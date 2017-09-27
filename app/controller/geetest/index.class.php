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
class index_controller extends common{
	function index_action(){

		session_start();

		require_once LIB_PATH . '/class.geetestlib.php';
		
		$GtSdk = new GeetestLib($this->config['sy_geetestid'], $this->config['sy_geetestkey']);
		
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
		$str ="";  
		for ( $i = 0; $i < 4; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);   
		}
		$user_id = $str;

		$data = array(
				"user_id" => $user_id, 
				"client_type" => "web", 
				"ip_address" => "127.0.0.1" 
		);

		$status = $GtSdk->pre_process($data, 1);

		$_SESSION['gtserver'] = $status;
		$_SESSION['user_id'] = $str;
		echo $GtSdk->get_response_str();
	}
	
}
?>