<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2017 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class jobadd_controller extends company{
	function index_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$statics = $this->company_satic();
		if( $statics['addjobnum'] == 2){
			if(intval($statics['integral']) < intval($this->config['integral_job'])){
				$this->ACT_msg($_SERVER['HTTP_REFERER'],"你的".$this->config['integral_pricename']."不够发布职位！",8);
			}
		}
		$company=$this->get_user();
		$msg=array();
		$isallow_addjob="1";
		$url="index.php?c=binding";
		if($this->config['com_enforce_emailcert']=="1"){
			if($company['email_status']!="1"){
				$isallow_addjob="0";
				$msg[]="邮箱认证";
			}
		}
		if($this->config['com_enforce_mobilecert']=="1"){
			if($company['moblie_status']!="1"){
				$isallow_addjob="0";
				$msg[]="手机认证";
			}
		}
		if($this->config['com_enforce_licensecert']=="1"){
			if($company['yyzz_status']!="1"){
				$isallow_addjob="0";
				$msg[]="营业执照认证";
			}
		}
		if($isallow_addjob=="0"){
			$this->ACT_msg($url,"请先完成".implode("、",$msg)."！");
		}
		if($this->config['com_enforce_setposition']=="1"){
			if(empty($company['x'])||empty($company['y'])){
				$this->ACT_msg("index.php?c=map","请先完成地图设置！");
			}
		}
		$save=$this->obj->DB_select_once("lssave","`uid`='".$this->uid."'and `savetype`='4'");
		$save=unserialize($save['save']);
		if($save['lastupdate']){
			$save['time']=date('H:i',ceil(($save['lastupdate'])));
		}
		$this->yunset("save",$save);
		$this->public_action();
		$CacheArr=$this->MODEL('cache')->GetCache(array('hy','job','city','com','circle'));
        $this->yunset($CacheArr);
		$row['hy']=$company['hy'];
		$row['sdate']=mktime();
		$row['edate']=strtotime("+1 month");
		$row['number']=$CacheArr['comdata']['job_number'][0];
		$row['type']=$CacheArr['comdata']['job_type'][0];
		$row['exp']=$CacheArr['comdata']['job_exp'][0];
		$row['report']=$CacheArr['comdata']['job_report'][0];
		$row['age']=$CacheArr['comdata']['job_age'][0];
		$row['edu']=$CacheArr['comdata']['job_edu'][0];
		$row['marriage']=$CacheArr['comdata']['job_marriage'][0]; 
		$this->yunset("company",$company); 
		$jobnum=$this->obj->DB_select_num("company_job","`uid`='".$this->uid."'");
		$this->yunset("jobnum",$jobnum);
		$this->yunset("row",$row);
		$this->yunset("today",date('Y-m-d',time()));
		$this->yunset("js_def",3);
		$this->com_tpl('jobadd');
	}
	function edit_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$statics = $this->company_satic();
		if($_GET['id']){
			$id=(int)$_GET['id'];
		}else{
			if($_GET['jobcopy']){ 
				if( $statics['addjobnum'] == 2){
					if(intval($statics['integral']) < intval($this->config['integral_job'])){
						$this->ACT_msg($_SERVER['HTTP_REFERER'],"你的".$this->config['integral_pricename']."不够发布职位！",8);
					}
				}
			}
			$id=(int)$_GET['jobcopy'];
		}
		$row=$this->obj->DB_select_once("company_job","`id`='".$id."' and `uid`='".$this->uid."'");
		$lang[] = @explode(',',$row['lang']);
		if($lang){
			foreach($lang as $key=>$val){
				$row['lang']=$val;
			}
		}
		$welfare[] = @explode(',',$row['welfare']);
		if($welfare){
			foreach($welfare as $key=>$val){
				$row['welfare']=$val;
			}
		}
		$company=$this->get_user();
		if($company['linktel']==''&&$company['linkphone']){
			$company['linktel']=$company['linkphone'];
		}
		$row['days']= ceil(($row['edate']-$row['sdate'])/86400);
        $this->yunset($this->MODEL('cache')->GetCache(array('hy','job','city','com','circle')));
		if($row['three_cityid']){
			$row['circlecity']=$row['three_cityid'];
		}else if($row['cityid']){
			$row['circlecity']=$row['cityid'];
		}else if($row['provinceid']){
			$row['circlecity']=$row['provinceid'];
		} 
		if($row['autotime']>time()){
			$row['autodate']=date("Y-m-d",$row['autotime']);
		}
		$job_link=$this->obj->DB_select_once("company_job_link","`jobid`='".$id."' and `uid`='".$this->uid."'");
		$this->yunset("job_link",$job_link); 
		$row['islink']=$job_link['link_type'];
		$row['isemail']=$job_link['email_type'];
		$this->public_action();
		$this->yunset("statis",$statics); 
		$this->yunset("company",$company);		
		$this->yunset("row",$row);
		$this->yunset("js_def",3);
		$this->com_tpl('jobadd');
	}
	function save_action(){
		if($_POST['submitBtn']){
			$id=intval($_POST['id']);
			if($id){
				$row=$this->obj->DB_select_once("company_job","`id`='".$id."' and `uid`='".$this->uid."'","`state`,`sdate`,`id`");
			}
			$state= intval($_POST['state']);
			unset($_POST['submitBtn']);
			unset($_POST['id']);
			unset($_POST['state']);
			$_POST['lastupdate']=mktime();
			$_POST['description'] = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['description'],ENT_QUOTES,"GB2312"));
			$comjob=$this->obj->DB_select_all("company_job","`uid`='".$this->uid."' and `name`='".$_POST['name']."'","`id`");
			if($comjob['id']!=$id&&$id&&$$comjob['id']){
				$this->ACT_layer_msg("职位名称已存在！",8);
			}

			$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'","status");
			if($member['status']!="1"){
			   $_POST['state']=0;
			}else{
			   $_POST['state']=$this->config['com_job_status'];
			}

			if($this->config['com_job_status']=="0"){
				$msg="等待审核！";
			}
			if($_POST['job_post']){
				$row1=$this->obj->DB_select_once("job_class","`id`='".intval($_POST['job_post'])."'","`keyid`");
				$row2=$this->obj->DB_select_once("job_class","`id`='".$row1['keyid']."'","`keyid`");
				if($row2['keyid']=='0'){
					$_POST['job1_son']=$_POST['job_post'];
					$_POST['job1']=$row1['keyid'];
					unset($_POST['job_post']);
				}else{
					$_POST['job1_son']=$row1['keyid'];
					$_POST['job1']=$row2['keyid'];
				}
			}
			
			$CacheList=$this->MODEL('cache')->GetCache(array('com'));
			$lang=array();
			foreach($CacheList['comdata']['job_lang'] as $k=>$v){
				if(intval($_POST['lang'.$v])==$v){
					$lang[]=$v;
				}
			}
			if(!empty($lang)){
				$_POST['lang'] = pyLode(',',$lang);
			}else{
				$_POST['lang'] = '';
			}
			$welfare=array();
			foreach($CacheList['comdata']['job_welfare'] as $k=>$v){
				if(intval($_POST['welfare'.$v])!=''){
					$welfare[]=$v;
				}
			}
			if(!empty($welfare)){
				$_POST['welfare'] =pyLode(',',$welfare);
			}else{
				$_POST['welfare'] = '';
			}
			if(intval($_POST['days'])&&$_POST['days_type']==''){
				if(intval($_POST['days'])>999){
					$_POST['days']=999;
				}
				if($row['sdate']){
					$_POST['edate']=$row['sdate']+(int)trim($_POST['days'])*86400;
				}else{
					$_POST['edate']=time()+(int)trim($_POST['days'])*86400;
				}
				unset($_POST['days']);
			}else if($_POST['days_type']){
				unset($_POST['days_type']);unset($_POST['days']);
				$_POST['edate']=strtotime($_POST['edate']." 23:59:59");
			}
			if($_POST['edate']<time()){
				$this->ACT_layer_msg("结束时间小于当前日期！",8,$_SERVER['HTTP_REFERER']);
			}
			if((int)$_POST['islink']=='2'&&($_POST['link_man']==''||$_POST['link_moblie']=='')){ 
				$this->ACT_layer_msg("联系人、联系电话均不能为空！",8); 
			}
			
			if((int)$_POST['isemail']=='2'){
				if($_POST['email']==''){
					$this->ACT_layer_msg("请输入新联系邮箱！",8);
				}else if($this->CheckRegEmail($_POST['email'])==false){
					$this->ACT_layer_msg("新联系邮箱格式错误！",8);
				}
			}
			$_POST['xuanshang']=intval($_POST['xuanshang']);
			if(!$_POST['xuanshang']){
				$_POST['xuanshang']='0';
			}
			$satic=$this->company_satic();
			$company=$this->get_user();
			$_POST['com_name']=$company['name'];
			$_POST['com_logo']=$company['logo'];
			$_POST['com_provinceid']=$company['provinceid'];
			$_POST['pr']=$company['pr'];
			$_POST['mun']=$company['mun'];
			$_POST['rating']=$satic['rating'];
			$islink=(int)$_POST['islink'];
			$link_type=$islink;
			if($islink<3){
			    $linktype=$islink;
				$islink=1;
			}else{
				$islink=0;
			} 
			$isemail=(int)$_POST['isemail'];
			$emailtype=$isemail;
			if($isemail<3){
				$isemail=1;
			}else{
				$isemail=0;
			}  
			if($_POST['salary_type']){
				$_POST['minsalary']=$_POST['maxsalary']=0;
			}
			$_POST['is_link']=$islink;
			$_POST['link_type']=$linktype;
			$_POST['is_email']=$isemail;
			$link_moblie=$_POST['link_moblie'];
			$email=$_POST['email'];
			$link_man=$_POST['link_man'];
			unset($_POST['link_moblie']); 
			unset($_POST['islink']);
			unset($_POST['isemail']);
			unset($_POST['link_man']);
			unset($_POST['email']);
			if(!$id||intval($_POST['jobcopy'])==$id){
				$_POST['sdate']=mktime();
				$_POST['uid']=$this->uid;
				$_POST['did']=$this->userdid;
				$this->get_com(1,$satic);
				$nid=$this->obj->insert_into("company_job",$_POST);
				$name="添加职位";
				$type='1';
				if($nid){
					$this->obj->DB_delete_all("lssave","`uid`='".$this->uid."'and `savetype`='4'");
					$this->obj->DB_update_all("company","`jobtime`='".$_POST['lastupdate']."'","`uid`='".$this->uid."'");
					$state_content = "发布了新职位 <a href=\"".$this->config['sy_weburl']."/index.php?m=job&c=comapply&id=$nid\" target=\"_blank\">".$_POST['name']."</a>。";
					$this->addstate($state_content,2);
				}
			}else{
				$where['id']=$id;
				$where['uid']=$this->uid;
				if($row['state']=='1'||$row['state']=='2'){
					$this->get_com(2,$satic);
				}
				$nid=$this->obj->update_once("company_job",$_POST,$where);
				$name="更新职位";
				$type='2';
				if($nid){
					$this->obj->DB_update_all("company","`lastupdate`='".$_POST['lastupdate']."'","`uid`='".$this->uid."'");
				}
			} 
			$joblink=array();
			$joblink[]="`email`='".trim($email)."',`is_email`='".$isemail."',`email_type`='".$emailtype."'";
			if($linktype==2){
				$joblink[]="`link_man`='".$link_man."',`link_moblie`='".$link_moblie."'";
			}
			if ($link_type){
			    $joblink[]="`link_type`='".$link_type."'";
			}
			if($id){
				delfiledir("../data/upload/tel/".$this->uid);
				$linkid=$this->obj->DB_select_once("company_job_link","`uid`='".$this->uid."' and `jobid`='".$id."'","id");
				if($linkid['id']){
					$this->obj->DB_update_all("company_job_link",@implode(',',$joblink),"`id`='".$linkid['id']."'");
				}else{
					$joblink[]="`uid`='".$this->uid."',`jobid`='".(int)$id."'";
					$this->obj->DB_insert_once("company_job_link",@implode(',',$joblink));
				}
			}else if($nid>0){
				$joblink[]="`uid`='".$this->uid."',`jobid`='".(int)$nid."'";
				$this->obj->DB_insert_once("company_job_link",@implode(',',$joblink));
			}
			if($nid && $_POST['xuanshang']){
				$nid=$this->company_invtal($this->uid,$_POST['xuanshang'],false,"发布竟价职位",true,2,'integral',11);
			}
			if($nid){
				$this->obj->member_log($name."《".$_POST['name']."》",1,$type);
				if($id==''){
					$this->ACT_layer_msg($name."成功！",9,$nid);
				}else{
					$this->ACT_layer_msg($name."成功！",9,$id);
				} 
			}else{
				$this->ACT_layer_msg($name."失败！",8,$_SERVER['HTTP_REFERER']);
			}
		}
	}
}
?>