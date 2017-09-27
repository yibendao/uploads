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
class report_controller extends company{
	function index_action(){
		if ($_POST['eid']){
			$row=$this->obj->DB_select_once("report","p_uid='".$this->uid."' and eid='".$_POST['eid']."' order by inputtime desc");
			if(is_array($row)&&!$row['result']){
				echo 2;die;
			}
			$eid=(int)$_POST['eid'];
			$reason=yun_iconv("utf-8","gbk",$_POST['reason']);
			$gw=$this->obj->DB_select_once("company_consultant","`id`='".$eid."'");
			$data['did']=$this->userdid;
			$data['p_uid']=$this->uid;
			$data['eid']=(int)$_POST['eid'];
			$data['usertype']=$this->usertype;
			$data['inputtime']=time();
			$data['username']=$this->username;
			$data['r_name']=$gw['username'];
			$data['r_reason']=$reason;
			$data['type']=2;
			$M=$this->MODEL('ask');
			$new_id=$M->AddReport($data);
			if($new_id){
				$M->member_log('投诉招聘顾问');
				echo '1';
			}else{
				echo '0';
			}
		}
	}
	function show_action(){
		$urlarr['c']="report";
		$urlarr['act']="show";
		$urlarr['page']="{{page}}";
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("report","p_uid='".$this->uid."' and type='2' ORDER BY inputtime desc",$pageurl,"10");
		$this->yunset('rows',$rows);
		$this->public_action();
		$this->yunset("js_def",7);
		$this->com_tpl("report");
	}
	function del_action(){
		if($_GET['id']){
	    	$del=$_GET['id'];
	    	if($del){
				$this->obj->DB_delete_all("report","`id`='".$del."'");
				$this->layer_msg('删除成功！',9,0,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的信息！',8,0,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
}
?>