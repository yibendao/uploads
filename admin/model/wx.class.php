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
class wx_controller extends common
{  

	function set_search(){

		$type=array('1'=>'关注微信','2'=>'绑定微信账户','3'=>'创建首份简历','4'=>'企业完善资料');
		$usertype=array('1'=>'个人','2'=>'企业');
		$status=array('2'=>'发放失败','1'=>'发放成功');
		$time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$this->yunset("type",$type);
		$this->yunset("usertype",$usertype);
		$this->yunset("status",$status);
		$this->yunset("time",$time);

		$search_list[]=array("param"=>"usertype","name"=>'用户类型',"value"=>$usertype);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){

		$this->yuntpl(array('admin/admin_wx'));
	}

	function save_action(){
 		if($_POST["msgconfig"]){
			unset($_POST["msgconfig"]);
			unset($_POST["pytoken"]);
			
			if (is_uploaded_file($_FILES['sy_wx_logo']['tmp_name'])) {
				
				$upload=$this->upload_pic("../data/logo/");
				$pictures=$upload->picture($_FILES['sy_wx_logo']);
				$pic = str_replace("../data/logo","data/logo",$pictures);

				$logo = $this->obj->DB_select_once("admin_config","`name`='sy_wx_logo'");
				if(is_array($logo)){
					unlink_pic("../".$logo['config']);
				}
				$_POST['sy_wx_logo'] = $pic;
			}
			if (is_uploaded_file($_FILES['sy_wx_qcode']['tmp_name'])) {
				
				$upload=$this->upload_pic("../data/logo/");
				$pictures=$upload->picture($_FILES['sy_wx_qcode']);
				$pic = str_replace("../data/logo","data/logo",$pictures);

				$logo = $this->obj->DB_select_once("admin_config","`name`='sy_wx_qcode'");
				if(is_array($logo)){
					unlink_pic("../".$logo['config']);
				}
				$_POST['sy_wx_qcode'] = $pic;
			}
			if (is_uploaded_file($_FILES['sy_wx_sharelogo']['tmp_name'])) {
				
				$upload=$this->upload_pic("../data/logo/");
				$pictures=$upload->picture($_FILES['sy_wx_sharelogo']);
				$pic = str_replace("../data/logo","data/logo",$pictures);

				$logo = $this->obj->DB_select_once("admin_config","`name`='sy_wx_sharelogo'");
				if(is_array($logo)){
					unlink_pic("../".$logo['config']);
				}
				$_POST['sy_wx_sharelogo'] = $pic;
			}


			foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
				$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".$v."'");
			   }else{
				$this->obj->DB_update_all("admin_config","`config`='".$v."'","`name`='$key'");
			   }
		 	}
			$this->web_config();
			$this->ACT_layer_msg("微信配置更新成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
	}
	
	function binduser_action(){

 		$where = "(`wxid`!='' &&  `wxid` is not null)";
		if(trim($_GET['keyword'])){
			$where.=" and `username` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']=$_GET['keyword'];
		}
		$order = " ORDER BY `wxbindtime` DESC";
		$urlarr['c']=$_GET['c'];  
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$userList=$this->get_page("member",$where.$order,$pageurl,$this->config['sy_listnum'],"`uid`,`username`,`wxid`,`wxbindtime`");

		$this->yunset("userList",$userList);
		$this->yuntpl(array('admin/admin_wxbind'));
	}

