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
class admin_user_controller extends common
{
	function index_action(){
		$where=1;
		if($_GET['type']=="d"){
			$where.=" and `did`>'0'";
			$urlarr['type']=$_GET['type'];
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("admin_user",$where." order by uid desc",$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];		
		if(is_array($rows)){
			$adminusergroup=$this->obj->DB_select_all("admin_user_group","`did`='0' order by id desc","`id`,`group_name`");
			foreach($rows as $k=>$v){
				foreach($adminusergroup as $val){
					if($v['m_id']==$val['id']){
						$rows[$k]['group_name']=$val['group_name'];
					}
				}
				if($v['did']>0){
					$dids[]=$v['did'];
				}
			}
			if(!empty($dids)){
				$domain=$this->obj->DB_select_all("domain","`id` in (".@implode(",",$dids).")","`id`,`title`");
				foreach($rows as $k=>$v){
					foreach($domain as $val){
						if($v['did']==$val['id']){
							$rows[$k]['group_name']=$val['title'];
						}
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_user_list'));
	}
	function add_action(){
		if(isset($_GET['uid'])){
			$adminuser=$this->obj->DB_select_once("admin_user","`uid`='".$_GET['uid']."'");
			$this->yunset("adminuser",$adminuser);
		}
		$user_group=$this->obj->DB_select_all("admin_user_group","`did`='".$this->config['did']."' order by `id` desc");
		$this->yunset("user_group",$user_group);
		$this->yuntpl(array('admin/admin_user_add'));
	}
	function group_action(){
		$adminusergroup=$this->obj->DB_select_all("admin_user_group","`did`='".$this->config['did']."' order by id desc");
		$num=$this->obj->DB_select_all("admin_user","`did`='0' or `isdid`='1' group by m_id desc","`m_id`,count(uid) as num");
		foreach($adminusergroup as $key=>$val){
			$adminusergroup[$key]['num']=0;
			foreach($num as $v){
				if($val['id']==$v['m_id']){
					$adminusergroup[$key]['num']=$v['num'];
				}
			}
		}
		$this->yunset("adminusergroup",$adminusergroup);
		$this->yuntpl(array('admin/admin_group_list'));
	}
	function myuser_action(){
		$where="`uid`='".$_SESSION['auid']."'";
		$adminuser=$this->obj->DB_select_once("admin_user",$where);
		$this->yunset("adminuser",$adminuser);
		$user_group=$this->obj->DB_select_once("admin_user_group","`id`='".$adminuser['m_id']."' and `did`='".$this->config['did']."'");
		$this->yunset("user_group",$user_group);
		$this->yuntpl(array('admin/admin_myuser'));
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
	function addgroup_action(){
		if((int)$_GET['id']){
			$where="`id`='".$_GET['id']."' and `did`='".$this->config['did']."'";
			$admingroup=$this->obj->DB_select_once("admin_user_group",$where);
			$this->yunset("admin_group",$admingroup);
			$this->yunset("power",unserialize($admingroup[2]));
		}
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION['auid']."' and b.`did`='".$this->config['did']."'");
		$menurows=$this->obj->DB_select_all("admin_navigation","`display`<>1 order by `sort` desc");
		$i=0;$j=0;$a=0;$b=0;
		if(is_array($menurows)){
			foreach($menurows as $key=>$v){
				if($v['keyid']==0){
					$navigation[$i]['id']=$v['id'];
					$navigation[$i]['name']=$v['name'];
					$i++;
				}
				if($v['menu']==2){
					$menu[$j]['id']=$v['id'];
					$menu[$j]['name']=$v['name'];
					$menu[$j]['url']=$v['url'];
					$j++;
				}
			}
		}
		if(is_array($navigation)){
			foreach($navigation as $va){
				if(is_array($menurows)){
					foreach($menurows as $key=>$v){
						if($v['keyid']==$va['id']){
							if(!is_array($one_menu[$va['id']]))$a=0;
							$one_menu[$va['id']][$a]['id']=$v['id'];
							$one_menu[$va['id']][$a]['name']=$v['name'];
							$a++;
							foreach($menurows as $key=>$vaa){
								if($vaa['keyid']==$v['id']){
									if(!is_array($two_menu[$v['id']]))$b=0;
									$two_menu[$v['id']][$b]['id']=$vaa['id'];
									$two_menu[$v['id']][$b]['name']=$vaa['name'];
									$two_menu[$v['id']][$b]['url']=$vaa['url'];
									$b++;
								}
							}
						}
					}
				}
			}
		}
		$power=unserialize($nav_user[0]['group_power']);
		$this->yunset("one_menu",$one_menu);
		$this->yunset("two_menu",$two_menu);
		$this->yunset("navigation",$navigation);
		$this->yuntpl(array('admin/admin_group'));
	}
	function save_action()
	{
		if(isset($_POST['useradd'])){
			if(!empty($_POST['username'])&&!empty($_POST['name'])){
				$user=$this->obj->DB_select_once("admin_user","`username`='".trim($_POST['username'])."'");
				if($user['uid']&&$_POST[uid]!=$user['uid']){
					$this->ACT_layer_msg( "用户名已存在！",8);
				}
				$value="`m_id`='".$_POST['m_id']."',`username`='".$_POST['username']."',`name`='".$_POST['name']."'";
				if($_POST['password']){
					$value.=",`password`='".md5($_POST['password'])."'";
				}
				if($_POST['did']){
					$value.=",`did`='".$_POST['did']."'";
				}
				if($_POST['isdid']){
					$value.=",`isdid`='".(int)$_POST['isdid']."'";
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
				$this->layer_msg('非法操作！',8);
			}
		}
	}
	function deluser_action()
	{
		$this->check_token();
		if(isset($_GET['uid'])){
			$where="`uid`='".$_GET['uid']."'";
			$result=$this->obj->DB_delete_all("admin_user", $where);
			isset($result)?$this->layer_msg('管理员（ID:'.$_GET['uid'].'）删除成功！',9):$this->layer_msg('删除失败！',8);
		}else{
			$this->layer_msg('非法操作！',8);
		}
	}
	function delgroup_action()
	{
		$this->check_token();
		if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."' and `did`='".$this->config['did']."'";
			$result=$this->obj->DB_delete_all("admin_user_group",$where);
			isset($result)?$this->layer_msg('用户组（ID：'.$_GET['id'].'）删除成功！',9):$this->layer_msg('删除失败！',8);
		}else{
			$this->layer_msg('非法操作！',8);
		}
	}
	function savagroup_action(){
		extract($_POST);
		$value="`group_name`='".$group_name."',`group_power`='".serialize($power)."'";
		if($group_type=='2'){
			$this->obj->DB_update_all("admin_user_group","`group_type`='1'","`did`='".$this->config['did']."'");
			$value.=",`group_type`='2'";
		}
		if(!$groupid){
			$value.=",`did`='".$this->config['did']."'";
			$id=$this->obj->DB_insert_once("admin_user_group",$value);
			isset($id)?$this->ACT_layer_msg( "用户组(ID：".$id.")添加成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "用户组添加失败！",8,$_SERVER['HTTP_REFERER']);
		}else{

			$result=$this->obj->DB_update_all("admin_user_group", $value,"`id`='".$groupid."' and `did`='".$this->config['did']."'");
			isset($result)?$this->ACT_layer_msg( "用户组(ID：".$groupid.")修改成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "修改失败！",8,$_SERVER['HTTP_REFERER']);
		}
	}
}

?>