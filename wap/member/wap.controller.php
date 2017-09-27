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
class wap_controller extends common{ 
	function __construct($tpl,$db,$def="",$model="index",$m="") {
		$this->common($tpl,$db,$def,$model,$m);
		if($this->usertype=='1' && $this->config['user_resume_status']=='1' && $_GET['c']!='addresume' && $_GET['c']!='kresume'){
			$myresumenum=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
			if($myresumenum<1){
				header("location:"."index.php?c=addresume");

			}
		}
	}
	function waplayer_msg($msg,$url='1',$tm=2){
		$msg = preg_replace('/\([^\)]+?\)/x',"",str_replace(array("（","）"),array("(",")"),$msg));
		$layer_msg['msg']=$this->yun_iconv("gbk","utf-8",$msg); 
		$layer_msg['url']=$url;
		$layer_msg['tm']=$tm;
		$msg = json_encode($layer_msg);
		echo $msg;die;
	}
	
	function yun_iconv($in_charset,$out_charset,$str){
	    if(function_exists('mb_convert_encoding')){
	        return mb_convert_encoding($str,$out_charset,$in_charset);
	    }else if(function_exists('mb_convert_encoding')){
	        return iconv($in_charset,$out_charset,$str);
	    }else{
	        return $str;
	    }
	}
	function member_log($content,$opera='',$type=''){
		if($this->uid){
			$value="`uid`='".(int)$this->uid."',";
			$value.="`usertype`='".(int)$this->usertype."',";
			$value.="`content`='".$content."',";
			$value.="`opera`='".$opera."',";
			$value.="`type`='".$type."',";
			$value.="`ip`='".fun_ip_get()."',";
			$value.="`ctime`='".time()."'";
			$this->obj->DB_insert_once("member_log",$value);
		}
	}
	function resume($table,$where){
		include(LIB_PATH."page.class.php");
		$limit=10;
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$page_url = "index.php?c=".$_GET['c']."&page={{page}}";
		$count = $this->obj->DB_select_alls($table,"resume_expect",$where." ORDER BY a.id DESC");
 		$num = count($count);
 		$pages=ceil($num/$limit);
		if($pages>1){
			$page = new page($page,$limit,$num,$page_url);
			$pagenav=$page->numPage();
			$this->yunset("pagenav",$pagenav);	
		}
 		
		
		$list = $this->obj->DB_select_alls($table,"resume_expect",$where."  ORDER BY a.id DESC LIMIT $ststrsql,$limit","a.*,a.id as did,b.*");
		include PLUS_PATH."/user.cache.php";
		include PLUS_PATH."/job.cache.php";
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		if(is_array($list)){
			$uid=array();
			foreach($list as $val){
				if(in_array($val['uid'],$uid)==false){
					$uid[]=$val['uid'];
				}
			}
			$resume=$this->obj->DB_select_all("resume","`uid` in(".pylode(',',$uid).")","`uid`,`name`");
			foreach($list as $k=>$v){
				foreach($resume as $value){
					if($value['uid']==$v['uid']){
						$list[$k]['name']=$value['name'];
					}
				}
				$list[$k]['sex']=$arr_data['sex'][$v['sex']];
				$list[$k]['exp']=$userclass_name[$v['exp']];
				$list[$k]['edu']=$userclass_name[$v['edu']];
				if($v['job_classid']!=""){
					$job=@explode(",",$v['job_classid']);
					$joblist=array();
					foreach($job as $val){
						$joblist[]=$job_name[$val];
					}
					$list[$k]['joblist']=@implode(",",$joblist);
				}
			}
		}
		$this->yunset("list",$list);
	}
}
?>