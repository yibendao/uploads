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
class paylist_controller extends user{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$this->public_action();
		$urlarr=array("c"=>"paylog","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$where.="`uid`='".$this->uid."' and `order_price`>0  order by order_time desc";
		$this->get_page("company_order",$where,$pageurl,"10");
		$this->user_tpl('paylist');
	}
	function del_action(){
		if($_GET['id']){
			$id=$this->obj->DB_delete_all("company_order","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			if($id){
				$this->obj->member_log("取消订单");
				$this->layer_msg('订单取消成功！',9,0,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('订单取消失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
	}
	function card_action(){
		$info=$this->obj->DB_select_once("prepaid_card","`card`='".$_POST['card']."' and `password`='".$_POST['password']."'");
		if($_POST['card']==""){
			$this->ACT_layer_msg("请输入卡号！",8,$_SERVER['HTTP_REFERER']);
		}elseif($_POST['password']==""){
			$this->ACT_layer_msg("请输入密码！",8,$_SERVER['HTTP_REFERER']);
		}elseif(empty($info)){
			$this->ACT_layer_msg("卡号或密码错误！",8,$_SERVER['HTTP_REFERER']);
		}elseif($info['uid']>0){
			$this->ACT_layer_msg("该充值卡已使用！",8,$_SERVER['HTTP_REFERER']);
		}elseif($info['type']=="2"){
			$this->ACT_layer_msg("该充值卡不可用！",8,$_SERVER['HTTP_REFERER']);
		}elseif($info['stime']>time()){
			$this->ACT_layer_msg("该充值卡还未到使用时间！",8,$_SERVER['HTTP_REFERER']);
		}elseif($info['etime']<time()){
			$this->ACT_layer_msg("该充值卡已过期！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$dingdan=mktime().rand(10000,99999);
			$integral=$info['quota']*$this->config['integral_proportion'];
			$data['order_id']=$dingdan;
			$data['order_price']=$info['quota'];
			$data['order_time']=mktime();
			$data['order_state']="2";
			$data['order_remark']="使用充值卡";
			$data['uid']=$this->uid;
			$data['did']=$this->userdid;
			$data['integral']=$integral;
			$data['type']='2';
			$nid=$this->obj->insert_into("company_order",$data);
			if($nid){
				$this->company_invtal($this->uid,$integral,true,"充值卡充值",true,$pay_state=2,"integral");
				$this->obj->DB_update_all("prepaid_card","`uid`='".$this->uid."',`username`='".$this->username."',`utime`='".time()."'","`id`='".$info['id']."'"); 
				$this->ACT_layer_msg("充值卡使用成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("充值卡使用失败！",8,$_SERVER['HTTP_REFERER']);
			}
		}
		
	}
}
?>