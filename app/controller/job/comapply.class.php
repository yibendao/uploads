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
class comapply_controller extends job_controller{
	function index_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$id=(int)$_GET['id'];
		$M=$this->MODEL('job');
		$companyM=$this->MODEL('company');
        $UserinfoM=$this->MODEL('userinfo');
		$ResumeM=$this->MODEL('resume');
        $AskM=$this->MODEL('ask');
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
        $this->yunset($CacheList);
		$JobInfo=$M->GetComjobOne(array('id'=>$id));
		session_start();
		if($JobInfo['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],"没有该职位！");
		}
		if($_SESSION['auid']==""){
			if($JobInfo['r_status']=='2'){
				$this->ACT_msg($this->config['sy_weburl'],"企业已被锁定！");
			}
		}
		if($this->usertype=="1"&&$this->uid){
			$resume=$ResumeM->GetResumeExpectNum(array('uid'=>$this->uid,"`r_status`<>'2' and `job_classid`<>''","open"=>'1'));

			if($resume!='0'){ 
				$look_job=$M->GetLookJobOne(array('uid'=>$this->uid,'jobid'=>$JobInfo['id']));
				if(!empty($look_job)){
					$M->UpdateLookJob(array('datetime'=>time()),array('uid'=>$this->uid,'jobid'=>$JobInfo['id']));
				}else{
					
					$M->AddLookJob(array('uid'=>$this->uid,'jobid'=>$JobInfo['id'],'com_id'=>$JobInfo['uid'],'datetime'=>time(),'did'=>$this->userdid)); 
					$historyM = $this->MODEL('history');
					$historyM->addHistory('lookjob',$JobInfo['id']);
				}
			}

		}
 
		if($this->uid!=$JobInfo['uid']){
			if($this->config['com_login_link']=="3"){
				if($this->uid=="" && $this->username==""){
					$look_msg=1;
				}else{
					if($this->usertype!="1"){
						$look_msg=2;
					}
				}
			}elseif($this->config['com_login_link']=="2"){
				$look_msg=4;
			}
			if($this->config['com_resume_link']=="1"&&$this->usertype=='1'){ 
				$row=$ResumeM->GetResumeExpectNum(array("uid"=>$this->uid)); 
				if($row<1){
					$look_msg=3;
				}
			}
			if($this->usertype=='1'){
				$favjob=$M->GetFavJobOne(array("uid"=>$this->uid,"type"=>1,"job_id"=>$JobInfo['id']));
				$userid_job=$M->GetUseridJobOne(array('uid'=>$this->uid,'job_id'=>$JobInfo['id']),array('field'=>'id'));
				$report_job=$this->obj->DB_select_num("report","`eid`='".$JobInfo['id']."'and `p_uid`='".$this->uid."' and `c_uid`='".$JobInfo['uid']."'");
				$this->yunset(array('userid_job'=>$userid_job['id'],'usertype'=>1,"favjob"=>$favjob,"report_job"=>$report_job));
			}
		} 
		$ComInfo=$UserinfoM->GetUserinfoOne(array('uid'=>$JobInfo['uid']),array('field'=>"`ant_num`,`linkqq`,`logo`,`address`,`busstops`,`linktel`,`linkman`,`linkphone`,`email_status`,`moblie_status`,`yyzz_status`,`content`,`x`,`y`",'usertype'=>2));
		if(!$ComInfo['logo'] || !file_exists(str_replace($this->config['sy_weburl'],APP_PATH,'.'.$ComInfo['logo']))){
		    $ComInfo['logo']=$this->config['sy_weburl']."/".$this->config['sy_unit_icon'];
		}else{
		    $ComInfo['logo']=str_replace("./",$this->config['sy_weburl']."/",$ComInfo['logo']);
		}
		$JobInfo['jobname']=$JobInfo['name'];unset($JobInfo['name']);
		$JobInfo['jobrec']=$JobInfo['rec'];unset($JobInfo['rec']);
        $Info=array_merge_recursive($JobInfo,$ComInfo); 
		if($Info['linkman']){
			$operatime=time()-$Info['operatime'];
			if($Info['operatime']==''){
				$Info['operatime']='0';
			}else if($operatime<3600){
				$Info['operatime']='一小时以内';
			}else if($operatime>=3600&&$operatime<86400){
				$Info['operatime']=floor($operatime/3600).'小时';
			}else if($operatime>=86400){
				$Info['operatime']=floor($operatime/86400).'天';
			}  
			$allnum=$M->GetUserJobNum(array("com_id"=>$Info['uid'],"job_id"=>$Info['id']));
			$replynum=$M->GetUserJobNum(array("com_id"=>$Info['uid'],"job_id"=>$Info['id'],"`is_browse`>'1'")); 
			$pre=round(($replynum/$allnum)*100); 
			$this->yunset("pre",$pre);
		}
		$this->yunset("look_msg",$look_msg);
		if($_SESSION['auid']==""){
			if($Info['state']=="0"){
				$this->ACT_msg($_SERVER['HTTP_REFERER'],"职位审核中！");
			}elseif($Info['state']=="2"){
				$this->yunset('entype','1');
			
			}elseif($Info['state']=="3"){
				$this->ACT_msg($_SERVER['HTTP_REFERER'],"该职位未通过审核！");
			
			}elseif($Info['status']=="1"){
				$this->yunset('stop','1');
			}
		}
		if(is_array($Info)){
            $cache_array = $this->db->cacheget();
			$Job = $this->db->array_action($Info,$cache_array);
			if($Job['is_link']=="1" && $this->config['com_login_link']=="3"){ 
				if($Job['link_type']==1){
					$Job['linkman']=$Info['linkman'];
					if ($Info['linktel']){
					    $Job['linktel']=substr_replace($Info['linktel'],'*****',3,5);
					}elseif ($Info['linkphone']){
					    $Job['linktel']=substr_replace($Info['linkphone'],'*****',3,5);
					}
				}else{
					$link=$M->GetComjoblinkOne(array('jobid'=>$Job['id']),array('field'=>'`link_man`,`link_moblie`'));
					$Job['linkman']=$link['link_man'];
					$Job['linktel']=substr_replace($link['link_moblie'],'*****',3,5);
				}
			}
		}
		if($this->uid&&$this->usertype&&$this->usertype!=1){
			$typename=array('2'=>'企业账户');
			$this->yunset("usertypemsg",'您当前帐号名为：<span class="job_user_name_s">'.$this->username.'</span>，属于'.$typename[$this->usertype].'。');
		}
		$com=$UserinfoM->GetMemberOne(array('uid'=>$Job['uid']),array('field'=>'`username`'));
		$subject = strip_tags($Job['content']);
		$pattern = '/\s/';
		$Job['content'] = preg_replace($pattern, '', $subject);
		$Job['cert_n'] = @explode(",",$Job['cert']);
		$Job['uid'] = $Job['uid'];
		$Job['com_url'] = Url("company",array("c"=>"show","id"=>$Job[uid]));
		$Job['username'] = $com['username'];
		$Job['sex']=$arr_data['sex'][$Job['sex']];
		$data['job_name']=$Job['jobname'];
		$data['company_name']=$Job['com_name'];
		$data['industry_class']=$Job['job_hy'];
		$data['job_class']=$Job['job_class_one'].",".$Job['job_class_two'].",".$Job['job_class_three'];
		$data['job_desc']=$this->GET_content_desc($Job['description']);
		$this->data=$data;		
		$this->yunset("Info",$Job);
		$this->seo("comapply");
		$this->yun_tpl(array('comapply'));
	}
	
