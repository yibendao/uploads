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
class invite_controller extends company
{
	function index_action(){
		if(trim($_GET['keyword'])){
			$resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and a.`r_status`<>'2' and a.`name` like '%".trim($_GET['keyword'])."%' and a.`def_job`=b.`id`","a.`name`,a.`uid`,a.`sex`,a.`edu`,b.`job_classid`,a.`exp`,b.`salary`"); 
			if(is_array($resume)){
				foreach($resume as $v){
					$uidarr[]=$v['uid'];
				}
			}
			$where="uid in (".pylode(',',$uidarr).") and ";
			$urlarr['keyword']=trim($_GET['keyword']);
		}
		$this->public_action();
		$urlarr['c']='invite';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("userid_msg",$where." `fid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows) && !empty($rows)){
			if(empty($resume)){
				foreach($rows as $v){
					$uid[]=$v['uid'];
				}
				$where="a.`uid` in (".pylode(",",$uid).") and a.`r_status`<>'2' and a.`def_job`=b.`id`";
				$resume=$this->obj->DB_select_alls("resume","resume_expect",$where,"a.`uid`,a.`name`,a.`sex`,a.`edu`,a.`exp`,b.`salary`,b.`job_classid`");
			}
			if(is_array($resume)){
				include(PLUS_PATH."user.cache.php");
				include(PLUS_PATH."job.cache.php");
				foreach($resume as $va){
					if($va['job_classid']!=""){
						$job=@explode(",",$va['job_classid']);
						$user[$va['uid']]['jobname']=$job_name[$job[0]];
					}
					$user[$va['uid']]['name']=$va['name'];
					$user[$va['uid']]['sex']=$va['sex'];
					$user[$va['uid']]['edu']=$userclass_name[$va['edu']];
                    $user[$va['uid']]['exp']=$userclass_name[$va['exp']];
                    $user[$va['uid']]['salary']=$userclass_name[$va['salary']];
				}
			}
			$this->yunset("user",$user);
		}
		$this->public_action();
		$this->company_satic();
		$this->yunset("js_def",5);
		$this->com_tpl('invite');
	}
	function del_action(){
		if($_POST['delid'] || $_GET['id']){
			if($_GET['id']){
				$id=(int)$_GET['id'];
				$layer_type='0';
			}else{
				$id=pylode(",",$_POST['delid']);
				$layer_type='1';
			}
			$nid=$this->obj->DB_delete_all("userid_msg","`id` in (".$id.") and `fid`='".$this->uid."'"," ");
			if($nid)
			{
				$this->obj->member_log("删除已邀请面试的人才",4,3);
				$this->layer_msg('删除成功！',9,$layer_type,"index.php?c=invite");
			}else{
				$this->layer_msg('删除失败！',8,$layer_type,"index.php?c=invite");
			}
		}
	}
}
?>