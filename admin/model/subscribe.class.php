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
class subscribe_controller extends common
{
	function set_search(){
		$search_list[]=array("param"=>"type","name"=>'订阅类型',"value"=>array("1"=>"订阅职位","2"=>"订阅简历"));
		$search_list[]=array("param"=>"state","name"=>'状态',"value"=>array("1"=>"已认证","2"=>"未认证"));
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'订阅时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
	    $where="1";
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `ctime` >='".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `ctime`>'".strtotime('-'.intval($_GET['end']).' day')."'";
			}
			
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['type']){ 
			$where.=" and `type`='".(int)$_GET['type']."'"; 
			$urlarr['type']=(int)$_GET['type'];
		}
		if($_GET['state']){
			if($_GET['state']=='2'){
				$where.=" and `status`='0'";
			}else{
				$where.=" and `status`='".$_GET['state']."'";
			}
			$urlarr['state']=$_GET['state'];
		}
		if(trim($_GET['keyword'])){
			$where.=" and `email` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']="".$_GET['keyword']."";
		}
		if($_GET['order'])
			{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
				$urlarr['order']=$_GET['order'];
				$urlarr['t']=$_GET['t'];
			}else{
				$where.=" order by ctime desc";
			}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows=$this->get_page("subscribe",$where,$pageurl,$this->config['sy_listnum']);
		include PLUS_PATH."/user.cache.php";
		include PLUS_PATH."/com.cache.php";
		include PLUS_PATH."/job.cache.php";
		include PLUS_PATH."/city.cache.php";
		if(is_array($rows)){
			foreach($rows as $k=>$v){
                $rows[$k]['job1']=$job_name[$v['job1']];
				$rows[$k]['job1_son']=$job_name[$v['job1_son']];
				$rows[$k]['job_post']=$job_name[$v['job_post']];
				$rows[$k]['minsalary']=$v['minsalary'];
				$rows[$k]['maxsalary']=$v['maxsalary'];
				$rows[$k]['provinceid']=$city_name[$v['provinceid']];
				$rows[$k]['cityid']=$city_name[$v['cityid']];
				$rows[$k]['three_cityid']=$city_name[$v['three_cityid']];
			}
		}
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/subscribe_list'));
	}

	function del_action()
	{
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$layer_type=1;
					$this->obj->DB_delete_all("subscribe","`id` in(".@implode(',',$del).")","");
					$this->obj->DB_delete_all("subscriberecord","`sid` in(".@implode(',',$del).")","");
					$del=@implode(',',$del);
		    	}else{
					$this->obj->DB_delete_all("subscribe","`id`='$del'");
					$this->obj->DB_delete_all("subscriberecord","`sid`='$del'","");
					$layer_type=0;
		    	}
				$this->layer_msg('订阅(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的信息！',8,0,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
}

?>