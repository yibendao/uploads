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

///////////页面功能说明///////////////
//该页面可在本机电脑测试
//该页面称作“返回页”，是由支付宝服务器同步调用，可当作是支付完成后的提示信息页，如“您的某某某订单，多少金额已支付成功”。
//可放入HTML等美化页面的代码和订单交易完成后的数据库更新程序代码
//该页面可以使用PHP开发工具调试，也可以使用写文本函数log_result进行调试，该函数已被默认关闭，见alipay_notify.php中的函数return_verify
//TRADE_FINISHED(表示交易已经成功结束，为普通即时到帐的交易状态成功标识);
//TRADE_SUCCESS(表示交易已经成功结束，为高级即时到帐的交易状态成功标识);
///////////////////////////////////
error_reporting(0);
require_once("class/alipay_notify.php");
require_once("alipay_config.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");

//构造通知函数信息
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
//计算得出通知验证结果
$verify_result = $alipay->return_verify();

if($verify_result) {

    //验证成功
    //获取支付宝的通知返回参数
    $dingdan           = $_GET['out_trade_no'];    //获取订单号
    $total_fee         = $_GET['total_fee'];	    //获取总价格
	if(!preg_match('/^[0-9]+$/',$dingdan))
	{
		die;
	}

    /*假设：
	sOld_trade_status="0";表示订单未处理；
	sOld_trade_status="1";表示交易成功（TRADE_FINISHED/TRADE_SUCCESS）；
    */
    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		
		
		
        //放入订单交易完成后的数据库更新程序代码，请务必保证echo出来的信息只有success
        //为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是订单未处理状态

        if ($sOld_trade_status < 1) {
			
            //根据订单号更新订单，把订单处理成交易成功
			require_once(APP_PATH.'app/public/common.php');
			require_once(LIB_PATH.'ApiPay.class.php');
			$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');

			$apiPay->payAll($dingdan,$total_fee,'alipay');
        }
		header("Location:".$config['sy_weburl']."/member/index.php?c=paylog");
    }else {
      echo "trade_status=".$_GET['trade_status'];	
    }
}else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的return_verify函数，比对sign和mysign的值是否相等，或者检查$veryfy_result有没有返回true
    //echo "fail";
}
?>