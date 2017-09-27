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
class index_controller extends map_controller{ 
	function index_action(){   
		$this->yunset($this->MODEL('cache')->GetCache(array('job','com','city','hy')));
		if($_GET[r]<500){
			$zoom=15;
		}elseif($_GET[r]>=500 && $_GET[r]<5000){
			$zoom=13;
		}else{
			$zoom=11;
		}
		$this->yunset("zoom",$zoom);
		$this->yunset("getinfo",$_GET);
		$this->seo("map");
		$this->map_tpl('index');
	} 
}
?>