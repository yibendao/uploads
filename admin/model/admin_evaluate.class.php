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
class admin_evaluate_controller extends common {
	function index_action(){ 
		$group=$this->obj->DB_select_all("evaluate_group","`keyid`='0'","`id`,`name`");
	    if ($group){
		    $arr=array();
		    foreach($group as $val){
		        $arr[$val['id']]=$val['name'];
		    }
		    $search_list[]=array("param"=>"keyid","name"=>'试卷类别',"value"=>$arr);
		    $this->yunset("arr",$arr);
		    $this->yunset("search_list",$search_list);
		}
		
		$where="1 and `keyid`!='0'";
		if($_GET['evaluate_search']&&trim($_GET['keyword'])){
			$where.=" and `name` like '%".trim($_GET['keyword'])."%'"; 
			$urlarr['evaluate_search']=$_GET['evaluate_search'];
			$urlarr['keyword']=trim($_GET['keyword']);
		}
		if((int)$_GET['keyid']){
			$where.=" and `keyid`='".(int)$_GET['keyid']."'"; 
			$urlarr['keyid']=(int)$_GET['keyid'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr['order']=$_GET['order'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin'); 
		$rows=$this->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`"); 
		$this->yunset($rows);  
		$this->yunset("get_type", $_GET);  
		$this->yuntpl(array('admin/admin_evaluate_list'));  
	} 
	function examup_action(){	
		$group_all = $this->obj->DB_select_all("evaluate_group","`keyid`='0'","`id`,`name`");
		$this->yunset("group_all",$group_all);
		$examid=(int)$_GET['id']; 
		$info = $this->obj->DB_select_once("evaluate_group","`id`='".$examid."'");  
		
		$info['fromscore'] = unserialize($info['fromscore']);
		$info['toscore'] = unserialize($info['toscore']);
		$info['comment'] = unserialize($info['comment']);
		$info['describe']= explode(",",$info['describe']);
		  
		$ask = $this->obj->DB_select_all("evaluate","`gid`='".$examid."' order by id asc");
		$fullscore=0;
		foreach($ask as $key=>$val){ 
			$ask[$key]['option'] = unserialize($val['option']);
			$ask[$key]['score'] = unserialize($val['score']);
			$tempscore=intval($ask[$key]['score'][0]); 
			foreach($ask[$key]['score'] as $v){
				if($v>$tempscore){
					$tempscore=$v;
				}
			}
			$fullscore+=$tempscore;
		}  
		$this->obj->DB_update_all("evaluate_group","`score`='".$fullscore."',`num`='".count($ask)."'","`id`='".$info['id']."'");
		$this->yunset("info",$info);
		$this->yunset("ask",$ask);
		$this->yunset("fullscore",$fullscore); 
		$this->yuntpl(array('admin/admin_evaluate_examup'));
	}
	function examupsave_action(){ 
		$examid = (int)$_POST['examid']; 
		if($_POST['submit']){   
			$fromscore=serialize($_POST['fromscore']);
			$toscore=serialize($_POST['toscore']);
			$comment=serialize($_POST['comment']); 
			$pic=trim($_POST['uplocadpic']);
			$examtitle=trim($_POST['examtitle']); 
			if($pic==''){
				$this->ACT_layer_msg("请上传图片！",8); 
			}
			if($examtitle==''){
				$this->ACT_layer_msg("请填写测评名称！",8); 
			}
			if($examid){
				$info=$this->obj->DB_select_once("evaluate_group","`id`='".$examid."'","`pic`"); 
				if($info['pic']!=$pic){
					unlink_pic("../".$info['pic']);
				}	
			}  
			$val="`fromscore`='".$fromscore."',";
			$val.="`toscore`='".$toscore."',";
			$val.="`comment`='".$comment."',";
			$val.="`description`='".trim($_POST['description'])."',";
			$val.="`name`='".$examtitle."',";
			$val.="`pic`='".$pic."',";
			$val.="`top`='".(int)$_POST['top']."',";
			$val.="`recommend`='".(int)$_POST['recommend']."',";
			$val.="`hot`='".(int)$_POST['hot']."',";
			$val.="`sort`='".(int)$_POST['sort']."',";
			$val.="`keyid`='".(int)$_POST['selectgroup']."'";  
			if($examid){ 
				$nid=$examid;
				$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			}else{
				$val.=",`ctime`='".time()."'";
				$nid=$scale = $this->obj->DB_insert_once("evaluate_group",$val); 
			} 
			$scale?$this->ACT_layer_msg("操作成功！",9,"index.php?m=admin_evaluate&c=examup&id=".$nid):$this->ACT_layer_msg("操作失败！",8,$_SERVER['HTTP_REFERER']); 
		}
	} 
	function message_action(){
		$where='1';
		if(trim($_GET['keyword'])!=""){
			if($_GET['type']=='1'){
				$info=$this->obj->DB_select_all('member',"username like '%".trim($_GET['keyword'])."%'",'uid');
				if($info&&is_array($info)){
					foreach($info as $v){
						$uids[]=$v['uid'];
					}
				}
				$where .=" and `uid` in (".pylode(',',$uids).")";
			}else{
				$where .=" and `message` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		$urlarr['c']=$_GET['c'];
		$urlarr['id']=$_GET['id'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin'); 
		$rows=$this->get_page("evaluate_leave_message",$where." order by `id` desc",$pageurl,$this->config['sy_listnum']);
		if($rows&&is_array($rows)){
			$uid=array();
			foreach($rows as $key=>$val){
				$rows[$key]['name']='访客';
				if(in_array($val['uid'],$uid)==false&&$val['usertype']){
					$uid[]=$val['uid'];
				}
			}
			$member=$this->obj->DB_select_all("member","`uid` in(".pylode(',',$uid).")","`uid`,`username`");
			foreach($rows as $key=>$val){
				foreach($member as $v){
					if($v['uid']==$val['uid']){
						$rows[$key]['name']=$v['username'];
					}
				}
			}
		} 
		$this->yunset("rows",$rows); 
		$this->yuntpl(array('admin/admin_evaluate_message'));
	}
	function delmsg_action(){
		if(is_array($_GET['del'])){
			$layer_type=1;
			$nid=$this->obj->DB_delete_all("evaluate_leave_message","`id` in (".pylode(',',$_GET['del']).")"," ");
		}else if($_GET['id']){
			$layer_type=0;
			$nid=$this->obj->DB_delete_all("evaluate_leave_message","`id`='".intval($_GET['id'])."'");
		}
		if($nid){
			$num=$this->obj->DB_select_num("evaluate_leave_message","`examid`='".intval($_GET['examid'])."'");
			$this->obj->DB_update_all("evaluate_group","`comnum`='".$num."'","`id`='".intval($_GET['examid'])."'");
			$this->layer_msg( "评论删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg( "评论删除失败！",8,$layer_type,$_SERVER['HTTP_REFERER']);
		}
	}
	function delevaluate_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
	    		$this->delevagroup($del); 
 				$this->layer_msg('测评试卷(ID:'.@implode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的测评试卷！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
			$result=$this->obj->DB_delete_all("evaluate_group", $where); 
			$nid=$this->obj->DB_delete_all("evaluate_leave_message","`examidid`='".$_GET['id']."'",""); 
			$nid=$this->obj->DB_delete_all("evaluate_log","`examidid`='".$_GET['id']."'",""); 
			$nid=$this->obj->DB_delete_all("evaluate","`gid`='".$_GET['id']."'",""); 
			isset($result)?$this->layer_msg('测评试卷(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}	

	function delquestion_action(){
		$this->check_token();
		if($_GET['qid']){
			$qid=$_GET['qid']; 
			$scale = $this->obj->DB_delete_all("evaluate","`id`='".$qid."'");
			isset($scale)?$this->layer_msg('测评问题(ID:'.$qid.')删除成功！',9):$this->layer_msg('删除失败！',8);
		}
	} 
	function delevagroup($ids){
		$id=@implode(',',$ids);
		$this->obj->DB_delete_all("evaluate_group","`id` in(".$id.")","");
		$this->obj->DB_delete_all("evaluate_leave_message","`examidid` in(".$id.")","");
		$this->obj->DB_delete_all("evaluate_log","`examidid` in(".$id.")","");
		$this->obj->DB_delete_all("evaluate","`gid` in(".$id.")","");
	}
 
	function group_action(){
		$evaluate_group = $this->obj->DB_select_all("evaluate_group","1 order by `sort` asc","id,keyid,name,sort");    
		if(is_array($evaluate_group)){
			$rootid=array();
			foreach($evaluate_group as $key=>$value){
				if($value['keyid']!=0){
					$rootid[$value['keyid']][] = $value['id'];
				}else{
					$rootid[$value['id']][] = $value['id'];
				}
			}
		}
		if(is_array($rootid)&&$rootid){
			foreach($rootid as $k=>$v){
				$root_arr = @implode(",",$v);
				$count = $this->obj->DB_select_num("evaluate_group","`keyid`='$k' or keyid IN ($root_arr)");
				
				foreach($evaluate_group as $key=>$value){
					if($value['id']==$k){
						$evaluate_group[$key]['count'] = $count;
						$evaluate_group[$key]['roots'] = count($v)-1;
					}
				}
			}
		}
		$this->yunset("evaluate_group",$evaluate_group);
		$this->yuntpl(array('admin/admin_evaluate_group'));
	}

	function addgroup_action(){
        if($_POST['sub']){
			if($_POST['classname']!=""){
				if(!is_array($this->obj->DB_select_once("evaluate_group","name='".$_POST['classname']."'"))){
					$va="`name`='".$_POST['classname']."',`keyid`='0'";
					$nbid=$this->obj->DB_insert_once("evaluate_group",$va);
					isset($nbid)?$this->ACT_layer_msg("测评类别(ID:".$nbid.")添加成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg( "添加失败！",8,$_SERVER['HTTP_REFERER']);
			     }else{
				   $this->ACT_layer_msg( "已经存在此类别！",8,$_SERVER['HTTP_REFERER']);
			    }
			}else{
				$this->ACT_layer_msg( "请正确填写你的类别！",8,$_SERVER['HTTP_REFERER']);
		    }
        }
	}

	function ajax_action(){
		if($_POST['sort']){
			$this->obj->DB_update_all("evaluate_group","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->admin_log("测评类别(ID:".$_POST['id'].")修改排序");
		}
		
		if($_POST['name']){
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("evaluate_group","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->admin_log("测评类别(ID:".$_POST['id'].")修改名称");
		} 
		echo '1';die;
	} 

	function delgroup_action(){
	   $this->check_token();
	   if(isset($_GET['id'])) {	
			$titleid = $this->obj->DB_select_all("evaluate_group","`keyid`='".$_GET['id']."'","id");
			$ids=array();
			foreach($titleid as $val){
				$ids[]=$val['id'];
			}
			$this->delevagroup($ids);
			$result=$this->obj->DB_delete_all("evaluate_group","`id`='".$_GET['id']."'","");
			isset($result)?$this->layer_msg('测评类别(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
	   }
	}
	 
	function ajaxsave_action(){
		$status = $_POST['status'];
		if($status=="up"){
			$questid = $_POST['questid'];  
			$question = iconv("UTF-8","gb2312",$_POST['question']); //echo $question;die;
			$option = $_POST['option'];
			for($i=0; $i<count($option); $i++){
				$option[$i] = iconv("UTF-8","gb2312",$option[$i]);
			}
			$option=serialize($option);
			$score = serialize($_POST['score']);
			
			$val="`question`='".$question."',";
			$val.="`option`='".$option."',";
			$val.="`score`='".$score."'";
			$scale = $this->obj->DB_update_all("evaluate",$val,"`id`='".$questid."'");
			if($scale>0) $this->admin_log("测评问题(ID:".$questid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}else if($status=="savenewquestion"){
			$examid = $_POST['examid'];
			$question = iconv("UTF-8","GBK",$_POST['question']);
			$option = $_POST['option'];
			for($i=0; $i<count($option); $i++){
				$option[$i] = iconv("UTF-8","GBK",$option[$i]);
			}
			$option = serialize($option);
			$score = serialize($_POST['score']);
			
			$val="`gid`='".$examid."',";
			$val.="`question`='".$question."',";
			$val.="`option`='".$option."',";
			$val.="`score`='".$score."',";
			$val.="`sort`='0'";
			$scale = $this->obj->DB_insert_once("evaluate",$val);
			if($scale>0) $this->admin_log("测评问题(ID:".$scale.")添加成功"); 
			unset($val);
			unset($scale);
			echo '1';die;
		} 
	}
	function show_action(){
		if($_POST['id']){
			$data=$this->obj->DB_select_once("evaluate_leave_message","`id`='".$_POST['id']."'","message");
			$data['message']=yun_iconv('gbk','utf-8',$data['message']);
			echo json_encode($data);die;
		}
	}
	 
}
?>