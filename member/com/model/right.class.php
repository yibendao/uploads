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
class right_controller extends company{
	function index_action(){
		$this->company_satic();
		$this->public_action();
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		if($statis['rating']>0){
			if($statis['vip_etime']>time()){
				$days=round(($statis['vip_etime']-mktime())/3600/24) ;
				$this->yunset("days",$days);
			}
		}
		$this->yunset("statis",$statis);
		$this->yunset("com",$com);
		$rows=$this->obj->DB_select_all("company_rating","`category`='1' and `display`='1' and `type`='1' order by `type` asc,`sort` desc");
		if(is_array($rows)){
			foreach($rows as $v){
				$couponid[]=$v['coupon'];
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("js_def",4);
		$this->com_tpl('member_right');
	}
	
	function time_action(){
		$this->company_satic();
		$this->public_action();
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		if($statis['rating']>0){
			if($statis['vip_etime']>time()){
				$days=round(($statis['vip_etime']-mktime())/3600/24) ;
				$this->yunset("days",$days);
			}
		}
		$this->yunset("statis",$statis);
		$this->yunset("com",$com);
		$times=$this->obj->DB_select_all("company_rating","`category`='1' and `display`='1' and `type`='2' order by `type` asc,`sort` desc");
		if(is_array()){
			foreach($times as $v){
				$couponid[]=$v['coupon'];
			}
			if(empty($coupon)){
				$coupon=$this->obj->DB_select_all("coupon","`id` in (".@implode(",",$couponid).")","`id`,`name`");
			}
			if(is_array($coupon)){
				foreach($times as $k=>$v){
					foreach($coupon as $val){
						if($v['coupon']==$val['id']){
							$times[$k]['couponname']=$val['name'];
						}
					}
				}
			}
		}
		$this->yunset("times",$times);
		$this->yunset("js_def",4);
		$this->com_tpl('member_time');
	}
	function buyvip_action(){
		$this->public_action();
		$this->company_satic();
		$this->yunset("js_def",4);
		if($_GET['vipid']==0){
			$this->com_tpl('buypl');
		}else{
			$row=$this->obj->DB_select_once("company_rating","`id`='".(int)$_GET['vipid']."' and display='1'");
			$this->yunset("row",$row);
			if($row['time_start']<time() && $row['time_end']>time()){
				$price=$row['integral_buy']-$row['yh_integral'];
			}else{
				$price=$row['integral_buy'];
			}
			$this->com_tpl('buyvip');
		}
	}
	function added_action(){
        $this->public_action();
		$id=intval($_GET['id']);	
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		$rows=$this->obj->DB_select_all("company_service","`display`='1'");
		if($id){
			$info=$this->obj->DB_select_all("company_service_detail","`type` = '$id' order by `service_price` asc");
		}else{
			$row=$this->obj->DB_select_once("company_service","`display`='1'","id");
			$info=$this->obj->DB_select_all("company_service_detail","`type` = '".$row['id']."' order by `service_price` asc");
		}
		if($statis['rating']>0){
			if($statis['vip_etime']>time()){
				$days=round(($statis['vip_etime']-mktime())/3600/24) ;
				$this->yunset("days",$days);
			}
		}
		if ($statis){
			$rating=$statis['rating'];
			$discount=$this->obj->DB_select_once("company_rating","`id`=$rating");
			$this->yunset("discount",$discount);
		}
		$this->yunset("com",$com);
		$this->yunset("statis",$statis);
		$this->yunset("info",$info);
		$this->yunset("rows",$rows);
		$this->yunset("js_def",4);
		$this->com_tpl('added');
	}
}
?>
