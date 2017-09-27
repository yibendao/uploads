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
class desc_class_controller extends common
{
	function index_action()
	{
		$list=$this->obj->DB_select_all("desc_class","1 order by sort desc");
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_descclass'));
	}

	function add_action(){
	    $_POST=$this->post_trim($_POST);
	    $position=explode('-',$_POST['name']);
		foreach ($position as $val){
			if($val){
				$name[]=iconv('utf-8','gbk',$val);
			}
		}
		$desc_class=$this->obj->DB_select_all("desc_class","`name` in ('".implode("','", $name)."')");
		if(empty($desc_class)){
		    foreach ($name as $key=>$val){
		       $value="`name`='".$val."',`sort`='".intval($v)."'";
		       $add=$this->obj->DB_insert_once("desc_class",$value);
		    }
		    $add?$msg=3:$msg=4;
		    $this->admin_log("单页面类别(ID:".$add.")添加成功！");
		}else{
			$msg=2;
		}
		echo $msg;die;
	}

	function upp_action(){
		if($_POST['update']){
			if(!empty($_POST['name'])){
				$up=$this->obj->DB_update_all("desc_class","`name`='".$_POST['name']."',`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
 				$up?$this->ACT_layer_msg("单页面类别(ID:".$_POST['id'].")更新成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("更新失败，请销后再试！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("请正确填写你要更新的单页面类别！",8,$_SERVER['HTTP_REFERER']);
			}
		}
	}

	function del_action()
	{
		if((int)$_GET['delid'])
		{
			$this->check_token();
			$id=$this->obj->DB_delete_all("desc_class","`id`='".$_GET['delid']."'");
			$id?$this->layer_msg('单页面类别(ID:'.$_GET['delid'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['del'])
		{
			$del=@implode(",",$_POST['del']);
			$id=$this->obj->DB_delete_all("desc_class","`id` in (".$del.")","");
			isset($id)?$this->layer_msg('单页面类别(ID:'.$del.')删除成功！',9,1,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function ajax_action(){
		if($_POST['sort']){
			$this->obj->DB_update_all("desc_class","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->admin_log("单页面类别(ID:".$_POST['id'].")修改排序！");
		}
		if($_POST['name']){
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("desc_class","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->admin_log("单页面类别(ID:".$_POST['id'].")修改类别名称！");
		}
		echo '1';die;
	}
}
?>