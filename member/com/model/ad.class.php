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
class ad_controller extends company
{
	function index_action()
	{
		$this->public_action();
		$this->company_satic();
		$this->yunset("js_def",4);
		$rows=$this->obj->DB_select_all("ad_class","`type`='1'");
		$this->yunset("rows",$rows);
		$this->com_tpl('ad');
	}
	function adinfo_action()
	{
		if($_GET['id'])
		{
			$row=$this->obj->DB_select_once("ad_class","`id`='".(int)$_GET['id']."' and `type`='1'");
			if($row['id'])
			{
				$this->public_action();
				$this->company_satic();
				$this->yunset("js_def",4);
				$this->yunset("row",$row);
				$this->com_tpl('buyad');
			}else{
				$this->ACT_msg("index.php?c=ad","非法操作！");
			}
		}
	}
}
?>