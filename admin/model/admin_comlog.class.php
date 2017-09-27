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
class admin_comlog_controller extends common{
	function index_action(){		
		$where = "1";
		if(trim($_GET['keyword'])){
			if($_GET['type']=="1")
			{
				$where.=" and `job_name` like '%".trim($_GET['keyword'])."%'";
			}elseif ($_GET['type']=="2"){
				$where.=" and `com_name` like '%".trim($_GET['keyword'])."%'";
			}elseif ($_GET['type']=="3"){
				$info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
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
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['browse']){
			$where.=" and `is_browse`= '".$_GET['browse']."'";
			$urlarr['browse']=$_GET['browse'];
		}
		if($_GET['sdate'])
		{
			$sdate=strtotime($_GET['sdate']);
			$where.=" and `datetime`>'$sdate'";
		}
		if($_GET['edate'])
		{
			$edate=strtotime($_GET['edate']);
			$where.=" and `datetime`<'$edate'";
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
		$list=$this->get_page("userid_job",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$uid[]=$v['uid'];
				$eid[]=$v['eid'];
				$com_id[]=$v['com_id'];
			}
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid");
			$resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","name,id");
			$statis=$this->obj->DB_select_all("company_statis","`uid` in (".@implode(",",$com_id).")","rating,uid");
			foreach($list as $k=>$v)
			{
				foreach($member as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$list[$k]['username']=$val['username'];
					}
				}
				foreach($resume as $val)
				{
					if($v['eid']==$val['id'])
					{
						$list[$k]['resume']=$val['name'];
					}
				}
				foreach($statis as $val){
					if($v['com_id']==$val['uid']){
						$list[$k]['rating']=$val['rating'];
					}
				}
			}
		}
		$search_list[]=array("param"=>"browse","name"=>'是否查看',"value"=>array("1"=>"未查看","2"=>"已查看"));
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'申请时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_useridjob'));
	}
	function deluseridjob_action(){
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
			$this->obj->DB_delete_all("userid_job","`id` in (".$del.")","");
			$this->layer_msg( "职位申请记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	   }else{
			$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
    	}
	}
	
	
	function useridmsg_action(){
		$where = "1"; 
		if(trim($_GET['keyword']))
		{
			if($_GET['type']=="1")
			{
				$info=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$comid[]=$v['uid'];
					}
				}
				$where.=" and `uid` in (".@implode(",",$comid).")";
			}elseif ($_GET['type']=="2"){
				$where.=" and `fname` like '%".trim($_GET['keyword'])."%'";
			}elseif ($_GET['type']=="3"){
				$where.=" and `title` like '%".trim($_GET['keyword'])."%'";
			}elseif ($_GET['type']=="4"){
				$where.=" and `content` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['browse']){
			$where.=" and `is_browse`= '".$_GET['browse']."'";
			$urlarr['browse']=$_GET['browse'];
		}
		if($_GET['sdate'])
		{
			$sdate=strtotime($_GET['sdate']);
			$where.=" and `datetime`>'$sdate'";
		}
		if($_GET['edate'])
		{
			$edate=strtotime($_GET['edate']);
			$where.=" and `datetime`<'$edate'";
		}
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr["c"]="useridmsg";
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("userid_msg",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$uid[]=$v['uid'];
				$fid[]=$v['fid'];
			}
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid");
			$statis=$this->obj->DB_select_all("company_statis","`uid` in (".@implode(",",$fid).")","rating,uid");
			foreach($list as $k=>$v)
			{
				foreach($member as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$list[$k]['username']=$val['username'];
					}
				}
				foreach($statis as $val)
				{
					if($v['fid']==$val['uid'])
					{
						$list[$k]['rating']=$val['rating'];
					}
				}
			}
		}
		$search_list[]=array("param"=>"browse","name"=>'是否查看',"value"=>array("1"=>"未查看","2"=>"已查看"));
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'邀请时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_useridmsg'));
	}
	function deluseridmsg_action(){
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
			$this->obj->DB_delete_all("userid_msg","`id` in (".$del.")","");
			$this->layer_msg( "邀请面试记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	   }else{
			$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
    	}
	}
	
	
	function lookjob_action(){
		$where = "1";
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if(trim($_GET['keyword'])){
			if($_GET['type']=="1"){
				$member=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%' and `usertype`='1'","username,uid");
				if(is_array($member))
				{
					foreach($member as $v)
					{
						$uid[]=$v['uid'];
					}
				}
				$where.=" and `uid` in (".@implode(",",$uid).")";
			}else{
				if($_GET['type']=="2"){ 
					$job=$this->obj->DB_select_all("company_job","`name` like '%".trim($_GET['keyword'])."%'","name,uid,com_name,id");
					$jobid=array();
					if(is_array($job)){
						foreach($job as $v){
							$jobid[]=$v['id'];
						}
					}
					$where.=" and `jobid` in (".@implode(",",$jobid).")";
				}elseif($_GET['type']=="3"){
					$job=$this->obj->DB_select_all("company_job","`com_name` like '%".trim($_GET['keyword'])."%'","name,uid,com_name,id");
					$com_id=array();
					if(is_array($job)){
						foreach($job as $v){
							$com_id[]=$v['uid'];
						}
					}
					$where.=" and `com_id` in (".@implode(",",$com_id).")";
				}
				
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
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
		$urlarr["c"]="lookjob";
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("look_job",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($list)){
			$jobid=$uids=array();
			
			foreach($list as $v){
				if(in_array($v['uid'],$uids)==false){
					$uids[]=$v['uid'];
				}
				if(in_array($v['jobid'],$jobid)==false){
					$jobid[]=$v['jobid'];
				} 
			}
			if($_GET['type']!="1" || !trim($_GET['keyword'])){
				$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uids).")","username,uid");
			}
			if(($_GET['type']!="2" && $_GET['type']!="3") || !trim($_GET['keyword'])){ 
				$job=$this->obj->DB_select_all("company_job","`id` in (".@implode(",",$jobid).")","name,com_name,id");
			} 
			foreach($list as $k=>$v){
				foreach($member as $val){
					if($v['uid']==$val['uid']){
						$list[$k]['username']=$val['username'];
					}
				}
				foreach($job as $val){
					if($v['jobid']==$val['id']){
						$list[$k]['job_name']=$val['name'];
						$list[$k]['com_name']=$val['com_name'];
					}
				}
			}
		}
		$adtime=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'浏览时间',"value"=>$adtime);
		$this->yunset("search_list",$search_list);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_lookjob'));
	}
	function dellookjob_action(){
		$this->check_token();
	    if($_GET['del']){
	    	if(is_array($_GET['del'])){
	    		$del=@implode(",",$_GET['del']);
	    		$layer_status=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_status=0;
	    	}
			$this->obj->DB_delete_all("look_job","`id` in (".$del.")","");
			$this->layer_msg( "职位浏览记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
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