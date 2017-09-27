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
		$this->seo('advice');
		$this->yun_tpl(array('index'));
	}
	function savequestion_action(){
		session_start();
		if($_POST['infotype']==''){
			$this->ACT_layer_msg("请选择意见类型!",8);
		}elseif($_POST['username']==''){
			$this->ACT_layer_msg("请填写联系人姓名!",8);
		}elseif($_POST['telphone']==''){
			$this->ACT_layer_msg("请填写联系手机!",8);
		}elseif($_POST['content']==''){
			$this->ACT_layer_msg("请填写反馈内容!",8);
		}elseif($_POST['authcode']==''){
			$this->ACT_layer_msg("请填写验证码!",8);
		}elseif(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode']){
			unset($_SESSION['authcode']);
			$this->ACT_layer_msg("验证码错误!",8);
		}else{
			$_POST['ctime']=time();
			$data=array(
					'username'=>$_POST['username'],
					'ctime'=>$_POST['ctime'],
					'infotype'=>$_POST['infotype'],
					'content'=>$_POST['content'],
					'mobile'=>$_POST['telphone']
			);
			$nid=$this->obj->insert_into("advice_question",$data);
			if($nid){
				$this->ACT_layer_msg("提交成功,感谢你的反馈！",9,"index.php?m=advice");
			}else{
				$this->ACT_layer_msg("提交失败，请重新填写！",8,"index.php?m=advice");
			}
			
		} 
	}
}
?>