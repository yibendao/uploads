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
class once_controller extends common{
	function index_action(){
		$this->rightinfo();
		if($this->config['sy_wzp_web']=="2"){
			$data['msg']='很抱歉！该模块已关闭！';
			$data['url']='index.php';
			$this->yunset("layer",$data);
		}
		$this->get_moblie();
		$this->seo("once");
		$this->yunset("topplaceholder","请输入招聘关键字,如：服务员...");
		$M=$this->MODEL('once');
		$ip=fun_ip_get();
		$start_time=strtotime(date('Y-m-d 00:00:00')); 
		$mess=$M->GetOncejobNum(array('login_ip'=>$ip,'`ctime`>\''.$start_time.'\''));
		$num=$this->config['sy_once']-$mess;
		$this->yunset("num",$num);				
		$CacheM=$this->MODEL('cache');
        $CacheArr=$CacheM->GetCache(array('city'));
		$this->yunset($CacheArr);
		$this->yunset("headertitle","店铺招聘");
		$this->yuntpl(array('wap/once'));
	}
	function add_action(){ 
		$this->rightinfo();		
		$CacheM=$this->MODEL('cache');
        $CacheArr=$CacheM->GetCache(array('city'));
		$this->yunset($CacheArr);
		if($this->config['sy_wzp_web']=="2"){
			$data['msg']='很抱歉！该模块已关闭！';
			$data['url']='index.php';
			$this->yunset("layer",$data);
		}
		$this->get_moblie();
		$TinyM=$this->MODEL('once');

		if((int)$_GET['id']){
            $row=$TinyM->GetOncejobOne(array('id'=>(int)$_GET[id]));
			$row['edate']=ceil(($row['edate']-$row['ctime'])/86400) ;
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
			$_POST=$this->post_trim($_POST);
			$_POST['mans'] = (int)$_POST['mans'];
			$_POST = yun_iconv('utf-8','gbk',$_POST);
			$_POST['status']=$this->config['com_fast_status'];
			$_POST['ctime']=time();
			$_POST['edate']=strtotime("+".(int)$_POST['edate']." days");
			$password=md5(trim($_POST['password']));
			if(is_uploaded_file($_FILES['pic']['tmp_name'])){
				$upload=$this->upload_pic("../data/upload/once/",false);
				$pictures=$upload->picture($_FILES['pic']);
				$pic=str_replace("../data/upload/once/","data/upload/once/",$pictures);
				$_POST['pic']=$pic;
			}
			unset($_POST['submit']);
			$id=intval($_POST['id']);
			if($id<1){
				$ip=fun_ip_get();
				$start_time=strtotime(date('Y-m-d 00:00:00')); 
				$mess=$TinyM->GetOncejobNum(array('login_ip'=>$ip,'`ctime`>\''.$start_time.'\'')); 
				if($this->config['sy_once']<=$mess&&$this->config['sy_once']){
					$data['msg']="一天内只能发布".$this->config['sy_once']."次！";
					$data['url']='index.php?c=once';
				}else{
					unset($_POST['id']);
					$_POST['ip']=$ip;
					$_POST['password']=$password;
					$_POST['did']=$this->config['did'];
					$nid=$TinyM->AddOncejob($_POST);
					if($this->config['com_fast_status']=="0"){$msg="发布成功，等待审核！";}else{$msg="发布成功!";}
					$nid?$data['msg']=$msg:$data['msg']=$msg;
					$data['url']='index.php?c=once';
				}
			}else{
				$arr=$TinyM->GetOncejobOne(array('id'=>$id,'password'=>$password),array('field'=>'pic,id'));
				if($arr['id']){
				    $data['mans']=$_POST['mans'];
				    $data['title']=$_POST['title'];
				    $data['require']=$_POST['require'];
				    $data['companyname']=$_POST['companyname'];
				    $data['phone']=$_POST['phone'];
				    $data['linkman']=$_POST['linkman'];
				    $data['provinceid']=$_POST['provinceid'];
				    $data['cityid']=$_POST['cityid'];
				    $data['three_cityid']=$_POST['three_cityid'];
				    $data['address']=$_POST['address'];
				    $data['status']=$this->config['com_fast_status'];
				    $data['password']=$password;
				    $data['edate']=$_POST['edate'];
				    if ($_POST['pic']!=''){
				        $data['pic']=$_POST['pic'];
				    }else{
				        $data['pic']=$arr['pic'];
				    }
					$nid=$TinyM->UpdateOncejob($data,array("id"=>$id));
					if($this->config['com_fast_status']=="0"){
					    $msg="操作成功，等待审核！";
					}else{
					    $msg="操作成功!";
					}
					$nid?$data['msg']=$msg:$data['msg']=$msg;
					$data['url']='index.php?c=once';
				}else{ 
					$data['msg']='密码错误！';
					$data['url']=Url('wap',array('c'=>'once','a'=>'show','id'=>$id));
				}
			}
			
            $data=yun_iconv('gbk','utf-8',$data);
            echo json_encode($data);die;
		}
		
		$CacheList=$this->MODEL('cache')->GetCache('user');
        $this->yunset($CacheList);
		$this->yunset("layer",$data);
		$this->yunset("headertitle","店铺招聘");
		$this->yunset("title","添加店铺招聘");
		$this->yuntpl(array('wap/once_add'));
	}
	function show_action(){
		if($this->config['sy_wzp_web']=="2"){
			$data['msg']='很抱歉！该模块已关闭！';
			$data['url']='index.php';
			$this->yunset("layer",$data);
		}
		$this->rightinfo();
		$this->get_moblie();
		$this->yunset("headertitle","店铺招聘");
        $TinyM=$this->MODEL('once');
		$TinyM->UpdateOncejob(array("`hits`=`hits`+1"),array('id'=>(int)$_GET[id]));
		$row=$TinyM->GetOncejobOne(array('id'=>(int)$_GET[id]));
		$row['ctime']=date("Y-m-d",$row[ctime]);
		$row['require'] = str_replace("\r\n","<br>",$row['require']);
		$row['require'] = str_replace("\n","<br>",$row['require']);
		$this->yunset("row",$row);
		$data['once_job']=$row['title'];
		$data['once_name']=$row['companyname'];
		$description=$row['require'];
		$data['once_desc']=$this->GET_content_desc($description);
		$this->data=$data;
		$this->seo('once_show');
		$this->yuntpl(array('wap/once_show'));
	}
}
?>