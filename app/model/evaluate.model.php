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
class evaluate_model extends model{ 
    
	function GetExamList($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){ 
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_all('evaluate_group',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	} 
	
	function GetExamBaseInfo($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_once('evaluate_group',$WhereStr,$FormatOptions['field']);
	}
	
	function GetQuestions($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		return $this->DB_select_all('evaluate',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);	
	}
	
	function UpdateExamBaseInfo($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('evaluate_group',$ValuesStr,$WhereStr);
	}
	
	function GetGradeOne($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		return $this->DB_select_once('evaluate_log',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);	
	}
	
	function GetGrade($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		$rows=$this->DB_select_all('evaluate_log',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);	
		$uid=array();
		foreach($rows as $key=>$val){
			$uid[]=$val['uid'];
		}  
		$member=$this->DB_select_all('member','uid in('.pylode(',',$uid).')','uid,username');
		$user=$this->DB_select_all('resume',"`uid` in(".pylode(',',$uid).")","`photo`,`uid`");
		$com=$this->DB_select_all('company',"`uid` in(".pylode(',',$uid).")","`logo`,`uid`");
		foreach($rows as $k=>$val){
			foreach($member as $v){
				if($v['uid']==$val['uid']){
					$rows[$k]['nickname']=$v['username'];
				}
			}
			foreach($user as $v){
				if($v['uid']==$val['uid']){
					if($v['photo']&&file_exists(str_replace($this->config['sy_weburl'],APP_PATH,'.'.$v['photo']))){
						$rows[$k]['pic']='.'.$v['photo'];
					}else{
						$rows[$k]['pic']=$this->config['sy_weburl'].'/'.$this->config['sy_friend_icon'];
					}
				}
			}
			foreach($com as $v){
				if($v['uid']==$val['uid']){
					if($v['logo']&&file_exists(str_replace($this->config['sy_weburl'],APP_PATH,'.'.$v['logo']))){
						$rows[$k]['pic']='.'.$v['logo'];
					}else{
						$rows[$k]['pic']=$this->config['sy_weburl'].'/'.$this->config['sy_friend_icon'];
					}
				}
			}
		}
		return $rows;
	}
	
	function SaveGrade($Values=array(),$Where=array()){ 
		$ValuesStr=$this->FormatValues($Values); 
		if($Where){
			$WhereStr=$this->FormatWhere($Where);
			return $this->DB_update_all('evaluate_log',$ValuesStr,$WhereStr);
		}else{ 
			return $this->insert_into('evaluate_log',$Values);
		}
	}
	
	function SaveMessage($Values=array()){ 
		$nid=$this->insert_into('evaluate_leave_message',$Values);
		if($nid&&$Values['examid']){
			$this->DB_update_all("evaluate_group","`comnum`=`comnum`+'1'","`id`='".$Values['examid']."'");
		}
		return $nid;
	}
	
	function GetGradeRank($Where){
		return $this->DB_select_num('evaluate_log',$Where);
	}
	
	function SaveLeaveMessage($Values){ 
		$ValuesStr=$this->FormatValues($Values); 
		return $this->DB_insert_once('evaluate_leave_message',$ValuesStr);
	} 
	
	
	function GetLeaveMessageList($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);  
		$rows=$this->DB_select_all('evaluate_leave_message',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	    $uid=array();
		foreach($rows as $key=>$val){
			$uid[]=$val['uid'];
			$rows[$key]['pic']=$this->config['sy_weburl'].'/'.$this->config['sy_friend_icon'];
		}
		
		
		return $rows;
	} 
	
	
	function GetUserBaseInfo($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        return $this->DB_select_once('resume',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	} 
}
?>