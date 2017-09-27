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
class favorite_controller extends user{
	function index_action(){
		$this->yunset($this->MODEL('cache')->GetCache(array('city','com')));
		$this->public_action();
		$this->member_satic();
		$urlarr=array("c"=>"favorite","page"=>"{{page}}");
        $StateNameList=array('0'=>'等待审核','1'=>'招聘中','2'=>'已结束','3'=>'未通过');
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("fav_job","`uid`='".$this->uid."' order by id desc",$pageurl,"20");
		if($rows&&is_array($rows)){
			
			include PLUS_PATH."/com.cache.php";
			foreach($rows as $val){
				if($val['type']==1){
					$com_jobid[]=$val['job_id'];				
				}
			}			
			$company_job=$this->obj->DB_select_all("company_job","`id` in(".pylode(',',$com_jobid).")","`id`,`minsalary`,`maxsalary`,`provinceid`,`cityid`,`state`");
			foreach($rows as $key=>$val){
                $rows[$key]['statename']='已关闭';
				foreach($company_job as $v){
					if($val['job_id']==$v['id']){
						$rows[$key]['minsalary']=$v['minsalary'];
						$rows[$key]['maxsalary']=$v['maxsalary'];
						$rows[$key]['provinceid']=$v['provinceid'];
						$rows[$key]['cityid']=$v['cityid'];
                        $rows[$key]['statename']=$StateNameList[$v['state']];
					}
				}
				
			}
		}
		$num=$this->obj->DB_select_num("fav_job","`uid`='".$this->uid."'");
		$this->obj->DB_update_all("member_statis","fav_jobnum='".$num."'","`uid`='".$this->uid."'");
		$this->yunset("rows",$rows);
		$this->user_tpl('favorite');
	}
	function del_action(){		
		if($_GET['del']||$_GET['id']){
			if(is_array($_GET['del'])){				
				$del=pylode(",",$_GET['del']);
				$layer_type=1;
			}else{
				$del=(int)$_GET['id'];
				$layer_type=0;
			}
			$nid=$this->obj->DB_delete_all("fav_job","`id` in (".$del.") and `uid`='".$this->uid."'","");
			
			if($nid){
				$historyM = $this->MODEL('history');
				$favjob  = $historyM->favjobHistory($this->uid);
				if($this->config['sy_web_site']=="1"){
					if($this->config['sy_onedomain']!=""){
						$weburl=get_domain($this->config['sy_onedomain']);
					}elseif($this->config['sy_indexdomain']!=""){
						$weburl=get_domain($this->config['sy_indexdomain']);
					}else{
						$weburl=get_domain($this->config['sy_weburl']);
					}
					SetCookie("favjob",$favjob,time() + 86400,"/",$weburl);
				}else{
					SetCookie("favjob",$favjob,time() + 86400,"/");
				}
				$fnum=$this->obj->DB_select_num("fav_job","`uid`='".$this->uid."'","`id`");
				$this->obj->update_once('member_statis',array('fav_jobnum'=>$fnum),array('uid'=>$this->uid));
				$this->obj->member_log("删除收藏的职位信息",5,3);
				$this->layer_msg('删除成功！',9,$layer_type,"index.php?c=favorite");
			}			
		}
	}
}
?>