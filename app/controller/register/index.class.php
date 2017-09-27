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
		$this->seo("register");
		$this->yunset('type',$_GET['type']);
		
		if($this->config['reg_user_stop']!=1){ 
			$this->yun_tpl(array('stopreg'));
		}else{ 
			if($this->uid!=""&&$this->username!=""){
				$this->ACT_msg($this->config['sy_weburl'], "您已经登录了！");
			}
			if((int)$_GET['uid']){
				$time=time()+3600;
				$this->addcookie('regcode',(int)$_GET['uid'],$time); 
			}   
			if((int)$_GET['usertype']=="2"){
				$this->yun_tpl(array('company'));
			}else{
				$this->yun_tpl(array('user'));
			}
		}
	}
	function ok_action(){
		if((int)$_GET['type']==1){
			$seo=$this->config['sy_webname']."- 注册成功";
		}elseif((int)$_GET['type']==2){
			$seo=$this->config['sy_webname']."- 帐号被锁定";
		}elseif((int)$_GET['type']==3){
			$seo=$this->config['sy_webname']."- 审核未通过";
		}elseif((int)$_GET['type']==4){
			$seo=$this->config['sy_webname']."- 邮件认证成功";
		}elseif((int)$_GET['type']==5){
			$seo=$this->config['sy_webname']."- 未审核";
		}elseif((int)$_GET['type']==6){
			$seo=$this->config['sy_webname']."- 订阅";
		}else{
			header("location:".$this->config['sy_weburl']);
		}
		$this->seo('register');
		$this->yun_tpl(array('ok'));
	}
	function ajaxreg_action(){
		$post = array_keys($_POST);
		$key_name = $post[0];
		if(!in_array($key_name,array('username','email')))
		{
			exit();
		}
		$Member=$this->MODEL("userinfo");
		if($key_name=="username"){
			$username=yun_iconv("utf-8","gbk",$_POST['username']);
			if(!$this->CheckRegUser($username) && !$this->CheckRegEmail($username)){
				echo 2;die;
			}
			if($this->config['sy_uc_type']=="uc_center"){
				$this->uc_open();
				$user = uc_get_user($username);
			}else{
				$user = $Member->GetMemberNum(array("username"=>$username));
			}
			if($this->config['sy_regname']!=""){
				$regname=@explode(",",$this->config['sy_regname']);
				if(in_array($username,$regname)){
					echo 3;die;
				}
			}
		}elseif($key_name=="email"){
			if(!$this->CheckRegEmail($_POST['email'])){
				echo 2;die;
			}
			$user = $Member->GetMemberNum(array("`email`='".$_POST['email']."' or `username`='".$_POST['email']."'"));
		}
		if($user){echo 1;}else{echo 0;}
	}
	function regmoblie_action(){
		if($_POST['moblie']){
			$Member=$this->MODEL("userinfo");
			$num = $Member->GetMemberNum(array("moblie='".$_POST['moblie']."' or `username`='".$_POST['moblie']."'"));
			if ($num>0){
			    echo 1;die;
			}
			if($this->config['sy_web_mobile']!=""){
			    $regnamer=@explode(";",$this->config['sy_web_mobile']);
			    if(in_array($_POST['moblie'],$regnamer)){
			        echo 2;die;
			    }
			}
			echo 0;die;
		}
	}
	function checkcomname_action(){

		if($_POST['unit_name']){

			$comnameNum = $this->obj->DB_select_num("company","`name`='".iconv('utf-8','gbk',$_POST['unit_name'])."'");
			if($comnameNum>0){
				echo 1;
			}else{
				echo 0;
			}
		}
	}
	function errjson($msg,$status='8'){
		$arr['status']=$status;
		$arr['msg']=yun_iconv("gbk","utf-8",$msg);
		echo json_encode($arr);die;
	}
	function regsave_action(){
		if($this->config['reg_user_stop']!=1){
			$this->errjson('网站已关闭注册！');
		}
		$Member=$this->MODEL("userinfo");
		$_POST=$this->post_trim($_POST);
		$usertype=intval($_POST['usertype']);
		$_POST['username']=yun_iconv("utf-8","gbk",$_POST['username']);
		$_POST['unit_name']=yun_iconv("utf-8","gbk",$_POST['unit_name']);
		$_POST['address']=yun_iconv("utf-8","gbk",$_POST['address']);
		$_POST['linkman']=yun_iconv("utf-8","gbk",$_POST['linkman']);
		$_POST['name']=yun_iconv("utf-8","gbk",$_POST['name']);
		if($this->uid!="" && $this->username!=""){
			$this->errjson('您已经登录了！');
		}
		$ip=fun_ip_get();
		if($this->config['sy_reg_interval']>0){
			$intervaltime=time()-3600*$this->config['sy_reg_interval'];
			$regnum=$Member->GetMemberNum(array('reg_ip'=>$ip,"`reg_date`>='".$intervaltime."'"));
			if($regnum){
				$this->errjson('请勿频繁注册！');
			}
		}
		
		if(strpos($this->config['code_web'],'注册会员')!==false && $_POST['codeid']!='2'){
		    session_start();
		    if ($this->config['code_kind']==3){
				
				if(!gtauthcode($this->config)){
					 $this->errjson("请点击按钮进行验证！");
				}
		    }else{
		        if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
		            unset($_SESSION['authcode']);
		            $this->errjson('验证码错误！');
		        }
		    }
		}
		if(!$this->CheckRegUser($_POST['username']) && !$this->CheckRegEmail($_POST['username'])){
			$this->errjson('用户名包含特殊字符！');
		}

		

		if($_POST['codeid']=='1'){
			if($this->config['reg_username'] =='1' && $usertype=='1'){
				if(!$this->CheckRegUser($_POST['name']) || $_POST['name']==""){
					$this->errjson('真实姓名包含特殊字符');
				}
			}
			
			if(($this->config['reg_usertel']=='1' && $usertype=='1') || ($this->config['reg_comtel']=='1' && $usertype=='2')){
				if(!preg_match("/1[34578]{1}\d{9}$/",$_POST['moblie'])){
					$this->errjson('手机格式错误！');
				}else{
					$moblieNum = $Member->GetMemberNum(array("moblie"=>$_POST['moblie']));
					if($moblieNum>0){
						$this->errjson('手机已存在！');
					}
				}
			}
			if(($this->config['reg_useremail']=='1' && $usertype=='1') || ($this->config['reg_comemail']=='1' && $usertype=='2')){
				if(!$this->CheckRegEmail($_POST['email']) || $_POST['email']==""){
					$this->errjson('Email格式不规范！');
				}
			}
			if($usertype=='2'){
				if($this->config['reg_comname'] =='1'){
					if($_POST['unit_name']==""){
						$this->errjson('请正确填写企业名称！');
					}else{
						$comnameNum = $this->obj->DB_select_num("company","`name`='".$_POST['unit_name']."'");
						if($comnameNum>0){
							$this->errjson('企业名称已被使用！');
						}
					}
				}
				if($this->config['reg_comaddress'] =='1'){			
					if(!$this->CheckRegUser($_POST['address']) || $_POST['address']==""){
						$this->errjson('请正确填写企业地址！');
					}
				}
				if($this->config['reg_comlink'] =='1'){			
					if(!$this->CheckRegUser($_POST['linkman']) || $_POST['linkman']==""){
						$this->errjson('请正确填写企业联系人');
					}
				}

			}
		}elseif($_POST['codeid']=='2'){
			if(!preg_match("/1[34578]{1}\d{9}$/",$_POST['moblie'])){ 
				$this->errjson('手机格式错误！');
			}
			if($this->config['sy_msg_regcode']=="1"){
				if($_POST['moblie_code']){
					$regCertMobile = $Member->GetCompanyCert(array("type"=>'2',"check"=>$_POST['moblie']));
				}
				if($regCertMobile['check2']!=$_POST['moblie_code'] || $regCertMobile['check2']==''){
					$this->errjson('短信验证码错误！');
				}
			}
			$_POST['username'] =  $_POST['moblie'];
		}elseif($_POST['codeid']=='3'){
			if(!$this->CheckRegEmail($_POST['email']) || $_POST['email']==""){
				$this->errjson('Email格式不规范！');
			}
			$_POST['username'] =  $_POST['email'];
		}
		if($_POST['username']){
			$nid = $Member->GetMemberNum(array("username"=>$_POST['username']));
			if($nid){
				$this->errjson('账户名已存在！');
			}else{
				if($_POST['usertype']=='1'){
					$satus = 1;
				}elseif($_POST['usertype']=='2'){
					$satus = $this->config['com_status'];
				}
				if($this->config['sy_uc_type']=="uc_center"){
					$ucinfo = $this->uc_open();					
					if(strtolower($ucinfo['UC_CHARSET']) =='utf8' || strtolower($ucinfo['UC_DBCHARSET'])=='utf8'){
						$ucusername = iconv('gbk','utf-8',$_POST['username']);
					}else{
						$ucusername = $_POST['username'];
					}					
					$uid=uc_user_register($ucusername,$_POST['password'],$_POST['email']);
					if($uid<=0){
						switch($uid){
							case "-1":$this->errjson('用户名不合法!');
							break;
							case "-2":$this->errjson('包含不允许注册的词语!');
							break;
							case "-3":$this->errjson('用户名已经存在!');
							break;
							case "-4":$this->errjson('Email 格式有误!');
							break;
							case "-5":$this->errjson('Email 不允许注册!');
							break;
							case "-6":$this->errjson('该 Email 已经被注册!');
							break;
						}						
					}else{
						list($uid,$username,$password,$email,$salt)=uc_user_login($ucusername,$_POST['password']);
						$pass = md5(md5($_POST['password']).$salt);
						$ucsynlogin=uc_user_synlogin($uid);
					}
				}elseif($this->config['sy_pw_type']=="pw_center"){
					include(APP_PATH."/api/pw_api/pw_client_class_phpapp.php");
					$password=$_POST['password'];
					$email=$_POST['email'];
					$pw=new PwClientAPI($_POST['username'],$password,$email);
					$pwuid=$pw->register();
					$salt = substr(uniqid(rand()), -6);
					$pass = md5(md5($password).$salt);
				}else{
					$salt = substr(uniqid(rand()), -6);
					$pass = md5(md5($_POST['password']).$salt);
				} 
				$data['username']=$_POST['username'];
				$data['password']=$pass;
				$data['usertype']=$_POST['usertype'];
				$data['email']=$_POST['email'];
				$data['moblie']=$_POST['moblie'];
				$data['did']=$this->config['did'];
				$data['status']=$satus;
				$data['salt']=$salt;
				$data['reg_date']=time();
				$data['reg_ip']=$ip;
				$data['qqid']=$_SESSION['qq']['openid'];
				$data['sinaid']=$_SESSION['sina']['openid'];
				$data['wxid']=$_SESSION['wx']['openid'];
				$data['regcode']=(int)$_COOKIE['regcode'];
				$userid=$Member->AddMember($data);
				if(!$userid){
					$user_id = $Member->GetMemberOne(array("username"=>$_POST['username']),array("field"=>"uid"));
					$userid = $user_id['uid'];
				}
				if($userid){

					$this->unset_cookie();
					if($this->config['sy_pw_type']=="pw_center"){
						$Member->UpdateMember(array("pwuid"=>$pwuid),array("uid"=>$userid));
					}
					if($_POST['usertype']=="1"){
						$table = "member_statis";
						$table2 = "resume";
						$data1=array("uid"=>$userid);
						$data2=array("uid"=>$userid,"email"=>$_POST['email'],"telphone"=>$_POST['moblie'],"name"=>$_POST['name'],'did'=>$_COOKIE['did']);
					}elseif($_POST['usertype']=="2"){
						$table = "company_statis";
						$table2 = "company";
						$data1=$Member->FetchRatingInfo(array("uid"=>$userid));
						$data2['uid']=$userid;
						$data2['linkmail']=$_POST['email'];
						if($_POST['areacode']&&$_POST['telphone']){
							$data2['linkphone']=$_POST['areacode'].'-'.$_POST['telphone'];
						}
						if($_POST['exten']){
							$data2['linkphone'].='-'.$_POST['exten'];
						}
						$data2['name']=$_POST['unit_name'];
						$data2['linktel']=$_POST['moblie'];
						$data2['address']=$_POST['address'];
						$data2['linkman']=$_POST['linkman'];
						$data2['did']=$this->config['did'];
						
						
						$conid = $Member->Guwen();
						$data2['conid'] = $conid;
						if($this->config['com_status']==0){
							$data2['r_status']=2;
						}
					}

					
					if($_POST['codeid']=='2' && $this->config['sy_msg_regcode']=="1")
					{
						
						$Member->UpdateMember(array("moblie"=>''),array("moblie"=>trim($_POST['moblie']),'uid<>'=>$userid));
						if($usertype == '1'){
							$Member->UpdateResume(array("telphone"=>"","moblie_status"=>"0"),array("telphone"=>$_POST['moblie']));
							$data2['moblie_status']="1";
						}elseif($usertype == '2'){
							$Member->UpdateCompany(array("linktel"=>"","moblie_status"=>"0"),array("linktel"=>$_POST['moblie'],"telphone"=>$_POST['areacode'].'-'.$_POST['telphone'].'-'.$_POST['exten']));
							$data2['moblie_status']="1";
						}
					}
					$data1['did']=$this->config['did'];
					$Member->InsertReg($table,$data1);
					$Member->InsertReg($table2,$data2);
					if($_COOKIE['regcode']!=""){ 
						if($this->config['integral_invite_reg_type']=="1"){ 
							$auto=true;
						}else{
							$auto=false;
						}
						$this->company_invtal((int)$_COOKIE['regcode'],$this->config['integral_invite_reg'],$auto,"邀请注册",true,2,'integral',23);
					}
					if($this->config['integral_reg']>0){
						$this->company_invtal($userid,$this->config['integral_reg'],true,"注册赠送",true,2,'integral',23);
					}


					if($_POST['usertype']=="1"){
						if($this->config['user_status']=="1" && $_POST['email']){
							$randstr=rand(10000000,99999999);
							$base=base64_encode($userid."|".$randstr."|".$this->config['coding']);
							$data_cert['uid']=$userid;
							$data_cert['type']="cert";
							$data_cert['did']=$this->config['did'];
							$data_cert['email']=$_POST['email'];
							$data_cert['url']="<a href='".$this->config['sy_weburl']."/index.php?m=qqconnect&c=mcert&id=".$base."'>点击认证</a>";
							$data_cert['date']=date("Y-m-d");
							if($this->config['sy_email_set']=="1"){
								$this->send_msg_email($data_cert);
								$this->errjson('帐号激活邮件已发送到您邮箱，请先激活！',7);
							}else{
								$this->errjson('还没有配置邮箱，请联系管理员！');
							}
						}else{
							$this->get_integral_action($userid,"integral_login","会员登录");
							
							$Member->UpdateMember(array("login_date"=>time(),"login_ip"=>$ip),array("uid"=>$userid));
							$this->add_cookie($userid,$_POST['username'],$salt,$_POST['email'],$pass,$usertype,1,$this->config['did']);
							$_POST['uid']=$userid;
							$this->regemail($_POST);
							
							$this->errjson('注册成功',1);
						}
					}elseif($usertype=="2"){
						$_POST['uid']=$userid;
						$this->regemail($_POST);
						
						if($this->config['com_status']!="1"){
							$this->errjson('注册成功，请等待管理员审核！',7);
						}else{
							$this->get_integral_action($userid,"integral_login","会员登录");
							$Member->UpdateMember(array("login_date"=>time(),"login_ip"=>$ip),array("uid"=>$userid));
							$this->add_cookie($userid,$_POST['username'],$salt,$_POST['email'],$pass,$usertype);
							$this->errjson('注册成功',1);
						}
					}
				}else{
					$this->errjson('注册失败！');
				}
			}
		}else if($_POST['username']==''){
			$this->errjson('用户名不能为空！');
		}
	}
	function regemail($post){
	    if($post['email']){
	        $this->send_msg_email(array("name"=>$post['username'],"username"=>$post['username'],"password"=>$post['password'],"email"=>$post['email'],"type"=>"reg",'uid'=>$post['uid']));
	    }
		if($this->config["sy_msguser"]!="" && $this->config["sy_msgpw"]!="" && $this->config["sy_msgkey"]!=""&&$this->config['sy_msg_isopen']=='1'){
			$this->send_msg_email(array("name"=>$post['username'],"username"=>$post['username'],"password"=>$post['password'],"moblie"=>$post['moblie'],"type"=>"reg",'uid'=>$post['uid']));
		}
	}
}
?>