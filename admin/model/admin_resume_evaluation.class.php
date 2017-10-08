<?php
/*
* 
*�����������۹���
* 
 */
class admin_resume_evaluation_controller extends common{

	//����������
	function set_search(){

		$lo_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$search_list[]=array("param"=>"time","name"=>'����ʱ��',"value"=>$lo_time);
		// $f_time=array('1'=>'����','2'=>'�м�','3'=>'�߼�');
		// $search_list[]=array("param"=>"grade","name"=>'���۵ȼ�',"value"=>$f_time);
		$this->yunset("search_list",$search_list);
	}
	//���� ���ܵĲ�����id (phpyun_admin_resume_expect.id) ��by (admin);��ѯ�ı�phpyun_admin_resume_evalution
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
	//���� �����б�
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
	//��Ӽ�������
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
					$this->ACT_layer_msg( "������۳ɹ���",9,'index.php?m=admin_resume_evaluation&c=evaluation&id='.$_POST['id'],2,1);
				} else {
					$this->ACT_layer_msg( "�������ʧ�ܣ�",8,'index.php?m=admin_resume_evaluation&c=evaluation&id='.$_POST['id']);
				}
			}
			
		}
		die();
	}
	
	//ɾ����������
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
				$this->layer_msg("��������(ID:".$del.")ɾ���ɹ���",9,$layer_type,$_SERVER['HTTP_REFERER'],2,1);
	    	}else{
				$this->layer_msg("��ѡ����Ҫɾ������Ϣ��",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
	//ɾ����������sql
	function del_member($id)
	{
		return $this->obj->DB_delete_all("resume_evaluation","`id`='".$id."'" );
	}
	//�������Ž��ܵĲ�����id ��uid;��Ӧ�ı�phpyun_resume_expect
	function undisturb_action()
	{
		$result = $this->obj->DB_update_all('resume_expect','`undisturb`="'.$_POST['status'].'"','`id`="'.$_POST['id'].'" and `uid`="'.$_POST['uid'].'"');
		if($result) {
			$this->ACT_layer_msg("��������(ID:".$uid.")���óɹ���",9,$_SERVER['HTTP_REFERER'],2,1);
		} else {
			$this->ACT_layer_msg( "����ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
		}
	}


	//��ȡ�����б�����
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

	//���� �����б�
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