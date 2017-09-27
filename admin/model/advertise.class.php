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
class advertise_controller extends common{
	function public_action(){
		include_once("model/model/advertise_class.php");
	}
	function set_search(){
		$search_list[]=array("param"=>"ad","name"=>'广告类型',"value"=>array("1"=>"文字广告","2"=>"图片广告","3"=>"FLASH广告"));
		$search_list[]=array("param"=>"is_check","name"=>'审核状态',"value"=>array("1"=>"已过期","2"=>"已审核" ,"-1"=>"未审核"));
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where = '1';
		if($_GET['is_check']){
			if($_GET['is_check']=='1'){
				$where .=" AND `time_end`<'".date("Y-m-d",time())."'";
				$urlarr['end']=1;
			}
			if($_GET['is_check']=='-1'){
				$where .=" AND `is_check`='0' AND `time_end`>'".date("Y-m-d",time())."' ";
				$urlarr['is_check']=$_GET['is_check'];
			}elseif($_GET['is_check']=='2'){
				$where .=" AND `is_check`='1' AND `time_end`>'".date("Y-m-d",time())."' ";
				$urlarr['is_check']=$_GET['is_check'];
			}

		}
		if($_GET['class_id']){
			$where .=" AND `class_id`='".$_GET['class_id']."'";
			$urlarr['class_id']=$_GET['class_id'];
		}
		if($_GET['name']){
			$where .=" AND `ad_name` LIKE '%".$_GET['name']."%'";
			$urlarr['name']=$_GET['name'];
		}
		if($_GET['ad']){
			if($_GET['ad']=='1'){
                 $where .=" AND `ad_type`='word'";
			}
			if($_GET['ad']=='2'){
                 $where .=" AND `ad_type`='pic'";
			}
			if($_GET['ad']=='3'){
                 $where .=" AND `ad_type`='flash'";
			}
			$urlarr['ad']=$_GET['ad'];
		}
		$where.=" order by `class_id` desc,`id` desc";
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$linkrows=$this->get_page("ad",$where,$pageurl,$this->config['sy_listnum']);
		$class = $this->obj->DB_select_all("ad_class","1 order by `orders` desc");
		$nclass=array();
		if(is_array($class)&&$class){
			foreach($class as $val){
				$nclass[$val['id']]=$val['class_name'];
			}
		}
		$domain= $this->obj->DB_select_all("domain");
		$Dname=array();
		if(is_array($domain)&&$domain){
			foreach($domain as $key=>$val){
				$Dname[$val['id']]=$val['title'];
			}
		}
		if(is_array($linkrows)){
			foreach($linkrows as $key=>$value){
				$start = @strtotime($value['time_start']);
				$end = @strtotime($value['time_end']." 23:59:59");
				$time = time();
				$linkrows[$key]['class_name'] = $nclass[$value['class_id']];
				if($value['did']){
					$linkrows[$key]['d_title'] = $Dname[$value['did']];
				}else{
					$linkrows[$key]['d_title'] ='全站';
				}
				if($value['is_check']=="1"){
					$linkrows[$key]['check']="<font color='green'>已审核</font>";
				}else{
					$linkrows[$key]['check']="<font color='red'>未审核</font>";
				}
				switch($value['ad_type']){
					case "word":$linkrows[$key]['ad_typename'] ="文字广告";
					break;
					case "pic":$linkrows[$key]['ad_typename'] ="<a href=\"javascript:void(0)\" class=\"preview\" url=\"".$value['pic_url']."\">图片广告</a>";
					break;
					case "flash":$linkrows[$key]['ad_typename'] ="FLASH广告";
					break;
					case "lianmeng":$linkrows[$key]['ad_typename'] ="<a href=\"javascript:void(0)\" class=\"preview\" url=\"".$value['lianmeng_url']."\">联盟广告</a>";
					break;
				}
				if($value['time_start']!="" && $start!="" &&($value['time_end']==""||$end!="")){
					if($value['time_end']=="" || $end>$time){
						
						if($value['is_open']=='1'&&$start<$time){
							$linkrows[$key]['type']="<font color='green'>使用中..</font>";
						}else if($start<$time&&$value['is_open']=='0'){
							$linkrows[$key]['type']="<font color='red'>已停用</font>";
						}elseif($start>$time && ($end>$time || $value['time']=="")){
							$linkrows[$key]['type']="<font color='#ff6600'>广告暂未开始</font>";
						}
					}else{
						$linkrows[$key]['type']="<font color='red'>过期广告</font>";
						$linkrows[$key]['is_end']='1';
					}
				}else{
					$linkrows[$key]['type']="<font color='red'>无效广告</font>";
				}
			}
		}
		$ad_time=array('1'=>'一天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
        $this->yunset("ad_time",$ad_time);
		$this->yunset("get_type", $_GET);
		$this->yunset("nclass",$nclass);
		$this->yunset("class",$class);
		$this->yunset("linkrows",$linkrows);
		$this->yuntpl(array('admin/admin_advertise'));
	}
	function ad_add_action() {
		$class = $this->obj->DB_select_all("ad_class","1 order by `orders` desc");

		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);

		if($_GET['id']){
		    $info=$this->obj->DB_select_once("ad","id='".$_GET['id']."'");
		    $class = $this->obj->DB_select_all("ad_class","1 order by `orders` desc");
		    $this->yunset("class",$class);
		    $this->yunset("info",$info);
		    $this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
		}
		$this->yunset("class",$class);
		$this->yuntpl(array('admin/admin_advertise_add'));
	}
	function ad_saveadd_action(){
	 $this->public_action();
	 $adver = new advertise($this->obj,$this);
		if($_FILES['ad_url']['size']>0){
		 	if($_POST['ad_type']=="flash"){
		 		$time = time();
				$flash_name = $time.rand(0,999).".swf";
		 		move_uploaded_file($_FILES['ad_url']['tmp_name'],DATA_PATH."/upload/flash/$flash_name");
		 		$pictures = "../data/upload/flash/".$flash_name;
		 	}else{
		 		$upload = $this->upload_pic("../data/upload/pimg/");
		 		$pictures=$upload->picture($_FILES['ad_url']);
		 	}
		}
		$_POST['target']=$_POST['target']==2?2:1;
		$html = $adver->model_saveadd_action($_POST,$pictures);
	}

