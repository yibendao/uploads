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
class description_controller extends common{
	function index_action(){
		$where=1;
		if($_GET['order']){
			if($_GET['order']=="desc"){
				$order=" order by `".$_GET['t']."` desc";
			}else{
				$order=" order by `".$_GET['t']."` asc";
			}
		}else{
			$order=" order by `id` desc";
		} 
		if ($_GET['is_type']!=""){
		    $where.=" and `is_type`='".$_GET['is_type']."'";
		    $urlarr['is_type']=$_GET['is_type'];
		}
		if (trim($_GET['keyword'])){
		    $where.=" and `name` like '%".trim($_GET['keyword'])."%'";
		    $urlarr['keyword']=$_GET['keyword'];
		}
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$descrows=$this->get_page("description",$where.$order,$pageurl,$this->config['sy_listnum']);
		$this->yunset("descrows",$descrows);
		$is_type=array('0'=>'外部链接','1'=>'自定义页面','2'=>'站内链接');
		$this->yunset('is_type',$is_type);
		$this->yuntpl(array('admin/admin_description'));
	}
	function add_action(){
		if($_GET['id']){
			$descrow=$this->obj->DB_select_once("description","`id`='".$_GET['id']."'");
		}else{
			$descrow['sort']=rand(1,50);
		}
		$this->yunset('lasturl',$_SERVER['HTTP_REFERER']);
		$this->yunset("descrow",$descrow);
		$class=$this->obj->DB_select_all("desc_class");
		$this->yunset("class",$class);
		$this->yuntpl(array('admin/admin_description_add'));
	}
	function save_action(){
	    $_POST=$this->post_trim($_POST);
		extract($_POST);
		$value="`name`='".$name."',";
		if($url && $is_type==1){
			$url = stripslashes($url);
			$url = str_replace("../","",$url);
			$url = str_replace("./","",$url);
			$p_delfiles = path_tidy($url);
			if($p_delfiles!=$url){
				$this->ACT_layer_msg("无效的文件名！",8,$_SERVER['HTTP_REFERER']);
			}
			$urlArr = explode('/',$url);
			foreach($urlArr as $v){
				if(!preg_match("/^[".chr(0xa1)."-".chr(0xff)." |a-z|0-9|A-Z|\@\.\_\]\[\!]+$/",$v) && $v!='') {

					$this->ACT_layer_msg("无效的文件名！",8,$_SERVER['HTTP_REFERER']);
				}
			}
			$urlarr=explode(".",$url);
			if(end($urlarr)!="html"){
				$this->ACT_layer_msg("请正确填写静态网页名称！",8,$_SERVER['HTTP_REFERER']);
			}
			if(substr($url,0,1)=="/"){
				$url=substr($url,1);
			}
		}
		$value.="`nid`='$nid',";
		$value.="`url`='$url',";
		$value.="`title`='$title',";
		$value.="`keyword`='$keyword',";
		$value.="`descs`='$description',";
		$value.="`top_tpl`='$top_tpl',";
		$value.="`top_tpl_dir`='$top_tpl_dir',";
		$value.="`footer_tpl`='$footer_tpl',";
		$value.="`footer_tpl_dir`='$footer_tpl_dir',";
		$value.="`ctime`='".mktime()."',";
		$value.="`sort`='$sort',";
		$value.="`is_nav`='$is_nav',";
		$value.="`is_type`='$is_type',";
		$content = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',''),html_entity_decode($_POST["content"],ENT_QUOTES,"GB2312"));
		$value.="`content`='".$content."'";
		if(!$id){
			$descid=$this->obj->DB_insert_once("description",$value);
			$ids=$descid;
			$alert="添加";
		}else{
			$row=$this->obj->DB_select_once("description","`id`='$id'");
			if($row['is_menu']=="1"){
				$url = str_replace("amp;","",$url);
				$values="`url`='".$url."',";
				$values.="`furl`='".$url."',";
				$values.="`name`='".$name."'";
				$this->obj->DB_update_all("navigation",$values,"`desc`='".$id."'");
				$this->menu_cache_action();
			}
			$descid=$this->obj->DB_update_all("description",$value,"`id`='$id'");
			$ids=$id;
			$alert="更新";
		}
		if($descid){
			$this->cache_action();
			if($is_type==1){
                $this->descriptionshow($ids,$url);
			}
			$this->ACT_layer_msg("单页面(ID:".$ids.")".$alert."成功！",9,$lasturl,2,1);
		}else{
			$this->ACT_layer_msg($alert."失败！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function del_action(){
		if(is_array($_POST['del'])){
			$linkid=@implode(',',$_POST['del']);
			foreach($del as $key=>$value){
				$info = $this->obj->DB_select_once("description","`id`='$value'");
				$filename = $info["url"];
				if(file_exists($filename)){
					@unlink($filename);
				}
				$info = "";
			}
			$layer_type='1';
		}else{
			$this->check_token();
			$linkid=$_GET["id"];
			$info = $this->obj->DB_select_once("description","`id`='$linkid'");
			$filename = APP_PATH."/".$info["url"];
			if(file_exists($filename)){
				@unlink($filename);
			}
			$layer_type='0';
		}

		$this->obj->DB_delete_all("navigation","`desc` in (".$linkid.")","");
		$delid=$this->obj->DB_delete_all("description","`id` in ($linkid)","");
		$this->menu_cache_action();
		$this->cache_action();
		$delid?$this->layer_msg('独立页面(ID:'.$linkid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

	function make_action(){
		extract($_GET);
		if($id){
			$where="`id`='$id'";
		}else{
			$where="1 and is_type=1";
		}
		$this->cache_action();
		$rows=$this->obj->DB_select_all("description",$where);
		if(@is_array($rows)){
			foreach($rows as $row){
                $fw=$this->descriptionshow($row['id'],$row["url"]);
			}
		}
 		$fw?$this->layer_msg("单页面生成成功！",9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg("生成失败！",8,0,$_SERVER['HTTP_REFERER']);
	}
	function ajax_menu_action()
	{
		if($_POST['id'])
		{
			$row=$this->obj->DB_select_once("description","`id`='".$_POST['id']."'");
			if($row['is_menu']=="1")
			{
				$info=$this->obj->DB_select_once("navigation","`desc`='".$_POST['id']."'");
				$arr['id']=$info['id'];
				$arr['nid']=$info['nid'];
				$arr['name']=iconv("gbk","utf-8",$info['name']);
				$arr['color']=$info['color'];
				$arr['url']=$info['url'];
				$arr['furl']=$info['furl'];
				$arr['type']=$info['type'];
				$arr['sort']=$info['sort'];
				$arr['eject']=$info['eject'];
				$arr['model']=$info['model'];
				$arr['bold']=$info['bold'];
				$arr['display']=$info['display'];
			}else{
				$arr['name']=iconv("gbk","utf-8",$row['name']);
				$arr['url']=$row['url'];
				$arr['furl']=$row['url'];
			}
			echo urldecode(json_encode($arr));die;
		}
	}
	function set_menu_action()
	{
	    if($_POST['submit'])
	    {
	    	if($_POST['id'])
	    	{
	    		$where=" and `id`<>'".$_POST['id']."'";
	    	}
	    	$row=$this->obj->DB_select_once("navigation","name='".$_POST['name']."' and `nid`='".$_POST['nid']."'".$where);
	    	if(!is_array($row))
	    	{
				$value="`nid`='".$_POST['nid']."',";
				$value.="`eject`='".$_POST['eject']."',";
				$value.="`display`='".$_POST['display']."',";
				$value.="`name`='".$_POST['name']."',";
				$url = str_replace("amp;","",$_POST['url']);
				$value.="`url`='".$url."',";
				$value.="`furl`='".$_POST['furl']."',";
				$value.="`sort`='".$_POST['sort']."',";
				$value.="`color`='".$_POST['color']."',";
				$value.="`model`='".$_POST['model']."',";
				$value.="`bold`='".$_POST['bold']."',";
				$value.="`type`='".$_POST['type']."'";
				if($_POST['id'])
				{
					$nbid=$this->obj->DB_update_all("navigation",$value,"`id`='".$_POST['id']."'");
					$msg="更新独立页面设置导航";
				}else{
					$value.=",`desc`='".$_POST['did']."'";
					$nbid=$this->obj->DB_insert_once("navigation",$value);
					$this->obj->DB_update_all("description","`is_menu`='1'","`id`='".$_POST['did']."'");
					$msg="添加独立页面设置导航";
				}
				$this->menu_cache_action();
				isset($nbid)?$this->ACT_layer_msg( $msg."成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg( $msg."失败！",8,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->ACT_layer_msg( "已经存在此导航！",8,$_SERVER['HTTP_REFERER']);
	    	}
		}
	}
	function delmenu_action()
	{
		if($_GET['id'])
		{
			$this->check_token();
			$this->obj->DB_update_all("description","`is_menu`='0'","`id`='".$_GET['id']."'");
			$this->obj->DB_delete_all("navigation","`desc`='".$_GET['id']."'");
			$this->menu_cache_action();
			$this->layer_msg("独立页面(ID:".$_GET['id'].")导航取消成功",9,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function menu_cache_action(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->menu_cache("menu.cache.php");
	}
    function descriptionshow($id,$path){
		
		$M=$this->MODEL('index');
		$row=$M->GetDescOne(array("id"=>$id));
		$top="";$footer="";
		if($row['top_tpl']==1){
            $top=APP_PATH."/app/template/".$this->config['style']."/header.htm";
		}else if($row['top_tpl']==3){
            $top=APP_PATH."/app/template/".$row['top_tpl_dir'].".htm";
		}
		if($row['footer_tpl']==1){
            $footer=APP_PATH."/app/template/".$this->config['style']."/footer.htm";
		}else if($row['footer_tpl']==3){
            $footer=APP_PATH."/app/template/".$row['footer_tpl_dir'].".htm";
		}
		$seo['title']=$row['name'];
		$seo['keywords']=$row['keyword'];
		$seo['description']=$row['descs'];
		$this->yunset("seo",$seo);
		$this->yunset("name",$row['name']);
		$this->yunset("content",$row['content']);

		$this->header_desc($row['name']."-".$this->config['sy_webname'],$row['keyword'],$row['descs']);

		$make=APP_PATH."/app/template/".$this->config['style']."/make.htm";
		$make_top=APP_PATH."/app/template/".$this->config['style']."/make_top.htm";

        global $phpyun;

        if($make_top){
            $contect = $phpyun->fetch($make_top,$id);
        }
		
        if($top){
            $contect .= $phpyun->fetch($top,$id);
        }
        if($make){
            $contect .= $phpyun->fetch($make,$id);
        }
        if($footer){
            $contect .= $phpyun->fetch($footer,$id);
        }
        $DirList=explode('/',$path);
        foreach($DirList as $k=>$v){
            $Dir.=$v.'/';
            if(!is_dir(APP_PATH.$Dir)&&!strstr($Dir,'.html')){
                mkdir(APP_PATH.$Dir,0777);
            }
        }
        $fp = fopen(APP_PATH.$path, "w");
        $fw=fwrite($fp, $contect);
        fclose($fp);
		
		return $fw;
	}
	function cache_action(){

		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);

		$makecache=$cacheclass->desc_cache("desc.cache.php");
	}
}
?>