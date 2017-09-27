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
class partapply_controller extends user{
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"partapply","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("part_apply","`uid`='".$this->uid."' order by id desc",$pageurl,"20");
		if($rows&&is_array($rows)){
			include PLUS_PATH."part.cache.php";
			foreach($rows as $val){
				$jobids[]=$val['jobid'];
			}
			$joblist=$this->obj->DB_select_all("partjob","`id` in(".pylode(',',$jobids).")");
			foreach($rows as $key=>$val){
				foreach($joblist as $v){
					if($val['jobid']==$v['id']){
						$rows[$key]['comid']=$val['comid'];
						$rows[$key]['jobname']=$v['name'];
						$rows[$key]['com_name']=$v['com_name'];
						$rows[$key]['salary']=$v['salary'].$partclass_name[$v['salary_type']];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$StateList=array("1"=>"未查看","2"=>"已查看","3"=>"已联系");
		$this->yunset("StateList",$StateList);
		$this->user_tpl('partapply');
	}
	function del_action(){
		if($_GET['id']){
			$del=(int)$_GET['id'];
			$nid=$this->obj->DB_delete_all("part_apply","`id`='".$del."' and `uid`='".$this->uid."'");
			if($nid){
				$this->obj->member_log("删除兼职报名",5,3);
				$this->layer_msg('删除成功！',9,0,"index.php?c=partapply");
			}else{
				$this->layer_msg('删除失败！',8,0,"index.php?c=partapply");
			}
		}
	}
}
?>