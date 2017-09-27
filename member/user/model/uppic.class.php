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
class uppic_controller extends user{
	function index_action(){
		$this->public_action();
    
		$file_max_size = (float)($this->config['user_pickb']) / 1024;
		$this->yunset('file_max_size',$file_max_size);
		
		$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		$this->yunset("row",$row);
		$this->user_tpl('uppic');
	}
	function uppath(){
		$upload_path = "../data/upload/user/";
		return $upload_path;
	}
	function ajaxfileupload_action(){

		if($_FILES['image']['tmp_name']){
			$upload=$this->upload_pic("../data/upload/user",false,$this->config['user_pickb']);
			$pictures=$upload->picture($_FILES['image']);
			$picMsg = $this->picmsg($pictures,$_SERVER['HTTP_REFERER'],"ajax");
			if($picMsg){
				$imginfo=$this->getInfo($pictures);
				if($_POST['type']=='info'){
					
					$s_thumb=$upload->makeThumb($pictures,80,100,'_S_');
					unlink_pic($pictures);
					$res["url"] = $s_thumb;
					$this->uplogo(array('1'=>$s_thumb,'2'=>$s_thumb));

				}elseif($imginfo['width']<80 || $imginfo['height']<100){
						unlink_pic($pictures);
						$res['s_thumb'] = iconv('gbk','utf-8','头像尺寸比例太小,最小尺寸：宽80/高100');
				}elseif($imginfo['width']>320 || $imginfo['height']>400){
						$s_thumb=$upload->makeThumb($pictures,320,400,'_S_');
						unlink_pic($pictures);
						$res["url"] = $s_thumb;
				}else{
						$res["url"] = $pictures;
				}

				echo json_encode($res);
			}
		}else{
			$res["s_thumb"] = iconv('gbk','utf-8','请选择上传图片');
			echo json_encode($res);
		}die;
	}
	function getInfo($file){
		$data=getimagesize($file);
		$imageInfo["width"]	= $data[0];
		$imageInfo["height"]= $data[1];
		$imageInfo["type"]	= $data[2];
		$imageInfo["name"]	= basename($file);
		$imageInfo["size"]  = filesize($file);
		return $imageInfo;
	}
	function savethumb_action(){
		$upload_path = $this->uppath();
		$upload_path=ltrim($upload_path,'.');
		if(stripos(trim($_POST['img1']),$upload_path)===false || stripos(trim($_POST['img2']),$upload_path)===false){
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
		include(LIB_PATH."sizer.class.php");
		$sizer=new Sizer("../data/upload/user/".date('Ymd').'/');
		$t_name = $sizer->sizeIt();
		$ref = $this->uplogo($t_name);
		if($ref){$this->obj->member_log("上传头像");echo $ref;}else{echo 2;}
	}
	function uplogo($t_name){
	
		$resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`photo`,`resume_photo`");
		if($resume['photo'] != './'.$this->config['sy_member_icon']){
			unlink_pic('.'.$resume['photo']);
		}
		if($resume['resume_photo'] != './'.$this->config['sy_member_icon']){
			unlink_pic('.'.$resume['resume_photo']);
		}

		if($resume['photo'] == ''){
			$this->get_integral_action($this->uid,"integral_avatar","上传头像");
		}
		$resume_photo=str_replace("../data/upload/user/","./data/upload/user/",$t_name[1]);
		$photo=str_replace("../data/upload/user/","./data/upload/user/",$t_name[2]);
		$ref=$this->obj->update_once("resume",array('resume_photo'=>$resume_photo,'photo'=>$photo),array('uid'=>$this->uid));
		$this->obj->DB_update_all("resume_expect","`photo`='".$photo."'","`uid`='".$this->uid."'");
		return $ref;
	
	}
}
?>