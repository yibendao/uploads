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
class index_controller extends user{
	function index_action(){
		$this->public_action();
		$this->member_satic();
        $this->com_cache(); 
		$this->user_cache(); 
		include_once PLUS_PATH."/job.cache.php";
		$yqnum=$this->obj->DB_select_num("userid_msg","`uid`='".$this->uid."'");
		$msgnum=$this->obj->DB_select_num("userid_msg","`uid`='".$this->uid."'  and `is_browse`='1'");
		$msg_count=$this->obj->DB_select_num("message","`fa_uid`='".$this->uid."' and `username`='管理员'");
		$lookNum=$this->obj->DB_select_num("look_resume","`uid`='".$this->uid."' and `status`<>'1'");
		$downNum=$this->obj->DB_select_num("down_resume","`uid`='".$this->uid."'");

		$finder=$this->finder();
		$this->config['user_finder']<count($finder)?$findernum=0:$findernum=$this->config['user_finder']-count($finder);
		$this->yunset("yqnum",$yqnum);
		$this->yunset("finder", $finder);
		$this->yunset("findernum", $findernum); 
		$this->yunset("msgnum", $msgnum);
		$this->yunset("msg_count",$msg_count);
		$this->yunset("lookNum",$lookNum);
		$this->yunset("downNum",$downNum);
		$time=strtotime(date("Y-m-d 00:00:00"));
		$resume = $this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`def_job`,`name`,`status`,`email`,`telphone`,`idcard`,`moblie_status`,`email_status`,`sex`,`idcard_status`,`description`");
		$rlist=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."' order by `defaults` desc","id,name,job_classid,cityid,hits,jobstatus,integrity,minsalary,maxsalary,doc,tmpid,topdate,lastupdate");

		if($rlist&&is_array($rlist)){
			
			foreach($rlist as $k=>$v){
				$rlist[$k]['name']=mb_substr($v['name'],0,10,'gbk');
				$eid[]=$v['id'];
				if($v['job_classid']){
					$jobname = array();
					$jobclassid = explode(',',$v['job_classid']);
					foreach($jobclassid as $val){
						if($job_name[$val]){
							$jobname[]=$job_name[$val];
						}
					}
					$jobname = $jobname[0];
					$rlist[$k]['jobname']=$jobname;
				}
				if($v['minsalary'] && $v['maxsalary']){
					$rlist[$k]['user_salary'] =$v['minsalary']."-".$v['maxsalary'];
				}elseif($v['minsalary']){
					$rlist[$k]['user_salary'] =$v['minsalary']."以上";
				}else{
                    $rlist[$k]['user_salary'] ="面议";
                }
			}
			$user_resume=$this->obj->DB_select_all("user_resume","`eid` in (".@implode(",",$eid).")");
			foreach($rlist as $key=>$val){
				$resumelist="";
				foreach($rlist as $v){
					$resumelist.="<li><a href=\"javascript:check_select_resume('".$v[id]."');\">".$v['name']."</a></li>";
				}
				$html='<span>'.$val[name].'</span><div class="index_resume_my_n_list" id="resume_expect'.$val[id].'" style="display:none;"><ul>'.$resumelist.'</ul></div>';
				$rlist[$key]['resumelist']=$html;
				foreach($user_resume as $v){
					if($val['id']==$v['eid']){
						$rlist[$key]['skill']=$v['skill'];
						$rlist[$key]['work']=$v['work'];
						$rlist[$key]['project']=$v['project'];
						$rlist[$key]['edu']=$v['edu'];
						$rlist[$key]['training']=$v['training'];
						$rlist[$key]['cert']=$v['cert'];
						$rlist[$key]['other']=$v['other'];						
					}
				}
				
				if($val['id']==$resume['def_job']){
					$jobwhere="(`job_post` in (".$val['job_classid'].") or `job1_son` in (".$val['job_classid'].")) and `cityid` in (".$val['cityid'].") ";
				}
				if($val['topdate']>1){
					$rlist[$key]['topdate']=date("Y-m-d",$val['topdate']);
				}else{
					$rlist[$key]['topdate']='未设置';
				}
			}
			$_GET['jobwhere']=$jobwhere;
		}else{
			$_GET['jobwhere']="1=2";
		}
		$atnM=$this->MODEL('ask');
		$auids=$atnM->GetAtnList(array('uid'=>$this->uid),array('field'=>'uid,sc_uid'));
		if($auids&is_array($auids)){
		    foreach($auids as $v){
		        $jobs=$this->MODEL('job')->GetComjobOne(array('uid'=>$v['sc_uid'],'state'=>1,'`edate`>\''.time().'\' order by lastupdate desc'),array('field'=>'uid,id,com_name,name'));
		        if($jobs){
		            $ainfo[]=$jobs;
		        }
		    }
		}
		if($this->config['sy_onedomain']!=""){
			$weburl=get_domain($this->config['sy_onedomain']);
		}else{
			$weburl=get_domain($this->config['sy_weburl']);
		}
		SetCookie("jobrefresh",'1',time() + 86400, "/",$weburl);
		$this->yunset('ainfo',$ainfo);
		$this->yunset("rlist",$rlist);
		$this->yunset("resume",$resume);
		$this->yunset("time",$time);
		$this->user_tpl('index');
	}
}
?>