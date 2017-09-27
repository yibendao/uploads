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
class job_model extends model{
    function GetFinderNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('finder',$WhereStr);
    }
    function GetBlackOne($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('blacklist',$WhereStr,$FormatOptions['field']);
    }
    function GetBlackList($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('blacklist',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetComjobOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_job',$WhereStr,$FormatOptions['field']);
    }
    function GetComjoblinkOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_job_link',$WhereStr,$FormatOptions['field']);
    }
	 function GetComjoblinkAll($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('company_job_link',$WhereStr.$FormatOptions['order'],$FormatOptions['field'],$FormatOptions['special']);
    }
	
    function GetComjobList($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        return $this->DB_select_all('company_job',$WhereStr.$FormatOptions['order'],$FormatOptions['field'],$FormatOptions['special']);
    }
	function DeleteReport($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('report',$WhereStr);
    }
	function DelJob($jobids){
		$this->DB_delete_all("company_job","`id` in (".$jobids.")","");
		$this->DB_delete_all("company_job_link","`jobid` in (".$jobids.")","");
		$this->DB_delete_all("user_entrust_record","`jobid` in (".$jobids.")",""); 
		$this->DB_delete_all("userid_msg","`jobid` in (".$jobids.")",""); 
		$this->DB_delete_all("userid_job","`job_id` in (".$jobids.")",""); 
		$this->DB_delete_all("fav_job","`job_id` in (".$jobids.")","");
		$this->DB_delete_all("look_job","`jobid` in (".$jobids.")","");
		$this->DB_delete_all("report","`usertype`=1 and `type`=0 and `eid` in (".$jobids.")","");
		$this->DB_delete_all("fav_job","`job_id` in (".$jobids.")",""); 
	}
    function GetComjobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('company_job',$WhereStr);
    }
    function UpdateComjob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('company_job',$ValuesStr,$WhereStr);
    }
	function AddCompanyJob($Values=array()){
        return $this->insert_into('company_job',$Values);
    }
    
    function GetUserJobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('userid_job',$WhereStr);
    }
    function GetComMsgNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $num=$this->DB_select_num('company_msg',$WhereStr);
		if($num<1){
			$num=0;
		}
		return $num;
    }

	
    function GetApplyList($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        return $this->DB_select_all('userid_job',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }

    

    function GetLookJobList($Where=array(),$Options=array('field'=>null)){
    	$WhereStr=$this->FormatWhere($Where);
    	$FormatOptions=$this->FormatOptions($Options);
    	return $this->DB_select_all('look_job',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetLookJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('look_job',$WhereStr,$FormatOptions['field']);
    }
    function AddLookJob($Values=array()){
        return $this->insert_into('look_job',$Values);
    }
    function UpdateLookJob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('look_job',$ValuesStr,$WhereStr);
    }
	function DeleteLookJob($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('look_job',$WhereStr);
    }
    function GetUseridJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('userid_job',$WhereStr,$FormatOptions['field']);
    }
    function GetUseridJob($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('userid_job',$WhereStr,$FormatOptions['field']);
    }
    function GetUseridMsgOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('userid_msg',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    
    function AddUseridJob($Values=array()){
		$Values['did']=$this->userdid;
        return $this->insert_into('userid_job',$Values);
    }
    function GetFavJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('fav_job',$WhereStr,$FormatOptions['field']);
    }
    
    function AddFavJob($Values=array()){
        return $this->insert_into('fav_job',$Values);
    }
   
    function AddCompanyShow($Values=array()){
        return $this->insert_into('company_show',$Values);
    }
 
    function AddMsg($Values=array()){
        return $this->insert_into('msg',$Values);
    }
}
?>