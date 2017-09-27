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
class expectq_controller extends user{
	function index_action(){
		$this->get_user();
		$num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
		if($num>=$this->config['user_number']&&$_GET['e']==''){
			$this->ACT_msg("index.php?c=resume","你的简历数已经超过系统设置的简历数了");
		}
		$row=$this->obj->DB_select_alls("resume_expect","resume_doc","a.`uid`='".$this->uid."' and a.`id`='".(int)$_GET['e']."' and a.`id`=b.eid");
		$this->yunset("row",$row[0]);

		if($row[0]['job_classid']){
			include PLUS_PATH."/job.cache.php";
			$job_classid=@explode(",",$row[0]['job_classid']);
			if(is_array($job_classid)){
				foreach($job_classid as $key){
					$job_classname[]=$job_name[$key];
				}
				$this->yunset("job_classname",pylode('+',$job_classname));
			}
			$this->yunset("job_classid",$job_classid);
		}
        $this->yunset($this->MODEL('cache')->GetCache(array('city','hy')));
		$this->user_cache();
		$this->yunset("js_def",2);
		$this->user_tpl('expectq');
	}
	function save_action(){
		if($_POST['submit']){
		    $_POST=$this->post_trim($_POST);
			$eid=(int)$_POST['eid'];
			$data['doc']=str_replace("&amp;","&",html_entity_decode($_POST['doc'],ENT_QUOTES,"GB2312"));
			$_POST['lastupdate']=mktime();
			$_POST['integrity']=100;
			unset($_POST['eid']);
			unset($_POST['submit']);
			unset($_POST['doc']);
			if(!$eid){
				$num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
				if($num>=$this->config['user_number']&&$_GET['e']==''){
					$this->ACT_msg("index.php?c=resume","你的简历数已经超过系统设置的简历数了");
				} 
				$_POST['doc']='1';
				$_POST['uid']=(int)$this->uid;
				$_POST['did']=(int)$this->userdid;
				$_POST['defaults']=$num<=0?1:0;
				$nid=$this->obj->insert_into("resume_expect",$_POST);

				if($nid){
					$num=$this->obj->DB_select_num("company_pay","`com_id`='".$this->uid."' AND `pay_remark`='发布简历'");
					if($num<1){
						$this->get_integral_action($this->uid,"integral_add_resume","发布简历");
					}
					$resume = $this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`name`,`edu`,`exp`,`sex`,`birthday`,`idcard_status`,`status`,`r_status`");
					
					$this->obj->update_once("resume_expect",array(
							"edu"=>$resume['edu'],
							"exp"=>$resume['exp'],
							"uname"=>$resume['name'],
							"sex"=>$resume['sex'],
							"birthday"=>$resume['birthday'],
							"idcard_status"=>$resume['idcard_status'],
							"status"=>$resume['status'],
							"r_status"=>$resume['r_status'],
							"photo"=>$resume['photo']
							),array('uid'=>$this->uid));
	
					$data['eid']=(int)$nid;
					$data['uid']=(int)$this->uid;
					$nid2=$this->obj->insert_into("resume_doc",$data);
					$resumearr=array(
						'lastupdate'=>time()
					);
					if($nid2){
						if($num==0){
							$resumearr['def_job']=$nid;
							
	 					}
						$nid2=$this->obj->DB_update_all("member_statis","`resume_num`=`resume_num`+1","uid='".$this->uid."'");
					}
					$this->obj->update_once('resume',$resumearr,array('uid'=>$this->uid));
				}
				if($nid2)
				{
					$this->obj->member_log("添加粘贴简历",2,1);
					$this->ACT_layer_msg("添加成功！",9,"index.php?c=resume");
				}else{
					$this->ACT_layer_msg("添加失败！",8,"index.php?c=resume");
				}
			}else{
				$_POST['height_status']='0';
				$this->obj->update_once("resume_expect",$_POST,array("id"=>$eid));
				$nid=$this->obj->update_once("resume_doc",$data,array("uid"=>$this->uid,"eid"=>$eid));
				if($nid){
					$this->obj->update_once('resume',array('lastupdate'=>time()),array('uid'=>$this->uid));
					$this->obj->member_log("更新粘贴简历",2,2);
					$this->ACT_layer_msg("更新成功！",9,"index.php?c=resume");
				}else{
					$this->ACT_layer_msg("更新失败！",8,"index.php?c=resume");
				}
 			}
		}
	}
}
?>