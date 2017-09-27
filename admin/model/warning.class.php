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
class warning_controller extends common
{
	function index_action()
	{
		$where = "1";
		if(($_GET['sdate']||$_GET['edate'])&&$_GET['time']<1){
			if($_GET['sdate']){
				$where.=" and `ctime` >= '".strtotime($_GET['sdate']." 00:00:00")."'";
				$urlarr['sdate']=$_GET['sdate'];
			}
			if($_GET['edate']){
				$where.=" and `ctime`<'".strtotime($_GET['edate']." 23:59:59")."'";
				$urlarr['edate']=$_GET['edate'];
			} 
		}
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("warning",$where." order by `id` desc",$pageurl,$this->config["sy_listnum"]);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$uid[]=$v['uid'];
			}
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","`uid`,`username`");
			foreach($list as $k=>$v)
			{
				foreach($member as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$list[$k]['username']=$val['username'];
					}
				}
			}
		}
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_warning'));
	}
	function config_action()
	{
 		if($_POST['config'])
 		{
			unset($_POST['config']);
		    foreach($_POST as $key=>$v)
		    {
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   	if($config==false){
					$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			  	}else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");
				}
			 }
			$this->web_config();
			$this->ACT_layer_msg("预警配置修改成功！",9,1,2,1);
		}
		$this->yuntpl(array('admin/admin_warning_config'));
	}
	function del_action()
	{
		$this->check_token();

	    if($_GET['del'])
	    {
	    	$del=$_GET['del'];
	    	if(is_array($del))
	    	{
				$del=@implode(",",$del);
				$layer_status=1;
	    	}else{
	    		$layer_status=0;
	    	}
			$this->obj->DB_delete_all("warning","`id` in (".$del.")","");
    		$this->layer_msg("预警信息删除(ID:".@implode(',',$del).")成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
    	}else{
			$this->layer_msg("请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
    	}
	}

}
?>