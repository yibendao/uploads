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
class privacy_controller extends user{

	function index_action(){ 
		$urlarr=array("c"=>"privacy","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$this->get_page("blacklist","`c_uid`='".$this->uid."' and `usertype`='1' order by `id` desc",$pageurl,"10");
		$resume = $this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`status`,`info_status`");
        $this->yunset("resume",$resume);
		$this->public_action();
		$this->user_tpl('privacy');
	}
	function up_action(){
		if(intval($_GET['status'])){ 
			$this->obj->DB_update_all("resume","`status`='".intval($_GET['status'])."'","`uid`='".$this->uid."'"); 
			$this->obj->DB_update_all("resume_expect","`status`='".intval($_GET['status'])."'","`uid`='".$this->uid."'"); 
			$this->obj->member_log("设置简历是否公开");
			$this->layer_msg('操作成功！',9,0,"index.php?c=privacy");
		}
	}
	function del_action(){
		if($_GET['id']){
			$del=(int)$_GET['id'];
			$nid=$this->obj->DB_delete_all("blacklist","`id`='".$del."' and `c_uid`='".$this->uid."'");
			if($nid){
				$this->obj->member_log("删除公司黑名单信息");
				$this->layer_msg('删除成功！',9,0,"index.php?c=privacy");
			}else{
				$this->layer_msg('删除失败！',8,0,"index.php?c=privacy");
			}
 		}
	}
	function delall_action(){
		$this->obj->DB_delete_all("blacklist","`c_uid`='".$this->uid."'","");
		$this->obj->member_log("清空公司黑名单信息");
		$this->layer_msg('删除成功！',9,0,"index.php?c=privacy");
	}
	function searchcom_action(){
		$blacklist=$this->obj->DB_select_all("blacklist","`c_uid`='".$this->uid."'","`p_uid`");
		if($blacklist&&is_array($blacklist)){
			$uids=array();
			foreach($blacklist as $val){
				$uids[]=$val['p_uid'];
			}
			$where=" and `uid` not in(".pylode(',',$uids).")";
		}
		$company=$this->obj->DB_select_all("company","`name` like '%".$this->stringfilter(trim($_POST['name']))."%' ".$where,"`uid`,`name`");
		$html="";
		if($company&&is_array($company)){
			foreach($company as $val){
				$html.="<li class=\"cur\"><input class=\"re-company\" type=\"checkbox\" value=\"".$val['uid']."\" name=\"buid[]\"><a href=\"".Url('company',array('c'=>'show',"id"=>$val['uid']))."\" target=\"_blank\">".$val['name']."</a></li>";
			} 
		}else{
			$html="<li class=\"cur\">暂无符合条件企业</li>";
		}
		echo $html;die;
	}
	function save_action(){
		if(is_array($_POST['buid'])&&$_POST['buid']){
			$company=$this->obj->DB_select_all("company","`uid` in(".pylode(',',$_POST['buid']).")","`uid`,`name`");
			foreach($company as $val){
				$this->obj->insert_into("blacklist",array('p_uid'=>$val['uid'],'c_uid'=>$this->uid,"inputtime"=>time(),'usertype'=>'1','com_name'=>$val['name']));
			}
			$this->layer_msg('操作成功！',9,1,"index.php?c=privacy");
		}else{
			$this->layer_msg('请选择要屏蔽的公司！',8,1,"index.php?c=privacy");
		}
	}
}
?>