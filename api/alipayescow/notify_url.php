<?php


error_reporting(0);
require_once("class/alipay_notify.php");
require_once("alipay_config.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	if(!preg_match('/^[0-9]+$/', $_POST['out_trade_no'])){
		die;
	}
    //验证成功
    //获取支付宝的反馈参数
    $dingdan           = $_POST['out_trade_no'];	    //获取支付宝传递过来的订单号
	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
	//已提交订单，但未付款，不做处理

        echo "success";

    }else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功

		
		
		require_once(APP_PATH.'app/public/common.php');
		require_once(LIB_PATH.'ApiPay.class.php');

		$apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
		
		$apiPay->payAll($dingdan,$total_fee,'alipay');

    }
	else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {//该判断表示卖家已经发了货，但买家还没有

        echo "success";
    }
	else if($_POST['trade_status'] == 'TRADE_FINISHED') {//该判断表示买家已经确认收货，这笔交易完成




        echo "success";


    }
    else {
		//其他状态判断
        echo "success";

    }


}
else {

    echo "fail";

}
?>