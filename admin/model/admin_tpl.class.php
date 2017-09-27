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
class admin_tpl_controller extends common{
	function public_action(){
		include_once("model/model/style_class.php");
	}
	function index_action(){
		$this->public_action();
		$style = new style($this->obj);
		$list = $style->model_list_action();
		$this->yunset("sy_style",$this->config['style']);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_style_list'));
	}
	function stylemodify_action(){
		extract($_GET);
		$this->public_action();
		$style = new style($this->obj);
		$style_info = $style->model_modify_action($dir);
		$this->yunset("style_info",$style_info);
		$this->yuntpl(array('admin/admin_style_modfy'));
	}
	function stylesave_action(){
		$this->public_action();
		$style = new style($this->obj);
	
		$style_info = $style->model_save_action($_POST);
		$this->ACT_layer_msg("信息修改成功！",9,"index.php?m=admin_tpl",2,1);
	}
	function check_style_action(){
		extract($_GET);
		if($dir!=""){
			$style = $this->obj->DB_select_all("admin_config","`name`='style'");
			if(is_array($style)){
				$this->obj->DB_update_all("admin_config","`config`='$dir'","`name`='style'");
			}else{
				$this->obj->DB_insert_once("admin_config","`config`='$dir',`name`='style'");
			}
			$this->web_config();
			$this->layer_msg('模板风格更换成功！',9);
		}else{
			$this->layer_msg('该目录无效！',8);
		}
	}
	function comtpl_action(){
		$list=$this->obj->DB_select_all("company_tpl","1 order by id desc");
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_comtpl'));
	}
	function comtpladd_action(){
		if($_GET['id']){
			$list=$this->obj->DB_select_once("company_tpl","id='".$_GET['id']."'");
			$this->yunset("row",$list);
		}
		$this->yuntpl(array('admin/admin_comtpl_add'));
	}
	function comptplsave_action(){
		$this->com_sava_action($_POST['url']);
		unset($_POST['msgconfig']);
		if($_POST['id']){
			if(is_uploaded_file($_FILES['pic']['tmp_name'])) {
				$upload=$this->upload_pic("../data/upload/company/");
				$pictures=$upload->picture($_FILES['pic']);
				$s_thumb=$upload->makeThumb($pictures,120,120,'_S_');
				$_POST['pic']=str_replace("../data/upload/company","data/upload/company",$s_thumb);
				unlink_pic($pictures);
			}
			$id=$this->obj->update_once("company_tpl",$_POST,array("id"=>$_POST['id']));
			$msg="企业模板(ID:".$_POST['id'].")更新";
		}else{
			$_POST['pic']="";
			if(!is_uploaded_file($_FILES['pic']['tmp_name'])) {
				$this->ACT_layer_msg("请上传缩略图！",8,"index.php?m=admin_tpl&c=comtpladd");
			}else{
				$upload=$this->upload_pic("../data/upload/company/");
				$pictures=$upload->picture($_FILES['pic']);
				$s_thumb=$upload->makeThumb($pictures,120,120,'_S_');
				$_POST['pic']=str_replace("../data/upload/company","data/upload/company",$s_thumb);
				unlink_pic($pictures);
			}
			$id=$this->obj->insert_into("company_tpl",$_POST);
			$msg="企业模板(ID:".$id.")添加";
		}
		$id?$this->ACT_layer_msg($msg."成功！",9,"index.php?m=admin_tpl&c=comtpl",2,1):$this->ACT_layer_msg($msg."失败！",8,"index.php?m=admin_tpl&c=comtpl");
	}
	function com_sava_action($url){
		if(!ctype_alnum($url)){
			$this->ACT_layer_msg("目录名称只能是字母或数字！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
		if(!is_dir("../app/template/company/".$url)){
			mkdir("../app/template/company/".$url,0777,true);
		}
	}
	function comtpldel_action(){
		$this->check_token();
		$del=$_GET['id'];
		if(!$del){$this->layer_msg('请先选择！',8,0,$_SERVER['HTTP_REFERER']);}
		$this->obj->DB_delete_all("company_tpl","`id`='$del'");
		$this->layer_msg("企业模板(ID".$del.")删除成功！",9,0,$_SERVER['HTTP_REFERER']);
	}
	function resumetpl_action(){
		$list=$this->obj->DB_select_all("resumetpl","1 order by id desc");
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_resumetpl'));
	}
	function resumetpladd_action(){
		if($_GET['id']){
			$list=$this->obj->DB_select_once("resumetpl","id='".$_GET['id']."'");
			$this->yunset("row",$list);
		}
		$this->yuntpl(array('admin/admin_resumetpl_add'));
	}
	function resumetplsave_action(){
		$this->resumetpl_sava_action($_POST['url']);
		unset($_POST['msgconfig']);
		if($_POST['id']){
			if(is_uploaded_file($_FILES['pic']['tmp_name'])) {
				$upload=$this->upload_pic("../data/upload/resume/");
				$pictures=$upload->picture($_FILES['pic']);
				$_POST['pic']=str_replace("../data/upload/resume","data/upload/resume",$pictures);
			}
			$id=$this->obj->update_once("resumetpl",$_POST,array("id"=>$_POST['id']));
			$msg="模板(ID:".$_POST['id'].")更新";
		}else{
			$_POST['pic']="";
			if(!is_uploaded_file($_FILES['pic']['tmp_name'])) {
				$this->ACT_layer_msg("请上传缩略图！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$upload=$this->upload_pic("../data/upload/resume/");
				$pictures=$upload->picture($_FILES['pic']);
				$s_thumb=$upload->makeThumb($pictures,300,120,'_S_');
				$_POST['pic']=str_replace("../data/upload/resume","data/upload/resume",$s_thumb);
				unlink_pic($pictures);
			}
			$id=$this->obj->insert_into("resumetpl",$_POST);
			$msg="模板(ID:".$id.")添加";
		}
		$id?$this->ACT_layer_msg($msg."成功！",9,"index.php?m=admin_tpl&c=resumetpl",2,1):$this->ACT_layer_msg($msg."失败！",8,"index.php?m=admin_tpl&c=resumetpl");
	}
	function resumetpl_sava_action($url){
		if(!ctype_alnum($url)){
			$this->ACT_layer_msg("目录名称只能是字母或数字！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
		if(!is_dir("../app/template/resume/".$url)){
			mkdir("../app/template/resume/".$url,0777,true);
		}
	}
	function resumetpldel_action(){
		$this->check_token();
		$del=$_GET['id'];
		if(!$del){$this->layer_msg('请先选择！',8,0,$_SERVER['HTTP_REFERER']);}
		$this->obj->DB_delete_all("resumetpl","`id`='$del'");
		$this->layer_msg("模板(ID".$del.")删除成功！",9,0,$_SERVER['HTTP_REFERER']);
	}
	function templatepublic_action(){
		include_once("model/model/tmp_class.php");	
	}
	function template_action(){
		$publicdir = "../app/template/";	
		if($_GET['dir']){
			$dir = str_replace('.',"",$_GET['dir']);
		}
		if(!$dir){
			$hostdir = '';
		}else{
			$hostdir = $dir.'/';
			$row=explode('/',$hostdir);
			if(count($row)>2){
				$str_dir = array_slice($row,-2,1);
				$retrundir=str_replace("/".$str_dir[0]."/","",$hostdir);
			}else{
				$retrundir=str_replace($row[0]."/","",$hostdir);
			}	
			$floder[] = array('name'=>"返回上一级",'url'=>$retrundir);
		}	
		$filesnames = @scandir($publicdir.$hostdir);	
		if(is_array($filesnames)){
			foreach($filesnames as $key=>$value){
				if($value!='.' && $value!='..' ){
					if(is_dir($publicdir.$hostdir.$value)){
						$floder[] = array('name'=>$value,'url'=>$hostdir.$value);
					}elseif(is_file($publicdir.$hostdir.$value)){
						$typearr = explode('.',$hostdir.$value);
						if(in_array(end($typearr),array('txt','htm','html','xml','js','css'))){	
							$file[] = array('name'=>$value,'url'=>$hostdir.$value,'size'=>round((filesize($publicdir.$hostdir.$value)/1024),2)."KB",'time'=>date("Y-m-d H:i:s",filemtime($publicdir.$hostdir.$value)));
						}
					}
				}
			}
		}
		$this->yunset("floder",$floder);
		$this->yunset("file",$file);
		$this->yuntpl(array('admin/admin_template'));
	}
	function modify_action(){
		if($this->config['sy_istemplate']!='1'){
			$this->ACT_msg($_SERVER['HTTP_REFERER'],"该功能已关闭！");
		}
		$hostdir = "../app/template/";
		$_GET['path'] = str_replace(array('./','../'),'',$_GET['path']);
		if(count(@explode('.',$_GET['path']))>2){
			$this->ACT_msg($_SERVER['HTTP_REFERER'],"非法的文件名！");
		}
		if(file_exists($hostdir.$_GET['path']) && $_GET['name']){	
			$path = $hostdir.$_GET['path'];
			$typearr = explode('.', $path);
			if(!in_array(end($typearr),array('txt','htm','html','xml','js','css'))){
				$this->ACT_msg($_SERVER['HTTP_REFERER'],"非法的文件名！");
			}
			$tp_info['name'] = $_GET['name'];
			$tp_info['path'] = $_GET['path'];
				
			$fp=@fopen($path,"r");
			$tp_info['content'] =@fread($fp,filesize($path));
			$tp_info['content'] = str_replace(array('<textarea>','</textarea>'),array('&lt;textarea&gt;','&lt;/textarea&gt;'),$tp_info['content']);
			fclose($fp);
			$this->yunset("safekey",$safekey);
				
			$tp_info['safekey'] = md5(md5($this->config['sy_safekey']).'admin_template');
			$this->yunset("tp_info",$tp_info);
			$this->yuntpl(array('admin/admin_template_modify'));
		}else{
			$this->ACT_msg($_SERVER['HTTP_REFERER'],"文件不存在！");
		}
	}
	function savetpl_action(){
		$hostdir = "../app/template/";
		$_GET['path'] = str_replace(array('./','../'),'',$_POST['tp_path']);
		if(count(@explode('.',$_POST['tp_path']))>2){
			$this->ACT_msg($_SERVER['HTTP_REFERER'],"非法的文件名！");
		}	
		if(file_exists($hostdir.$_POST['tp_path']) && $_POST['code'] && md5(md5($this->config['sy_safekey']).'admin_template') == $_POST['safekey']){
			$path = $hostdir.$_POST['tp_path'];
			$typearr = explode('.',$path);
			if(!in_array(end($typearr),array('txt','htm','html','xml','js','css'))){
				$this->ACT_layer_msg($_SERVER['HTTP_REFERER'],"非法的文件名！");
			}	
			$fp=@fopen($path,"w");
			fwrite($fp,stripslashes($_POST['code']));
			fclose($fp);
			$this->ACT_layer_msg("模板(".$_POST['tp_path'].")更新成功！",9,$_SERVER['HTTP_REFERER'],2,1);	
		}else{	
			$this->ACT_layer_msg("模板不能为空！",8,$_SERVER['HTTP_REFERER']);
		}
	}
			
}