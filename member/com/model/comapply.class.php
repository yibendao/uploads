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
class comapply_controller extends company
{
	function index_action(){
		
		$this->job_cache();
		include APP_PATH."/plus/city.cache.php";
		include APP_PATH."/plus/com.cache.php";
		if($_POST['submit'])
		{
			$black=$this->obj->DB_select_once("blacklist","`p_uid`='".$this->uid."' and `c_uid`='".(int)$_POST['job_uid']."'");
			if(!empty($black))
			{
				$this->ACT_layer_msg("您已被该企业列入黑名单，不能评论该企业！",8,$_SERVER['HTTP_REFERER']);
			}
			if(trim($_POST['content'])==""){
				$this->ACT_layer_msg( "留言内容不能为空！",8,$_SERVER['HTTP_REFERER']);
			}
			$data['uid']=$this->uid;
			$data['username']=$this->username;
			$data['jobid']=(int)$_POST['jobid'];
			$data['job_uid']=(int)$_POST['job_uid'];
			$data['content']=trim($_POST['content']);
			$data['com_name']=trim($_POST['com_name']);
			$data['job_name']=trim($_POST['job_name']);
			$data['type']='1';
			$data['datetime']=mktime();
			$id=$this->obj->insert_into("msg",$data);
			isset($id)?$this->ACT_layer_msg( "留言成功，请等待回复！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg("留言失败！",8,$_SERVER['HTTP_REFERER']);
		}
		$comuid = $this->obj->DB_select_once("company_job","`id`='".(int)$_GET['id']."'","uid");
		$this->obj->DB_update_all("company_job","`jobhits`=`jobhits`+1","`id`='".(int)$_GET['id']."'");

		if($this->usertype=="1"){
			$look_job=$this->obj->DB_select_once("look_job","`uid`='".$this->uid."' and `jobid`='".(int)$_GET['id']."'");
			if(!empty($look_job))
			{
				$this->obj->DB_update_all("look_job","`datetime`='".time()."'","`uid`='".$this->uid."' and `jobid`='".(int)$_GET['id']."'");
			}else{
				$value.="`uid`='".$this->uid."',";
				$value.="`did`='".$this->userdid."',";
				$value.="`jobid`='".(int)$_GET['id']."',";
				$value.="`com_id`='".$comuid['uid']."',";
				$value.="`datetime`='".time()."'";
				$this->obj->DB_insert_once("look_job",$value);
			}
		}


		if($this->uid!=$comuid['uid'])
		{
			if($this->config['com_login_link']=="1")
			{
				if($this->uid=="" && $this->username=="")
				{
					$look_msg1="您还没有登录，登录后才能申请职位！";
					$look_msg="您还没有登录，登录后才可以查看联系方式！";
				}else{
					if($this->usertype!="1")
					{
						$look_msg="您不是个人用户，不能查看联系方式！";
						$look_msg1="您不是个人用户，不能申请职位！";
						$looktype="2";
					}

				}
			}else if($this->usertype!="1"){
				$look_msg1="您不是个人用户，不能申请职位！";
			}
			if($this->config['com_resume_link']=="1"&&$this->usertype=='1')
			{
				$row=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
				if($row<1){
					$url=$this->config['sy_weburl']."/member/index.php?c=expect&add=".$this->uid;
					$look_msg="您好，".$this->username."，您还没有创建简历，不能查看联系方式！请点击<a href='".$url."'>创建</a>，不要错过机会！";
					$useruid=$this->uid;
					$looktype="1";
					$this->yunset("useruid",$useruid);
				}
			}
			if($this->usertype=='1')
			{
				$userid_job=$this->obj->DB_select_once("userid_job","`uid`='".$this->uid."' and `job_id`='".(int)$_GET['id']."'","id");
				$this->yunset("userid_job",$userid_job['id']);
				$this->yunset("usertype",'1');
			}
		 }
        $job_id=$this->obj->DB_select_once("company_job","`id`='".(int)$_GET['id']."'","`uid`");
		
		 $n_com=$this->obj->DB_select_num("company_msg","`cuid`='".$job_id['uid']."'");
		$this->yunset("n_com",$n_com);
		
		$g_com=$this->obj->DB_select_once("company","`uid`='".$job_id['uid']."'","`ant_num`");
		$this->yunset("g_com",$g_com);
       
        $s_com=$this->obj->DB_select_num("userid_job","`com_id`='".$job_id['uid']."'");
		$this->yunset("s_com",$s_com);
		$is_atn = $this->obj->DB_select_once("atn","`sc_uid`='".$comuid['uid']."' and `uid`='".$this->uid."'","id");
		$this->yunset("comclass_name",$comclass_name);
		$this->yunset("is_atn",$is_atn);
		$this->yunset("looktype",$looktype);
		$this->yunset("look_msg",$look_msg);
		$this->yunset("look_msg1",$look_msg1);
		$this->seo("comapply");
		$this->yun_tpl(array('comapply'));		
	} 
}
?>