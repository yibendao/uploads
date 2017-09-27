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
class cron_model extends model{
	
	function excron($cron,$id=''){

       if(is_array($cron) && !empty($cron)){
				
				foreach($cron as $key=>$value){
					if($id){
						if($value['id']==$id){
							$timestamp[$value['nexttime']] = $value;
							$timestamp[$value['nexttime']]['cronkey'] = $key;
							break;
						}
					}else{
						
						if($value['nexttime']<=time()){
							$timestamp[$value['nexttime']] = $value;
							$timestamp[$value['nexttime']]['cronkey'] = $key;
						}
					}
				}
				if($timestamp){
					
					$data['cron'] = ArrayToString($cron);
					$data['start'] = '1';
					made_web_array(PLUS_PATH.'cron.cache.php',$data);

					
					krsort($timestamp);
					$croncache = current($timestamp);
					
					
					set_time_limit(600);

					
						
					if(file_exists(LIB_PATH.'cron/'.$croncache['dir'])){
						include(LIB_PATH.'cron/'.$croncache['dir']);
					}
					
					$nexttime = $this->nextexe($croncache);

					
					$this->DB_update_all("cron","`nowtime`='".time()."',`nexttime`='".strtotime($nexttime)."'","`id`='".$croncache['id']."'");

					
					$cron[$croncache['cronkey']]['nexttime'] = strtotime($nexttime);
					$data['cron'] = ArrayToString($cron);
					
					$data['start'] = '0';
					made_web_array(PLUS_PATH.'cron.cache.php',$data);

				}

			}
			return true;
    }

	function nextexe($value){
		
		if($value["type"]=='1' && $value["week"]>0){
			$W   = date("w",time());   
			if($value["week"]>=$W){
				$Day = date("Ymd", strtotime("+".($value["week"]-$W)." days", time()));
			}else{
				$Day = date("Ymd", strtotime("+".($value["week"]-$W+7)." days", time()));
			}
		}elseif($value['type']=='2' && $value["month"]>0){
			if($value["month"]<10){
				$Day  = date('Ym')."0".$value["month"];
			}else{
				$Day  = date('Ym')."".$value["month"];
			}
		}else{
			$Day = date('Ymd');
		}

		$Date = $Day;
		
		if($value["hour"]>0){
			if($value["hour"]<10){
				$Date .= "0".$value["hour"];
			}else{
				$Date .= $value["hour"];
			}
		}else{
			$Date .= '00';
		}
		if($value["minute"]>0){
			if($value["minute"]<10){
				$Date .= "0".$value["minute"];
			}else{
				$Date .= $value["minute"];
			}
		}else{
			$Date .= '00';
		}

		
		if($Date<=date('YmdHi')){
			if($value["type"]=='1' && $value["week"]>0){
				$Dates = date('Ymd',strtotime("+1 week",$Date));

			}elseif($value['type']=='2' && $value["month"]>0){
				$nextmonth = $this->GetMonth();
				if($value["month"]<10){
					$Dates  = $nextmonth.'0'.$value["month"];
				}else{
					$Dates  = $nextmonth.$value["month"];
				}
			}else{
				$Dates = date('Ymd',strtotime("+1 days",strtotime($Day)));
			}

			
			if($value["hour"]>0){
				if($value["hour"]<10){
					$Dates  .= '0'.$value["hour"];
				}else{
					$Dates  .= $value["hour"];
				}
			}else{
				$Dates  .= "00";
			}

			if($value["minute"]>0){
				if($value["minute"]<10){
					$Dates  .= '0'.$value["minute"];
				}else{
					$Dates  .= $value["minute"];
				}
			}else{
				$Dates  .= "00";
			}
			return 	$Dates;
		}else{
			return 	$Date;
		}
	}
	function GetMonth(){
		
		$tmp_date=date("Ym");

		
		$tmp_year=substr($tmp_date,0,4);
		
		$tmp_mon =substr($tmp_date,4,2);
		$tmp_nextmonth=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);
		$tmp_forwardmonth=mktime(0,0,0,$tmp_mon-1,1,$tmp_year);

		
		return $fm_next_month=date("Ym",$tmp_nextmonth);
	}
}
?>