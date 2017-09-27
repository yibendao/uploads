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
//财付通即时到帐支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------
error_reporting(0);

require_once ("classes/PayRequestHandler.class.php");

require_once(dirname(dirname(dirname(__FILE__)))."/data/api/tenpay/tenpay_data.php");
require_once(dirname(dirname(dirname(__FILE__)))."/config/db.config.php");
require_once(dirname(dirname(dirname(__FILE__)))."/config/db.safety.php");
require_once(dirname(dirname(dirname(__FILE__)))."/data/plus/config.php");
if (substr(PHP_VERSION, 0, 1) == '7') {
	require_once(dirname(dirname(dirname(__FILE__)))."/app/include/mysqli.class.php");
}else{
	require_once(dirname(dirname(dirname(__FILE__)))."/app/include/mysql.class.php");
}
$db = new mysql($db_config['dbhost'], $db_config['dbuser'], $db_config['dbpass'], $db_config['dbname'], ALL_PS, $db_config['charset']);
if(!is_numeric($_POST['dingdan']))
{
	die;
}

$_COOKIE['uid']=(int)$_COOKIE['uid'];

$member_sql=$db->query("SELECT * FROM `".$db_config["def"]."member` WHERE `uid`='".$_COOKIE['uid']."' limit 1");
$member=$db->fetch_array($member_sql);
if($member['usertype'] != $_COOKIE['usertype']||md5($member['username'].$member['password'].$member['salt'])!=$_COOKIE['shell']){
	echo '登录信息验证错误，请重新登录！';die;
}
$sql=$db->query("select * from `".$db_config["def"]."company_order` where `order_id`='$_POST[dingdan]' AND `order_price`>=0");
$row=$db->fetch_array($sql);
if(!$row['uid'] || $row['uid']!=$_COOKIE['uid'])
{
	die;
}
/* 商户号 */
$bargainor_id = $tenpaydata[sy_tenpayid];

/* 密钥 */
$key = $tenpaydata[sy_tenpaycode];

/* 返回处理地址 */
$return_url = $tenpaydata[sy_weburl]."/api/tenpay/return_url.php";

//date_default_timezone_set(PRC);
$strDate = date("Ymd");
$strTime = date("His");

//4位随机数
$randNum = rand(1000, 9999);

$attach=$_POST[pay_type];

//10位序列号,可以自行调整。
$strReq = $strTime . $randNum;

/* 商家订单号,长度若超过32位，取前32位。财付通只记录商家订单号，不保证唯一。 */
$sp_billno = $_POST[dingdan];

/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
$transaction_id =trim($bargainor_id.$strDate.$strReq);

/* 商品价格（包含运费），以分为单位 */
$total_fee = $row[order_price]*100;
//$total_fee = 1;

/* 商品名称 */
$desc = "订单号：" . $transaction_id;

/* 创建支付请求对象 */
$reqHandler = new PayRequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);
//----------------------------------------
//设置支付参数
//----------------------------------------
$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
$reqHandler->setParameter("total_fee", $total_fee);					//商品总金额,以分为单位
$reqHandler->setParameter("return_url", $return_url);				//返回处理地址
$reqHandler->setParameter("desc", "订单号：" . $transaction_id);	    //商品名称
$reqHandler->setParameter("attach", $attach);			        	//自定义参数
//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
//$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);



//请求的URL
$reqUrl = $reqHandler->getRequestURL();


//debug信息
//$debugInfo = $reqHandler->getDebugInfo();

//echo "<br/>" . $reqUrl . "<br/>";
//echo "<br/>" . $debugInfo . "<br/>";

//重定向到财付通支付
//$reqHandler->doSend();
Header("Location:$reqUrl");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk">
	<title>财付通即时到帐程序</title>
</head>
<body>
<script>//location.href='<?php echo $reqUrl;?>';</script>
</body>
</html>
