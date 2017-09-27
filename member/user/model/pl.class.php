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
class pl_controller extends user{

	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"pl","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("company_msg","`uid`='".$this->uid."'order by `ctime`",$pageurl,"10");
		foreach($rows as $v){
			$uid[]=$v['cuid'];
		}
		$uids=@implode(',',$uid);
		$name=$this->obj->DB_select_all("company","`uid`in(".$uids.")","`name`,`uid`");
	
		foreach($rows as $key=>$val){
			foreach($name as $k=>$v){
				if($val['cuid']==$v['uid']){
					$rows[$key]['com_name']=$v['name'];
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->user_tpl('pl');
	}
    function del_action(){
        if($_GET['id']){
            $nid=$this->obj->DB_delete_all("company_msg","`id`='".(int)$_GET['id']."' AND `uid`='".$this->uid."'"," ");
            $this->obj->member_log("删除企业评论");
            if($nid){
	            $this->layer_msg('删除成功！',9);
            }else{
	            $this->layer_msg('删除失败！',8);
            }
        }
    }
}
?>