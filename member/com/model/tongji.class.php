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
class tongji_controller extends company
{
	function index_action()
	{
		$this->company_satic();
		$this->public_action();
		$tjtype=array("1"=>"区域","2"=>"学历","3"=>"薪资","4"=>"工作经验");
		$this->yunset("tjtype",$tjtype);
		$JobList=$this->obj->DB_select_all('company_job',"`uid`='".$this->uid."'","`id`,`name`");
		if(is_array($JobList) && $_GET['jobid']){
			foreach($JobList as $v){
				if($_GET['jobid']==$v['id']){
					$this->yunset("jobname",$v['name']);
				}
			}
		}
		$this->yunset("JobList",$JobList);

		$lwhere=$where="`com_id`='".$this->uid."'";
		$mwhere="`fid`='".$this->uid."'";
		if($_GET['jobid']){
			$where.=" and `job_id`='".(int)$_GET['jobid']."'";
			$lwhere.=" and `jobid`='".(int)$_GET['jobid']."'";
			$mwhere.=" and `jobid`='".(int)$_GET['jobid']."'";
		}
		if($_GET['sdate'] && $_GET['edate']){
			$sdate = $_GET['sdate'];
			$days = ceil(abs(time() - strtotime($sdate))/86400);
			$edate = $_GET['edate'];
			$days = ceil(abs(strtotime($edate) - strtotime($sdate))/86400);
			$edatetime=strtotime($edate);
		}else{
			$days = 30;
			$sdate = date('Y-m-d',(time()-$days*86400));
			$edate = date('Y-m-d');
			$edatetime=time();
		}
		$where.=" and `datetime`>='".strtotime($sdate)."' and `datetime`<='".$edatetime."'";
		$lwhere.=" and `datetime`>='".strtotime($sdate)."' and `datetime`<='".$edatetime."'";
		$mwhere.=" and `datetime`>='".strtotime($sdate)."' and `datetime`<='".$edatetime."'";
		$this->yunset("sdate",$sdate);
		$this->yunset("edate",$edate);
		$this->yunset("days",$days);
		$useridmsg=$this->obj->DB_select_num("userid_msg",$mwhere);
		$cgmsg=$this->obj->DB_select_num("userid_msg",$mwhere." and `is_browse`='1'");
	    if ($useridmsg&&$cgmsg){
		    $cgl=number_format($cgmsg/$useridmsg*100, 0, ',', ' ');
		}else{
		    $cgl=0;
		}
		$this->yunset("useridmsg",$useridmsg);
		$this->yunset("cgl",$cgl);
		$tdnum=$this->obj->DB_select_num("userid_job",$where);
		$this->yunset("tdnum",$tdnum);
		$List=$this->tj("userid_job",$where,$days);
		$this->yunset("list",$List);
		$LookList=$this->tj("look_job",$lwhere,$days);
		$this->yunset("looklist",$LookList);
		$useridjob=$this->obj->DB_select_all("userid_job",$where,"eid");
		if(is_array($useridjob)){
			foreach($useridjob as $v){
				$eid[]=$v['eid'];
			}
		}
		if($_GET['type']=="1"){
			include PLUS_PATH."city.cache.php";
			foreach($city_index as $k=>$v){
				$dateArr[] = $city_name[$v];
			}
			$list = $this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).") group by provinceid","count(*) as num,provinceid");
			if(is_array($list)){
				foreach($list as $key=>$value){
					$list[$key]['fields'] = $city_name[$value['provinceid']];
				}
			}
			$this->yunset("piename","区域简历投递统计");
		}elseif($_GET['type']=="2"){
			include PLUS_PATH."user.cache.php";
			foreach($userdata['user_edu'] as $k=>$v){
				$dateArr[] = $userclass_name[$v];
			}
			$list = $this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).") group by edu","count(*) as num,edu");
			if(is_array($list)){
				foreach($list as $key=>$value){
					$list[$key]['fields'] = $userclass_name[$value['edu']];
				}
			}
			$this->yunset("piename","学历简历投递统计");
		}elseif($_GET['type']=="3"){
			include PLUS_PATH."user.cache.php";
			foreach($userdata['user_salary'] as $k=>$v){
				$dateArr[] = $userclass_name[$v];
			}
			$list = $this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).") group by salary","count(*) as num,salary");
			if(is_array($list)){
				foreach($list as $key=>$value){
					$list[$key]['fields'] = $userclass_name[$value['salary']];
				}
			}
			$this->yunset("piename","薪资简历投递统计");

		}elseif($_GET['type']=="4"){
			include PLUS_PATH."user.cache.php";
			foreach($userdata['user_exp'] as $k=>$v){
				$dateArr[] = $userclass_name[$v];
			}
			$list = $this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).") group by exp","count(*) as num,exp");
			if(is_array($list)){
				foreach($list as $key=>$value){
					$list[$key]['fields'] = $userclass_name[$value['exp']];
				}
			}
			$this->yunset("piename","工作经验简历投递统计");
		}
		$this->yunset("pielist",$list);
		$this->yunset("js_def",2);
		$this->com_tpl('tongji');
	}
	function tj($table,$where,$days){
		$joblist=$this->obj->DB_select_all($table,$where." GROUP BY td ORDER BY td DESC","FROM_UNIXTIME(`datetime`,'%Y%m%d') as td,count(*) as cnt");
		if(is_array($joblist))
		{
			$AllNum = 0;
			foreach($joblist as $key=>$value)
			{
				$AllNum +=$value['cnt'];
				$Date[$value['td']] = $value;
			}
			if($days>0)
			{
				for($i=0;$i<=$days;$i++){
					$onday = date("Ymd", strtotime(' -'. $i . 'day'));
					$td    = date('m-d', strtotime(' -'. $i . 'day'));
					$date    = date('Y-m-d', strtotime(' -'. $i . 'day'));
					if(!empty($Date[$onday]))
					{
						$Date[$onday]['td'] = $td;
						$Date[$onday]['date'] = $date;
						$List[$onday] = $Date[$onday];
					}else{
						$List[$onday] = array('td'=>$td,'cnt'=>0,'date'=>$date);
					}
				}
			}
		}
		ksort($List);
		return $List;
	}

}
?>