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
class ajax_controller extends common{

	function order_type_action(){
		if($this->uid  && $this->username && $this->usertype==2){
			$nid=$this->obj->DB_update_all("company_order","`order_type`='".(int)$_POST['paytype']."'","`order_id`='".(int)$_POST['order']."'");
			if($nid){
				$this->obj->member_log("修改订单付款类型");
			}
			echo $nid?1:2;
		}
	}

	function delupload_action(){
		if(!$this->uid || !$this->username || $this->usertype!=2){
			echo 0;die;
		}else{
			$dir=$_POST[str][0];
			$isuser = $this->obj->DB_select_once("company_show","`picurl`='$dir'");
			if($isuser['uid']==$this->uid){
				echo unlink_pic(".".$dir);
			}else{
				echo 0;die;
			}
		}
	}
	function emailcert_action(){
		session_start();
		if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
			echo 4;die;
		}
		if(!$this->uid || !$this->username){
			echo 0;die;
		}else{
			if($this->config['sy_email_set']!="1"){
				echo 3;die;
			}
			if($this->config['sy_email_cert']=="2"){
				echo 2;die;
			}
			$email=$_POST['email'];
			$randstr=rand(10000000,99999999);
			$sql['status']=0;
			$sql['step']=1;
			$sql['check']=$email;
			$sql['check2']=$randstr;
			$sql['ctime']=mktime();
			$row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='1'");
			if(is_array($row)){
				$where['uid']=$this->uid;
				$where['type']='1';
				$this->obj->update_once("company_cert",$sql,$where);
				$this->obj->member_log("更新邮箱认证");
			}else{
				$sql['uid']=$this->uid;
				$sql['did']=$this->userdid;
				$sql['type']=1;
				$this->obj->insert_into("company_cert",$sql);
				$this->obj->member_log("添加邮箱认证");
			}
		
			$base=base64_encode($this->uid."|".$randstr."|".$this->config['coding']);
			$fdata=$this->forsend(array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$data['uid']=$this->uid;
			$data['name']=$fdata['name'];
 			$data['type']="cert";
			$data['email']=$email;
			$url=Url("qqconnect",array('c'=>'cert','id'=>$base),"1");
			$data['url']="<a href='".$url."'>点击认证</a> 如果您不能在邮箱中直接打开，请复制该链接到浏览器地址栏中直接打开：".$url;
			$data['date']=date("Y-m-d");
			$this->send_msg_email($data);
			echo "1";die;
		}
	}
	
