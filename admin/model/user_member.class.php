	<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2017 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class user_member_controller extends common{
	function set_search(){

		include(CONFIG_PATH."db.data.php");
		$source=$arr_data['source'];
		$search_list[]=array('param'=>'source','name'=>'数据来源','value'=>$source);
		$search_list[]=array('param'=>'lotime','name'=>'最近登录','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$search_list[]=array('param'=>'adtime','name'=>'最近注册','value'=>array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月'));
		$this->yunset('source',$source);
		$this->yunset('search_list',$search_list);
	}
	function index_action(){
		$this->set_search();
        $where="`usertype`='1'";
		if(trim($_GET['keyword'])){
			if($_GET['type']=="1"){
				$where .=" and `username` LIKE '%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=="2"){
				$resume = $this->obj->DB_select_all("resume","`name` LIKE '%".trim($_GET['keyword'])."%'","`uid`,`name`");
				foreach($resume as $key=>$value){
					$uids[] = $value['uid'];
				}
				$where .=" and `uid` IN (".@implode(',',$uids).")";

			}elseif($_GET['type']=="3"){
				$where .=" and `email` LIKE '%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=="4"){
				$where .=" and `moblie` LIKE '%".trim($_GET['keyword'])."%'";
			}else{
				$where .="and `uid` LIKE '%" .trim($_GET['keyword'])."%'";
			}
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['type']=$_GET['type'];
		}
		if($_GET['adtime']){
			if($_GET['adtime']=='1'){
				$where .=" and `reg_date`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `reg_date`>'".strtotime('-'.intval($_GET['adtime']).' day')."'";
			}
			$urlarr['adtime']=$_GET['adtime'];
		}
		if($_GET['lotime']){
			if($_GET['lotime']=='1'){
				$where .=" and `login_date`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `login_date`>'".strtotime('-'.intval($_GET['lotime']).' day')."'";
			}
			$urlarr['lotime']=$_GET['lotime'];
		}
		if($_GET['source']){
			$where .=" and `source` = '".$_GET['source']."'";
			$urlarr['source']=$_GET['source'];
		}
		if($_GET['r_uid']){
			$where.=" and `uid`='".$_GET['r_uid']."'";
			$urlarr['r_uid']=$_GET['r_uid'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by uid desc";
		}
        $urlarr['page']='{{page}}';
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$userrows=$this->get_page("member",$where,$pageurl,$this->config['sy_listnum'],'*');
		if(is_array($userrows)){
			if(empty($resume)){

				foreach($userrows as $key=>$value){
					$uids[] = $value['uid'];
				}
				$resume = $this->obj->DB_select_all("resume","`uid` IN (".@implode(',',$uids).")","`uid`,`name`");
			}

			foreach($userrows as $key=>$value){
				foreach($resume as $k=>$v){
					if($value['uid'] == $v['uid']){
						$userrows[$key]['name'] = $v['name'];
					}
				}
				if($value['did']<1){
					$userrows[$key]['did'] = 0;
				}
			}
		}

		$this->yunset("userrows",$userrows);
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=`id` and a.`uid`='".$_SESSION['auid']."'");
		$power=unserialize($nav_user[0]['group_power']);
		if(in_array('141',$power)){
			$this->yunset('email_promiss', '1');
			$this->yunset('moblie_promiss', '1');
		} 
		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);
		$this->yuntpl(array('admin/admin_member_userlist'));
	}
	function lockinfo_action(){
		$userinfo = $this->obj->DB_select_once("member","`uid`=".$_GET['uid'],"`lock_info`");
		echo trim($userinfo['lock_info']);die;
	}
	function status_action(){
		extract($_POST);
		$lock_info = trim($lock_info);
 		$id=$this->obj->DB_update_all("member","`status`='".$_POST['status']."',`lock_info`='".$lock_info."'","`uid`='".$uid."'");
 		$this->obj->DB_update_all("resume","`r_status`='".$_POST['status']."'","`uid`='".$uid."' ");
		$this->obj->DB_update_all("resume_expect","`r_status`='".$_POST['status']."'","`uid`='".$uid."' ");

 		if($this->config['sy_email_lock']=='1' && $_POST['status']==2){
			$userinfo = $this->obj->DB_select_once("member","`uid`=".$uid,"`email`,`uid`,`username`,`usertype`");
			$data=$this->forsend($userinfo);

			$this->send_msg_email(array("email"=>$userinfo['email'],'uid'=>$data['uid'],'name'=>$data['name'],"certinfo"=>$statusbody,"username"=>$userinfo['username'],"type"=>"lock"));
		}

 		$id?$this->ACT_layer_msg("个人会员锁定(ID:".$uid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}

	function edit_action(){
	    $_POST=$this->post_trim($_POST);
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		if((int)$_GET['id']){
			$com_info = $this->obj->DB_select_once("member","`uid`='".$_GET['id']."'");
			$this->yunset("com_info",$com_info);
			$row=$this->obj->DB_select_once("resume","`uid`='".$_GET['id']."'");
			$this->yunset("row",$row);
			$this->yunset($this->MODEL('cache')->GetCache(array('user','city')));
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
		}
		if($_POST['com_update']){
			$mem = $this->obj->DB_select_once("member","`uid`='".$_POST['uid']."'");
			if($mem['username']!=$_POST['username'] && $_POST['username']!=""){
				$num = $this->obj->DB_select_num("member","`username`='".$_POST['username']."'");
				if($num>0){
					$this->ACT_layer_msg("用户名已存在！",8,$_SERVER['HTTP_REFERER'],2,1);
				}else{
					$this->obj->DB_update_all("member","`username`='".$_POST['username']."'","`uid`='".$_POST['uid']."'");
				}
			}
		    $moblienum=$this->obj->DB_select_num("member","moblie='".$_POST['moblie']."' and `uid`<>'".$_POST['uid']."'");
		    $emailnum=$this->obj->DB_select_num("member","email='".$_POST['email']."' and `uid`<>'".$_POST['uid']."'");
		    $idcardnum=$this->obj->DB_select_num("resume","idcard='".$_POST['idcard']."' and `uid`<>'".$_POST['uid']."'");
		    $telhomenum=$this->obj->DB_select_num("resume","telhome='".$_POST['telhome']."' and `uid`<>'".$_POST['uid']."'");
			if($_POST['moblie']&&!$this->CheckMoblie($_POST['moblie'])){
				$this->ACT_layer_msg("手机格式错误！",8);
			}elseif($_POST['moblie']&&$moblienum){
				$this->ACT_layer_msg("手机已存在！",8);
			}
			if($_POST['email']&&!$this->CheckRegEmail($_POST['email'])){
				$this->ACT_layer_msg("邮箱格式错误！",8);
			}elseif($_POST['email']&&$emailnum){
				$this->ACT_layer_msg("邮箱已存在！",8);
			}
			if($_POST['idcard']&&!$this->CheckIdCard($_POST['idcard'])){
				$this->ACT_layer_msg("证件号码格式错误！",8);
			}elseif($_POST['idcard']&&$idcardnum){
				$this->ACT_layer_msg("证件号码已存在！",8);
			}
			if($_POST['telhome']&&!$this->CheckTell($_POST['telhome'])){
				$this->ACT_layer_msg("座机格式错误！",8);
			}elseif($_POST['telhome']&&$telhomenum){
				$this->ACT_layer_msg("座机已存在！",8);
			}
			$lasturl=str_replace("&amp;","&",$_POST['lasturl']);
			$post['uid']=$_POST['uid'];
			$post['password']=$_POST['password'];
			$post['email']=$_POST['email'];
			$post['moblie']=$_POST['moblie'];
			$post['status']=$_POST['status'];
			$post['address']=$_POST['address'];
			if(trim($_POST['password'])){
				$nid = $this->uc_edit_pw($post,1,'index.php?m=user_member');
			}
			if($_FILES['wxewm']['tmp_name']){
				$upload=$this->upload_pic("../data/upload/user/",false);
				$wxewm=$upload->picture($_FILES['wxewm']);
				$this->picmsg($wxewm,$_SERVER['HTTP_REFERER']);
				$wxewm = str_replace("../data/","./data/",$wxewm);
				$userwx=$this->obj->DB_select_once("resume","`uid`='".$_POST['uid']."'","wxewm");
				if($userwx['wxewm']){
					unlink_pic(".".$userwx['wxewm']);
				}
			}			
			$value="`name`='".$_POST['name']."',";
			$value.="`sex`='".$_POST['sex']."',";
			$value.="`living`='".$_POST['living']."',";
			$value.="`domicile`='".$_POST['domicile']."',";
			$value.="`r_status`='".$_POST['status']."',";
			$value.="`birthday`='".$_POST['birthday']."',";
			$value.="`marriage`='".$_POST['marriage']."',";
			$value.="`height`='".$_POST['height']."',";
			$value.="`nationality`='".$_POST['nationality']."',";
			$value.="`weight`='".$_POST['weight']."',";
			$value.="`idcard`='".$_POST['idcard']."',";
			$value.="`exp`='".$_POST['exp']."',";
			$value.="`email`='".$_POST['email']."',";
			$value.="`telphone`='".$_POST['moblie']."',";
			$value.="`telhome`='".$_POST['telhome']."',";
			$value.="`edu`='".$_POST['edu']."',";
			$value.="`address`='".$_POST['address']."',";
			$value.="`homepage`='".$_POST['homepage']."',";
			$value.="`qq`='".$_POST['qq']."',";
			$value.="`wxewm`='".$wxewm."',";
			$value.="`description`='".$_POST['description']."'";
			$this->obj->DB_update_all("resume",$value,"`uid`='".$_POST['uid']."'");
			$this->obj->update_once("resume_expect",array("edu"=>$_POST['edu'],"exp"=>$_POST['exp'],"uname"=>$_POST['name'],"sex"=>$_POST['sex'],"birthday"=>$_POST['birthday']),array('uid'=>$_POST['uid']));
			$this->obj->update_once('member',array("email"=>$_POST['email'],'status'=>$_POST['status'],"moblie"=>$_POST['moblie']),array('uid'=>$_POST['uid']));
			$statis = $this->obj->DB_select_once("member_statis","`uid`='".$_POST['uid']."'");
			if($statis['uid']){
				$this->obj->DB_insert_once("member_statis","`uid`='".$_POST['uid']."'");
			}
			delfiledir("../data/upload/tel/".$_POST['uid']);
			$this->ACT_layer_msg( "个人会员(ID:".$_POST['uid'].")修改成功",9,$lasturl,2,1);

		}
		$this->yuntpl(array('admin/admin_member_useredit'));
	}

	function add_action(){
		$this->yuntpl(array('admin/admin_member_useradd'));
	}
	function save_action(){
		if($_POST['submit']){
			extract($_POST);
			$moblienum=$this->obj->DB_select_num("member","mobli`='".$moblie."'");
			if ($email!=""){
				$emailnum=$this->obj->DB_select_num("member","email='".$email."'");
			}
			if($username==""||strlen($username)<2||strlen($username)>15){
				$this->ACT_layer_msg("会员名不能为空！",8);
			}elseif(!$this->CheckRegUser($username)){
				$this->ACT_layer_msg("会员名包含特殊字符！",8);
			}elseif($password==""||strlen($password)<6||strlen($password)>20){
				$this->ACT_layer_msg("密码不能为空！",8);
			}elseif($email!=""&&!$this->CheckRegEmail($email)){
				$this->ACT_layer_msg("邮箱格式错误！",8);
			}elseif($emailnum){
				$this->ACT_layer_msg("邮箱已存在！",8);
			}elseif($moblie==""){
				$this->ACT_layer_msg("手机不能为空！",8);
			}elseif(!$this->CheckMoblie($moblie)){
				$this->ACT_layer_msg("手机格式错误！",8);
			}elseif($moblienum){
				$this->ACT_layer_msg("手机已存在！",8);
			}else{
				if($this->config['sy_uc_type']=="uc_center"){
					$this->uc_open();
					$user = uc_get_user($username);
				}else{
					$user = $this->obj->DB_select_once("member","`username`='$username'");
				}

				if(is_array($user)){
					$this->ACT_layer_msg("该会员已经存在！",8);

				}else{
					$time = time();
					$ip = fun_ip_get();
					if($this->config['sy_uc_type']=="uc_center"){
						$uid=uc_user_register($_POST['username'],$_POST['password'],$_POST['email']);
						if($uid<0){
							$this->ACT_layer_msg("已存在该邮箱！",8);
						}else{
							list($uid,$username,$email,$password,$salt)=uc_get_user($username);
							$value = "`username`='$username',`password`='$password',`email`='$email',`usertype`='1',`salt`='$salt',`moblie`='$moblie',`reg_date`='$time',`reg_ip`='$ip'";
						}
					}else{
						$salt = substr(uniqid(rand()), -6);
						$pass = md5(md5($password).$salt);
						$value = "`username`='$username',`password`='$pass',`email`='$email',`usertype`='1',`status`='$satus',`salt`='$salt',`moblie`='$moblie',`reg_date`='$time',`reg_ip`='$ip'";
					}
					$nid = $this->obj->DB_insert_once("member",$value);
					if($nid>0){
						$this->obj->DB_insert_once("resume","`uid`='$nid',`email`='$email',`telphone`='$moblie'");
						$this->obj->DB_insert_once("member_statis","`uid`='$nid'");
						$this->ACT_layer_msg("个人会员(ID:".$nid.")添加成功！",9,"index.php?m=user_member");
					}
				}
			}
		}
	}
	function del_action(){
		$this->check_token();
	    if($_GET['del'] && !$_GET['send_email'] && !$_GET['send_msg']){
	    	$del=$_GET['del'];
	    	if($del){
				$del_array=array("member","resume","member_statis","look_resume","look_job","resume_show","userid_msg","resume_expect","resume_cert","resume_edu","resume_other","resume_project","resume_skill","resume_training","resume_work","resume_doc","user_resume","down_resume","userid_job","question","msg","attention","rebates","company_msg","fav_job","answer","answer_review","evaluate_log","subscribe","subscriberecord","talent_pool","user_entrust","user_entrust_record","friend_state"); 
	    		if(is_array($del)){
	    			foreach($del as $k=>$v){

	    				delfiledir("../data/data/upload/tel/".intval($v));
	    			}
		    		$uids = @implode(",",$del);
		    		$resume=$this->obj->DB_select_all("resume","`uid` in ($uids) and `photo`<>''","`photo`,`resume_photo`");
		    		if(is_array($resume)){
		    	    	foreach($resume as $val){
		    	    		unlink_pic(".".$val['photo']);
		    	    		unlink_pic(".".$val['resume_photo']);
		    	    	}
		    	    }
		    		
		    		$show=$this->obj->DB_select_all("resume_show","`uid` in ($uids) and `picurl`<>''","`picurl`");
		    		if(is_array($show)){
		    	    	foreach($show as $val){
		    	    		unlink_pic(".".$val['picurl']);
		    	    	}
		    	    }

					foreach($del_array as $value){
						$this->obj->DB_delete_all($value,"`uid` in ($uids)","");
					}
					$this->obj->DB_delete_all("email_msg","`uid` in (".$uids.") or `cuid` in (".$uids.")"," ");
					$this->obj->DB_delete_all("atn","`uid` in ($uids) or `sc_uid` in ($uids)","");
		    	    $this->obj->DB_delete_all("message","`uid` in ($uids)","");
		    	    $this->obj->DB_delete_all("blacklist","`p_uid` in ($uids)","");
		    	    $this->obj->DB_delete_all("friend","`uid` in ($uids) or `nid` in ($uids)","");
		    	    $this->obj->DB_delete_all("report","`p_uid` in ($uids) or `c_uid` in ($uids)","");
					$this->obj->DB_delete_all("part_apply","`uid` in (".$uids.")","");
					$this->obj->DB_delete_all("member_log","`uid` in (".$uids.")","");
					$this->obj->DB_delete_all("part_collect","`uid` in (".$uids.")","");
					$layer_type=1;

		    	}else{
					$del = intval($del);
					$uids = intval($del);
		    		delfiledir("../data/upload/tel/".$del);
		    		$resume=$this->obj->DB_select_once("resume","`uid`='".$del."' and `photo`<>''");
		    		if(is_array($resume)){
		    			unlink_pic('.'.$resume['photo']);
		    			unlink_pic(".".$resume['resume_photo']);
		    		}

		    		
		    		$show=$this->obj->DB_select_all("resume_show","`uid`='".$del."' and `picurl`<>''","`picurl`");
		    		unlink_pic(".".$show['picurl']);

					foreach($del_array as $value){
						$this->obj->DB_delete_all($value,"`uid`='".$del."'","");
					}
					$this->obj->DB_delete_all("email_msg","`uid`='".$del."' or `cuid`='".$del."'"," ");
					$this->obj->DB_delete_all("atn","`uid`='$del' or `sc_uid`='$del'","");
		    	    $this->obj->DB_delete_all("message","`uid`='".$del."'","");
		    	    $this->obj->DB_delete_all("blacklist","`p_uid`='$del'","");
		    	    $this->obj->DB_delete_all("report","`p_uid`='$del' or `c_uid`='$del'");
					$this->obj->DB_delete_all("part_apply","`uid` in (".$uids.")","");
					$this->obj->DB_delete_all("part_collect","`uid` in (".$uids.")","");
					$this->obj->DB_delete_all("member_log","`uid` in (".$uids.")","");
		    	    $layer_type=0;
		    	}
		    	$this->layer_msg( "个人会员(ID:".$uids.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的会员！',8,0,$_SERVER['HTTP_REFERER']);

	    	}
	    }

	}

	function reset_pw_action(){
		$this->check_token();
		$data['password']="123456";
		$data['uid']=$_GET['uid'];
		$this->uc_edit_pw($data,1,"index.php?m=user_member");
		$this->admin_log("会员(ID:".$_GET['uid'].")重置密码成功");
		echo "1";
	}

	function Imitate_action(){
		extract($_GET);
		$user_info = $this->obj->DB_select_once("member","`uid`='".$uid."'");
		$this->unset_cookie();
		$this->add_cookie($user_info['uid'],$user_info['username'],$user_info['salt'],$user_info['email'],$user_info['password'],$user_info['usertype'],1,$user_info['did']);

		header('Location: '.$this->config['sy_weburl'].'/member');
	}

	function checksitedid_action(){
		if($_POST['uid']){
			$uids=@explode(',',$_POST['uid']);
			$uid = pylode(',',$uids);
			if($uid){
				$siteDomain = $this->MODEL('site');
				$Table = array('member','resume','member_statis','userid_job','company_cert','company_order','resume_expect','user_entrust','company_msg','look_job');
				$siteDomain->UpDid(array("report"),$_POST['did'],"`p_uid` IN (".$uid.")");
				$siteDomain->UpDid(array("company_pay"),$_POST['did'],"`com_id` IN (".$uid.")");
				$siteDomain->UpDid($Table,$_POST['did'],"`uid` IN (".$uid.")");
				$this->ACT_layer_msg( "会员(ID:".$_POST['uid'].")分配站点成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("请正确选择需分配用户！",8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg( "参数不全请重试！",8,$_SERVER['HTTP_REFERER']);
		}
	}
}

?>