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
class comproduct_controller extends common
{
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","3"=>"未审核","2"=>"未通过"));
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'发布时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$where=1;
		$this->set_search();
		$_GET['time']=(int)$_GET['time'];
		$status=(int)$_GET['status'];
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		} 
		if($status){
			if($status=='3'){
				$where.=" and `status`='0'";
			}else{
				$where.=" and `status`='".$status."'";
			}
			
			$urlarr['status']=$status;
		}
		if(trim($_GET['keyword'])){
			if($_GET['type']=="1"){ 
				$company=$this->obj->DB_select_all("company","`name` LIKE '%".trim($_GET['keyword'])."%'","uid");
				
				foreach($company as $v){
					$comid[]=$v['uid'];
				}
				$where.=" and `uid` in (".@implode(",",$comid).")"; 
			}elseif ($_GET['type']=="2"){
				$where.=" and `title` LIKE '%".trim($_GET['keyword'])."%'";
			} 
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by status asc,id desc";
		}
		$urlarr['page']="{{page}}";
		$urlarr=Url($_GET['m'],$urlarr,'admin');
		$rows = $this->get_page("company_product",$where,$urlarr,$this->config['sy_listnum']);
		if($rows&&is_array($rows)){			
			$uids=array();
			foreach($rows as $val){
				if(in_array($val['uid'],$uids)==false){
					$uids[]=$val['uid'];
				}
			}
			$company=$this->obj->DB_select_all("company","`uid` in(".@implode(',',$uids).")","`uid`,`name`");			
			foreach($rows as $key=>$val){
				foreach($company as $v){
					if($val['uid']==$v['uid']){
						$rows[$key]['name']=$v['name'];
					}
				} 
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_comproduct'));
	}
	function statusbody_action(){
		$userinfo = $this->obj->DB_select_once("company_product","`id`=".$_GET['id'],"`statusbody`");
		echo $userinfo['statusbody'];die;
	}
	function status_action(){
		extract($_POST);
		$id = @explode(",",$id);
		if(is_array($id)){
			foreach($id as $value){
				$idlist[] = $value;
			}
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("company_product","`status`='$status',`statusbody`='".$statusbody."'","`id` IN ($aid)");
 			$id?$this->ACT_layer_msg("产品审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function statuss_action(){
		$this->obj->DB_update_all("company_product","`status`='".$_POST['status']."'","`id` IN (".$_POST['allid'].")");
		$this->admin_log("企业产品(ID:".$_POST['allid'].")审核成功");
		echo $_POST['status'];die;
	}
	function del_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
			    	foreach($del as $v){
			    	    $this->del_com($v);
			    	}
					$del_id=@implode(',',$del);
		    	}else{
		    		$this->del_com($del);
					$del_id=$del;
		    	}
				$this->layer_msg('产品(ID:'.$del_id.')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
	    		$this->layer_msg( "请选择您要删除的信息！",8,1);
	    	}
	    }
	    if(isset($_GET['id'])){
	    	extract($_GET);
	    	$id_a=explode("-",$id);
			$result=$this->del_com($id);
			isset($result)?$this->layer_msg('产品(ID:'.$id_a[0].')删除成功！',9,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',8);
		}
	}
	function del_com($id)
	{
		$id_arr = explode("-",$id);
		if($id_arr[0])
		{
			$product=$this->obj->DB_select_once("company_product","`id`='".$id_arr[0]."'");
 			unlink_pic("../".$product['pic']);
			$result=$this->obj->DB_delete_all("company_product","`id`='".$id_arr[0]."'" );
		}
		return $result;
	}
}
?>