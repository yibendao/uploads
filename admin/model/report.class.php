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
class report_controller extends common
{
	function set_search(){
		if($_GET['type']=='1'){
			$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已处理","2"=>"未处理"));
		}
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'举报时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		extract($_GET);
		$this->set_search();
		if($type=='0' || $type==''){
			if($_GET['ut']=="2"){
				$this->yunset("ut",$_GET['ut']);
				$where="`usertype`='".$_GET['ut']."' and `type`='0' ";
				$urlarr['ut']=$_GET['ut'];
				$urlarr['type']=$_GET['type'];

			}else{
				$this->yunset("ut",$_GET['ut']);
				$where="`usertype`='1' and `type`='0' ";

			}
			if($_GET['end']){
				if($_GET['end']=='1'){
					$where.=" and `inputtime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
				}else{
					$where.=" and `inputtime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
				}
				$urlarr['end']=$_GET['end'];
			}
			if($_GET['s']!=""){
				$where.=" and `status`= ".$_GET['s'];
				$urlarr['s']=$_GET['s'];
			}
			if ($_GET['qysearch']){
				if ($_GET['f_type']=='1'){
					$where.=" and `r_name` like '%".trim($_GET['keyword'])."%' ";
				}elseif ($_GET['f_type']=='2'){
					$where.=" and `username` like '%".trim($_GET['keyword'])."%' ";
				}elseif ($_GET['f_type']=='3'){
					$where.=" and `r_reason` like '%".trim($_GET['keyword'])."%' ";
				}
				$urlarr['f_type']=$_GET['f_type'];
				$urlarr['keyword']=$_GET['keyword'];
				$urlarr['qysearch']=$_GET['qysearch'];
			}
			if($_GET['order']){
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
				$urlarr['order']=$_GET['order'];
				$urlarr['t']=$_GET['t'];
			}else{
				$where.=" order by id desc";
			}
			$urlarr['page']="{{page}}";
			$pageurl=Url("report",$urlarr,'admin');
			$userrows=$this->get_page("report",$where,$pageurl,$this->config['sy_listnum']);
			if($userrows &&is_array($userrows)){
				$uids=$eids=array();
				foreach($userrows as $val){
					if(in_array($val['c_uid'],$uids)==false){
						$uids[]=$val['c_uid'];
					}
					if(in_array($val['eid'],$eids)==false){
						$eids[]=$val['eid'];
					}
				}
				$member=$this->obj->DB_select_all("member","`uid` in(".@implode(',',$uids).")","`uid`,`email`");
				if($member&&is_array($member)){
					foreach($member as $val){
						foreach($userrows as $key=>$value){
							if($val['uid']==$value['c_uid']){
								$userrows[$key]['email']=$val['email'];
							}
						}
					}
				}

				$job=$this->obj->DB_select_all("company_job","`id` in (".@implode(',',$eids).")","`id`,`name`");
				if($job&&is_array($job)){
					foreach($job as $val){
						foreach($userrows as $key=>$value){
							if($val['id']==$value['eid']){
								$userrows[$key]['name']=$val['name'];
							}
						}
					}
				}

			}
			$this->yunset("userrows",$userrows);
			$type='0';
		}else if($type=='1'){
			$where="`type`='1'";
			if($_GET['status']=='2'){
				$where .=" and `status`='0'";
			}elseif($_GET['status']=='1'){
				$where .=" and `status`='1'";
			}
			$urlarr['status']=$_GET['status'];
			if($_GET['end']){
				if($_GET['end']=='1'){
					$where.=" and `inputtime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
				}else{
					$where.=" and `inputtime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
				}
				$urlarr['end']=$_GET['end'];
			}
			if ($_GET['comquestion']){
				if ($_GET['p_type']=='1'){
					$where .=" and `r_name` like '%".trim($_GET['keyword'])."%'";
				}else{
					$where .=" and `username` like '%".trim($_GET['keyword'])."%'";
				}
				$urlarr['p_type']=$_GET['p_type'];
				$urlarr['keyword']=$_GET['keyword'];
				$urlarr['comquestion']=$_GET['comquestion'];
			}
			if($_GET['order'])
			{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
				$urlarr['order']=$_GET['order'];
				$urlarr['t']=$_GET['t'];
			}else{
				$where.=" order by id desc";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['page']="{{page}}";
			$pageurl=Url($_GET['m'],$urlarr,'admin');
			$q_report=$this->get_page("report",$where,$pageurl,$this->config['sy_listnum']);
			include PLUS_PATH."/reason.cache.php";
			$reason=$this->obj->DB_select_all("reason","1","`id`,`name`");
			foreach($q_report as $key=>$val){
				$q_report[$key]['c']="add";
				$question=$this->obj->DB_select_once("question","`id`='".$val['eid']."'","`title`");
				if($question['title']){
					$q_report[$key]['title']=$question['title'];
					$q_report[$key]['url']="index.php?m=admin_question&id=".$val['eid'];
				}else{
					$q_report[$key]['is_del']='问题已被删除';
				}
				foreach($reason as $v){
					if($val['r_reason']==$v['id']){
						$q_report[$key]['reason']=$v['name'];
					}else if($val['r_reason']=='0'){
						$q_report[$key]['reason']='原因已被删除';
					}
				}
			}
			$this->yunset("q_report",$q_report);
		}elseif ($type=='2'){
			$where="`type`='2'";
			if($_GET['status']=='2'){
				$where .=" and `status`='0'";
			}elseif($_GET['status']=='1'){
				$where .=" and `status`='1'";
			}
			$urlarr['status']=$_GET['status'];
			if($_GET['end']){
				if($_GET['end']=='1'){
					$where.=" and `inputtime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
				}else{
					$where.=" and `inputtime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
				}
				$urlarr['end']=$_GET['end'];
			}
			if ($_GET['comquestion']){
				if ($_GET['p_type']=='1'){
					$where .=" and `r_name` like '%".trim($_GET['keyword'])."%'";
				}else{
					$where .=" and `username` like '%".trim($_GET['keyword'])."%'";
				}
				$urlarr['p_type']=$_GET['p_type'];
				$urlarr['keyword']=$_GET['keyword'];
				$urlarr['comquestion']=$_GET['comquestion'];
			}
			if($_GET['order'])
			{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
				$urlarr['order']=$_GET['order'];
				$urlarr['t']=$_GET['t'];
			}else{
				$where.=" order by id desc";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['page']="{{page}}";
			$pageurl=Url($_GET['m'],$urlarr,'admin');
			$q_report=$this->get_page("report",$where,$pageurl,$this->config['sy_listnum']);
			$this->yunset("q_report",$q_report);
		}
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION["auid"]."'");
		$power=unserialize($nav_user[0]["group_power"]);
		if(in_array('141',$power)){
			$this->yunset("email_promiss", '1');
		} 
		$back_url=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$this->yunset("get_type", $_GET);
		$this->yunset("type",$type);
		$this->yunset("back_url",$back_url);
		$this->yuntpl(array('admin/admin_report_userlist'));
	}
	function recommend_action(){
		$nid=$this->obj->DB_update_all("report","`".$_GET['type']."`='".$_GET['rec']."'","`id`='".$_GET['id']."' and `type`='1'");
		$this->admin_log("举报问答(ID:".$_GET['id'].")设置是否处理");
		echo $nid?1:0;die;
	}
	function result_action(){
		$info=$this->obj->DB_select_once("report","`id`='".intval($_POST['id'])."'",'result,rtime,admin');
		if($info['admin']){
			$adminname=$this->obj->DB_select_once("admin_user","`uid`='".$info['admin']."'",'name');
			$info['admin']=$adminname['name'];
			$info['rtime']=date('Y-m-d H:i',$info['rtime']);
		}
		echo json_encode($info);die;
	}
	function  saveresult_action(){
		$this->obj->DB_update_all("report","`result`='".trim($_POST['result'])."',`admin`='".$_SESSION['auid']."',`rtime`='".time()."'","`id`='".intval($_POST['pid'])."'");
		$this->ACT_layer_msg("操作成功！",9,$_SERVER['HTTP_REFERER']);
	}
	function delresume_action(){
		$id=$_GET['eid'];
		$result=$this->obj->DB_delete_all("resume_expect","`id`='".$id."'" );
		$del_array=array("resume_cert","resume_edu","resume_other","resume_project","resume_skill","resume_training","resume_work","resume_doc","user_resume","resume_show","down_resume","userid_job");
		$show=$this->obj->DB_select_all("resume_show","`eid`='".$id."' and `picurl`<>''","`picurl`");
		if(is_array($show))
		{
			foreach($show as $v)
			{
				unlink_pic(".".$show['picurl']);
			}
		}
		foreach($del_array as $v){
			$this->obj->DB_delete_all($v,"`eid`='".$id."'");
		}
		$this->obj->DB_update_all("member_statis","`resume_num`=`resume_num`-1","`uid`='".$_GET['uid']."'");
		$this->obj->DB_delete_all("report","`id`='".$_GET['id']."'");
		$this->layer_msg('简历(ID:'.$id.')删除成功！',9,0,$_SERVER['HTTP_REFERER']);
	}
	function deljob_action(){
		$this->obj->DB_delete_all("company_job","`id`='".$_GET['eid']."'");
		$this->obj->DB_delete_all("report","`id`='".$_GET['id']."'");
		$this->layer_msg('职位(ID:'.$_GET['eid'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']);
	}
	function del_action(){
		$this->check_token(); 
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$layer_type=1;
					$this->obj->DB_delete_all("report","`id` in(".@implode(',',$del).")","");
					$del=@implode(',',$del);
		    	}else{
					$this->obj->DB_delete_all("report","`id`='$del'");
					$layer_type=0;
		    	}
				$this->layer_msg('举报(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的信息！',8,0,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
	function delquestion_action(){		
		if($_GET['del']){
			$ids=$_GET['del'];
			$rows=$this->obj->DB_select_all('answer',"`qid` in(".pylode(',',$ids).") group by uid","count(id) as num,uid");
			$ask=$this->obj->DB_select_all('question',"`id` in(".pylode(',',$ids).") group by uid","count(id) as num,uid");
			$uid=array();
			foreach($rows as $val){
				$num[$val['uid']]=$val['num'];
				$uid[]=$val['uid'];
			}
			
			foreach($ids as $v){
				$attention=$this->obj->DB_select_all("attention","FIND_IN_SET('".$v."',ids) and `type`='1'","`ids`,`id`");
				if(count($attention)){
					foreach($attention as $val){
						$ids=array();
						$arr=@explode(',',$val['ids']);
						foreach($arr as $v){
							if($v!=$v){
								$ids[]=$v;
							}
						} 
						if($ids[0]){
							$this->obj->DB_update_all('attention',"`ids`='".pylode(',',$ids)."'","`id`='".$val['id']."'");
						}else{
							$this->obj->DB_delete_all('attention',"`id`='".$val['id']."'");
						} 
					}
				}
			}
			
			$this->obj->DB_delete_all("answer","`qid` in(".pylode(',',$ids).")","");
			$this->obj->DB_delete_all("answer_review","`qid` in(".pylode(',',$ids).")","");
			$this->obj->DB_delete_all("question","`id` in(".pylode(',',$ids).")","");	
			$this->layer_msg('问答(ID:'.$ids.')删除成功！',9,0,$_SERVER['HTTP_REFERER']);		
		}
	}
	function show_action(){
		if($_POST['id']){
			$row=$this->obj->DB_select_once("report","id='".$_POST['id']."'","r_reason");
			$data['r_reason']=yun_iconv('gbk','utf-8',$row['r_reason']);
			echo json_encode($data);die;
		}
	}
}

?>