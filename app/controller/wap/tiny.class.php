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
class tiny_controller extends common{
	function index_action(){
		$this->rightinfo();
		if($this->config['sy_wjl_web']=="2"){
			$data['msg']='很抱歉！该模块已关闭！';
			$data['url']='index.php';
			$this->yunset("layer",$data);
		}
		$M=$this->MODEL('tiny');
		$ip = fun_ip_get();
		$s_time=strtotime(date('Y-m-d 00:00:00')); 
		$m_tiny=$M->GetTinyresumeNum(array('login_ip'=>$ip,'`time`>\''.$s_time.'\''));
		$num=$this->config['sy_tiny']-$m_tiny;
		$this->yunset("num",$num);
        $this->yunset($this->MODEL('cache')->GetCache('user'));
		$this->get_moblie();
		$this->seo("tiny");
		$this->yunset("topplaceholder","请输入关键字如：普工");
		$this->yunset("headertitle","普工专区");
		$this->yuntpl(array('wap/tiny'));
	}
	function add_action(){
		$this->rightinfo();
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		if($this->config['sy_wjl_web']=="2"){
			$data['msg']='很抱歉！该模块已关闭！';
			$data['url']='index.php';
			$this->yunset("layer",$data);
		}
		$this->get_moblie();
        $TinyM=$this->MODEL('tiny');

		if((int)$_GET['id']){
			$row=$TinyM->GetTinyresumeOne(array('id'=>(int)$_GET[id]));
			$this->yunset("row",$row);
		}
		if($_POST['submit']){
			if(strpos($this->config['code_web'],'店铺招聘')!==false){
			    session_start();
			   
				if($this->config['code_kind']==3){
					 //极验验证
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
			$_POST['status']=$this->config['user_wjl'];
			$_POST['time']=time();
			$_POST['lastupdate']=time();
			$_POST['lastupdate']=time();
			$_POST['username']=yun_iconv('utf-8','gbk',trim($_POST['username']));
			$_POST['production']=yun_iconv('utf-8','gbk',trim($_POST['production']));
			$_POST['job']=yun_iconv('utf-8','gbk',trim($_POST['job']));
			$password=md5(trim($_POST['password']));
			$type=trim($_POST['type']);
			$id=intval($_POST['id']);
			unset($_POST['submit']);
			unset($_POST['type']);
			if($id==''){
				$ip = fun_ip_get();
				$s_time=strtotime(date('Y-m-d 00:00:00')); 
				$m_tiny=$TinyM->GetTinyresumeNum(array('login_ip'=>$ip,'`time`>\''.$s_time.'\''));
				if($this->config['sy_tiny']>$m_tiny||$this->config['sy_tiny']<1){
					$_POST['password']=$password;
					$_POST['ip']=$ip;
					$_POST['did']=$this->config['did'];
					$nid=$this->obj->insert_into("resume_tiny",$_POST);
					$nid?$data['msg']='操作成功！':$data['msg']='操作失败！';
					$data['url']='index.php?c=tiny';
				}else{
					$data['msg']="一天内只能发布".$this->config['sy_tiny']."次！";
					$data['url']='index.php?c=tiny';
				}
			}else{ 
				$row=$TinyM->GetTinyresumeOne(array("id"=>$id,'password'=>$password));
				if($row['id']){
					unset($_POST['id']);
					unset($_POST['password']); 
					$nid=$TinyM->UpdateTinyresume($_POST,array("id"=>$id,'password'=>$password));
					
					$nid?$data['msg']='操作成功！':$data['msg']='操作失败！';
					$data['url']='index.php?c=tiny';
				}else{
					$data['msg']='密码错误！';
					$data['url']='index.php?c=tiny';
				} 
			}
            $data=yun_iconv('gbk','utf-8',$data);
            echo json_encode($data);die;
		} 
		$this->user_cache();
		$this->yunset(array("layer"=>$data,"headertitle"=>"普工专区"));
		$this->yunset("title","添加微简历");
		$this->yuntpl(array('wap/tiny_add'));
	}
	function show_action(){
		$this->rightinfo();
		if($this->config['sy_wjl_web']=="2"){
			$data['msg']='很抱歉！该模块已关闭！';
			$data['url']='index.php';
			$this->yunset("layer",$data);
		}
		$this->get_moblie();
		$this->yunset("headertitle","普工专区");
		$CacheList=$this->MODEL('cache')->GetCache('user');
        $this->yunset($CacheList);
        $TinyM=$this->MODEL('tiny');
        $TinyM->UpdateTinyresume(array("`hits`=`hits`+1"),array('id'=>(int)$_GET[id]));
		$row=$TinyM->GetTinyresumeOne(array('id'=>(int)$_GET[id]));

		$this->data=array('tiny_username'=>$row['username'],'tiny_job'=>$row['job'],'tiny_desc'=>$row['production']);
		$this->seo('tiny_cont');
		$this->yunset("row",$row);
		$this->yuntpl(array('wap/tiny_show'));
	}
}
?>