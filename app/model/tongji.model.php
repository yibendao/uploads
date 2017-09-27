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

class tongji_model extends model{
	

	function getTj($Tablename,$Get,$Field,$Where='1 ',$CountField='count(*) as count'){
		
		$TimeDate = $this->TimeDate($Field,$CountField);
		
		$Stats =$this->DB_select_all($Tablename,$Where." AND ".$TimeDate['FieldWhere'],$TimeDate['FieldFormat']);
		
		return $this->TjInfo($Stats,$TimeDate);
	}


	 function TjInfo($Stats,$TimeDate){
	
		if(is_array($Stats))
		{
			$AllNum = 0;$Date=array();
			foreach($Stats as $key=>$value)
			{
				$AllNum +=$value['count'];
				
				$Date[$value['tjtime']] = $value['count'];
			}
			foreach($TimeDate['DateList'] as $key=>$value){
				if($Date[$value['onday']]<1){
					$Date[$value['onday']] = 0;
				}
				$List[$value['onday']] = array('tjtime'=>$value['tjtime'],'count'=>$Date[$value['onday']],'date'=>$value['date']);
			}
		}
		ksort($List);
		return array('allnum'=>$AllNum,'list'=>$List,'timedate'=>$TimeDate);
	}


	
	function TimeDate($field,$countfield='count(*) as count'){

		if(!$_GET['days'] && !$_GET['sdate'] && !$_GET['edate']){
			
			$_GET['days']  =1;
		}
		if($_GET['days']=='-1'){

			$days = 24;
			$sdate = strtotime('-1 days');
			$edate = strtotime(date('Y-m-d'));
			
			$FieldFormat = "FROM_UNIXTIME(`$field`,'%k') as tjtime,$countfield";

			for($i=0;$i<=$days;$i++){

				$DateList[$i]['tjtime'] = $i;
				$DateList[$i]['date'] = $i.":00";
				$DateList[$i]['onday'] = $i;
			}

		}elseif($_GET['days']=='1'){
			$days = 24;
			$sdate = strtotime(date('Y-m-d'));
			$edate = time();
			$FieldFormat = "FROM_UNIXTIME(`$field`,'%k') as tjtime,$countfield";
			for($i=0;$i<=$days;$i++){

				$DateList[$i]['tjtime'] = $i;
				$DateList[$i]['date'] = $i.":00";
				$DateList[$i]['onday'] = $i;
			}

		}elseif((int)$_GET['days']>1)
		{
			$days = (int)$_GET['days'];
			$sdate = strtotime('-'.$days.' days');
			$edate = time();
			$FieldFormat = "FROM_UNIXTIME(`$field`,'%Y%m%d') as tjtime,$countfield";
			
			for($i=0;$i<=$days;$i++){
				$onday = date("Ymd", strtotime(' -'. $i . 'day'));
				$tjtime    = date('m-d', strtotime(' -'. $i . 'day'));
				$date  = date('Y-m-d', strtotime(' -'. $i . 'day'));

				$DateList[$i]['tjtime'] = $tjtime;
				$DateList[$i]['date'] = $date;
				$DateList[$i]['onday'] = $onday;
			}

		}elseif($_GET['sdate']){
			if($_GET['edate']){

				$edate = strtotime($_GET['edate']);

				$sdate = strtotime($_GET['sdate']);
				
				$days = ceil(abs($edate - $sdate)/86400);

				$FieldFormat = "FROM_UNIXTIME(`$field`,'%Y%m%d') as tjtime,$countfield";

				for($i=0;$i<=$days;$i++){
					$onday = date("Ymd", strtotime(' -'. $i . 'day'));
					$tjtime    = date('m-d', strtotime(' -'. $i . 'day'));
					$date  = date('Y-m-d', strtotime(' -'. $i . 'day'));

					$DateList[$i]['tjtime'] = $tjtime;
					$DateList[$i]['date'] = $date;
					$DateList[$i]['onday'] = $onday;
				}


			}else{

				$days = 24;
				$sdate = strtotime($_GET['edate']);
				$edate = $sdate+86400;
				$FieldFormat = "FROM_UNIXTIME(`$field`,'%k') as tjtime,$countfield";

				for($i=0;$i<=$days;$i++){

					$DateList[$i]['tjtime'] = $i;
					$DateList[$i]['date'] = $i.":00";
					$DateList[$i]['onday'] = $i;
				}
			}	
		}

		$DateWhere = " $field >= ".$sdate." AND $field < ".$edate;

		$FieldWhere = $DateWhere." GROUP BY tjtime ORDER BY tjtime DESC";

		return array('days'=>$days,'FieldWhere'=>$FieldWhere,'FieldFormat'=>$FieldFormat,'DateList'=>$DateList,'DateWhere'=>$DateWhere);
	}
	

	
	function TopTen($Tablename,$Where,$Field,$Type,$Limit='10',$CountField="count(*) AS count"){
		

		$List = $this->DB_select_all($Tablename,$Where." GROUP BY ".$Field." ORDER BY count DESC LIMIT ".$Limit,$CountField.",".$Field);
		
		foreach($List as $key=>$value){
			
			$Fields[] = $value[$Field];
			$Count[$value[$Field]] = $value['count'];
		}
		
		if($Type=='job'){
			
			
			$FieldList = $this->DB_select_all("company_job","`id` IN (".pylode(',',$Fields).")","`id`,`uid`,`name`");
			
			foreach($FieldList as $key=>$value){
			
				$value['count'] = $Count[$value['id']];
				$NewList[$value['id']] = $value;
			}

			foreach($List as $key=>$value){
			
				$TopList[$key] = $NewList[$value[$Field]];
			}
		}elseif($Type=='company'){
			$FieldList = $this->DB_select_all("company","`uid` IN (".pylode(',',$Fields).")","`uid`,`name`");

			
			foreach($FieldList as $key=>$value){
			
				$value['count'] = $Count[$value['uid']];
				$NewList[$value['uid']] = $value;
			}

			foreach($List as $key=>$value){
				if(!empty($NewList[$value[$Field]])){
					$TopList[$key] = $NewList[$value[$Field]];
				}	
				
			}
		}elseif($Type=='expect'){
			$FieldList = $this->DB_select_all("resume_expect","`id` IN (".pylode(',',$Fields).")","`id`,`uid`,`uname`,`job_classid`,`provinceid`,`cityid`,`three_cityid`");
			
			
			foreach($FieldList as $key=>$value){
			
				$value['count'] = $Count[$value['id']];
				$NewList[$value['id']] = $value;
			}

			foreach($List as $key=>$value){
				if(!empty($NewList[$value[$Field]])){
					$TopList[$key] = $NewList[$value[$Field]];
				}	
				
			}
		}elseif($Type=='resume'){
			$FieldList = $this->DB_select_all("resume","`uid` IN (".pylode(',',$Fields).")","`uid`,`name`,`sex`,`exp`,`edu`");
			
			
			foreach($FieldList as $key=>$value){
			
				$value['count'] = $Count[$value['uid']];
				$NewList[$value['uid']] = $value;
			}

			foreach($List as $key=>$value){
				if(!empty($NewList[$value[$Field]])){
					$TopList[$key] = $NewList[$value[$Field]];
				}	
				
			}
		}elseif($Type=='order'){
			$FieldList = $this->DB_select_all("member","`uid` IN (".pylode(',',$Fields).")","`uid`,`username`,`usertype`");
			
			
			foreach($FieldList as $key=>$value){
			
				$value['count'] = $Count[$value['uid']];
				$NewList[$value['uid']] = $value;
			}

			foreach($List as $key=>$value){
				if(!empty($NewList[$value[$Field]])){
					$TopList[$key] = $NewList[$value[$Field]];
				}	
				
			}
		}if($Type=='ad'){
			
			
			$FieldList = $this->DB_select_all("adclick","`aid` IN (".pylode(',',$Fields).")","`aid`");
			
			$adList = $this->DB_select_all("ad","`id` IN (".pylode(',',$Fields).")");
			foreach($adList as $value){
				$adLists[$value['id']] = $value['ad_name'];
			}
			foreach($FieldList as $key=>$value){
			
				$value['count'] = $Count[$value['aid']];
				$value['name'] = $adLists[$value['aid']];
				$NewList[$value['aid']] = $value;
			}

			foreach($List as $key=>$value){
			
				$TopList[$key] = $NewList[$value[$Field]];
			}
		}

		return $TopList;
	}

