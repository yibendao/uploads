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
class com_controller extends wap_controller{
	function comguwen(){
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$guweninfo=$this->obj->DB_select_once("company_consultant","`id` ='".$company['conid']."'");
		if($guweninfo['logo']){
		    $guweninfo['logo']=str_replace("./",$this->config['sy_weburl']."/",$guweninfo['logo']);
		}else{
		    $guweninfo['logo']=$this->config['sy_weburl'].'/'.$this->config['sy_guwen'];
		}
		include(PLUS_PATH."menu.cache.php");
		$this->yunset("company",$company);
		$this->yunset("guweninfo",$guweninfo);
	}
	function get_user(){
		$rows=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		if(!$rows['name'] || !$rows['address'] || !$rows['pr']){				
			 $data['msg']='请先完善企业资料！';
		     $data['url']='index.php?c=info';
			 $this->yunset("layer",$data);						
		}
		$this->yunset("company",$rows);
		return $rows;
	}
	function waptpl($tpname){
		$this->yuntpl(array('wap/member/com/'.$tpname));
	}
	function index_action(){ 
		$this->comguwen();
		$this->rightinfo();
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`name`,`logo`,`uid`,`yyzz_status`,`hy`");
		if(!$company['logo'] || !file_exists(str_replace('./',APP_PATH,$company['logo']))){
		    $company['logo']=$this->config['sy_weburl']."/".$this->config['sy_unit_icon'];
		}else{
		    $company['logo']=str_replace("./",$this->config['sy_weburl']."/",$company['logo']);
		}
		$this->yunset("company",$company);
		$sqnum=$this->obj->DB_select_num("userid_job","`com_id`='".$this->uid."'");
		$this->yunset("sqnum",$sqnum);
		$jobnum=$this->obj->DB_select_num("company_job","`uid`='".$this->uid."'");
		$this->yunset("jobnum",$jobnum);
		$talent_pool_num=$this->obj->DB_select_num("talent_pool","`cuid`='".$this->uid."'");
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'","`vip_etime`,`rating_type`,`job_num`,`integral`");
		if($statis['vip_etime']>time() || $statis['vip_etime']==0){ 
			if($statis['rating_type']=="2"){
				$addjobnum='1';
			}else{
				if($statis['job_num']>0){
					$addjobnum='1';
				}else{
					if($this->config['com_integral_online']=='1'){
						$addjobnum='2';
					}else{
						$addjobnum='0';
					}
				}  
			}
		}else {
			if($this->config['com_integral_online']=='1'){ 
				$addjobnum='2';
			}else{
				$addjobnum='0';
			}
		}
		
		$statis['addjobnum']=$addjobnum;
		$backurl=Url('wap',array());
		$this->yunset('backurl',$backurl);
		$this->yunset("statis",$statis);
		$this->yunset("talent_pool_num",$talent_pool_num);
		$this->waptpl('index');
	}
	function com_action(){
		$this->comguwen();
		$this->rightinfo();
		$info=$this->obj->DB_select_once("prepaid_card","`card`='".$_POST['card']."' and `password`='".$_POST['password']."'");
		if($_POST['submit']){
		    $info=$this->obj->DB_select_once("prepaid_card","`card`='".$_POST['card']."' and `password`='".$_POST['password']."'");
		    if($_POST['card']==''){
		        $data['msg']='请填写卡号！';
		    }elseif($_POST['password']==''){
		        $data['msg']='请填写密码！';
		    }elseif(empty($info)){
		        $data['msg']='卡号或密码错误！';
    		}elseif($info['uid']>0){
    		    $data['msg']='该充值卡已使用！';
    		}elseif($info['type']=="2"){
    		    $data['msg']='该充值卡不可用！';
    		}elseif($info['stime']>time()){
    		    $data['msg']='该充值卡还未到使用时间！';
    		}elseif($info['etime']<time()){
    		    $data['msg']='该充值卡已过期！';
    		}
		    if ($data['msg']==''){
		        $dingdan=mktime().rand(10000,99999);
		        $integral=$info['quota']*$this->config['integral_proportion'];
		        $data['order_id']=$dingdan;
		        $data['order_price']=$info['quota'];
		        $data['order_time']=mktime();
		        $data['order_state']="2";
		        $data['order_remark']="使用充值卡";
		        $data['uid']=$this->uid;
		        $data['did']=$this->userdid;
		        $data['integral']=$integral;
		        $data['type']='2';
		        $nid=$this->obj->insert_into("company_order",$data);
		        if($nid){
		            $this->obj->DB_update_all("prepaid_card","`uid`='".$this->uid."',`username`='".$this->username."',`utime`='".time()."'","`id`='".$info['id']."'");
		            $this->company_invtal($this->uid,$integral,true,"充值卡充值",true,$pay_state=2,"integral");
		            $data['msg']='充值卡使用成功！';
		            $data['url']=$_SERVER['HTTP_REFERER'];
		        }else{
		            $data['msg']='充值卡使用失败！';
		            $data['url']=$_SERVER['HTTP_REFERER'];
		        }
		    }
		    $this->yunset("layer",$data);
		}
		$this->company_satic();
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		if($statis['rating']){
		    $rating=$this->obj->DB_select_once("company_rating","`id`='".$statis['rating']."'");
		}
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		if($statis['rating']>0){
		    if($statis['vip_etime']>time()){
		        $days=round(($statis['vip_etime']-mktime())/3600/24) ;
		        $this->yunset("days",$days);
		    }
		}
		$allprice=$this->obj->DB_select_once("company_pay","`com_id`='".$this->uid."' and `type`='1' and `order_price`<0","sum(order_price) as allprice");
		if($allprice['allprice']==''){$allprice['allprice']='0';}
		$this->yunset("integral",number_format(str_replace("-","", $allprice['allprice'])));
		$this->yunset("com",$com);
		$this->yunset("statis",$statis);
		$this->yunset("rating",$rating);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('com');
	}
	function info_action(){
		$this->rightinfo();
		if($_POST['submit']){
			$_POST=$this->post_trim($_POST);
			$comname=$this->obj->DB_select_num('company',"`uid`<>'".$this->uid."' and `name`='".$_POST['name']."'","`uid`");
			$linkphone=array();
			if($_POST['phonetwo']){ 
				if($_POST['phone']){
					$linkphone[]=$_POST['phone'];
					unset($_POST['phone']);
				}else{
					$data['msg']='请填写区号！';
				}
				if($_POST['phonetwo']){
					$linkphone[]=$_POST['phonetwo'];
					unset($_POST['phonetwo']);
				}
				if($_POST['phonethree']){
					$linkphone[]=$_POST['phonethree'];
					unset($_POST['phonethree']);
				}
			}
			if($data['msg']==''){ 
				$_POST['linkphone']=@implode('-',$linkphone);
				if($_POST['name']==""){
					$data['msg']='企业全称不能为空！';
				}elseif($comname){
					$data['msg']='企业全称已存在！';
				}elseif($_POST['hy']==""){
					$data['msg']='从事行业不能为空！';
				}elseif($_POST['pr']==""){
					$data['msg']='企业性质不能为空！';
				}elseif($_POST['provinceid']==""){
					$data['msg']='所在地不能为空！';
				}elseif($_POST['mun']==""){
					$data['msg']='企业规模不能为空！';
				}else if($_POST['address']==""){
					$data['msg']='公司地址不能为空！';	
				}else if($_POST['linkphone']==""&&$_POST['linktel']==""){
					$data['msg']='手机或电话必填一项！';
				}elseif($_POST['content']==""){
					$data['msg']='企业简介不能为空！';
				}
			}
			if($data['msg']==''){
				delfiledir("../data/upload/tel/".$this->uid);
				$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
				$Member=$this->MODEL("userinfo");
				if($company['moblie_status']==1){
					unset($_POST['linktel']);
				}else{
					$moblieNum = $Member->GetMemberNum(array("moblie"=>$_POST['linktel'],"`uid`<>'".$this->uid."'"));
					if($_POST['linktel']==''){
						$data['msg']='手机号码不能为空！';
					}elseif($this->CheckMoblie($_POST['linktel'])==false){
						$data['msg']='手机号码格式错误！';
					}elseif($moblieNum>0){
						$data['msg']='手机号码已存在！';
					}else{
						$mvalue['moblie']=$_POST['linktel'];
					}
						
				}
				if($company['email_status']==1){
					unset($_POST['linkmail']);
				}else{
					$emailNum = $Member->GetMemberNum(array("email"=>$_POST['linkmail'],"`uid`<>'".$this->uid."'"));
					if($_POST['linkmail']&&$this->CheckRegEmail($_POST['linkmail'])==false){
						$data['msg']='联系邮箱格式错误！';
					}elseif($_POST['linkmail']&&$emailNum>0){
						$data['msg']='联系邮箱已存在！';
					}else{
						$mvalue['email']=$_POST['linkmail'];
					}
				}
				if($company['yyzz_status']=='1'){
					$_POST['name'] = $company['name'];
				}
				if($_FILES['comqcode']['tmp_name']){
					$upload=$this->upload_pic("../../data/upload/company/",false);
					$comqcode=$upload->picture($_FILES['comqcode']);
					$this->picmsg($comqcode,$_SERVER['HTTP_REFERER']);
					$_POST['comqcode'] = str_replace("../../data/","./data/",$comqcode);
					if($company['comqcode']){
						unlink_pic("../.".$company['comqcode']);
					}
				}
				unset($_POST['submit']);
				$where['uid']=$this->uid;
				$_POST['lastupdate']=time(); 
				$nid=$this->obj->update_once("company",$_POST,$where);
				if($nid){
					if(!empty($mvalue)){
						$this->obj->update_once('member',$mvalue,array("uid"=>$this->uid));
					}
					$data['com_name']=$_POST['name'];
					$data['pr']=$_POST['pr'];
					$data['mun']=$_POST['mun'];
					$data['com_provinceid']=$_POST['provinceid'];
					$this->obj->update_once("company_job",$data,array("uid"=>$this->uid));


					if($company['name']!=$_POST['name']){
						$this->obj->update_once("partjob",array("com_name"=>$_POST['name']),array("uid"=>$this->uid));
						$this->obj->update_once("userid_job",array("com_name"=>$_POST['name']),array("com_id"=>$this->uid));
						$this->obj->update_once("fav_job",array("com_name"=>$_POST['name']),array("com_id"=>$this->uid));
						$this->obj->update_once("report",array("r_name"=>$_POST['name']),array("c_uid"=>$this->uid));
						$this->obj->update_once("blacklist",array("com_name"=>$_POST['name']),array("c_uid"=>$this->uid));
						$this->obj->update_once("msg",array("com_name"=>$_POST['name']),array("job_uid"=>$this->uid));
					}
					

					if($company['lastupdate']<1){
						if($this->config['integral_userinfo_type']=="1"){
							$auto=true;
						}else{
							$auto=false;
						}

						$this->company_invtal($this->uid,$this->config['integral_userinfo'],$auto,"首次填写基本资料",true,2,'integral',25);
					}
					$this->member_log("修改企业资料");
					$data['msg']='更新成功！';
					$data['url']='index.php?c=info';
				}else{
					$data['msg']='更新失败！';
					$data['url']='index.php?c=info';
				}
			}
			$this->yunset("layer",$data);
		}
		$row=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		if ($row['comqcode']){
		    $row['comqcode']=str_replace('./', $this->config['sy_weburl'].'/', $row['comqcode']);
		}
		$linkphone=@explode('-',$row['linkphone']);
		$row['phone']=$linkphone[0];
		$row['phonetwo']=$linkphone[1];
		$row['phonethree']=$linkphone[2]; 
		$this->yunset($this->MODEL('cache')->GetCache(array('city','com','hy')));
		$this->yunset("row",$row);
		$this->comguwen();
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('info');
	}
	function get_com($type){
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		if($statis['rating_type']&&$statis['rating']) {
			if($type==1){
				if($statis['rating_type']=='1' && $statis['job_num']>0 && ($statis['vip_etime']<1 || $statis['vip_etime']>=time())){
					$value="`job_num`=`job_num`-1";
				}elseif($statis['rating_type']=='2' && $statis['vip_etime']>time()){
					$value="";
				}else{
					return $this->intergal($type,$statis);
				}
			}elseif($type==2){
				if($statis['rating_type']=='1' && $statis['editjob_num']>0 && ($statis['vip_etime']<1 || $statis['vip_etime']>=time())){
					$value="`editjob_num`=`editjob_num`-1";
				}else if($statis['rating_type']=='2' && $statis['vip_etime']>time()){
					$value="";
				}else{
					return $this->intergal($type,$statis);
				}
			}elseif($type==3){
				if($statis['rating_type']=='1' && $statis['breakjob_num']>0 && ($statis['vip_etime']<1 || $statis['vip_etime']>=time())){
					$value="`breakjob_num`=`breakjob_num`-1";
				}else if($statis['rating_type']=='2' && $statis['vip_etime']>time()){
					$value="";
				}else{
					return $this->intergal($type,$statis);
				}
			}elseif($type==7){
				if($statis['rating_type']=='1' && $statis['part_num']>0 && ($statis['vip_etime']<1 || $statis['vip_etime']>=time())){
					$value="`part_num`=`part_num`-1";
				}else if($statis['rating_type']=='2' && $statis['vip_etime']>time()){
					$value="";
				}else{
					return $this->intergal($type,$statis);
				}
			}elseif($type==8){
				if($statis['rating_type']=='1' && $statis['editpart_num']>0 && ($statis['vip_etime']<1 || $statis['vip_etime']>=time())){
					$value="`editpart_num`=`editpart_num`-1";
				}else if($statis['rating_type']=='2' && $statis['vip_etime']>time()){
					$value="";
				}else{
					return $this->intergal($type,$statis);
				}
			}elseif($type==9){
				if($statis['rating_type']=='1' && $statis['breakpart_num']>0 && ($statis['vip_etime']<1 || $statis['vip_etime']>=time())){
					$value="`breakpart_num`=`breakpart_num`-1";
				}else if($statis['rating_type']=='2' && $statis['vip_etime']>time()){
					$value="";
				}else{
					return $this->intergal($type,$statis);
				}
			}
			if($value){
				$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
			}
		}else{
			return $this->intergal($type,$statis);
		}
	}
	function intergal($type,$statis){
		$data=array("1"=>'会员发布职位用完,购买会员服务更快捷！',"2"=>'会员修改职位用完！',"3"=>'会员刷新职位用完！',"4"=>'会员发布猎头职位用完，购买会员服务更快捷！',"5"=>'会员修改猎头职位用完！',"6"=>'会员刷新猎头职位用完！',"7"=>'会员发布兼职职位用完，购买会员服务更快捷！',"8"=>'会员修改兼职职位用完！',"9"=>'会员刷新兼职职位用完！');
		if($this->config['com_integral_online']=="1"){
			if($type==1 && $this->config['integral_job']){
				if($this->config['integral_job_type']=="1"){
					$auto=true;
				}else if($statis['integral']<$this->config['integral_job']){
					return "你的".$this->config['integral_pricename']."不够发布职位！";
				}else if($statis['integral']>=$this->config['integral_job']){
					$auto=false;
				}
				$nid=$this->company_invtal($this->uid,$this->config['integral_job'],$auto,"发布职位",true,2,'integral',6);
			}elseif($type==3 && $this->config['integral_jobefresh']){
				if($this->config['integral_jobefresh_type']=="1"){
					$auto=true;
				}else if($statis['integral']<$this->config['integral_jobefresh']){
					
					if($_GET){
					return	$this->layer_msg("你的".$this->config['integral_pricename']."不够刷新职位！",8,0,"index.php?c=pay");
					}else{
					return	$this->ACT_layer_msg("你的".$this->config['integral_pricename']."不够刷新职位！",8,"index.php?c=pay");
					}
					
				}else{
					$auto=false;
				}
				$nid=$this->company_invtal($this->uid,$this->config['integral_jobefresh'],$auto,"刷新职位",true,2,'integral',8);
			}elseif($type==7 && $this->config['integral_partjob']){
				if($this->config['integral_partjob_type']=="1"){
					$auto=true;
				}if($statis['integral']<$this->config['integral_partjob']){
					return "你的".$this->config['integral_pricename']."不够发布兼职职位！";
				}else{
					$auto=false;
				}
				$nid=$this->company_invtal($this->uid,$this->config['integral_partjob'],$auto,"发布兼职职位",true,2,'integral',18);
			}elseif($type==9 && $this->config['integral_partjobefresh']){
				if($this->config['integral_partjobefresh_type']=="1"){
					$auto=true;
				}else if($statis['integral']<$this->config['integral_partjobefresh']){
					return "你的".$this->config['integral_pricename']."不够刷新兼职职位！";
				}else{
					$auto=false;
				}
				$nid=$this->company_invtal($this->uid,$this->config['integral_partjobefresh'],$auto,"刷新兼职职位",true,2,'integral',20);
			}
		}else{
			return $data[$type];
		}
	}
	function jobadd_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		if($company['lastupdate']<1){
			$data['msg']="请先完善基本资料！";
			$data['url']='index.php?c=info';
		}
		$this->rightinfo();
		$msg=array();
		$isallow_addjob="1";
		if($this->config['com_enforce_emailcert']=="1"){
			if($company['email_status']!="1"){
				$isallow_addjob="0";
				$msg[]="邮箱认证";
			}
		}
		if($this->config['com_enforce_mobilecert']=="1"){
			if($company['moblie_status']!="1"){
				$data['msg']="请先完成手机认证";
				$data['url']='index.php?c=binding';
			}
		}
		if($this->config['com_enforce_licensecert']=="1"){
			if($company['yyzz_status']!="1"){
				$data['msg']="请先完成营业执照认证";
				$data['url']='index.php?c=binding';
			}
		}
		if($this->config['com_enforce_setposition']=="1"){
			if(empty($company['x'])||empty($company['y'])){
				$isallow_addjob="0";
				$msg[]="设置企业地图";
				$url="index.php?c=map";
			}
		}
		if($isallow_addjob=="0"){
			$data['msg']="请先登录电脑客户端完成".implode(",",$msg)."！";
			$data['url']='index.php';
		}else if($_GET['id']){
			$row=$this->obj->DB_select_once("company_job","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			$arr_data1=$arr_data['sex'][$row['sex']];		
		    $this->yunset("arr_data1",$arr_data1);
			if($row['id']){
				if($row['lang']!=""){
					$row['lang']= @explode(",",$row['lang']);
				}
				if($row['welfare']!=""){
					$row['welfare']= @explode(",",$row['welfare']);
				}
				$row['days']= ceil(($row['edate']-$row['sdate'])/86400);
				$job_link=$this->obj->DB_select_once("company_job_link","`jobid`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
				$this->yunset("job_link",$job_link);
				$row['islink']=$job_link['link_type'];
				$row['isemail']=$job_link['email_type'];
				$this->yunset("row",$row);
			}else{
				$data['msg']='非法操作！';
				$data['url']='index.php?c=job';
			}
		}
		if($_POST['submit']){
			$id=intval($_POST['id']);
			$state= intval($_POST['state']);
			unset($_POST['submit']);
			unset($_POST['id']);
			unset($_POST['state']);

			$_POST['lastupdate']=mktime(); 
			$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'","`status`,`did`");

			if($member['status']!="1"){
			   $_POST['state']=0;
			}else{
			   $_POST['state']=$this->config['com_job_status'];
			}
			if($this->config['com_job_status']=="0"){
				$msg="等待审核！";
			}
			if(!empty($_POST['lang'])){
				$_POST['lang'] = pylode(",",$_POST['lang']);
			}else{
				$_POST['lang'] = "";
			}
			if(!empty($_POST['welfare'])){
				$_POST['welfare'] = pylode(",",$_POST['welfare']);
			}else{
				$_POST['welfare'] = "";
			}
			$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`name`,`logo`,`provinceid`,`pr`,`mun`");
			$_POST['sdate']=time();
			$_POST['edate']=time()+$_POST['days']*86400;
			unset($_POST['days']);
			$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'","`rating`");
			$_POST['com_name']=$com['name'];
			$_POST['com_logo']=$com['logo'];
			$_POST['com_provinceid']=$com['provinceid'];
			$_POST['pr']=$com['pr'];
			$_POST['mun']=$com['mun'];
			$_POST['rating']=$statis['rating'];
			$islink=(int)$_POST['islink'];
			$link_type=$islink;
			if($islink<3){
			    $linktype=$islink;
			    $islink=1;
			}else{
			    $islink=0;
			}
			$isemail=(int)$_POST['isemail'];
			$emailtype=$isemail;
			if($isemail<3){
			    $isemail=1;
			}else{
			    $isemail=0;
			}
			if($_POST['salary_type']){
				$_POST['minsalary']=$_POST['maxsalary']=0;
			}
			$_POST['is_link']=$islink;
			$_POST['link_type']=$linktype;
			$_POST['is_email']=$isemail;
			$link_moblie=$_POST['link_moblie'];
			$email=$_POST['email'];
			$link_man=$_POST['link_man'];
			unset($_POST['link_moblie']);
			unset($_POST['islink']);
			unset($_POST['isemail']);
			unset($_POST['link_man']);
			unset($_POST['email']);
			if(!$id){ 
				$_POST['uid']=$this->uid;
				$_POST['did']=$member['did'];

				$data['msg']=$this->get_com(1);
				if($data['msg']==''){
					$_POST['source']=2;
					$nid=$this->obj->insert_into("company_job",$_POST);
					$name="添加职位";
					if($nid){
						$this->obj->DB_update_all("company","`jobtime`='".$_POST['lastupdate']."'","`uid`='".$this->uid."'");
						$state_content = "发布了新职位 <a href=\"".Url("job",array("c"=>"comapply","id"=>$nid))."\" target=\"_blank\">".$_POST['name']."</a>。";
						$this->addstate($state_content);
						$this->member_log("发布了新职位 ".$_POST['name']);
					}
					$nid?$data['msg']=$name."成功！":$data['msg']=$name."失败！";
				}
			}else{
				$where['id']=$id;
				$where['uid']=$this->uid;
				if($state=="1" || $state=="2"){
					$data['msg']=$this->get_com(2);
				}
				if($data['msg']==''){
					$nid=$this->obj->update_once("company_job",$_POST,$where);
					$name="更新职位";
					if($nid){
						$this->obj->DB_update_all("company","`jobtime`='".$_POST['lastupdate']."'","`uid`='".$this->uid."'");
						$this->member_log("更新基本信息".$_POST['name']);
					}
					$nid?$data['msg']=$name."成功！":$data['msg']=$name."失败！";
				}

			}
			$joblink=array();
			$joblink[]="`email`='".trim($email)."',`is_email`='".$isemail."',`email_type`='".$emailtype."'";
			if($linktype==2){
			    $joblink[]="`link_man`='".$link_man."',`link_moblie`='".$link_moblie."'";
			}
			if ($link_type){
			    $joblink[]="`link_type`='".$link_type."'";
			}
			if($id){
			    delfiledir("../data/upload/tel/".$this->uid);
			    $linkid=$this->obj->DB_select_once("company_job_link","`uid`='".$this->uid."' and `jobid`='".$id."'","id");
			    if($linkid['id']){
			        $this->obj->DB_update_all("company_job_link",@implode(',',$joblink),"`id`='".$linkid['id']."'");
			    }else{
			        $joblink[]="`uid`='".$this->uid."',`jobid`='".(int)$id."'";
			        $this->obj->DB_insert_once("company_job_link",@implode(',',$joblink));
			    }
			}else if($nid>0){
			    $joblink[]="`uid`='".$this->uid."',`jobid`='".(int)$nid."'";
			    $this->obj->DB_insert_once("company_job_link",@implode(',',$joblink));
			}
			$data['url']='index.php?c=job';
		}
		$this->yunset("layer",$data);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','com','hy','job')));
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('jobadd');
	}
	function job_action(){
		$this->rightinfo();
		$urlarr=array("c"=>"job","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$this->get_page("company_job","`uid`='".$this->uid."'",$pageurl,"10");
		$this->company_satic();
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->waptpl('job');
	}
	function refreshjob_action(){ 
		if($_GET['up']){
			$this->get_com(3);
			$nid=$this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`uid`='".$this->uid."' and `id`='".(int)$_GET['up']."'");
			if($nid){
				$this->obj->DB_update_all("company","`jobtime`='".time()."'","`uid`='".$this->uid."'");
				$job=$this->obj->DB_select_once("company_job","`id`='".(int)$_GET['up']."'","name");
				$this->obj->member_log("刷新职位《".$job['name']."》",1,4); 
				$this->layer_msg('刷新职位成功！',9,0,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('刷新失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
	}
	function getserver_action(){ 
		$jobid=intval($_GET['id']);
		$server=intval($_GET['server']);
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'","`integral`"); 
		$info=$this->obj->DB_select_once("company_job","`uid`='".$this->uid."' and `id`='".$jobid."'","`id`,`job1`,`rec_time`,`urgent_time`,`urgent`,`rec`,`xuanshang`");  
		$this->yunset("info",$info); 
		$this->yunset("statis",$statis);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('getserver');
	}
	function saveserver_action(){
		$server=intval($_POST['server']);
		$days=intval($_POST['days']);
		$jobid=intval($_POST['jobid']); 
		if($days<1){ 
			echo json_encode(array('type'=>2,'msg'=>yun_iconv("gbk","utf-8",'请选择或填写天数！')));die;
		}else{
			if($server=='1'){
				$price=$days*$this->config['job_auto'];
				if($this->config['job_auto_type']=="1"){
					$auto=true;
				}else{
					$auto=false;
				}
				$type=9;
				$msg="购买自动刷新";
			}else if($server=='2'){
				$price=$days*$this->config['integral_job_top'];
				$auto=false;
				$type=11;
				$msg="发布置顶职位";
			}else if($server=='3'){
				if($this->config['com_recjob_type']=="1"){
					$auto=true;
				}else{
					$auto=false;
				}
				$price=$days*$this->config['com_recjob'];
				$type=12;
				$msg="发布推荐职位";
			}else{
				$price=$days*$this->config['com_urgent'];
				if($this->config['com_urgent_type']=="1"){
					$auto=true;
				}else{
					$auto=false;
				}
				$type=10;
				$msg="发布紧急职位";
			}
			$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'","`integral`"); 
			$info=$this->obj->DB_select_once("company_job","`uid`='".$this->uid."' and `id`='".$jobid."'","`id`,`name`,`job1`,`rec_time`,`urgent_time`,`urgent`,`rec`,`xuanshang`,`xsdate`"); 
			if($price>$statis['integral']&&$auto==false){
				echo json_encode(array('type'=>2,'msg'=>yun_iconv("gbk","utf-8",$this->config['integral_pricename'].'不足，请先充值！')));die;
			}else{
				$this->company_invtal($this->uid,$price,$auto,$msg,true,2,'integral',$type);
				if($server=='1'){ 
					if($info['autotime']>=time()){
						$autotime = $info['autotime']+$days*86400;
					}else{
						$autotime = time()+$days*86400;
					} 
					$this->obj->update_once('company_job',array('autotime'=>$autotime,'autotype'=>1),"`uid`='".$this->uid."' and `id`='".$info['id']."'"); 
					$this->obj->update_once('company_statis',array('autotime'=>$autotime),array('uid'=>$this->uid)); 
					$this->obj->member_log("购买职位自动刷新功能");
				}else if($server=='2'){
					if($info['xsdate']>time()){
						$data['xsdate']=$info['xsdate']+$days*86400;
					}else{
						$data['xsdate']=strtotime("+".$days." day");
					}  
					$this->obj->update_once("company_job",$data,array('uid'=>$this->uid,'id'=>$info['id']));
					$this->obj->member_log("发布竞价职位《".$info['name']."》",1,1);
				}else if($server=='3'){
					if($info['rec_time']<time()){
						$time=time()+$days*86400;
					}else{
						$time=$info['rec_time']+$days*86400;
					}
					$this->obj->update_once("company_job",array('rec'=>1,'rec_time'=>$time),array('uid'=>$this->uid,'id'=>$info['id']));
					$this->obj->member_log("发布推荐职位《".$info['name']."》",1,1);
				}else{
					if($info['urgent_time']<time()){
						$time=time()+$days*86400;
					}else{
						$time=$info['urgent_time']+$days*86400;
					}
					$this->obj->update_once("company_job",array('urgent'=>1,'urgent_time'=>$time),array('uid'=>$this->uid,'id'=>$info['id']));
					$this->obj->member_log("发布紧急职位《".$info['name']."》",1,1);
				}
				echo json_encode(array('type'=>1,'msg'=>yun_iconv("gbk","utf-8",'操作成功！')));die;
			}
		}
	}
	function jobset_action(){
		if($_GET['status']){
			if($_GET['status']==2){
				$_GET['status']=0;
			}
			$this->obj->update_once('company_job',array('status'=>intval($_GET['status'])),array('uid'=>$this->uid,'id'=>intval($_GET['id'])));
			$this->member_log("修改职位招聘状态");
			$this->get_user();
			$this->waplayer_msg("设置成功！");
		}
	}

	function jobdel_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_delete_all("company_job","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			if($nid){
				$newest=$this->obj->DB_select_once("company_job","`uid`='".$this->uid."' order by lastupdate DESC","`lastupdate`");
				$this->obj->DB_delete_all("userid_job","`com_id`='".$this->uid."' and `job_id`='".(int)$_GET['id']."'");
				$this->obj->DB_delete_all("look_job","`com_id`='".$this->uid."' and `jobid`='".(int)$_GET['id']."'");
				$this->obj->DB_delete_all("fav_job","`job_id`='".(int)$_GET['id']."'"," ");
                $this->obj->DB_delete_all("user_entrust_record","`jobid`='".(int)$_GET['id']."' and `comid`='".$this->uid."'","");
                $this->obj->DB_delete_all("report","`usertype`=1 and `type`=0 and `eid`='".(int)$_GET['id']."'","");
				$this->obj->update_once("company",array("jobtime"=>$newest['lastupdate']),array("uid"=>$this->uid));
				$this->obj->DB_delete_all("company_job_link","`uid`='".$this->uid."' and `jobid`='".(int)$_GET['id']."'");
				$this->member_log("删除职位记录（ID:".(int)$_GET['id']."）");
				$this->waplayer_msg("删除成功！");
			}else{
				$this->waplayer_msg("删除失败！");
			}
		}
	}
	
	function partapply_action(){
		$this->rightinfo();
		
		if($_GET['del']){
			$nid=$this->obj->DB_delete_all("part_apply","`id`='".(int)$_GET['del']."' and `comid`='".$this->uid."'");
			if($nid){
				$data['msg']="删除成功!";
				$this->member_log("删除兼职报名");
			}else{
				$data['msg']="删除失败！";
			}
			$data['url']='index.php?c=partapply';
			$this->yunset("layer",$data);
		}
		
		if((int)$_GET['id']&&(int)$_GET['status']){
			$nid=$this->obj->update_once("part_apply",array('status'=>(int)$_GET['status']),array("comid"=>$this->uid,"id"=>(int)$_GET['id']));
			if($nid){
				$this->member_log("更改兼职报名状态（ID:".(int)$_GET['id']."）");
				$this->waplayer_msg("操作成功！");
			}else{
				$this->waplayer_msg("操作失败！");
			}
		}
		$urlarr=array("c"=>"partapply","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("part_apply","`comid`='".$this->uid."'",$pageurl,"10");
		if(is_array($rows)&&$rows){
			include PLUS_PATH."/user.cache.php";
			include(CONFIG_PATH."db.data.php");
		    unset($arr_data['sex'][3]);
		    $this->yunset("arr_data",$arr_data);
			foreach($rows as $val){
				$jobid[]=$val['jobid'];
				$uid[]=$val['uid'];
			}
			$joblist=$this->obj->DB_select_all("partjob","`id` in(".pylode(',',$jobid).")","`id`,`name`");
			$uselist=$this->obj->DB_select_all("resume","`uid` in (".pylode(",",$uid).") and `r_status`<>'2'","`name`,`sex`,`edu`,`uid`,`birthday`,`telphone`,`def_job`,`birthday`");
		}
		foreach($rows as $key=>$val){
			foreach($joblist as $k=>$v){
				if($val['jobid']==$v['id']){
					$rows[$key]['job_name']=$v['name'];
				}
			}
			foreach($uselist as $k=>$va){
				if($val['uid']==$va['uid']){
					$rows[$key]['username']=$va['name'];
					$rows[$key]['moblie']=$va['telphone'];
					$rows[$key]['sex']=$arr_data['sex'][$va['sex']];
					$rows[$key]['edu']=$userclass_name[$va['edu']];
					$rows[$key]['age']=ceil((time()-strtotime($va['birthday']))/31104000);
					$rows[$key]['resumeid']=$va['def_job'];
					$rows[$key]['birthday']=$va['birthday'];
				}
			}
		}
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('partapply');
	}
    function hr_action(){
		$this->rightinfo();
		$urlarr=array("c"=>"hr","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("userid_job","`com_id`='".$this->uid."' ORDER BY is_browse asc,datetime desc",$pageurl,"10");
		if(is_array($rows) && !empty($rows)){
			$uid=$eid=array();
			foreach($rows as $v){
				$uid[]=$v['uid'];
				$eid[]=$v['eid'];
			}
			$userrows=$this->obj->DB_select_all("resume","`uid` in (".pylode(",",$uid).") and `r_status`<>'2'","`name`,`sex`,`edu`,`uid`,`exp`");
			$userid_msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' and `uid` in (".pylode(",",$uid).")","uid,jobid");
			$expect=$this->obj->DB_select_all("resume_expect","`id` in (".pylode(",",$eid).")","`id`,`job_classid`,`salary`,`height_status`");

			if(is_array($userrows)){
				include(PLUS_PATH."user.cache.php");
				include(PLUS_PATH."job.cache.php");
				include(CONFIG_PATH."db.data.php");
		        unset($arr_data['sex'][3]);
		        $this->yunset("arr_data",$arr_data);
				$expectinfo=array();
				foreach($expect as $key=>$val){
					$jobids=@explode(',',$val['job_classid']);
					$jobname=array();
					foreach($jobids as $v){
						$jobname[]=$job_name[$v];
					}
					$expectinfo[$val['id']]['jobname']=@implode('、',$jobname);
					$expectinfo[$val['id']]['salary']=$userclass_name[$val['salary']];
					$expectinfo[$val['id']]['height_status']=$val['height_status'];
				}
				foreach($rows as $k=>$v){
					$rows[$k]['jobname']=$expectinfo[$v['eid']]['jobname'];
					$rows[$k]['salary']=$expectinfo[$v['eid']]['salary'];
					$rows[$k]['height_status']=$expectinfo[$v['eid']]['height_status'];
					
					foreach($userrows as $val){
						if($v['uid']==$val['uid']){
							$rows[$k]['name']=$val['name'];
							
							$rows[$k]['edu']=$userclass_name[$val['edu']];
							$rows[$k]['exp']=$userclass_name[$val['exp']];
							$rows[$k]['sex']=$arr_data['sex'][$val['sex']];
						}
					}
					foreach($userid_msg as $val){
						if($v['uid']==$val['uid'] && $val['jobid']==$v['job_id']){ 
							$rows[$k]['userid_msg']=1;
						}
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('hr');
	}
	function hrset_action(){
		$id=(int)$_GET['id'];
		$browse=(int)$_GET['browse'];
		if($id&&$browse){
			$nid=$this->obj->update_once("userid_job",array('is_browse'=>$browse),array("com_id"=>$this->uid,"id"=>$id));
			$this->member_log("更改申请职位状态（ID:".$id."）");
			
			if($browse==4){
				$resumeuid=$this->obj->DB_select_once("userid_job","`id`='".$id."'",'eid,job_id');
				$resumeexp=$this->obj->DB_select_once("resume_expect","`id`='".$resumeuid['eid']."' and `r_status`<>'2' and `status`='1'",'uid,uname');
				$uid=$this->obj->DB_select_once("resume","`uid`='".$resumeexp['uid']."'","telphone,email");
				$comjob=$this->obj->DB_select_once("company_job","`uid`='".$this->uid."' and `id`='".$resumeuid['job_id']."'","name,com_name");
				$data['uid']=$resumeexp['uid'];
				$data['cname']=$this->username;
				$data['name']=$resumeexp['uname'];
				$data['type']="sqzwhf";
				$data['cuid']=$this->uid;
				$data['company']=$comjob['com_name'];
				$data['jobname']=$comjob['name'];
				if($this->config['sy_msg_sqzwhf']=='1'&&$uid["telphone"]&&$this->config["sy_msguser"]&&$this->config["sy_msgpw"]&&$this->config["sy_msgkey"]&&$this->config['sy_msg_isopen']=='1'){$data["moblie"]=$uid["telphone"]; }
				if($this->config['sy_email_sqzwhf']=='1'&&$uid["email"]&&$this->config['sy_email_set']=="1"){$data["email"]=$uid["email"]; }
				if($data["email"]||$data['moblie']){
					$this->send_msg_email($data);
				}
			}
			$nid?$this->waplayer_msg("操作成功！"):$this->waplayer_msg("操作失败！");
		}
	}
	function delhr_action(){
		$nid=$this->obj->DB_delete_all("userid_job","`id`='".(int)$_GET['id']."' and `com_id`='".$this->uid."'");
		$this->member_log("删除申请职位记录（ID:".(int)$_GET['id']."）");
		$nid?$this->waplayer_msg("删除成功！"):$this->waplayer_msg("删除失败！");
	}
	function password_action(){
		$this->rightinfo();
		if($_POST['submit']){
			$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
			$pw=md5(md5($_POST['oldpassword']).$member['salt']);
			if($pw!=$member['password']){
				$data['msg']="旧密码不正确，请重新输入！";
			}else if(strlen($_POST['password1'])<6 || strlen($_POST['password1'])>20){
				$data['msg']="密码长度应在6-20位！";
			}elseif($_POST['password1']!=$_POST['password2']){
				$data['msg']="新密码和确认密码不一致！";
			}elseif($this->config['sy_uc_type']=="uc_center" && $member['name_repeat']!="1"){
				$this->uc_open();
				$ucresult= uc_user_edit($member['username'], $_POST['oldpassword'], $_POST['password1'], "","1");
				if($ucresult == -1){
					$data['msg']="旧密码不正确，请重新输入！";
				}
			}else{
				$salt = substr(uniqid(rand()), -6);
				$pass2 = md5(md5($_POST['password1']).$salt);
				$this->obj->DB_update_all("member","`password`='".$pass2."',`salt`='".$salt."'","`uid`='".$this->uid."'");
				SetCookie("uid","",time() -286400, "/");
				SetCookie("username","",time() - 86400, "/");
				SetCookie("salt","",time() -86400, "/");
				SetCookie("shell","",time() -86400, "/");
				$this->member_log("修改密码");
				$data['msg']="修改成功，请重新登录！";
				$data['url']=get_url(array('m'=>'wap','c'=>'login'),$this->config);
			}
            $this->waplayer_msg($data['msg'],$data['url']);
		}
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('password');
	}
	function time_action(){
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		$this->yunset("statis",$statis);
		$this->yunset("com",$com);
		$rows=$this->obj->DB_select_all("company_rating","`category`='1' and `display`='1' and `type`='2' order by `type` asc,`sort` desc");
		if(is_array($rows)&&$rows){
			foreach($rows as $v){
				$couponid[]=$v['coupon'];
			}
			if(empty($coupon)){
				$coupon=$this->obj->DB_select_all("coupon","`id` in (".@implode(",",$couponid).")","`id`,`name`");
			}
			if(is_array($coupon)){
				foreach($rows as $k=>$v){
					foreach($coupon as $val){
						if($v['coupon']==$val['id']){
							$rows[$k]['couponname']=$val['name'];
						}
					}
				}
			}
		}
		if($rows&&is_array($rows)){
			foreach ($rows as $k=>$v){
				$rname=array();
				if($v['job_num']>0){$rname[]='发布职位:'.$v['job_num'].'份';}
				if($v['breakjob_num']>0){$rname[]='刷新职位:'.$v['breakjob_num'].'份';}
				if($v['resume']>0){$rname[]='下载简历:'.$v['resume'].'份';}
				if($v['interview']>0){$rname[]='邀请面试:'.$v['interview'].'份';}
				if($v['part_num']>0){$rname[]='发布兼职职位:'.$v['part_num'].'份';}
				if($v['breakpart_num']>0){$rname[]='刷新兼职职位:'.$v['breakpart_num'].'份';}
				
				if($v['msg_num']>0){$rname[]='短信数:'.$v['msg_num'].'份';}
				$rows[$k]['rname']=@implode('+',$rname);
			}
		}
		$backurl=Url('wap',array('c'=>com),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset("rows",$rows);
		$this->yunset("js_def",4);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('member_time');
	}
	function rating_action(){
		$com=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		$this->yunset("statis",$statis);
		$this->yunset("com",$com);
		$rows=$this->obj->DB_select_all("company_rating","`category`='1' and `display`='1' and `type`='1' order by `type` asc,`sort` desc");
		if(is_array($rows)&&$rows){
			foreach($rows as $v){
				$couponid[]=$v['coupon'];
			}
			if(empty($coupon)){
				$coupon=$this->obj->DB_select_all("coupon","`id` in (".@implode(",",$couponid).")","`id`,`name`");
			}
			if(is_array($coupon)){
				foreach($rows as $k=>$v){
					foreach($coupon as $val){
						if($v['coupon']==$val['id']){
							$rows[$k]['couponname']=$val['name'];
						}
					}
				}
			}
		}
		if($rows&&is_array($rows)){
			foreach ($rows as $k=>$v){
				$rname=array();
				if($v['job_num']>0){$rname[]='发布职位:'.$v['job_num'].'份';}
				if($v['breakjob_num']>0){$rname[]='刷新职位:'.$v['breakjob_num'].'份';}
				if($v['resume']>0){$rname[]='下载简历:'.$v['resume'].'份';}
				if($v['interview']>0){$rname[]='邀请面试:'.$v['interview'].'份';}
				if($v['part_num']>0){$rname[]='发布兼职职位:'.$v['part_num'].'份';}
				if($v['breakpart_num']>0){$rname[]='刷新兼职职位:'.$v['breakpart_num'].'份';}				
				if($v['msg_num']>0){$rname[]='短信数:'.$v['msg_num'].'份';}
				$rows[$k]['rname']=@implode('+',$rname);
			}
		}
		$backurl=Url('wap',array('c'=>com),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset("rows",$rows);
		$this->yunset("js_def",4);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('member_rating');
	}
	function added_action(){
		$id=intval($_GET['id']);	
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		$rows=$this->obj->DB_select_all("company_service","`display`='1'");
		if($id){
			$info=$this->obj->DB_select_all("company_service_detail","`type` = '$id' order by `service_price` asc");
		}else{
			$row=$this->obj->DB_select_once("company_service","`display`='1'","id");
			$info=$this->obj->DB_select_all("company_service_detail","`type` = '".$row['id']."' order by `service_price` asc");
		}
		if($statis['rating']>0){
			if($statis['vip_etime']>time()){
				$days=round(($statis['vip_etime']-mktime())/3600/24) ;
				$this->yunset("days",$days);
			}
		}
		if ($statis){
			$rating=$statis['rating'];
			$discount=$this->obj->DB_select_once("company_rating","`id`=$rating");
			$this->yunset("discount",$discount);
		}
		$backurl=Url('wap',array('c'=>com),'member');
		$this->yunset('backurl',$backurl);
		$this->yunset("statis",$statis);
		$this->yunset("info",$info);
		$this->yunset("rows",$rows);
		$this->yunset("js_def",4);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('added');
	
	}
	function pay_action(){
		
		if($this->config['wxpay']=='1'){		
			$paytype['wxpay']='1';
		}
		if($this->config['alipay']=='1' &&  $this->config['alipaytype']=='1'){
			$paytype['alipay']='1';
		}
		if($paytype){
			$statis=$this->company_satic();
			if($_POST['usertype']=='price'){
				$id=(int)$_POST['id'];
				if ($id){
					$rows=$this->obj->DB_select_once("company_rating","`service_price`<>'' and `service_time`>'0' and `id`='".$id."' and `display`='1' and `category`=1 order by sort desc","name,time_start,time_end,service_price,yh_price,coupon,id");
					if ($rows['time_start']<time() && $rows['time_end']>time()){
						if ($rows['coupon']>0){
							$coupon=$this->obj->DB_select_once("coupon","`id`='".$rows['coupon']."'");
							$this->yunset("coupon",$coupon);
						}
					}
				}else{
					$rows=$this->obj->DB_select_all("company_rating","`service_price`<>'' and `service_time`>'0' and `display`='1' and `category`=1 order by sort desc","name,time_start,time_end,service_price,yh_price,id");
				}
				$this->yunset("rows",$rows);
			}elseif($_POST['usertype']=='service'){
				$id=(int)$_POST['id'];
				if($id){
					$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
					if ($statis){
						$rating=$statis['rating'];
						$discount=$this->obj->DB_select_once("company_rating","`id`='".$rating."'");
						$this->yunset("discount",$discount);
					}
					$rows=$this->obj->DB_select_once("company_service_detail","`id`='".$id."'","type,service_price,id");
					if ($rows['type']){
						$service=$this->obj->DB_select_once("company_service","`id`='".$rows['type']."'");
						$this->yunset("service",$service);
					}
					$this->yunset("rows",$rows);
				}else{
					$data['msg']="请选择套餐！";
					$data['url']=$_SERVER['HTTP_REFERER'];
					$this->yunset("layer",$data);
				}
			}elseif($_GET['id']){
				$order=$this->obj->DB_select_once("company_order","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."'");
				if(empty($order)){ 
					$this->ACT_msg($_SERVER['HTTP_REFERER'],"订单不存在！"); 
				}elseif($order['order_state']!='1'){ 
					header("Location:index.php?c=paylog"); 
				}else{
					$this->yunset("order",$order);
				}
			}
			$this->yunset("statis",$statis);
			$remark="姓名：\n联系电话：\n留言：";
			$this->yunset("paytype",$paytype);
			$this->yunset("remark",$remark);
			$this->yunset("js_def",4);			
		}else{		
			$data['msg']="暂未开通手机支付，请移步至电脑端充值！";
			$data['url']=$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
			
			
		}
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('pay');
	}

	
	function company_satic(){
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		if($statis['rating']){
			$rating=$this->obj->DB_select_once("company_rating","`id`='".$statis['rating']."'");
		}
		$statis['rating_type'] = $rating['type'];
		if($statis['vip_etime']<time()){
			
			if($statis['vip_etime']>'1'){
				$nums=0;
			}else if($statis['rating_type']=='1'&&$statis['vip_etime']<'1'){
				$nums=1;
			}
			if($nums<1){
				if($this->config['com_vip_done']=='0'){
					$data['job_num']=$data['down_resume']=$data['invite_resume']=$data['editjob_num']=$data['breakjob_num']=$data['part_num']=$data['editpart_num']=$data['breakpart_num']='0';
					$statis['rating_name']=$data['rating_name']="非会员";
					$statis['rating_type']=$statis['rating']=$data['rating']="";
					$statis['vip_etime']=$data['vip_etime']="";
					$where['uid']=$this->uid;
					$this->obj->update_once("company_statis",$data,$where);
				}elseif ($this->config['com_vip_done']=='1'){
					$ratingM = $this->MODEL('rating');
					$rat_value=$ratingM->rating_info();
					$this->obj->DB_update_all("company_statis",$rat_value,"`uid`='".$this->uid."'");
				}
			}
		}
		if($statis['autotime']>=time()){
			$statis['auto'] = 1;
		}
		
		if($statis['vip_etime']>time() || $statis['vip_etime']==0){
		    if($statis['rating_type']=="2"){
		        $addjobnum=$addpartjobnum=$editjobnum=$editpartjobnum='1';
		    }else{
		        if($statis['job_num']>0){
		            $addjobnum='1';
		        }else{
		            if($this->config['com_integral_online']=='1'){
		                $addjobnum='2';
		            }else{
		                $addjobnum='0';
		            }
		        }
		        if($statis['part_num']>0){
		            $addpartjobnum='1';
		        }else{
		            if($this->config['com_integral_online']=='1'){
		                $addpartjobnum='2';
		            }else{
		                $addpartjobnum='0';
		            }
		        }
		        if($statis['editjob_num']>0){
		            $editjobnum='1';
		        }else{
		            if($this->config['com_integral_online']=='1'){
		                $editjobnum='2';
		            }else{
		                $editjobnum='0';
		            }
		        }
		        if($statis['editpart_num']>0){
		            $editpartjobnum='1';
		        }else{
		            if($this->config['com_integral_online']=='1'){
		                $editpartjobnum='2';
		            }else{
		                $editpartjobnum='0';
		            }
		        }
		    }
		}else {
		    if($this->config['com_integral_online']=='1'){
		        $addjobnum=$addpartjobnum=$editjobnum=$editpartjobnum='2';
		    }else{
		        $addjobnum=$addpartjobnum=$editjobnum=$editpartjobnum='0';
		    }
		}
		$statis['addjobnum']=$addjobnum;
		
		$statis['addpartjobnum']=$addpartjobnum;
		$statis['pay_format']=number_format($statis['pay'],2);
		$statis['integral_format']=number_format($statis['integral']);
		
		$this->yunset("addjobnum",$addjobnum);
		$this->yunset("addpartjobnum",$addpartjobnum);
		$this->yunset("statis",$statis);
		$this->yunset("rating",$rating);
		return $statis;
	}
	function yq_action(){
		$jobnum=$this->obj->DB_select_all('company_job',"`uid`='".$this->uid."' and `edate`>'".time()."' and `sdate`<'".time()."'  and `status`<>1 and `state`=1","id");
		if($jobnum){
			$rows=$this->obj->DB_select_all("company_job","`uid`='".$this->uid."' and `edate`>'".time()."' and `sdate`<'".time()."'  and `status`<>1 and `state`=1","`id`,`name`,`link_type`");
			$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`linkman`,`linktel`,`address`");
			$Info=$this->obj->DB_select_once("resume_expect","`uid`='".$_GET['uid']."'","`id`,`uid`,`name`");
			if($rows['2']){
				$link=$this->obj->DB_select_once("company_job_link","`jobid`='".$rows['id']."'");
				$company['linkman']=$link['link_man'];
				$company['linktel']=$link['link_moblie'];
			}
			$this->yunset("Info",$Info);
			$this->yunset("company",$company);
			$this->yunset("rows",$rows);
		}else{
			$data['msg']="您还没有正在招聘的职位，请先发布职位吧！";
			$data['url']=$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
		}
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('yq');
	}
	function dingdan_action(){
		$this->comguwen();
			if($_POST['price']){
				if($_POST['comvip']){
					$comvip=(int)$_POST['comvip'];
					$ratinginfo =  $this->obj->DB_select_once("company_rating","`id`='".$comvip."'");
					if($ratinginfo['time_start']<time() && $ratinginfo['time_end']>time()){
						$price = $ratinginfo['yh_price'];
					}else{
						$price = $ratinginfo['service_price'];
					}
					$data['type']='1';
				}elseif($_POST['comservice']){
					$id=(int)$_POST['comservice'];
					$detailinfo =  $this->obj->DB_select_once("company_service_detail","`id`='".$id."'");
					$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
					if ($statis){
						$rating=$statis['rating'];
						$discount=$this->obj->DB_select_once("company_rating"," `id`='".$rating."' ");
						if($discount){
							$dis=$discount['service_discount'];
							if ($dis !=0 && $dis !=100){
								$price = $detailinfo['service_price'] * $dis *0.01;
							}else {
								$price = $detailinfo['service_price'];
							}
						}
					}
					$data['type']='5';
				}elseif($_POST['price_int']){
					if($this->config['integral_min_recharge'] && $_POST['price_int']<$this->config['integral_min_recharge']){
						
						$data['msg']="充值不得低于".$this->config['integral_min_recharge'];
						$data['url']=$_SERVER['HTTP_REFERER'];
						$this->yunset("layer",$data);
						$this->waptpl('pay');exit;
					}
					$price = $_POST['price_int']/$this->config['integral_proportion'];
					$data['type']='2';
				}
				$dingdan=mktime().rand(10000,99999);
				$data['order_id']=$dingdan;
				$data['order_price']=$price;
				$data['order_time']=mktime();
				$data['order_state']="1";
				$data['order_remark']=trim($_POST['remark']);
				$data['uid']=$this->uid;
				$data['rating']=$_POST['comvip']?$_POST['comvip']:$_POST['comservice'];
				$data['integral']=$_POST['price_int'];
				$id=$this->obj->insert_into("company_order",$data);
				if($id){
					$this->member_log("下单成功,订单ID".$dingdan);
					$_POST['dingdan']=$dingdan;
					$_POST['dingdanname']=$dingdan;
					$_POST['alimoney']=$price;
					$data['msg']="下单成功，请付款！";
					
					if($_POST['paytype']=='alipay'){ 
						$url=$this->config['sy_weburl'].'/api/wapalipay/alipayto.php?dingdan='.$dingdan.'&dingdanname='.$dingdanname.'&alimoney='.$price;
						header('Location: '.$url);exit();
					}elseif($_POST['paytype']=='wxpay'){
						$url='index.php?c=wxpay&id='.$id;
						header('Location: '.$url);exit();
					}
				}else{
					$data['msg']="提交失败，请重新提交订单！";
					$data['url']=$_SERVER['HTTP_REFERER'];
				}
			}else{
				$data['msg']="参数不正确，请正确填写！";
				$data['url']=$_SERVER['HTTP_REFERER'];
			}
		$this->yunset("layer",$data);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('pay');
	}
	function wxpay_action(){
		$this->comguwen();
		if($_GET['id']){
			$id = (int)$_GET['id'];
			$order = $this->obj->DB_select_once("company_order","`uid`='".$this->uid."' AND `id`='".$id."'");
			if(!empty($order)){				
				require_once(LIB_PATH.'wxOrder.function.php');				
				$jsApiParameters = wxWapOrder(array('body'=>iconv("gbk","utf-8",'充值'),'id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price']));
				if($jsApiParameters){
					$this->yunset('jsApiParameters',$jsApiParameters);
				}else{
					
					$data['msg']="参数不正确，请重新支付！";
					$data['url']='index.php?c=com';
					$this->yunset("layer",$data);
				}
				
			}else{
				$data['msg']="参数不正确，请正确填写！";
				$data['url']=$_SERVER['HTTP_REFERER'];
				$this->yunset("layer",$data);
			}

			$this->yunset('id',(int)$_GET['id']);
			$this->waptpl('wxpay');
		}else{
			$data['msg']="参数不正确，请正确填写！";
			$data['url']=$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
			$backurl=Url('wap',array(),'member');
		    $this->yunset('backurl',$backurl);
			$this->get_user();
			$this->waptpl('pay');
		}
	}
	function look_job_action(){
		$urlarr['c']='look_job';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("look_job","`com_id`='".$this->uid."' and `com_status`='0' order by datetime desc",$pageurl,"10");
		if(is_array($rows))
		{
			foreach($rows as $v)
			{
				$uid[]=$v['uid'];
				$jobid[]=$v['jobid'];
			}
			$cjob=$this->obj->DB_select_all("company_job","`id`in(".@implode(',',$jobid).")","`name`,`id`");
			$resume=$this->obj->DB_select_all("resume","`uid` in (".pylode(",",$uid).")","`uid`,`name`,`edu`,`exp`,`sex`,`def_job` as `eid`");
			$userid_msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' and `uid` in (".pylode(",",$uid).")","uid");
			include(PLUS_PATH."user.cache.php");
			include(PLUS_PATH."job.cache.php");
			include(CONFIG_PATH."db.data.php");
		    unset($arr_data['sex'][3]);
		    $this->yunset("arr_data",$arr_data);
			foreach($resume as $val){
				$eid[]=$val['eid'];
			}
			$expect=$this->obj->DB_select_all("resume_expect","`id` in (".pylode(",",$eid).")","`id`,`uid`,`salary`,job_classid");
			foreach($rows as $key=>$val)
			{
				foreach($expect as $v){
					if($val['uid']==$v['uid']){
            			$rows[$key]['resume_id']=$v['id'];
						$rows[$key]['salary']=$userclass_name[$v['salary']];
						if($v['job_classid']!=""){
							$job_classid=@explode(",",$v['job_classid']);
							$rows[$key]['jobname']=$job_name[$job_classid[0]];
						}
					}
				}
				foreach($resume as $va)
				{
					if($val['uid']==$va['uid'])
					{
						$rows[$key]['sex']=$arr_data['sex'][$va['sex']];
						$rows[$key]['exp']=$userclass_name[$va['exp']];
						$rows[$key]['edu']=$userclass_name[$va['edu']];
						$rows[$key]['name']=$va['name'];
					}
				}
				foreach($userid_msg as $va)
				{
					if($val['uid']==$va['uid'])
					{
						$rows[$key]['userid_msg']=1;
					}
				}
				foreach($cjob as $va)
				{
					if($val['jobid']==$va['id'])
					{
						$rows[$key]['comjob']=$va['name'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("js_def",5);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('look_job');
	}
	function lookresumedel_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_update_all("look_resume","`com_status`='1'","`id`='".(int)$_GET['id']."' and `com_id`='".$this->uid."'");
			if($nid){
				$this->member_log("删除已浏览简历记录（ID:".(int)$_GET['id']."）");
				$this->waplayer_msg('删除成功！');
			}else{
				$this->waplayer_msg('删除失败！');
			}
		}
	}
	function lookjobdel_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_update_all("look_job","`com_status`='1'","`id`='".(int)$_GET['id']."' and `com_id`='".$this->uid."'");
			if($nid){
				$this->member_log("删除已浏览简历记录（ID:".(int)$_GET['id']."）");
				$this->waplayer_msg('删除成功！');
			}else{
				$this->waplayer_msg('删除失败！');
			}
		}
	}

	function look_resume_action(){
		$urlarr['c']='look_resume';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("look_resume","`com_id`='".$this->uid."' and `com_status`='0' order by datetime desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $v){
				$resume_id[]=$v['resume_id'];
				$uid[]=$v['uid'];
			}
			$resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and b.`id` in (".pylode(",",$resume_id).")","a.`name`,a.`sex`,a.`exp`,a.`edu`,a.`birthday`,b.`id`,b.job_classid,b.`salary`");
			$userid_msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' and `uid` in (".pylode(",",$uid).")","uid");
			if(is_array($resume)){
				include(PLUS_PATH."user.cache.php");
				include(PLUS_PATH."job.cache.php");
				include(CONFIG_PATH."db.data.php");
		        unset($arr_data['sex'][3]);
		        $this->yunset("arr_data",$arr_data);
				$age=date("Y",time());
				$time=date("Y",0);
				foreach($rows as $key=>$val){
					foreach($resume as $va){
						if($val['resume_id']==$va['id']){
							$rows[$key]['name']=$va['name'];
							$rows[$key]['salary']=$userclass_name[$va['salary']];
							$rows[$key]['birthday']=$va['birthday'];
							$rows[$key]['sex']=$arr_data['sex'][$va['sex']];
							$rows[$key]['exp']=$userclass_name[$va['exp']];
							$rows[$key]['edu']=$userclass_name[$va['edu']];
							if($va['job_classid']!=""){
								$job_classid=@explode(",",$va['job_classid']);
								$rows[$key]['jobname']=$job_name[$job_classid[0]];
							}
						}
					}
					foreach($userid_msg as $va){
						if($va['uid']&&$val['uid']&&$val['uid']==$va['uid']){
							$rows[$key]['userid_msg']=1;
						}
					}
				}
			}
		}
		$this->yunset("age",$age);
		$this->yunset("time",$time);
		$this->yunset("rows",$rows);
		$this->yunset("js_def",5);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('look_resume');
	}
	function talent_pool_remark_action()
	{
		if($_POST['remark']=="")
		{
			$this->ACT_layer_msg("备注内容不能为空！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$nid=$this->obj->DB_update_all("talent_pool","`remark`='".$_POST['remark']."'","`id`='".(int)$_POST['id']."' and `cuid`='".$this->uid."'");
			if($nid)
			{
				$this->member_log("备注人才".$_POST['r_name']);
				
				$data['msg']="备注成功！";
				$data['url']=$this->config['sy_weburl'].'/wap/member/index.php?c=talent_pool';
			}else{
				
				$data['msg']="备注失败！";
				$data['url']=$this->config['sy_weburl'].'/wap/member/index.php?c=talent_pool';
			}
		}
		$this->yunset("layer",$data);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('talent_pool');
	}
	function talentpooldel_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_delete_all("talent_pool","`id`='".(int)$_GET['id']."' and `cuid`='".$this->uid."'");
			if($nid){
				$this->member_log("删除收藏简历人才（ID:".(int)$_GET['id']."）");
				$this->waplayer_msg('删除成功！');
			}else{
				$this->waplayer_msg('删除失败！');
			}
		}
	}
	function talent_pool_action(){
		$where="`cuid`='".$this->uid."'";
		$urlarr['c']='talent_pool';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("talent_pool",$where."  order by id desc",$pageurl,"10");
		if(is_array($rows)) {
			foreach($rows as $v) {
				$uid[]=$v['uid'];
				$eid[]=$v['eid'];
			}
			$resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and a.`r_status`<>'2' and a.uid in (".pylode(',',$uid).")","a.`name`,a.`uid`,a.`sex`,a.`birthday`,b.`edu`,a.`exp`,b.`job_classid`,b.id as eid,b.salary");
           $user=$this->obj->DB_select_all("resume","`birthday`limit 2");
		  
			$userid_msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' and `uid` in (".pylode(",",$uid).")","uid");
			if(is_array($resume)) {
				include(PLUS_PATH."user.cache.php");
				include(PLUS_PATH."job.cache.php");
				include(CONFIG_PATH."db.data.php");
		        unset($arr_data['sex'][3]);
		        $this->yunset("arr_data",$arr_data);	
				 $age=date("Y",time());
				 $time=date("Y",0);
				foreach($rows as $key=>$val) {
					foreach($resume as $va) {
						if($val['uid']==$va['uid'])
						{ 
                            $rows[$key]['birthday']=$va['birthday'];
							$rows[$key]['eid']=$va['eid'];
							$rows[$key]['name']=$va['name'];
							$rows[$key]['sex']=$arr_data['sex'][$va['sex']];
							$rows[$key]['exp']=$userclass_name[$va['exp']];
							$rows[$key]['edu']=$userclass_name[$va['edu']];
							if($va['job_classid']!="")
							{
								$job_classid=@explode(",",$va['job_classid']);
								$rows[$key]['jobname']=$job_name[$job_classid[0]];
							}
						}
					}
					foreach($user as $value){
						if($val['uid']==$value['uid']){
							$rows[$key]['age']=$user['age'];
						}
					}
					foreach($userid_msg as $va)
					{
						if($val['uid']==$va['uid'])
						{
							$rows[$key]['userid_msg']=1;
						}
					}
				}
			}
		}
		$this->yunset("age",$age);
		$this->yunset("time",$time);
		$this->yunset("rows",$rows);
		$report=$this->config['com_report'];
		$this->yunset("report",$report);
		$this->company_satic();
		$this->yunset("js_def",5);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('talent_pool');
	}
	function atn_teacher_action(){
		if($_GET['del']){
			$id=$this->obj->DB_delete_all("atn","`id`='".$_GET['del']."' AND `uid`='".$this->uid."'");
			$this->obj->DB_update_all("px_teacher","`ant_num`=`ant_num`-1","`id`='".$_GET['tid']."'");
			if($id){
				$this->waplayer_msg('取消成功！');
			}else{
				$this->waplayer_msg('取消失败！');
			}
		}
		$urlarr=array("c"=>"atn_teacher","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("atn","`uid`='".$this->uid."' and `tid`<>'' and `sc_usertype`='4' order by `id` desc",$pageurl,"20");
		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$tids[]=$val['tid'];
			}
			$tids=array_unique($tids);
			$teacher=$this->obj->DB_select_all("px_teacher","`id` in(".pylode(',',$tids).") and `status`=1 and `r_status`<>2","`name`,`id`,`pic`");
			$where=1;
			foreach ($tids as $k=>$v){
			    if($k==0){
			        $where1=" and (FIND_IN_SET('".$v."',`teachid`)";
			    }else{
			        $where1.=" or FIND_IN_SET('".$v."',`teachid`)";
			    }
			}
			$where1.=")";
			$subject=$this->obj->DB_select_all("px_subject",$where.$where1." and `status`=1 and `r_status`<>2","`uid`,`name`,`id`,`teachid`");
			foreach($subject as $v){
				$url=Url('wap',array("c"=>"train",'a'=>'subshow',"id"=>$v['id']));
				$teachids=explode(',', $v['teachid']);
				if (!empty($teachids)){
				    if (count($teachids)>1){
				       foreach ($teachids as $val){
				           $sname[$val][]="<a href='".$url."'>".$v['name']."</a>";
				       }
				    }else{
				        $sname[$v['teachid']][]="<a href='".$url."'>".$v['name']."</a>";
				    }
				}
			}
			foreach($rows as $key=>$val){
				foreach($teacher as $v){
					if($val['tid']==$v['id']){
						$rows[$key]['teacher']=$v['name'];
						if($v['pic']){
							$rows[$key]['pic']=$v['pic'];
						}else{
							$rows[$key]['pic']=$this->config['sy_pxteacher_icon'];
						}
					}
				}
				foreach($sname as $k=>$v){
					if($val['tid']==$k){
						$rows[$key]['snum']=count($v);
						$i=0;
						foreach($v as $value){
							if($i<2){
								$slist[$key][]=$value;
							}
							$i++;
						}
						$rows[$key]['sname']=@implode(",",$slist[$key]);
					}
				}
			}
		}
		$this->yunset("js_def",7);
		$this->yunset("rows", $rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
 		$this->waptpl('atn_teacher');
	}
	function fav_subject_action(){
		$urlarr=array("c"=>"fav_subject","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("px_subject_collect","`uid`='".$this->uid."' order by id desc",$pageurl,"10");

		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$sid[]=$val['sid'];
				$s_uid[]=$val['s_uid'];
			}
			$train=$this->obj->DB_select_all("px_train","`uid` in(".pylode(',',$s_uid).")","`uid`,`name`");
			$subject=$this->obj->DB_select_all("px_subject","`id` in(".pylode(',',$sid).")","`id`,`name`,`address`,`pic`");
			foreach($rows as $key=>$val){
				foreach($subject as $v){
					if($val['sid']==$v['id']){
						$rows[$key]['name']=$v['name'];
						$rows[$key]['address']=$v['address'];
						if($v['pic']){
							$rows[$key]['pic']=$v['pic'];
						}else{
							$rows[$key]['pic']=$this->config['sy_pxsubject_icon'];
						}
					}
				}
				foreach($train as $v){
					if($val['s_uid']==$v['uid']){
						$rows[$key]['train_name']=$v['name'];
					}
				}

			}
		}
		$this->yunset("js_def",7);
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('fav_subject');
	}
	
	function fav_subjectdel_action(){
	    if($_GET['id']){
	        $nid=$this->obj->DB_delete_all("px_subject_collect","`id`='".(int)$_GET['id']."'"," ");
	        if($nid){
	            $this->member_log("删除已收藏的课程（ID:".(int)$_GET['id']."）");
	            $this->waplayer_msg('删除成功！');
	        }else{
	            $this->waplayer_msg('删除失败！');
	        }
	    }
	}
	
		function baoming_subject_action(){
		if($_GET['del']){
			$del=(int)$_GET['del'];
			$nid=$this->obj->DB_delete_all("px_baoming","`id`='".$del."' and `uid`='".$this->uid."'");
			$this->obj->DB_delete_all("company_order","`sid`='".$del."' and `uid`='".$this->uid."'");
			if($nid){
				$this->waplayer_msg('取消成功！');
			}else{
				$this->waplayer_msg('取消失败！');
			}
		}
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$urlarr=array("c"=>"baoming_subject","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("px_baoming","`uid`='".$this->uid."' order by id desc",$pageurl,"10");

		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$sid[]=$val['sid'];
				$s_uid[]=$val['s_uid'];
				$ids[]=$val['id'];
			}
			$subject=$this->obj->DB_select_all("px_subject","`id` in(".pylode(',',$sid).")","`id`,`name`,`pic`,`price`,`isprice`");
			$train=$this->obj->DB_select_all("px_train","`uid` in(".pylode(',',$s_uid).")","`uid`,`name`");
			$order=$this->obj->DB_select_all("company_order","`sid` in(".pylode(',',$ids).") and `type`=6","`id`,`sid`,`order_state`");
			foreach($rows as $key=>$val){
				foreach($subject as $v){
					if($val['sid']==$v['id']){
						$rows[$key]['name']=$v['name'];
						$rows[$key]['price']=$v['price'];
						$rows[$key]['isprice']=$v['isprice'];
						if($v['pic']){
							$rows[$key]['pic']=$v['pic'];
						}else{
							$rows[$key]['pic']=$this->config['sy_pxsubject_icon'];
						}
					}
				}
				foreach($train as $v){
					if($val['s_uid']==$v['uid']){
						$rows[$key]['train_name']=$v['name'];
					}
				}
				foreach($order as $v){
					if($val['id']==$v['sid']){
						$rows[$key]['order_state']=$v['order_state'];
						$rows[$key]['oid']=$v['id'];
					}
				}
			}
		}
		$this->yunset("js_def",7);
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('baoming_subject');
	
		}
	function invite_action(){
		$urlarr['c']='invite';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("userid_msg"," `fid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows) && !empty($rows)){
			foreach($rows as $v){
				$uid[]=$v['uid'];
			}
			$resume=$this->obj->DB_select_all("resume","`uid` in (".pylode(",",$uid).") and `r_status`<>'2'","`uid`,`name`,`exp`,`sex`,`edu`,`def_job` as `eid`");
			foreach($resume as $val){
				$eid[]=$val['eid'];
			}
			$expect=$this->obj->DB_select_all("resume_expect","`id` in (".pylode(",",$eid).")","`salary`,`id`,`job_classid`");
			if(is_array($resume)){
				$user=array();
				include(PLUS_PATH."user.cache.php");
				include(PLUS_PATH."job.cache.php");
				include(CONFIG_PATH."db.data.php");
		        unset($arr_data['sex'][3]);
		        $this->yunset("arr_data",$arr_data);
				foreach($resume as $val){
					foreach($expect as $v){
						if($v['id']==$val['eid']){
							$user[$val['uid']]['salary']=$userclass_name[$v['salary']];
							if($v['job_classid']!=""){
								$job_classid=@explode(",",$v['job_classid']);
								$user[$val['uid']]['jobname']=$job_name[$job_classid[0]];
							}
						}
					}
					
					$user[$val['uid']]['eid']=$val['eid'];
					$user[$val['uid']]['name']=mb_substr($val['name'],0,8);
					$user[$val['uid']]['exp']=$userclass_name[$val['exp']];
					$user[$val['uid']]['edu']=$userclass_name[$val['edu']];
					$user[$val['uid']]['sex']=$arr_data['sex'][$val['sex']];
				}
			}

			$this->yunset("user",$user);
		}
		$this->yunset("rows",$rows);
		$this->yunset("js_def",5);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('invite');
	}
	function invite_del_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_delete_all("userid_msg","`id`='".(int)$_GET['id']."' and `fid`='".$this->uid."'");
			if($nid){
				$this->member_log("删除已邀请面试的人才",4,3);
				$this->waplayer_msg('删除成功！');
			}else{
				$this->waplayer_msg('删除失败！');
			}
		}
	}
	function part_action(){
		$this->rightinfo();
		$urlarr=array("c"=>"part","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("partjob","`uid`='".$this->uid."'",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$rows[$k]['applynum']=$this->obj->DB_select_num("part_apply","`jobid`='".$v['id']."'");
			}
		}
		$this->company_satic();
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('part');
	}
	function partadd_action(){
	    include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		if($_GET['id']){
			$row=$this->obj->DB_select_once("partjob","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."'");
			$row['worktime']=explode(',', $row['worktime']);
			$arr_data1=$arr_data['sex'][$row['sex']];		
		    $this->yunset("arr_data1",$arr_data1);
			$this->yunset("row",$row);
		}
		if($_POST['submit']){ 
			if($_POST['worktime']){
				$_POST['worktime']=@implode(",",$_POST['worktime']);
			} 
			$_POST['content']=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));			
			$_POST['sdate']=strtotime($_POST['sdate']);
			
			if($_POST['timetype']||$_POST['edate']==''){
				$_POST['edate']="";
				$_POST['deadline']="";
			}else{ 
				$_POST['edate']=strtotime($_POST['edate']);
				$_POST['deadline']=strtotime($_POST['deadline']);
			}
			$_POST['lastupdate'] = time();
			$_POST['state'] = $this->config['com_partjob_status'];			
			$id=(int)$_POST['id'];
			unset($_POST['submit']);
			unset($_POST['id']);
			if(!$id){ 
				$_POST['addtime'] = time();
				$_POST['uid'] = $this->uid;
				$data['msg']=$this->get_com(7);
				if($data['msg']==''){
					$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
					$_POST['com_name']=$company['name'];
					$nid=$this->obj->insert_into("partjob",$_POST);
					$name="添加兼职职位";
					if($nid){
						$state_content = "新发布了兼职职位 <a href=\"".$this->config['sy_weburl']."/part/index.php?c=show&id=$nid\" target=\"_blank\">".$_POST['name']."</a>。";
						$this->addstate($state_content,2);
						$nid?$data['msg']=$name."成功！":$data['msg']=$name."失败！";
					}
				}
			}else{
				$job=$this->obj->DB_select_once("partjob","`id`='".$id."' and `uid`='".$this->uid."'","state");
				if($job['state']=="1" || $job['state']=="2"){
					$data['msg']=$this->get_com(8);
				}
				if($data['msg']==''){
					$where['id']=$id;
					$where['uid']=$this->uid;
					$nid=$this->obj->update_once("partjob",$_POST,$where);
					$name="更新兼职职位";
					$nid?$data['msg']=$name."成功！":$data['msg']=$name."失败！";
				}
			}

			$data['url']='index.php?c=part';
		}
		$this->rightinfo();
		$this->yunset("layer",$data);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','part')));
		$morning=array('0101','0201','0301','0401','0501','0601','0701');
		$noon=array('0102','0202','0302','0402','0502','0602','0702');
		$afternoon=array('0103','0203','0303','0403','0503','0603','0703');
		$this->yunset(array('morning'=>$morning,'noon'=>$noon,'afternoon'=>$afternoon));
		$this->yunset("today",date("Y-m-d"));
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('partadd');
	}
	function partdel_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_delete_all("partjob","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			if($nid){
				$this->obj->DB_delete_all("part_collect","`jobid`='".(int)$_GET['id']."'","");
				$this->obj->DB_delete_all("part_apply","`jobid`='".(int)$_GET['id']."'","");
				$this->member_log("删除兼职");
				$this->waplayer_msg('删除成功！');
			}else{
				$this->waplayer_msg('删除失败！');
			}
		}
	}
	function photo_action(){

		if($_POST['submit']){
			preg_match('/^(data:\s*image\/(\w+);base64,)/', $_POST['uimage'], $result);
			$uimage=str_replace($result[1], '', str_replace('#','+',$_POST['uimage']));
			
			if(in_array(strtolower($result[2]),array('jpg','png','gif','jpeg'))){
				$new_file = time().rand(1000,9999).".".$result[2];
			}else{
				$new_file = time().rand(1000,9999).".jpg";
			}
			
			$im = imagecreatefromstring(base64_decode($uimage));
			if ($im === false) {
				echo 2;die;
			}
			if (!file_exists(DATA_PATH."upload/company/".date('Ymd')."/")){
				mkdir(DATA_PATH."upload/company/".date('Ymd')."/");
				chmod(DATA_PATH."upload/company/".date('Ymd')."/",0777);

			}
			$re=file_put_contents(DATA_PATH."upload/company/".date('Ymd')."/".$new_file, base64_decode($uimage));
			chmod(DATA_PATH."upload/company/".date('Ymd')."/".$new_file,0777);
			if($re){
				$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`logo`");
				unlink_pic(APP_PATH.$company['logo']);
				$photo="./data/upload/company/".date('Ymd')."/".$new_file;
				$this->obj->DB_update_all("company","`logo`='".$photo."'","`uid`='".$this->uid."'");
				$this->obj->DB_update_all("company_job","`com_logo`='".$photo."'","`uid`='".$this->uid."'");
				echo 1;die;
			}else{
				unlink_pic(APP_PATH."data/upload/company/".date('Ymd')."/".$new_file);
				echo 2;die;
			}
		}else{
			$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`logo`");
			if($company['logo']==""){
				$company['logo']='/'.$this->config['sy_unit_icon'];
			}
			$this->yunset("company",$company);
			$backurl=Url('wap',array(),'member');
		    $this->yunset('backurl',$backurl);
			$this->comguwen();
			$this->get_user();
			$this->waptpl('photo');
		}
	}
	
	function comcert_action(){
		if($_POST['submit']){
			$comname=$this->obj->DB_select_num('company',"`uid`<>'".$this->uid."' and `name`='".$_POST['name']."'","`uid`");
			$row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='3'");
			if($_POST['name']==""){
				$data['msg']='企业全称不能为空！';
			}elseif($comname){
				$data['msg']='企业全称已存在！';
			}elseif(is_uploaded_file($_FILES['pic']['tmp_name'])==false&&!$row['check']){
				$data['msg']='请上传营业执照！';
			}else{
				if(is_uploaded_file($_FILES['pic']['tmp_name'])){
					$upload=$this->upload_pic(APP_PATH."/data/upload/cert/",false);
					$pic=$upload->picture($_FILES['pic']);
					$this->picmsg($pic,$_SERVER['HTTP_REFERER']);
					$photo=str_replace(APP_PATH."/data/upload/cert/","/data/upload/cert/",$pic);
					if($row['check']){
						unlink_pic("APP_PATH".$row['check']);
					}
				}else{
					$photo=$row['check'];
				}
			}
			if($this->config['com_cert_status']=="1"){
				$sql['status']=0;
			}else{
				$sql['status']=1;
			}
			$this->obj->DB_update_all("company","`name`='".$_POST['name']."',`yyzz_status`='".$sql['status']."'","`uid`='".$this->uid."'");
			$sql['step']=1;
			$sql['check']=$photo;
			$sql['check2']="0";
			$sql['ctime']=mktime();
			$company=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."'  and type='3'","`check`");
			if(is_array($company)){
				$where['uid']=$this->uid;
				$where['type']='3';
				$this->obj->update_once("company_cert",$sql,$where);
				$this->obj->member_log("更新营业执照");
			}else{
				$sql['uid']=$this->uid;
				$sql['did']=$this->userdid;
				$sql['type']=3;
				$this->obj->insert_into("company_cert",$sql);
				$this->obj->member_log("上传营业执照");
			}
			$data['msg']='上传营业执照成功！';
			$data['url']='index.php?c=comcert';
		}
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`name`");
		$cert=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and `type`='3'","`check`");
		$this->yunset("company",$company);
		$this->yunset("cert",$cert);
		$this->yunset("layer",$data);
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset("backurl",$backurl);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('comcert');
	}
	
	function binding_action(){
		if($_POST['moblie']){
			$row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and `check`='".$_POST['moblie']."'");
			if(!empty($row)){
				session_start();
				if($row['check2']!=$_POST['code']){
					echo 3;die;
				}else if(!$_POST['authcode']){
					echo 4;die;
				}elseif(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
					echo 5;die;
				}else{
					
					$this->obj->DB_update_all("resume","`moblie_status`='0'","`telphone`='".$row['check']."'");
					$this->obj->DB_update_all("company","`moblie_status`='0'","`linktel`='".$row['check']."'");
					$this->obj->DB_update_all("px_train","`moblie_status`='0'","`linktel`='".$row['check']."'");
					
					$this->obj->DB_update_all("member","`moblie`='".$row['check']."'","`uid`='".$this->uid."'");
					$this->obj->DB_update_all("company","`linktel`='".$row['check']."',`moblie_status`='1'","`uid`='".$this->uid."'");
					$this->obj->DB_update_all("company_cert","`status`='1'","`uid`='".$this->uid."' and `check2`='".$_POST['code']."'");
					$this->obj->member_log("手机绑定");//会员日志
					$pay=$this->obj->DB_select_once("company_pay","`pay_remark`='手机绑定' and `com_id`='".$this->uid."'");
					if(empty($pay)){
						$this->get_integral_action($this->uid,"integral_mobliecert","手机绑定");
					}
					echo 1;die;
				}
			}else{
				echo 2;die;
			}
		}
		if($_GET['type']){
			if($_GET['type']=="moblie")
			{
				$this->obj->DB_update_all("company","`moblie_status`='0'","`uid`='".$this->uid."'");
			}
			if($_GET['type']=="email")
			{
				$this->obj->DB_update_all("company","`email_status`='0'","`uid`='".$this->uid."'");
			}
			if($_GET['type']=="qqid")
			{
				$this->obj->DB_update_all("member","`qqid`=''","`uid`='".$this->uid."'");
			}
			if($_GET['type']=="sinaid")
			{
				$this->obj->DB_update_all("member","`sinaid`=''","`uid`='".$this->uid."'");
			}
			$this->waplayer_msg('解除绑定成功！');
		}
		$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		$this->yunset("member",$member);
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		$this->yunset("company",$company);
		if(($member['qqid']!=""||$member['wxid']!=""||$member['unionid']!=""||$member['sinaid']!="") && $member['restname']=="0"){
			$this->yunset("setname",1);
		}
		if($company['yyzz_status']!=1){
			$cert=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and `type`='3'","`id`,`status`,`statusbody`");
			$this->yunset("cert",$cert);
		}
		
		$this->rightinfo();
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('binding');
	}
	function bindingbox_action(){
		$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		$this->yunset("member",$member);
		$this->rightinfo();
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('bindingbox');
	}
	function setname_action(){
		if($_POST['username']){
			$user=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
			if(($user['qqid']==""&&$user['wxid']==""&&$user['unionid']==""&&$user['sinaid']=="") || $user['restname']=="1"){
				echo "您无权修改账户！";die;
			}
			$username=yun_iconv("utf-8","gbk",$_POST['username']);
			$num = $this->obj->DB_select_num("member","`username`='".$username."'");
			if($num>0){
				echo "用户名已存在！";die;
			}
			if($this->config['sy_regname']!=""){
				$regname=@explode(",",$this->config['sy_regname']);
				if(in_array($username,$regname)){
					echo "该用户名禁止使用！";die;
				}
			}
			$salt = substr(uniqid(rand()), -6);
		    $password = md5(md5($_POST['password']).$salt);
		    $data['password']=$password;
		    $data['salt']=$salt;
		    $data['username']=$username;
		    $data['restname']=1;
			$this->obj->update_once('member',$data,array('uid'=>$this->uid));
			$this->unset_cookie();
			$this->obj->member_log("修改账户",8);
			echo 1;die;
		}
		$user=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		if(($user['qqid']==""&&$user['wxid']==""&&$user['unionid']==""&&$user['sinaid']=="") || $user['restname']=="1"){
			$data['msg']="您无权修改账户！";
			$data['url']='index.php?c=binding';
			$this->yunset("layer",$data);
		}
		$this->rightinfo();
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('setname');
	}
	
	function reward_list_action(){
		$urlarr['c']='reward_list';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("change","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $key=>$val){
				$gid[]=$val['gid'];
			}
			$M=$this->MODEL('redeem');
			$gift=$M->GetReward(array('`id` in('.pylode(',', $gid).')'),array('field'=>'id,pic'));
			foreach($rows as $k=>$val){
				foreach ($gift as $v){
					if($val['gid']==$v['id']){
						$rows[$k]['pic']=$v['pic'];
					}
				}
			}
		}
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'","rating_name,integral");
		$statis[integral]=number_format($statis[integral]);
		$this->yunset("statis",$statis);
		$this->yunset('rows',$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->comguwen();
		$this->get_user();
		$this->waptpl('reward_list');
	}
	
	function delreward_action(){
		if($this->usertype!='2' || $this->uid==''){
			$this->waplayer_msg('登录超时！');
		}else{
			$rows=$this->obj->DB_select_once("change","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' ");
			if($rows['id']){
				$this->obj->DB_update_all("reward","`num`=`num`-".$rows['num'].",`stock`=`stock`+".$rows['num']."","`id`='".$rows['gid']."'");
				$this->company_invtal($this->uid,$rows['integral'],true,"取消兑换",true,2,'integral',24);
				$this->obj->DB_delete_all("change","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' ");
			}
			$this->obj->member_log("取消兑换");
			$this->waplayer_msg('取消成功！');
		}
	}
	function paylog_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$urlarr=array("c"=>"paylog","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$where="`uid`='".$this->uid."' order by order_time desc";
		$rows=$this->get_page("company_order",$where,$pageurl,"10");
		$this->yunset("rows",$rows);
		$this->yunset('backurl','index.php');
		$this->comguwen();
		$this->get_user();
		$this->waptpl('paylog');
	}
	
	function delpaylog_action(){
		if($this->usertype!='2' || $this->uid==''){
			$this->waplayer_msg('登录超时！');
		}else{
			$oid=$this->obj->DB_select_once("company_order","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' and `order_state`='1'");
			if(empty($oid)){
				$this->waplayer_msg('订单不存在！');
			}else{
				$this->obj->DB_delete_all("company_order","`id`='".$oid['id']."' and `uid`='".$this->uid."'");
				$this->waplayer_msg('取消成功！');
			}
		}
	}
	
	function consume_action(){
	    include(CONFIG_PATH."db.data.php");
	    $this->yunset("arr_data",$arr_data);
	    $urlarr=array("c"=>"consume","page"=>"{{page}}");
	    $pageurl=Url('wap',$urlarr,'member');
	    $where="`com_id`='".$this->uid."'";
	    
	    $where.="  order by pay_time desc";
	    $rows = $this->get_page("company_pay",$where,$pageurl,"10");
	    if(is_array($rows)){
	        foreach($rows as $k=>$v){
	            $rows[$k]['pay_time']=date("Y-m-d H:i:s",$v['pay_time']);
	            $rows[$k]['order_price']=str_replace(".00","",$rows[$k]['order_price']);
	        }
	    }
	    if ($_GET['type']==1){
	        $this->yunset('backurl',Url('wap',array('c'=>'com'),'member'));
	    }else{
	        $this->yunset('backurl','index.php');
	    }
	    $this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
	    $this->comguwen();
		$this->get_user();
	    $this->waptpl('consume');
	}
	
	function down_action(){
	    $where="`comid`='".$this->uid."'";
	    $urlarr['c']='down';
	    $urlarr["page"]="{{page}}";
	    $pageurl=Url('wap',$urlarr,'member');
	    $rows=$this->get_page("down_resume","$where order by id desc",$pageurl,"10");
	    if(is_array($rows)&&$rows){
	        if(empty($resume)){
	            foreach($rows as $v){
	                $uid[]=$v['uid'];
	            }
	            $resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and a.`r_status`<>'2' and a.uid in (".@implode(",",$uid).")","a.`name`,a.`uid`,a.`exp`,a.`sex`,a.`edu`,b.`minsalary`,b.`maxsalary`,b.`job_classid`,b.`height_status`");
	        }
	        $userid_msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' and `uid` in (".pylode(",",$uid).")","uid");
	        if(is_array($resume)){
	            include(PLUS_PATH."user.cache.php");
	            include(PLUS_PATH."job.cache.php");
				include(CONFIG_PATH."db.data.php");
		        unset($arr_data['sex'][3]);
		        $this->yunset("arr_data",$arr_data);
	            foreach($rows as $key=>$val){
	                foreach($resume as $va){
	                    if($val['uid']==$va['uid']){
	                        $rows[$key]['name']=$va['name'];
							$rows[$key]['sex']=$arr_data['sex'][$va['sex']];	
	                        $rows[$key]['exp']=$userclass_name[$va['exp']];
	                        $rows[$key]['edu']=$userclass_name[$va['edu']];
	                        $rows[$key]['minsalary']=$va['minsalary'];
	                        $rows[$key]['maxsalary']=$va['maxsalary'];
	                        $rows[$key]['height_status']=$va['height_status'];
	                        if($va['job_classid']!=""){
	                            $job_classid=@explode(",",$va['job_classid']);
	                            $rows[$key]['jobname']=$job_name[$job_classid[0]];
	                        }
	                    }
	                }
	                foreach($userid_msg as $va){
	                    if($val['uid']==$va['uid']){
	                        $rows[$key]['userid_msg']=1;
	                    }
	                }
	            }
	        }
	    }
	    $this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
	    $this->comguwen();
		$this->get_user();
	    $this->waptpl('down');
	}
	
	function downdel_action(){
	    if($_GET['id']){
	        $nid=$this->obj->DB_delete_all("down_resume","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."'"," ");
	        if($nid){
	            $this->member_log("删除已下载简历记录（ID:".(int)$_GET['id']."）");
	            $this->waplayer_msg('删除成功！');
	        }else{
	            $this->waplayer_msg('删除失败！');
	        }
	    }
	}
}
?>