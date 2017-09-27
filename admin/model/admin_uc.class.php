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
//模板操作类
class admin_uc_controller extends common
{
	function index_action()
	{
		$this->yunset("sy_weburl",$this->config['sy_weburl']);
		$path = APP_PATH."data/api/uc/config.inc.php";
		require_once $path;
		$this->yunset("ucinfo",$ucinfo);
		$this->yuntpl(array('admin/admin_uc'));
	}
	function save_action(){
		$config = "<?php \r\n";
		if($_POST){
			$parr="";
			$sy_uc_type=$_POST['sy_uc_type'];
			unset($_POST['submit']);
			unset($_POST['sy_uc_type']);
			$_POST['UC_CONNECT']="mysql";
			$_POST['UC_DBCONNECT']="0";
			$_POST['UC_DBCHARSET']=$_POST['UC_CHARSET'];
			$_POST['UC_IP']="";
			$_POST['UC_DBTABLEPRE']="`".$_POST['UC_DBNAME']."`.".$_POST['UC_DBTABLEPRE_NEW'];
			
			foreach($_POST as $key=>$value)
			{
				$config.="define(\"".$key."\",\"".$value."\"); \r\n";
				$parr .= "\"".$key."\"=>\"".$value."\",";
			}
			$parr = rtrim($parr,",");
			$config.="\$ucinfo=array(".$parr."); \r\n";
		}
		$path = APP_PATH."data/api/uc/config.inc.php";
		$fp = @fopen($path,"w");
		fwrite($fp,$config);
		fclose($fp);
		
		$uc_type = $this->obj->DB_select_once("admin_config","`name`='sy_uc_type'");
		if(is_array($uc_type)){
			$this->obj->DB_update_all("admin_config","`config`='".$sy_uc_type."'","`name`='sy_uc_type'");
		}else{
			$this->obj->DB_insert_once("admin_config","`name`='sy_uc_type',`config`='".$sy_uc_type."'");
		}
		 $this->web_config();		
		$this->ACT_layer_msg("保存成功！",9,"index.php?m=admin_uc",2,1); 
	}
	function pw_action(){
		$this->yunset("sy_weburl",$this->config['sy_weburl']);
		$path = APP_PATH."data/api/pw_api/pw_config.php";
		require_once $path;
		$this->yunset("ucinfo",$ucinfo);
		$this->yuntpl(array('admin/admin_pw'));
	}
	function pwsave_action() { 
		$config = "<?php \r\n";
		if($_POST){
			$parr="";
			$sy_pw_type=$_POST['sy_pw_type'];
			unset($_POST['submit']);
			unset($_POST['sy_pw_type']);
			$_POST['UC_DBCONNECT']="0";
			$_POST['UC_IP']="";
			$_POST['UC_DBCHARSET']=$_POST['UC_CHARSET'];
			foreach($_POST as $key=>$value){
				$config.="define(\"".$key."\",\"".$value."\"); \r\n";
				$parr .= "\"".$key."\"=>\"".$value."\",";
			}
			$parr = rtrim($parr,",");
			$config.="\$ucinfo=array(".$parr."); \r\n";
		}
		$path = APP_PATH."data/api/pw_api/pw_config.php";
		$fp = @fopen($path,"w");
		fwrite($fp,$config);
		fclose($fp);
		$uc_type = $this->obj->DB_select_once("admin_config","`name`='sy_pw_type'");
		if(is_array($uc_type)){
			$this->obj->DB_update_all("admin_config","`config`='".$sy_pw_type."'","`name`='sy_pw_type'");
		}else{
			$this->obj->DB_insert_once("admin_config","`name`='sy_pw_type',`config`='".$sy_pw_type."'");
		}
		$this->obj->DB_update_all("admin_config","`config`=''","`name`='sy_uc_type'");
		$this->web_config();
		if($sy_pw_type=='pw_center'){
			$user_arr = $this->obj->DB_select_all("member"," 1",'`uid`,`username`,`password`,`salt`');

			require_once APP_PATH.'/api/pw_api/pw_client/class_db.php';

			$db_uc = new UcDB;

			include(APP_PATH."data/api/pw_api/pw_config.php");
			$db_uc->connect(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBCONNECT, UC_DBCHARSET);
			$pw_query=$db_uc->query("SELECT `uid`,`username`,`password` FROM ".UC_DBTABLEPRE."members");
			
			while($pw_rs = $db_uc->fetch_array($pw_query)){
				if(is_array($user_arr)){
					foreach($user_arr as $key=>$value){
						if($value['username']==$pw_rs['username']&&$value['pw_repeat']!="1"){
							if($value['pwuid']<1){
								if($value['password']==md5($pw_rs['password'].$value['salt'])){
									$this->obj->DB_update_all("member","`pwuid`='".$pw_rs['uid']."'","`uid`='".$value['uid']."'");
								}else{
									$this->obj->DB_update_all("member","`pw_repeat`='1'","`uid`='".$value['uid']."'");
								}
							}
						}
					}
				}
			} 
		}
		
		$this->ACT_layer_msg("保存成功！",9,"index.php?m=admin_uc&c=pw");
	}
}
?>