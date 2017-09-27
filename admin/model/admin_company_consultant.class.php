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
class admin_company_consultant_controller extends common{
	function set_search(){
		$week=array("1"=>"周一","2"=>"周二","3"=>"周三","4"=>"周四","5"=>"周五","6"=>"周六","7"=>"周日");
		$search_list[]=array('param'=>'week','name'=>'值班时间','value'=>$week);
		$this->yunset("search_list",$search_list);
	}
function index_action(){
		$this->set_search();
		$where="1";
		$uids=array();
		if($_GET['week']){
			$where.=" and  FIND_IN_SET('".$_GET['week']."',`status`)";
			$urlarr['week']=$_GET['week'];
		}
		if(trim($_GET['keyword'])){
            if($_GET['com_type']=='1'){
				$where.= "  AND `username` like '%".trim($_GET['keyword'])."%' ";
            }elseif($_GET['com_type']=='2'){
				$where.=" AND `mobile` like '%".trim($_GET['keyword'])."%' ";
			}elseif($_GET['com_type']=='3'){
				$where.=" AND `qq` like '%".trim($_GET['keyword'])."%' ";
			}elseif($_GET['com_type']=='4'){
				$where.=" AND `weixin` like '%".trim($_GET['keyword'])."%' ";
			}
			$urlarr['com_type']=$_GET['com_type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['adtime']){
			if($_GET['adtime']=='1'){
				$where.=" and `adtime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `adtime` >= '".strtotime('-'.(int)$_GET['adtime'].'day')."'";
			}
			$urlarr['adtime']=$_GET['adtime'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr['c']="index";
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$rows=$this->get_page("company_consultant",$where,$pageurl,$this->config['sy_listnum']);
		if(!empty($rows)){
			foreach($rows as $key=>$value){
				$consultantId[] = $value['id'];
				
				$zbtime=@explode(',',$value['status']);
				$week=array("1"=>"周一","2"=>"周二","3"=>"周三","4"=>"周四","5"=>"周五","6"=>"周六","7"=>"周日");
				$weeks=array();
				foreach($zbtime as $v){
					$weeks[]=$week[$v];
				}
				$rows[$key]['zbstatus']=@implode(',',$weeks);
			}
			$companyNum = $this->obj->DB_select_all("company","`conid` in(".@implode(',',$consultantId).") group by conid","count(*) as num,conid");
			if(!empty($companyNum)){
				foreach($rows as $key=>$value){
					foreach($companyNum as $k=>$v){
						if($v['conid']==$value['id']){
							$rows[$key]['num'] = $v['num'];
						}
					}
					
					$rows[$key]['logo']=str_replace('./', $this->config['sy_weburl'].'/', $value['logo']);
				}
			}
		}
        $this->yunset('rows',$rows);
		$this->yuntpl(array('admin/admin_consultant_list'));
	}
	function del_action(){
		$this->check_token();
		if ($_GET['del']){
			$del=$_GET['del'];
			if ($del){
				if (is_array($del)){
					$del=@implode(',', $del);
					$layer_type=1;
				}else{		    		 
		    	    $layer_type=0;
				}
				$this->obj->DB_delete_all("company_consultant","`id` in (".$del.")","");
				$this->obj->DB_update_all("company","`conid`=''","`conid` in (".$del.")");
				$this->layer_msg("数据(ID:".$del.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('请选择您要删除的数据！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
	}

	function save_action(){
		if(is_uploaded_file($_FILES['logo']['tmp_name'])){
			$upload=$this->upload_pic("../data/upload/guwen/");
			$pictures=$upload->picture($_FILES['logo']);
			$pic = str_replace("../data/upload","./data/upload",$pictures);
		}
		$_POST['adtime']=time();
		if (!empty($_POST['status'])){
			$_POST['status'] = pylode(",",$_POST['status']);
		}else{
			$_POST['status'] = "";
		}
        $data=array(
    		'username'=>$_POST['username'],
    		'mobile'=>$_POST['mobile'],
    		'qq'=>$_POST['qq'],
    		'adtime'=>$_POST['adtime'],
    		'status'=>$_POST['status'],
    		'weixin'=>$_POST['weixin'],
    		'logo'=>$pic
    		);
		if($_POST['username']==''){
			$this->ACT_layer_msg("用户姓名不能为空！",8);
		}elseif($_POST['mobile']==''){	
			$this->ACT_layer_msg("手机号码不能为空!",8);
		}elseif($_POST['qq']==''){
			$this->ACT_layer_msg("QQ不能为空!",8);
		}elseif($_POST['weixin']==''){
			$this->ACT_layer_msg("微信号不能为空!",8);
		};
		if (!$_POST['id']){
		    $nid=$this->obj->insert_into('company_consultant',$data);
		}else{
		    $nid=$this->obj->update_once("company_consultant",$data,array('id'=>$_POST['id']));
		}
		$nid?$this->ACT_layer_msg("保存成功！",9,"index.php?m=admin_company_consultant"):$this->ACT_layer_msg("保存失败！",8,$_SERVER['HTTP_REFERER']);
	}

	function show_action(){
		if($_GET['id']){
			$show=$this->obj->DB_select_once("company_consultant","id='".$_GET['id']."'");
			if ($show){
				$status=@explode(',', $show['status']);
				$this->yunset("status",$status);
			}
			$this->yunset("show",$show);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
		}
		$this->yuntpl(array('admin/admin_company_consultant_show'));
	}

	function comlist_action(){
		$this->set_search();
		$info=$this->obj->DB_select_once("company_consultant","id='".$_GET['conid']."'");
		$this->yunset("info",$info);
		$where="conid='".$_GET['conid']."'";
		$urlarr['c']="comlist";
		$urlarr['conid']=$_GET['conid'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$M=$this->MODEL();
		$rows=$M->get_page("company",$where,$pageurl,$this->config['sy_listnum']);
		
		if(!empty($rows['rows'])){
			$com = $this->obj->DB_select_all("member","usertype=2","`uid`,`username`");
			if(!empty($com)){
				foreach($rows['rows'] as $key=>$value){
					foreach($com as $k=>$v){
						if($v['uid']==$value['uid']){
							$rows['rows'][$key]['username'] = $v['username'];
						}
					}
				}
			}
		}
        $this->yunset($rows);
        $this->yuntpl(array('admin/admin_consultant_comlist'));
	}
    function delcom_action(){
		$this->check_token();
		if($_GET['del']||$_GET['uid']){
			if(is_array($_GET['del'])){
				$layer_type=1;
				$del=@implode(',',$_GET['del']);
			}else{
				$layer_type=0;
				$del=$_GET['uid'];
			}
			$this->obj->DB_update_all("company","`conid`=''","`uid` in (".$del.")");
			$this->layer_msg("(ID:".$del.")取消成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg("请选择您要取消的信息！",8,1);
		}
	}

}
?>