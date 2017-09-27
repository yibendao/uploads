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
class admin_appeal_controller extends common{
    function set_search(){
        $state=array('1'=>'未完成','2'=>'已完成');
        $search_list[]=array("param"=>"appealstate","name"=>'申诉情况',"value"=>$state);
        $this->yunset("search_list",$search_list);
    }
    function index_action(){
        $this->set_search();
        if(trim($_GET['keyword'])){
            $where="`username` like '%".trim($_GET['keyword'])."%' and `appeal`<>''";
            $urlarr['keyword']=$_GET['keyword'];
        }else{
            $where="`appeal`<>''";
        }
        if($_GET['appealstate']){
            if($_GET['appealstate']=='1'){
                $where.=" and `appealstate` = '1'";
            }else{
                $where.=" and `appealstate` = '2'";
            }
            $urlarr['appealstate']=$_GET['appealstate'];
        }
        if($_GET['order']){
            $where.=" order by ".$_GET['t']." ".$_GET['order'];
            $urlarr['order']=$_GET['order'];
            $urlarr['t']=$_GET['t'];
        }else{
            $where.=" order by appealstate asc,appealtime desc";
        }
        $urlarr['page']="{{page}}";
        $pageurl=Url($_GET['m'],$urlarr,'admin');
        $rows=$this->get_page("member",$where,$pageurl,$this->config['sy_listnum'],'uid,username,appeal,appealtime,appealstate,moblie,email');
        $this->yunset('rows',$rows);
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION["auid"]."'");
		$power=unserialize($nav_user[0]["group_power"]);
		if(in_array('141',$power)){
			$this->yunset("email_promiss", '1');
			$this->yunset("moblie_promiss", '1');
		} 
        $this->yuntpl(array('admin/admin_appeal'));
    }
    function info_action(){
		$info = $this->obj->DB_select_once("member","`uid`='".$_GET['id']."'");
		if($info['usertype']=='1'){
			$user = $this->obj->DB_select_once("resume","`uid`='".$info['uid']."'");
		}else if($info['usertype']=='2'){
			$user = $this->obj->DB_select_once("company","`uid`='".$info['uid']."'");
		}else if($info['usertype']=='3'){
			$user = $this->obj->DB_select_once("lt_info","`uid`='".$info['uid']."'","*,`realname` as `name`");
		}
		$this->yunset('user',$user);
		$this->yunset('info',$info);
		$this->yuntpl(array('admin/admin_appeal_info'));
	}
    function success_action(){
        if ($_GET['id']){
            $M=$this->MODEL('userinfo');
            $result=$M->UpdateMember(array('appealstate'=>'2'),array('uid'=>intval($_GET['id'])));
            isset($result)?$this->layer_msg('申诉确认成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('确认失败！',8,0,$_SERVER['HTTP_REFERER']);
        }
    }

    function del_action(){
        $M=$this->MODEL('userinfo');
        if(is_array($_POST['del'])){
            $delid=@pylode(',',$_POST['del']);
            $layer_type=1;
        }else{
            $this->check_token();
            $delid=(int)$_GET['id'];
            $layer_type=0;
        }
        if(!$delid){
            $this->layer_msg('请选择要删除的内容！',8,$layer_type,$_SERVER['HTTP_REFERER']);
        }
        $result=$M->UpdateMember(array('appeal'=>'','appealtime'=>'','appealstate'=>'1'),array("`uid` in(".$delid.")"));
        isset($result)?$this->layer_msg('申诉(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
    }
}