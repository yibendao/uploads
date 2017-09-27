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
class admin_siteadmin_controller extends common
{
	function index_action(){
		$group=$this->obj->DB_select_once("admin_user_group","`group_type`='2'");
		if($group['id']==''){
			$this->yunset("nogroup",1);
		} 
		if(isset($_GET['uid'])){
			$adminuser=$this->obj->DB_select_once("admin_user","`uid`='".$_GET['uid']."'");
			$this->yunset("adminuser",$adminuser);
		}
		$domain=$this->obj->DB_select_all("domain","1 order by `id` desc","`id`,`title`");
		$this->yunset("domain",$domain);
		$this->yuntpl(array('admin/admin_siteadmin'));
	}  
	function pass_action(){
		if($_POST['useradd']){
			$_POST['oldpass']=trim($_POST['oldpass']);
			$_POST['password']=trim($_POST['password']);
			$where="`uid`='".$_SESSION['auid']."'";
			$row=$this->obj->DB_select_once("admin_user",$where);
			if($_POST['oldpass']==''||$_POST['password']==''){
				$this->ACT_layer_msg("原始密码、新密码均不能为空！",8,$_SERVER['HTTP_REFERER']);
			}
			if($_POST['oldpass']==$_POST['password']){
				$this->ACT_layer_msg("新密码和原始密码一致，不需要修改！",8,$_SERVER['HTTP_REFERER']);
			}
			if(md5($_POST['oldpass'])!=$row['password']){
				$this->ACT_layer_msg("原始密码不正确！",8,$_SERVER['HTTP_REFERER']);
			}
			if($_POST['password']!=$_POST['okpassword']){
				$this->ACT_layer_msg("新密码两次输入不一致！",8,$_SERVER['HTTP_REFERER']);
			}
			$value.="`password`='".md5($_POST['password'])."'";
			$nbid=$this->obj->DB_update_all("admin_user",$value,$where);
			unset($_SESSION['authcode']);
			unset($_SESSION['auid']);
			unset($_SESSION['ausername']);
			unset($_SESSION['ashell']);
			$this->ACT_layer_msg("管理员(ID:".$row['uid']."帐号".$row['username'].")密码修改成功,请重新登录！",9,$_SERVER['HTTP_REFERER'],2,1);
		}

		$this->yuntpl(array('admin/admin_mypass'));
	} 
	function save_action(){
		if(isset($_POST['useradd'])){
			if(!empty($_POST['username'])&&!empty($_POST['name'])){
				$group=$this->obj->DB_select_once("admin_user_group","`group_type`='2'");
				if($group['id']==''){
					$this->ACT_layer_msg("暂无分站管理员组！",8,$_SERVER['HTTP_REFERER']);
				} 
				$value="`m_id`='".$group['id']."',`username`='".$_POST['username']."',`name`='".$_POST['name']."'";
				if($_POST['password']){
					$value.=",`password`='".md5($_POST['password'])."'";
				}
				if($_POST['did']){
					$value.=",`did`='".(int)$_POST['did']."'";
				}

				if(!$_POST[uid]){
				 	$nbid=$this->obj->DB_insert_once("admin_user","$value");
					$name="管理员（ID:".$nbid."）添加";
				 }else{ 
				 	$nbid=$this->obj->DB_update_all("admin_user",$value,"`uid`='".$_POST['uid']."'");
				 	if($_POST['uid']==$_SESSION['auid']){
						unset($_SESSION['authcode']);
						unset($_SESSION['auid']);
						unset($_SESSION['ausername']);
						unset($_SESSION['ashell']);
						$this->ACT_layer_msg( "管理员(ID:".$_POST['uid'].")修改成功,请重新登录！",9,$_SERVER['HTTP_REFERER'],2,1);
				 	}
				 	$name="管理员(ID:".$_POST['uid'].")更新";
				 }
				isset($nbid)?$this->ACT_layer_msg($name."成功！",9,"index.php?m=admin_user",2,1):$this->ACT_layer_msg($name."失败！",8,"index.php?m=admin_user");
			}else{
				$this->ACT_layer_msg( "请填写完整！",8,$_SERVER['HTTP_REFERER']);
			}
		}
	} 
}

?>