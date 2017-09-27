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
class likejob_controller extends user{
	
	function index_action(){
		$this->public_action();
		
		if($_GET['id']){
			$id=(int)$_GET['id'];
			$resume=$this->obj->DB_select_alls("resume_expect","resume","a.`uid`=b.`uid` and a.id='".$id."'");
			$resume=$resume[0]; 
			$this->yunset("resume",$resume);
			if($resume['job_classid']!=""){
				$jobclass=@explode(",",$resume['job_classid']);
				foreach($jobclass as $v){
					$where[]=$v;
				}
				$where=" and (`job_post` in (".@implode(" , ",$where).") or `job1_son` in (".@implode(" , ",$where)."))and `cityid`='".$resume['cityid']."' order by id desc limit 16 ";
			}
			$time = time();
			$select="id,name,three_cityid,edu,sex,marriage,report,exp,minsalary,maxsalary";
			$job=$this->obj->DB_select_all("company_job","`sdate`<'".$time."'and `r_status`<>2 and `status`<>1  and `edate`>'".$time."' and `state`='1' ".$where,$select);  
			if(is_array($resume)){
				include PLUS_PATH."/user.cache.php";
				include PLUS_PATH."/com.cache.php";
				include(CONFIG_PATH."db.data.php");
		        $this->yunset("arr_data",$arr_data);
				$this->yunset("comclass_name",$comclass_name);
				foreach($job as $k=>$v){
					$job[$k]['sex']=$arr_data['sex'][$v['sex']];
					
					$pre=60;
					if($v['three_cityid']==$resume['three_cityid']){
						$pre=$pre+10;
					}
					if($userclass_name[$resume['edu']]==$comclass_name[$v['edu']] || $comclass_name[$v['edu']]=="不限"){
						$pre=$pre+5;
					}
					if($userclass_name[$resume['marriage']]==$comclass_name[$v['marriage']] || $comclass_name[$v['sex']]=="不限"){
						$pre=$pre+5;
					}
					if($job['sex']==$v['sex']){
						$pre=$pre+5;
					}
					if($userclass_name[$resume['report']]==$comclass_name[$v['report']] || $comclass_name[$v['report']]=="不限"){
						$pre=$pre+5;
					}
					if($userclass_name[$resume['exp']]==$comclass_name[$v['exp']] || $comclass_name[$v['exp']]=="不限"){
						$pre=$pre+5;
					}
					$job[$k]['pre']=$pre;
				}
				$sort = array(
				        'direction' => 'SORT_DESC', 
				        'field'     => 'pre',       
				);
				$arrSort = array();
				foreach($job AS $uniqid => $row){
				    foreach($row AS $key=>$value){
				        $arrSort[$key][$uniqid] = $value;
				    }
				}
				if($sort['direction']){
				    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $job);
				}
				$this->yunset("job",$job);
			}
		}
		$this->user_tpl('likejob');
	}
}
?>