	function keyword_action(){

 		$where = "`type`='8'";
		if(trim($_GET['keyword'])){
			$where.=" and `key_name` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']=trim($_GET['keyword']);
		}
		$order = " ORDER BY `num` DESC";
		$urlarr['c']=$_GET['c'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$keyList=$this->get_page("hot_key",$where.$order,$pageurl,$this->config['sy_listnum']);

		$this->yunset("keyList",$keyList);
		$this->yuntpl(array('admin/admin_wxkey'));
	}

	function wxnav_action()
	{
  		$list = $this->obj->DB_select_all("wxnav","1 ORDER BY `sort` ASC");
		if(is_array($list)){
			foreach($list as $value){
				if($value['keyid']=='0' || $value['keyid']==''){
					$navlist[$value['id']] = $value;
				}
			}
			foreach($list as $val){
				foreach($navlist as $key=>$v){
					if($v['id']==$val['keyid']){
						$navlist[$key]['list'][] = $val;
					}
				}
			}
		}
		$this->yunset('navlist',$navlist);
		$this->yuntpl(array('admin/admin_wxnav'));
	}

	function wxlog_action()
	{
		$this->set_search();
 		$where = '1';
		if(trim($_GET['keyword'])){
			if($_GET['wtype']=='1'){
				$where.= "  AND `re_nick` like '%".trim($_GET['keyword'])."%' ";
            }elseif($_GET['wtype']=='2'){
				$mwhere.=" and `username` like '%".trim($_GET['keyword'])."%'";
            }
			$where.=" and (`username` like '%".trim($_GET['keyword'])."%' OR  `re_nick` like '%".trim($_GET['keyword'])."%')";
			$urlarr['keyword']=trim($_GET['keyword']);
		}

		if($_GET['status']){
			if($_GET['status']=='2'){
				$status = 0;
			}else{
				$status = $_GET['status'];
			}
			$where.=" and `status`='".$status."'";
			$urlarr['status']=trim($_GET['status']);
		}	
		if($_GET['usertype']){
			$where.=" and `usertype`='".$_GET['usertype']."'";
			$urlarr['usertype']=trim($_GET['usertype']);
		}	
		if($_GET['type']){
			$where.=" and `type`='".$_GET['type']."'";
			$urlarr['type']=trim($_GET['type']);
		}	
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where .=" and `time`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `time`>'".strtotime('-'.intval($_GET['time']).' day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}	
		$urlarr['c']="wxlog";
		$urlarr['page']="{{page}}";
		$order = " ORDER BY `time` DESC";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$logList=$this->get_page("wxredpack",$where.$order,$pageurl,$this->config['sy_listnum']);
		$this->yunset("logList",$logList);
		$this->yuntpl(array('admin/admin_wxlog'));
	}
	
	public function edit_action()
	{
		if($_POST['name'] && $_POST['keyid']!=='')
		{
			$_POST['name'] = iconv('utf-8','gbk',$_POST['name']);
			$_POST['key'] = iconv('utf-8','gbk',$_POST['key']);
			$where = "`name`='".$_POST['name']."'";
			if($_POST['keyid']>0)
			{
				if(!$_POST['key'] && $_POST['type']!='view')
				{
					echo 1;
					exit();
				}elseif($_POST['key']!=""){

					$where = "(`name`='".$_POST['name']."' AND  `keyid`='".$_POST['keyid']."')";
				}
			}
			
			if($_POST['navid']>0)
			{
				$where .= " AND  `id`<>'".$_POST['navid']."'";
			}
			
 			$nav = $this->obj->DB_select_num("wxnav",$where);
			if($nav>0)
			{
				echo 2;
				exit();
			}
			if($_POST['keyid']=='0')
			{
				$_POST['type']= 'click';
				unset($_POST['url']);unset($_POST['key']);
			}
			unset($_POST['pytoken']);
			if($_POST['navid']>0)
			{
				$navid = $_POST['navid'];
				unset($_POST['navid']);

				$this->obj->update_once("wxnav",$_POST,array('id'=>$navid));
				$this->admin_log("微信菜单(ID:".$navid.")修改成功");
			}else{
				$navid=$this->obj->insert_into("wxnav",$_POST);
				$this->admin_log("微信菜单(ID:".$navid.")添加成功");
			}

			echo 3;
			exit();
		}else{
			echo 1;
			exit();
		}

	}
 	public function creat_action()
	{
 		$list = $this->obj->DB_select_all("wxnav","1 ORDER BY `keyid` ASC,`sort` ASC");

		if(is_array($list))
		{
			foreach($list as $value){
				if($value['keyid']=='0'){
					$navlist[$value['id']] = $value;
				}
			}
			foreach($list as $val){
				foreach($navlist as $key=>$v){
					if($v['id']==$val['keyid']){
						$navlist[$key]['list'][] = $val;
					}
				}
			} 
			$CreatNav = '{"button":[';
			$i=0;
			foreach($navlist as $key=>$value)
			{
				if($i<1)
				{
					$CreatNav.='{"name":"'.iconv('gbk','utf-8',trim($value['name'])).'","sub_button":[';
				}else{
					$CreatNav.=',{"name":"'.iconv('gbk','utf-8',trim($value['name'])).'","sub_button":[';
				}
				$i++;
				$NavInfo = array();

				if(is_array($value['list']) && !empty($value['list'])){

					foreach($value['list'] as $k=>$v)
					{
						if($k>0)
						{
							$CreatNav.=',';
						}
						if($v['type']=='click')
						{
							$CreatNav.='{"type":"click","name":"'.iconv('gbk','utf-8',trim($v['name'])).'","key":"'.iconv('gbk','utf-8',$v['key']).'"}';

						}elseif($v['type']=='view'){

							$CreatNav.='{"type":"view","name":"'.iconv('gbk','utf-8',trim($v['name'])).'","url":"'.trim($v['url']).'"}';
						}
					}
				}
				$CreatNav.=']}';
			}
			$CreatNav.=']}';
 			$Token = getToken($this->config);

 			$DelUrl = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$Token;
			CurlPost($DelUrl);
			
			$Url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$Token;
			$result = CurlPost($Url,$CreatNav);
			$Info = json_decode($result);
			
			if($Info->errcode=='0' || $Info->errmsg=='ok'){
 				echo 1;die;
			}else{
 				echo 2;die;
			}
		}
	}
 	function delnav_action(){
		if($_POST['del']){
			$this->obj->DB_delete_all("wxnav","`id` in(".@implode(',',$_POST['del']).")",'');
			$this->obj->DB_delete_all("wxnav","`keyid` in(".@implode(',',$_POST['del']).")",'');
			$this->layer_msg('微信菜单(ID:'.@implode(',',$_POST['del']).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
		}
		if((int)$_GET['delid']){
			$this->check_token();
			$id=$this->obj->DB_delete_all("wxnav","`id`in(".$_GET['delid'].")","");
			$this->obj->DB_delete_all("wxnav","`keyid` in(".$_GET['delid'].")","");
			$id?$this->layer_msg('微信菜单(ID:'.$_GET['delid'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
 	function deluser_action(){
		if($_GET['del']){
			$this->check_token();
			$this->obj->DB_update_all("member","`wxid`=''","`uid` in(".@implode(',',$_GET['del']).")");
			$this->layer_msg('微信用户(ID:'.@implode(',',$_GET['del']).')取消绑定成功！',9,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function ajax_action()
	{
		if($_POST['sort'])
		{
			$this->obj->DB_update_all("wxnav","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->admin_log("微信菜单(ID:".$_POST['id'].")排序修改成功");
		}
		if($_POST['name'])
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("wxnav","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->admin_log("微信菜单(ID:".$_POST['id'].")名称修改成功");
		}
		echo '1';die;
	}

	function array_iconv($in_charset,$out_charset,$arr){
        return eval('return '.iconv($in_charset,$out_charset,var_export($arr,true).';'));
	}	
	
	function zdkeyword_action()
	{		
	    $where ="1";
		if(trim($_GET['keyword'])){
			$where.=" and `keyword` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']=trim($_GET['keyword']);
		}
		$order = " ORDER BY `time` DESC";
		$urlarr['c']=$_GET['c'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$keyList=$this->get_page("wxzdkeyword",$where.$order,$pageurl,$this->config['sy_listnum']);
		$this->yunset("keyList",$keyList);		
		$this->yuntpl(array('admin/admin_zdkeyword'));
	}
	
	
	function zdaddkeyword_action()
	{	
	    $id=(int)$_GET['id'];
		$row=$this->obj->DB_select_once('wxzdkeyword',"`id`='".$id."'");
	    $this->yunset("row",$row);
		if($_POST["submit"]){          
			if(trim($_POST['title'])==''){
				$this->ACT_layer_msg("规则名称不能为空！",8);
			}	
			if(trim($_POST['keyword'])==''){
				$this->ACT_layer_msg("关键字不能为空！",8);
			}	
			if(trim($_POST['content'])==''){
				$this->ACT_layer_msg("回复内容不能为空！",8);
			}	  		  
			$this->obj->DB_insert_once("wxzdkeyword","`title`='".$_POST['title']."',`keyword`='".$_POST['keyword']."',`content`='".$_POST['content']."',`time`='".time()."'");
			$this->ACT_layer_msg("添加成功！",9,"index.php?m=wx&c=zdkeyword",2,1);
		}
		if($_POST["update"]){       
			$this->obj->DB_update_all('wxzdkeyword',"`title`='".$_POST['title']."',`keyword`='".$_POST['keyword']."',`content`='".$_POST['content']."',`time`='".time()."'","`id`='".$_POST['id']."'");	
	        $this->ACT_layer_msg("修改成功！",9,"index.php?m=wx&c=zdkeyword",2,1);		
		}
		$this->yuntpl(array('admin/admin_zdaddkeyword'));
	}
		
	function delkeyword_action(){
		extract($_GET);
		extract($_POST);
		if(is_array($del)){
			$delid=@implode(',',$del);
			$layer_type=1;
		}else{
			$this->check_token();
			$delid=$id;
			$layer_type=0;
		}
		if(!$delid){
			$this->layer_msg('请选择要删除的内容！',8);
		}
		$del=$this->obj->DB_delete_all("wxzdkeyword","`id` in (".$delid.")"," ");		
		$del?$this->layer_msg('(ID:'.$delid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
}

?>