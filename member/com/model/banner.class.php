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
class banner_controller extends company{
	function index_action(){
		$banner=$this->obj->DB_select_once("banner","`uid`='".$this->uid."'");
		$this->yunset("banner",$banner); 
		$this->public_action();
		$this->yunset("js_def",2);
		$this->com_tpl("banner");
	}
	
	function save_action(){
	    if($_POST['save']){
			$statis=$this->obj->DB_select_once("company_statis","`uid`='".$this->uid."'",'integral');
			if($statis['integral']<$this->config['integral_banner']&&$this->config['integral_banner_type']!=1){
				$this->ACT_layer_msg($this->config['integral_pricename']."不足，请先充值！",8,"index.php?c=banner");
			}else{
			    if(is_uploaded_file($_FILES['pic']['tmp_name'])){
			        $upload=$this->upload_pic("../data/upload/company/",false,$this->config['com_uppic']);
			        $pictures=$upload->picture($_FILES['pic']);
			        $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
			        $data['uid']=$this->uid;
    		        $data['pic']=str_replace("../data/upload/company/","./data/upload/company/",$pictures);
    		        $this->obj->insert_into("banner",$data);
    		        $this->obj->member_log("上传企业横幅");
    		        $this->get_integral_action($this->uid,"integral_banner","上传企业横幅");
    		        $this->ACT_layer_msg("设置成功！",9,"index.php?c=banner");
			    }
			}
		}
        if($_POST['update']){
            if(is_uploaded_file($_FILES['pic']['tmp_name'])){
                $upload=$this->upload_pic("../data/upload/company/",false,$this->config['com_uppic']);
                $pictures=$upload->picture($_FILES['pic']);
                $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
                $row=$this->obj->DB_select_once("banner","`uid`='".$this->uid."'");
                if(is_array($row)){
                    unlink_pic('.'.$row['pic']);
                }
                $this->obj->update_once("banner",array("pic"=>str_replace("../data/upload/company/","./data/upload/company/",$pictures)),array("uid"=>$this->uid));
                $this->obj->member_log("修改企业横幅");
                $this->ACT_layer_msg("修改成功！",9,"index.php?c=banner");
            }	
        }
	}
}
?>