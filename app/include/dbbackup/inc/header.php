<?php
require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/global.php');
global $db_config,$db,$config;
@require('config.php');
include(APP_PATH.'/app/include/dbbackup/class/functions.php');
$editor=2;

$mydbname=$db_config['dbname'];
$mypath=$_GET['mypath'];
if(empty($mydbname)||empty($mypath)){
}
SetCharset($db_config['charset']);
$usql=$db->query("use `$mydbname`");
?>