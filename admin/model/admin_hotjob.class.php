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
class admin_hotjob_controller extends common{
	function set_search(){
		$rating=$this->obj->DB_select_all("company_rating","`category`='1' order by `sort` asc","`id`,`name`");
		if(!empty($rating)){
			foreach($rating as $k=>$v){
                 $ratingarr[$v['id']]=$v['name'];
			}
		}
		$nrating=array();
		foreach($rating as $val){
			$nrating[$val['id']]=$val['name'];
		}
		$this->yunset("rating", $nrating);
		$edtime=array('1'=>'7天内','2'=>'一个月内','3'=>'半年内','4'=>'一年内');
		$this->yunset("edtime",$edtime);

		$search_list[]=array("param"=>"rating","name"=>'会员等级',"value"=>$ratingarr);
		$search_list[]=array("param"=>"time","name"=>'到期时间',"value"=>$edtime);
		$this->yunset("ratingarr",$ratingarr);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where=$mwhere="1";
		$uids=array();
		if($_GET['time']){
            if($_GET['time']=='1'){
            	$num="+7 day"; 
            }elseif($_GET['time']=='2'){
				$num="+1 month"; 
            }elseif($_GET['time']=='3'){
				$num="+6 month"; 
            }elseif($_GET['time']=='4'){
                $num="+1 year";
            }
			$where.=" and `time_end`>'".time()."' and `time_end`<'".strtotime($num)."'";
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['rating']){
			$where.=" and  `rating_id`='".$_GET['rating']."'";
			$urlarr['rating']=$_GET['rating'];
		}
	    if(trim($_GET['keyword'])){
	    	if($_GET['ctype']=='2'){
	    		$where .= " and `beizhu` like '%".trim($_GET['keyword'])."%' ";
	    	}else{
	    		$where .= " and `username` like '%".trim($_GET['keyword'])."%' ";
	    	}
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['order'])
		{
			if($_GET['t']=="time")
			{
				$where.=" order by `lastupdate` ".$_GET['order'];
			}else{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
			}
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by `time_start` desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("hotjob",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];
 		if(is_array($rows)&&$rows){
			if(empty($list)){
				$list=$this->obj->DB_select_all("company_statis","`uid` in (".@implode(",",$uids).")","`uid`,`pay`,`integral`,`rating`,`rating_name`,`vip_etime`,`msg_num`");
			}
 			foreach($rows as $k=>$v){ 
 				if(strlen($v['username'])>14){
					$rows[$k]['username']=mb_substr($v['username'],"0","12","gbk")."...";
 				}
				if(strlen($v['beizhu'])>24){
					$rows[$k]['beizhu']=mb_substr($v['beizhu'],"0","12","gbk")."...";
 				}
				if($v['did']<1)
				{
					$rows[$k]['did'] = 0;
				}
			}
		}	
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION["auid"]."'");
		$power=unserialize($nav_user[0]["group_power"]);
		if(in_array('141',$power)){
			$this->yunset("email_promiss", '1');
			$this->yunset("moblie_promiss", '1');
		} 
		$where=str_replace(array("(",")"),array("[","]"),$where);
		$this->yunset("where", $where);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_hotjob'));
	}
	function hotjobinfo_action(){
		if($_GET['id']){
			$hotjob=$this->obj->DB_select_once("hotjob","`uid`='".(int)$_GET['id']."'");
		}else if($_GET['uid']){
			$row = $this->obj->DB_select_alls("company","company_statis","a.`uid`='".(int)$_GET['uid']."' and b.`uid`='".(int)$_GET['uid']."'","a.`content`,a.`name` as username,b.`rating` as rating_id,b.`rating_name` as rating,a.`uid`,a.`logo` as hot_pic");
			$row=$row[0];
			$hotjob=$row;
			$hotjob['time_start']=time();
		}
		$this->yunset("hotjob",$hotjob);
		$this->yuntpl(array('admin/admin_hotjob_info'));
	}
	function del_action(){
		$this->check_token();
	    if($_GET['del']||$_GET['id']){
    		if(is_array($_GET['del'])){
    			$layer_type=1;
				$del=@implode(',',$_GET['del']);
	    	}else{
	    		$layer_type=0;
	    		$del=$_GET['id'];
	    	}
			$hot=$this->obj->DB_select_all("hotjob","`uid`in(".$del.")","`uid`,`hot_pic`");
			$result=$this->obj->DB_delete_all("hotjob","`uid`in(".$del.")","" );
			if($result){
				foreach($hot as $v){
					unlink_pic("../".$v['hot_pic']);
					$this->obj->DB_update_all("company","`hottime`=' ',`rec`='0'","`uid`='".$v['uid']."'");
				}
				$this->layer_msg('名企(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
    	}else{
			$this->layer_msg("请选择您要删除的信息！",8,1);
    	}
	}
	function save_action(){
		extract($_POST);
		if(is_uploaded_file($_FILES['hot_pic']['tmp_name'])){
			$upload=$this->upload_pic("../data/upload/hotpic/");
			$pictures=$upload->picture($_FILES['hot_pic']);
			$pic = str_replace("../data/upload","./data/upload",$pictures);
		}else{
			if($_POST['hotad']){
				$defpic=".".$defpic;
				$url=@explode("/",$defpic);
				$url2=str_replace($url[4],date("Ymd"),$defpic);
				$name=@explode(".",$url[5]);
				$url2=str_replace($name[0],time(),$url2);
				if(!file_exists('../data/upload/company/'.date("Ymd")))
				{
					mkdir ('../data/upload/company/'.date("Ymd"));
				}
				copy($defpic,$url2);
				$pic = str_replace("../data/upload","./data/upload",$url2);
			}
		}
		$com=$this->obj->DB_select_once("company","`uid`='".$uid."'","`did`");
		if($_POST['hotad']){
			$start = strtotime($time_start);
			$end = strtotime($time_end);
			$nid=$this->obj->DB_insert_once("hotjob","`uid`='$uid',`username`='$username',`sort`='$sort',`rating_id`='$rating_id',`rating`='$rating',`hot_pic`='$pic',`service_price`='$service_price',`beizhu`='$beizhu',`time_start`='$start',`time_end`='$end',`did`='".$com['did']."'");
			$this->obj->DB_update_all("company","`hottime`='".$end."',`rec`='1'","`uid`='".$uid."'");
			$this->ACT_layer_msg("名企(ID:".$nid.")设定成功！",9,"index.php?m=admin_company",2,1);
		}elseif($_POST['hotup']){
			$start = strtotime($time_start);
			$end = strtotime($time_end);
			$value = "`service_price`='$service_price',`time_start`='$start',`time_end`='$end',`beizhu`='$beizhu',`sort`='$sort',`did`='".$com['did']."'";
			if($pic!=""){
				$hot=$this->obj->DB_select_once("hotjob","`id`='$id'");
				unlink_pic("../".$hot['hot_pic']);
				$value.=",`hot_pic`='$pic'";
			}
			$this->obj->DB_update_all("hotjob",$value,"`id`='$id'");
			$this->obj->DB_update_all("company","`hottime`='".$end."'","`uid`='".$uid."'");
			$this->ACT_layer_msg("名企(ID:".$id.")修改成功！",9,"index.php?m=admin_hotjob",2,1);
		}
		$this->yuntpl(array('admin/admin_hotjob_add'));
	}
	
}
?>