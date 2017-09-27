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
class resume_controller extends common{
	function index_action(){
		$this->rightinfo();
		$this->get_moblie();
		$CacheM=$this->MODEL('cache');
        $CacheArr=$CacheM->GetCache(array('user','job','city','hy'));
        $uptime=array(1=>'今天',3=>'最近3天',7=>'最近7天',30=>'最近一个月',90=>'最近三个月');
        $this->yunset("uptime",$uptime);
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		if($_GET['jobin']){
			$job_classid=@explode(',',$_GET['jobin']);
			$jobname=$CacheArr['job_name'][$job_classid[0]];
			$this->yunset("jobname",mb_substr($jobname,0,6,'gbk'));
		}
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		
		$down=$this->obj->DB_select_all('down_resume','comid='.$this->uid.'','eid');
		foreach ($down as $v){
		    $eid[]=$v['eid'];
		}
		$this->yunset('eid',$eid);
		$searchurl=@implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);
		$this->yunset('backurl',Url('wap'));
		$this->yunset($CacheArr);
		$this->yunset("headertitle","找人才");
		$this->yunset("topplaceholder","请输入简历关键字,如：服务员...");
		$this->seo("user_search");
		$this->yuntpl(array('wap/resume'));
	}
	function search_action(){
		$this->index_action();
	}
	function show_action(){
		$this->rightinfo();
		$this->get_moblie();
		$ResumeM=$this->MODEL('resume');
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		if((int)$_GET['uid']){
			if((int)$_GET['type']=="2"){
				$user=$ResumeM->GetResumeExpectOne(array("uid"=>(int)$_GET['uid'],"height_status"=>'2'));
				$id=$user['id'];
			}else{
				$def_job=$ResumeM->SelectResumeOne(array("uid"=>(int)$_GET['uid'],"`r_status`<>'2'"));
				$id=$def_job['def_job'];
			}
		}else{
			$id=(int)$_GET['id'];
		}
		$user=$ResumeM->resume_select((int)$_GET['id']);
		$euid=$this->obj->DB_select_once("resume_expect","`id`='".(int)$_GET['id']."'","`uid`");
		$talent_pool=$this->obj->DB_select_num("talent_pool","`eid`='".(int)$_GET['id']."'and `cuid`='".$this->uid."'");
		$userid_msg=$this->obj->DB_select_num("userid_msg","`uid`='".$euid['uid']."'and `fid`='".$this->uid."'");
		$user['talent_pool']=$talent_pool;
		$user['userid_msg']=$userid_msg;
		$user['euid']=$euid;
		
        if($this->usertype=="2" ){
			$this->yunset("uid",$this->uid);
			$ResumeM->RemindDeal("userid_job",array("is_browse"=>"2"),array("com_id"=>$this->uid,"eid"=>(int)$_GET['id']));

			$look_resume=$ResumeM->SelectLookResumeOne(array("com_id"=>$this->uid,"resume_id"=>$id));
			if(!empty($look_resume)){
				$ResumeM->SaveLookResume(array("datetime"=>time()),array("resume_id"=>$id,"com_id"=>$this->uid));
			}else{
				$ResumeM->AddExpectHits($id);
				$data['uid']=$user['uid'];
				$data['resume_id']=$id;
				$data['com_id']=$this->uid;
				$data['did']=$this->userdid;
				$data['datetime']=time();
				$ResumeM->SaveLookResume($data);
			}
        }
		$data['resume_username']=$user['username_n'];
		$data['resume_city']=$user['city_one'].",".$user['city_two'];
		$data['resume_job']=$user['hy'];
		$this->data=$data;
		$this->seo("resume");
		$this->yunset("Info",$user);
		$this->yunset("headertitle","找人才");
		$this->yunset("shareurl",Url('wap',array('c'=>'resume','a'=>'share','id'=>(int)$_GET['id'])));
		$this->yuntpl(array('wap/resume_show'));
	}
	function share_action(){
		$this->get_moblie();
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		$ResumeM=$this->MODEL('resume');
		$user=$ResumeM->resume_select((int)$_GET['id']);
		$user['sex']=$arr_data['sex'][$user['sex']];
		$this->yunset("Info",$user);
		$this->yunset("headertitle",$user['name']."-$user[jobname]-$user[city_one]$user[city_two]$user[city_three]".$this->config['sy_webname']);
		$this->yunset("resume_style",$this->config['sy_weburl']."/app/template/wap/resume");
		$this->yuntpl(array('wap/resume/index'));
	}
	function invite_action(){
		$this->get_moblie();
		$rows=$this->obj->DB_select_all("company_job","`uid`='".$this->uid."'");
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`linktel`,`linkman`,`address`");
		
		$inviteInfo = $this->obj->DB_select_once("userid_msg","`fid`='".$this->uid."' AND `intertime`<>''");
		$this->yunset("inviteinfo",$inviteInfo);
		
		$this->yunset("joblist",$rows);
		$this->yunset("com",$com);
		$this->yunset("cuid",$this->uid);
		$this->seo('invite_resume');
		$this->yunset("headertitle","面试邀请");
		$this->yuntpl(array('wap/invite'));
	}
}
?>