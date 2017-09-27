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
class buysave_controller extends company{
	function index_action(){ 
		$statis=$this->company_satic(); 
		if($_POST['type']=='ad'){
			$row=$this->obj->DB_select_once("ad_class","`id`='".(int)$_POST['aid']."' and `type`='1'");  
			if($row['id']){
				$integral=$row['integral_buy']*intval($_POST['buy_time']);
			}else{
				$this->ACT_layer_msg("非法操作！",8,"index.php?c=ad"); 
			}
		}elseif($_POST['type']=='pl'){
			$integral=$this->config['integral_com_comments']*intval($_POST['time']);
		}
		if($statis['integral']<$integral){
			$this->ACT_layer_msg("你的".$this->config['integral_pricename']."不足，请先充值！",8,"index.php?c=pay");
		}
		if($_POST['type']=="ad"){
			
			$pay_integral = $integral;
			$nid=$this->company_invtal($this->uid,$pay_integral,false,"购买广告位",true,2,'integral',4);
			if($nid){
				$data['comid']=$this->uid;
				$data['did']=$this->userdid;
				$data['order_id']=mktime().rand(10000,99999);
		 		$upload = $this->upload_pic("../data/upload/adpic/");
		 		$pictures=$upload->picture($_FILES['pic_url']);
		 		$data['ad_name']=$_POST['ad_name'];
		 		$data['pic_url']=$pictures;
				$data['pic_src']=$_POST['pic_src'];
				$data['buy_time']=intval($_POST['buy_time']);
				$data['integral']=$pay_integral;
				$data['aid']=(int)$_POST['aid'];
				$data['adname']=$_POST['adname'];
				$data['order_state']=2;
				$data['datetime']=mktime();
				$oid=$this->obj->insert_into("ad_order",$data);
				if($oid)
				{
					$content="购买了广告位 ".$_POST['adname'];
					$this->addstate($content,2);
					$this->obj->member_log($content);
 					$this->ACT_layer_msg("您的订单已提交，请等待管理员审核！",9,"index.php?c=ad_order");
				}else{
 					$this->ACT_layer_msg("提交失败，请稍后再试！",8,$_SERVER['HTTP_REFERER']);
				}
			}else{
 				$this->ACT_layer_msg("系统出错，请联系管理员！",8,"index.php");
			}
		}
	}
}
?>