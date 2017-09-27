<?php
/* *
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
		if((int)$_GET['uid']){
			$UserinfoM=$this->MODEL('userinfo');
			$cert=$UserinfoM->GetCompanyCert(array("uid"=>(int)$_GET['uid'],"type"=>6));
			$member=$UserinfoM->GetMemberOne(array("uid"=>(int)$_GET['uid']),array("field"=>"`claim`"));
			if($member['claim']=="1"){
				$this->ACT_msg($this->config['sy_weburl'],"该用户已经被认领！");
			}
		}
		if($cert['check2']!=$_GET['code'] || $cert['check2']==""){
			$this->ACT_msg($this->config['sy_weburl'],"参数不正确！");
		}
		$this->seo("claim");
		$this->yun_tpl(array('index'));
	}
	function save_action(){
		if($_POST['submit']){
			$UserinfoM=$this->MODEL('userinfo');
			$member=$UserinfoM->GetMemberOne(array("uid"=>(int)$_POST['uid']),array("field"=>"`claim`"));
			if($member['claim']=="1"){
				$this->ACT_layer_msg("该用户已经被认领！",8);
			}
			$cert=$UserinfoM->GetCompanyCert(array("uid"=>(int)$_POST['uid'],"type"=>6));
			if($cert['check2']!=$_POST['code'] || $cert['check2']==""){
				$this->ACT_layer_msg("参数不正确！",8,$_SERVER['HTTP_REFERER']);
			}
			$row=$UserinfoM->GetMemberOne(array("username"=>$_POST['username']),array("field"=>"`uid`"));
			if($row['uid']>0){
				$this->ACT_layer_msg("用户名已存在，请重新输入！",8);
			}
			$salt = substr(uniqid(rand()), -6);
			$pass = md5(md5($_POST['password']).$salt);
			$data['username']=$_POST['username'];
			$data['salt']=$salt;
			$data['password']=$pass;
			$data['claim']=1;
			$data['source']=1;
			$UserinfoM->UpdateMember($data,array("uid"=>(int)$_POST['uid']));
			$this->ACT_layer_msg("认领成功！",9,Url("login"));
		}
    }
}