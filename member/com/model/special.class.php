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
class special_controller extends company{
	function index_action(){
		$this->company_satic();
		$this->public_action();
		$urlarr["c"]="special";
		$urlarr["page"]="{{page}}";
		$pageurl=Url('member',$urlarr);
		$where="`uid`='".$this->uid."'";
		$rows=$this->get_page("special_com",$where,$pageurl,"10");
		if($rows&&is_array($rows)){
			$uid=array();
			foreach($rows as $val){
				$sid[]=$val['sid'];
			}
			$special=$this->obj->DB_select_all("special","`id` in(".pylode(',',$sid).")","id,title,intro");
			foreach($rows as $key=>$val){
				foreach($special as $v){
					if($val['sid']==$v['id']){
						$rows[$key]['title']=$v['title'];
						$rows[$key]['intro']=$v['intro'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("js_def",3);
		$this->com_tpl("special");
	}
	function del_action(){
		$id=$this->obj->DB_select_once("special_com","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."' and `status`=0","uid,integral");
		if($id&&$id['integral']>0){
			$this->company_invtal($id['uid'],$id['integral'],true,"取消专题招聘报名，退还".$this->config['integral_pricename'],true,2,'integral');
		}
		$delid=$this->obj->DB_delete_all("special_com","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'"," ");
		if($delid){
			$this->obj->member_log("删除专题报名");
			$this->layer_msg('删除成功！',9,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>