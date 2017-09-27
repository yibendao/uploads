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
class admin_userlog_controller extends common{	 
	function index_action(){
		$where = "1"; 
		if(trim($_GET['keyword'])){
			if($_GET['type']=="1"){
				$info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$comid[]=$v['uid'];
					}
				}
				$where.=" and `comid` in (".@implode(",",$comid).")";
			}elseif ($_GET['type']=="2"){
				$info=$this->obj->DB_select_all("company","`name` like '%".trim($_GET['keyword'])."%'","`uid`");
				if(is_array($info)&&$info){
					foreach ($info as $v){
						$comid[]=$v['uid'];
					}
				}
				$where.=" and `comid` in (".@implode(",",$comid).")";
			}elseif ($_GET['type']=="3"){
				$info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%' and `usertype`='1'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$uid[]=$v['uid'];
					}
				}
				$where.=" and `uid` in (".@implode(",",$uid).")";
			}elseif ($_GET['type']=="4"){
				$info=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET['keyword'])."%'","`id`");
				if(is_array($info)){
					foreach ($info as $v){
						$eid[]=$v['id'];
					}
				}
				$where.=" and `eid` in (".@implode(",",$eid).")";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `downtime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `downtime` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['sdate'])
		{
			$sdate=strtotime($_GET['sdate']);
			$where.=" and `downtime`>'$sdate'";
		}
		if($_GET['edate'])
		{
			$edate=strtotime($_GET['edate']);
			$where.=" and `downtime`<'$edate'";
		}
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("down_resume",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$eid[]=$v['eid'];
				$uid[]=$v['uid'];
				$uid[]=$v['comid'];
				$comid[]=$v['comid'];
			}
			$resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","name,id");
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid,usertype");
			$company=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$comid).")","name,uid");
			$statis=$this->obj->DB_select_all("company_statis","`uid` in (".@implode(",",$comid).")","rating,uid");
			foreach($list as $k=>$v)
			{
				foreach($company as $val)
				{
					if($v['comid']==$val['uid'])
					{
						$list[$k]['com_name']=$val['name'];
					}
				}
				foreach($statis as $val)
				{
					if($v['comid']==$val['uid'])
					{
						$list[$k]['rating']=$val['rating'];
					}
				}
				
				foreach($resume as $val)
				{
					if($v['eid']==$val['id'])
					{
						$list[$k]['resume']=$val['name'];
					}
				}
				foreach($member as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$list[$k]['username']=$val['username'];
					}
					if($v['comid']==$val['uid'])
					{
						$list[$k]['com_username']=$val['username'];
						$list[$k]['usertype']=$val['usertype'];
					}
				}
			}
		}
		$lotime=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'下载时间',"value"=>$lotime);
		$this->yunset("search_list",$search_list);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/down'));
	}
	function deldown_action(){
		$this->check_token();
	    if($_GET['del']){
	    	if(is_array($_GET['del']))
	    	{
	    		$del=@implode(",",$_GET['del']);
	    		$layer_status=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_status=0;
	    	}
			$this->obj->DB_delete_all("down_resume","`id` in (".$del.")","");
			$this->layer_msg( "下载记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	   }else{
			$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
    	}
	}
	function trust_action(){
		$where = "1";
		if(trim($_GET['keyword'])!="")
		{
			if($_GET['type']=="1"||$_GET['type']=="")
			{
				$resume=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET['keyword'])."%'","`id`,`name`");
				if(is_array($resume))
				{
					foreach($resume as $v)
					{
						$eid[]=$v['id'];
					}
				}
				$where.=" and `eid` in (".@implode(",",$eid).")";
			}else{
				if($_GET['type']=="2")
				{
					$jobwhere="`com_name` like '%".trim($_GET['keyword'])."%'";
				}else{
					$jobwhere="`name` like '%".trim($_GET['keyword'])."%'";
				}
				$job=$this->obj->DB_select_all("company_job",$jobwhere,"`id`,`name`,`com_name`");
				if(is_array($job))
				{
					foreach($job as $v)
					{
						$jobid[]=$v['id'];
					}
				}
				$where.=" and `jobid` in (".@implode(",",$jobid).")";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		$urlarr["c"]="trust";
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("user_entrust_record",$where." order by `id` desc",$pageurl,$this->config['sy_listnum']);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$eid[]=$v['eid'];
				$jobid[]=$v['jobid'];
			}
			if($_GET['keyword']!="")
			{
				if($_GET['type']=="1" || $_GET['type']=="")
				{
					$job=$this->obj->DB_select_all("company_job","`id` in (".@implode(",",$jobid).")","`id`,`name`,`com_name`");
				}else{
					$resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","`id`,`name`");
				}
			}else{
				$resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","`id`,`name`");
				$job=$this->obj->DB_select_all("company_job","`id` in (".@implode(",",$jobid).")","`id`,`name`,`com_name`");
			}
			foreach($list as $k=>$v)
			{
				foreach($resume as $val)
				{
					if($v['eid']==$val['id'])
					{
						$list[$k]['resume_name']=$val['name'];
					}
				}
				foreach($job as $val)
				{
					if($v['jobid']==$val['id'])
					{
						$list[$k]['job_name']=$val['name'];
						$list[$k]['com_name']=$val['com_name'];
					}
				}
			}
		}
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_trust_record'));
	}

	function deltrust_action(){
		$this->check_token();
	    if($_GET['del']){
	    	if(is_array($_GET['del']))
	    	{
	    		$del=@implode(",",$_GET['del']);
	    		$layer_status=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_status=0;
	    	}
	    	$this->obj->DB_delete_all("user_entrust_record","`id` in (".$del.")","");
	    	$this->layer_msg( "简历推送(ID:".@implode(',',$del).")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	    }else{
	    	$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
	    }
	}
	
	 
	function lookresume_action(){
		$where = "1"; 
		if(trim($_GET['keyword'])){
			if($_GET['type']=="3"){
				$company=$this->obj->DB_select_all("company","`name` like '%".trim($_GET['keyword'])."%'","name,uid");
				if(is_array($company)&&$company)
				{
					foreach($company as $v)
					{
						$com_id[]=$v['uid'];
					}
				}
				$where.=" and `com_id` in (".@implode(",",$com_id).")";
			}else{
				if($_GET['type']=="1")
				{
					$resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and a.`name` like '%".trim($_GET['keyword'])."%'","a.name,a.uid,b.name as resume_name,b.id");
				}elseif($_GET['type']=="2"){
					$resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and b.`name` like '%".trim($_GET['keyword'])."%'","a.name,a.uid,b.name as resume_name,b.id");
				}
				if(is_array($resume))
				{
					foreach($resume as $v)
					{
						$resume_id[]=$v['id'];
					}
				}
				$where.=" and `resume_id` in (".@implode(",",$resume_id).")";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['sdate'])
		{
			$sdate=strtotime($_GET['sdate']);
			$where.=" and `datetime`>'$sdate'";
			$urlarr['sdate']=$_GET['sdate'];
		}
		if($_GET['edate'])
		{
			$edate=strtotime($_GET['edate']);
			$where.=" and `datetime`<'$edate'";
			$urlarr['edate']=$_GET['edate'];
		}
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr["c"]="lookresume";
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("look_resume",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$resume_ids[]=$v['resume_id'];
				$com_ids[]=$v['com_id'];
			}
			if(($_GET['type']!="1" && $_GET['type']!="2") || !trim($_GET['keyword'])){
				$resume=$this->obj->DB_select_alls("resume","resume_expect","a.uid=b.uid and b.`id` in (".@implode(",",$resume_ids).")","a.name,a.uid,b.name as resume_name");
			}
			if($_GET['type']!="3" || !trim($_GET['keyword'])){
				$company=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$com_ids).")","name,uid");
			}
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$com_ids).")","username,uid,usertype");
			foreach($list as $k=>$v)
			{
				foreach($resume as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$list[$k]['name']=$val['name'];
						$list[$k]['resume_name']=$val['resume_name'];
					}
				}
				foreach($company as $val)
				{
					if($v['com_id']==$val['uid'])
					{
						$list[$k]['com_name']=$val['name'];
					}
				}
				
				foreach($member as $val)
				{
					if($v['com_id']==$val['uid'])
					{
						$list[$k]['usertype']=$val['usertype'];
					}
				}
			}
		}
		$lotime=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'浏览时间',"value"=>$lotime);
		$this->yunset("search_list",$search_list);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/look_resume'));
	}
	function dellook_action(){
		$this->check_token();
	    if($_GET['del']){
	    	if(is_array($_GET['del']))
	    	{
	    		$del=@implode(",",$_GET['del']);
	    		$layer_status=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_status=0;
	    	}
			$this->obj->DB_delete_all("look_resume","`id` in (".$del.")","");
			$this->layer_msg( "简历浏览记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	   }else{
			$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
    	}
	}
	function dellog_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$layer_type=1;
					$this->obj->DB_delete_all("member_log","`id` in (".@implode(',',$del).")","");
					$del=@implode(',',$del);
		    	}else{
					$this->obj->DB_delete_all("member_log","`id`='".$del."'");
					$layer_type=0;
		    	}
				$this->layer_msg('会员日志(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的信息！',8,0,$_SERVER['HTTP_REFERER']);
	    	}
	    }
		if($_GET['time']){
			$time=strtotime($_GET['time']);
			$this->obj->DB_delete_all("member_log","`ctime`<'".$time."' and `usertype`='".(int)$_GET['type']."'","");
			$this->layer_msg('会员日志删除成功！',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>