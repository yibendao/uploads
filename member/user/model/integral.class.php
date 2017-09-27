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
class integral_controller extends user{
	function index_action(){
		$this->public_action();
		$baseInfo			= false;	
		$photo				= false;	
		$emailChecked		= false;	
		$phoneChecked		= false;	
		$question        	=false;		
		$answer       		=false;		
		$answerpl           =false;		
		$identification		= false;	
		
		$row = $this->obj->DB_select_once("resume",'`uid` = '.$this->uid,
			"`name`,`sex`,`birthday`,`telphone`,`email`,`edu`,`exp`,`living`,
			`photo`,`email_status`,`moblie_status`,`idcard_status`");
		
		if(is_array($row) && !empty($row)){
			if($row['name'] != '' && $row['sex'] != '' && $row['birthday'] != '' && $row['telphone'] != '' 
				&& $row['email'] != '' && $row['edu'] != '' && $row['exp'] != '' && $row['living'] != '')
				$baseInfo = true;
			
			if($row['photo'] != '') $photo = true;
			if($row['email_status'] != 0) $emailChecked = true;
			if($row['moblie_status'] != 0) $phoneChecked = true;
			if($row['idcard_status'] != 0) $identification = true;
		}
		if($this->config['integral_question_type']=="1"){
			$question=$this->max_time('发布问题');
		}
		if($this->config['integral_answer_type']=="1"){
			$answer=$this->max_time('回答问题');
		}
		if($this->config['integral_answerpl_type']=="1"){
			$answerpl=$this->max_time('评论问答');
			
		}
		
		$statusList = array(
			'baseInfo'		=>$baseInfo,
			'photo'			=>$photo,
			'emailChecked'	=>$emailChecked,
			'phoneChecked'	=>$phoneChecked,
			'question'	    =>$question,
			'answer'	    =>$answer,
			'answerpl'	    =>$answerpl,
			'identification'=>$identification
		); 
		$expectnum=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
		$this->yunset("expectnum",$expectnum);
		$this->yunset("statusList",$statusList);
		$this->user_tpl('integral');
	}
	
}
?>