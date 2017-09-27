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
class seo_controller extends common{
	function index_action(){
		include (CONFIG_PATH."/db.data.php");
		$this->yunset("arr_data",$arr_data);
		$action=$_GET[action]?$_GET[action]:"index";
		$where="`seomodel`='".$action."'";
		$seolist = $this->obj->DB_select_all("seo",$where);
		$this->yunset("get_type",$_GET);
		$this->yunset("seolist",$seolist);
		$this->yuntpl(array('admin/admin_list_seo'));
	}
	function SeoAdd_action(){
		include(CONFIG_PATH."db.data.php"); 
		$this->yunset("arr_data",$arr_data);
		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);
		if($_GET['id']){
		    $info= $this->obj->DB_select_once("seo","`id`='".$_GET['id']."'");
		    $this->yunset("info",$info);
		}
		$this->yuntpl(array('admin/admin_add_seo'));
	}

	function Save_action(){
		extract($_POST);
		$value = "`seoname`='$seoname',";
		$value.= "`ident`='$ident',";
		$value.= "`seomodel`='$seomodel',";
		$value.= "`title`='$title',";
		$value.= "`keywords`='$keywords',";
		$value.= "`php_url`='$php_url',";
		$value.= "`rewrite_url`='$rewrite_url',";
		$value.= "`description`='$description',";
		$value.= "`did`='$did',";
		$value.= "`time`='".time()."'";

		if($_POST['update'])
		{
			$this->obj->DB_update_all("seo",$value,"`id`='$id'");
			$this->cache_action();
			$msg = "SEO 修改成功！";
		}elseif($_POST['add']){
			$this->obj->DB_insert_once("seo",$value);
			$this->cache_action();
			$msg = "SEO 添加成功！";
		}
		$this->ACT_layer_msg( $msg,9,"index.php?m=seo&action=".$seomodel,2,1);
		$this->yuntpl(array('admin/admin_add_seo'));
	}

	function getseo_action()
	{
		include(PLUS_PATH."seo.cache.php");
	}
	function del_action()
	{
		if($_GET['del'])
		{
			$this->check_token();
	    	if(is_array($_GET['del']))
	    	{
	    		$del=@implode(",",$_GET['del']);
	    		$layer_status=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_status=0;
	    	}
			$id=$this->obj->DB_delete_all("seo","`id` in (".$del.")","");
			if($id)
			{
				$this->cache_action();
				$this->layer_msg('SEO(ID:'.$del.')删除成功！',9,$layer_status,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('SEO(ID:'.$del.')删除失败！',8,$layer_status,$_SERVER['HTTP_REFERER']);
			}
		}

	}
	function cache_action(){
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->seo_cache("seo.cache.php");
	}

}