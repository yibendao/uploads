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
class ask_controller extends common{ 
	function ask_tpl($tpl){ 
		$this->yuntpl(array('ask/'.$tpl));
	}
	function  is_login(){
		if($this->uid==""||$this->username==''){
			echo 'no_login';die;
		}
	}
	function atnask($M){
		if($this->uid){ 
			$my_attention=$M->GetAttentionList(array('uid'=>$this->uid,'type'=>1));
			$my_atten=@explode(',',rtrim($my_attention['ids'],",")); 
			$this->yunset("my_atten",$my_atten);			
		} 
	}
	function hotclass(){
		$CacheM=$this->MODEL('cache');
		$CacheList=$CacheM->GetCache(array('ask'));
		$rows=array();
		$i=0;
		foreach($CacheList['ask_name'] as $key=>$val){
			if($i<'10'){
				$rows[$key]=$val;
			}
			$i++; 
		} 
		$this->yunset("hotclass",$rows); 
	}
	function autosearch_action(){
		$M=$this->MODEL('ask');
		$keyword=yun_iconv("utf-8","gbk",trim($_POST['keyword']));
		$rows=$M->GetQuestionList(array("`title` like '%".$keyword."%'"),array("field"=>"`id`,`title`,`answer_num`","orderby"=>'answer_num',"desc"=>'desc',"limit"=>6)); 
		if($rows&&is_array($rows)){
			foreach($rows as $key=>$val){
				$rows[$key]['url']=Url('ask',array("c"=>"content","id"=>$val['id']));
				$rows[$key]['title']=urlencode(str_replace($keyword,"<b>".$keyword."</b>",$val['title']));
			}
		}
		$rows = json_encode($rows);
		echo urldecode($rows);die;
	}
}
?>