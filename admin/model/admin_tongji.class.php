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
class admin_tongji_controller extends common
{	

	function index_action(){
		
		$this->yuntpl(array('admin/admin_tongji'));
	}
	
	function reg_action(){
		
		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('member',$_GET,'reg_date');
		$List['all']['name'] = '所有会员';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$comStats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='2'");
		$List['com']['name'] = '企业会员';
		$List['com']['list'] = $comStats['list'];
		$AllNum['com'] = $comStats['allnum'];
		
		$userStats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='1'");
		$List['user']['name'] = '个人会员';
		$List['user']['list'] = $userStats['list'];


		$CountTj = $TongJi->DataTj('reg',$Stats['timedate']['DateWhere'],'member','uid');
		
		$this->yunset('counttj',$CountTj);
		$AllNum['user'] = $userStats['allnum'];
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','会员注册统计');

		$this->yuntpl(array('admin/admin_tongji_reg'));
	}
	function lookjob_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('look_job',$_GET,'datetime');
		
		$List['all']['name'] = '职位浏览';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['job'] = $TongJi->TopTen("look_job",$Stats['timedate']['DateWhere'],"jobid","job");

		$TopList['company'] = $TongJi->TopTen("look_job",$Stats['timedate']['DateWhere'],"com_id","company");
		
		
		$this->yunset('toplist',$TopList);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','职位浏览统计');

		$this->yuntpl(array('admin/admin_tongji_lookjob'));
	
	}

	function lookresume_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('look_resume',$_GET,'datetime');
		$List['all']['name'] = '简历浏览';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['expect'] = $TongJi->TopTen("look_resume",$Stats['timedate']['DateWhere'],"resume_id","expect");

		$TopList['company'] = $TongJi->TopTen("look_resume",$Stats['timedate']['DateWhere'],"com_id","company");
		
		$this->yunset('toplist',$TopList);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','简历浏览统计');

		$this->yuntpl(array('admin/admin_tongji_lookresume'));
	
	}

	function useridmsg_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('userid_msg',$_GET,'datetime');
		$List['all']['name'] = '邀请面试';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['company'] = $TongJi->TopTen("userid_msg",$Stats['timedate']['DateWhere'],"fid","company");
		
		$TopList['resume'] = $TongJi->TopTen("userid_msg",$Stats['timedate']['DateWhere'],"uid","resume");

		$CountTj = $TongJi->DataTj('job',$Stats['timedate']['DateWhere'],'userid_msg','jobid');
		
		$this->yunset('counttj',$CountTj);
		$this->yunset('toplist',$TopList);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','邀请面试统计');

		$this->yuntpl(array('admin/admin_tongji_useridmsg'));
	
	}

	function downresume_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('down_resume',$_GET,'downtime');
		$List['all']['name'] = '简历下载';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$TopList['company'] = $TongJi->TopTen("down_resume",$Stats['timedate']['DateWhere'],"comid","company");
		
		$TopList['resume'] = $TongJi->TopTen("down_resume",$Stats['timedate']['DateWhere'],"uid","resume");

		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'down_resume','eid');
		
		$this->yunset('counttj',$CountTj);
		$this->yunset('toplist',$TopList);

		
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','简历下载统计');

		$this->yuntpl(array('admin/admin_tongji_downresume'));
	
	}
	function useridjob_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('userid_job',$_GET,'datetime');
		$List['all']['name'] = '简历投递';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['company'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"com_id","company");

		$TopList['resume'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"eid","expect");
		
		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'userid_job','eid');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','简历投递统计');

		$this->yuntpl(array('admin/admin_tongji_useridjob'));
	
	}
	function order_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_order',$_GET,'order_time',"`order_state`='2'","SUM(`order_price`) as count");
		$List['all']['name'] = '充值金额';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		
		$TopList['company'] = $TongJi->TopTen("company_order",$Stats['timedate']['DateWhere']." AND `order_state`='2'","uid","order",'10',"SUM(`order_price`) as count");
		 
		$CountTj = $TongJi->DataTj('order',$Stats['timedate']['DateWhere']." AND `order_state`='2'",'company_order','id');
		

		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);

		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','充值金额统计');

		$this->yuntpl(array('admin/admin_tongji_order'));
	
	}

	function pay_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_pay',$_GET,'pay_time');
		$List['all']['name'] = '消费记录';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','消费记录统计');

		$this->yuntpl(array('admin/admin_tongji_pay'));
	
	}

	function job_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_job',$_GET,'sdate');
		$List['all']['name'] = '发布职位';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];		
		
		$TopList['company'] = $TongJi->TopTen("company_job",$Stats['timedate']['DateWhere'],"uid","company");

		$CountTj = $TongJi->DataTj('job',$Stats['timedate']['DateWhere'],'company_job','id');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','发布职位统计');

		$this->yuntpl(array('admin/admin_tongji_job'));
	
	}
	function resume_action(){

		$TongJi=$this->MODEL('tongji');
		$Stats = $TongJi->getTj('resume_expect',$_GET,'lastupdate');
		$List['all']['name'] = '发布简历';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];		
		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'resume_expect','id');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','发布职位统计');

		$this->yuntpl(array('admin/admin_tongji_resume'));
	
	}

	function rating_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_statis',$_GET,'sdate');
		$List['all']['name'] = '会员办理';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$TopList['company'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"com_id","company");

		$TopList['resume'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"eid","expect");
		
		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'userid_job','eid');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','会员办理统计');

		$this->yuntpl(array('admin/admin_tongji'));
	
	}
	function company_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='2'");
		$List['all']['name'] = '企业统计';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$comStats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='2' AND `status`='0'");
		$List['com']['name'] = '待审核企业';
		$List['com']['list'] = $comStats['list'];
		$AllNum['com'] = $comStats['allnum'];


		$CountTj = $TongJi->DataTj('company',$Stats['timedate']['DateWhere'],'member','uid');
		
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','企业统计');

		$this->yuntpl(array('admin/admin_tongji_company'));
	
	}
	function ad_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('adclick',$_GET,'addtime');
		$List['all']['name'] = '点击量';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$TopList['ad'] = $TongJi->TopTen("adclick",$Stats['timedate']['DateWhere'],"aid","ad");

		$this->yunset('toplist',$TopList);

		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','广告点击统计');

		$this->yuntpl(array('admin/admin_tongji_ad'));
	
	}

	
}

?>