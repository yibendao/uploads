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
class admin_partjob_controller extends common
{
	function set_search(){
		include PLUS_PATH."/part.cache.php";
        foreach($comdata['job_type'] as $k=>$v){
               $comarr[$v]=$comclass_name[$v];
        }
        foreach($partdata['part_billing_cycle'] as $k=>$v){
               $billing_cycle[$v]=$partclass_name[$v];
        }
		$search_list[]=array("param"=>"state","name"=>'审核状态',"value"=>array("1"=>"已审核","4"=>"未审核","3"=>"未通过","2"=>"已过期"));
		$search_list[]=array("param"=>"lastupdate","name"=>'更新时间',"value"=>array("1"=>"今天","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
		$search_list[]=array("param"=>"edate","name"=>'结束日期',"value"=>array("1"=>"已到期","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
		$search_list[]=array("param"=>"billing_cycle","name"=>'结算周期',"value"=>$billing_cycle);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where=1;
        if(trim($_GET['keyword'])){
        	if($_GET['type']==1){
        		$where .=" and `com_name` like '%".trim($_GET['keyword'])."%'";
        	}else{
        		$where .=" and `name` like '%".trim($_GET['keyword'])."%'";
        	}
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['type']=$_GET['type'];
		}

		if($_GET['lastupdate']){
			if($_GET['lastupdate']=='1'){
				$where .=" and `lastupdate`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `lastupdate`>'".strtotime('-'.intval($_GET['lastupdate']).' day')."'";
			}
			$urlarr['lastupdate']=$_GET['lastupdate'];
		}
		if($_GET['edate']){
			if($_GET['edate']=='1'){
				$where .=" and `edate`<'".time()."'and `edate`>'0'";
			}else{
				$where .=" and `edate`<'".strtotime('+'.intval($_GET['edate']).' day')."' and `edate`>'".time()."'";
			} 
			$urlarr['edate']=$_GET['edate'];
		}

		if($_GET['state']){
			if($_GET['state']=="1"){
				$where.= " and `state`='1' and (`edate`>'".time()."'||`edate`='')";
			}elseif($_GET['state']=="2"){
				$where.= "  and `edate`<'".time()."' and `edate`>'0'";
			}elseif($_GET['state']=="3"){
				$where.= " and `state`='".$_GET['state']."'";
			}elseif($_GET['state']=="4"){
				$where.= "  and `state`='0'";
			}
			$urlarr['state']=$_GET['state'];
		}
		if ($_GET['billing_cycle']){
			$where .=" and `billing_cycle`='".$_GET['billing_cycle']."'";
			$urlarr['billing_cycle']=$_GET['billing_cycle'];
		}
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by state asc,id desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("partjob",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];
		if(is_array($rows)){
			include PLUS_PATH."part.cache.php";
			foreach($rows as $k=>$v){
				$rows[$k]['salary_type']=$partclass_name[$v['salary_type']];
				$rows[$k]['billing_cycle']=$partclass_name[$v['billing_cycle']];
				$rows[$k]['type']=$partclass_name[$v['type']];
				if($v['edate']==0){
					$rows[$k]['edatetxt'] = "长期招聘";
				}elseif($v['edate']<time()){
					$rows[$k]['edatetxt'] = "<font color='red'>已到期</font>";
				}elseif($v['edate']<(time()+3*86400)){
					$rows[$k]['edatetxt'] = "<font color='blue'>3天内到期</font>";
				}elseif($v['edate']<(time()+7*86400)){
					$rows[$k]['edatetxt'] = "<font color='blue'>7天内到期</font>";
				}else{
					$rows[$k]['edatetxt'] = date("Y-m-d",$v['edate']);
				}
				if($v['rec_time']>time()){
					$rows[$k]['rec_day'] = ceil(($v['rec_time']-time())/86400);
				}else{
					$rows[$k]['rec_day'] = "0";
				}
				if($v['rec_time']>1000){
					$rows[$k]['recdate']=date("Y-m-d",$v['rec_time']);
				}

			}
		}
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_partjob'));
	}

	function show_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','part')));
		$morning=array('0101','0201','0301','0401','0501','0601','0701');
		$noon=array('0102','0202','0302','0402','0502','0602','0702');
		$afternoon=array('0103','0203','0303','0403','0503','0603','0703');
		$this->yunset(array('morning'=>$morning,'noon'=>$noon,'afternoon'=>$afternoon));
		if($_GET['id']){
			$show=$this->obj->DB_select_once("partjob","id='".$_GET['id']."'");
			$show['worktime']=explode(',', $show['worktime']);
			$this->yunset("show",$show);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
			$this->yunset("today",date("Y-m-d"));
		}

		if($_POST['update']){
			if($_POST['worktime']){
				$_POST['worktime']=@implode(",",$_POST['worktime']);
			}
			$_POST['content']=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
			$_POST['sdate']=strtotime($_POST['sdate']);
			if($_POST['timetype']){
				$_POST['edate']="";
				$_POST['deadline']="";
			}else{
				$_POST['edate']=strtotime($_POST['edate']);
				$_POST['deadline']=strtotime($_POST['deadline']." 23:59:59");
			}
			$_POST['lastupdate'] = time();
			$_POST['state']=1;
			$lasturl=$_POST['lasturl'];
			unset($_POST['update']);unset($_POST['lasturl']);
			if($_POST['id']){
				$where['id']=$_POST['id'];
				unset($_POST['id']);
				$nid=$this->obj->update_once("partjob",$_POST,$where);
				if($nid){
					$this->ACT_layer_msg("兼职(ID:".$where['id'].")修改成功！",9,$lasturl,2,1);
				}else{
					$this->ACT_layer_msg("兼职(ID:".$where['id'].")修改成功！",8,$lasturl,2,1);
				}
			}
		}
		$this->yuntpl(array('admin/admin_partjob_show'));
	}

	function lockinfo_action(){
		$userinfo = $this->obj->DB_select_once("partjob","`id`='".$_POST['id']."'","`statusbody`");
		echo $userinfo['statusbody'];die;
	}
	function recommend_action()
	{
		extract($_POST);
		$addday=$_POST['addday'];
		if($addday<1&&$s==''){$this->ACT_layer_msg("推荐天数不能为空！",8);}
		$addtime = 86400*$addday;
		if($pid){
			if($s==1){
				$this->obj->DB_update_all("partjob","`rec_time`='0'","`id`='".$pid."'");
			}elseif($eid>time()){
				$this->obj->DB_update_all("partjob","`rec_time`=`rec_time`+$addtime","`id`='".$pid."'");
			}else{
				$this->obj->DB_update_all("partjob","`rec_time`=".time()."+$addtime","`id`='".$pid."'");
			}
			$this->ACT_layer_msg("职位推荐(ID:".$pid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		if(!empty($codearr)){
			if($s==1){
				$this->obj->DB_update_all("partjob","`rec_time`='0'","`id` in (".$codearr.")");
				$this->ACT_layer_msg("取消职位推荐设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
			}else{
				$list=$this->obj->DB_select_all("partjob","`id` in (".$codearr.")","`id`,`rec_time`");
                if(is_array($list)){
                	foreach($list as $v){
                        if($v['rec_time']<time()){
                       	    $gid[]=$v['id']; 
                        }else{
                       	    $mid[]=$v['id'];
                        }
                	}
                	$guoqi=@implode(",",$gid);
                	$meiguo=@implode(",",$mid);
                	if($guoqi!=""){
				        $this->obj->DB_update_all("partjob","`rec_time`=".time()."+$addtime","`id` in (".$guoqi.")");
                	}elseif($meiguo!=""){
				        $this->obj->DB_update_all("partjob","`rec_time`=`rec_time`+$addtime","`id` in (".$meiguo.")");
                	}
                	$this->ACT_layer_msg("职位推荐设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
                }
			}

		}
		$this->yunset("addday",$addday);

	}
	function ctime_action(){
		extract($_POST);
		$id=@explode(",",$jobid);
		if(is_array($id)){
			$posttime=intval($endtime)*86400;
			$rows=$this->obj->DB_select_all("partjob","`id` in(".pylode(',',$jobid).")","`id`,`state`,`edate`");
			foreach($rows as $value){
				if($value['edate']!=0){
					if($value['state']==2 || $value['edate']<time()){
						$time=time()+$posttime;
						$id=$this->obj->DB_update_all("partjob","`edate`='".$time."',`state`='1'","`id`='".$value['id']."'");
					}else{
						$time=$value['edate']+$posttime;
						$id=$this->obj->DB_update_all("partjob","`edate`='".$time."'","`id`='".$value['id']."'");
					}
				}
			}
			$id?$this->ACT_layer_msg("兼职职位延期(ID:".$jobid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function status_action(){
		extract($_POST);
		$id = @explode(",",$pid);
		if(is_array($id)){
			foreach($id as $value){
				if($value){
					$idlist[] = $value;
					$data[] = $this->shjobmsg($value,$status,$statusbody);
				}
			}
			if($data!=""){
				$smtp = $this->email_set();
				foreach($data as $key=>$value){
					$this->send_msg_email($value,$smtp);
				}
			}
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("partjob","`state`='$status',`statusbody`='".$statusbody."',`lastupdate`='".time()."'","`id` IN ($aid)");
			$id?$this->ACT_layer_msg("兼职职位审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function shjobmsg($jobid,$yesid,$statusbody){
		$data=array();
		$comarr=$this->obj->DB_select_once("partjob","`id`='".$jobid."'","uid,name");
		if($yesid==1){
			$data['type']="partshtg";
		}elseif($yesid==3){
			$data['type']="partshwtg";
		}
		if($data['type']!=""){
			$uid=$this->obj->DB_select_alls("member","company","a.`uid`='".$comarr['uid']."' and a.`uid`=b.`uid`","a.email,a.moblie,a.uid,b.name");
			$data['uid']=$uid[0]['uid'];
			$data['name']=$uid[0]['name'];
			$data['email']=$uid[0]['email'];
			$data['moblie']=$uid[0]['moblie'];
			$data['jobname']=$comarr['name'];
			$data['date']=date("Y-m-d H:i:s");
			$data['status_info']=$statusbody;
			return $data;
		}
	}
	function del_action()
	{
		$this->check_token();
	    if($_GET['del']||$_GET['id']){
    		if(is_array($_GET['del'])){
    			$layer_type=1;
				$del=@implode(',',$_GET['del']);
	    	}else{
	    		$layer_type=0;
	    		$del=$_GET['id'];
	    	}
			$this->obj->DB_delete_all("partjob","`id` in (".$del.")","");
			$this->obj->DB_delete_all("part_collect","`jobid` in (".$del.")","");
			$this->obj->DB_delete_all("part_apply","`jobid` in (".$del.")","");
			$this->layer_msg("兼职职位(ID:".$del.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
    	}else{
			$this->layer_msg("请选择您要删除的信息！",8,1);
    	}
	}
	function refresh_action()
	{
		$this->obj->DB_update_all("partjob","`lastupdate`='".time()."'","`id` in (".$_POST['ids'].")");
		$this->admin_log("兼职职位(ID".$_POST['ids']."刷新成功");
	}
}
?>