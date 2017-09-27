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
class topic_controller extends ask_controller{  
	function index_action(){
		$M=$this->MODEL('ask');
		$recom=$M->GetQuestionList(array('is_recom'=>'1'),array('field'=>'uid,nickname,pic','limit'=>'8','orderby'=>'add_time'));
		foreach($recom as $k=>$v){
			if($v['pic']){
				$recom[$k]['pic']=$this->config['sy_weburl'].'/'.$v['pic'];
			}else{
				$recom[$k]['pic']=$this->config['sy_weburl'].'/'.$this->config['sy_friend_icon'];
			}
		}
		$this->yunset('recom',$recom);
		$this->yunset("navtype","topic");
		$this->seo("ask_topic");
		$this->ask_tpl('topic');
	}
}
?>