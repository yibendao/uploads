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
class partok_controller extends company{
	function index_action(){
		$this->public_action();
		include PLUS_PATH."part.cache.php";
		$urlarr=array("c"=>"partok","page"=>"{{page}}");
		if($_GET["w"]>=0){
			$where .= " and `state`='".$_GET['w']."'";
			$urlarr['w']=$_GET['w'];
		}else{
			$where .= " and `edate`<'".time()."'";
			$urlarr['w']=0;
		}
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("partjob","`uid`='".$this->uid."' ".$where,$pageurl,'10');
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$rows[$k]['salary_type']=$partclass_name[$v['salary_type']];
				$rows[$k]['type']=$partclass_name[$v['type']];
				if(intval($_GET['w'])==1){
					$rows[$k]['applynum']=$this->obj->DB_select_num("part_apply","`jobid`='".$v['id']."'");
				}
			}
		}
		$urgent=$this->config['com_urgent'];
		$this->yunset("rows",$rows);
		$this->company_satic();
		$this->yunset("js_def",3);
		if(intval($_GET['w'])==1){
			$this->com_tpl('part');
		}else{
			$this->com_tpl('partok');
		}
	}
	function opera_action(){
		$this->part();
	}
}
?>