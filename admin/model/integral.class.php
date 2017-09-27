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
class integral_controller extends common
{
	function index_action()
	{
		$this->yuntpl(array('admin/admin_integral_config'));
	}
	function user_action()
	{
		$this->yuntpl(array('admin/admin_integral_user'));
	}
	function com_action()
	{
		$this->yuntpl(array('admin/admin_integral_com'));
	}
	function save_action(){
 		if($_POST["config"]){
		 unset($_POST["config"]);
		   foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
				$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			   }else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");

				   }
			 }
		 $this->web_config();
		 $this->ACT_layer_msg($this->config['integral_pricename']."配置修改成功！",9,1,2,1);
		}
	}
}

?>