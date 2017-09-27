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
class payment_controller extends user{
	function index_action(){
		$rows=$this->obj->DB_select_all("bank");
		$this->yunset("rows",$rows);
		if($this->usertype!='1' || $this->uid==''){
			$this->ACT_msg("index.php","非法操作！");
		}else{
			$order=$this->obj->DB_select_once("company_order","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' and `order_state`='1'");
			if(is_array($order)){
				$orderbank=@explode("@%",$order['order_bank']);
				$order['bank_name']=$orderbank[0];
				$order['bank_number']=$orderbank[1];				
			}
			if(empty($order)){
				header("Location:index.php?c=paylist");
			}else{
				
				$this->yunset("order",$order);
				$this->public_action();
				$this->yunset("comstyle","../app/template/member/com");
				$this->user_tpl('payment');
			}
		}
	}
	function wxurl_action(){
		if((int)$_POST['orderId']){
			$order=$this->obj->DB_select_once("company_order","`uid`='".$this->uid."' and `id`='".(int)$_POST['orderId']."' AND `order_state`='1'");
			if($order['order_price']>0){
				if($this->config['wxpay']=='1'){
					require_once(LIB_PATH.'wxOrder.function.php');
					$wxUrl = wxOrder(array('body'=>iconv("gbk","utf-8",'充值'),'id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price']));
				}
			}
		}
		if($wxUrl){
			echo "<img src=\"http://paysdk.weixin.qq.com/example/qrcode.php?data=".$wxUrl."\" width=\"210\" height=\"210\">";
		}else{
			echo "二维码生成失败<br>请联系客服 ".$this->config['sy_freewebtel'];
		}
	}
	function paybank_action(){
		$order=$this->obj->DB_select_once("company_order","`id`='".(int)$_POST['oid']."' and `uid`='".$this->uid."'");
		if($order['id']){
			if($_POST['bank_name']==""){
				$this->ACT_layer_msg("请填写汇款银行！");
			}
			if($_POST['bank_number']==""){
				$this->ACT_layer_msg("请填写汇入账号！");
			}
			if($_POST['bank_price']==""){
				$this->ACT_layer_msg("请填写汇款金额！");
			}
			if($_POST['bank_time']==""){
				$this->ACT_layer_msg("请填写汇款时间！");
			}
			if(is_uploaded_file($_FILES['order_pic']['tmp_name'])){
				$upload=$this->upload_pic("../data/upload/order/",false,$this->config['com_uppic']);
				$pictures=$upload->picture($_FILES['order_pic']);
				$this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
				$pictures = str_replace("../data/upload/order","./data/upload/order",$pictures);				
			}else{
				$pictures=$order['order_pic'];
			}
			$orderbank=$_POST['bank_name'].'@%'.$_POST['bank_number'].'@%'.$_POST['bank_price'];
			if($_POST['bank_time']){
				$banktime=strtotime($_POST['bank_time']);
			}else{
				$banktime="";
			}
			$company_order="`order_type`='bank',`order_state`='3',`order_remark`='".$_POST['order_remark']."',`order_pic`='".$pictures."',`order_bank`='".$orderbank."',`bank_time`='".$banktime."'";
			
			$this->obj->DB_update_all("company_order",$company_order,"`order_id`='".$order['order_id']."'");
			$this->ACT_layer_msg("操作成功，请等待管理员审核！",9,"index.php?c=paylist");
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function wxpaystatus_action(){
		
		if((int)$_POST['orderid']){
			$order=$this->obj->DB_select_once("company_order","`id`='".(int)$_POST['orderid']."' and `uid`='".$this->uid."'");
			if($order['order_state']=='2'){
					
				echo 1;
				exit();
			}
		}
		echo 0;
		exit();
		
	}
}
?>