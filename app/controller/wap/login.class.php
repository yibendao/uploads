<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2016 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class login_controller extends common{
	function index_action(){
		if(preg_match("/^[a-zA-Z0-9_-]+$/",$_GET['wxid'])){
			$wxid = $_GET['wxid'];
			setcookie("wxid",$_GET['wxid'],time() + 86400, "/");

		}elseif($_COOKIE['wxid']){

			$wxid = $_COOKIE['wxid'];
		}

		if(preg_match("/^[a-zA-Z0-9_-]+$/",$_GET['unionid'])){
			setcookie("unionid",$_GET['unionid'],time() + 86400, "/");
		}
		if(preg_match("/^[a-zA-Z0-9_-]+$/",$_GET['wxloginid'])){
			setcookie("wxloginid",$_GET['wxloginid'],time() + 86400, "/");
		}
		
		
		$this->get_moblie();
		if($wxid){
			if($wxid == $_COOKIE['wxid']){
				
				$this->yunset("wxid",$wxid);
				$this->yunset("wxnickname",$_COOKIE['wxnickname']);
				$this->yunset("wxpic",$_COOKIE['wxpic']);

			}else{
		
				$wxM = $this->MODEL('weixin');
				$wxinfo = $wxM->getWxUser($wxid);
				
				if($wxinfo['nickname']){
					
					$this->yunset("wxid",$wxid);
					setcookie("wxnickname",iconv('utf-8','gbk',$wxinfo['nickname']),time() + 86400, "/");
					$this->yunset("wxnickname",iconv('utf-8','gbk',$wxinfo['nickname']));
					setcookie("wxpic",$wxinfo['headimgurl'],time() + 86400, "/");
					$this->yunset("wxpic",$wxinfo['headimgurl']);
				}
			}
		}
		if($this->uid || $this->username){
			if((int)$_GET['bind']=='1'){
				$this->unset_cookie();
				$data['msg']='重新绑定您的求职账户！';

			}elseif($_GET['wxid']){

				$this->unset_cookie();
			}else{
				$this->wapheader('member/index.php');
			}
		}
			
		
		
		$checkurl=$_COOKIE['checkurl'];
		unset($checkurl);
        $this->yunset("checkurl",$checkurl);

		if($_POST['submit']){ 
		
            $UserinfoM=$this->MODEL('userinfo');
			if($_POST['wxid']){
				$wxparse = '&wxid='.$_POST['wxid'];
			}
			$username = yun_iconv("utf-8","gbk",$_POST['username']);
			if(strpos($this->config['code_web'],'前台登录')!==false){
			    session_start();
			   
				if($this->config['code_kind']==3){
					if(!gtauthcode($this->config,'mobile')){
						$data['msg']='请点击按钮进行验证！';
						$this->layer_msg($data['msg'],9,0,'',2);
					}
			    }else{
			        if(md5(strtolower($_POST['checkcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
			            
			            $data['msg']='验证码错误！';
						unset($_SESSION['authcode']);
						$this->layer_msg($data['msg'],10,0,'',2);
			        }
					unset($_SESSION['authcode']);
			    }
			}
			if(!$this->CheckRegUser($username) && !$this->CheckRegEmail($username)){
				$data['msg']='无效的用户名！';
				$this->layer_msg($data['msg'],9,0,'',2);
			}

			if($username!=''){

				if($this->config['sy_uc_type']=="uc_center"){
					$ucinfo = $this->uc_open();
						
					if(strtolower($ucinfo['UC_CHARSET']) =='utf8' || strtolower($ucinfo['UC_DBCHARSET'])=='utf8'){
						$uname = iconv('gbk','utf-8',$username);
					}else{
						$uname = $username;
					}
					
					list($uid, $uname, $password, $email) = uc_user_login($uname, $_POST['password']);

					if($uid=='-1'){
						$user = $UserinfoM->GetMemberOne(array("username"=>$username),array("field"=>"username,email,uid,password,salt"));
						$pass = md5(md5($_POST['password']).$user['salt']);

						if($pass==$user['password']){
							$uid = $user['uid'];
							$uid = uc_user_register($user['username'],$_POST['password'],$user['email']);
							if($uid=='-1'){
								$data['msg']='当前用户名不合法';
								$this->layer_msg($data['msg'],9,0,'',2);
							}elseif($uid=='-2'){
								$data['msg']='当前用户名包含论坛禁止的词语';
								$this->layer_msg($data['msg'],9,0,'',2);
							}elseif($uid=='-4'){
								$data['msg']='当前用户 Email 格式不符合论坛规则！';
								$this->layer_msg($data['msg'],9,0,'',2);
							}elseif($uid=='-5'){
								$data['msg']='当前用户 Email 论坛不允许注册！';
								$this->layer_msg($data['msg'],9,0,'',2);
							}elseif($uid=='-6'){
								$data['msg']='当前用户 Email 与论坛其他用户重复！';
								$this->layer_msg($data['msg'],9,0,'',2);
							}
							list($uid, $username, $password, $email) = uc_user_login($uname, $_POST['password']);
						}else{
							$this->layer_msg('账户或密码错误！',9,0,'',2);
						}
					}else if($uid > 0) {
						$ucsynlogin=uc_user_synlogin($uid);
						$msg =  '登录成功！';
						$user = $UserinfoM->GetMemberOne(array("username"=>$username),array("field"=>"`uid`,`usertype`,`email_status`,`status`"));
						if(!empty($user)){
							if (session_id() == ""){session_start();}
							$pass = md5(md5($_POST['password']).$user['salt']);

							if($pass!=$user['password']){
								$this->layer_msg('账户密码错误！',9,0,'',2);
							}
							if($_SESSION['qq']['openid']){
								$UserinfoM->UpdateMember(array("qqid"=>$_SESSION['qq']['openid']),array("uid"=>$user['uid']));
								unset($_SESSION['qq']);
							}
							if($_SESSION['wx']['openid']){
								$udate = array('wxid'=>$_SESSION['wx']['openid']);

								if($_SESSION['wx']['unionid']){
									$udate['unionid']  = $_SESSION['wx']['unionid'];
								}
								$UserinfoM->UpdateMember($udate,array("uid"=>$user['uid']));
								unset($_SESSION['wx']);
							}
							if($_SESSION['sina']['openid']){

								$UserinfoM->UpdateMember(array("sinaid"=>$_SESSION['sina']['openid']),array("uid"=>$user['uid']));
								unset($_SESSION['sina']);
							}
							if($_COOKIE['wxid']){
								$UserinfoM->UpdateMember(array('wxid'=>'','unionid'=>'','wxopenid'=>''),array('wxid'=>$_COOKIE['wxid']));
								$UserinfoM->UpdateMember(array('wxid'=>$_COOKIE['wxid'],'unionid'=>$_COOKIE['unionid'],'wxbindtime'=>time()),array('uid'=>$user['uid']));
								if($_COOKIE['wxloginid']){
									$UserinfoM->UpdateWxlogin(array('wxid'=>$_COOKIE['wxid'],'unionid'=>$_COOKIE['unionid'],'status'=>'1'),array('wxloginid'=>$_COOKIE['wxloginid']));
								}

								setcookie("unionid",'',time() - 86400, "/");
								setcookie("wxloginid",'',time() - 86400, "/");
							}
							if(!$user['usertype']){
								$this->unset_cookie();
								$this->addcookie("username",$username,time()+3600);
								$this->addcookie("password",$_POST['password'],time()+3600);
								$this->ajaxlogin($ucsynlogin,Url("login",array("c"=>"utype"),"1"),'3');
							}
							if($user['status']=="2"){
								$this->layer_msg('您的账号已被锁定',9,0,'',2);
							}
							if($user['usertype']=="2" && $this->config['com_status']!="1" && $user['status']!="1"){
								$this->layer_msg('您还没有通过审核',9,0,'',2);
								die;
							}
							if($user['usertype']=="3" && $this->config['lt_status']!="1" && $user['status']!="1"){
								$this->layer_msg('您还没有通过审核',9,0,'',2);
								die;
							}
							if($user['usertype']=="4" && $this->config['px_status']!="1" && $user['status']!="1"){
								$this->layer_msg('您还没有通过审核',9,0,'',2);
								die;
							}
							
							if($this->config['user_status']=="1"){
								if($user['usertype']=='1'){
									$Resume=$this->MODEL("resume");
									$info=$Resume->SelectResumeOne(array("uid"=>$user['uid']),"`name`,`email_status`,`birthday`");
									if($info['email_status']=="1"){
										$this->layer_msg('您的账户还未激活,请查阅邮箱激活邮件!',9,0,'',2);
										die;
									}
								}
							}
							if($_POST['loginname']){
								setcookie("loginname",$username,time()+8640000);
							}
							$this->autoupjob($user['uid'],$user['usertype']);
							if($_COOKIE['wxid']){
							 
							 setcookie("wxid",'',time() - 86400, "/");
							}
						}else{
							$this->unset_cookie();
							$this->addcookie("username",$username,time()+3600);
							$this->addcookie("password",$_POST['password'],time()+3600);
							$this->layer_msg('论坛用户请先激活您的身份!'.$ucsynlogin,9,0,Url("wap",array("c"=>"login",'a'=>'utype')),2);
						}
						$this->layer_msg($msg.$ucsynlogin,9,0,Url("wap",array("c"=>"login",'a'=>'utype')),2);

					} elseif($uid == -2) {
						$msg =  '密码错误';
					} elseif($uid == -3)  {
						$msg = '论坛安全提问错误!';
					}else{
						$msg = '登录失败!';
					}
					$this->layer_msg($msg.$ucsynlogin,9,0,Url("wap",array("c"=>"login",'a'=>'utype')),2);
				}else{
					$userinfo = $UserinfoM->GetMemberOne(array('username'=>$username),array('field'=>"username,usertype,password,uid,salt,status,did,login_date"));
					if(!is_array($userinfo)){
						$data['msg']='用户不存在！';
						$this->layer_msg($data['msg'],9,0,'',2);
					}
					
					$pass = md5(md5($_POST['password']).$userinfo['salt']);

					if($pass!=$userinfo['password']){
						$data['msg']='密码不正确！';
					}else{
						if($userinfo['status']=="2"){
							$this->layer_msg('',9,0,Url('wap',array('c'=>'login','a'=>'loginlock','type'=>1)));
						}
						if($userinfo['usertype']=="2" && $this->config['com_status']!="1" && $userinfo['status']!="1"){ 
							$this->layer_msg('',9,0,Url('wap',array('c'=>'login','a'=>'loginlock','type'=>2)));
						}
						if($userinfo['usertype']=='1'){
							$Resume=$this->MODEL("resume");
							$info=$Resume->SelectResumeOne(array("uid"=>$userinfo['uid']),"`email_status`");
							if($this->config['user_status']=="1" &&$info['email_status']!="1"){
								$data['msg']='您的账户还未激活，请先激活！';
								$this->layer_msg($data['msg'],9,0,'',2);
							}
						}
						$ip = fun_ip_get();
						$UserinfoM->UpdateMember(array("login_ip"=>$ip,"login_date"=>time(),"`login_hits`=`login_hits`+1"),array("uid"=>$userinfo['uid']));

						if($_SESSION['qq']['openid']){
								$UserinfoM->UpdateMember(array("qqid"=>$_SESSION['qq']['openid']),array("uid"=>$userinfo['uid']));
								unset($_SESSION['qq']);
						}
						if($_SESSION['wx']['openid']){
							$udate = array('wxid'=>$_SESSION['wx']['openid']);

							if($_SESSION['wx']['unionid']){
								$udate['unionid']  = $_SESSION['wx']['unionid'];
							}
							$UserinfoM->UpdateMember($udate,array("uid"=>$userinfo['uid']));
							unset($_SESSION['wx']);
						}
						if($_SESSION['sina']['openid']){

							$UserinfoM->UpdateMember(array("sinaid"=>$_SESSION['sina']['openid']),array("uid"=>$userinfo['uid']));
							unset($_SESSION['sina']);
						}
						if($_COOKIE['wxid']){
							$UserinfoM->UpdateMember(array('wxid'=>'','unionid'=>'','wxopenid'=>''),array('wxid'=>$_COOKIE['wxid']));
							$UserinfoM->UpdateMember(array('wxid'=>$_COOKIE['wxid'],'unionid'=>$_COOKIE['unionid'],'wxbindtime'=>time()),array('uid'=>$userinfo['uid']));
							if($_COOKIE['wxloginid']){
								$UserinfoM->UpdateWxlogin(array('wxid'=>$_COOKIE['wxid'],'unionid'=>$_COOKIE['unionid'],'status'=>'1'),array('wxloginid'=>$_COOKIE['wxloginid']));
							}
							setcookie("unionid",'',time() - 86400, "/");
							setcookie("wxloginid",'',time() - 86400, "/");
						}
						
						$logdate=date("Ymd",$userinfo['login_date']);
						$nowdate=date("Ymd",time());
						if($logdate!=$nowdate){
							$this->get_integral_action($userinfo['uid'],"integral_login","会员登录");
						}
						$this->autoupjob($userinfo['uid'],$userinfo['usertype']);
						$this->add_cookie($userinfo['uid'],$userinfo['username'],$userinfo['salt'],$userinfo['email'],$userinfo['password'],$userinfo['usertype'],1,$userinfo['did']);
						if($_COOKIE['wxid']){
							 
							 setcookie("wxid",'',time() - 86400, "/");
							 $this->layer_msg('绑定成功，请按左上方返回进入微信客户端',9,0,Url('wap').'member/',2);
						}else if($_POST['job']){
							$this->layer_msg('',9,0,Url('wap',array('c'=>'job','a'=>'view','id'=>intval($_POST['job']))),2);
						}else if($_POST['checkurl']){
							$this->layer_msg('',9,0,$_POST['checkurl'],2);
						}else{ 
							$this->layer_msg('',9,0,Url('wap').'member/',2);
						}
					}
				}
			}else{
				$data['msg']='数据错误！';
			}
            $this->layer_msg($data['msg'],9,0,'',2);
		}
		if($_GET['usertype']=="2"){
			$this->yunset("headertitle","会员登录");
		}else{
			$this->yunset("headertitle","会员登录");
		}
		
		$this->seo("login");
		
		$this->yuntpl(array('wap/login'));
	}
	function loginlock_action(){
		$this->seo("login"); 
		$this->yuntpl(array('wap/loginlock'));
	}
	function autoupjob($uid,$usertype){
		if($usertype=='2'){
			$Job=$this->Model("job");
			$Job->UpdateComjob(array("lastupdate"=>time()),array("`uid`='".$uid."' AND `autotype`='2' AND `autotime`>'".time()."'"));
		}
	}
	function utype_action()
	{
		if($this->uid)
		{
			header("Location:".$this->config['sy_weburl']."/member");
		}
		$this->seo("login");
		$this->yun_tpl(array('utype'));
	}

	function setutype_action(){


		if($_COOKIE['username'] && $_COOKIE['password'] && ($this->CheckRegUser($_COOKIE['username']) OR $this->CheckRegEmail($_COOKIE['username'])))
		{
			$Member=$this->MODEL("userinfo");
			$user = $Member->GetMemberOne(array("username"=>$_COOKIE['username']),array("field"=>"uid,username,password,salt,usertype,did"));
		
			$pass = md5(md5($_COOKIE['password']).$user['salt']);
			$userid = $user['uid'];

			if(!$user['usertype'])
			{
				if($pass==$user['password'] && $user['password']!='')
				{
					$usertype = (int)$_GET['usertype'];
					if($usertype=='1')
					{
						$table = "member_statis";
						$table2 = "resume";
						$data1=array("uid"=>$userid);
						$data2['uid']=$userid;

					}elseif($usertype=='2')
					{

						$table = "company_statis";
						$table2 = "company";
						$data1=$Member->FetchRatingInfo(array("uid"=>$userid));
						$data2['uid']=$userid;
						$data1['did']=$user['did'];

					}elseif($usertype=='3')
					{
						$table1 = 'lt_statis';
						$table2 = 'lt_info';

						$id =$this->config['lt_rating'];
						$row = $Member->GetRatinginfoOne(array('id'=>$id));
						$data1=array('rating'=>$id,'integral'=>$this->config['integral_reg'],'rating_name'=>$row['name'],'rating_type'=>$row['type'],'lt_job_num'=>$row['lt_job_num'],'lt_down_resume'=>$row['lt_resume'],'lt_editjob_num'=>$row['lt_editjob_num'],'lt_breakjob_num'=>$row['lt_breakjob_num']);
						if($row['service_time']>0){
							$time=time()+86400*$row['service_time'];
						}else{
							$time=0;
						}
						$data1['vip_etime']=$time;
						$data2['uid']=$userid;
						$data2['did']=$user['did'];

					}elseif($usertype=='4')
					{
						$table1 = 'train_statis';
						$table2 = 'px_train';
						$data1=array('uid'=>$userid,'integral'=>$this->config['integral_reg']);
						$data2['uid']=$userid;
						$data2['did']=$user['did'];
					}
					$Member->UpdateMember(array("usertype"=>$usertype),array("uid"=>$userid));
					$Member->InsertReg($table,$data1);
					$Member->InsertReg($table2,$data2);
					$this->add_cookie($userid,$user['username'],$user['salt'],$user['email'],$user['password'],$usertype,1,$user['did']);
					header("Location:".$this->config['sy_weburl'].'/member');
				}else{
					$this->unset_cookie();
					echo "激活失败";
				}
			}else{
				$this->unset_cookie();
				echo "激活失败";
			}


		}else{
			header("Location:".Url('index'));
		}


	}
}
?>