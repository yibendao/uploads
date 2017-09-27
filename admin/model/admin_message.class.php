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
class admin_message_controller extends common{

	function set_search(){
		$search_list[]=array("param"=>"infotype","name"=>'意见类型',"value"=>array("1"=>"建议","2"=>"意见","3"=>"求助","4"=>"投诉"));
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'意见时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where =1;
		if(trim($_GET['keyword'])){
			if($_GET["type"]==1){
				$where.=" and `username` like '%".trim($_GET['keyword'])."%'";
			}else{
				$where.=" and `content` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['infotype']){
			$where.=" and `infotype` = '".$_GET['infotype']."'";
			$urlarr['infotype']=$_GET['infotype'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by ctime desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("advice_question",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_message'));
	}
   function show_action(){
		if($_POST['submit']){
			if($_POST['content']==""){
				$this->ACT_layer_msg("请填写内容！",2,"index.php?m=admin_message");
			}
			$value="`reply`='".$_POST['content']."',`reply_time`='".time()."',`status`='1'";
			$nid=$this->obj->DB_update_all("message",$value,"`id`='".$_POST['id']."'");
 		    $nid?$this->ACT_layer_msg("意见反馈回复(ID:$nid)成功！",9,"index.php?m=admin_message",2,1):$this->ACT_layer_msg("回复(ID:$nid)失败！",8,$_SERVER['HTTP_REFERER']);
		}
		$this->yuntpl(array('admin/admin_message_show'));
	}
	function del_action(){
	    if($_GET['del']){
			$this->check_token();
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
	    			$del=@implode(',',$del);
					$layer_msg=1;
		    	}else{
					$layer_msg=0;
		    	}
		    	$this->obj->DB_delete_all("advice_question","`id` in (".$del.")","");
				$this->layer_msg("意见反馈(ID:".$del.")删除成功！",9,$layer_msg,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('非法操作！',8);
			}
	    }
	}
	function content_action(){
		$con=$this->obj->DB_select_once('advice_question','`id`=\''.intval($_GET['id']).'\'');
		
		if($con['infotype']==1){
			$con['type']='建议';
		}elseif($con['infotype']==2){
			$con['type']='意见';
		}elseif($con['infotype']==3){
			$con['type']='求助';
		}elseif($con['infotype']==4){
			$con['type']='投诉';
		}
		$con['name']=yun_iconv("gbk","utf-8",$con['username']);
		$con['type']=yun_iconv("gbk","utf-8",$con['type']);
		$con['ctime']=date('Y-m-d H:s:m',$con['ctime']);
		$con['content']=yun_iconv("gbk","utf-8",$con['content']);
		echo json_encode($con);die;
	}
}