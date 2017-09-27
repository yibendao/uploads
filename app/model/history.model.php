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
class history_model extends model{
	
	function lookJobHistory($uid){
       $uid = intval($uid);
	   if($uid>0){
	    $List =  $this->DB_select_all('look_job',"`uid` = '".$uid."' AND `datetime`>=".(time()-7*86400),"`jobid`");

		   if(is_array($List) && !empty($List)){
		   
				foreach($List as $value){
				
					$historyList[] = $value['jobid'];
				}
				return pylode(',',$historyList);
		   }
	   
	   }
      return 'N';
    }


	function favJobHistory($uid){
       $uid = intval($uid);
	   if($uid>0){
	    $List =  $this->DB_select_all('fav_job',"`uid` = '".$uid."' AND `datetime`>=".(time()-7*86400),"`job_id`");

		   if(is_array($List) && !empty($List)){
		   
				foreach($List as $value){
				
					$historyList[] = $value['job_id'];
				}
				return pylode(',',$historyList);
		   }
	   
	   }
	   return 'N';
      
    }

	function useridJobHistory($uid){
       $uid = intval($uid);
	   if($uid>0){
	    $List =  $this->DB_select_all('userid_job',"`uid` = '".$uid."' AND `datetime`>=".(time()-7*86400),"`job_id`");


		   if(is_array($List) && !empty($List)){
		   
				foreach($List as $value){
				
					$historyList[] = $value['job_id'];
				}
				return pylode(',',$historyList);
		   }
	   
	   }
	   return 'N';
      
    }

	function talentPoolHistory($uid){
       $uid = intval($uid);
	   if($uid>0){
	    $List =  $this->DB_select_all('talent_pool',"`cuid` = '".$uid."' AND `ctime`>=".(time()-7*86400),"`eid`");

		   if(is_array($List) && !empty($List)){
		   
				foreach($List as $value){
				
					$historyList[] = $value['eid'];
				}
				return pylode(',',$historyList);
		   }
	   }
	   return 'N';
      
    }
	function lookResumeHistory($uid){
       $uid = intval($uid);
	   if($uid>0){
	
	    $List =  $this->DB_select_all('look_resume',"`com_id` = '".$uid."'  AND `datetime`>=".(time()-7*86400),"`resume_id`");
		
		   if(is_array($List) && !empty($List)){
		   
				foreach($List as $value){
				
					$historyList[] = $value['resume_id'];
				}
				return pylode(',',$historyList);
		   }
			
	   }
      return 'N';
    }

	function useridmsgHistory($uid){
       $uid = intval($uid);
	   if($uid>0){
	    $List =  $this->DB_select_all('userid_msg',"`fid` = '".$uid."' AND `datetime`>=".(time()-7*86400),"`uid`");
		
		   if(is_array($List) && !empty($List)){
		   
				foreach($List as $value){
				
					$historyList[] = $value['uid'];
				}
				return pylode(',',$historyList);
		   }
	   }
	   return 'N';
    }

	function addHistory($name,$value){
		global $config;
		if($config['sy_onedomain']!=""){
			$weburl=get_domain($this->config['sy_onedomain']);
		}elseif($config['sy_indexdomain']!=""){
			$weburl=get_domain($this->config['sy_indexdomain']);
		}else{
			$weburl=get_domain($this->config['sy_weburl']);
		}
		if($_COOKIE[$name])
		{
			$Arr = explode(',',$_COOKIE[$name]);
		}
		$Arr[] = $value;
		if($this->config['sy_web_site']=="1"){
			SetCookie($name,@implode(',',$Arr),time() + 86400,"/",$weburl);
		}else{
			SetCookie($name,@implode(',',$Arr),time() + 86400,"/");
		}
	}
	
}
?>