	function DataTj($Type,$Where,$Tablename,$Field){
		
		include PLUS_PATH.'city.cache.php';
		include PLUS_PATH.'industry.cache.php';
		include PLUS_PATH.'job.cache.php';
		include PLUS_PATH.'com.cache.php';
		include PLUS_PATH.'user.cache.php';
        include(CONFIG_PATH."db.data.php");		
		
		
		$List = $this->DB_select_all($Tablename,$Where,$Field);
		
		if(is_array($List)){
			foreach($List as $key=>$value){
				
				$Fields[] = $value[$Field];
			}
			if($Type=='resume_expect'){

			
				$ResumeList = $this->DB_select_all("resume_expect","`id` IN (".pylode(',',$Fields).")","`sex`,`edu`,`exp`,`job_classid`,`provinceid`,`cityid`,`three_cityid`,`salary`");
				
				$jobClassEnd = array();
				foreach($job_index as $val){
					
					if(is_array($job_type[$val])){
						$jobClassAll[$val][] = $val;
						foreach($job_type[$val] as $v){
							
							$jobClassAll[$val] = array_merge($jobClassAll[$val], $job_type[$val]);
							
							if(is_array($job_type[$v])){
										
								$jobClassAll[$val] = array_merge($jobClassAll[$val], $job_type[$v]);
								
							}
						}
					}
				}
				foreach($jobClassAll as $key=>$value){
					if(is_array($value)){
						foreach($value as $v){
							$jobClassEnd[$v] = $key;
						}
					}
				}
			
				foreach($ResumeList as $key=>$value){
					
					$Count['sex'][$value['sex']]['count']++;					
					$Count['sex'][$value['sex']]['name'] =$arr_data['sex'][$value['sex']];
										
					$Count['edu'][$value['edu']]['count']++;
					$Count['edu'][$value['edu']]['name'] = $userclass_name[$value['edu']];

					$Count['exp'][$value['exp']]['count']++;
					$Count['exp'][$value['exp']]['name'] = $userclass_name[$value['exp']];
					if($value['job_classid']){
						$jobclassid = @explode(',',$value['job_classid']);
						foreach($jobclassid as $k=>$v){
							$classid = $jobClassEnd[$v];
							if($classid){
								$Count['job1'][$classid]['count']++;
								$Count['job1'][$classid]['name'] = $job_name[$classid];
							}
						}
					}
					

					$Count['provinceid'][$value['provinceid']]['count']++;
					$Count['provinceid'][$value['provinceid']]['name'] = $city_name[$value['provinceid']];
					
					$Count['cityid'][$value['cityid']]['count']++;
					$Count['cityid'][$value['cityid']]['name'] = $city_name[$value['cityid']];

					$Count['three_cityid'][$value['three_cityid']]['count']++;
					$Count['three_cityid'][$value['three_cityid']]['name'] = $city_name[$value['three_cityid']];

					$Count['salary'][$value['salary']]['count']++;
					$Count['salary'][$value['salary']]['name'] = $userclass_name[$value['salary']];
				}
			}elseif($Type=='job'){
				
				
				$JobList = $this->DB_select_all("company_job","`id` IN (".pylode(',',$Fields).")","`edu`,`exp`,`job1`,`job1_son`,`job_post`,`provinceid`,`cityid`,`three_cityid`,`salary`");
				
				
				foreach($JobList as $key=>$value){
					
					$Count['edu'][$value['edu']]['count']++;
					$Count['edu'][$value['edu']]['name'] = $comclass_name[$value['edu']];

					$Count['exp'][$value['exp']]['count']++;
					$Count['exp'][$value['exp']]['name'] = $comclass_name[$value['exp']];

					$Count['job1'][$value['job1']]['count']++;
					$Count['job1'][$value['job1']]['name'] = $job_name[$value['job1']];

					$Count['job1_son'][$value['job1_son']]['count']++;
					$Count['job1_son'][$value['job1_son']]['name'] = $job_name[$value['job1_son']];

					$Count['job_post'][$value['job_post']]['count']++;
					$Count['job_post'][$value['job_post']]['name'] = $job_name[$value['job_post']];

					$Count['provinceid'][$value['provinceid']]['count']++;
					$Count['provinceid'][$value['provinceid']]['name'] = $city_name[$value['provinceid']];
					
					$Count['cityid'][$value['cityid']]['count']++;
					$Count['cityid'][$value['cityid']]['name'] = $city_name[$value['cityid']];

					$Count['three_cityid'][$value['three_cityid']]['count']++;
					$Count['three_cityid'][$value['three_cityid']]['name'] = $city_name[$value['three_cityid']];

					$Count['salary'][$value['salary']]['count']++;
					$Count['salary'][$value['salary']]['name'] = $comclass_name[$value['salary']];
				}
			}elseif($Type=='reg'){
				
				

				$RegList = $this->DB_select_all("member","`uid` IN (".pylode(',',$Fields).") group by source","count(*) as count,source");
				
				foreach($RegList as $key=>$value){
					
					$Count['source'][$value['source']]['count'] = $value['count'];
					switch($value['source']){
						case '1':
							$Count['source'][$value['source']]['name'] = 'PC网页';
						break;
						case '2':
							$Count['source'][$value['source']]['name'] = '手机WAP';
						break;
						case '3':
							$Count['source'][$value['source']]['name'] = 'APP';
						break;
						case '4':
							$Count['source'][$value['source']]['name'] = '微信';
						break;
						case '5':
							$Count['source'][$value['source']]['name'] = 'PC应用';
						break;
						case '6':
							$Count['source'][$value['source']]['name'] = '采集';
						break;
						case '7':
							$Count['source'][$value['source']]['name'] = 'EXCEL导入';
						break;

					}
				}
			}elseif($Type=='order'){
				
				
				$OrderList = $this->DB_select_all("company_order","`id` IN (".pylode(',',$Fields).")","`id`,`order_type`,`type`");
				
				$TypeName = array('0'=>'其他','1'=>'购买会员','2'=>'充值'.$this->config['integral_pricename'].'','3'=>'银行转账','4'=>'金额充值','5'=>'购买增值包','6'=>'课程订购');

				$OrderTypeName = array('adminpay'=>'管理员充值','admincut'=>'管理员扣款','alipay'=>'支付宝','wapalipay'=>'手机支付宝','wxpay'=>'微信支付','bank'=>'银行汇款','tenpay'=>'财付通','0'=>'其他');

				foreach($OrderList as $key=>$value){	
					if(!$value['order_type']){
						$value['order_type'] = 0;
					}
					$Count['ordertype'][$value['order_type']]['count']++;
					$Count['ordertype'][$value['order_type']]['name'] = $OrderTypeName[$value['order_type']];

					if(!$value['type']){
						$value['type'] = 0;
					}
					$Count['type'][$value['type']]['count']++;
					$Count['type'][$value['type']]['name'] = $TypeName[$value['type']];
				}
			}elseif($Type=='company'){
				$rating = $this->DB_select_all("company_rating","1","`id`,`name`");
				foreach($rating as $value){
					$ratingList[$value['id']] = $value['name'];
				}
				
				
				$CompanyList = $this->DB_select_all("company","`uid` IN (".pylode(',',$Fields).")","`uid`,`hy`,`provinceid`,`jobtime`");

				$CompanyRating = $this->DB_select_all("company_statis","`uid` IN (".pylode(',',$Fields).")","`uid`,`rating`");
				foreach($CompanyRating as $value){

					$Count['rating'][$value['rating']]['count']++;
					$Count['rating'][$value['rating']]['name'] = $ratingList[$value['rating']];

				}
				
				foreach($CompanyList as $key=>$value){	
					if(!$value['hy']){
						$Count['hy'][0]['count']++;
						$Count['hy'][0]['name'] = '其他';
						$Count['is'][0]['count']++;
					}else{
						$Count['is'][1]['count']++;
						$Count['hy'][$value['hy']]['count']++;
						$Count['hy'][$value['hy']]['name'] = $industry_name[$value['hy']];
					}
					
					
					$Count['is'][0]['name']='信息不全';

					$Count['is'][1]['name']='信息完善';

				}
			
			}elseif($Type=='ad'){
				
				
				
				$CompanyList = $this->DB_select_all("company","`uid` IN (".pylode(',',$Fields).")","`uid`,`hy`,`provinceid`,`jobtime`");


				$CompanyRating = $this->DB_select_all("company_statis","`uid` IN (".pylode(',',$Fields).")","`uid`,`rating`");
				foreach($CompanyRating as $value){

					$Count['rating'][$value['rating']]['count']++;
					$Count['rating'][$value['rating']]['name'] = $ratingList[$value['rating']];

				}
				
				foreach($CompanyList as $key=>$value){	
					if(!$value['hy']){
						$Count['hy'][0]['count']++;
						$Count['hy'][0]['name'] = '其他';
						$Count['is'][0]['count']++;
					}else{
						$Count['is'][1]['count']++;
						$Count['hy'][$value['hy']]['count']++;
						$Count['hy'][$value['hy']]['name'] = $industry_name[$value['hy']];
					}
					
					
					$Count['is'][0]['name']='信息不全';

					$Count['is'][1]['name']='信息完善';

				}
			
			}
		}
		return $Count;
	}
}
?>