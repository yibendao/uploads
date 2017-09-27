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
class partjob_controller extends common{
	function add_action(){
		
		include(APP_PATH."data/api/locoy/locoy_config.php");
		if($locoyinfo['locoy_online']!=1){
			echo 4;die;
		}
		if($locoyinfo['locoy_key']!=trim($_GET['key'])){
			echo 5;die;
		}
        if(!$_POST['part_name'] || !$_POST['com_name']){
			echo 2;die;
		}
		$uid=$this->add_com($_POST,$locoyinfo);
		$this->add_partjob($_POST,$locoyinfo,$uid);
	}
	function add_partjob($p,$l,$uid){
		$data['uid']=$uid;
		$data['name']=$p['part_name']; 
		$data['lastupdate']=mktime();  
		$data['state']=$l['locoy_partjob_status'];
		$data['content'] = strip_tags(html_entity_decode($p['partcontent'],ENT_NOQUOTES,"GB2312"),"<p> <br>");
   
		$chenk_row=$this->obj->DB_select_once("partjob","`name`='".$data['name']."' and `uid`='".$uid."'");
		if(is_array($chenk_row)){
			echo 3;die;
		}

		include(PLUS_PATH."industry.cache.php");
		
		
		$city=$p['job_city']?$p['job_city']:$p['city'];
		$city_row=$this->get_city($city,$l['locoy_rate']);
			if($city_row){
				$i=1;
				foreach($city_row as $v){
					if($i==1)$data['provinceid']=$v;
					if($i==2)$data['cityid']=$v;
					if($i==3)$data['three_cityid']=$v;
					$i++;
				}
			}else{
				$data['provinceid']=$l['locoy_job_province'];
				$data['cityid']=$l['locoy_job_city'];
				$data['three_cityid']=$l['locoy_job_three'];
			}
		if($p['sdate']){
			$data['sdate']=strtotime($p['sdate']);
		}else{
			$data['sdate']=mktime();
		}
		if($p['edate']){
			$data['edate']=strtotime($p['edate']);
		}else{
			$data['edate']=0;
		}
		$data['worktime']=$p['worktime'];
	
	    
		$data['sex']=$this->locoytostr($this->get_com_type('sex'),$p['sex'],$l['locoy_rate']);
		if(!$data['sex']){
			$data['sex']=$l['locoy_job_sex'];
		}
	
		$data['number']=$p['number'];
		if(!$data['number']){
			$data['number']=$l['locoy_job_number'];
		}
		include(PLUS_PATH."part.cache.php");
		
		$data['type']=$this->locoytostr($partclass_name,$p['type'],$l['locoy_rate']);
		if(!$data['type']){
			$data['type']=$l['locoy_part_type'];
		}
		
		$data['salary']=$p['salary'];
		$data['salary_type']=$this->locoytostr($partclass_name,$p['salary_type'],$l['locoy_rate']);
		
		if(!$data['salary_type']){
			$data['salary_type']=$l['locoy_part_salary']; 
		}
		
		$com=$this->obj->DB_select_once("company","`uid`='".$uid."'");
		$data['com_name']=$com['name'];
		$data['billing_cycle']=$l['locoy_part_billing'];
		$data['address']=trim($p['address']);
		$data['x']=$p['x'];
	    $data['y']=$p['y'];
		$data['deadline']=mktime()+604800;
		$data['linkman']=$p['linkman'];
	    $data['linktel']=$p['linktel'];
	    $data['statusbody']=0;
		
		$row=explode('-',$locoyinfo['locoy_part_hits']);
		if(is_array($row)){
			$rand=rand(trim($row[0]),trim($row[1]));
		}else{
			$rand=!trim($row)?0:$row;
		}
	    $data['hits']=$rand;
	    $data['rec_time']=0;
	    $data['did']=0;		
		$nid=$this->obj->insert_into("partjob",$data);
		if($this->config['com_job_status']=="1"){
			$this->send_dingyue($nid,2);
		}
		$this->obj->DB_update_all("company","`lastupdate`='".$p['lastupdate']."'","`uid`='".$uid."'");
		echo 1;die;
	}

