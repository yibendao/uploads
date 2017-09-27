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
class advice_controller extends common{
	function index_action(){
		$this->seo('advice');
		$this->yunset("backurl",Url('wap'));
		$this->yunset("headertitle","意见反馈");
		$this->yuntpl(array('wap/advice'));
	}

	function saveadd_action(){
		session_start();
		$_POST['content']=iconv("utf-8","gb2312",$_POST['content']);
		$_POST['username']=iconv("utf-8","gb2312",$_POST['username']);
		if($_POST['infotype']==''){
			echo 2;die;
		}elseif($_POST['username']==''){
			echo 3;die;
		}elseif($_POST['moblie']==''){
			echo 4;die;
		}elseif($_POST['content']==''){
			echo 5;die;
		}elseif($_POST['authcode']==''){
			echo 6;die;
		}elseif(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode']){
			unset($_SESSION['authcode']);
			echo 0;die;
		}else{
			$_POST['ctime']=time();
			$data=array(
					'username'=>$_POST['username'],
					'ctime'=>$_POST['ctime'],
					'infotype'=>$_POST['infotype'],
					'content'=>$_POST['content'],
					'mobile'=>$_POST['moblie']
			);
			$nid=$this->obj->insert_into("advice_question",$data);
			if($nid){echo 1;die;}else{echo 7;die;}
		}
	}
}
?>