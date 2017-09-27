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
class hrclass_controller extends common
{
	function index_action()
	{
		$rows=$this->obj->DB_select_all("toolbox_class");
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_hrclass'));
	}
	function add_action()
	{
		if($_GET['id'])
		{
			$row=$this->obj->DB_select_once("toolbox_class","id='".$_GET['id']."'");
			$this->yunset("row",$row);
		}
		if($_POST['submit'])
		{
			$value.="`name`='".$_POST['name']."',";
			$value.="`content`='".$_POST['content']."'";
			$upload=$this->upload_pic("../data/upload/hrclass/","22");
			if($_FILES['pic']['tmp_name']!="")
			{
				$pictures=$upload->picture($_FILES['pic']);
				if($pictures=='2'){$this->ACT_layer_msg("非法文件格式！",8,"index.php?m=hrclass");}
				$value.=",`pic`='".str_replace("../","",$pictures)."'";
				if($_POST['id'])
				{
					$row=$this->obj->DB_select_once("toolbox_class","`id`='".$_POST['id']."' and `pic`<>''");
					if(is_array($row))
					{
						unlink_pic("../".$row['pic']);
					}
				}
			}
			if($_POST['id'])
			{
				$id=$this->obj->DB_update_all("toolbox_class",$value,"`id`='".$_POST['id']."'");
				$msg="更新";
			}else{
				$id=$this->obj->DB_insert_once("toolbox_class",$value);
				$msg="添加";
			}
			isset($id)?$this->ACT_layer_msg("HR类别(ID:".$id.")".$msg."成功！",9,"index.php?m=hrclass",2,1):$this->ACT_layer_msg($msg."失败！",8,"index.php?m=hrclass");
		}
		$this->yuntpl(array('admin/admin_hrclass_add'));
	}
	function del_action()
	{
		if($_GET['del'])
		{
			$this->check_token();
			{
				$del=$_GET['del'];
				$layer_type=0;
			}
		}
		else{
			if(isset($_POST['del']) && is_array($_POST['del'])){
				$del=@implode(",",$_POST['del']);
				$layer_type=1;
			}
		}
		$row=$this->obj->DB_select_all("toolbox_class","`id` in (".$del.") and `pic`<>''");
		if(is_array($row))
		{
			foreach($row as $v)
			{
				unlink_pic("../".$v['pic']);
			}
		}
		$delid=$this->obj->DB_delete_all("toolbox_class","`id` in ($del)","");
		$this->obj->DB_delete_all("toolbox_doc","`cid` in ($del)","");
		$delid?  $this->layer_msg('HR类别(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER'])
				:$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
}

?>