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
class news_controller extends common{
	function addnews_action(){
		include(APP_PATH."data/api/locoy/locoy_config.php");
		if($locoyinfo['locoy_online']!=1){
			echo 4;die;
		}
		if($locoyinfo['locoy_key']!=trim($_GET['key'])){
			echo 5;die;
		}
        if(!$_POST['title'] || !$_POST['content'] || !$_POST['nid']){
			echo 2;die;
		}
		$row=$this->obj->DB_select_once("news_base","`title`='".trim($_POST['title'])."' and `nid`='".$_POST['nid']."'");
		if(is_array($row)){
			echo 3;die;
		}
		$content=$_POST['content'];
		
		$value="";
        $value.="`title`='".trim($_POST['title'])."',";
		$value.="`nid`='".$_POST['nid']."',";
		$value.="`did`='0',";
		$value.="`author`='".$_POST['author']."',";
		$description=mb_substr(strip_tags(html_entity_decode($content,ENT_NOQUOTES,"GB2312")),0,180,"gbk");
		$description=$_POST['description']?$_POST['description']:$description;
		$description=str_replace(array(' ',"\n","\r","\r\n"," "),array(''),$description);
		$value.="`description`='".$description."',";
		$value.="`source`='".$_POST['source']."'";
		if($_POST['ctime']){
			$value.=",`datetime`='".strtotime($_POST['ctime'])."'";
		}else{
			$value.=",`datetime`='".time()."'";
		}
		if($_POST['hits']){
			$value.=",`hits`='".trim($_POST['hits'])."'";
		}else{
			$row=explode('-',$locoyinfo['locoy_rand']);
			if(is_array($row)){
				$rand=rand(trim($row[0]),trim($row[1]));
			}else{
				$rand=!trim($row)?0:$row;
			}
			$value.=",`hits`='".$rand."'";
		}
		if($_POST['sort']){
			$value.=",`sort`='".trim($_POST['sort'])."'";
		}else{
			$row=explode('-',$locoyinfo['locoy_sort']);
			if(is_array($row)){
				$rand=rand(trim($row[0]),trim($row[1]));
			}else{
				$rand=!trim($row)?0:$row;
			}
			$value.=",`sort`='".$rand."'";
		}
		if($_POST['newsphoto']){
			$value.=",`newsphoto`='".trim($_POST['newsphoto'])."'";
		}
		if($_POST['s_thumb']){
			$value.=",`s_thumb`='".trim($_POST['s_thumb'])."'";
		}
       if(!$_POST['keyword'] && $locoyinfo['locoy_keyword']==1){
			require(LIB_PATH."lib_splitword_class.php");
			$sp = new SplitWord();
			$keywordarr=$sp->getkeyword(strip_tags(html_entity_decode($content)));
			$value.=",`keyword`='".strip_tags(@implode(",",$keywordarr))."'";
		}elseif($_POST['keyword']){
			$value.=",`keyword`='".str_replace("，",",",$_POST['keyword'])."'";
		}
     	$new_base = $this->obj->DB_insert_once("news_base",$value);
        $news_content = $this->obj->DB_insert_once("news_content", "`nbid`='$new_base',`content`='".html_entity_decode($content,ENT_NOQUOTES,"GB2312")."'");
		if($new_base){
			echo 1;die;
		}else{
			echo 0;die;	
		}
	}
}
?>