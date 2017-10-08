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
		// $f_time=array('1'=>'初级','2'=>'中级','3'=>'高级');
		// $search_list[]=array("param"=>"grade","name"=>'评价等级',"value"=>$f_time);
		$this->yunset("search_list",$search_list);
	}
	//评价 接受的参数：id (phpyun_admin_resume_expect.id) 、by (admin);查询的表phpyun_admin_resume_evalution
	function evaluation_action()
	{
		if($_GET[id]){
			$resume = $this->obj->DB_select_once('resume_expect','id=' . intval($_GET[id]));
			$result = $this->get_evaluation_list($_GET[id]);
			$this->yunset("id",$_GET[id]);
			$this->yunset("resume",$resume);
			$this->yunset($result['rows']);
			$this->yunset("get_type", $_GET);
			$this->yuntpl(array('admin/admin_resume_evaluation'));
		}
	}
	//评价 简历列表
	function index_action()
	{
		$this->set_search();

		$select_sql = 'select c.id,a.com_name,a.resume_expect_id,a.created_at,b.username as uname,c.name as resume_name ';
		$from = ' from '.$this->def.'resume_evaluation a,';
		$from .= $this->def.'member b,';
		$from .= $this->def.'resume_expect c ';

		$where=' where a.uid=b.uid and c.id=a.resume_expect_id ';
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and a.`created_at` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and a.`created_at` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
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
		$where .=" order by a.created_at desc";

		$select_sql .= $from .' '.$where; 
		$selectSql = 'select * from ('.$select_sql.') as con group by resume_expect_id order by resume_expect_id '.$order;
		$countSql = 'select count(a.id) as num ' . $from . $where .' group by a.resume_expect_id';

        $M=$this->MODEL();
		$list = $M->get_page_by_sql($selectSql,$countSql,$pageurl);
		$this->yunset($list);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_evaluation_resume'));
	}
	//添加简历评价
	function add_action() {
		if($_POST['evaluationadd'] && $_POST['id']) {
			$M = $this->MODEL();
			$resume = $M->DB_select_once('resume_expect','id=' . intval($_POST['id']));
			if($resume) {
				$value = "`uid`='".$resume['uid']."',";
				$value .= "`by_uid`='".$_SESSION['auid']."',";
				$value .= "`by_user_type`='0',";
				$value .= "`resume_expect_id`='". $resume['id'] ."',";
				$value .= "`com_name`=' ',";
				$value .= "`content`='".$_POST['content']."',";
				// $value .= "`score`='".$_POST['score']."',";
				$value .= "`created_at`='".date('Y-m-d H:i:s')."',";
				$value .= "`updated_at`='".date('Y-m-d H:i:s')."'";
				$row = $M->DB_insert_once('resume_evaluation',$value);
				if($row) {
					$this->ACT_layer_msg( "添加评论成功！",9,'index.php?m=admin_resume_evaluation&c=evaluation&id='.$_POST['id'],2,1);
				} else {
					$this->ACT_layer_msg( "添加评论失败！",8,'index.php?m=admin_resume_evaluation&c=evaluation&id='.$_POST['id']);
				}
			}
			
		}
		die();
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
		return $this->obj->DB_delete_all("resume_evaluation","`id`='".$id."'" );
	}
	//设置勿扰接受的参数：id 、uid;对应的表phpyun_resume_expect
	function undisturb_action()
	{
		$result = $this->obj->DB_update_all('resume_expect','`undisturb`="'.$_POST['status'].'"','`id`="'.$_POST['id'].'" and `uid`="'.$_POST['uid'].'"');
		if($result) {
			$this->ACT_layer_msg("简历勿扰(ID:".$uid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		} else {
			$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
		}
	}


	//获取评价列表内容
	function get_evaluation_list($resume_expect_id=false)
	{

		$selectSql = 'select a.id,a.com_name,a.grade,a.score,a.created_at,a.content,b.username as uname,c.name as resume_name,d.username as by_username ';
		$countSql = 'select count(a.id) as num';
		$from = ' from '.$this->def.'resume_evaluation a,';
		$from .= $this->def.'member b,';
		$from .= $this->def.'resume_expect c,';
		$from .= $this->def.'member d ';

		$where=' where a.uid=b.uid and a.by_uid=d.uid and c.id=a.resume_expect_id ';
		if($resume_expect_id) {
			$where .= ' and a.resume_expect_id='. intval($resume_expect_id) . ' ';
		}

		$page_url['order']=$_GET['order'];
		$page_url['page']="{{page}}";
		$pageurl=Url($_GET['m'],$page_url,'admin');
		if($_GET['order'])
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}

		$selectSql .= $from .' '.$where . ' order by a.id '.$order; 
		$countSql .= $from .' '.$where; 

        $M=$this->MODEL();
		$list = $M->get_page_by_sql($selectSql,$countSql,$pageurl);
		return array('rows' => $list,'get_type'=>$_GET );
	}

	//评价 简历列表
	function index2_action()
	{
		$this->set_search();

		$select_sql = 'select a.id,a.com_name,a.resume_expect_id,a.created_at,b.username as uname,c.name as resume_name ';
		// $select_sql = 'select a.id,a.com_name,a.grade,a.score,a.created_at,a.content,b.username as uname,c.name as resume_name,d.username as by_username ';
		$from = ' from '.$this->def.'resume_evaluation a,';
		$from .= $this->def.'member b,';
		$from .= $this->def.'resume_expect c ';
		// $from .= $this->def.'member d ';

		$where=' where a.uid=b.uid and c.id=a.resume_expect_id ';
		// $where=' where a.uid=b.uid and a.by_uid=d.uid and c.id=a.resume_expect_id ';
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and a.`created_at` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and a.`created_at` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		// if($_GET['grade']){
		// 	$where.=" and a.`grade` = ".$_GET['grade'];
		// 	$urlarr['grade']=$_GET['grade'];
		// }
	
		if($_GET['order'])
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}

		$page_url['order']=$_GET['order'];
		$page_url['page']="{{page}}";
		$pageurl=Url($_GET['m'],$page_url,'admin');
		$where .=" order by a.created_at desc";

		$select_sql .= $from .' '.$where; 
		$selectSql = 'select * from ('.$select_sql.') as con group by resume_expect_id order by resume_expect_id '.$order;
		$countSql = 'select count(a.id) as num ' . $from . $where .' group by a.resume_expect_id';

        $M=$this->MODEL();
		$list = $M->get_page_by_sql($selectSql,$countSql,$pageurl);
		$this->yunset($list);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_evaluation_resume'));
	}

}
?>