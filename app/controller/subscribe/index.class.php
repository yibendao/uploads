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
		if($this->uid&&$this->usertype=='1'){ 
			$email=$this->MODEL("resume")->SelectResume(array("uid"=>$this->uid),"name,email,email_status");  
		}else if($this->uid&&$this->usertype=='2'){
			$email=$this->MODEL("company")->GetCompanyInfo(array("uid"=>$this->uid),array("field"=>"name,`linkmail` as `email`,email_status")); 
		}  
		if($_POST['submit']){
			if($this->usertype&&$this->usertype!=1&&$this->usertype!=2){
				$this->ACT_layer_msg("只有个人和企业用户才可订阅！",8);
			}
			unset($_POST['submit']);
			$sid=(int)$_POST['sid'];
			if(!$this->CheckRegEmail($_POST['email'])){
				$this->ACT_layer_msg("接收邮箱格式不正确！",8,$_SERVER['HTTP_REFERER']);
			}
			$Subscribe=$this->MODEL("subscribe");
			$info=$Subscribe->GetSubscribeOnce(array("email"=>$_POST['email'],"type"=>(int)$_POST['type']));
			if($info['status']=='1'){
				$email['email_status']=1;
				$email['email']=$info['email'];
			}
			if($info['status']=="1"&&$info['uid']!=$this->uid){
				$this->ACT_layer_msg("该邮箱已设置订阅，请不要重复设置！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$code = substr(uniqid(rand()), -6);
				$_POST['code']=$code;
				$_POST['ctime']=time(); 
				if($sid){
					if($info['email']!=$_POST['email']){
						$_POST['status']=$info['status']=0;
					}else {
						$_POST['status']=$info['status'];
					}
					if($email['email_status']=='1'&&$_POST['email']==$email['email']){
						$_POST['email']=$email['email'];
						$_POST['status']=1;
					}

					unset($_POST['sid']);
					$where['id']=$sid;
					$where['uid']=$this->uid;
					$Subscribe->UpdateSubscribe($_POST,$where);
				}else{
					if($email['email_status']=='1'){
						$_POST['email']=$email['email'];
						$_POST['status']=$info['status']=1;
					}
					$_POST['uid']=$this->uid;
					$sid=$Subscribe->AddSubscribe($_POST);
				}
				
				if($info['status']!="1"){
					$data=array();
					$data['cname']=$email['name'];
					$data['type']="cert";
					$data['code']=$code;
					$data['email']=$_POST['email'];
					$data['date']=date("Y-m-d");
					$base=base64_encode($_POST['email']."|".$code);
					if($this->uid){
					    $data['url']="<a href='".$this->config['sy_weburl']."/index.php?m=subscribe&c=cert&coid=".$base."&id=".$sid."'>点击认证</a>";
					}else{
					    $data['url']="<a href='".$this->config['sy_weburl']."/index.php?m=subscribe&c=cert&coid=".$base."&id=".$sid."&type=6'>点击认证</a>";
					}
					$this->send_msg_email($data);
					$this->ACT_layer_msg("订阅设置成功，请认证邮箱！",9,"index.php?m=subscribe&c=cert&id=".$sid);
				}else{
					$this->ACT_layer_msg("订阅设置成功！",9,"member/index.php?c=subscribe");
				}
			}
		}
        $this->yunset($this->MODEL('cache')->GetCache(array('com','job','user','city'))); 
        
		$sid=(int)$_GET['id'];
		if($sid){
			$Subscribe=$this->MODEL("subscribe");
			$info=$Subscribe->GetSubscribeOnce(array("uid"=>$this->uid,"id"=>$sid));
			$this->yunset("info",$info);
		} 
		$this->yunset("email",$email); 
		$cycle_time=array('3'=>'3天以内','7'=>'1周以内','14'=>'2周以内','21'=>'3周以内','30'=>'1月以内','90'=>'3月以内');
		$this->yunset("cycle_time",$cycle_time);
		$this->seo("subscribe");
		$this->yun_tpl(array('index'));
	}
	function cert_action(){
		$Subscribe=$this->MODEL("subscribe");
		if($_GET['coid']){
			$arr=@explode("|",base64_decode($_GET['coid']));
			$email = $arr[0];
			$code = $arr[1];
			if(!$this->CheckRegEmail($email) || !ctype_alnum($code)){
				exit();
			}else{ 
				$nid=$Subscribe->UpdateSubscribe(array("status"=>"1"),array("email"=>$email,"code"=>$code));
				if($nid&&$this->uid){
					$UserinfoM=$this->MODEL("userinfo");
					$id=(int)$_GET['id'];
					$row=$Subscribe->GetSubscribeOnce(array('id'=>$id,"code"=>$code));
					$info=$UserinfoM->GetMemberOne(array("uid"=>$row['uid']),array("field"=>"usertype,uid"));
					$UserinfoM->UpdateUserinfo(array("usertype"=>$info['usertype'],"values"=>array("email_dy"=>1)),array("uid"=>$info['uid']));
				}
				if ($_GET['type']){
				    header("location:".$this->config['sy_weburl']."/index.php?m=register&c=ok&type=6");
				}else {
				    header("location:".$this->config['sy_weburl']."/index.php?m=register&c=ok&type=4");
				}
			}
		}
		$row=$Subscribe->GetSubscribeOnce(array('id'=>intval($_GET['id']),"uid"=>$this->uid));
		if($row['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],"未找到该记录！");
		}
		$this->yunset("row",$row);
		$this->seo("subscribe");
		$this->yun_tpl(array('cert'));
	}
	function send_email_action(){
		if($_POST['email']){
			$data['type']="cert";
			$code = substr(uniqid(rand()), -6);
			$data['code']=$code;
			$data['date']=date("Y-m-d");
			$data['email']=$_POST['email'];
			$base=base64_encode($_POST['email']."|".$code);
			$url=Url("subscribe",array("c"=>"cert","coid"=>$base));
			$data['url']="<a href='".$url."'>点击认证</a> 如果您不能在邮箱中直接打开，请复制该链接到浏览器地址栏中直接打开：".$url;
			$status=$this->send_msg_email($data);
			$Subscribe=$this->MODEL("subscribe");
			$Subscribe->UpdateSubscribe(array("code"=>$code),array("email"=>$_POST['email']));
			echo 1;die;
		}
	}
}
