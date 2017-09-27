<?php
/*
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2017 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */

class ApiPay extends common{ 
	function payAll($dingdan,$total_fee,$paytype=''){ 

		if(!preg_match('/^[0-9]+$/', $dingdan)){

			die;
		} 
		
		$order=$this->obj->DB_select_once("company_order","`order_id`='$dingdan'");
		
		if($order['order_state']!='2' && $order['id']){

			$member=$this->obj->DB_select_once("member","`uid`='".$order['uid']."'","`usertype`,`username`,`wxid`");

			if($member['usertype']=='1'){
				$table='member_statis';
				$marr=$this->obj->DB_select_once("resume","`uid`='".$order['uid']."'","`name`,`email`,`telphone`as `moblie`");
			}else if($member['usertype']=='2'){
				$table='company_statis';
				$tvalue=",`all_pay`=`all_pay`+'".$order["order_price"]."'";
				$marr=$this->obj->DB_select_once("company","`uid`='".$order['uid']."'","`name`,`linkmail` as `email`,`linktel` as `moblie`");
			}
	
			$emaildata['type']="recharge";
			$emaildata['username']=$member['username'];
			$emaildata['name']=$marr['name'];
			$emaildata['price']=$order['order_price'];
			$emaildata['time']=date("Y-m-d H:i:s");
			$emaildata['email']=$marr['email'];
			$emaildata['moblie']=$marr['moblie'];
			
			$sendInfo['wxid'] = $member['wxid'];
			$sendInfo['first'] = '您有一笔订单支付成功！';
			$sendInfo['username'] = $member['username'];
			$sendInfo['order'] = $order['order_id'];
			$sendInfo['price'] = $order['order_price'];
			$sendInfo['time'] = date('Y-m-d H:i:s');
			switch($paytype){
			
				case 'alipay':$sendInfo['paytype']='支付宝'; 
				break;
				case 'wxpay':$sendInfo['paytype']='微信支付'; 
				break;
				case 'wapalipay':$sendInfo['paytype']='支付宝手机支付'; 
				break;
				case 'tenpay':$sendInfo['paytype']='财付通'; 
				break;
				default :$sendInfo['paytype']='其他支付方式';
				
				break; 

			}

			if($order['type']=='1' && $order['rating'] && $member['usertype']!='1'){
				
				
				

				$row=$this->obj->DB_select_once("company_rating","`id`='".$order['rating']."'");
				$sendInfo['info'] = '购买：'.$row['name'];

				$ratingM = $this->MODEL('rating');
				$value=$ratingM->rating_info($order['rating'],$order['uid']);
				$nid=$this->obj->DB_update_all($table,$value,"`uid`='".$order['uid']."'");
				
				$sendMail = 1;
			}else if($order['type']=='2' && $order['integral']){ 
				$nid=$this->obj->DB_update_all($table,"`integral`=`integral`+'".$order['integral']."'".$tvalue,"`uid`='".$order['uid']."'");
				if($nid){ 
					$this->obj->DB_insert_once("company_pay","`order_id`='".$order['order_id']."',`order_price`='".$order['integral']."',`pay_time`='".time()."',`pay_state`='2',`com_id`='".$order["uid"]."',`pay_remark`='"."购买".$this->config['integral_pricename']."',`type`='1',`pay_type`='2',`did`='".$this->config['did']."'");
					$sendMail = 1;
				}
				$sendInfo['info'] = '充值'.$this->config['integral_pricename'].'：'.$order['integral'];

			}else if($order['type']=='5'){
				$value='';
				$row=$this->obj->DB_select_once("company_service_detail","`id`='".$order['rating']."'");
				if($member['usertype']=='2'){
					
					$value.="`job_num`=`job_num`+'".$row['job_num']."',";
					$value.="`down_resume`=`down_resume`+'".$row['resume']."',";
					$value.="`invite_resume`=`invite_resume`+'".$row['interview']."',";
					$value.="`breakjob_num`=`breakjob_num`+'".$row['breakjob_num']."',";
					$value.="`part_num`=`part_num`+'".$row['part_num']."',";
					$value.="`breakpart_num`=`breakpart_num`+'".$row['breakpart_num']."',";
					$value.="`all_pay`=`all_pay`+'".$order["order_price"]."'";
				}
				$nid=$this->obj->DB_update_all($table,$value,"`uid`='".$order['uid']."'");
				$sendMail = 1;
				$sendInfo['info'] = '购买增值包：'.$row['name'];
			}else if($order['type']=='6'){

				$value='';
				
				$sendMail = 1;
				$sendInfo['info'] = '购买培训课程：';
				$nid = 1;
			}
			
			if($nid){
				$this->obj->DB_update_all("company_order","`order_state`='2',`order_type`='".$paytype."'","`id`='".$order['id']."'"); 

				$Weixin=$this->MODEL('weixin');
				$Weixin->sendWxPay($sendInfo);
				
				
				if($sendMail==1){ 
					$this->send_msg_email($emaildata);
				}
			}
		} 
	} 
}

?>