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
class atn_controller extends user{
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"atn","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("atn","`uid`='".$this->uid."' and `sc_usertype`='2' order by `id` desc",$pageurl,"10");
		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$uids[]=$val['sc_uid'];
			}
			$job=$this->obj->DB_select_all("company_job","`uid` in(".pylode(',',$uids).")and `status`<>1","`uid`,`name`,`id`");
			$company=$this->obj->DB_select_all("company","`uid` in(".pylode(',',$uids).")","`uid`,`name`");
			foreach($job as $v){
				$url=Url('job',array("c"=>"comapply","id"=>$v['id']));
				$jobname[$v['uid']][]="<a href='".$url."' target='_bank'>".$v['name']."</a>";
				
			}
			foreach($rows as $key=>$val){
				foreach($company as $v){
					if($val['sc_uid']==$v['uid']){
						$rows[$key]['com_name']=$v['name'];
					}
				}
				foreach($jobname as $k=>$v){
					if($val['sc_uid']==$k){
						$rows[$key]['jobnum']=count($v);
						$i=0;
						foreach($v as $value){
							if($i<2){
								$joblist[$key][]=$value;
							}
							$i++;
						}
						$rows[$key]['jobname']=@implode(",",$joblist[$key]);
					}
				}
			}
		}
		$this->yunset("rows", $rows);
 		$this->user_tpl('atn');
	}
	function del_action(){
		if($_GET['id']){
			$this->obj->DB_delete_all("atn","`id`='".intval($_GET['id'])."' AND `uid`='".$this->uid."'");
			$this->obj->DB_update_all("company","`ant_num`=`ant_num`-1","`uid`='".intval($_GET['uid'])."'");
			$this->obj->member_log("取消关注企业");
 			$this->layer_msg('取消关注成功企业！',9,0,"index.php?c=atn");
		}
	}
}
?>