    function mobliecert_action(){
		if(!$this->config["sy_msguser"] || !$this->config["sy_msgpw"] || !$this->config["sy_msgkey"]||$this->config['sy_msg_isopen']!='1'){
			echo 4;die;
		}
		if(!$this->uid || !$this->username){
			echo 0;die;
		}else{
			$shell=$this->GET_user_shell($this->uid,$_COOKIE['shell']);
			if(!is_array($shell)){echo 5;die;}
			$moblie=$_POST['str'];
			$randstr=rand(100000,999999);
			
			if($this->config['sy_msg_cert']=="2"){
				echo 3;die;
			}else{
				$num=$this->obj->DB_select_num("moblie_msg","`moblie`='".$moblie."' and `ctime`>'".strtotime(date("Y-m-d"))."' ");
				if($num>=$this->config['moblie_msgnum']){
					echo 1;die;
				}
				$ip=fun_ip_get();
				$ipnum=$this->obj->DB_select_num("moblie_msg","`ip`='".$ip."' and `ctime`>'".strtotime(date("Y-m-d"))."'");
				if($ipnum>=$this->config['ip_msgnum']){
					echo 2;die;
				}
				$fdata=$this->forsend(array('uid'=>$this->uid,'usertype'=>$this->usertype));
				$data['uid']=$this->uid;
				$data['name']=$fdata['name'];
				$data['type']="cert";
				$data['moblie']=$moblie;
				$data['code']=$randstr;
				$data['date']=date("Y-m-d");
				$status=$this->send_msg_email($data);
				if($status=="发送成功!"){
					setcookie("moblie_code",$randstr,time()+120, "/");
					$sql['status']=0;
					$sql['step']=1;
					$sql['check']=$moblie;
					$sql['check2']=$randstr;
					$sql['ctime']=mktime();
					$row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='2'");
					if(is_array($row)){
						$where['uid']=$this->uid;
						$where['type']='2';
						$this->obj->update_once("company_cert",$sql,$where);
						$this->obj->member_log("更新手机认证");
					}else{
						$sql['uid']=$this->uid;
						$sql['did']=$this->userdid;
						$sql['type']=2;
						$this->obj->insert_into("company_cert",$sql);
						$this->obj->member_log("添加手机认证");
					}
				}
				echo $status;die;
			}
		}
	}
    function getzphcom_action(){
		if(!$_GET['jobid']){
			$arr['status']=0;
			$arr['content']=iconv("gbk","utf-8","您还没有职位，<a href='".Url("login",array(),"1")."'>请先登录</a>");
		}else{
			$_GET['jobid'] = pylode(',',@explode(',',$_GET['jobid']));
			$row=$this->obj->DB_select_all("company_job","`id` in (".$_GET['jobid'].") and `uid`='".$this->uid."' and `r_status`<>'2' and `status`<>'1'","`name`");
			$space=$this->obj->DB_select_all("zhaopinhui_space");
			$zhaopinhui=$this->obj->DB_select_once("zhaopinhui","`id`='".intval($_GET['zid'])."'","`title`,`address`,`starttime`,`endtime`");
			$com=$this->obj->DB_select_once("zhaopinhui_com","`zid`='".intval($_GET['zid'])."' and `uid`='".$this->uid."'");
			foreach($row as $v){
				$data[]=$v['name'];
			}
			$spaces=array();
			foreach($space as $val){
				$spaces[$val['id']]=$val['name'];
			}
			$cname=@implode('、',$data);
			$arr['status']=1;
			$arr['content']=iconv("gbk","utf-8",$cname);
			$arr['title']=iconv("gbk","utf-8",$zhaopinhui['title']);
			$arr['address']=iconv("gbk","utf-8",$zhaopinhui['address']);
			$arr['starttime']=iconv("gbk","utf-8",$zhaopinhui['starttime']);
			$arr['endtime']=iconv("gbk","utf-8",$zhaopinhui['endtime']);
			if($spaces[$com['sid']]){
				$arr['sid']=iconv("gbk","utf-8",$spaces[$com['sid']]);
			}else{
				$arr['sid']=iconv("gbk","utf-8",'无');
			}
			$arr['bid']=iconv("gbk","utf-8",$spaces[$com['bid']]);
			$arr['cid']=iconv("gbk","utf-8",$spaces[$com['cid']]);
		}
		echo json_encode($arr);
	}
	function Position_job_action(){
		if($_POST['idk']){
			$num=$_POST['idk'];
		}
		if($_POST['ids']){
			$timenews=$_POST['ids'];
		}
		
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");
		if($statis['vip_etime']>time() || $statis['vip_etime']=="0"){
			if($statis['rating_type']==1){
				if($statis['breakjob_num']>=$num){

					$value="`breakjob_num`='".($statis['breakjob_num']-$num)."'";
					$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
				}else{
					if($this->config['com_integral_online']=="1"){
						$integral=$this->config['integral_jobefresh']*($num-$statis['breakjob_num']);
						if($statis['integral']<$integral){
							echo "会员刷新职位数、".$this->config['integral_pricename']."均不足！";die;
						}else{
							$value="`breakjob_num`='0',`integral`=`integral`-$integral";
							$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
							$this->insert_company_pay($integral,2,$this->uid,'批量刷新职位',1,8);
						}
					}else{
						echo "会员刷新职位数不足！";die;
					}
				}
			}
		}else{
			if($this->config['com_integral_online']=="1"){
				$integral=$this->config['integral_jobefresh']*($num-$statis['breakjob_num']);
				if($statis['integral']<$integral){
					echo "会员刷新职位数、".$this->config['integral_pricename']."均不足！";die;
				}else{
					$value="`breakjob_num`='0',`integral`=`integral`-$integral";
					$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
					$this->insert_company_pay($integral,2,$this->uid,'批量刷新职位',1,8);
				}
			}else{
				echo "会员刷新职位数不足！";die;
			}
		}
		if($_POST['ids']!=""){
			$nid=$this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`id` in (".$timenews.") and `uid`='".$this->uid."'");
		}else{
			$nid=$this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`status`='1' and `uid`='".$this->uid."'");
		}
		$this->obj->DB_update_all("company","`jobtime`='".time()."'","`uid`='".$this->uid."'");
		if($nid){
			$this->obj->member_log("批量刷新职位",1,4);
			echo 1;die;
		}else{
			echo "刷新失败！";die;
		}	
	}
	
