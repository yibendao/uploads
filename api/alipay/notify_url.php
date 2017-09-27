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

/////////////////////////////////////
error_reporting(0);
require_once("class/alipay_notify.php");
require_once("alipay_config.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");

$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);    //构造通知函数信息
$verify_result = $alipay->notify_verify();  //计算得出通知验证结果
if($verify_result) {
	if(!preg_match('/^[0-9]+$/', $_POST['out_trade_no'])){
		die;
	}
    //验证成功
    //获取支付宝的反馈参数
    $dingdan           = $_POST['out_trade_no'];	    //获取支付宝传递过来的订单号
    $total_fee         = $_POST['total_fee'];	    //获取支付宝传递过来的总价格

    /*假设：
	sOld_trade_status="0";表示订单未处理；
	sOld_trade_status="1";表示交易成功（TRADE_FINISHED/TRADE_SUCCESS）；
    */
    if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') {    //交易成功结束
         //放入订单交易完成后的数据库更新程序代码，请务必保证echo出来的信息只有success
        //为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是订单未处理状态 

			if($sOld_trade_status < 1) {
				//根据订单号更新订单，把订单处理成交易成功
				require_once(APP_PATH.'app/public/common.php');
				require_once(LIB_PATH.'ApiPay.class.php');

				$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
				
				$apiPay->payAll($dingdan,$total_fee,'alipay');
			}
			echo "success";

			//调试用，写文本函数记录程序运行情况是否正常
			//log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
		 
	} else {
        echo "success";		//其他状态判断。普通即时到帐中，其他状态不用判断，直接打印success。

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
}else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>