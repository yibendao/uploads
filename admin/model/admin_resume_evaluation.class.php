<?php
/*
* 
*新增简历评价管理
* 
 */
class admin_resume_evaluation_controller extends common{

	//设置搜索项
	function set_search(){

		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'评论时间',"value"=>$lo_time);
		$f_time=array('1'=>'初级','2'=>'中级','3'=>'高级');
		$search_list[]=array("param"=>"grade","name"=>'评价等级',"value"=>$f_time);
		$this->yunset("search_list",$search_list);
	}
	//简历评价列表
	function index_action()
	{
		$this->set_search();

		$selectSql = 'select a.id,a.com_name,a.grade,a.score,a.created_at,a.content,b.username as uname,c.name as resume_name,d.username as by_username ';
		$countSql = 'select count(a.id) as num';
		$from = ' from '.$this->def.'resume_evalution a,';
		$from .= $this->def.'member b,';
		$from .= $this->def.'resume_expect c,';
		$from .= $this->def.'member d ';

		$where=' where a.uid=b.uid and a.by_uid=d.uid and c.id=a.resume_expect_id ';
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and a.`created_at` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and a.`created_at` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['grade']){
			$where.=" and a.`grade` = ".$_GET['grade'];
			$urlarr['grade']=$_GET['grade'];
		}
	
		if($_GET['order'])
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}

		$page_url['order']=$_GET['order'];
		$page_url['page']="{{page}}";
		$pageurl=Url($_GET['m'],$page_url,'admin');

		$selectSql .= $from .' '.$where . ' order by a.id '.$order; 
		$countSql .= $from .' '.$where; 

        $M=$this->MODEL();
		$mes_list = $M->get_page_by_sql($selectSql,$countSql,$pageurl);
	
		$this->yunset($mes_list);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_resume_evalution'));
	}
	//删除简历评价
	function del_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
			    	foreach($del as $v){
			    	   $this->del_member($v);
			    	}
					$layer_type='1';
					$del=implode(",",$del);
		    	}else{
		    		 $this->del_member($del);
					 $layer_type='0';
		    	}
				$this->layer_msg("简历评价(ID:".$del.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER'],2,1);
	    	}else{
				$this->layer_msg("请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
	//删除简历评价sql
	function del_member($id)
	{
		return $this->obj->DB_delete_all("resume_evalution","`id`='".$id."'" );
	}
	//设置勿扰接受的参数：id 、uid;对应的表phpyun_admin_resume_expect
	function undisturb_action()
	{

	}
	//评价 接受的参数：id (phpyun_admin_resume_expect.id) 、by (admin);查询的表phpyun_admin_resume_evalution
	function evalution_action()
	{

	}

}
?>