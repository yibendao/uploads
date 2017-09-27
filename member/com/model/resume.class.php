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
class resume_controller extends company{
    function index_action(){
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
        $uptime=array(1=>'今天',3=>'最近3天',7=>'最近7天',30=>'最近一个月',90=>'最近三个月');
        $this->yunset('uptime',$uptime);
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache (array('city','user','job','hy'));
        $date=date("Y",0);
        $time=date("Y",time());
        $this->yunset("date",$date);
        $this->yunset("time",$time);
        $this->yunset($CacheList);
        $this->yunset("type",$_GET['type']);
        $this->public_action();
        $this->yunset("js_def",5);
        $this->com_tpl('resume');
    }
}