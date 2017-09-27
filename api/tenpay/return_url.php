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
//---------------------------------------------------------
//财付通即时到帐支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
error_reporting(0);
require_once ("./classes/PayResponseHandler.class.php");
require_once(dirname(dirname(dirname(__FILE__)))."/data/api/tenpay/tenpay_data.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");
/* 密钥 */
$key =$tenpaydata[sy_tenpaycode];

/* 创建支付应答对象 */
$resHandler = new PayResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {

	//交易单号
	$transaction_id = $resHandler->getParameter("transaction_id");

	//本站单号
	$sp_billno = $resHandler->getParameter("sp_billno");

	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");

	//支付结果
	$pay_result = $resHandler->getParameter("pay_result");
	//类型
	$attach = $resHandler->getParameter("attach");

	if( "0" == $pay_result ) {

		//------------------------------
		//处理业务开始
		//------------------------------

		//注意交易单不要重复处理
		//注意判断返回金额
//处理本站信息开始
	if(!preg_match('/^[0-9]+$/',$sp_billno))
	{
		die;
	}
	require_once(APP_PATH.'app/public/common.php');
	require_once(LIB_PATH.'ApiPay.class.php');

	$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
	
	$apiPay->payAll($sp_billno,$total_fee,'tenpay');
	

//处理本站信息结束




		//------------------------------
		//处理业务完毕
		//------------------------------

		//调用doShow, 打印meta值跟js代码,告诉财付通处理成功,并在用户浏览器显示$show页面.
		//$show = $tenpaydata[sy_weburl]."/app/tenpay/show.php";
		//$resHandler->doShow($show);
		header("Location:".$config['sy_weburl']."/member/index.php?c=paylog");
	} else {
		//当做不成功处理
		echo "<br/>" . "支付失败" . "<br/>";
	}

} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
}

//echo $resHandler->getDebugInfo();

?>