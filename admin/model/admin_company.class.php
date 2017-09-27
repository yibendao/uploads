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
class admin_company_controller extends common{
	function set_search(){ 
		$rating=$this->obj->DB_select_all("company_rating","`category`='1' order by `sort` asc","`id`,`name`");
		if(!empty($rating)){
			foreach($rating as $k=>$v){
                 $ratingarr[$v['id']]=$v['name'];
			}
		}
		include(CONFIG_PATH."db.data.php");
		$source=$arr_data['source'];
		$adtime=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$lotime=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$status=array('1'=>'已审核','2'=>'已锁定','3'=>'未通过','4'=>'未审核');
		$edtime=array('1'=>'7天内','2'=>'一个月内','3'=>'半年内','4'=>'一年内');
		$search_list[]=array("param"=>"rating","name"=>'会员等级',"value"=>$ratingarr);
		$search_list[]=array("param"=>"time","name"=>'到期时间',"value"=>$edtime);
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>$status);			
		$search_list[]=array('param'=>'source','name'=>'数据来源','value'=>$source);
		$search_list[]=array("param"=>"rec","name"=>'知名企业',"value"=>array("1"=>"是","2"=>"否"));
		$search_list[]=array("param"=>"gw","name"=>'企业顾问',"value"=>array("1"=>"已分配","2"=>"未分配"));
		$search_list[]=array("param"=>"lotime","name"=>'最近登录',"value"=>$lotime);
		$search_list[]=array("param"=>"adtime","name"=>'最近注册',"value"=>$adtime);
		$this->yunset("source",$source);
		$this->yunset("ratingarr",$ratingarr);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where=$swhere=$mwhere="1";
		$uids=array();
		if($_GET['status']){
			if($_GET['status']=='4'){
				$mwhere.=" and `status`='0'";
			}else if($_GET['status']){
				$mwhere.=" and `status`='".intval($_GET['status'])."'";
			}
			$urlarr['status']=intval($_GET['status']);
		}
		if($_GET['rating']){
			$swhere="`rating`='".$_GET['rating']."'";
			$urlarr['rating']=$_GET['rating'];
		}
		if($_GET['time']){
            if($_GET['time']=='1'){
            	$num="+7 day"; 
            }elseif($_GET['time']=='2'){
				$num="+1 month"; 
            }elseif($_GET['time']=='3'){
				$num="+6 month"; 
            }elseif($_GET['time']=='4'){
                $num="+1 year"; 
            }
			if($swhere){
				$swhere.=" and `vip_etime`>'".time()."' and `vip_etime`<'".strtotime($num)."'";
			}else{
				$swhere=" `vip_etime`>'".time()."' and `vip_etime`<'".strtotime($num)."'";
			}
			$urlarr['time']=$_GET['time'];
		}

		if($swhere){
			$list=$this->obj->DB_select_all("company_statis",$swhere,"`uid`,`pay`,`rating`,`rating_name`,`vip_etime`");
			foreach($list as $val){
				$uids[]=$val['uid'];
			}
			$where.=" and `uid` in (".@implode(',',$uids).")";
		}				
		if($_GET['rec']){
       	   if($_GET['rec']=='1'){
 				$where.= "  and `rec`=1 ";
       	   }else{
 				$where.= "  and `rec`=0 ";
       	   }
			$urlarr['rec']=$_GET['rec'];
       }
		if($_GET['gw']){
       	   if($_GET['gw']=='1'){
 				$where.= "  and `conid`!=0 ";
       	   }else{
 				$where.= "  and `conid`=0 ";
       	   }
			$urlarr['gw']=$_GET['gw'];
       }