	function modify_save_action(){
		$this->public_action();
		$adver = new advertise($this->obj,$this);
		if($_FILES['ad_url']['size']>0){
		 	if($_POST['ad_type']=="flash"){
		 		$time = time();
				$flash_name = $time.rand(0,999).".swf";
		 		move_uploaded_file($_FILES['ad_url']['tmp_name'],DATA_PATH."/upload/flash/".$flash_name);
		 		$pictures = "../data/upload/flash/".$flash_name;
		 	}else{
		 		$upload = $this->upload_pic("../data/upload/pimg/");
		 		$pictures=$upload->picture($_FILES['ad_url']);
		 	}
		}
		$_POST['target']=$_POST['target']==2?2:1;
		$adver->model_modify_save_action($_POST,$pictures);
	}
	function del_ad_action(){
		$this->check_token();
		$this->public_action();
		$adver = new advertise($this->obj);
		if($_GET['id']){
			$ad=$this->obj->DB_select_once("ad","`id`='".$_GET['id']."'");
			if(is_array($ad)){
				unlink_pic($ad['pic_url']);
				@unlink($ad['flash_url']);
				$this->obj->DB_delete_all("ad","`id`='".$_GET['id']."'");
			}
		}
		$adver->model_ad_arr_action();
		$this->layer_msg('广告(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']);
	}

	function ad_preview_action(){
		$ad=$this->obj->DB_select_once("ad","`id`='".$_GET['id']."'");
		if($ad['ad_type']=="word"){
			$ad['html']="<a href='".$ad['word_url']."'>".$ad['word_info']."</a>";
		}else if($ad['ad_type']=='pic'){
			if(@!stripos("ttp://",$ad['pic_url'])){
				$pic_url = str_replace("../",$this->config['sy_weburl']."/",$ad['pic_url']);
			}
			$height = $width="";
			if($ad['pic_height']){
				$height = "height='".$ad['pic_height']."'";
			}
			if($ad['pic_width']){
				$width = "width='".$ad['pic_width']."'";
			}
			$ad['html']="<a href='".$ad['pic_src']."' target='_blank' rel='nofollow'><img src='".$pic_url."'  ".$height." ".$width." ></a>";
		}else if($ad['ad_type']=='flash'){
			if(@!stripos("ttp://",$ad['flash_url'])){
				$flash_url = str_replace("../",$this->config['sy_weburl']."/",$ad['flash_url']);
			}
			$ad['html']="<object type='application/x-shockwave-flash' data='".$flash_url."' width='".$ad['flash_width']."' height='".$ad['flash_height']."'><param name='movie' value='".$flash_url."' /><param value='transparent' name='wmode'></object>";
		}
		if(@strtotime($ad['time_end']." 23:59:59")<time()){
			$ad['is_end']='1';
		}
		$ad['src']=$this->config['sy_weburl']."/data/plus/yunimg.php?classid=".$ad['class_id']."&ad_id=".$ad['id'];
		$this->yunset("ad",$ad);
		$this->yuntpl(array('admin/admin_ad_preview'));
	}
	function ajax_check_action(){
		extract($_POST);
		$this->obj->DB_update_all("ad","`is_check`='$val'","`id`='$id'");
		$this->public_action();
		$adver = new advertise($this->obj);
		$adver->model_ad_arr_action();
		if($val=="1"){
			echo "<font color='green'>已审核</font>";
		}else{
			echo "<font color='red' >未审核</font>";
		}

	}
	function class_action(){
		$where = "1";
		if($_POST['id']){
			$nid=$this->obj->DB_update_all("ad_class","`integral_buy`='".$_POST['integral_buy']."',`class_name`='".iconv('utf-8','gbk',$_POST['class_name'])."',`orders`='".$_POST['orders']."',`href`='".$_POST['href']."',`type`='".$_POST['type']."'","`id`='".$_POST['id']."'");
			$msg=$nid?1:2;
			if($msg==1){
				$this->admin_log("广告类别(ID:".$_POST['id'].")修改成功");
			}
			echo $msg;die;
		}else if($_POST['type']&&$_POST['id']==''){
			$nid=$this->obj->DB_insert_once("ad_class","`integral_buy`='".$_POST['integral_buy']."',`class_name`='".iconv('utf-8','gbk',$_POST['class_name'])."',`orders`='".$_POST['orders']."',`href`='".$_POST['href']."',`type`='".$_POST['type']."'");
			$msg=$nid?1:2;
			if($msg==1){
				$this->admin_log("广告类别(ID:".$nid.")添加成功");
			}
			echo $msg;die;
		}
        $urlarr['c']="class";
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$M=$this->MODEL();
		$PageInfo=$M->get_page("ad_class",$where." order by id desc",$pageurl,$this->config['sy_listnum']);
		$this->yunset($PageInfo);
		$ad_class_list=$PageInfo['rows'];
		if($_GET['ad_id']){
			$ad_class = $this->obj->DB_select_once("ad_class","`id`='".$_GET['ad_id']."'");
		}
		$this->yunset("ad_class",$ad_class);
		$this->yunset("ad_class_list",$ad_class_list);
		$this->yuntpl(array('admin/admin_ad_class'));
	}
	function delclass_action(){
		$this->check_token();
		if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
				if(is_array($del)){
				$this->obj->DB_delete_all("ad_class","`id` in(".@implode(',',$del).")","");
				}
				$this->layer_msg('广告类别(ID:'.@implode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }

		$id=intval($_GET['id']);
		$ad = $this->obj->DB_select_once("ad","`class_id`='$id'");
		if(is_array($ad)){
			$this->layer_msg('该分类下还有广告，请清空后再执行删除！',8,0,"index.php?m=advertise&c=class");
		}else{
			$this->obj->DB_delete_all("ad_class","`id`='".$id."'");
			$this->layer_msg('广告类别(ID:'.$id.')删除成功！',9,0,"index.php?m=advertise&c=class");
		}


	}
	function cache_ad_action(){
		$this->public_action();
		$adver = new advertise($this->obj);
		$adver->model_ad_arr_action();
		$this->layer_msg("广告更新成功！",9,0,"index.php?m=advertise");
	}
	function ctime_action(){
		extract($_POST);
		$id=$this->obj->DB_update_all("ad","`time_end`=DATE_ADD(time_end,INTERVAL ".$endtime." DAY)","`id` IN (".$jobid.")");
		$this->public_action();
		$adver = new advertise($this->obj);
		$adver->model_ad_arr_action();
		$id?$this->ACT_layer_msg("广告批量延期(ID:".$jobid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
    function del_action(){
		extract($_GET);
		extract($_POST);
		if(is_array($del)){
			$delid=@implode(',',$del);
			$layer_type=1;
		}else{
			$this->check_token();
			$delid=$id;
			$layer_type=0;
		}
		if(!$delid){
			$this->layer_msg('请选择要删除的内容！',8);
		}
		$del=$this->obj->DB_delete_all("ad","`id` in (".$delid.")"," ");
        $this->public_action();
		$adver = new advertise($this->obj);
		$adver->model_ad_arr_action();
		$del?$this->layer_msg('广告(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
}
?>