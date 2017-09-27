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
class look_job_controller extends company
{
	function index_action()
	{

		$this->public_action();
		$urlarr['c']='look_job';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("look_job","`com_id`='".$this->uid."' and `com_status`='0' order by datetime desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $v){
				$uid[]=$v['uid'];
				$jobid[]=$v['jobid'];
			}
			$resume=$this->obj->DB_select_all("resume","`uid` in (".pylode(",",$uid).")","`uid`,`name`,`edu`,`exp`,`def_job`");
            foreach($resume as $k=>$v){
                $EIDList[]=$v['def_job'];
            }
            $resume_expect=$this->obj->DB_select_all("resume_expect","`id` in (".pylode(",",$EIDList).")","`minsalary`,`maxsalary`,`uid`,job_classid");
			$job=$this->obj->DB_select_all("company_job","`id` in (".pylode(",",$jobid).")","`id`,`name`");
			$userid_msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' and `uid` in (".pylode(",",$uid).")","uid");
			include(PLUS_PATH."user.cache.php");
			include(PLUS_PATH."job.cache.php");
			foreach($rows as $key=>$val){
				foreach($resume as $va){
					if($val['uid']==$va['uid']){
						$rows[$key]['exp']=$userclass_name[$va['exp']];
						$rows[$key]['edu']=$userclass_name[$va['edu']];
                        $rows[$key]['minsalary']=$va['minsalary'];
                        $rows[$key]['maxsalary']=$va['maxsalary'];
                        $rows[$key]['name']=$va['name'];
						
					}
				}
                foreach($resume_expect as $va){
					if($val['uid']==$va['uid']){
                        $rows[$key]['minsalary']=$va['minsalary'];
                        $rows[$key]['maxsalary']=$va['maxsalary'];
                        if($va['job_classid']!=""){
                        	$job_classid=@explode(',',$va['job_classid']);
                        	$rows[$key]['jobclassidname']=$job_name[$job_classid['0']];
                        }
					}
				}
				foreach($job as $va){
					if($val['jobid']==$va['id']){
						$rows[$key]['jobname']=$va['name'];
					}
				}
				foreach($userid_msg as $va){
					if($val['uid']==$va['uid']){
						$rows[$key]['userid_msg']=1;
					}
				}
			}
		}
		$JobM=$this->MODEL("job");
		$company_job=$JobM->GetComjobList(array("uid"=>$this->uid,"state"=>1,"`edate`>'".time()."' and `r_status`<>'2' and `status`<>'1'"),array("field"=>"`name`,`id`"));
		$this->yunset("company_job",$company_job);
		$this->yunset("rows",$rows);
		$this->yunset("js_def",5);
		$this->com_tpl('look_job');
	}
	function del_action(){
		if($_POST['delid']||$_GET['id']){
			if(is_array($_POST['delid'])){
				$delid=pylode(",",$_POST['delid']);
				$layer_type='1';
			}else{
				$delid=(int)$_GET['id'];
				$layer_type='0';
			}
			$nid=$this->obj->DB_update_all("look_job","`com_status`='1'","`id` in (".$delid.") and `com_id`='".$this->uid."'"," ");
			if($nid)
			{
				$this->obj->member_log("删除已浏览简历记录（ID:".$delid."）");
				$this->layer_msg('删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
			}
		}
	}
}
?>