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
class paylog_controller extends user
{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$this->public_action(); 
		$urlarr=array("c"=>"paylog","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$where="`com_id`='".$this->uid."'";

		$where.="  order by pay_time desc";
		$rows = $this->get_page("company_pay",$where,$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $k=>$v)
			{
				$rows[$k]['pay_time']=date("Y-m-d H:i:s",$v['pay_time']);
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("ordertype","ok");  
		$this->user_tpl('paylog');
	} 
	
}
?>