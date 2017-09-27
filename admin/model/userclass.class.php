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
class userclass_controller extends common{

	function index_action(){
		$position=$this->obj->DB_select_all("userclass","`keyid`='0'");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_userclass'));
	}

	function save_action(){
	    $_POST=$this->post_trim($_POST);
	    $position=explode('-',$_POST['name']);
		foreach ($position as $val){
			if($val){
				$name[]=iconv('utf-8','gbk',$val);
			}
		}
		if($_POST['nid']){
			$where=" and `keyid`='".$_POST['nid']."'";
		}
		$userclass=$this->obj->DB_select_all("userclass","`name` in ('".implode("','", $name)."')".$where);		
		if(empty($userclass)){
		    $variable=explode('-',$_POST['str']);
		    if($_POST['ctype']=='1'){
		        foreach ($name as $key=>$val){
		            foreach ($variable as $k=>$v){
		                if($k==$key){
		                    $value="`name`='".$val."',`variable`='".trim($v)."'";
		                    $add=$this->obj->DB_insert_once("userclass",$value);
		                }
		            }
		        }
		    }else{
		        foreach ($name as $key=>$val){
		            $value="`name`='".$val."',`keyid`='".intval($_POST['nid'])."'";
		            $add=$this->obj->DB_insert_once("userclass",$value);
		        }
		    }
		    $this->cache_action();
		    $add?$msg=2:$msg=3;
		    $this->admin_log("个人会员分类(ID:".$add.")添加成功");
		}else{
			$msg=1;
		}
		echo $msg;die;
	}

	function up_action(){

		if($_GET['id']){
			$id=$_GET['id'];
			$class1=$this->obj->DB_select_once("userclass","`id`='".$_GET['id']."'");
			$class2=$this->obj->DB_select_all("userclass","`keyid`='".$_GET['id']."' order by `sort` asc");
			$this->yunset("id",$id);
			$this->yunset("class1",$class1);
			$this->yunset("class2",$class2);
		}
		$position=$this->obj->DB_select_all("userclass","`keyid`='0'");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_userclass'));
	}

	function upp_action(){
		if($_POST['update']){
			if(!empty($_POST['position'])){
				if(preg_match("/[^\d-., ]/",$_POST['sort'])){
					$this->ACT_layer_msg("请正确填写，排序是数字！",8,$_SERVER['HTTP_REFERER']);
				}else{
					$value="`name`='".iconv('utf-8','gbk',trim($_POST['position']))."'";
					if($_POST['sort']){
						$value.=",`sort`='".$_POST['sort']."'";
					}
					$where="`id`='".$_POST['id']."'";
					$up=$this->obj->DB_update_all("userclass",$value,$where);
					$this->cache_action();
					$up?$this->ACT_layer_msg("个人会员分类(ID:".$_POST['id'].")更新成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("更新失败，请销后再试！",8,$_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->ACT_layer_msg("请正确填写你要更新的分类！",8,$_SERVER['HTTP_REFERER']);
			}
		}
	}

	function del_action(){
		if($_GET['delid']){
			$this->check_token();
			$id=$this->obj->DB_delete_all("userclass","`id`='".$_GET['delid']."' or `keyid`='".$_GET['delid']."'","");
			$this->cache_action();
		    isset($id)?$this->layer_msg('个人会员分类删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['del']){
			$del=@implode(",",$_POST['del']);
			$id=$this->obj->DB_delete_all("userclass","`id` in (".$del.") or `keyid` in (".$del.")","");
			$this->cache_action();
			isset($id)?$this->layer_msg('个人会员分类删除成功！',9,1,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function cache_action(){
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache("../data/plus/",$this->obj);
		$makecache=$cacheclass->user_cache("user.cache.php");
	}
	function ajax_action(){
		if($_POST['sort']){
			$this->obj->DB_update_all("userclass","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->admin_log("个人会员分类(ID:".$_POST['id'].")排序修改成功");
		}
		if($_POST['name']){
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("userclass","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->admin_log("个人会员分类(ID:".$_POST['id'].")名称修改成功");
		}
		$this->cache_action();echo '1';die;
	}
}
?>