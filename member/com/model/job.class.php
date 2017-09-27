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
class job_controller extends company{
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"job","page"=>"{{page}}");		
		$where="`uid`='".$this->uid."' ";
		if($_GET['keyword']){
			$where .= " and `name` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['w']==4){
			$where .= " and `status`='1'";
			$urlarr['w']=$_GET['w'];
		}elseif($_GET["w"]==2){
			$where .= " and `edate`<'".time()."'";
			$urlarr['w']=2;
		}elseif($_GET["w"]==1){
			$where .= "  and `status`='0' and `state`='1'";
			$urlarr['w']=1;
		}elseif($_GET["w"]==5){
			$where .= "and 1";
			$urlarr['w']=5;
		}else{
			$where .= " and `state`='".$_GET['w']."'";
			$urlarr['w']=$_GET['w'];
		} 
		
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("company_job",$where,$pageurl,'10');
		if(is_array($rows) && !empty($rows)){ 
			$jobids=array();
			foreach($rows as $v){
				$jobids[]=$v['id'];
			}
			$jobnum=$this->obj->DB_select_all("userid_job","`job_id` in(".pylode(',',$jobids).") and `com_id`='".$this->uid."' GROUP BY `job_id`","`job_id`,count(`id`) as `num`");
			foreach($rows as $k=>$v){
				if($v['autotime']>time()){
					$rows[$k]['autodate']=date("Y-m-d",$v['autotime']);
				}
				if($v['xsdate']>time()){
				    $rows[$k]['xs']=1;
				}
				$rows[$k]['jobnum']=0;
				foreach($jobnum as $val){
					if($v['id']==$val['job_id']){
						$rows[$k]['jobnum']=$val['num'];
					}
				} 
			}
		}
		$maxfen=$this->obj->DB_select_once("company_job","`state`='1' and `sdate`<'".mktime()."' and `r_status`<>'2' and `edate`>'".mktime()."' order by `xuanshang` desc",'xuanshang'); 
		$urgent=$this->config['com_urgent'];
		 
		$audit=$this->obj->DB_select_num("company_job","`uid`='".$this->uid."' and `state`=0"); 
		$this->yunset("audit",$audit); 
		$this->yunset("rows",$rows);
		$this->yunset("urgent",$urgent);
		$this->yunset("maxfen",$maxfen);
		$this->company_satic();
		$this->yunset("js_def",3);
		if(intval($_GET['w'])==1){
			$this->com_tpl('joblist');
		}else{
			$this->com_tpl('job');
		}
	}
	function opera_action(){
		$this->job();
	}
	function buyautojob_action(){
		$jobautoids=@explode(',',$_POST['jobautoids']); 
		$jobautoids = pylode(',',$jobautoids); 
		$autodays= intval($_POST['crdays']); 
		$autotype = 1; 
		$synalljob = intval($_POST['synalljob']); 
		if($autodays<1){
			$autodays= intval($_POST['rdays']); 
		}
		if($autodays>0&&$jobautoids){ 
			
			$buyprice = ceil($autodays*$this->config['job_auto']); 
			$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'","`integral`");
			if($synalljob=='1'){  
				$jobs=$this->obj->DB_select_all("company_job","`uid`='".$this->uid."'","`autotime`,`id`");
			}else{
				$jobs=$this->obj->DB_select_all("company_job","`uid`='".$this->uid."' and `id` in(".$jobautoids.")","`autotime`,`id`");
			} 
			if($statis['integral']>=$buyprice ||$this->config['job_auto_type']=="1"){
				if($this->config['job_auto_type']=="1"){
					$auto=true;
				}else{
					$auto=false;
				}
				$nid=$this->company_invtal($this->uid,$buyprice,$auto,"购买职位自动刷新",true,2,'integral',9);
				if($nid){ 
					$lastautotime=0;
					foreach($jobs as $v){
						if($v['autotime']>=time()){
							$autotime = $v['autotime']+$autodays*86400;
						}else{
							$autotime = time()+$autodays*86400;
						}
						if($autotime>$lastautotime){
							$lastautotime=$autotime;
						}
						$this->obj->update_once('company_job',array('autotime'=>$autotime,'autotype'=>$autotype),"`uid`='".$this->uid."' and `id`='".$v['id']."'");  
					} 
					$this->obj->update_once('company_statis',array('autotime'=>$lastautotime),array('uid'=>$this->uid));   
					$this->obj->member_log("购买职位自动刷新功能");
					$this->ACT_layer_msg("购买成功，有效期至".date('Y-m-d',$autotime),9,"index.php?c=job&w=1");
				}else{
					$this->ACT_layer_msg("购买失败！",8,"index.php?c=job&w=1");
				}
			}else{
				$this->ACT_layer_msg("您的".$this->config['integral_pricename']."余额不足，请先兑换或者充值！",8,"index.php?c=job&w=1");
			}
		}else{
			$this->ACT_layer_msg("请填写一个有效的购买期限！",8,"index.php?c=job&w=1");
		}
	}
	function bidding_action(){

		$where="`uid`='".$this->uid."' and `xsdate`>'".time()."'";
		$urlarr=array("c"=>"job",'act'=>'bidding',"page"=>"{{page}}");
		if(trim($_GET['keyword'])){
			$where.=" and `name` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']=trim($_GET['keyword']);
		}
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("company_job",$where,$pageurl,"10"); 
		$this->yunset("rows",$rows);
		$this->yunset("js_def",3);
		$this->company_satic();
		$this->com_tpl('bidding');
	} 
	function refresh_action(){		
		$nid=$this->obj->DB_update_all("company_job","`lastupdate`='".time()."'","`uid`='".$this->uid."' and `id`='".(int)$_POST['id']."'");
		if($nid){
			$this->obj->DB_update_all("company","`lastupdate`='".time()."'","`uid`='".$this->uid."'");							
			echo 1;
		}			
	}
}
?>