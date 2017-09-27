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
class evaluate_controller extends common{ 
	function evaluate_tpl($tpl){
		$this->yuntpl(array('default/evaluate/'.$tpl));
	}
	
	function imgWebUrl($imgPath){
		return $this->config['sy_weburl']."/".$imgPath;
	}	
	
	function create_uuid($prefix = "yun"){  
		$str = md5(uniqid(mt_rand(), true));   
		$uuid  = substr($str,0,12);   
		return $prefix.$uuid; 
	}	
}
?>