    function Refresh_job_action(){
		if($_POST['ids']){
			$num=count($_POST['ids']);
		}else{
			$num=$this->obj->DB_select_num("company_job","`state`='1' and `uid`='".$this->uid."'");
		}
		if($num==0){
			echo "您暂无正常职位！";die;
		}
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");


		if($statis['vip_etime']>time() || $statis['vip_etime']=="0"){
			if($statis['rating_type']==1){
				if($statis['breakjob_num']>=$num){

					$value="`breakjob_num`='".($statis['breakjob_num']-$num)."'";
					$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
				}else{
					if($this->config['com_integral_online']=="1"){
						$integral=$this->config['integral_jobefresh']*($num-$statis['breakjob_num']);
						if($statis['integral']<$integral){
							echo "会员刷新职位数、".$this->config['integral_pricename']."均不足！";die;
						}else{
							$value="`breakjob_num`='0',`integral`=`integral`-$integral";
							$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
							$this->insert_company_pay($integral,2,$this->uid,'批量刷新职位',1,8);
						}
					}else{
						echo "会员刷新职位数不足！";die;
					}
				}
			}
		}else{
			if($this->config['com_integral_online']=="1"){
				$integral=$this->config['integral_jobefresh']*($num-$statis['breakjob_num']);
				if($statis['integral']<$integral){
					echo "会员刷新职位数、".$this->config['integral_pricename']."均不足！";die;
				}else{
					$value="`breakjob_num`='0',`integral`=`integral`-$integral";
					$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
					$this->insert_company_pay($integral,2,$this->uid,'批量刷新职位',1,8);
				}
			}else{
				echo "会员刷新职位数不足！";die;
			}
		}
		if($_POST['ids']!=""){
			$ids=pylode(",",$_POST['ids']);
			$nid=$this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`id` in (".$ids.") and `uid`='".$this->uid."'");
		}else{
			$nid=$this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`status`='1' and `uid`='".$this->uid."'");
		}
		$this->obj->DB_update_all("company","`jobtime`='".time()."'","`uid`='".$this->uid."'");
		if($nid){
			$this->obj->member_log("批量刷新职位",1,4);
			echo 1;die;
		}else{
			echo "刷新失败！";die;
		}
	}
	
    function ajax_city_action(){
		if($_POST['ptype']=='city'){
			include(PLUS_PATH."city.cache.php");
			if(is_array($city_type[$_POST['id']])){
				$data.="<ul>";
				foreach($city_type[$_POST['id']] as $v){
					if($_POST['gettype']=="citys"){
						$data.='<li><a href="javascript:;" onclick="select_city(\''.$v.'\',\'citys\',\''.$city_name[$v].'\',\'three_city\',\'city\');">'.$city_name[$v].'</a></li>';
					}else{
						$data.='<li><a href="javascript:;" onclick="selects(\''.$v.'\',\'three_city\',\''.$city_name[$v].'\');">'.$city_name[$v].'</a></li>';
					}
				}
				$data.="</ul>";
			}
		}else{
			include(PLUS_PATH."job.cache.php");
			if(is_array($job_type[$_POST['id']])){
				$data.="<ul>";
				foreach($job_type[$_POST['id']] as $v){
					if($_POST['gettype']=="job1_son"){
						$data.='<li><a href="javascript:;" onclick="select_city(\''.$v.'\',\'job1_son\',\''.$job_name[$v].'\',\'job_post\',\'job\');">'.$job_name[$v].'</a></li>';
					}else{
						$data.='<li><a href="javascript:;" onclick="selects(\''.$v.'\',\'job_post\',\''.$job_name[$v].'\');">'.$job_name[$v].'</a></li>';
					}
				}
				$data.="</ul>";
			}
		}
		echo $data;
	}
    
