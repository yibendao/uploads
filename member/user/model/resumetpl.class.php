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
class resumetpl_controller extends user{
   function index_action() { 
		$rows=$this->obj->DB_select_all("resumetpl","`status`='1' order by `id` asc");
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'",'`tpl`,`paytpls`');
		if($statis['paytpls']){
			$paytpls=@explode(',',$statis['paytpls']);
			$this->yunset("paytpls",$paytpls);
		}  
		$this->yunset("statis",$statis);
		$this->yunset("rows",$rows);
		$this->public_action();
		$this->user_tpl('resumetpl'); 
	}
	function pay_action(){
		$id=intval($_GET['id']);
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'",'`tpl`,`paytpls`,`integral`');
		$info=$this->obj->DB_select_once("resumetpl","`id`='".$id."'");
		$paytpls=array();
		if($statis['paytpls']){
			$paytpls=@explode(',',$statis['paytpls']); 
			if(in_array($id,$paytpls)){
				$this->layer_msg('请勿重复购买！',8,0,"index.php?c=resumetpl");
			}
		}
		if($info['price']>$statis['integral']){
			$this->layer_msg($this->config['integral_pricename'].'不足，请先充值！！',8,0,"index.php?c=resumetpl");
		}else{ 
			$nid=$this->company_invtal($this->uid,$info['price'],false,"购买简历模板",true,2,'integral',15);
			if($nid){
				$paytpls[]=$id;
				$this->obj->DB_update_all("member_statis","`paytpls`='".@implode(',',$paytpls)."'","`uid`='".$this->uid."'");
				$this->layer_msg('购买成功！',9,0,"index.php?c=resumetpl");
			}else{
				$this->layer_msg('购买失败！',8,0,"index.php?c=resumetpl");
			}
		} 
	}
	function settpl_action(){
		$id=intval($_GET['id']);
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'",'`tpl`,`paytpls`,`integral`');
		$paytpls=array();
		if($statis['paytpls']){
			$paytpls=@explode(',',$statis['paytpls']);  
		}
		if(in_array($id,$paytpls)==false&&$id>0){
			$this->layer_msg('请先购买！',8,0,"index.php?c=resumetpl");
		}
		$this->obj->DB_update_all("member_statis","`tpl`='".$id."'","`uid`='".$this->uid."'");
		$this->layer_msg('操作成功！',9,0,"index.php?c=resumetpl");
	}
}
?>