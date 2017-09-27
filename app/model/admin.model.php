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
class admin_model extends model{
	function GetPurview(){ 
		if($this->config['did']){
			$nav_user=$this->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION["auid"]."' and a.`did`='".$this->config['did']."'");
		}else{
			$nav_user=$this->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION["auid"]."'");
		}		 
		return $power=unserialize($nav_user[0]["group_power"]); 
	}
	function InsertInfo($table,$Values=array()){
		return $this->insert_into($table,$Values);
	} 
	function UpdateHotJob($Values=array(),$Where=array()){ 
		$WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('hotjob',$ValuesStr,$WhereStr);
    }
	function DeleteHotJob($Where=array()){ 
		$WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('hotjob',$WhereStr,"");
    }
	function DelUsers($tables=array(),$uids,$usertype=''){  
		$uidnum=count(@explode(',',$uids));
		if($uidnum=1){ 
			if($tables&&is_array($tables)){
				foreach($tables as $val){
					$this->DB_delete_all($val,"`uid`='".$uids."'","");
				} 
			}
		}else if($uidnum>1){
			if($tables&&is_array($tables)){
				foreach($tables as $val){
					$this->DB_delete_all($val,"`uid` in(".$uids.")","");
				} 
			}	
		} 
		if($usertype=='2'){
			if($uidnum=1){
				$this->DB_delete_all("down_resume","`comid`='".$uids."'","");
				$this->DB_delete_all("part_apply","`comid`='".$uids."'","");
				$this->DB_delete_all("part_collect","`comid`='".$uids."'",""); 
				$this->DB_delete_all("email_msg","`uid`='".$uids."' or `cuid`='".$uids."'"," "); 
				$this->DB_delete_all("company_msg","`cuid`='".$uids."'"," ");
				$this->DB_delete_all("talent_pool","`cuid`='".$uids."'"," ");
				$this->DB_delete_all("user_entrust_record","`comid`='".$uids."'"," ");
				$this->DB_delete_all("ad_order","`comid`='".$uids."'"," "); 
				$this->DB_delete_all("company_pay","`com_id`='".$uids."'"," ");
				$this->DB_delete_all("atn","`uid`='".$uids."' or `scid`='".$uids."'","");
				$this->DB_delete_all("look_resume","`com_id`='".$uids."'","");
				$this->DB_delete_all("look_job","`com_id`='".$uids."'","");
				$this->DB_delete_all("fav_job","`com_id`='".$uids."'","");
				$this->DB_delete_all("userid_msg","`fid`='".$uids."'","");
				$this->DB_delete_all("userid_job","`com_id`='".$uids."'","");
				$this->DB_delete_all("message","`fa_uid`='".$uids."'","");
				$this->DB_delete_all("msg","`job_uid`='".$uids."'","");
				$this->DB_delete_all("blacklist","`c_uid`='".$uids."'"," ");
				$this->DB_delete_all("rebates","`job_uid`='".$uids."' or `uid` ='".$uids."'"," ");
				$this->DB_delete_all("report","`p_uid`='".$uids."' or `c_uid`='".$uids."'"," ");
				$this->DB_delete_all("member_log","`uid`='".$uids.""," ");
			}else if($uidnum>1){
				$this->DB_delete_all("part_apply","`comid` in (".$uids.")","");
				$this->DB_delete_all("part_collect","`comid` in (".$uids.")",""); 
				$this->DB_delete_all("email_msg","`uid` in (".$uids.") or `cuid` in (".$uids.")"," ");
				$this->DB_delete_all("talent_pool","`cuid` in (".$uids.")"," ");
				$this->DB_delete_all("user_entrust_record","`comid` in (".$uids.")"," ");
				$this->DB_delete_all("ad_order","`comid` in (".$uids.")"," ");
				$this->DB_delete_all("company_pay","`com_id` in (".$uids.")"," ");
				$this->DB_delete_all("atn","`uid` in (".$uids.") or `scid` in (".$uids.")","");
				$this->DB_delete_all("look_resume","`com_id` in (".$uids.")","");
				$this->DB_delete_all("fav_job","`com_id` in (".$uids.")","");
				$this->DB_delete_all("userid_msg","`fid` in (".$uids.")","");
				$this->DB_delete_all("userid_job","`com_id` in (".$uids.")","");
				$this->DB_delete_all("look_job","`com_id` in (".$uids.")","");
				$this->DB_delete_all("message","`fa_uid` in (".$uids.")","");
				$this->DB_delete_all("msg","`job_uid` in (".$uids.")","");
				$this->DB_delete_all("blacklist","`c_uid` in (".$uids.")","");
				$this->DB_delete_all("rebates","`job_uid` in (".$uids.") or `uid` in (".$uids.")"," ");
				$this->DB_delete_all("report","`p_uid` in ($uids) or `c_uid` in ($uids)","");
				$this->DB_delete_all("member_log","`uid` in ($uids)","");
			}
			
		}
	}
	
}
?>