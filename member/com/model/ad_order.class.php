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
class ad_order_controller extends company{
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"ad_order","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$where="`comid`='".$this->uid."'";
		$this->get_page("ad_order",$where,$pageurl,"10");
		$this->yunset("js_def",4);
		$this->com_tpl('ad_order');
	}
	function del_action(){
		if($_GET['id']){
			$pic_url=$this->obj->DB_select_once("ad_order","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."' and `status`<>'1'","`pic_url`");
 			if($pic_url['pic_url']){
				unlink_pic($pic_url['pic_url']);
			}
			$this->obj->DB_delete_all("ad_order","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."'");
			$this->obj->member_log("删除广告订单");
 			$this->layer_msg('删除成功！',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function look_action(){
		$this->public_action();
		$info=$this->obj->DB_select_once("ad_order","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."'");
		if($info['status']==1){
			$ad=$this->obj->DB_select_once("ad","`id`='".$info['ad_id']."'");
			$start = @strtotime($ad['time_start']);
			$end = @strtotime($ad['time_end']." 23:59:59");
			$time = time();
			if($ad['time_start']!="" && $start!="" &&($ad['time_end']==""||$end!="")){
				if($ad['time_end']=="" || $end>$time){
					if($ad['is_open']=='1'&&$start<$time){
						$ad['type']="<font color='green'>使用中..</font>";
					}else if($start<$time&&$ad['is_open']=='0'){
						$ad['type']="<font color='red'>已停用</font>";
					}elseif($start>$time && ($end>$time || $ad['time']=="")){
						$ad['type']="<font color='#ff6600'>广告暂未开始</font>";
					}
				}else{
					$ad['type']="<font color='red'>过期广告</font>";
				}
			}else{
				$ad['type']="<font color='red'>无效广告</font>";
			}
		}elseif($info['status']==2){
			$ad['type']="<font color='red'>已退回</font>";
		}else{
			$ad['type']="<font color='red'>未审核</font>";
		}
		$this->yunset("info",$info);
		$this->yunset("ad",$ad);
		$this->yunset("js_def",4);
		$this->com_tpl('ad_detail');
	}
}
?>