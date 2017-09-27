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
class recycle_controller extends common
{
	function set_search(){
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'半月之内','30'=>'一个月之内','90'=>'三个月之内','180'=>'半年之内');
		$search_list[]=array("param"=>"ctime","name"=>'删除时间',"value"=>$lo_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where=1;
		extract($_GET);
		if (trim($keyword)){
			if ($type=='1'){
					$where .=" and `username` like '%".$keyword."%'";
			}elseif ($type=='3'){
					$where .=" and `tablename`='".$keyword."'";
			}
			$urlarr['type']=$type;
			$urlarr['keyword']=$keyword;
		}
		if($_GET['ctime']){
			if($_GET['ctime']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['ctime'].'day')."'";
			}
			$urlarr['ctime']=$_GET['ctime'];
		}
		if($_GET['stime']){
			$where.=" and `ctime` >='".strtotime($_GET['stime']."00:00:00")."'";
			$urlarr['stime']=$_GET['stime'];
		}
		if($_GET['etime']){
			$where.=" and `ctime` <='".strtotime($_GET['etime']."23:59:59")."'";
			$urlarr['etime']=$_GET['etime'];
		}
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("recycle",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];
		$this->yunset("get_type", $_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_recycle'));
	}
	function show_action(){
		$rows=$this->obj->DB_select_once("recycle","`id`='".$_GET['id']."'");
		$this->yunset("rows",unserialize($rows[body]));
		$this->yuntpl(array('admin/admin_recycle_show'));
	}
	function recover_action(){
		$_GET['id']=(int)$_GET['id'];
		if($_GET['id']){
			$rows=$this->obj->DB_select_once("recycle","`id`='".$_GET['id']."'");
			$body=unserialize($rows['body']);
			$this->obj->insert_into($rows['tablename'],$body);
			$this->obj->DB_delete_all("recycle","`id`='".$_GET['id']."'","");
			$this->layer_msg($rows['tablename']."(ID:".$_GET['id'].")恢复成功!",9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function del_action(){
		$this->check_token();
		if($_GET['id']=="alldel"){
			$this->db->Query("TRUNCATE `".$this->def."recycle`");
			$this->layer_msg( "已清空回收站！",9,0,$_SERVER['HTTP_REFERER']);
		}else if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
				$this->obj->DB_delete_all("recycle","`id` in(".@implode(',',$del).")","");
				$this->layer_msg( "回收站数据(ID:".@implode(',',$del).")删除成功！",9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }else if(isset($_GET['id'])){
			$result=$this->obj->DB_delete_all("recycle","`id`='".$_GET['id']."'" );
			isset($result)?$this->layer_msg('回收站数据(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8);
		}else if($_GET['time']){
			$time=strtotime($_GET['time']);
			$this->obj->DB_delete_all("recycle","`ctime`<'".$time."'","");
			$this->layer_msg('数据删除成功！',9,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',8);
		}
	}
}
?>