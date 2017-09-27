<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2016 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
include_once("../global.php");echo $this->config['sy_adclick'];
//if($id){
//	$id=(int)$_GET['id'];
//	$ad=$this->obj->DB_select_once("ad","`id`='".$id."'","pic_src,id");
//	if(!empty($ad))
//	{
//		$ip = fun_ip_get();
//		if($this->config['sy_adclick']>"0")
//		{
//			$num=$this->obj->DB_select_num("adclick","`ip`='".$ip."' and `aid`='".$id."' and `addtime`>'".strtotime('-'.$this->config['sy_adclick'].' hour')."'");
//			if($num>"0")
//			{
//				echo $ad['pic_src'];die;
//			}
//		}
//		$data['aid']=$id;
//		$data['uid']=$this->uid;
//		$data['ip']=$ip;
//		$data['addtime']=time();
//		$nid=$this->obj->insert_into("adclick",$data);
//		if($nid){$this->obj->DB_update_all("ad","`hits`=`hits`+1","`id`='".$id."'");}
//		echo $ad['pic_src'];die;
//	}
//}

?>