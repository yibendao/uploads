<?php
/* *
 * 功能：支付宝页面跳转同步通知页面
 */

error_reporting(0);
require_once("class/alipay_notify.php");
require_once("alipay_config.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");



?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码

	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号

	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号

	$trade_no = $_GET['trade_no'];

	if(!preg_match('/^[0-9]+$/', $_GET['out_trade_no'])){
		die;
	}
	//交易状态
	$trade_status	  = $_GET['trade_status'];

	$dingdan          = $_GET['out_trade_no'];    //获取订单号

    if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {

		
		require_once(APP_PATH.'app/public/common.php');
		require_once(LIB_PATH.'ApiPay.class.php');

		$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
		
		$apiPay->payAll($dingdan,$total_fee,'alipay');
		header("Location:".$config['sy_weburl']."/member/index.php?c=paylog");
    }else {
      echo "trade_status=".$_GET['trade_status'];
    }
	echo "支付成功";
}else {

    echo "支付失败";
}
?>
        <title>支付宝纯担保交易接口</title>
	</head>
    <body>
    </body>
</html>