	function add_com($p,$l){
		$row=$this->obj->DB_select_once("company","`name`='".$p['com_name']."'");
		if(is_array($row)){
			return $row['uid'];
		}else{
			$userid=$this->add_user($p,$l);
			$where['uid']=$userid;
			$data['name']=trim($p['com_name']);
			$data['address']=trim($p['address']);
			$data['linkphone']=trim($p['linkphone']);
			$data['linkmail']=trim($p['email']);
			$data['zip']=trim($p['zip']);
			$data['linkman']=trim($p['linkman']);
			$data['linkjob']=trim($p['linkjob']);
			$data['linkqq']=trim($p['linkqq']);
			$data['linktel']=trim($p['moblie']);
			$data['website']=trim($p['website']);
			if($p['com_sdate']){
				$data['sdate']=date("Y-m-d",strtotime(trim($p['com_sdate'])));
			}
			$money=str_replace(array("元","美元","￥","$"),"",trim($p['money']));
			if(!$money)$money=$l['locoy_com_money'];
			$data['money']=$money;
			$data['content'] = strip_tags(html_entity_decode($p['content'],ENT_NOQUOTES,"GB2312"),"<p> <br>");
			$data['lastupdate']=mktime();

			include(PLUS_PATH."industry.cache.php");
			$data['hy']=$this->locoytostr($industry_name,$p['hy'],$l['locoy_rate']);
			if(!$data['hy']){
				$data['hy']=$l['locoy_com_hy'];
			}
			$data['pr']=$this->locoytostr($this->get_com_type('pr'),$p['pr'],$l['locoy_rate']);
			if(!$data['pr']){
				$data['pr']=$l['locoy_com_pr'];
			}
			$data['mun']=$this->locoytostr($this->get_com_type('mun'),$p['mun'],$l['locoy_rate']);
			if(!$data['mun']){
				$data['mun']=$l['locoy_com_mun'];
			}
			$city_row=$this->get_city($p['city'],$l['locoy_rate']);
			if($city_row){
				$i=1;
				foreach($city_row as $v){
					if($i==1)$data['provinceid']=$v;
					if($i==2)$data['cityid']=$v;
					$i++;
				}
			}else{
				$data['provinceid']=$l['locoy_com_province'];
				$data['cityid']=$l['locoy_com_city'];
			}
			$nid=$this->obj->update_once("company",$data,$where);
			return $userid;
		}
	}
	function add_user($p,$l){
		$salt = substr(uniqid(rand()),-6);
		$pass = md5(md5($l['locoy_pwd']).$salt);
		$ip = fun_ip_get();
		$time = time();
		$username=$this->get_username($l);
		if($l['locoy_user_status']==1){
			$satus=1;
		}
		$userid=$this->obj->DB_insert_once("member","`username`='".$username."',`password`='$pass',`moblie`='".$p['moblie']."',`email`='".$p['email']."',`usertype`='2',`status`='$satus',`salt`='$salt',`reg_date`='$time',`reg_ip`='$ip',`source`='6'");
		$ratingM = $this->MODEL('rating');
		$value="`uid`='$userid',".$ratingM->rating_info($l['locoy_rating']);
		$value2 = "`uid`='$userid',`linkmail`='".$p['email']."',`name`='".$p['com_name']."',`linktel`='".$p['moblie']."',`address`='".$_POST['address']."'";
		$this->obj->DB_insert_once("company_statis",$value);
		$this->obj->DB_insert_once("company",$value2);
		return $userid;
	}
	function get_username($l){
		$row = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9");
		$va="";
		for($i=0;$i<$l['locoy_length'];$i++){
			$rand=rand(0,61);
			$va.=$row[$rand];
		}
		$data=$l['locoy_name'].$va;
		return $data;
	}
	
	function get_city($name,$locoy_rate){
		include(PLUS_PATH."city.cache.php");
		$name=str_replace(array("省","市","县","区"),"/",$name);
		$arr=explode("/",$name);
		if(is_array($arr)){
			foreach($arr as $v){
				$data[]=$this->locoytostr($city_name,$v,$locoy_rate);
			}
		}
		$city_type[0]=$city_index;
		$val=$this->get_all_city($city_type,$data);
		if(count($val)==1){
			$val[]=$this->get_once_city($city_type,$city_name,$val[0],$locoy_rate);
		}
		return $val;
	}
	function get_job_class($name,$locoy_rate){
		include(PLUS_PATH."job.cache.php");
		$arr=explode("/",$name);
		if(is_array($arr)){
			foreach($arr as $v){
				$data[]=$this->locoytostr($job_name,$v,$locoy_rate);
			}
		}
		$job_type[0]=$job_index;
		$val=$this->get_all_city($job_type,$data,$locoy_rate);
		if(count($val)==1){
			$val[]=$this->get_once_city($job_type,$job_name,$val[0],$locoy_rate);
		}
		return $val;
	}
	function get_all_city($city_type,$data,$locoy_rate,$k=""){
		if(is_array($data)){
			foreach($data as $v){
				foreach($city_type as $key=>$value){
					$a=$k?$k:$v;
					if(in_array($a,$value)){
						if($key){
							$val=$this->get_all_city($city_type,$data,$locoy_rate,$key);
						}
						$val[$key]=$a;
					}
				}
			}
		}
		return $val;
	}
	function get_once_city($t,$n,$id,$locoy_rate){
		$row=$n[$id];
		if(is_array($t[$id])){
			foreach($t[$id] as $k=>$v){
				$array[$v]=$n[$v];
			}
		}
		$r=$this->locoytostr($array,$row,$locoy_rate);
		return $r;
	}
	function get_com_type($cat){
		include(PLUS_PATH."com.cache.php");
		foreach($comdata["job_".$cat] as $v){
			$data[$v]=$comclass_name[$v];
		}
		return $data;
	}
	function locoytostr($arr,$str,$locoy_rate="50"){
		foreach($arr as $key=>$value)
		{
			similar_text($str,$value,$percent);

			$rows[$percent]=$key;
			$aaa[$percent] = $value;
		}
		krsort($rows);
		foreach($rows as $k =>$v){
			if ($k>=$locoy_rate){
				return $v;
			}else{
				return false;
			}
		}
	}
	function tostring($string){
		$length=strlen($string);
		$retstr=array();
		for($i=0;$i<$length;$i++) {
			$retstr[]=ord($string[$i])>127?$string[$i].$string[++$i]:$string[$i];
		}
		return $retstr;
	}
}
?>