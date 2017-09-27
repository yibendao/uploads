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
class crm_order_controller extends common
{
	function set_search(){
		$pro=$this->obj->DB_select_all("crm_product","1","`id`,`name`");
		if(!empty($pro)){
			foreach($pro as $k=>$v){
				$carr[$v['id']]=$v['name'];
			}
		}
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"待审核","2"=>"已付款","3"=>"已完成","4"=>"已退款"));
		$search_list[]=array("param"=>"product","name"=>'产品名称',"value"=>$carr);
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"o_time","name"=>'发布时间',"value"=>$lo_time);
		$this->yunset("pro", $pro);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		$where.="`nid` in (".$this->config['crmpronid'].")";
		if ($_GET['product']!=""){
			$where.=" and `pid`='".$_GET['product']."'";
			$urlarr['product']=$_GET['product'];
		}
		if($_GET['status'])
		{
			$where.=" and `status`='".$_GET['status']."'";
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['o_time']){
			if($_GET['o_time']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.$_GET['o_time'].'day')."'";
			}
			$urlarr['o_time']=$_GET['o_time'];
		}
		if($_GET['news_search']){

			if (trim($_GET['keyword'])!=""){
					if ($_GET['type']=='2'){
				$where.=" and `orderid` like '%".trim($_GET['keyword'])."%'";
			}elseif ($_GET['type']=='1'){
				$orderinfo=$this->obj->DB_select_all("crm_client","`name` like '%".trim($_GET['keyword'])."%'","`id`");
				if (is_array($orderinfo)){
					foreach ($orderinfo as $val){
						$orderuids[]=$val['id'];
					}
					$oruids=@implode(",",$orderuids);
				}
				$where.=" and `client_id` in (".$oruids.")";

			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
			}
			$urlarr['news_search']=$_GET['news_search'];
		}
		if($_GET['order'])
		{
			if($_GET['order']=="desc")
			{
				$order=" order by `".$_GET['t']."` desc";
			}else{
				$order=" order by `".$_GET['t']."` asc";
			}
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$order=" order by `id` desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows=$this->get_page("crm_order",$where.$order,$pageurl,$this->config['sy_listnum']);
		if(is_array($rows))
		{
			foreach($rows as $v)
			{
				$pid[]=$v['pid'];
				$cuid[]=$v['client_id'];
			}
			$plist=$this->obj->DB_select_all("crm_product","`id` in (".@implode(",",$pid).")");
			$clist=$this->obj->DB_select_all("crm_client","`id` in (".@implode(",",$cuid).")");
			foreach($rows as $k=>$v)
			{
				foreach($plist as $val)
				{
					if($v['pid']==$val['id'])
					{
						$rows[$k]['pname']=$val['name'];
					}
				}
				foreach($clist as $val)
				{
					if($v['client_id']==$val['id'])
					{
						$rows[$k]['username']=$val['name'];
					}
				}
			}
		}
		$this->yunset("get_type", $_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/crm_order'));
	}
	function show_action()
	{
		$info=$this->obj->DB_select_once("crm_order","`id`='".$_GET['id']."'");
		$this->yunset("info",$info);
		$product=$this->obj->DB_select_once("crm_product","`id`='".$info['pid']."'");
		$this->yunset("product",$product);
		$this->yuntpl(array('admin/crm_order_show'));
	}
	function status_action()
	{
		if(is_array($_POST['del']))
		{
			$del=@implode(",",$_POST['del']);
			$layer_type=1;
		}else{
			$del=$_GET['del'];
			$layer_type=0;
		}
		$nid=$this->obj->DB_update_all("crm_order","`status`='3'","`id` in (".$del.")");
		isset($nid)?$this->layer_msg('crm订单(ID:".$del.")确认完成成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('确认完成失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
}
?>