	function job_content_action(){
		$info=$this->obj->DB_select_once("job_class","`id`='".(int)$_POST['id']."'");
		echo $info['content'];die;
	}
	
	function get_jobclass_action(){
		if($_POST['name']){
			include(PLUS_PATH."job.cache.php");
			$name=$this->stringfilter($_POST['name']);
			$r=$this->locoytostr($job_name,$name);
			if(is_array($r)&&$content){
				$arr=array();
				foreach($r as $v){
					foreach($content as $val){
						if($v==$val){
							$arr[]=$val;
						}
					}
				}
				if($arr&&is_array($arr)){
					foreach($arr as $v){
						if(in_array($v,$content)){
							$html.="<a href=\"javascript:select_job('".$v."');\"> ".$job_name[$v]." </a>";
						}
					}
					echo $html."##".$job_name[$arr[0]];die;
				}
			}
		}
	}
	function locoytostr($arr,$str,$locoy_rate="50"){
		$str_array=$this->tostring($str);
		foreach($arr as $key =>$list){
			$h=0;
			foreach($str_array as $val){
				if(substr_count($list,$val))$h++;
			}
			$categoryname_array=$this->tostring($list);
			$j=round($h/count($categoryname_array)*100,2);
			$rows[$j]=$key;
		}
		krsort($rows);
		$i=0;
		foreach($rows as $k =>$v){
			if ($k>=$locoy_rate && $i<3){
				$job[]=$v;
				$i++;
			}
		}
		return $job;
	}
	function tostring($string){
		$length=strlen($string);
		$retstr=array();
		for($i=0;$i<$length;$i++) {
			$retstr[]=ord($string[$i])>127?$string[$i].$string[++$i]:$string[$i];
		}
		return $retstr;
	}

	function getjoblist_action(){
		if($_POST['type']=='job1'){
			$self="job1_son";
			$son='job_post';
		}else{
			$self="job_post";
			$son='';
		}
		include(PLUS_PATH."job.cache.php");
		$data='';
		if(is_array($job_type[$_POST['id']])){
			foreach($job_type[$_POST['id']] as $v){
				$data.="<li><a href=\"javascript:void(0);\" onclick=\"getjoblist('".$v."','".$self."','".$job_name[$v]."','".$son."');\">".$job_name[$v]."</a></li>";
			}
		}
		echo $data;die;
	}
	
	function getcitylist_action(){
		if($_POST['type']=='province'){
			$self="cityid";
			$son='three_cityid';
		}else{
			$self="three_cityid";
			$son='';
		}
		include(PLUS_PATH."city.cache.php");
		$data='';
		if(is_array($city_type[$_POST['id']])){
			foreach($city_type[$_POST['id']] as $v){
				$data.="<li><a href=\"javascript:void(0);\" onclick=\"getcitylist('".$v."','".$self."','".$city_name[$v]."','".$son."');\">".$city_name[$v]."</a></li>";
			}
		}
		echo $data;die;
	}
	
