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
		session_start(); 
		if($this->config['sy_tiny_web']=="2"){
			header("location:".Url('error'));
		}
		if($_GET['keyword']=='请输入普工简历的关键字'){
			$_GET['keyword']='';
		}
		$M=$this->MODEL('tiny');
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		$ip = fun_ip_get();
		$s_time=strtotime(date('Y-m-d 00:00:00'));
		$m_tiny=$M->GetTinyresumeNum(array('login_ip'=>$ip,'`time`>\''.$s_time.'\''));
		$num=$this->config['sy_tiny']-$m_tiny;
        $CacheM=$this->MODEL('cache');
		$CacheList=$CacheM->GetCache(array('user'));
        $this->yunset($CacheList);
        
		if($_POST['submit']){
			$id=(int)$_POST['id'];
			$authcode=md5(strtolower($_POST['authcode']));
			$password=md5($_POST['password']);
			unset($_POST['authcode']);
			unset($_POST['password']);
			unset($_POST['submit']);
			unset($_POST['id']);
			$_POST['status']=$this->config['user_wjl'];
			$_POST['login_ip']=$ip;
			$_POST['time']=time();
			$_POST['lastupdate']=time();
			$_POST['qq']=$_POST['qq'];
			$_POST['did']=$this->config['did'];
			if(strpos($this->config['code_web'],'店铺招聘')!==false){
				session_start();
				if ($this->config['code_kind']==3){
					
					if(!gtauthcode($this->config)){
						$this->ACT_layer_msg("请点击按钮进行验证！",8);
						
					}
					unset($_POST['geetest_challenge']);
					unset($_POST['geetest_validate']);
					unset($_POST['geetest_seccode']);

				}else{
					if($authcode!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
						unset($_SESSION['authcode']);
						$this->ACT_layer_msg("验证码错误！",8); 
					}
					unset($_SESSION['authcode']);
					unset($_POST['authcode']);
				}
			}
			if($id){
                
				$arr=$M->GetTinyresumeOne(array('id'=>$id,'password'=>$password));
				if(empty($arr)){
					$this->ACT_layer_msg("密码不正确",8);
				}
				
                

				$M->UpdateTinyresume($_POST,array('id'=>$id));
				if($this->config['user_wjl']=="0"){$msg="修改成功，等待审核！";}else{$msg="修改成功!";}

			}else{
				
				
				$_POST['password']=$password; 
				if($this->config['sy_tiny']>$m_tiny||$this->config['sy_tiny']<1){
					$M->AddTinyresume($_POST);
					if($this->config['user_wjl']=="0"){$msg="发布成功，等待审核！";}else{$msg="发布成功!";}
				}else{
					$this->ACT_layer_msg("一天内只能发布".$this->config['sy_tiny']."次！",8,$_SERVER['HTTP_REFERER']);
				} 
			}
			$this->ACT_layer_msg($msg,9,'index.php');
		}

		$this->yunset("num",$num);
		$this->seo("tiny");
		$this->yunset("ip",$ip);
		$add_time=array("0"=>"不限","7"=>"一周以内","15"=>"半个月","30"=>"一个月","60"=>"两个月","180"=>"半年","365"=>"一年");
		$this->yunset("add_time",$add_time); 
		$this->yun_tpl(array('index'));
	}
	function ajax_action(){
		 session_start();
		if(md5(strtolower($_POST['code']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
			unset($_SESSION['authcode']);
			echo 1;die;
		}
        
		$M=$this->MODEL('tiny');
      
		$jobinfo=$M->GetTinyresumeOne(array('id'=>(int)$_POST['tid'],'password'=>md5($_POST['pw'])));
		if(!is_array($jobinfo) || empty($jobinfo)){
			echo 2;die;
		}
		if($_POST['type']==1){
			$M->UpdateTinyresume(array('lastupdate'=>time()),array('id'=>(int)$jobinfo['id']));
			echo 3;die;
		}elseif($_POST['type']==3){
			$M->DeleteTinyresume(array('id'=>(int)$jobinfo['id']));
			echo 4;die;
		}else{
            
            $CacheM=$this->MODEL('cache');
            $UserData=$CacheM->GetCache(array('user'));
            $this->yunset($UserData);
           
			$jobinfo['expname']=$UserData['userclass_name'][$jobinfo['exp']];
			$jobinfo = yun_iconv('gbk','utf-8',$jobinfo);
			echo json_encode($jobinfo);die;
		}
	}
	function show_action(){
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
        $CacheM=$this->MODEL('cache');
        $UserData=$CacheM->GetCache(array('user'));
        $this->yunset($UserData);
		
		if(isset($_GET['id'])){
			$id=(int)$_GET['id'];
            
			$M=$this->MODEL('tiny');
            
		    $M->UpdateTinyresume(array("`hits`=`hits`+1"),array('id'=>$id));
           
            $t_info=$M->GetTinyresumeOne(array('id'=>$id));
			$t_info['sex']=$arr_data['sex'][$t_info['sex']];
		}
		if($t_info['id']){
			$this->data=array('tiny_username'=>$t_info['username'],'tiny_job'=>$t_info['job'],'tiny_desc'=>$t_info['production']);
			$this->seo('tiny_cont');
			$this->yunset('t_info',$t_info);
			$this->yunset('ip',fun_ip_get());
			$s_time=strtotime(date('Y-m-d 00:00:00'));
			$m_tiny=$M->GetTinyresumeNum(array('login_ip'=>$ip,'`time`>\''.$s_time.'\''));
			$num=$this->config['sy_tiny']-$m_tiny;
			$this->yunset("num",$num);
			$this->yun_tpl(array('show'));
		}else{
			$this->ACT_msg($this->config['sy_weburl'],"没有找到该简历！");
		}
		
	} 
}
?>
