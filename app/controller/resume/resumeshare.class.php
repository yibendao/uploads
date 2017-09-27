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
class resumeshare_controller extends resume_controller{
	function index_action(){
		if($_POST){
			if($_POST['femail']=="" || $_POST['myemail']=="" || $_POST['authcode']==""){
				echo "请完整填写信息！";die;
			}
			session_start();
			if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
				echo "验证码不正确！";die;
			}
			unset($_SESSION['authcode']);
			if($_COOKIE["sendresume"]==$_POST['id']){
				echo "请不要频繁发送邮件！同一简历发送间隔为两分钟！";die;
			}
			if($this->config['sy_email_set']!="1"){
				echo "网站邮件服务器不可用!";die;
			}
			if($this->CheckRegEmail(trim($_POST['femail']))==false){echo "邮箱格式错误！";die;}
			$contents=file_get_contents($this->config[sy_weburl]."/resume/index.php?c=sendresume&id=".$_POST['id']);
			$myemail = $this->stringfilter($_POST['myemail']);

			
			$emailData['to'] = $_POST['femail'];
			$emailData['subject'] = "您的好友".$myemail."向您推荐了简历！";
			$emailData['content'] = $contents;
			
			$emailData['uid'] = '';
			$emailData['name'] = $_POST['femail'];
			$emailData['cuid'] = $this->uid;
			$emailData['cname'] = $myemail;

			$sendid = $this->sendemail($emailData);	

			if($sendid){
				echo 1;
			}else{
				echo "邮件发送错误 原因：1邮箱不可用 2网站关闭邮件服务";die;
			}
			SetCookie("sendresume",$_POST['id'],time() + 120, "/");
			die;
		}
		if((int)$_GET['id']){
			$M=$this->MODEL('resume');
			$id=(int)$_GET['id'];
			$user=$M->resume_select($id);
			include(CONFIG_PATH."db.data.php");
		    unset($arr_data['sex'][3]);
		    $this->yunset("arr_data",$arr_data);
			$user['sex']=$arr_data['sex'][$user['sex']];
			$JobM=$this->MODEL('job');
			$time=strtotime("-14 day");
			$allnum=$JobM->GetUserJobNum(array("uid"=>$user['uid'],"eid"=>$user['id'],"`datetime`>'".$time."'"));
			$replynum=$JobM->GetUserJobNum(array("uid"=>$user['uid'],"eid"=>$user['id'],"`datetime`>'".$time."' and `is_browse`>'1'"));
			$pre=round(($replynum/$allnum)*100);
			$this->yunset("pre",$pre);
			$this->yunset('Info',$user);
			$data['resume_username']=$user['username_n'];
			$data['resume_city']=$user['city_one'].",".$user['city_two'];
			$data['resume_job']=$user['hy'];
			$this->data=$data;
		}
		$this->seo("resume_share");
		$this->yuntpl(array('resume/resume_share'));
    }
}
?>