	function saveform_action(){
		$value['savetype']=$_POST['savetype'];
		$name=$_POST['name'];
		if($value['savetype']=="1"){
			$_POST['nationality']=iconv("utf-8", "gbk", $_POST['nationality']);
			$_POST['domicile']=iconv("utf-8", "gbk", $_POST['domicile']);
			$_POST['homepage']=iconv("utf-8", "gbk", $_POST['homepage']);
		}
		if($value['savetype']=="3"){
			$_POST['linkjob']=iconv("utf-8", "gbk", $_POST['linkjob']);
			$_POST['busstops']=iconv("utf-8", "gbk", $_POST['busstops']);
		}
		if($value['savetype']=="4"){
			$_POST['minsalary']=iconv("utf-8", "gbk", $_POST['minsalary']);
			$_POST['maxsalary']=iconv("utf-8", "gbk", $_POST['maxsalary']);
			$firname =@explode("lang%5B%5D=",$_POST['lang']);
			$secname=@implode("",$firname);
			$firwel =@explode("welfare%5B%5D=",$_POST['welfare']);
			$secwel=@implode("",$firwel);
			$_POST['lang'] =@str_replace ("&",",",$secname);
			$_POST['description']=iconv("utf-8", "gbk", $_POST['description']);
			$_POST['description'] = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['description'],ENT_QUOTES,"GB2312"));
		}
		if($value['savetype']=="5"){
			$firtimee =@explode("worktime%5B%5D=",$_POST['worktime']);
			$sectime=@implode("",$firtimee);
			$_POST['worktime'] =@str_replace ("%3A",":",$sectime);
			}
		$_POST['lastupdate']=time();
		$_POST['linkman']=iconv("utf-8", "gbk", $_POST['linkman']);
		$_POST['content']=iconv("utf-8", "gbk", $_POST['content']);
		$_POST['address']=iconv("utf-8", "gbk", $_POST['address']);
		$_POST['name']=iconv("utf-8", "gbk", $_POST['name']);
		$_POST['uname']=iconv("utf-8", "gbk", $_POST['uname']);
		$_POST['living']=iconv("utf-8", "gbk", $_POST['living']);

		$value['save']=serialize($_POST);
		$num=$this->obj->DB_select_num("lssave","`uid`='".$this->uid."' and `savetype`='".$value['savetype']."'");
		if(!$num ){
			$value['uid']=$this->uid;
			$data=$this->obj->insert_into("lssave",$value);
		}else{
			$data=$this->obj->update_once("lssave",$value,"`uid`='".$this->uid."' and `savetype`='".$value['savetype']."'");
		}
      echo $data;die;
	}
	function readform_action(){
		$save=$this->obj->DB_select_once("lssave","`uid`='".$this->uid."'and `savetype`='".intval($_POST['savetype'])."'");
		$save=unserialize($save['save']);
		include PLUS_PATH."/job.cache.php";
		include PLUS_PATH."/com.cache.php";
		include PLUS_PATH."/user.cache.php";
		include PLUS_PATH."/city.cache.php";
		include PLUS_PATH."/hy.cache.php";
		include PLUS_PATH."/industry.cache.php";
		include PLUS_PATH."/part.cache.php";
		$jobclass =@explode(",",$save['job_classid']);
		if(is_array($jobclass)){
			foreach($jobclass as $k=>$v){
				$save['job_class'][$k]=iconv("gbk","utf-8",$job_name[$v]);
		}
			$save['job_class']=@implode(",",$save['job_class']);
		}else{
			$save['job_class']=iconv("gbk","utf-8",$job_name[$save['job_classid']]);
		}
		$save['lang'] =@explode(",",$save['lang']);
		$save['welfare'] =@explode(",",$save['welfare']);
		$save['name']=iconv( "gbk","utf-8",$save['name']);
		$save['linkman']=iconv( "gbk","utf-8",$save['linkman']);
		$save['linkjob']=iconv( "gbk","utf-8",$save['linkjob']);
		$save['uname']=iconv( "gbk","utf-8",$save['uname']);
		$save['living']=iconv( "gbk","utf-8",$save['living']);
		$save['nationality']=iconv( "gbk","utf-8",$save['nationality']);
		$save['exp']=iconv( "gbk","utf-8",$userclass_name[$save['expid']]);
		$save['edu']=iconv( "gbk","utf-8",$userclass_name[$save['eduid']]);
		$save['marriage']=iconv("gbk","utf-8",$userclass_name[$save['marriageid']]);
		$save['marriages']=iconv("gbk","utf-8",$comclass_name[$save['marriagesid']]);
		$save['hy']=iconv("gbk","utf-8",$industry_name[$save['hyid']]);
		$save['salary']=iconv("gbk","utf-8",$userclass_name[$save['salaryid']]);
		$save['province']=iconv("gbk","utf-8",$city_name[$save['provinceid']]);
		$save['citys']=iconv("gbk","utf-8",$city_name[$save['citysid']]);
		$save['three_city']=iconv("gbk","utf-8",$city_name[$save['three_cityid']]);
		$save['type']=iconv("gbk","utf-8",$userclass_name[$save['typeid']]);
		$save['report']=iconv("gbk","utf-8",$userclass_name[$save['reportid']]);
		$save['status']=iconv("gbk","utf-8",$userclass_name[$save['statusid']]);
		$save['content']=iconv("gbk","utf-8",$save['content']);
		$save['busstops']=iconv("gbk","utf-8",$save['busstops']);
		$save['mun']=iconv("gbk","utf-8",$comclass_name[$save['munid']]);
		$save['qypr']=iconv("gbk","utf-8",$comclass_name[$save['qyprid']]);
		$save['job_post']=iconv("gbk","utf-8",$job_name[$save['job_postid']]);
		$save['age']=iconv("gbk","utf-8",$comclass_name[$save['ageid']]);
		$save['address']=iconv( "gbk","utf-8",$save['address']);
		if($save['savetype']=="4"){
			$save['description']=iconv("gbk","utf-8",$save['description']);
			$save['minsalary']=iconv( "gbk","utf-8",$save['minsalary']);
			$save['maxsalary']=iconv( "gbk","utf-8",$save['maxsalary']);
			$save['salarys']=iconv("gbk","utf-8",$comclass_name[$save['salarysid']]);
			$save['sexs']=$save['sexsid'];
			$save['edus']=iconv( "gbk","utf-8",$comclass_name[$save['edusid']]);
			$save['types']=iconv("gbk","utf-8",$comclass_name[$save['typesid']]);
			$save['reports']=iconv("gbk","utf-8",$comclass_name[$save['reportsid']]);
			$save['exps']=iconv( "gbk","utf-8",$comclass_name[$save['expsid']]);
		}
		if($save['savetype']=="5"){
			$save['billing_cycle']=iconv("gbk","utf-8",$partclass_name[$save['billingid']]);
			$save['salary_type']=iconv( "gbk","utf-8",$partclass_name[$save['salary_typeid']]);
			$save['types']=iconv("gbk","utf-8",$partclass_name[$save['typesid']]);
			$save['sex']=$save['sexid'];
			$save['worktime']=@explode("&",$save['worktime']);
		}
		if($save['basic_info']=="0"){
			$save['basic_info']=iconv("gbk","utf-8","显示");
		}else{
			$save['basic_info']=iconv("gbk","utf-8","不显示");
		}
		echo json_encode($save);die;
	}
		
    function Refresh_part_action(){
		if($_POST['ids']){
			$num=count($_POST['ids']);
		}else{
			$num=$this->obj->DB_select_num("partjob"," `uid`='".$this->uid."'");
		}
		if($num==0){
			echo "您暂无正常兼职！";die;
		}
		$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'");


		if($statis['vip_etime']>time() || $statis['vip_etime']=="0"){
			if($statis['rating_type']==1){
				if($statis['breakpart_num']>=$num){

					$value="`breakpart_num`='".($statis['breakpart_num']-$num)."'";
					$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
				}else{
					if($this->config['com_integral_online']=="1"){
						$integral=$this->config['integral_partjobefresh']*($num-$statis['breakpart_num']);
						if($statis['integral']<$integral){
							echo "会员刷新兼职职位数、".$this->config['integral_pricename']."均不足！";die;
						}else{
							$value="`breakpart_num`='0',`integral`=`integral`-$integral";
							$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
							$this->insert_company_pay($integral,2,$this->uid,'批量刷新兼职职位',1,8);
						}
					}else{
						echo "会员刷新兼职职位数不足！";die;
					}
				}
			}
		}else{
			if($this->config['com_integral_online']=="1"){
				$integral=$this->config['integral_partjobefresh']*($num-$statis['breakpart_num']);
				if($statis['integral']<$integral){
					echo "会员刷新兼职职位数、".$this->config['integral_partjobefresh']."均不足！";die;
				}else{
					$value="`breakpart_num`='0',`integral`=`integral`-$integral";
					$this->obj->DB_update_all("company_statis",$value,"`uid`='".$this->uid."'");
					$this->insert_company_pay($integral,2,$this->uid,'批量刷新兼职职位',1,8);
				}
			}else{
				echo "会员刷新兼职职位数不足！";die;
			}
		}
		if($_POST['ids']!=""){
			$ids=pylode(",",$_POST['ids']);
			$nid=$this->obj->DB_update_all("partjob","`lastupdate`='".time()."'","`id` in (".$ids.") and `uid`='".$this->uid."'");
		}else{
			$nid=$this->obj->DB_update_all("partjob","`lastupdate`='".time()."'","`uid`='".$this->uid."'");
		}
		if($nid){
			$this->obj->member_log("批量刷新兼职职位",1,4);
			echo 1;die;
		}else{
			echo "兼职刷新失败！";die;
		}
	}
	function sign_action(){
	    $date=date("Ymd");
	    $member=$this->obj->DB_select_once("member","`uid`='".$this->uid."' and `usertype`='".$_COOKIE['usertype']."'","`signday`,`signdays`");
	    $lastreg=$this->obj->DB_select_once("member_reg","`uid`='".$this->uid."' and `usertype`='".$_COOKIE['usertype']."' order by `id` desc");
	    $lastregdate=date("Ymd",$lastreg['ctime']);
	    if($lastregdate!=$date){
	        $yesterday=date("Ymd",strtotime("-1 day"));
	        if($lastregdate==$yesterday&&intval(date("d"))>1){
	            if($member['signday']>=5){
	                $integral=$this->config['integral_signin']*2;
	            }else{
	                $integral=$this->config['integral_signin'];
	            }
	            $signday=$member['signday']+1;
	            $msg='连续签到'.$signday."天";
	        }else{
	            $signday='1';
	            $integral=$this->config['integral_signin'];
	            $msg='第一次签到';
	        }
	        $arr=array();
	        $nid=$this->obj->insert_into("member_reg",array("uid"=>$this->uid,"usertype"=>$_COOKIE['usertype'],'date'=>$date,"ctime"=>time(),'ip'=>fun_ip_get()));
	        if($nid){
	            $this->save_integral($this->uid,$integral,$msg);
	            $this->obj->DB_update_all("member","`signday`='".$signday."',`signdays`=`signdays`+'1'","`uid`='".$this->uid."'");
	            $arr['type']=date("j");
	        }else{
	            $arr['type']=-2;
	        }
	        $arr['integral']=iconv("gbk","UTF-8",$integral.$this->config['integral_pricename']);
	        $arr['signday']=$signday;
	        $arr['signdays']=$member['signdays']+1;
	        echo json_encode($arr);die;
	    }
	}
	function guwenZan_action(){
	    $id=intval($_POST['id']);
	    $zan=$this->obj->DB_select_once('atn',"`conid`='".$id."' and `uid`='".$this->uid."'");
	    if (!$zan){
	        $data['uid']=$this->uid;
	        $data['time']=time();
	        $data['usertype']=$this->usertype;
	        $data['conid']=$id;
	        $this->obj->insert_into('atn',$data);
	        $this->obj->DB_update_all('company_consultant', '`zan`=`zan`+1',"`id`='".$id."'");
	        echo 1;die();
	    }else{
	        echo 2;die();
	    }
	}
}
?>