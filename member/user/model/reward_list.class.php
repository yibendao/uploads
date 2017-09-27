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
class reward_list_controller extends user{
	function index_action(){		
		$this->public_action();
		$urlarr=array("c"=>"reward_list","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$where.="`uid`='".$this->uid."'order by id desc";
		$this->get_page("change",$where,$pageurl,"13");
		$num=$this->obj->DB_select_num("change","`uid`='".$this->uid."'");
		$this->yunset("num",$num);
		$statis = $this->member_satic();
		$statis[integral]=number_format($statis[integral]);
		$this->yunset("statis",$statis);
		$this->user_tpl('reward_list');
	}	
	function del_action(){
		if($this->usertype!='1' || $this->uid==''){
			$this->layer_msg('非法操作！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$rows=$this->obj->DB_select_once("change","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' ");
			if($rows['id']){
				$this->obj->DB_update_all("reward","`num`=`num`-".$rows['num'].",`stock`=`stock`+".$rows['num']."","`id`='".$rows['gid']."'");
				$this->company_invtal($this->uid,$rows['integral'],true,"取消兑换",true,2,'integral',24);
				$this->obj->DB_delete_all("change","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' ");
			} 
			$this->obj->member_log("取消兑换");
			$this->layer_msg('取消成功！',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>