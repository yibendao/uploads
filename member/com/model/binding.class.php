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
class binding_controller extends company{
	function index_action(){
		$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		$this->yunset("member",$member);
		if(($member['qqid']!=""||$member['wxid']!=""||$member['unionid']!=""||$member['sinaid']!="") && $member['restname']=="0"){
			$this->yunset("setname",1);
		}
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$this->yunset("company",$company);
		$cert=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='3'");
		if ($cert['check']){
		    $cert['check']=str_replace('./','../', $cert['check']);
		}
		$this->yunset("cert",$cert);
		$this->public_action();
		$this->get_user();
		$this->yunset("js_def",2);
		$this->com_tpl("binding");
	}
	function save_action(){
		if($_POST['moblie']){
			$row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and `check`='".$_POST['moblie']."' and `type`='2'");
			if(!empty($row)){
				if($row['check2']!=$_POST['code']){
					echo 3;die;
				}
				
				$this->obj->DB_update_all("member","`moblie`=''","`moblie`='".$row['check']."'");
				$this->obj->DB_update_all("resume","`moblie_status`='0',`telphone`=''","`telphone`='".$row['check']."'");
				$this->obj->DB_update_all("company","`moblie_status`='0',`linktel`=''","`linktel`='".$row['check']."'");
				$this->obj->DB_update_all("member","`moblie`='".$row['check']."'","`uid`='".$this->uid."'");
				$this->obj->DB_update_all("company","`linktel`='".$row['check']."',`moblie_status`='1'","`uid`='".$this->uid."'");
				$this->obj->DB_update_all("company_cert","`status`='1'","`uid`='".$this->uid."' and `check2`='".$_POST['code']."'");
				$this->obj->member_log("手机绑定");
				$pay=$this->obj->DB_select_once("company_pay","`pay_remark`='手机绑定' and `com_id`='".$this->uid."'");
				if(empty($pay)){
					$this->get_integral_action($this->uid,"integral_mobliecert","手机绑定");
				}
				echo 1;die;
			}else{
				echo 2;die;
			}
		}
	    if($_POST['upfile']){
		    $row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='3'");
	        if($this->config['com_cert_status']=="1"){
				$sql['status']=0;
			}else{
				$sql['status']=1;
			}
			if ($_POST['upfile']=='info'){
			    $company_name=iconv('utf-8','gbk',$_POST['company_name']);
			}else{
			    $company_name=$_POST['company_name'];
			}
			$this->obj->DB_update_all("company","`name`='".$company_name."',`yyzz_status`='".$sql['status']."'","`uid`='".$this->uid."'");
			$sql['step']=1;
			$sql['check']=str_replace('../','./', $_POST['com_cert']);
			$sql['check2']="0";
			$sql['ctime']=mktime();
			if(is_array($row)){
				$where['uid']=$this->uid;
				$where['type']='3';
				$id=$this->obj->update_once("company_cert",$sql,$where);
				$this->obj->member_log("更新营业执照");
			}else{
				$sql['uid']=$this->uid;
				$sql['did']=$this->userdid;
				$sql['type']=3;
				$id=$this->obj->insert_into("company_cert",$sql);
				$this->obj->member_log("上传营业执照");
				if($this->config['com_cert_status']!="1"){
					$this->get_integral_action($this->uid,"integral_comcert","认证营业执照");
				}
			}
		    if($id){
		        $this->ACT_layer_msg("上传成功！",9,1);
		    }else{
		        $this->ACT_layer_msg("上传失败！",9,1);
		    }
		}
		if ($_POST['uppic']){
		    $row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='3'");
		    if(is_uploaded_file($_FILES['pic']['tmp_name'])){
		        $upload=$this->upload_pic("../data/upload/cert/",false,$this->config['com_uppic']);
		        $pictures=$upload->picture($_FILES['pic']);
		        $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
		        $pic = str_replace("../data/upload/cert","./data/upload/cert",$pictures);
		        $id=$this->obj->DB_update_all('company_cert',"`check`='".$pic."'","`uid`='".$this->uid."' and type=3");
		
		        if($id){
		            unlink_pic(".".$row['check']);
		            $data['url']=$pictures;
		        }else{
		            $data['msg']=iconv('gbk','utf-8','上传失败');
		        }
		    }else{
		        $data['msg']=iconv('gbk','utf-8','请上传营业执照');
		    }
		    echo json_encode($data);
		}
	}
	
	function del_action(){
		if($_GET['type']=="moblie"){
			$this->obj->DB_update_all("company","`moblie_status`='0'","`uid`='".$this->uid."'");
		}
		if($_GET['type']=="email"){
			$this->obj->DB_update_all("company","`email_status`='0'","`uid`='".$this->uid."'");
		}
		if($_GET['type']=="qqid"){
			$this->obj->DB_update_all("member","`qqid`=''","`uid`='".$this->uid."'");
		}
		if($_GET['type']=="sinaid"){
			$this->obj->DB_update_all("member","`sinaid`=''","`uid`='".$this->uid."'");
		}
		if($_GET['type']=="wxid"){
			$this->obj->DB_update_all("member","`wxid`='',`wxopenid`='',`unionid`=''","`uid`='".$this->uid."'");
		}
		$this->layer_msg("解除绑定成功！",9,0,$_SERVER['HTTP_REFERER']);
	}
}
?>