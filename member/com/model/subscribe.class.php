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
class subscribe_controller extends company{
	function index_action(){ 
		$urlarr=array("c"=>"subscribe","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("subscribe","`uid`='".$this->uid."' and `type`='2' order by id desc",$pageurl,"20"); 
		if($rows&&is_array($rows)){
			include(PLUS_PATH."job.cache.php");
			include(PLUS_PATH."city.cache.php");
			include(PLUS_PATH."user.cache.php");
			foreach($rows as $key=>$val){
				$jobname=$cityname=array();
				$jobname[]=$job_name[$val['job1']];
				$jobname[]=$job_name[$val['job1_son']];
				if($job_name[$val['job_post']]){$jobname[]=$job_name[$val['job_post']];}
				$cityname[]=$city_name[$val['provinceid']];
				if($city_name[$val['cityid']]){$cityname[]=$city_name[$val['cityid']];}
				if($city_name[$val['three_cityid']]){$cityname[]=$city_name[$val['three_cityid']];} 
				
				$rows[$key]['jobname']=@implode(',',$jobname);
				$rows[$key]['city_name']=@implode('-',$cityname);
				$rows[$key]['minsalary']=$val['minsalary'];
				$rows[$key]['maxsalary']=$val['maxsalary'];
			}
		}
		$this->yunset("rows",$rows);
		$this->public_action();
		$this->yunset("js_def",5);
		$this->com_tpl('subscribe');
	}
	function record_action(){
		$urlarr=array("c"=>"subscribe","act"=>"record","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("subscriberecord","`uid`='".$this->uid."' and `type`='2' order by id desc",$pageurl,"20"); 
		$this->yunset("rows",$rows);
		$this->public_action();
		$this->yunset("js_def",5);
		$this->com_tpl('subscriberecord');
	}  
	function del_action(){
		if($_POST['delid']||$_GET['id']){
			if(is_array($_POST['delid'])){
				$del=pylode(",",$_POST['delid']);
				$layer_type=1;
			}else{
				$del=(int)$_GET['id'];
				$layer_type=0;
			}
			$this->obj->DB_delete_all("subscribe","`id` in (".$del.") and `uid`='".$this->uid."'"," ");
			$this->obj->DB_delete_all("subscriberecord","`sid` in (".$del.") and `uid`='".$this->uid."'"," ");
			$this->obj->member_log("删除订阅（ID:".$del."）");
 			$this->layer_msg('删除成功！',9,$layer_type,"index.php?c=subscribe");
		}
	}
}
?>