	   if($_GET['hy']){
			$where .= " and `hy` = '".$_GET['hy']."' ";
			$urlarr['hy']=$_GET['hy'];
		}
	   if($_GET['provinceid']){
			$where .= " and `provinceid` = '".$_GET['provinceid']."' ";
			$urlarr['provinceid']=$_GET['provinceid'];
		}
		if($_GET['cityid']){
			$where .= " and `cityid` = '".$_GET['cityid']."' ";
			$urlarr['cityid']=$_GET['cityid'];
		}
		 if($_GET['pr']){
			$where .= " and `pr` = '".$_GET['pr']."' ";
			$urlarr['pr']=$_GET['pr'];
		}
		 if($_GET['mun']){
			$where .= " and `mun` = '".$_GET['mun']."' ";
			$urlarr['mun']=$_GET['mun'];
		}
	    if(trim($_GET['keywords'])){
			$where .= " and `name` like '%".trim($_GET['keywords'])."%' ";
			$urlarr['keywords']=$_GET['keywords'];
		}
	   if(trim($_GET['keyword'])){
            if($_GET['type']=='1'){
				$where.= "  AND `name` like '%".trim($_GET['keyword'])."%' ";
            }elseif($_GET['type']=='2'){
				$mwhere.=" and `username` like '%".trim($_GET['keyword'])."%'";
            }elseif($_GET['type']=='3'){
				$where.= "  AND `linkman` like '%".trim($_GET['keyword'])."%' ";
            }elseif($_GET['type']=='4'){
				$where.= "  AND `linktel` like '%".trim($_GET['keyword'])."%' ";
            }elseif($_GET['type']=='5'){
				$where.= "  AND `linkmail` like '%".trim($_GET['keyword'])."%' ";
            }elseif($_GET['type']=='6'){
				$where.=" AND `uid` like '%" .trim($_GET['keyword']). "%' ";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['adtime']){
			if($_GET['adtime']=='1'){
				$mwhere .=" and `reg_date`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$mwhere .=" and `reg_date`>'".strtotime('-'.intval($_GET['adtime']).' day')."'";
			}
			$urlarr['adtime']=$_GET['adtime'];
		}
		if($_GET['lotime']){
			if($_GET['lotime']=='1'){
				$mwhere .=" and `login_date`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$mwhere .=" and `login_date`>'".strtotime('-'.intval($_GET['lotime']).' day')."'";
			}
			$urlarr['lotime']=$_GET['lotime'];
		}
		if($_GET['source']){
			$mwhere .=" and `source` = '".$_GET['source']."'";
			$urlarr['source']=$_GET['source'];
		}
		if($mwhere!='1'){
			$username=$this->obj->DB_select_all("member",$mwhere." and `usertype`='2'","`username`,`uid`,`reg_date`,`login_date`,`status`,`source`");
			$uids=array();
			foreach($username as $val){
				$uids[]=$val['uid'];
			}
			$where.=" and `uid` in (".@implode(',',$uids).")";
		}
		if($_GET['order']){
			if($_GET['t']=="time"){
				$where.=" order by `lastupdate` ".$_GET['order'];
			}else{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
			}
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by uid desc";
		}
		$ids=array();
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows=$this->get_page("company",$where,$pageurl,$this->config['sy_listnum']);
		$this->yunset($company);
 		if(is_array($rows)&&$rows){
			if($mwhere=='1'&&empty($username)){
				foreach($rows as $v){$uids[]=$v['uid'];}
				$username=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uids).")","`username`,`uid`,`reg_date`,`login_date`,`reg_ip`,`status`,`source`,`login_ip`");
			}
			if(empty($list)){
				$list=$this->obj->DB_select_all("company_statis","`uid` in (".@implode(",",$uids).")","`uid`,`pay`,`integral`,`rating`,`rating_name`,`vip_etime`,`msg_num`");
			}
			$con = $this->obj->DB_select_all("company_consultant");
 			foreach($rows as $k=>$v){
 				if(strlen($v['name'])>24){
					$rows[$k]['name']=mb_substr($v['name'],"0","12","gbk")."...";
 				}
				if($v['did']<1){
					$rows[$k]['did'] = 0;
				}
				foreach($username as $val){
					if($v['uid']==$val['uid']){
						$rows[$k]['username']=$val['username'];
						$rows[$k]['reg_date']=$val['reg_date'];
						$rows[$k]['reg_ip']=$val['reg_ip'];
						$rows[$k]['login_date']=$val['login_date'];
						$rows[$k]['status']=$val['status'];
						$rows[$k]['source']=$val['source'];
						$rows[$k]['login_ip']=$val['login_ip'];
					}
				}
				foreach($list as $val){
					if($v['uid']==$val['uid']){
						$rows[$k]['rating']=$val['rating'];
						$rows[$k]['pay']=$val['pay'];
						$rows[$k]['rating_name']=$val['rating_name'];
						$rows[$k]['vip_etime']=$val['vip_etime'];
						$rows[$k]['integral']=$val['integral'];
						$rows[$k]['vip_done']=$this->config['com_vip_done'];
					}
				}
 				foreach($con as $val){
					if($v['conid']==$val['id']){
						$rows[$k]['con']=$val['username'];
					}
				}
			}
		}
		$guweninfo=$this->obj->DB_select_all("company_consultant","`id`>'0'");
		$this->yunset("guweninfo",$guweninfo);
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION["auid"]."'");
		$power=unserialize($nav_user[0]["group_power"]);
		if(in_array('141',$power)){
			$this->yunset("email_promiss", '1');
			$this->yunset("moblie_promiss", '1');
		} 

		$where=str_replace(array("(",")"),array("[","]"),$where);
		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);
		$this->yunset("where", $where);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_company'));
	}

	function edit_action(){
		if((int)$_GET['id']){
			$com_info = $this->obj->DB_select_once("member","`uid`='".$_GET['id']."'");
			$row = $this->obj->DB_select_once("company","`uid`='".$_GET['id']."'");
			$statis = $this->obj->DB_select_once("company_statis","`uid`='".$_GET['id']."'");
			$rating_list = $this->obj->DB_select_all("company_rating","`category`=1");
			if($row['linkphone']){
				$linkphone=@explode('-',$row['linkphone']);
				$row['phoneone']=$linkphone[0];
				$row['phonetwo']=$linkphone[1];
				$row['phonethree']=$linkphone[2]; 
			}
			if ($row['comqcode']&& file_exists(str_replace('..',APP_PATH,'.'.$row['comqcode']))){
			    $row['comqcode']=str_replace('./', $this->config['sy_weburl'].'/', $row['comqcode']);
			}else{
				$row['comqcode']='';
			}
			$this->yunset("statis",$statis);
			$this->yunset("row",$row);
			$this->yunset("rating_list",$rating_list);
			$this->yunset("rating",$_GET['rating']);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
			$this->yunset("com_info",$com_info);
			$this->yunset($this->MODEL('cache')->GetCache(array('city','hy','com')));

		}
		if($_POST['com_update']){
			$mem = $this->obj->DB_select_once("member","`uid`='".$_POST['uid']."'");
			if($mem['username']!=$_POST['username'] && $_POST['username']!=""){
				$num = $this->obj->DB_select_num("member","`username`='".$_POST['username']."'");
				if($num>0){
					$this->ACT_layer_msg("用户名已存在！",8);
				}else{
					$this->obj->DB_update_all("member","`username`='".$_POST['username']."'","`uid`='".$_POST['uid']."'");
				}
			}
			$email=$_POST['email'];
			$uid=$_POST['uid'];
			$user = $this->obj->DB_select_once("member","`email`='$email' AND  `email`<>'' and `uid`<>'$uid'",'uid');
			$moblienum = $this->obj->DB_select_once("member","`moblie`='".$_POST['moblie']."' AND  `moblie`<>'' and `uid`<>'".$uid."'",'uid');
			$company=$this->obj->DB_select_once("company","`uid`='".$_POST['uid']."'","name,comqcode");
			if(is_array($user)){
				$this->ACT_layer_msg( "邮箱已存在！",8);
			}elseif(is_array($moblienum)){
				$this->ACT_layer_msg( "手机号已存在！",8);
			}else{
				$value="`r_status`='".$_POST['status']."',";
				if($_POST['status']=='2'){
					$smtp = $this->email_set();
					if($mem['status']!='2'){
						$data=$this->forsend($mem);
						$this->send_msg_email(array("email"=>$mem['email'],"lock_info"=>$_POST['lock_info'],"uid"=>$data['uid'],"name"=>$data['name'],"type"=>"lock"));
					}
				}
				$this->obj->DB_update_all("member","`lock_info`='".$_POST['lock_info']."',`status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
				unset($_POST['com_update']);
				$ratingid = (int)$_POST['ratingid'];
				unset($_POST['ratingid']);
				$post['uid']=$_POST['uid'];
				$post['password']=$_POST['password'];
				$post['email']=$_POST['email'];
				$post['moblie']=$_POST['moblie'];
				$post['status']=$_POST['status'];
				$post['address']=$_POST['address'];
				if(trim($post['password'])){
					$nid = $this->uc_edit_pw($post,1,"index.php?m=com_member");
				} 
				$linkphone=array();
				if($_POST['phoneone']){
					$linkphone[]=$_POST['phoneone'];
				}
				if($_POST['phonetwo']){
					$linkphone[]=$_POST['phonetwo'];
				} 
				if($_POST['phonethree']){
					$linkphone[]=$_POST['phonethree'];
				} 
				$_POST['linkphone']=pylode('-',$linkphone);
				if($_FILES['comqcode']['tmp_name']){
					$upload=$this->upload_pic("../data/upload/company/",false);
					$comqcode=$upload->picture($_FILES['comqcode']);
					$this->picmsg($comqcode,$_SERVER['HTTP_REFERER']);
					$comqcode = str_replace("../data/","./data/",$comqcode);
					if($company['comqcode']){
						unlink_pic(".".$company['comqcode']);
					}
				}
				$value.="`address`='".$_POST['address']."',";
				$value.="`name`='".$_POST['name']."',";
				$value.="`hy`='".$_POST['hy']."',";
				$value.="`pr`='".$_POST['pr']."',";
				$value.="`provinceid`='".$_POST['provinceid']."',";
				$value.="`cityid`='".$_POST['cityid']."',";
				$value.="`three_cityid`='".$_POST['three_cityid']."',";
				$value.="`mun`='".$_POST['mun']."',";
				$value.="`linkphone`='".$_POST['linkphone']."',";
				$value.="`linktel`='".$_POST['moblie']."',";
				$value.="`money`='".$_POST['money']."',";
				$value.="`moneytype`='".intval($_POST['moneytype'])."',";
				$value.="`zip`='".$_POST['zip']."',";
				$value.="`linkman`='".$_POST['linkman']."',";
				$value.="`linkjob`='".$_POST['linkjob']."',";
				$value.="`linkqq`='".$_POST['linkqq']."',";
				$value.="`website`='".$_POST['website']."',";
				$content=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',''),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
				$value.="`content`='".$content."',";
				$value.="`busstops`='".$_POST['busstops']."',";
				$value.="`admin_remark`='".$_POST['admin_remark']."',";
				$value.="`linkmail`='".$_POST['email']."',";
				$value.="`infostatus`='".intval($_POST['infostatus'])."',";
				$value.="`comqcode`='".$comqcode."'";

				$this->obj->DB_update_all("company",$value,"`uid`='".$_POST['uid']."'");
				$this->obj->DB_update_all("member","`email`='".$_POST['email']."',`moblie`='".$_POST['moblie']."'","`uid`='".$_POST['uid']."'");
				$rat_arr = @explode("+",$rating_name);
				$statis = $this->obj->DB_select_once("company_statis","`uid`='".$_POST['uid']."'");
				if($ratingid != $statis['rating']){
					$newrating=$this->obj->DB_select_once("company_rating","`id`='".$ratingid."'","`name`");
					$ratingM = $this->MODEL('rating');
					$rat_value=$ratingM->rating_info($ratingid);

					$this->obj->DB_update_all("company_statis",$rat_value,"`uid`='".$_POST['uid']."'"); 
					$this->admin_log("企业会员(ID".$_POST['uid'].")更新为【".$newrating['name']."】"); 
				}else{
					if($_POST['vip_etime']){
						$value3.="`vip_etime`='".strtotime($_POST['vip_etime'])."',";
					}else{
						$value3.="`vip_etime`='0',";
					}
					$value3.="`job_num`='".$_POST['job_num']."',";
					$value3.="`down_resume`='".$_POST['down_resume']."',";
					$value3.="`editjob_num`='".$_POST['editjob_num']."',";
					$value3.="`invite_resume`='".$_POST['invite_resume']."',";
					$value3.="`breakjob_num`='".$_POST['breakjob_num']."',";
					$value3.="`part_num`='".$_POST['part_num']."',";
					$value3.="`editpart_num`='".$_POST['editpart_num']."',";
					$value3.="`breakpart_num`='".$_POST['breakpart_num']."'";
					$this->obj->DB_update_all("company_statis",$value3,"`uid`='".$_POST['uid']."'");
				}
				$value2.="`com_name`='".$_POST['name']."',";
				$value2.="`pr`='".$_POST['pr']."',";
				$value2.="`mun`='".$_POST['mun']."',";
				$value2.="`com_provinceid`='".$_POST['provinceid']."',";
				$value2.="`rating`='".$rat_arr[0]."',";
				if($_POST['status']=='1'){
					$rstatus='1';
				}else{
					$rstatus='2';
				}
				$value2.="`r_status`='".$rstatus."'";
				$this->obj->DB_update_all("company_job",$value2,"`uid`='".$_POST['uid']."'");
				$this->obj->DB_update_all("partjob","`r_status`='".$rstatus."'","`uid`='".$_POST['uid']."'");
				
				if($_POST['name']!=$company['name']){
					$this->obj->update_once("partjob",array("com_name"=>$_POST['name']),array("uid"=>$_POST['uid']));
					$this->obj->update_once("userid_job",array("com_name"=>$_POST['name']),array("com_id"=>$_POST['uid']));
					$this->obj->update_once("fav_job",array("com_name"=>$_POST['name']),array("com_id"=>$_POST['uid']));
					$this->obj->update_once("report",array("r_name"=>$_POST['name']),array("c_uid"=>$_POST['uid']));
					$this->obj->update_once("blacklist",array("com_name"=>$_POST['name']),array("c_uid"=>$_POST['uid']));
					$this->obj->update_once("msg",array("com_name"=>$_POST['name']),array("job_uid"=>$_POST['uid']));
					$this->obj->update_once("hotjob",array("username"=>$_POST['name']),array("uid"=>$_POST['uid']));
				}
				delfiledir("../data/upload/tel/".$_POST['uid']);
				$lasturl=str_replace("&amp;","&",$_POST['lasturl']);
				$this->ACT_layer_msg( "企业会员(ID:".$_POST['uid'].")修改成功！",9,$lasturl,2,1);
			}
		}
		$this->yuntpl(array('admin/admin_member_comedit'));
	}
	function rating_action(){
		$ratingid = (int)$_POST['ratingid'];
		$statis = $this->obj->DB_select_once("company_statis","`uid`='".$_POST['uid']."'");
		if($ratingid!=$statis['rating']){
			$ratingM = $this->MODEL('rating');
			if(is_array($statis) && !empty($statis)){
				$value=$ratingM->rating_info($ratingid);
				$this->obj->DB_update_all("company_statis",$value,"`uid`='".$_POST['uid']."'");
				$newrating=$this->obj->DB_select_once("company_rating","`id`='".$ratingid."'","`name`");
				$this->admin_log("企业会员(ID".$_POST['uid'].")更新为【".$newrating['name']."】"); 
			}else{
				$value="`uid`='".$_POST['uid']."',";
				$value.=$ratingM->rating_info($ratingid);
				$this->obj->DB_insert_once("company_statis",$value);
				$this->admin_log("企业会员(ID".$_POST['uid'].")添加会员等级");
			}
			echo "1";die;
		}else{
			echo 0;die;
		}
	}
	function add_action(){
		$rating_list = $this->obj->DB_select_all("company_rating","`category`=1");
		if($_POST['submit']){
			extract($_POST);
			if($username==""||strlen($username)<2||strlen($username)>15){
				$data['msg']= "会员名不能为空或不符合要求！";
				$data['type']='8';
			}elseif($password==""||strlen($username)<2||strlen($username)>15){
				$data['msg']= "密码不能为空或不符合要求！";
				$data['type']='8';
			}else{
				if($this->config['sy_uc_type']=="uc_center"){
					$this->uc_open();
					$user = uc_get_user($username);
				}else{
					if ($username!=""){
						$user = $this->obj->DB_select_once("member","`username`='$username'");
					}
					if ($email!=""){
						$comemail = $this->obj->DB_select_once("member","`email`='$email'");
					}
					if ($moblie!=""){
						$commoblie = $this->obj->DB_select_once("company","`linktel`='$moblie'");
					}
					if ($name!=""){
						$comname = $this->obj->DB_select_once("company","`name`='$name'");
					}
				}
				if(is_array($user)){
					$data['msg']= "用户名已存在！";
					$data['type']='8';
				}elseif(is_array($comemail)){
					$data['msg']= "邮箱已存在！";
					$data['type']='8';
				}elseif(is_array($commoblie)){
					$data['msg']= "联系手机已存在！";
					$data['type']='8';
				}elseif(is_array($comname)){
					$data['msg']= "公司全称已存在！";
					$data['type']='8';
				}else{
					$ip = fun_ip_get();
					$time = time();
					if($this->config['sy_uc_type']=="uc_center"){
						$uid=uc_user_register($_POST['username'],$_POST['password'],$_POST['email']);
						if($uid<0){
							$this->obj->get_admin_msg("index.php?m=com_member&c=add","该邮箱已存在！");
						}else{
							list($uid,$username,$email,$password,$salt)=uc_get_user($username);
							$value = "`username`='$username',`password`='$password',`email`='$email',`usertype`='2',`address`='$address',`status`='$status',`salt`='$salt',`moblie`='$moblie',`reg_date`='$time',`reg_ip`='$ip'";
						}
					}else{
						$salt = substr(uniqid(rand()), -6);
						$pass = md5(md5($password).$salt);
						$value = "`username`='$username',`password`='$pass',`email`='$email',`usertype`='2',`address`='$address',`status`='$status',`salt`='$salt',`moblie`='$moblie',`reg_date`='$time',`reg_ip`='$ip'";
					}
					$nid = $this->obj->DB_insert_once("member",$value);
					$uid = $nid;
					
					if($uid>0){
						$this->obj->DB_insert_once("company","`uid`='$uid',`name`='$name',`linkphone`='$areacode-$telphone-$exten',`linktel`='$moblie',`linkmail`='$email',`address`='$address'");
						$rat_arr = @explode("+",$rating_name);
						$value = "`uid`='$uid',";
						
						$ratingM = $this->MODEL('rating');
						$value.=$ratingM->rating_info($rat_arr[0]);

						$this->obj->DB_insert_once("company_statis",$value);
						$data['msg']="会员(ID:".$uid.")添加成功";
						$data['type']='9';
					}
				}
			}
			if($_POST['type']){
				echo "<script type='text/javascript'>window.location.href='index.php?m=admin_company_job&c=show&uid=".$nid."'</script>";die;
			}else{
				if($data['type']=='9'){
				$this->ACT_layer_msg($data['msg'],$data['type'],"index.php?m=admin_company",2,1);
				}else{
				$this->ACT_layer_msg($data['msg'],$data['type']);
				}
			}

		}
		$this->yunset("get_info",$_GET);
		$this->yunset("rating_list",$rating_list);
		$this->yuntpl(array('admin/admin_member_comadd'));
	}
	
	function getstatis_action(){
		if($_POST['uid']){
			$rating	= $this->obj->DB_select_once("company_statis","`uid`='".intval($_POST['uid'])."'");
			if($rating['vip_etime']>0){
				$rating['vipetime'] = date("Y-m-d",$rating['vip_etime']);
			}else{
				$rating['vipetime'] = '不限';
			}
			echo json_encode(yun_iconv('gbk','utf-8',$rating));
		}
	}
	function getrating_action(){
		if($_POST['id']){
			$rating	= $this->obj->DB_select_once("company_rating","`id`='".intval($_POST['id'])."' and `category`='1'");
			if($rating['service_time']>0){
				$rating['oldetime'] = time()+$rating['service_time']*86400;
				$rating['vipetime'] = date("Y-m-d",(time()+$rating['service_time']*86400));
			}else{
				$rating['oldetime'] = 0;
				$rating['vipetime'] = '不限';
			}
			echo json_encode(yun_iconv('gbk','utf-8',$rating));
		}
	}
	function uprating_action(){

		 if($_POST['ratuid']){

			$uid = intval($_POST['ratuid']);
			$statis = $this->obj->DB_select_once("company_statis","`uid`='".$uid."'");

			unset($_POST['ratuid']);unset($_POST['pytoken']);
			if((int)$_POST['addday']>0){
				if((int)$_POST['oldetime']>0){
					$_POST['vip_etime'] = intval($_POST['oldetime'])+intval($_POST['addday'])*86400;
				}else{
					$_POST['vip_etime'] = time()+intval($_POST['addday'])*86400;
				}
			}else{
				$_POST['vip_etime'] = intval($_POST['oldetime']);
			}
			unset($_POST['addday']);
			unset($_POST['oldetime']);

			foreach($_POST as $key=>$value){

				$statisValue[] = "`$key`='$value'";
			}
			$statisSqlValue = @implode(',',$statisValue);
			$ratinginfo = $this->obj->DB_select_once("company_rating","`id`='".$_POST['rating']."'","`type`");
			$statisSqlValue.=",`rating_type`='".$ratinginfo['type']."'";
			if($statis['rating'] != $_POST['rating']){
				$statisSqlValue.=",`vip_stime`='".time()."'";
				$this->obj->DB_update_all("company_job","`rating`='".$_POST['rating']."'","`uid`='".$uid."'");
			}
			if(!empty($statis)){
				$id = $this->obj->DB_update_all("company_statis",$statisSqlValue,"`uid`='".$uid."'");
			}else{
				$this->obj->DB_insert_once("company_statis",$statisSqlValue.",`uid`='".$uid."'");
				$id = true;
			}
			$id?$this->ACT_layer_msg("企业会员等级(ID:".$uid.")修改成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("修改失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}

	}
	function recommend_action(){
		$nid=$this->obj->DB_update_all("company","`".$_GET['type']."`='".$_GET['rec']."'","`uid`='".$_GET['id']."'");
		$this->admin_log("知名企业(ID:".$_GET['id'].")设置成功");
		echo $nid?1:0;die;
	}
	function del_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
				$del_array=array("member","company","company_job","company_cert","company_news","company_order","company_product","company_show","banner","company_statis","question","attention","hotjob","special_com","partjob","answer","answer_review","evaluate_log","subscribe","subscriberecord","friend_state");

	    		if(is_array($del)){
	    			$layer_type=1;
	    			$uids = @implode(",",$del);
	    			foreach($del as $k=>$v){
	    				delfiledir("../data/upload/tel/".intval($v));
	    			}
				    $company=$this->obj->DB_select_all("company","`uid` in (".$uids.") and `logo`!=''","logo,firmpic");
				    if(is_array($company)){
				    	foreach($company as $v){
				    		unlink_pic(".".$v['logo']);
				    		unlink_pic(".".$v['firmpic']);
				    	}
				    }
		    	    $cert=$this->obj->DB_select_all("company_cert","`uid` in (".$uids.") and `type`='3'","check");
		    	    if(is_array($cert)){
				    	foreach($cert as $v){
				    		unlink_pic("../".$v['check']);
				    	}
				    }
		    	    $product=$this->obj->DB_select_all("company_product","`uid` in (".$uids.")","pic");
		    	    if(is_array($product)){
		    	    	foreach($product as $val){
		    	    		unlink_pic("../".$val['pic']);
		    	    	}
		    	    }
		    	    $show=$this->obj->DB_select_all("company_show","`uid` in (".$uids.")","picurl");
		    	    if(is_array($show)){
		    	    	foreach($show as $val){
		    	    		unlink_pic("../".$val['picurl']);
		    	    	}
		    	    }
		    	    $uhotjob=$this->obj->DB_select_all("hotjob","`uid` in (".$uids.")","hot_pic");
		    	    if(is_array($uhotjob)){
		    	    	foreach($uhotjob as $val){
		    	    		unlink_pic("../".$val['hot_pic']);
		    	    	}
		    	    }
		    	  	$banner=$this->obj->DB_select_all("banner","`uid` in (".$uids.")","pic");
		    	    if(is_array($banner)){
		    	    	foreach($banner as $val)
		    	    	{
		    	    		unlink_pic($val['pic']);
		    	    	}
		    	    }
		    	    

					foreach($del_array as $value){
						$this->obj->DB_delete_all($value,"`uid` in (".$uids.")","");
					}
					$this->obj->DB_delete_all("email_msg","`uid` in (".$uids.") or `cuid` in (".$uids.")"," ");
					$this->obj->DB_delete_all("company_msg","`cuid` in (".$uids.")"," ");
					$this->obj->DB_delete_all("talent_pool","`cuid` in (".$uids.")"," ");
					$this->obj->DB_delete_all("user_entrust_record","`comid` in (".$uids.")"," ");
					$this->obj->DB_delete_all("ad_order","`comid` in (".$uids.")"," ");
		    	    $this->obj->DB_delete_all("company_pay","`com_id` in (".$uids.")"," ");
					$this->obj->DB_delete_all("atn","`uid` in (".$uids.") or `sc_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("look_resume","`com_id` in (".$uids.")","");
					$this->obj->DB_delete_all("fav_job","`com_id` in (".$uids.")","");
					$this->obj->DB_delete_all("userid_msg","`fid` in (".$uids.")","");
					$this->obj->DB_delete_all("userid_job","`com_id` in (".$uids.")","");
					$this->obj->DB_delete_all("look_job","`com_id` in (".$uids.")","");
					$this->obj->DB_delete_all("message","`fa_uid` in (".$uids.")","");
		    	    $this->obj->DB_delete_all("msg","`job_uid` in (".$uids.")","");
		    	    $this->obj->DB_delete_all("blacklist","`c_uid` in (".$uids.")","");
		    	    $this->obj->DB_delete_all("rebates","`job_uid` in (".$uids.") or `uid` in (".$uids.")"," ");
		    	    $this->obj->DB_delete_all("report","`p_uid` in ($uids) or `c_uid` in ($uids)","");
					$this->obj->DB_delete_all("part_apply","`comid` in (".$uids.")","");
					$this->obj->DB_delete_all("part_collect","`comid` in (".$uids.")","");
					$this->obj->DB_delete_all("member_log","`uid` in (".$uids.")","");
					$this->obj->DB_delete_all("down_resume","`comid` in (".$uids.")","");
		    	}else{
		    		$layer_type=0;
					$uids=$del = intval($del);
		    		
		    		delfiledir("../data/upload/tel/".$del);
				    $company=$this->obj->DB_select_once("company","`uid`='".$del."' and `logo`!=''","logo,firmpic");
				    unlink_pic(".".$company['logo']);
				    unlink_pic(".".$company['firmpic']);
		    	    $cert=$this->obj->DB_select_once("company_cert","`uid`='".$del."' and `type`='3'","check");
		    	    unlink_pic("../".$cert['check']);
		    	    $product=$this->obj->DB_select_all("company_product","`uid`='".$del."'","pic");
		    	    if(is_array($product)){
		    	    	foreach($product as $v){
		    	    		unlink_pic("../".$v['pic']);
		    	    	}
		    	    }
		    	    $show=$this->obj->DB_select_all("company_show","`uid`='".$del."'","picurl");
		    	    if(is_array($show)){
		    	    	foreach($show as $v){
		    	    		unlink_pic("../".$v['picurl']);
		    	    	}
		    	    }
			    	$uhotjob=$this->obj->DB_select_all("hotjob","`uid`='".$del."'","hot_pic");
		    	    if(is_array($uhotjob)){
		    	    	foreach($uhotjob as $val){
		    	    		unlink_pic("../".$val['hot_pic']);
		    	    	}
		    	    }
		    	    $banner=$this->obj->DB_select_once("banner","`uid`='".$del."'","pic");
					unlink_pic($banner['pic']);
					foreach($del_array as $value){
						$this->obj->DB_delete_all($value,"`uid`='".$del."'","");
					}
					$this->obj->DB_delete_all("email_msg","`uid`='".$del."' or `cuid`='".$del."'"," ");
					$this->obj->DB_delete_all("company_msg","`cuid`='".$del."'"," ");
					$this->obj->DB_delete_all("talent_pool","`cuid`='".$del."'"," ");
					$this->obj->DB_delete_all("user_entrust_record","`comid`='".$del."'"," ");
					$this->obj->DB_delete_all("ad_order","`comid`='".$del."'"," ");
					$this->obj->DB_delete_all("company_pay","`com_id`='".$del."'"," ");
		    	    $this->obj->DB_delete_all("atn","`uid`='".$del."' or `sc_uid`='".$del."'","");
		    	    $this->obj->DB_delete_all("look_resume","`com_id`='".$del."'","");
		    	    $this->obj->DB_delete_all("look_job","`com_id`='".$del."'","");
		    	    $this->obj->DB_delete_all("fav_job","`com_id`='".$del."'","");
		    	    $this->obj->DB_delete_all("userid_msg","`fid`='".$del."'","");
		    	    $this->obj->DB_delete_all("userid_job","`com_id`='".$del."'","");
		    	    $this->obj->DB_delete_all("message","`fa_uid`='".$del."'","");
		    	    $this->obj->DB_delete_all("msg","`job_uid`='".$del."'","");
		    	    $this->obj->DB_delete_all("blacklist","`c_uid`='".$del."'","");
		    	    $this->obj->DB_delete_all("rebates","`job_uid`='".$del."' or `uid` ='".$del."'"," ");
		    	    $this->obj->DB_delete_all("report","`p_uid`='".$del."' or `c_uid`='".$del."'","");
					$this->obj->DB_delete_all("part_apply","`comid` ='".$del."'","");
					$this->obj->DB_delete_all("part_collect","`comid` ='".$del."'","");
					$this->obj->DB_delete_all("member_log","`uid` ='".$del."'","");
					$this->obj->DB_delete_all("down_resume","`comid` ='".$del."'",""); 
		    	}
	    		$this->layer_msg( "公司(ID:".$uids.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的公司！",8,1);
	    	}
	    }
	}
	function lockinfo_action(){
		$userinfo = $this->obj->DB_select_once("member","`uid`=".$_POST['uid'],"`lock_info`");
		echo $userinfo['lock_info'];die;
	}
	function lock_action(){
		$_POST['uid']=intval($_POST['uid']);
		if(($_POST['status']==2 || $_POST['status']==3)&&$_POST['lock_info']==''){
			$this->ACT_layer_msg("请填写锁定说明！",8);
		}
		if($_POST['status']==3 &&$_POST['statusip']){
			$ip=$this->config['sy_bannedip']?$this->config['sy_bannedip']."|".$_POST['statusip']:$_POST['statusip'];
			$this->obj->DB_update_all("admin_config","`config`='".$ip."'","`name`='sy_bannedip'");
			$this->web_config();
			$_POST['status']==2;
		}

		$email=$this->obj->DB_select_once("company","`uid`='".$_POST['uid']."'","`linkmail`,`name`");
		$this->obj->DB_update_all("partjob","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$this->obj->DB_update_all("company_job","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$this->obj->DB_update_all("company","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$id=$this->obj->DB_update_all("member","`status`='".$_POST['status']."',`lock_info`='".$_POST['lock_info']."'","`uid`='".$_POST['uid']."'");
		if($_POST['status']=='2'){
			$this->send_msg_email(array("email"=>$email['linkmail'],"uid"=>$_POST['uid'],"name"=>$email['name'],"lock_info"=>$_POST['lock_info'],"type"=>"lock"));
		} 
		
		$id?$this->ACT_layer_msg("企业会员(ID:".$_POST['uid'].")锁定设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}

	function addgw_action(){
		 extract($_POST);
		 $value="`conid`='".$_POST['conid']."',";
		 $value.="`addtime`='".time()."'";
		 $where="`uid` in (".$uid.")";
		 $nid=$this->obj->DB_update_all("company",$value,$where);
		 $member=$this->obj->DB_select_all("member","`uid` in (".$uid.")");
		 if (is_array($member)&&!empty($member)){
		 	if ($nid){
		 		$this->ACT_layer_msg("顾问分配成功！",9,$_SERVER['HTTP_REFERER']);
		 	}else{
		 		$this->ACT_layer_msg("顾问分配失败！",8,$_SERVER['HTTP_REFERER']);
		 	}
		 }else{
		 	$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		 }
	}
	function status_action(){
		 extract($_POST);
		 $member=$this->obj->DB_select_all("member","`uid` in (".$uid.")","`email`,`moblie`,`uid`");
		 if(is_array($member)&&$member){
			 $company=$this->obj->DB_select_all("company","`uid` in (".$uid.")","`name`,`uid`");
			 $info=array();
			 
			foreach($company as $val){
				$info[$val['uid']]=$val['name'];
			}
			$smtp = $this->email_set();
			foreach($member as $v){
				$idlist[] =$v['uid'];
				if($status>0){
				 if($status==1){
					 $_POST['states'] = '审核通过！';
				 }else{
					 $_POST['states'] = '审核未通过！';
				 }
			 }
				$this->send_msg_email(array("uid"=>$v['uid'],"name"=>$info[$v['uid']],"email"=>$v['email'],"moblie"=>$v['moblie'],"auto_statis"=>$_POST['states'],"status_info"=>$statusbody,"date"=>date("Y-m-d H:i:s"),"type"=>"userstatus"),$smtp);
			}
			if(trim($statusbody)){
				$lock_info=$statusbody;
			}
			 
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("member","`status`='".$status."',`lock_info`='".$lock_info."'","`uid` IN (".$aid.")");
			if($id){
				if($status=="1"){
					$rstatus='1';
				}else{
					$rstatus='2';
				}
				$this->obj->DB_update_all("partjob","`r_status`='".$rstatus."'","`uid` IN (".$aid.")");
				$this->obj->DB_update_all("company","`r_status`='".$rstatus."'","`uid` IN (".$aid.")");
				$this->obj->DB_update_all("company_job","`r_status`='".$rstatus."'","`uid` IN (".$aid.")");
				$this->ACT_layer_msg("企业会员审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
			}else{
				$this->ACT_layer_msg("审核设置失败！",8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}

	function hotjobinfo_action(){
		if($_GET['id']){
			$hotjob=$this->obj->DB_select_once("hotjob","`uid`='".(int)$_GET['id']."'");
		}else if($_GET['uid']){
			$row = $this->obj->DB_select_alls("company","company_statis","a.`uid`='".(int)$_GET['uid']."' and b.`uid`='".(int)$_GET['uid']."'","a.`content`,a.`name` as username,b.`rating` as rating_id,b.`rating_name` as rating,a.`uid`,a.`logo` as hot_pic");
			$row=$row[0];
			$row['content']=@explode(' ',trim(strip_tags($row['content'])));
			if(is_array($row['content'])&&$row['content']){
				foreach($row['content'] as $val){
					$row['beizhu'].=trim($val);
				}
			}else{
				$row['beizhu']=$row['content'];
			}
			$hotjob=$row;
			$hotjob['time_start']=time();
		}
		$this->yunset("hotjob",$hotjob);
		$this->yuntpl(array('admin/admin_hotjob_info'));
	}

	function save_action(){
		extract($_POST);
		if(is_uploaded_file($_FILES['hot_pic']['tmp_name'])){
			$upload=$this->upload_pic("../data/upload/hotpic/");
			$pictures=$upload->picture($_FILES['hot_pic']);
			$pic = str_replace("../data/upload","./data/upload",$pictures);
		}else{
			if($_POST['hotad']){
				$defpic=".".$defpic;
				$url=@explode("/",$defpic);
				$url2=str_replace($url[4],date("Ymd"),$defpic);
				$name=@explode(".",$url[5]);
				$url2=str_replace($name[0],time(),$url2);
				if(!file_exists('../data/upload/company/'.date("Ymd")))
				{
					mkdir ('../data/upload/company/'.date("Ymd"));
				}
				copy($defpic,$url2);
				$pic = str_replace("../data/upload","./data/upload",$url2);
			}
		}
		$com=$this->obj->DB_select_once("company","`uid`='".$uid."'","`did`");
		if($_POST['hotad']){ 
			$start = strtotime($time_start);
			$end = strtotime($time_end);
			$nid=$this->obj->DB_insert_once("hotjob","`uid`='$uid',`username`='$username',`sort`='$sort',`rating_id`='$rating_id',`rating`='$rating',`hot_pic`='$pic',`service_price`='$service_price',`beizhu`='$beizhu',`time_start`='$start',`time_end`='$end',`did`='".$com['did']."'");
			$this->obj->DB_update_all("company","`hottime`='".$end."',`logo`='".$pic."',`rec`='1'","`uid`='".$uid."'");
			$this->ACT_layer_msg("名企招聘(ID:".$nid.")设定成功！",9,"index.php?m=admin_company",2,1);
		}elseif($_POST['hotup']){
			$start = strtotime($time_start);
			$end = strtotime($time_end);
			$value = "`service_price`='$service_price',`time_start`='$start',`time_end`='$end',`beizhu`='$beizhu',`sort`='$sort',`did`='".$com['did']."'";
			if($pic!=""){
				$hot=$this->obj->DB_select_once("hotjob","`id`='$id'");
				unlink_pic("../".$hot['hot_pic']);
				$value.=",`hot_pic`='$pic'";
			}
			$this->obj->DB_update_all("hotjob",$value,"`id`='$id'");
			$this->obj->DB_update_all("company","`hottime`='".$end."',`logo`='".$pic."'","`uid`='".$uid."'");
			$this->ACT_layer_msg("名企招聘(ID:".$id.")修改成功！",9,"index.php?m=admin_company",2,1);
		}
		$this->yuntpl(array('admin/admin_hotjob_add'));
	}
	function delhot_action(){
		$this->check_token();
	    if(isset($_GET['id'])){
	    	$hot=$this->obj->DB_select_once("hotjob","`uid`='".$_GET['id']."'");
			unlink_pic("../".$hot['hot_pic']);
			$result=$this->obj->DB_delete_all("hotjob","`uid`='".$_GET['id']."'" );
			if($result){
				$this->obj->DB_update_all("company","`hottime`='',`rec`='0'","`uid`='".$hot['uid']."'");
				$this->layer_msg('名企招聘(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
	}
	function changeorder_action(){
		if($_POST['uid']){
			if(!$_POST['order']){
				$_POST['order']='0';
			}
			$this->obj->DB_update_all("company","`order`='".$_POST['order']."'","`uid`='".$_POST['uid']."'");
			$this->admin_log("公司(ID:".$_POST['uid'].")排序设置成功");
		}
		die;
	}
	function Imitate_action(){
		extract($_GET);
		$user_info = $this->obj->DB_select_once("member","`uid`='".$uid."'");
		$this->unset_cookie();
		$this->add_cookie($user_info['uid'],$user_info['username'],$user_info['salt'],$user_info['email'],$user_info['password'],$user_info['usertype'],1,$user_info['did']);
		if($_GET['type']){
			$url = '/?c=tongji';
		}
		header('Location: '.$this->config['sy_weburl'].'/member'.$url);
	}
	function xls_action(){
		if($_POST['where']){
			$gettype=$_POST['type'];
			$_POST['where']=str_replace(array("[","]","an d","\&acute;","\\"),array("(",")","and","'",""),$_POST['where']);
			if(in_array("lastdate",$_POST['type']) || in_array("rating",$_POST['type']) || in_array("vip_stime",$_POST['type'])){
				foreach($_POST['type'] as $v){
					if($v=="lastdate"){
						$type[]="lastupdate";
					}elseif($v!="rating" && $v!="vip_stime"){
						$type[]=$v;
					}
				}
				$_POST['type']=$type;
			}
			$select=@implode(",",$_POST['type']);
			if(strstr($select,"rating") && strstr($select,"uid")==false){
				$select=$select.",uid";
			}
			$list=$this->obj->DB_select_all("company","uid in (".$_POST['uid'].") and ".$_POST['where'],$select);
			if(!empty($list)){
				if(in_array("rating",$gettype)){
					foreach($list as $v){
						$uid[]=$v['uid'];
					}
					$rating=$this->obj->DB_select_all("company_statis","uid in (".@implode(",",$uid).")","uid,rating_name,vip_stime");
					foreach($list as $k=>$v){
						foreach($rating as $val){
							if($v['uid']==$val['uid']){
								$list[$k]['rating']=$val['rating_name'];
								$list[$k]['vip_stime']=$val['vip_stime'];
							}
						}
					}
				}
				$this->yunset("list",$list);
				$this->yunset($this->MODEL('cache')->GetCache(array('city','hy','com')));
				$this->yunset("type",$gettype);
				$this->yuntpl(array('admin/admin_company_xls'));
				$this->admin_log("导出公司信息");
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=company.xls");
			}
		}
	}
	function check_username_action(){
		$username=iconv("utf-8", "gbk", $_POST['username']);
		$member=$this->obj->DB_select_once("member","`username`='".$username."'","`uid`");
		echo $member['uid'];die;
	}

	function checksitedid_action(){
		if($_POST['uid']){
			$uids=@explode(',',$_POST['uid']);
			$uid = pylode(',',$uids);
			if($uid){
				$siteDomain = $this->MODEL('site');
				$Table = array('member','company','company_statis','company_job','company_cert','company_news','company_order','company_product','partjob','hotjob');
				$siteDomain->UpDid(array('report'),$_POST['did'],"`p_uid` IN (".$uid.")");
				$siteDomain->UpDid(array('userid_msg'),$_POST['did'],"`fid` IN (".$uid.")");
				$siteDomain->UpDid(array('down_resume','company_pay'),$_POST['did'],"`com_id` IN (".$uid.")");
				$siteDomain->UpDid(array('look_resume','ad_order'),$_POST['did'],"`comid` IN (".$uid.")");
				$siteDomain->UpDid($Table,$_POST['did'],"`uid` IN (".$uid.")");
				$this->ACT_layer_msg( "会员(ID:".$_POST['uid'].")分配站点成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("请正确选择需分配用户！",8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg( "参数不全请重试！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function saveusername_action(){
		if($_POST['username']){
			$username=yun_iconv("utf-8","gbk",$_POST['username']);
			$M=$this->MODEL("userinfo");
			$num=$M->GetMemberNum(array("username"=>$username));
			if($num>0){
				echo 1;die;
			}else{
				$M->UpdateMember(array("username"=>$username),array("uid"=>$_POST['uid']));
				
				echo 0;die;
			}
		}
	}
	function getinfo_action(){
	    if($_POST['comid']){
	        $info= $this->obj->DB_select_once("company","`uid`='".intval($_POST['comid'])."'");
	        $member=$this->obj->DB_select_once("member","`uid`='".$info['uid']."'","`username`,`reg_ip`,`status`");
	        $statis=$this->obj->DB_select_once("company_statis","`uid`='".$info['uid']."'","`rating`");
	        $yyzz=$this->obj->DB_select_once("company_cert","`uid`='".$info['uid']."' and `type`=3 ","`check`");
	        $conid=$info['conid'];
	        if ($conid){
	        	$adviser=$this->obj->DB_select_once("company_consultant","`id`=$conid");
	        	$info['adviser']=$adviser['username'];
	        }else{
	        	$info['adviser']=null;
	        }
	        $info['username']=$member['username'];
	        $info['reg_ip']=$member['reg_ip'];
	        $info['status']=$member['status'];
	        $info['rating']=$statis['rating'];
	        $info['yyzzurl']=str_replace("./",$this->config['sy_weburl']."/",$yyzz['check']);
            if ($info['linktel']){
                $info['phone']=$info['linktel'];
            }else{
                $info['phone']=$info['linkphone'];
            }
	        echo json_encode(yun_iconv('gbk','utf-8',$info));
	    }
	}
	function mdown_action(){
	    $where='`comid`='.intval($_GET['comid']).'';
	    $urlarr['c']='mdown';
	    $urlarr['comid']=intval($_GET['comid']);
	    if(trim($_GET['keyword'])){
	        if($_GET['type']=="1"){
	            $info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
	            if(is_array($info)){
	                foreach ($info as $v){
	                    $uid[]=$v['uid'];
	                }
	            }
	            $where.=" and `uid` in (".@implode(",",$uid).")";
	        }elseif ($_GET['type']=="2"){
	            $info=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET['keyword'])."%'","`id`");
	            if(is_array($info)){
	                foreach ($info as $v){
	                    $eid[]=$v['id'];
	                }
	            }
	            $where.=" and `eid` in (".@implode(",",$eid).")";
	        }
	        $urlarr['type']=$_GET['type'];
	        $urlarr['keyword']=$_GET['keyword'];
	    }
	    if($_GET['order']){
	        $where.=" order by ".$_GET['t']." ".$_GET['order'];
	        $urlarr['order']=$_GET['order'];
	        $urlarr['t']=$_GET['t'];
	    }else{
	        $where.=" order by id desc";
	    }
	    $urlarr["page"]="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $list=$this->get_page("down_resume",$where,$pageurl,$this->config['sy_listnum']);
	    if(is_array($list)){
	        foreach($list as $v){
	            $eid[]=$v['eid'];
	            $uid[]=$v['uid'];
	            $uid[]=$v['comid'];
	            $comid[]=$v['comid'];
	        }
	        $resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","name,id");
	        $member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid,usertype");
	        $company=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$comid).")","name,uid");
	        foreach($list as $k=>$v){
	            foreach($company as $val){
	                if($v['comid']==$val['uid']){
	                    $list[$k]['com_name']=$val['name'];
	                }
	            }
	            foreach($resume as $val){
	                if($v['eid']==$val['id']){
	                    $list[$k]['resume']=$val['name'];
	                }
	            }
	            foreach($member as $val){
	                if($v['uid']==$val['uid']){
	                    $list[$k]['username']=$val['username'];
	                }
	                if($v['comid']==$val['uid']){
	                    $list[$k]['com_username']=$val['username'];
	                    $list[$k]['usertype']=$val['usertype'];
	                }
	            }
	        }
	    }
	    $this->yunset("list",$list);
	    $this->yuntpl(array('admin/admin_company_mdown'));
	}
	function mdowndel_action(){
	    $this->check_token();
	    if($_GET['del']){
	        if(is_array($_GET['del'])){
	            $del=@implode(",",$_GET['del']);
	            $layer_status=1;
	        }else{
	            $del=$_GET['del'];
	            $layer_status=0;
	        }
	        $this->obj->DB_delete_all("down_resume","`id` in (".$del.")","");
	        $this->layer_msg( "下载记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	    }else{
	        $this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    }
	}
	function mapply_action(){
	    $where='`com_id`='.intval($_GET['comid']).'';
	    $urlarr['c']='mapply';
	    $urlarr['comid']=intval($_GET['comid']);
	    if(trim($_GET['keyword'])){
	        if($_GET['type']=="1"){
	            $info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
	            if(is_array($info)){
	                foreach ($info as $v){
	                    $uid[]=$v['uid'];
	                }
	            }
	            $where.=" and `uid` in (".@implode(",",$uid).")";
	        }elseif ($_GET['type']=="2"){
	            $info=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET['keyword'])."%'","`id`");
	            if(is_array($info)){
	                foreach ($info as $v){
	                    $eid[]=$v['id'];
	                }
	            }
	            $where.=" and `eid` in (".@implode(",",$eid).")";
	        }
	        $urlarr['type']=$_GET['type'];
	        $urlarr['keyword']=$_GET['keyword'];
	    }
	    if($_GET['order']){
	        $where.=" order by ".$_GET['t']." ".$_GET['order'];
	        $urlarr['order']=$_GET['order'];
	        $urlarr['t']=$_GET['t'];
	    }else{
	        $where.=" order by id desc";
	    }
	    $urlarr["page"]="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $list=$this->get_page("userid_job",$where,$pageurl,$this->config['sy_listnum']);
	    if(is_array($list)){
	        foreach($list as $v){
	            $eid[]=$v['eid'];
	            $uid[]=$v['uid'];
	            $comid[]=$v['com_id'];
	        }
	        $resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","name,id");
	        $member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid");
	        $company=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$comid).")","name,uid");
	        foreach($list as $k=>$v){
	            foreach($company as $val){
	                if($v['comid']==$val['uid']){
	                    $list[$k]['com_name']=$val['name'];
	                }
	            }
	            foreach($resume as $val){
	                if($v['eid']==$val['id']){
	                    $list[$k]['resume']=$val['name'];
	                }
	            }
	            foreach($member as $val){
	                if($v['uid']==$val['uid']){
	                    $list[$k]['username']=$val['username'];
	                }
	            }
	        }
	    }
	    $this->yunset("list",$list);
	    $this->yuntpl(array('admin/admin_company_mapply'));
	}
	
	function mapplydel_action(){
	    $this->check_token();
	    if($_GET['del']){
	        if(is_array($_GET['del'])){
	            $id=@implode(",",$_GET['del']);
	            $layer_status=1;
	        }else{
	            $id=$_GET['del'];
	            $layer_status=0;
	        }
	        $sq_num = $this->obj->DB_select_all("userid_job","`id` in (".$id.") and `com_id`='".intval($_GET['comid'])."'","`uid`,`job_id`");
	        if(is_array($sq_num)){
	            $jobid=array();
	            $uid=array();
	            foreach($sq_num as $v){
	                $jobid[]=$v['job_id'];
	                $uid[]=$v['uid'];
	            }
	            if(intval($_POST['type'])!=2){
	                $this->obj->DB_update_all("company_job","`operatime`='".time()."'","`id` in (".pylode(",",$jobid).") and `uid`='".intval($_GET['comid'])."'");
	            }
	            $this->obj->DB_update_all("member_statis","`sq_jobnum`=`sq_jobnum`-1","`uid`  in(".pylode(",",$uid).")");
	        }
	        $num=count($sq_num);
	        $this->obj->DB_update_all("company_statis","`sq_job`=`sq_job`-$num","`uid`='".intval($_GET['comid'])."'");
	        $nid=$this->obj->DB_delete_all("userid_job","`id` in (".$id.") and `com_id`='".intval($_GET['comid'])."'"," ");
	        if($nid){
	            $this->layer_msg('删除成功！',9,$layer_status,$_SERVER['HTTP_REFERER']);
	        }else{
	            $this->layer_msg('删除失败！',8,$layer_status,$_SERVER['HTTP_REFERER']);
	        }
	    }else{
	        $this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    }
	}
	
	function minvite_action(){
	    $where='`fid`='.intval($_GET['comid']).'';
	    $urlarr['c']='minvite';
	    $urlarr['fid']=intval($_GET['comid']);
	    if(trim($_GET['keyword'])){
	        if($_GET['type']=="1"){
	            $info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
	            if(is_array($info)){
	                foreach ($info as $v){
	                    $uid[]=$v['uid'];
	                }
	            }
	            $where.=" and `uid` in (".@implode(",",$uid).")";
	        }elseif ($_GET['type']=="2"){
	            $info=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET['keyword'])."%'","`id`");
	            if(is_array($info)){
	                foreach ($info as $v){
	                    $eid[]=$v['id'];
	                }
	            }
	            $where.=" and `eid` in (".@implode(",",$eid).")";
	        }
	        $urlarr['type']=$_GET['type'];
	        $urlarr['keyword']=$_GET['keyword'];
	    }
	    if($_GET['order']){
	        $where.=" order by ".$_GET['t']." ".$_GET['order'];
	        $urlarr['order']=$_GET['order'];
	        $urlarr['t']=$_GET['t'];
	    }else{
	        $where.=" order by id desc";
	    }
	    $urlarr["page"]="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $list=$this->get_page("userid_msg",$where,$pageurl,$this->config['sy_listnum']);
	    if(is_array($list)){
	        foreach($list as $v){
	            $uid[]=$v['uid'];
	        }
	        $resume=$this->obj->DB_select_all("resume","`uid` in (".@implode(",",$uid).")","name,uid");
	        foreach($list as $k=>$v){
	            foreach($resume as $val){
	                if($v['uid']==$val['uid']){
	                    $list[$k]['resume']=$val['name'];
	                }
	            }
	        }
	    }
	    $this->yunset("list",$list);
	    $this->yuntpl(array('admin/admin_company_minvite'));
	}
	function minvitedel_action(){
	    $this->check_token();
	    if($_GET['del']){
	        if(is_array($_GET['del'])){
	            $del=@implode(",",$_GET['del']);
	            $layer_status=1;
	        }else{
	            $del=$_GET['del'];
	            $layer_status=0;
	        }
	        $this->obj->DB_delete_all("userid_msg","`id` in (".$del.")","");
	        $this->layer_msg( "邀请面试记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	    }else{
	        $this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    }
	}
	function sendsysmsg_action(){
        if($_POST['content']==""){
            $this->ACT_layer_msg("请填写内容！",8);
        }
        $data['content']=$_POST['content'];
        $data['ctime']=time();
        $data['fa_uid']=$_POST['sysmsg_user'];
        $data['username']=$_POST['sys_username'];
        $nid=$this->obj->insert_into("sysmsg",$data);
        if ($nid){
            $this->ACT_layer_msg("系统消息发送成功！",9,$_SERVER['HTTP_REFERER'],2,1);
        }else{
            $this->ACT_layer_msg("用户不存在！",8,$_SERVER['HTTP_REFERER']);
        }
	}
	function member_log_action(){
	    $opera=array('1'=>'职位操作','3'=>'下载简历','4'=>'邀请面试','7'=>'修改基本信息','8'=>'修改密码');
	    $search_list[]=array("param"=>"operas","name"=>'操作类型',"value"=>$opera);
	    if($_GET['operas']=='1'||$_GET['operas']=='2'){
	        $parr=array('1'=>'增加','2'=>'修改','3'=>'删除','4'=>'刷新');
	        $search_list[]=array("param"=>"parrs","name"=>'操作内容',"value"=>$parr);
	    }
	    $ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
	    $search_list[]=array("param"=>"end","name"=>'发布时间',"value"=>$ad_time);
	    $this->yunset("search_list",$search_list);
	    
	    $where='`uid`='.intval($_GET['comid']).'';
	    $urlarr['c']='member_log';
	    $urlarr['comid']=intval($_GET['comid']);
	    if($_GET['operas']){
	        $where.=" and `opera`='".$_GET['operas']."'";
	        $urlarr['operas']=$_GET['operas'];
	    }
	    if($_GET['parr']){
	        $where.=" and `type`='".$_GET['parrs']."'";
	        $urlarr['parrs']=$_GET['parrs'];
	    }
	    if($_GET['end']){
	        if($_GET['end']=='1'){
	            $where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
	        }else{
	            $where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
	        }
	        $urlarr['end']=$_GET['end'];
	    }
	    if($_GET['stime']){
	        $where.=" and `ctime` >='".strtotime($_GET['stime']."00:00:00")."'";
	        $urlarr['stime']=$_GET['stime'];
	    }
	    if($_GET['etime']){
	        $where.=" and `ctime` <='".strtotime($_GET['etime']."23:59:59")."'";
	        $urlarr['etime']=$_GET['etime'];
	    }
	    if($_GET['order']){
	        $where.=" order by ".$_GET['t']." ".$_GET['order'];
	        $urlarr['order']=$_GET['order'];
	        $urlarr['t']=$_GET['t'];
	    }else{
	        $where.=" order by `id` desc";
	    }
	    $urlarr['page']="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $rows=$this->get_page("member_log",$where,$pageurl,$this->config['sy_listnum']);
	    if(is_array($rows)){
	            foreach($rows as $v){
	                $uid[]=$v['uid'];
	            $member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","`uid`,`username`");
	        }
	        foreach($rows as $k=>$v){
	            foreach($member as $val){
	                if($v['uid']==$val['uid']){
	                    $rows[$k]['username']=$val['username'];
	                }
	            }
	        }
	    }
	    $this->yunset("rows",$rows);
	    $this->yuntpl(array('admin/admin_company_member_log'));
	}
	function mmeberlogdel_action(){
	    $this->check_token();
	    if($_GET['del']){
	        $del=$_GET['del'];
	        if($del){
	            if(is_array($del)){
	                $layer_type=1;
	                $this->obj->DB_delete_all("member_log","`id` in (".@implode(',',$del).")","");
	                $del=@implode(',',$del);
	            }else{
	                $this->obj->DB_delete_all("member_log","`id`='".$del."'");
	                $layer_type=0;
	            }
	            $this->layer_msg('会员日志(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	        }else{
	            $this->layer_msg('请选择您要删除的信息！',8,0,$_SERVER['HTTP_REFERER']);
	        }
	    }
	}
	
	function mjob_action(){
	    $urlarr['c']='mjob';
	    $urlarr['comid']=intval($_GET['comid']);
	    $urlarr['page']="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $M=$this->MODEL();
	    $PageInfo=$M->get_page("company_job",'`uid`='.intval($_GET['comid']).'',$pageurl,$this->config['sy_listnum']);
	    $this->yunset($PageInfo);
	    $rows=$PageInfo['rows'];
	    include PLUS_PATH."job.cache.php";
	    include PLUS_PATH."industry.cache.php";
	    include PLUS_PATH."com.cache.php";
	    if(is_array($rows)){
	        $jobids=array();
	        foreach ($rows as $v){
	            $jobids[]=$v['id'];
	        }
	        $useridjob=$this->MODEL('job')->GetApplyList(array("`job_id` in(".pylode(',',$jobids).")",'is_browse'=>1),array('field'=>"count(id) as num,`job_id`",'groupby'=>'job_id'));
	        	
	        $msgnum=$this->MODEL('resume')->GetUserMsgNums(array("`jobid` in(".pylode(',',$jobids).")"),array('field'=>"count(id) as num,`jobid`",'groupby'=>'jobid'));
	        foreach($rows as $k=>$v){
	            if($v['rec_time']>1000){
	                $rows[$k]['recdate']=date("Y-m-d",$v['rec_time']);
	            }
	            if($v['urgent_time']>1000){
	                $rows[$k]['eurgent']=date("Y-m-d",$v['urgent_time']);
	            }
	    
	            $rows[$k]['browseNum']=$rows[$k]['inviteNum']=0;
	            $rows[$k]['edu']=$comclass_name[$v['edu']];
	            $rows[$k]['exp']=$comclass_name[$v['exp']];
	            if($v['job_post']){
	                $rows[$k]['job']=$job_name[$v['job_post']];
	            }else{
	                $rows[$k]['job']=$job_name[$v['job1_son']];
	            }
	    
	            $rows[$k]['salary']=$comclass_name[$v['salary']];
	            $rows[$k]['type']=$comclass_name[$v['type']];
	            if($v['edate']<time())
	            {
	                $rows[$k]['edatetxt'] = "<font color='red'>已到期</font>";
	            }elseif($v['edate']<(time()+3*86400)){
	    
	                $rows[$k]['edatetxt'] = "<font color='blue'>3天内到期</font>";
	    
	            }elseif($v['edate']<(time()+7*86400)){
	    
	                $rows[$k]['edatetxt'] = "<font color='blue'>7天内到期</font>";
	            }else{
	                $rows[$k]['edatetxt'] = date("Y-m-d",$v['edate']);
	            }
	            if($v['urgent_time']>time()){
	                $rows[$k]['urgent_day'] = ceil(($v['urgent_time']-time())/86400);
	            }else{
	                $rows[$k]['urgent_day'] = "0";
	            }
	            if($v['rec_time']>time()){
	                $rows[$k]['rec_day'] = ceil(($v['rec_time']-time())/86400);
	            }else{
	                $rows[$k]['rec_day'] = "0";
	            }
	            foreach($useridjob as $val){
	                if($val['job_id']==$v['id']){
	                    $rows[$k]['browseNum']=$val['num'];
	                }
	            }
	            foreach($msgnum as $val){
	                if($val['jobid']==$v['id']){
	                    $rows[$k]['inviteNum']=$val['num'];
	                }
	            }
	    
	        }
	    }
	    $where=str_replace(array("(",")"),array("[","]"),$where);
	    $this->yunset("where",$where);
	    $this->job_cache();
	    $this->com_cache();
	    $this->industry_cache();
	    $this->yunset("rows",$rows);
	    $this->yunset("time",time());
	    $this->yuntpl(array('admin/admin_company_mjob'));
	}
	function mjobshow_action(){
	    $this->yunset($this->MODEL('cache')->GetCache(array('city','hy','com','job')));
	    if($_GET['id']){
	        $show=$this->obj->DB_select_once("company_job","id='".$_GET['id']."'");
	        $show['lang']=@explode(',',$show['lang']);
	        $show['welfare']=@explode(',',$show['welfare']);
	        if($show['three_cityid']){
	            $show['circlecity']=$show['three_cityid'];
	        }else if($show['cityid']){
	            $show['circlecity']=$show['cityid'];
	        }else if($show['provinceid']){
	            $show['circlecity']=$show['provinceid'];
	        }
	        $this->yunset("show",$show);
	        $this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
	    }
	
	    if($_POST['update']){
	        $_POST['lang']=@implode(',',$_POST['lang']);
	        $_POST['welfare']=@implode(',',$_POST['welfare']);
	
	        $_POST['edate']=strtotime($_POST['edate']);
	        $_POST['description'] = str_replace("&amp;","&",html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
	        $_POST['lastupdate'] = time();
	        $lasturl=$_POST['lasturl'];
	        unset($_POST['update']);unset($_POST['content']);unset($_POST['lasturl']);
	        if($_POST['edate']>time()){
	            $_POST['state']="1";
	        }else{
	            $this->ACT_layer_msg("结束时间不能小于当前时间",8,$_SERVER['HTTP_REFERER'],2,1);
	        }
	
	        if($_POST['id']&&$_POST['uid']==''){
	            $job=$this->obj->DB_select_once("company_job","`id`='".$_POST['id']."'","`uid`");
	            $where['id']=$_POST['id'];
	            unset($_POST['id']);
	            $this->obj->update_once("company_job",$_POST,$where);
	            $this->obj->DB_update_all("company","`lastupdate`='".time()."'","`uid`='".$job['uid']."'");
	            $this->ACT_layer_msg("职位(ID:".$where['id'].")修改成功！",9,$lasturl,2,1);
	        }else if($_POST['uid']){
	            $company=$this->obj->DB_select_once("company","`uid`='".$_POST['uid']."'","name");
	            $statis=$this->obj->DB_select_once("company_statis","`uid`='".$_POST['uid']."'","`vip_etime`,`job_num`,`integral`");
	
	            if($statis['vip_etime']>time() || $statis['vip_etime']=="0"){
	                if($statis['rating_type']==1){
	                    if($statis['job_num']<1){
	                        if($this->config['com_integral_online']=="1"){
	                            if($statis['integral']<$this->config['integral_job']){
	                                $this->ACT_layer_msg($this->config['integral_pricename']."不够发布职位！",8,"index.php?m=admin_company_job");
	                            }
	                        }else{
	                            $this->ACT_layer_msg("该会员发布职位用完！",8,"index.php?m=admin_company_job");
	                        }
	                    }else{
	                        $this->obj->DB_update_all("company_statis","`job_num`=`job_num`-1","`uid`='".$_POST['uid']."'");
	                    }
	                }
	            }else{
	                if($this->config['com_integral_online']=="1"){
	                    if($statis['integral']<$this->config['integral_job']){
	                        $this->ACT_layer_msg($this->config['integral_pricename']."不够发布职位！",8,"index.php?m=admin_company_job");
	                    }
	                }else{
	                    $this->ACT_layer_msg("该会员发布职位用完！",8,"index.php?m=admin_company_job");
	                }
	            }
	            $_POST['com_name']=$company['name'];
	            $_POST['sdate']=time();
	            $id=$this->obj->insert_into("company_job",$_POST);
	            if($id){
	                $this->obj->DB_update_all("company","`jobtime`='".time()."'","`uid`='".$_POST['uid']."'");
	                $this->ACT_layer_msg( "职位(ID:".$id.")发布成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	            }else{
	                $this->ACT_layer_msg( "职位发布失败！",8,$_SERVER['HTTP_REFERER'],2,1);
	            }
	        }
	    }
	    $this->yunset("uid",$_GET['uid']);
	    $this->yuntpl(array('admin/admin_company_job_show'));
	}
	function mlockinfo_action(){
	    $userinfo = $this->obj->DB_select_once("company_job","`id`=".$_POST['id'],"`statusbody`");
	    echo $userinfo['statusbody'];die;
	}
	function mstatus_action(){
	    extract($_POST);
	    $id = @explode(",",$pid);
	    if(is_array($id)){
	        foreach($id as $value){
	            if($value){
	                $idlist[] = $value;
	                $data[] = $this->shjobmsg($value,$status,$statusbody);
	            }
	        }
	        if($data!=""){
	            $smtp = $this->email_set();
	            foreach($data as $key=>$val){
	                $this->send_msg_email($val,$smtp);
	            }
	        }
	        $aid = @implode(",",$idlist);
	        $id=$this->obj->DB_update_all("company_job","`state`='$status',`statusbody`='".$statusbody."',`lastupdate`='".time()."'","`id` IN ($aid)");
	        if($id){
	            $Weixin=$this->MODEL('weixin');
	            $sendInfo['jobid'] = $idlist;
	            $sendInfo['state'] = $status;
	            $sendInfo['statusbody'] = $statusbody;
	            $Weixin->sendWxJobStatus($sendInfo);
	        }
	        $id?$this->ACT_layer_msg("职位审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	    }else{
	        $this->ACT_layer_msg("非法操作！",3,$_SERVER['HTTP_REFERER']);
	    }
	}
	function msaveclass_action(){
	    extract($_POST);
	    if($hy==""){
	        $this->ACT_layer_msg("请选择行业类别！",8,$_SERVER['HTTP_REFERER']);
	    }
	    if($job1==""){
	        $this->ACT_layer_msg("请选择职位类别！",8,$_SERVER['HTTP_REFERER']);
	    }
	    $id=$this->obj->DB_update_all("company_job","`hy`='$hy',`job1`='$job1',`job1_son`='$job1_son',`job_post`='$job_post'","`id` IN ($jobid)");
	    $id?$this->ACT_layer_msg("职位类别(ID:".$jobid.")修改成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("修改失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function mjobclass_action(){
	    include(PLUS_PATH."industry.cache.php");
	    include(PLUS_PATH."job.cache.php");
	    if(is_array($job_type[$_POST['val']])&&$job_type[$_POST['val']]){
	        foreach($job_type[$_POST['val']] as $val){
	            $html.="<option value='".$val."'>".$job_name[$val]."</option>";
	        }
	    }else{$html.="<option value=''>暂无分类</option>";}
	    echo $html;
	}
	function shjobmsg($jobid,$yesid,$statusbody){
	    $data=array();
	    $comarr=$this->obj->DB_select_once("company_job","`id`='".$jobid."'","uid,name");
	    if($yesid==1){
	        $data['type']="zzshtg";
	        $this->send_dingyue($jobid,2);
	    }elseif($yesid==3){
	        $data['type']="zzshwtg";
	    }
	    if($data['type']!=""){
	        $uid=$this->obj->DB_select_alls("member","company","a.`uid`='".$comarr['uid']."' and a.`uid`=b.`uid`","a.email,a.moblie,a.uid,b.name");
	        $data['uid']=$uid[0]['uid'];
	        $data['name']=$uid[0]['name'];
	        $data['email']=$uid[0]['email'];
	        $data['moblie']=$uid[0]['moblie'];
	        $data['jobname']=$comarr['name'];
	        $data['date']=date("Y-m-d H:i:s");
	        $data['status_info']=$statusbody;
	        return $data;
	    }
	}
	function mctime_action(){
	    extract($_POST);
	    $id=@explode(",",$jobid);
	    if(is_array($id)){
	        $posttime=$endtime*86400;
	        foreach($id as $value){
	            $row=$this->obj->DB_select_once("company_job","`id`='".$value."'");
	            if($row['state']==2 || $row['edate']<time()){
	                $time=time()+$posttime;
	                $id=$this->obj->DB_update_all("company_job","`edate`='".$time."',`state`='1'","`id`='".$value."'");
	            }else{
	                $time=$row['edate']+$posttime;
	                $id=$this->obj->DB_update_all("company_job","`edate`='".$time."'","`id`='".$value."'");
	            }
	        }
	        $id?$this->ACT_layer_msg("职位延期(ID:".$jobid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	    }else{
	        $this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
	    }
	}
	function mxuanshang_action(){
	    if($_POST['s']==1){
	        $id=$this->obj->DB_update_all("company_job","`xsdate`='0'","`id`='".intval($_POST['pid'])."'");
	    }else{
	        $info=$this->obj->DB_select_once("company_job","`id`='".intval($_POST['pid'])."'","`xsdate`");
	        $xsdays=intval($_POST['xsdays']);
	        $time=$xsdays*86400;
	        if($info['xsdate']>time()){
	            $id=$this->obj->DB_update_all("company_job","`xsdate`=`xsdate`+'".$time."'","`id`='".intval($_POST['pid'])."'");
	        }else{
	            $xsdate=time()+$time;
	            $id=$this->obj->DB_update_all("company_job","`xsdate`='".$xsdate."'","`id`='".intval($_POST['pid'])."'");
	        }
	    }
	    $id?$this->ACT_layer_msg("职位置顶(ID:".$_POST['pid'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function mrecommend_action(){
	    extract($_POST);
	    if($addday<1&&$s==''){$this->ACT_layer_msg("推荐天数不能为空！",8);}
	    $addtime = 86400*$addday;
	    if($pid){
	        if($s==1){
	            $this->obj->DB_update_all("company_job","`rec_time`='0',`rec`='0'","`id`='$pid'");
	        }elseif($eid>time()){
	            $this->obj->DB_update_all("company_job","`rec_time`=`rec_time`+$addtime,`rec`='1'","`id`='$pid'");
	        }else{
	            $time=time()+$addtime;
	            $this->obj->DB_update_all("company_job","`rec_time`='".$time."',`rec`='1'","`id`='$pid'");
	        }
	        $this->ACT_layer_msg("职位推荐(ID:".$pid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	    }
	    if(!empty($codearr)){
	        if($s==1){
	            $this->obj->DB_update_all("company_job","`rec_time`='0',`rec`='0'","`id` in (".$codearr.")");
	            $this->ACT_layer_msg("取消职位推荐设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	        }else{
	            $list=$this->obj->DB_select_all("company_job","`id` in (".$codearr.")","`id`,`rec_time`");
	            if(is_array($list)){
	                foreach($list as $v){
	                    if($v['rec_time']<time()){
	                        $gid[]=$v['id'];
	                    }else{
	                        $mid[]=$v['id']; 
	                    }
	                }
	                $guoqi=@implode(",",$gid);
	                $meiguo=@implode(",",$mid);
	                if($guoqi!=""){
	                    $time=time()+$addtime;
	                    $this->obj->DB_update_all("company_job","`rec_time`=".$time.",`rec`='1'","`id` in (".$guoqi.")");
	                }elseif($meiguo!=""){
	                    $this->obj->DB_update_all("company_job","`rec_time`=`rec_time`+$addtime,`rec`='1'","`id` in (".$meiguo.")");
	                }
	                $this->ACT_layer_msg("职位推荐设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	            }
	        }
	    }
	}
	function murgent_action(){
	    extract($_POST);
	    if($addday<1&&$s==''){$this->ACT_layer_msg("紧急天数不能为空！",8);}
	    $addtime = 86400*$addday;
	    if($pid){
	        if($s==1){
	            $this->obj->DB_update_all("company_job","`urgent_time`='0',`urgent`='0'","`id`='$pid'");
	        }elseif($eid>time()){
	            $this->obj->DB_update_all("company_job","`urgent_time`=`urgent_time`+$addtime,`urgent`='1'","`id`='$pid'");
	        }else{
	            $this->obj->DB_update_all("company_job","`urgent_time`=".time()."+$addtime,`urgent`='1'","`id`='$pid'");
	        }
	        $this->ACT_layer_msg("紧急招聘(ID:".$pid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	    }
	    if(!empty($codeugent)){
	        if($s==1){
	            $this->obj->DB_update_all("company_job","`urgent_time`='0',`urgent`='0'","`id` in (".$codeugent.")");
	            $this->ACT_layer_msg("取消职位紧急设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	        }else{
	            $code_ugent=@explode(",",$codeugent);
	            if(is_array($code_ugent)){
	                foreach($code_ugent as $k=>$v){
	                    $r_time[$v]=$this->obj->DB_select_once("company_job","`id`='".$v."'","`urgent_time`");
	                }
	            }
	            if(is_array($r_time)){
	                $ti=time();
	                foreach($r_time as $ke=>$va){
	                    if($va['urgent_time']<$ti){
	                        $g_id[]=$ke;
	                    }else{
	                        $m_id[]=$ke; 
	                    }
	                }
	                $guoqi=@implode(",",$g_id);
	                $meiguo=@implode(",",$m_id);
	                if($g_id){
	                    $this->obj->DB_update_all("company_job","`urgent_time`=".time()."+$addtime,`urgent`='1'","`id` in (".$guoqi.")");
	                }elseif($m_id){
	                    $this->obj->DB_update_all("company_job","`urgent_time`=`urgent_time`+$addtime,`urgent`='1'","`id` in (".$meiguo.")");
	                }
	                $this->ACT_layer_msg("职位紧急设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	            }
	        }
	    }
	}
	function mjobdel_action(){
	    $this->check_token();
	    if($_GET['del']||$_GET['id']){
	        if(is_array($_GET['del'])){
	            $layer_type=1;
	            $del=@implode(',',$_GET['del']);
	        }else{
	            $layer_type=0;
	            $del=$_GET['id'];
	        }
	        $this->obj->DB_delete_all("user_entrust_record","`jobid` in (".$del.")","");
	        $this->obj->DB_delete_all("company_job","`id` in (".$del.")","");
	        $this->obj->DB_delete_all("company_job_link","`jobid` in (".$del.")","");
	        $this->obj->DB_delete_all("userid_msg","`jobid` in (".$del.")","");
	        $this->obj->DB_delete_all("userid_job","`job_id` in (".$del.")","");
	        $this->obj->DB_delete_all("fav_job","`job_id` in (".$del.")","");
	        $this->obj->DB_delete_all("look_job","`jobid` in (".$del.")","");
	        $this->obj->DB_delete_all("report","`usertype`=1 and `type`=0 and `eid` in (".$del.")","");
	        $this->layer_msg("职位(ID:".$del.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
	    }else{
	        $this->layer_msg("请选择您要删除的信息！",8,1);
	    }
	}
	function mrefresh_action(){
	    $list=$this->obj->DB_select_all("company_job","`id` in (".$_POST['ids'].")","`uid`");
	    if(is_array($list)){
	        foreach($list as $v){
	            $uid[]=$v['uid'];
	        }
	        $this->obj->DB_update_all("company","`lastupdate`='".time()."'","`uid` in (".@implode(",",$uid).")");
	    }
	    $this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`id` in (".$_POST['ids'].")");
	    $this->admin_log("职位(ID".$_POST['ids']."刷新成功");
	}
	function mxls_action(){
	    if($_POST['where']){
	        $_POST['where']=str_replace(array("[","]","an d","\&acute;","\\"),array("(",")","and","'",""),$_POST['where']);
	        if(in_array("lastdate",$_POST['type']))
	        {
	            foreach($_POST['type'] as $v)
	            {
	                if($v=="lastdate"){
	                    $type[]="lastupdate";
	                }else{
	                    $type[]=$v;
	                }
	            }
	            $_POST['type']=$type;
	        }
	        $select=@implode(",",$_POST['type']);
	        $list=$this->obj->DB_select_all("company_job","`id` in (".$_POST["pid"].") and ".$_POST['where'],$select);
	        if(!empty($list))
	        {
	            foreach($list as $k=>$v)
	            {
	                $welfares = $langs = array();
	                if($v['lang']!="")
	                {
	                    include PLUS_PATH."/com.cache.php";
	                    $lang=@explode(",",$v['lang']);
	                    foreach($lang as $val)
	                    {
	                        $langs[]=$comclass_name[$val];
	                    }
	                    $list[$k]['lang']=@implode(",",$langs);
	                }
	                if($v['welfare']!="")
	                {
	                    include PLUS_PATH."/com.cache.php";
	                    $lang=@explode(",",$v['welfare']);
	                    foreach($lang as $val)
	                    {
	                        $welfares[]=$comclass_name[$val];
	                    }
	                    $list[$k]['welfare']=@implode(",",$welfares);
	                }
	            }
	            $this->yunset("list",$list);
	            $this->yunset($this->MODEL('cache')->GetCache(array('city','hy','com','job')));
	            $this->yunset("type",$_POST['type']);
	            $this->yuntpl(array('admin/admin_job_xls'));
	            $this->admin_log("导出职位信息");
	            header("Content-Type: application/vnd.ms-excel");
	            header("Content-Disposition: attachment; filename=job.xls");
	        }
	    }
	}
	function mcheckstate_action(){
	    if($_POST['id'] && $_POST['state']){
	        if($_POST['state']==2){
	            $_POST['state']=0;
	        }
	        $this->obj->DB_update_all("company_job","`status`='".$_POST['state']."'","`id`='".$_POST['id']."'");
	    }
	    echo 1;
	}
	function mmatching_action(){
	    if($_GET['id']){
	        $id=intval($_GET['id']);
	        $this->yunset($this->MODEL('cache')->GetCache(array('city')));
	        $where = "status<>'2' and `r_status`<>'2' and `job_classid`<>'' and `open`='1' and `defaults`='1'";
	        $JobM=$this->MODEL('job');
	        $jobinfo=$JobM->GetComjobOne(array('id'=>$id),array('field'=>'uid,job1,cityid'));
	        $this->yunset('comid',$jobinfo['uid']);
	        if($jobinfo){
	            $where .="and `cityid`='".$jobinfo['cityid']."'";
	        }
	        include PLUS_PATH."job.cache.php";
	        if($jobinfo['job1']){
	            $joball=$job_type[$jobinfo['job1']];
	            foreach($job_type[$jobinfo['job1']] as $v){
	                $joball[]=@implode(",",$job_type[$v]);
	            }
	            $job_classid=@implode(",",$joball);
	        }
	        if(!empty($job_classid)){
	            $classid=@explode(",",$job_classid);
	            foreach($classid as $value){
	                $jobclass[]="FIND_IN_SET('".$value."',job_classid)";
	            }
	            $classid=@implode(" or ",$jobclass);
	            $where .= " AND ($classid)";
	        }
	        $record=$this->obj->DB_select_all("user_entrust_record","`jobid`='".$id."'");
	        foreach($record as $k=>$v){
	            $eids[]=$v['eid'];
	        }
	        $where.=" and `id` not in(".pylode(',',$eids).")";
	        $where.="order by `lastupdate` desc";
	        $urlarr["page"]="{{page}}";
	        $pageurl=Url('admin_company_job&c=matching&id='.$id.'',$urlarr,'admin');
	        $rows=$this->get_page("resume_expect",$where,$pageurl,$this->config['sy_listnum'],'`id`,`uid`,`uname`,`job_classid`,`provinceid`,`cityid`');
	        foreach ($rows as $key=>$val){
	            $job_classid=explode(",",$val['job_classid']);
	            if(is_array($job_classid)){
	                foreach($job_classid as $val){
	                    $jobname[]=$job_name[$val];
	                }
	            }
	            $rows[$key]['job_name']=implode(",",$jobname);
	        }
	        $this->yunset('resumes',$rows);
	        $this->yuntpl(array('admin/admin_matching'));
	    }
	}
	function directrecom_action(){
	    if($_GET['eid']&&$_GET['uid']&&$_GET['id']&&$_GET['comid']){
	        $eid=intval($_GET['eid']);
			$uid=intval($_GET['uid']);
	        $id=intval($_GET['id']);
	        $comid=intval($_GET['comid']);
	        $row=$this->obj->DB_select_once("user_entrust_record","`jobid`='".$id."' and `eid`='".$eid."'");
	        if(!empty($row)){
	            $arr['msg']=iconv('gbk','utf-8','请勿重复推送！');
	            $arr['type']='8';
	        }else{
	            $linkmail=$this->obj->DB_select_once("company","`uid`='".$comid."'","`linkmail`,`uid`,`did`");
	            $id=$this->obj->DB_insert_once("user_entrust_record","`jobid`='".$id."',`eid`='".$eid."',`uid`='".$uid."',`comid`='".$comid."',`ctime`='".time()."',`did`='".$linkmail['did']."'");
	            if($id){
	               
	                   
					$contents=file_get_contents($this->config['sy_weburl']."/index.php?m=resume&c=sendresume&id=".$eid."&type=charge");

					$emailData['to'] = $linkmail['linkmail'];
					$emailData['subject'] = $this->config['sy_webname']."向您推荐了简历！";
					$emailData['content'] = $contents;
					$sendid = $this->sendemail($emailData);		

	                
	                $arr['msg']=iconv('gbk','utf-8','推送成功！');
	                $arr['type']='9';
	            }else{
	                $arr['msg']=iconv('gbk','utf-8','推送失败');
	                $arr['type']='8';
	            }
	        }
	        echo json_encode($arr);die;
	    }
	}
	function mintegral_action(){
	    include(CONFIG_PATH."db.data.php");
	    $this->yunset("arr_data",$arr_data);
	    $where='`com_id`='.intval($_GET['comid']).' and `type`=1';
	    $urlarr['c']='mintegral';
	    $urlarr['comid']=intval($_GET['comid']);
	    if($_GET['order']){
	        $where.=" order by ".$_GET['t']." ".$_GET['order'];
	        $urlarr['order']=$_GET['order'];
	        $urlarr['t']=$_GET['t'];
	    }else{
	        $where.=" order by id desc";
	    }
	    $urlarr["page"]="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $list=$this->get_page("company_pay",$where,$pageurl,$this->config['sy_listnum']);
	    $this->yunset("list",$list);
	    $this->yuntpl(array('admin/admin_company_mintegral'));
	}
	
	function morder_action(){
	    $search_list[]=array("param"=>"typezf","name"=>'支付类型',"value"=>array("alipay"=>"支付宝","tenpay"=>"财富通","bank"=>"银行转帐"));
	    $search_list[]=array("param"=>"typedd","name"=>'订单类型',"value"=>array("1"=>"会员充值","2"=>"".$this->config['integral_pricename']."充值","3"=>"银行转帐","4"=>"金额充值"));
	    $search_list[]=array("param"=>"order_state","name"=>'订单状态',"value"=>array("0"=>"支付失败","1"=>"等待付款","2"=>"支付成功","3"=>"等待确认"));
	    $lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
	    $search_list[]=array("param"=>"time","name"=>'充值时间',"value"=>$lo_time);
	    $this->yunset("search_list",$search_list);
	    $where='`uid`='.intval($_GET['comid']).'';
	    $urlarr['c']='morder';
	    $urlarr['comid']=intval($_GET['comid']);
		if($_GET['typezf']){
			$where .=" and `order_type`='".$_GET['typezf']."'";
			$urlarr['typezf']=$_GET['typezf'];
		}
		if($_GET['typedd']){
			$where .=" and `type`='".$_GET['typedd']."'";
			$urlarr['typedd']=$_GET['typedd'];
		}
		if (trim($_GET['keyword'])!=""){
			 $where .=" and `order_id` like '%".trim($_GET['keyword'])."%'";				   
		     $urlarr['keyword']=$_GET['keyword'];				 
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `order_time` >='".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `order_time`>'".strtotime('-'.intval($_GET['time']).' day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['order_state']!=""){
            $where.=" and `order_state`='".$_GET['order_state']."'";
			$urlarr['order_state']=$_GET['order_state'];
	    }
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		} 
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows=$this->get_page("company_order",$where,$pageurl,$this->config['sy_listnum']);
		include (APP_PATH."/config/db.data.php");
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$rows[$k]['order_state_n']=$arr_data['paystate'][$v['order_state']];
				$rows[$k]['order_type_n']=$arr_data['pay'][$v['order_type']];
				$classid[]=$v['uid'];
			}
			$group=$this->obj->DB_select_all("member","uid in (".@implode(",",$classid).")","`uid`,`username`");
			$company=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$classid).")","`uid`,`name`");
			$resume=$this->obj->DB_select_all("resume","`uid` in (".@implode(",",$classid).")","`uid`,`name`");
			foreach($rows as $k=>$v){
				foreach($company as $val){
					if($v['uid']==$val['uid']){
						$rows[$k]['comname']=$val['name'];
					}
				}				
				foreach($group as $val){
						if($v['uid']==$val['uid']){
							$rows[$k]['username']=$val['username'];
						}					
				}
				
				foreach($resume as $val){
					if($v['uid']==$val['uid']){
						$rows[$k]['comname']=$val['name'];
					}
				}
			}
		}
        $this->yunset("get_type", $_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_company_morder'));
	}
	function morderdel_action(){
	    $this->check_token();
	    if($_GET['del']){
	        $del=$_GET['del'];
	        if(is_array($del)){
	            $this->obj->DB_delete_all("company_order","`id` in(".@implode(',',$del).")","");
	            $this->layer_msg( "充值记录(ID:".@implode(',',$del).")删除成功！",9,1,$_SERVER['HTTP_REFERER']);
	        }else{
	            $this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	        }
	    }
	    if(isset($_GET['id'])){
	        $result=$this->obj->DB_delete_all("company_order","`id`='".$_GET['id']."'" );
	        isset($result)?$this->layer_msg('充值记录(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
	    }else{
	        $this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
	    }
	}
	function msetpay_action(){
	    $del=(int)$_GET['id'];
	    $this->check_token();
	    $row=$this->obj->DB_select_once("company_order","`id`='$del'");
	    if($row['order_state']=='1'||$row['order_state']=='3'){
	        $nid=$this->upuser_statis($row);
	        isset($nid)?$this->layer_msg("充值记录(ID:".$del.")确认成功！",9):$this->layer_msg("确认失败,请销后再试！",8);
	    }else{
	        $this->layer_msg("订单已确认，请勿重复操作！",8);
	    }
	}
	function morderedit_action(){
	    $id=(int)$_GET['id'];
	    $row=$this->obj->DB_select_once("company_order","`id`='".$id."'");
	    if(is_array($row)){
	        $member=$this->obj->DB_select_once('member',"`uid`='".$row['uid']."'","uid,username,usertype");
	        $row['username']=$member['username'];
	        	
	        if($member['usertype']=='1'){
	            $resume=$this->obj->DB_select_once("resume","`uid`='".$member['uid']."'","`uid`,`name`");
	            $row['comname']=$resume['name'];
	        }else if($member['usertype']=='2'){
	            $company=$this->obj->DB_select_once("company","`uid`='".$member['uid']."'","`uid`,`name`");
	            $row['comname']=$company['name'];
	        }
	        $orderbank=@explode("@%",$row['order_bank']);
	        if(is_array($orderbank)){
	            foreach($orderbank as $key){
	                $orderbank[]=$key;
	            }
	            $row['bankname']=$orderbank[0];
	            $row['bankid']=$orderbank[1];
	        }
	    }
	    
	    $this->yunset("row",$row);
	    $this->yuntpl(array('admin/admin_company_morder_edit'));
	}
	function mordersave_action(){
	   
	    if(is_uploaded_file($_FILES['order_pic']['tmp_name'])){
	        $upload=$this->upload_pic("../data/upload/order/");
	        $pictures=$upload->picture($_FILES['order_pic']);
	        $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
	        $pictures = str_replace("../data/upload/order","./data/upload/order",$pictures);
	    }else{
	        $order=$this->obj->DB_select_once("company_order","`id`='".(int)$_POST['id']."'");
	        $pictures=$order['order_pic'];
	    }
	    $r_id=$this->obj->DB_update_all("company_order","`order_price`='".$_POST['order_price']."',`order_remark`='".$_POST['order_remark']."',`order_pic`='".$pictures."'","id='".$_POST['id']."'");
	    isset($r_id)?$this->ACT_layer_msg("充值记录(ID:".$_POST['id'].")修改成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("修改失败,请销后再试！",8,$_SERVER['HTTP_REFERER']);
	}
	function morderadd_action(){
	    $comid=intval($_GET['comid']);
	    $member=$this->obj->DB_select_once("member","`uid`='".$comid."'",'username');
	    $this->yunset('user',array('uid'=>$comid,'username'=>$member['username']));
	    if(isset($_POST['insert'])){
	        $fsmsg=$_POST['fs']==1?"充值":"扣除";
	        $dingdan=mktime().rand(10000,99999);
	        $num=$_POST['price_int'];
	        $msg=$_POST['price_int'].$this->config['integral_pricename'];
	        $comid=intval($_POST['uid']);
	        if($_POST['fs']==1){
	            $type=true;
	            $integral_v="`integral`=`integral`+".$num."";
	            $_POST['order_type']="adminpay";
	            $data['type']=2;
	        }else{
	            $statis=$this->obj->DB_select_once('comstatis',"`uid`='".$comid."'","pay,integral");
	            if($statis['integral']<$num){
	                $num=$statis['integral'];
	            }
	            $type=false;
	            $integral_v="`integral`=`integral`-".$num."";
	            $data['order_type']="admincut";
	            $data['type']=5;
	        }
	        $data['order_id']=$dingdan;
	        $data['order_price']=$num/$this->config['integral_proportion'];
	        $data['order_time']=mktime();
	        $data['order_state']="2";
	        $data['order_remark']=$_POST['remark'];
	        $data['uid']=$comid;
	        $data['integral']=$num;
	        $nid=$this->obj->DB_update_all('company_statis',$integral_v,"`uid`='".$comid."'");
	        if($nid){
	            $this->insert_company_pay($num,2,$comid,$_POST['remark'],1,'',$type);
	            $nid=$this->obj->insert_into("company_order",$data);
	            $this->ACT_layer_msg("会员(ID:".$comid.")".$fsmsg.$msg."成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	        }else{
	            $this->ACT_layer_msg($fsmsg."失败！",8,$_SERVER['HTTP_REFERER']);
	        }
	    }
	    $this->yuntpl(array('admin/admin_company_morder_add'));
	}
	function mshow_action(){
	    $comid=intval($_GET['comid']);
	    $urlarr['c']="mshow";
	    $urlarr['comid']=$comid;
	    $urlarr["page"]="{{page}}";
	    $pageurl=Url($_GET['m'],$urlarr,'admin');
	    $this->get_page("company_show","`uid`='".$comid."' order by sort desc",$pageurl,"12","`title`,`id`,`picurl`,`uid`");
	    $this->yuntpl(array('admin/admin_company_mshow'));
	}
	
	function mshowdel_action(){
	    if($_GET['id']){
	        $row=$this->obj->DB_select_once("company_show","`id`='".(int)$_GET['id']."'","`picurl`");
	        if(is_array($row)){
	            unlink_pic(".".$row['picurl']);
	            $oid=$this->obj->DB_delete_all("company_show","`id`='".(int)$_GET['id']."'");
	        }
	        if($oid){
	            $this->layer_msg('删除成功！',9);
	        }else{
	            $this->layer_msg('删除失败！',8);
	        }
	    }
	}
	function mshowadd_action(){
	    $this->yuntpl(array('admin/admin_company_mshowadd'));
	}
	function mshowsave_action(){
	    if($_POST['submitbtn']){
	        $pid=pylode(',',$_POST['id']);
	        $comid=intval($_POST['comid']);
	        $company_show=$this->obj->DB_select_all("company_show","`id` in (".$pid.") and `uid`='".$comid."'","`id`");
	        if($company_show&&is_array($company_show)){
	            foreach($company_show as $val){
	                $title=$_POST['title_'.$val['id']];
	                $this->obj->update_once("company_show",array("title"=>trim($title)),array("id"=>(int)$val['id']));
	            }
	            $this->ACT_layer_msg("保存成功！",9,'index.php?m=admin_company&c=mshow&comid='.$comid);
	        }else{
	            $this->ACT_layer_msg("非法操作！",8,'index.php?m=admin_company&c=mshow&comid='.$comid);
	        }
	    }else{
	        $this->ACT_layer_msg("非法操作！",8,'index.php?m=admin_company&c=mshow&comid='.$comid);
	    }
	}
	function mshowedit_action(){
	    $picurl=$this->obj->DB_select_once("company_show","`id`='".(int)$_GET['id']."' and `uid`='".(int)$_GET['comid']."'","`picurl`,`title`,`sort`");
	    $this->yunset("picurl",$picurl);
	    $this->yuntpl(array('admin/admin_company_mshowedit'));
	}
	function mshowup_action(){
	    if($_POST['submitbtn']){
	        $time=time();
	        unset($_POST['submitbtn']);
	        if(!empty($_FILES['uplocadpic']['tmp_name'])){
	            $upload=$this->upload_pic("../data/upload/show/",false);
	            $uplocadpic=$upload->picture($_FILES['uplocadpic']);
	            $this->picmsg($uplocadpic,$_SERVER['HTTP_REFERER']);
	            $uplocadpic = str_replace("../data/upload/show","./data/upload/show",$uplocadpic);
	            $row=$this->obj->DB_select_once("company_show","`uid`='".(int)$_POST['uid']."' and `id`='".intval($_POST['id'])."'","`picurl`");
	            if(is_array($row)){
	                unlink_pic(".".$row['picurl']);
	            }
	        }else{
	            $uplocadpic=$_POST['picurl'];
	        }
	        $nid=$this->obj->DB_update_all("company_show","`picurl`='".$uplocadpic."',`title`='".$_POST['title']."',`sort`='".$_POST['showsort']."',`ctime`='".$time."'","`uid`='".(int)$_POST['uid']."'and `id`='".$_POST['id']."'");
	        if($nid){
	            $this->ACT_layer_msg("更新成功！",9,'index.php?m=admin_company&c=mshow&comid='.(int)$_POST['uid']);
	        }else{
	            $this->ACT_layer_msg("更新失败！",8,'index.php?m=admin_company&c=mshow&comid='.(int)$_POST['uid']);
	        }
	    }
	}
	function mcomtpl_action(){
	    $comid=intval($_GET['comid']);
	    $list=$this->obj->DB_select_all("company_tpl","`status`='1' and (`service_uid`='0' or FIND_IN_SET('".$comid."',service_uid)) order by id desc");
	    $this->yunset("list",$list);
		$this->yunset("comid",$comid);
	    $statis=$this->obj->DB_select_once("company_statis","`uid`='".$comid."'","`comtpl`");
	    $this->yunset('statis',$statis);
	    $this->yuntpl(array('admin/admin_company_mcomtpl'));
	}
	function msettpl_action(){
	    $this->check_token();
	    $tpl=$this->obj->DB_select_once("company_tpl","`id`='".intval($_GET['id'])."'","`url`");
	    $oid=$this->obj->update_once("company_statis",array("comtpl"=>$tpl['url']),array("uid"=>intval($_GET['comid'])));
	    if ($oid){
	        $this->layer_msg('设置成功！',9);
	    }else{
	        $this->layer_msg('设置失败！',9);
	    }
	}
	function guwen_action(){
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		
		$guweninfo=$this->obj->DB_select_all("company_consultant","`id`");
		$this->yunset($company);
		$this->yunset($guweninfo);
       
	}

	function reset_companypassword_action(){
		$this->check_token();
		$data['password']="123456";
		$data['uid']=$_GET['uid'];
		$this->uc_edit_pw($data,1,$_SERVER['HTTP_REFERER']);
		$this->admin_log("企业会员（ID:".$_GET['uid']."）重置密码成功");
		echo "1";
	}
}
?>