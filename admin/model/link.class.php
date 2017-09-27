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
class link_controller extends common{
	function set_search(){
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		if($this->config["sy_web_site"]=='1'){
		    include(PLUS_PATH."domain_cache.php");
		    $domain=array();
		    foreach($site_domain as $val){
		        $domain[$val['id']]=$val['cityname'];
		    }
		    $search_list[]=array("param"=>"did","name"=>'显示站点',"value"=>$domain);
		}
		$search_list[]=array("param"=>"link","name"=>'发布时间',"value"=>$lo_time);	
		$search_list[]=array("param"=>"type","name"=>'类型',"value"=>array("1"=>"文字链接","2"=>"图片链接"));
		$search_list[]=array("param"=>"state","name"=>'审核状态',"value"=>array("1"=>"已审核","2"=>"未审核"));
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		extract($_GET);
		$where=1;
		if($state=='1'){
			$where.=" and `link_state`='1'";
			$urlarr['state']='1';
		}elseif($state=='2'){
			$urlarr['state']='2';
			$where.=" and `link_state`='0'";
		}
		if($type=='1'){
			$where.=" and `link_type`='1'";
			$urlarr['type']='1';
		}elseif($type=='2'){
			$urlarr['type']='2';
			$where.=" and `link_type`='2'";
		}
		if($_GET['did']){
			$urlarr['did']=$_GET['did'];
			$where.=" and `did`='".$_GET['did']."'";
		}
		if($_GET['link']){
			if($_GET['link']=='1'){
				$where.=" and `link_time` >='".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `link_time`>'".strtotime('-'.intval($_GET['link']).' day')."'";
			}
			$urlarr['link']=$_GET['link'];
		}
		if($_GET['news_search']!=''){
			if ($_GET['type']=='1'){
				$where.=" and `link_name` like '%".trim($_GET['keyword'])."%' and `link_type`='1'";
			}elseif ($_GET['type']=='2'){
				$where.=" and `link_name` like '%".trim($_GET['keyword'])."%' and `link_type`='2'";
			}else{
			    $where.=" and `link_name` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['news_search']=$_GET['news_search'];
		}

		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by link_state asc,link_time desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$linkrows=$this->get_page("admin_link",$where,$pageurl,$this->config['sy_listnum']);
		$Domain = $this->obj->DB_select_all("domain","`type`='1'");
		foreach($linkrows as $key=>$value){
			if($value['did']<1){
				$userrows[$key]['did'] = 0;
			}
		}
		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);
		$this->yunset("get_type", $_GET);
		$this->yunset("linkrows",$linkrows);
		$this->yuntpl(array('admin/admin_link_list'));
	}

	function add_action(){
		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);
		if($_GET['id']){
			$info=$this->obj->DB_select_once("admin_link","id='".$_GET['id']."'"); 
			$this->yunset("info",$info);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
		}
		$this->yuntpl(array('admin/admin_link_add'));
	}
	function del_action(){
		if(is_array($_POST['del'])){
			$linkid=@implode(',',$_POST['del']);
			$layer_type=1;
		}else{
			$this->check_token();
			$linkid=$_GET['id'];
			$layer_type=0;
		}
		$row=$this->obj->DB_select_all("admin_link","`id` in (".$linkid.") and `pic`<>''");
		if(is_array($row)){
			foreach($row as $v){
				unlink_pic("../".$v['pic']);
			}
		}
		$delid=$this->obj->DB_delete_all("admin_link","`id` in (".$linkid.")","");
		$this->get_cache();
		$delid?$this->layer_msg('友情连接(ID:'.$linkid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
	function status_action(){
		extract($_POST);
		if($yesid){
		$update=$this->obj->DB_update_all("admin_link","`link_state`='".$status."'","id='".$yesid."'");
		$this->get_cache();
 		$update?$this->ACT_layer_msg("友情链接审核成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("友情链接审核失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function save_action(){
		extract($_POST);
		$upload=$this->upload_pic("../data/upload/link/","22");
		if($link_add){
			if(preg_match("/[^\d-., ]/",$sorting)){
				$this->ACT_layer_msg("请正确填写，排序是数字！",8,$_SERVER['HTTP_REFERER']);
			}else{
				if($sorting=="")
				{
					$sorting="0";
				}
				if($phototype==""){
					$phototype="0";
				}

				$value.="`did`='$did',";
				$value.="`link_name`='".trim($title)."',";
				$value.="`link_url`='$url',";
				$value.="`link_type`='$type',";
				$value.="`tem_type`='$tem_type',";
				$value.="`img_type`='$phototype',";
				$value.="`link_sorting`='$sorting',";
				$value.="`link_state`='1',";
				$value.="`link_time`='".mktime()."'";

				if($phototype==1){
					$pictures=$upload->picture($_FILES['uplocadpic']);
					$value.=",`pic`='".str_replace("../","",$pictures)."'";
				}else{
					$value.=",`pic`='".$uplocadpic."'";
				}
				$nbid=$this->obj->DB_insert_once("admin_link",$value);
				$this->get_cache();
 				isset($nbid)?$this->ACT_layer_msg("友情连接(ID:".$nbid.")添加成功！",9,"index.php?m=link",2,1):$this->ACT_layer_msg("添加失败！",8,"index.php?m=link");
			}
		}

		if($link_update){

			$value.="`did`='$did',";
			$value.="`link_name`='".trim($title)."',";
			$value.="`link_url`='$url',";
			$value.="`link_type`='$type',";
			$value.="`tem_type`='$tem_type',";
			$value.="`img_type`='$phototype',";
			$value.="`link_sorting`='$sorting',";
			$value.="`link_state`='1'";
			if($phototype==1){
				if($_FILES['uplocadpic']['tmp_name']!=""){
					$pictures=$upload->picture($_FILES['uplocadpic']);
					$value.=",`pic`='".str_replace("../","",$pictures)."'";
					$row=$this->obj->DB_select_once("admin_link","`id`='$id' and `pic`!=''");
					if(is_array($row)){
						unlink_pic("../".$row["pic"]);
					}
				}
			}else{
				$value.=",`pic`='".$uplocadpic."'";
			}
			$nbid=$this->obj->DB_update_all("admin_link",$value,"`id`='$id'");
			$lasturl=str_replace("&amp;","&",$lasturl);
			$this->get_cache();
			isset($nbid)?$this->ACT_layer_msg("友情连接(ID:".$id.")修改成功！",9,$lasturl,2,1):$this->ACT_layer_msg("修改失败！",8,$lasturl);
		}

	}
	function get_cache(){
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->link_cache("link.cache.php");
	}

	function checksitedid_action(){
		if($_POST['uid']){
			$ids=@explode(',',$_POST['uid']);
			$id = pylode(',',$ids);
			if($id){
				$siteDomain = $this->MODEL('site');
				$Table = array('admin_link');
				$siteDomain->UpDid($Table,$_POST['did'],"`id` IN (".$id.")");
				$this->get_cache();
				$this->ACT_layer_msg( "友情链接(ID:".$_POST['uid'].")分配站点成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("请正确选择需分配用户！",8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg( "参数不全请重试！",8,$_SERVER['HTTP_REFERER']);
		}
	}
}

?>