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
include(dirname(dirname(__FILE__))."/global.php");

$DirNameList=explode('\\',dirname(__FILE__));
$ModuleName=end($DirNameList);

if($_GET['c'] && !preg_match("/^[0-9a-zA-Z\_]*$/",$_GET['c'])){
	$_GET['c'] = 'index';
}
$model = $_GET['c'];
$action = $_GET['act'];
if($model=="")	$model="index";
if($action=="")	$action = "index"; 
$usertype=$_COOKIE['usertype'];
if($usertype==1){
	$type="user";
}else if($usertype==2){
	$type="com";
}else{
	header('Location: '.Url('login'));die;
}

require(APP_PATH.'app/public/common.php');
if($_GET['m']=='ajax'){
    require('ajax.class.php');
    $model=$_GET['m'];
    $action=$_GET['c'];
}else{
    require($type."/".$type.'.class.php');
    require($type."/model/".$model.'.class.php');
}

$conclass=$model.'_controller';
$actfunc=$action.'_action';

$views=new $conclass($phpyun,$db,$db_config["def"],"member");
if(!method_exists($views,$actfunc)){
	$views->DoException();
}
$views->obj=$views->MODEL('userinfo');
$views->$actfunc();
?>