	function qrcode_action(){
		$wapUrl = Url('wap');
		if( isset($_GET['id']) && $_GET['id'] != '')
			$wapUrl = Url('wap',array('c'=>'job','a'=>'share','id'=>(int)$_GET['id']));
		include_once LIB_PATH."yunqrcode.class.php";
		YunQrcode::generatePng2($wapUrl,4);
	}

	function msg_action(){
		if($_POST['submit']){
			if($this->uid==''||$this->username==''){
				$this->ACT_layer_msg("请先登录！",8,$_SERVER['HTTP_REFERER']);
			}
			if($this->usertype!="1"){
				$this->ACT_layer_msg("只有个人用户才可以留言！",8,$_SERVER['HTTP_REFERER']);
			}
			$M=$this->MODEL("job");
			$black=$M->GetBlackOne(array('p_uid'=>$this->uid,'c_uid'=>(int)$_POST['job_uid']));
			if(!empty($black)){
				$this->ACT_layer_msg("该企业暂不接受相关咨询！",8,$_SERVER['HTTP_REFERER']);
			}
			if(trim($_POST['content'])==""){
				$this->ACT_layer_msg( "留言内容不能为空！",8,$_SERVER['HTTP_REFERER']);
			}
			if(trim($_POST['authcode'])==""){
				$this->ACT_layer_msg( "验证码不能为空！",8,$_SERVER['HTTP_REFERER']);
			}
			session_start();
			if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
				$this->ACT_layer_msg("验证码错误！", 8,$_SERVER['HTTP_REFERER']);
			}
			$id=$M->AddMsg(array('uid'=>$this->uid,'username'=>$this->username,'jobid'=>trim($_POST['jobid']),'job_uid'=>trim($_POST['job_uid']),'content'=>trim($_POST['content']),'com_name'=>trim($_POST['com_name']),'job_name'=>trim($_POST['job_name']),'type'=>'1','datetime'=>time()));
			isset($id)?$this->ACT_layer_msg( "留言成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg("留言失败！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function GetHits_action() {
	    if(intval($_GET['id'])){
	        $JobM=$this->MODEL('job');
	        $JobM->UpdateComjob(array("`jobhits`=`jobhits`+1"),array("id"=>(int)$_GET['id']));
	        $hits=$JobM->GetComjobOne(array('id'=>intval($_GET['id'])),array('field'=>'jobhits'));
	        echo 'document.write('.$hits['jobhits'].')';
	    }
	}
	function gettel_action(){

		//只有网站不直接开放联系方式下才用到
		if($this->config['com_login_link']!="2"){
			
			//个人用户才可查看
			if($this->usertype=='1' || $this->config['com_login_link']=="1"){
				//拥有简历才可查看
				if($this->config['com_resume_link']=="1" && $this->config['com_login_link']=="3"){
					$ResumeM=$this->MODEL('resume');
					$resume=$ResumeM->GetResumeExpectNum(array('uid'=>$this->uid));
					if($resume<1){
						echo 1;
						die;
					}
				}
				//查询职位联系方式
				$id=intval($_POST['id']);
				if($id>=1){
					$JobM=$this->MODEL('job');
					$JobInfo=$JobM->GetComjobOne(array('id'=>$id,'r_status<>2','state'=>1),array('field'=>'`link_type`,`uid`'));

					$companyM=$this->MODEL('company');
					$cominfo=$companyM->GetCompanyInfo(array('uid'=>$JobInfo['uid']),array('field'=>'`linktel`,`linkphone`,`linkqq`,`linkman`,`busstops`'));
					
					$JobInfo['linkqq']=$cominfo['linkqq'];
					$JobInfo['busstops']=$cominfo['busstops'];
					if($JobInfo['link_type']=='1'){
						
						
						if ($cominfo['linktel']){
							$JobInfo['linktel']=$cominfo['linktel'];
						}elseif ($cominfo['linkphone']){
							$JobInfo['linktel']=$cominfo['linkphone'];
						}
						
						$JobInfo['linkman']=$cominfo['linkman'];
					}else{
						$link=$JobM->GetComjoblinkOne(array('jobid'=>$id),array('field'=>'link_moblie,linkman'));
						if(!empty($link)){
							
							$JobInfo['linktel']=$link['link_moblie'];
							$JobInfo['linkman']=$cominfo['linkman'];
						}else{
							if ($cominfo['linktel']){
								$JobInfo['linktel']=$cominfo['linktel'];
							}elseif ($cominfo['linkphone']){
								$JobInfo['linktel']=$cominfo['linkphone'];
							}
						
							$JobInfo['linkman']=$cominfo['linkman'];
							
						}
					}
					echo json_encode(array('linktel'=>iconv('gbk','utf-8',$JobInfo['linktel']),'linkqq'=>iconv('gbk','utf-8',$JobInfo['linkqq']),'linkman'=>iconv('gbk','utf-8',$JobInfo['linkman']),'busstops'=>iconv('gbk','utf-8',$JobInfo['busstops'])));
				}
			}else{
				echo 2;
			}
		}else{
		
			echo 0;
		}
	}
}
?>