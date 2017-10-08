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
error_reporting(0);
define('APP_PATH',dirname(__FILE__).'/');
define('CONFIG_PATH',APP_PATH.'/config/'); 
define('DATA_PATH',APP_PATH.'/data/');
define('LIB_PATH',APP_PATH.'/app/include/');
define('TPL_PATH',APP_PATH.'/app/template/');
define('MODEL_PATH',APP_PATH.'/model/');
define('PLUS_PATH',DATA_PATH.'/plus/');
define('ALL_PS','conn');

ini_set('session.gc_maxlifetime',9000);
ini_set('session.gc_probability',10);
ini_set('session.gc_divisor',100);

include(CONFIG_PATH.'db.config.php');
include_once(PLUS_PATH.'config.php');
include(CONFIG_PATH.'db.safety.php');

$starttime=time();
define('DEF_DATA', $db_config['def']);
unset ($_ENV, $HTTP_ENV_VARS, $_REQUEST, $HTTP_POST_VARS, $HTTP_GET_VARS);
$_COOKIE = (is_array($_COOKIE)) ? $_COOKIE : $HTTP_COOKIE_VARS;
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
header('Content-Type: text/html; charset=' . $db_config['charset']);
header("Cache-control: private");
@ob_start('ob_gzhandler');
date_default_timezone_set($db_config['timezone']);
if (substr(PHP_VERSION, 0, 1) == '7') {
	include_once(LIB_PATH."mysqli.class.php");
}else{
	include_once(LIB_PATH."mysql.class.php");
}

include_once(LIB_PATH.'libs/Smarty.class.php');
$phpyun = new Smarty;
$phpyun->debugging      = false;
$phpyun->caching        = false;
$phpyun->force_cache    = false;
$phpyun->template_dir   = TPL_PATH;
$phpyun->compile_dir    = DATA_PATH.'/templates_c/';
$phpyun->left_delimiter = '{yun:}';
$phpyun->right_delimiter= '{/yun}';
$phpyun->get_install();
$phpyun->clearCache();

if(is_file(LIB_PATH.'webscan360/360safe/360webscan.php')){
	require_once(LIB_PATH.'webscan360/360safe/360webscan.php');
}

$db = new mysql($db_config['dbhost'], $db_config['dbuser'], $db_config['dbpass'], $db_config['dbname'], ALL_PS, $db_config['charset'],$db_config['def']);

include_once(LIB_PATH.'public.function.php');
include_once(LIB_PATH.'public.domain.php');
include(LIB_PATH.'public.url.php');

include(PLUS_PATH.'seo.cache.php');

?>