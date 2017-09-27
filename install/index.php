<?php
/*
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2016 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
header("Content-Type: text/html; charset=gb2312");
ob_start();
error_reporting(0);
$i_model = 1;
define('APP_PATH',dirname(dirname(__FILE__)).'/');  
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('VERSION', '4.3 beta');
define('YEAR', '2017');
if (substr(PHP_VERSION, 0, 1) == '7') {
	$installDir = 'php7';
}else{
	$installDir = 'php5';
}
define('INS_DIR',$installDir.'/'); 
require_once 'install_lang.php';
require_once $installDir.'/install_function.php';
require_once $installDir.'/install_mysql.php';
require_once $installDir.'/install_var.php';
include $installDir.'/install.php';

?>