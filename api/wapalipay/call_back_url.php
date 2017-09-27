<?php
error_reporting(0);

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");


$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	$out_trade_no = $_GET['out_trade_no'];

	$trade_no = $_GET['trade_no'];

	$result = $_GET['result'];

	$out_trade_no = $_GET['out_trade_no'];

	$trade_no = $_GET['trade_no'];

	$result = $_GET['result'];
    $dingdan           = $out_trade_no;
    $total_fee         = $_GET['total_fee'];
    $sOld_trade_status = "0";
	if(!preg_match('/^[0-9]+$/', $dingdan)){
		die;
	}

    if(($result == 'TRADE_FINISHED') || ($result == 'TRADE_SUCCESS') || ($result == 'success') ) {

		require_once(APP_PATH.'app/public/common.php');
		require_once(LIB_PATH.'ApiPay.class.php');

		$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
		
		$apiPay->payAll($out_trade_no,$total_fee,'wapalipay');
    }
    else {
		echo '<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>支付宝即时到账交易接口</title>
	</head>
    <body>'."trade_status=".$_GET['trade_status'].'</body></html>';die;
    }
}
else {
	echo "验证失败";die;
}

if(!($config['sy_wapdomain'])){
	$wapdomain=$config['sy_weburl'].'/'.$config['sy_wapdir'];
}else{
	$wapdomain=$config['sy_wapdomain'];
}

$member_sql=$db->query("SELECT * FROM `".$db_config["def"]."member` WHERE `uid`='".$_COOKIE['uid']."' limit 1");
$member=$db->fetch_array($member_sql);
if($member['usertype'] != $_COOKIE['usertype']||md5($member['username'].$member['password'].$member['salt'])!=$_COOKIE['shell']){
    echo '登录信息验证错误，请重新登录！';die;
}

if ($member['usertype']==1){
    $Loaction=$wapdomain."/member/index.php?c=paylog";
}elseif ($member['usertype']==2){
    $Loaction=$wapdomain."/member/index.php?c=com";
}
header("Location:".$Loaction);
?>