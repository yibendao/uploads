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
class admin_trust_controller extends common
{
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已接受","3"=>"未审核","2"=>"未接受"));
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'发布时间',"value"=>$lo_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where='1';
		if($_GET["status"] ){
			if($_GET["status"]==3){
				$where.=" and `status`=0";
			}else{
				$where.=" and `status`='".$_GET["status"]."'";
			}
			$urlarr["status"]=$_GET["status"];
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `add_time` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `add_time` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET["keyword"]!=""){
			if ($_GET['type']=='1'){
				$where.=" and `username` like '%".trim($_GET["keyword"])."%'";
			}elseif ($_GET['type']=='2'){
				$trustinfo=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET["keyword"])."%'","`uid`");
				if (is_array($trustinfo)){
					foreach ($trustinfo as $val){
						$trustuids[]=$val['uid'];
					}
					$trustuid=@implode(",",$trustuids);
				}
				$where.=" and `uid` in (".$trustuid.") ";
			}
			$urlarr["type"]=$_GET["type"];
			$urlarr["keyword"]=$_GET["keyword"];
		}

		if($_GET['order'])
		{
			$where.=" order by ".$_GET['order']." ".$_GET['desc'];
			$urlarr['order']=$_GET['order'];
			$urlarr['desc']=$_GET['desc'];
		}else{
			$where.=" order by status asc,`add_time` desc";
		}
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows = $this->get_page("user_entrust",$where,$pageurl,$this->config["sy_listnum"]);

		if(is_array($rows)&&$rows){
			$eid=array();
			foreach($rows as $val){
				$eid[]=$val['eid'];
			}
			$resume_expect=$this->obj->DB_select_all("resume_expect","`id` in(".pylode(",",$eid).") ","`id`,`name`");
			foreach($rows as $key=>$value){
				foreach($resume_expect as $val){
					if($value['eid']==$val['id'])
					{
						$rows[$key]['name']=$val['name'];
					}
				}
			}
		}
		$this->yunset("get_info",$_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_trust'));
	}
	function status_action(){
		extract($_POST);
		$user_entrust = $this->obj->DB_select_once("user_entrust","`id`='".$pid."'");
		if($status=='2'){
			$this->obj->DB_update_all("resume_expect","`is_entrust`='0'","`uid`='".$user_entrust['uid']."' and `id`='".$user_entrust['eid']."'");
			if($user_entrust['0']){ 
				$this->company_invtal($user_entrust['uid'],$user_entrust['price'],true,"退还委托简历".$this->config['integral_pricename'],true,2,'integral');  
			}
		}else{
			$this->obj->DB_update_all("resume_expect","`is_entrust`=".$status,"`uid`='".$user_entrust['uid']."' and `id`='".$user_entrust['eid']."'");
		}
		$id=$this->obj->DB_update_all("user_entrust","`status`='$status'","`uid`='".$user_entrust['uid']."' and `id`='".$pid."'");
 		$id?$this->ACT_layer_msg( "委托简历(ID:".$user_entrust['id'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function recom_action(){
		$this->yunset($this->MODEL('cache')->GetCache(array('com','city','job')));
		$urlarr['c']='recom';
		$row=$this->obj->DB_select_once("resume_expect","`id`='".$_GET['eid']."'");
		$user_entrust=$this->obj->DB_select_once("user_entrust","`id`='".$_GET['id']."'");
		$record=$this->obj->DB_select_all("user_entrust_record","`eid`='".$_GET['eid']."'","`jobid`");
		if(is_array($record)){
			foreach($record as $v){
				$jobid[]=$v['jobid'];
			}
		}
		$where="`state`='1' and `edate`>'".time()."' and `r_status`<>'2'";
		$urlarr['eid']=$_GET['eid'];
		$urlarr['id']=$_GET['id'];
		if($_GET["keyword"]!=""){
			if ($_GET['type']=='1'){
				$where.=" and `com_name` like '%".trim($_GET["keyword"])."%'";
			}elseif ($_GET['type']=='2'){
				$where.=" and `name` like '%".trim($_GET["keyword"])."%'";
			}
			$urlarr["type"]=$_GET["type"];
			$urlarr["keyword"]=$_GET["keyword"];
		}
		if($row['provinceid'] || $row['job_classid']){
			$where.=" and `provinceid`='".$row['provinceid']."' and `job_post` in(".pylode(',', $row['job_classid']).")";
			$urlarr['provinceid']=$_GET['provinceid'];
			$urlarr['job_post']=$_GET['job_post'];
		}
		
		if(is_array($jobid)){
			$where.=" and `id` not in (".@implode(",",$jobid).")";
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by lastupdate desc";
		}
		$urlarr["c"]="recom";
		$urlarr["page"]="{{page}}";
		$pageurl=Url('admin_trust',$urlarr,'admin');
        $M=$this->MODEL();
		$rows=$M->get_page("company_job",$where,$pageurl,$this->config['sy_listnum'],"`uid`,`name`,`hy`,`job1`,`job1_son`,`provinceid`,`cityid`,`job_post`,`id`,`minsalary`,`maxsalary`");
		$this->yunset($rows);
		$rows=$rows['rows'];

		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$uids[]=$val['uid'];
			}
			$company=$M->DB_select_all("company","`uid` in(".@implode(',',$uids).")","`uid`,`name`,`linkmail`");
			foreach($rows as $key=>$val){
				foreach($company as $value){
					if($val['uid']==$value['uid']){
						$rows[$key]['bname']=$value['name'];
						$rows[$key]['mail']=$value['linkmail'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("row",$row);
		$this->yuntpl(array('admin/admin_trust_recom'));
	}
	function directrecom_action(){ 
 		if($_GET['eid']&&$_GET['jobid']){
 			$row=$this->obj->DB_select_once("user_entrust_record","`jobid`='".$_GET['jobid']."' and `eid`='".$_GET['eid']."'");
			if(!empty($row)){
				$arr['msg']=iconv('gbk','utf-8','请勿重复推荐！');
				$arr['type']='8';
			}
			$linkmail=$this->obj->DB_select_once("company","`uid`='".$_GET['comid']."'","`linkmail`,`uid`,`did`");
			$resume=$this->obj->DB_select_once("resume_expect","`id`='".$_GET['eid']."'","`uid`");
			$id=$this->obj->DB_insert_once("user_entrust_record","`jobid`='".$_GET['jobid']."',`uid`='".$resume['uid']."',`eid`='".$_GET['eid']."',`comid`='".$_GET['comid']."',`ctime`='".time()."',`did`='".$linkmail['did']."'");
			if($id){
				$contents=file_get_contents($this->config['sy_weburl']."/index.php?m=resume&c=sendresume&id=".$_GET['eid']."&type=charge");

				$emailData['to'] = $linkmail['linkmail'];
				$emailData['subject'] = $this->config['sy_webname']."向您推荐了简历！";
				$emailData['content'] = $contents;
				$sendid = $this->sendemail($emailData);	

				$arr['msg']=iconv('gbk','utf-8','推荐成功！');
				$arr['type']='9';
			}else{
				$arr['msg']=iconv('gbk','utf-8','推荐失败');
				$arr['type']='8';
			}

			echo json_encode($arr);die;
		}
	}
	function del_action(){
		$this->check_token();
		if(is_array($_GET['del'])){
			$linkid=@implode(',',$_GET['del']);
			$layer_type=1;
		}else if($_GET["id"]){
			$linkid=$_GET["id"];
			$layer_type=0;
		}
		$eid=$this->obj->DB_select_all("user_entrust","`id` in (".$linkid.")","`eid`"); 
		if(is_array($eid)&&$eid){
			foreach($eid as $val){
				$eids[]=$val['eid'];
			}
			$this->obj->DB_update_all("resume_expect","`is_entrust`='0'","`id` in(".@implode(',',$eids).")","resume_expect");
		}
		$del=$this->obj->DB_delete_all("user_entrust","`id` in (".$linkid.")"," ");
		$del?$this->layer_msg('委托简历(ID:'.$linkid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

}

?>