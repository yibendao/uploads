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


include(dirname(__FILE__).'/global.php');

if($_GET['yunurl']){

	$var=@explode('-',str_replace('/','-',$_GET['yunurl']));
	foreach($var as $p){
		$param=@explode('_',$p);
		$_GET[$param[0]]=$param[1];
	}
	unset($_GET['yunurl']);

}

if($_GET['m'] && !preg_match('/^[0-9a-zA-Z\_]*$/',$_GET['c'])){
	$_GET['m'] = 'index';
}

$ModuleName = $_GET['m'];
if($ModuleName=='')	$ModuleName='index';

include(LIB_PATH.'init.php');


?>