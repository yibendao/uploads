<?php
/* *
* $Author ��PHPYUN�����Ŷ�
*
* ����: http://www.phpyun.com
*
* ��Ȩ���� 2009-2017 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
*
* ����������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
*/
class likeresume_controller extends company{
	function index_action(){
		if($_GET['jobid']){
			
			$id=(int)$_GET['jobid'];
			$job=$this->obj->DB_select_once("company_job","`id`='".$id."'");
			$this->yunset("job",$job);
			$msg=$this->obj->DB_select_all("userid_msg","`fid`='".$this->uid."' AND jobid='$id' group by `uid`","`uid`");
			$select="a.id,a.uid,a.three_cityid,a.report,a.minsalary,a.maxsalary,b.edu,b.sex,b.marriage,b.exp,b.name";
			
			if($msg&&is_array($msg)){
				$uids=array();
				foreach($msg as $val){
					$uids[]=$val['uid'];
				}
				$resume=$this->obj->DB_select_alls("resume_expect","resume"," FIND_IN_SET('".$job['job_post']."',a.job_classid) and a.`id`=b.`def_job` and b.`uid` not in(".pylode(',',$uids).")",$select);
			}else{
				$resume=$this->obj->DB_select_alls("resume_expect","resume"," FIND_IN_SET('".$job['job_post']."',a.job_classid) and a.`id`=b.`def_job`",$select);
			} 
			if(is_array($resume))
			{ 
				
				include PLUS_PATH."/user.cache.php";
				include PLUS_PATH."/com.cache.php";
				include(CONFIG_PATH."db.data.php");
		        unset($arr_data['sex'][3]);
		        $this->yunset("arr_data",$arr_data);
				$this->yunset("userclass_name",$userclass_name);
				$this->yunset("comclass_name",$comclass_name);
				foreach($resume as $k=>$v){
					$resume[$k]['sex']=$arr_data['sex'][$v['sex']];
					$pre=60;
					if($v['three_cityid']==$job['three_cityid']){
						$pre=$pre+10;
					}
					if($comclass_name[$job['edu']]==$userclass_name[$v['edu']] || $comclass_name[$job['edu']]=="����"){
						$pre=$pre+5;
					}
					if($job['sex']==$v['sex']){
						$pre=$pre+5;
					}
					if($comclass_name[$job['marriage']]==$userclass_name[$v['marriage']] || $comclass_name[$job['marriage']]=="����"){
						$pre=$pre+5;
					}
					if($comclass_name[$job['report']]==$userclass_name[$v['report']] || $comclass_name[$job['report']]=="����"){
						$pre=$pre+5;
					}
					if($comclass_name[$job['exp']]==$userclass_name[$v['exp']] || $comclass_name[$job['exp']]=="����"){
						$pre=$pre+5;
					}
					$resume[$k]['pre']=$pre;
				}
				$sort = array(
					'direction' => 'SORT_DESC',
					'field'     => 'pre',    
				);
				$arrSort = array();
				foreach($resume AS $uniqid => $row){
				    foreach($row AS $key=>$value){
				        $arrSort[$key][$uniqid] = $value;
				    }
				}
				if($sort['direction']){
				    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $resume);
				}
				
				$this->yunset("resume",$resume);
			}
		}
		$JobM=$this->MODEL("job");
		$company_job=$JobM->GetComjobList(array("uid"=>$this->uid,"state"=>1,"`edate`>'".time()."' and `r_status`<>'2' and `status`<>'1'"),array("field"=>"`name`,`id`"));
		$this->yunset("company_job",$company_job);
		$this->public_action();
		$this->yunset("js_def",3);
		$this->com_tpl('likeresume');
	}
}
?>