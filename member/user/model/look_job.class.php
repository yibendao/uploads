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
class look_job_controller extends user{
	function index_action(){
		$urlarr=array("c"=>"look_job","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$look=$this->get_page("look_job","`uid`='".$this->uid."' and `status`='0' order by `datetime` desc",$pageurl,"10");
		if(is_array($look)){
			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/com.cache.php";
			foreach($look as $v){
				$jobid[]=$v['jobid'];
			}
			$job=$this->obj->DB_select_all("company_job","`id` in (".pylode(",",$jobid).")","`id`,`name`,`com_name`,`minsalary`,`maxsalary`,`provinceid`,`cityid`,`status`,`edate`");
			foreach($look as $k=>$v){
				foreach($job as $val){
					if($v['jobid']==$val['id']){
						if($val['status']=="1"){
							$look[$k]['status']="已下架招聘";
						}elseif($val['edate']<time()){
							$look[$k]['status']="已过期";
						}else{
							$look[$k]['status']="正在招聘";
						}
						$look[$k]['jobname']=$val['name'];
						$look[$k]['comname']=$val['com_name'];
						$look[$k]['minsalary']=$val['minsalary'];
						$look[$k]['maxsalary']=$val['maxsalary'];
						$look[$k]['provinceid']=$city_name[$val['provinceid']];
						$look[$k]['cityid']=$city_name[$val['cityid']];
					}
				}
			}
		}
		$this->yunset("js_def",2);
		$this->yunset("look",$look);
		$this->public_action();
		$this->user_tpl('look_job');
	}
	function del_action(){
		if($_GET['del']||$_GET['id']){
			if(is_array($_GET['del'])){
				$del=pylode(",",$_GET['del']);
				$layer_type=1;
			}else{
				$del=(int)$_GET['id'];
				$layer_type=0;
			}
			$this->obj->DB_update_all("look_job","`status`='1'","`id` in (".$del.") and `uid`='".$this->uid."'");
			$this->obj->member_log("删除职位浏览记录（ID:".$del."）");
 			$this->layer_msg('删除成功！',9,$layer_type,"index.php?c=look_job");
		}
	}
}
?>