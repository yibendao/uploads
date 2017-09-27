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
class index_controller extends common
{
	function actMsg($msgUrl,$msg,$status=8){
		
		if($loginType==1){
			$this->ACT_wapMsg($msgUrl, $msg,$status);
		}else{
			$this->ACT_msg($msgUrl, $msg,$status);
		}
	}
	function getMsgUrl(){
		if(isMobileUser()){
			if($config['sy_wapdomain']!=""){
				if(strpos($config['sy_wapdomain'],$this->protocol)===false)
				{
					$msgUrl = $this->protocol.$config['sy_wapdomain'];
				}else{
					$msgUrl = $config['sy_wapdomain'];
				}

			}else{
				$msgUrl = $config['sy_weburl'].'/wap/';
			}
		}else{
			$msgUrl = $config['sy_weburl'];
		}
		return $msgUrl;
	}
	function index_action()
	{

		$msgUrl = $this->getMsgUrl();
		if($this->config['sy_sinalogin']!="1")
		{
			if((int)$_GET['login']=="1")
			{
				$this->actMsg($msgUrl,"对不起，新浪登录已关闭！");
			}
		}
		include_once( APP_PATH.'api/weibo/saetv2.ex.class.php' );
		define("WB_AKEY" ,$this->config['sy_sinaappid']);
		define("WB_SKEY" , $this->config['sy_sinaappkey']);
		define("WB_CALLBACK_URL" , $this->config['sy_weburl'].'/index.php?m=sinaconnect' );
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		if(isset($_GET['code']))
		{
			$keys = array();
			$keys['code'] = $_GET['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			$token = $o->getAccessToken('code',$keys);
			if($token['access_token'])
			{
				$tokens = 	$token['access_token'];
				$tokenuid =  $token['uid'];
				if($tokenuid>0)
				{
					if($this->uid!=""&&$this->username!="")
					{
						
						$this->obj->DB_update_all("member","`sinaid`=''","`sinaid`='".$tokenuid."'");
						$this->obj->DB_update_all("member","`sinaid`='".$tokenuid."'","`uid`='".$this->uid."'");
						$this->actMsg($msgUrl.'/member/index.php?c=binding',"新浪微博登录绑定成功！",9);
					}


					$userinfo = $this->obj->DB_select_once("member","`sinaid`='".$tokenuid."'");
					if(is_array($userinfo))
					{
						$this->obj->DB_update_all("member","`login_date`='".time()."'","`uid`='".$userinfo[uid]."'");
						$logtime=date("Ymd",$userinfo['login_date']);
						$nowtime=date("Ymd",time());
						if($logtime!=$nowtime){
							$this->get_integral_action($userinfo['uid'],"integral_login","会员登录");
						}
						if($this->config['sy_uc_type']=="uc_center")
						{
							$this->uc_open();
							$user = uc_get_user($userinfo['username']);
							$ucsynlogin=uc_user_synlogin($user[0]);
							$this->actMsg($msgUrl,"登录成功！",9);

						}else{
							$this->unset_cookie();
							$this->add_cookie($userinfo['uid'],$userinfo['username'],$userinfo['salt'],$userinfo['email'],$userinfo['password'],$userinfo['usertype'],1,$userinfo['did']);
							$this->actMsg($msgUrl,"登录成功！",9);
						}
					}else{
						session_start();
						
						$_SESSION['sina']["openid"] = $tokenuid;
						$_SESSION['sina']["tooken"] = $token['access_token'];
						$_SESSION['sina']["logininfo"] = "您已登录新浪微博，请绑定您的帐户！";
						
	
						$GetUrl = "https://api.weibo.com/2/users/show.json?uid=".$tokenuid."&access_token=".$token['access_token'];
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL,$GetUrl);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
						$str=curl_exec ($ch);
						curl_close ($ch);
						$user = json_decode($str,true);
						
						$user['name'] = iconv("utf-8","gbk",$user['name']);
						if($user['name']){
							$_SESSION['sina']['nickname'] = $user['name'];
							$_SESSION['sina']['pic'] = $user['avatar_hd'];
						}else{
							$this->actMsg($msgUrl,"用户信息获取失败，请重新登录新浪微博！");

						}
						header("location:".Url("sinaconnect",array("c"=>"sinabind")));
					}
				}else{
					$this->actMsg($msgUrl,"新浪微博授权失败，请重新授权！");
				}
			}
		}else{
			$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
			header("location:".$code_url);
			
		}
	  }
	 function sinabind_action(){
		session_start();
		if(((int)$_GET['usertype']=='1' || (int)$_GET['usertype']=='2') && $_SESSION['sina']['openid']){
			$usertype = (int)$_GET['usertype'];
			$ip = fun_ip_get();
			$time = time();
			$salt = substr(uniqid(rand()), -6);
			$pass = md5(md5($salt).$salt);
			$username = $this->checkuser($_SESSION['sina']['nickname'],$_SESSION['sina']['nickname']);
			$userid=$this->obj->DB_insert_once("member","`username`='$username',`password`='$pass',`usertype`='$usertype',`status`='1',`salt`='$salt',`reg_date`='$time',`reg_ip`='$ip',`sinaid`='".$_SESSION['sina']['openid']."',`login_date`='".time()."',`login_ip`='".$ip."',`source`='10'");
			if(!$userid){
				$user = $this->obj->DB_select_once("member","`username`='".$username."'","`uid`,`email`");
				$userid = $user['uid'];
				$email = $user['email'];
			}
			$this->unset_cookie();
			if($usertype=="1"){
				$table = "member_statis";
				$table2 = "resume";
				$value="`uid`='$userid'";
				$value2 = "`uid`='$userid',`name`='$username',`did`='".$this->config['did']."'"; 
			}elseif($usertype=="2"){
				$ratingM = $this->MODEL('rating');
				$table = "company_statis";
				$table2 = "company";
				$value="`uid`='$userid',`did`='".$this->config['did']."',".$ratingM->rating_info();
				$value2 = "`uid`='$userid',`linktel`='$moblie',`did`='".$this->config['did']."'";
			}
			$this->obj->DB_insert_once($table,$value);
			$this->obj->DB_insert_once($table2,$value2);

			
			$this->get_integral_action($userid,"integral_reg","注册赠送");
			

			unset($_SESSION['sina']);
			if($this->config['com_status']!="1" && $usertype=='2'){
					$this->ACT_msg(Url('register',array('c'=>'ok','type'=>'1')),'注册成功，请等待管理员审核！',9);
			}else{

				$this->get_integral_action($userid,"integral_login","会员登录");

				$Member->UpdateMember(array("login_date"=>time(),"login_ip"=>$ip),array("uid"=>$userid));
				$this->add_cookie($userid,$username,$salt,$email,$pass,$usertype,1,$this->config['did']);
				if($usertype=='1'){
					header("location:".$this->config['sy_weburl']."/member/index.php?c=expect");
				}elseif($usertype=='2'){
					header("location:".$this->config['sy_weburl']."/member/index.php?c=info");
				}else{
					header("location:".$this->config['sy_weburl']."/member/");
				}
				
			}
		}
		$this->seo("sinalogin");
		if(isMobileUser()){
			$this->yun_tpl(array('wapindex'));
		}else{
			$this->yun_tpl(array('index'));
		}
	} 
	function checkuser($username,$name)
	{

		$user = $this->obj->DB_select_once("member","`username`='".$username."'","`uid`");
		if($user['uid'])
		{
			$name.="_".rand(1000,9999);
			return $this->checkuser($name,$username);
		}else{

			return $username;
		}

	}
	

}

