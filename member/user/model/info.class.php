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
class info_controller extends user{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		 
		$save=$this->obj->DB_select_once("lssave","`uid`='".$this->uid."'and `savetype`='1'");
		$save=unserialize($save['save']);
		if($save['lastupdate']){
			$save['time']=date('H:i',ceil(($save['lastupdate'])));
		} 
		$row['wxewm']=str_replace("./",$this->config['sy_weburl']."/",$row['wxewm']);
		$nametype=array('1'=>'完全公开','2'=>'显示编号','3'=>'隐藏名字');
		$this->yunset("nametype",$nametype);
		$this->yunset("save",$save);
		$this->yunset("row",$row);
		$this->public_action();
		$this->city_cache();
		$this->user_cache();
		$this->user_tpl('info');
	}
	function save_action(){
		if($_POST['submitBtn']){
			$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
			if($_FILES['wxewm']['tmp_name']){
			    $upload=$this->upload_pic("../data/upload/user/",false,$this->config['user_pickb']);
			    $pictures=$upload->picture($_FILES['wxewm']);
			    $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
			    $pictures = str_replace("../data/upload/user","./data/upload/user",$pictures);
			    $_POST['wxewm']=$pictures;
			}
			if($row['email_status']!=1&&!empty($_POST['email'])){
				$email=$this->obj->DB_select_num("member","`uid`<>'".$this->uid."' and `email`='".$_POST['email']."'","`uid`");
				if($email>0){
					$this->ACT_layer_msg("邮箱已存在！",8);
				}else{
					$mvalue['email']=$_POST['email'];
				}
			}else{
				$mvalue['email']=$_POST['email'];
			}
			if($row['moblie_status']!=1){
				$mobile=$this->obj->DB_select_once("member","`uid`<>'".$this->uid."' and `moblie`='".$_POST['telphone']."'","`uid`");
				if($mobile>0){
					$this->ACT_layer_msg("手机已存在！",8);
				}else{
					$mvalue['moblie']=$_POST['telphone'];
				}
			}
			unset($_POST['submitBtn']);
			delfiledir("../data/upload/tel/".$this->uid);
			$_POST['lastipdate']=time();
			$where['uid']=$this->uid;
			$nid=$this->obj->update_once('resume',$_POST,$where);
			$resume_num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
			
			if($resume_num<1){
				$url="index.php?c=expect";
			}else{
				$url=$_SERVER['HTTP_REFERER'];
			}
		if ($nid){
				if(!empty($mvalue)){
					$this->obj->update_once('member',$mvalue,$where);
				}
				$this->obj->DB_delete_all("lssave","`uid`='".$this->uid."'and `savetype`='1'");
				$this->obj->member_log("修改基本信息",7);
				if($row['name']==""||$row['living']==""){ 
					$this->company_invtal($this->uid,$this->config['integral_userinfo'],true,"首次填写基本资料",true,2,'integral',25);
				}else{
					$this->obj->update_once("resume_expect",array("edu"=>$_POST['edu'],"exp"=>$_POST['exp'],"uname"=>$_POST['name'],"sex"=>$_POST['sex'],"birthday"=>$_POST['birthday']),$where);
				}
				$this->ACT_layer_msg("信息更新成功！",9,$url);
			}else{
				$this->ACT_layer_msg("信息更新失败！",8,$url);
			}
		}
	}
	function phototype_action(){
		$this->obj->DB_update_all("resume","`phototype`='".intval($_POST['phototype'])."'","uid='".$this->uid."'");
		$this->obj->DB_update_all("resume_expect","`phototype`='".intval($_POST['phototype'])."'","uid='".$this->uid."'");
		echo $_POST['phototype'];die();
	}
	function upewm_action(){
	    if ($_POST['uppic']){
	        $resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","wxewm");
	        if(is_uploaded_file($_FILES['wxewm']['tmp_name'])){
	            $upload=$this->upload_pic("../data/upload/user/",false);
	            $pictures=$upload->picture($_FILES['wxewm']);
	            $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
	            $wxewm = str_replace("../data","./data",$pictures);
	            if($resume['wxewm']){
	                unlink_pic(".".$resume['wxewm']);
	            }
	            $id=$this->obj->DB_update_all('resume',"`wxewm`='".$wxewm."'","`uid`='".$this->uid."'");
	
	            if($id){
	                unlink_pic(".".$resume['wxewm']);
	                $data['url']=$pictures;
	            }else{
	                $data['msg']=iconv('gbk','utf-8','上传失败');
	            }
	        }else{
	            $data['msg']=iconv('gbk','utf-8','请上传二维码');
	        }
	        echo json_encode($data);
	    }
	}
}
?>