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
class msgconfig_controller extends common{
	function index_action(){
		$this->yuntpl(array('admin/admin_msg_config'));
	}
	function save_action(){
 		if($_POST['config']){
			unset($_POST['config']);
		    foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			    if($config==false){
					$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			    }else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");
			    }
		 	}
			$this->web_config();
			$this->ACT_layer_msg( "短信配置设置成功！",9,1,2,1);
		 }
	}
	function tpl_action(){
		$this->yuntpl(array('admin/admin_msg_tpl'));
	}
	function settpl_action(){
		extract($_POST);
		if($config){
		    $config=$this->obj->DB_select_num("templates","`name`='$name'");
		    if($config==false){
				$this->obj->DB_insert_once("templates","name='$name',`title`='$title',`content`='".$content."'");
		    }else{
				$this->obj->DB_update_all("templates","`title`='$title',`content`='".$content."'","`name`='$name'");
		    }
			$this->ACT_layer_msg( "短信模版配置设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		include(CONFIG_PATH."db.tpl.php");
		$this->yunset("arr_tpl",$arr_tpl);
		$name=$_GET['name'];
		$row=$this->obj->DB_select_once("templates","`name`='$name'");
		$this->yunset("row",$row);
		$this->yuntpl(array('admin/admin_settpl'));
	}
	function alllist_action(){
	    include(CONFIG_PATH."db.data.php");
	    $this->yunset('msgreturn',$arr_data['msgreturn']);
		$where="1";
		if($_GET['state']=="1"){
			$where.=" and `state`='1'";
			$urlarr['state']='1';
		}elseif($_GET['state']=="2"){
			$where.=" and `state`='0'";
			$urlarr['state']='2';
		}
		if(trim($_GET['keyword'])){
			if ($_GET['type']=='1'){
				$where.=" and `moblie` like '%".trim($_GET['keyword'])."%'";
			}else if($_GET['type']=='2'){
			    $where.=" and `cname` like '%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=='3'){
				 $where.=" and `name` like '%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=='4'){
				 $where.=" and `content` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']="".$_GET['type']."";
			$urlarr['keyword']="".$_GET['keyword']."";
		}
		if(($_GET['sdate']||$_GET['edate'])&&$_GET['time']<1){
			if($_GET['sdate']){
				$where.=" and `ctime` >= '".strtotime($_GET['sdate']." 00:00:00")."'";
				$urlarr['sdate']=$_GET['sdate'];
			}
			if($_GET['edate']){
				$where.=" and `ctime`<'".strtotime($_GET['edate']." 23:59:59")."'";
				$urlarr['edate']=$_GET['edate'];
			} 
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where .=" and `ctime`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `ctime`>'".strtotime('-'.intval($_GET['time']).' day')."'";
			}
			unset($_GET['sdate']);
			unset($_GET['edate']); 
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['order']){
			if($_GET['order']=="desc"){
				$order=" order by `".$_GET['t']."` desc";
			}else{
				$order=" order by `".$_GET['t']."` asc";
			}

		}else{
			$order=" order by `id` desc";
		}
		if($_GET['order']=="asc"){
			$this->yunset("order","desc");
		}else{
			$this->yunset("order","asc");
		}
		$urlarr['c']="alllist";
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows=$this->get_page("moblie_msg",$where.$order,$pageurl,$this->config['sy_listnum']);
		$search_list[]=array("param"=>"state","name"=>'发送状态',"value"=>array("1"=>"发送成功","2"=>"发送失败"));
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'时间',"value"=>$lo_time);
		$this->yunset("search_list",$search_list);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_mobliemsg'));
	}
	function del_action(){

		if(is_array($_POST['del'])){
			$delid=@implode(',',$_POST['del']);
			$layer_type=1;
		}else{
			$this->check_token();
			$delid=(int)$_GET['id'];
			$layer_type=0;
		}
		if(!$delid){
			$this->layer_msg('请选择要删除的内容！',8,$layer_type,$_SERVER['HTTP_REFERER']);
		}
		$del=$this->obj->DB_delete_all("moblie_msg","`id` in ($delid)"," ");
		$del?$this->layer_msg('短信记录(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
	function get_restnum_action(){
	    $msguser=trim($_POST['msguser']);
	    $url='http://msg.phpyun.com/restnum.php';
	    $url.='?msguser='.$msguser.'';
	    if(function_exists('file_get_contents')){
	        $file_contents = file_get_contents($url);
	    }else{
	        $ch = curl_init();
	        $timeout = 5;
	        curl_setopt ($ch, CURLOPT_URL, $url);
	        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	        $file_contents = curl_exec($ch);
	        curl_close($ch);
	    }
	    echo $file_contents;
	}
}

?>