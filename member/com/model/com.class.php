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
class com_controller extends company{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$this->public_action();
		$statis = $this->company_satic();
		$urlarr=array("c"=>"com","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		if($statis['vip_etime']>time()){
			$statis['vip_time'] = date("Y年m月d日",$statis['vip_etime']);
		}else{
			$statis['vip_time'] = "已过期";
		} 
		$statis[integral]=number_format($statis[integral]);
		$this->yunset("statis",$statis);
		$rows = $this->get_page("company_order","uid='".$this->uid."'  order by order_time desc",$pageurl,"10");
		$this->yunset("rows",$rows);
		$allprice=$this->obj->DB_select_once("company_pay","`com_id`='".$this->uid."' and `type`='1' and `order_price`<0","sum(order_price) as allprice"); 
		if($allprice['allprice']==''){$allprice['allprice']='0';}
		$this->yunset("integral",number_format(str_replace("-","", $allprice['allprice'])));
		$this->yunset("js_def",4);
		$this->com_tpl('com');
	}
	function card_action(){
		$info=$this->obj->DB_select_once("prepaid_card","`card`='".$_POST['card']."' and `password`='".$_POST['password']."'");
		if($_POST['card']==""){
			$this->ACT_layer_msg("请输入卡号！",8);
		}elseif($_POST['password']==""){
			$this->ACT_layer_msg("请输入密码！",8);
		}elseif(empty($info)){
			$this->ACT_layer_msg("卡号或密码错误！",8);
		}elseif($info['uid']>0){
			$this->ACT_layer_msg("该充值卡已使用！",8);
		}elseif($info['type']=="2"){
			$this->ACT_layer_msg("该充值卡不可用！",8);
		}elseif($info['stime']>time()){
			$this->ACT_layer_msg("该充值卡还未到使用时间！",8);
		}elseif($info['etime']<time()){
			$this->ACT_layer_msg("该充值卡已过期！",8);
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
				$this->obj->DB_update_all("prepaid_card","`uid`='".$this->uid."',`username`='".$this->username."',`utime`='".time()."'","`id`='".$info['id']."'");
				$this->company_invtal($this->uid,$integral,true,"充值卡充值",true,$pay_state=2,"integral");
				$this->ACT_layer_msg("充值卡使用成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("充值卡使用失败！",8,$_SERVER['HTTP_REFERER']);
			}
			
		}
	}
}
?>