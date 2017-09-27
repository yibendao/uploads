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
class msg_controller extends user{
	
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"msg","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$this->get_page("userid_msg","`uid`='".$this->uid."' and `type`<>'1' order by id desc",$pageurl,"20");
 		$this->yunset("js_def",4);
		$this->user_tpl('msg');
	}
	function shield_action(){
		if($_GET['id']){
			$info=$this->obj->DB_select_once("userid_msg","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			$data['p_uid']=$info['fid'];
			$data['inputtime']=mktime();
			$data['c_uid']=$this->uid;
			$data['usertype']=1;
			$data['com_name']=$info['fname'];
			$haves=$this->obj->DB_select_once("blacklist","`c_uid`='".$this->uid."' and `p_uid`='".$info['fid']."'  and `usertype`='1'");
			if(is_array($haves)){
				$this->ACT_layer_msg("该用户已在您黑名单中！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$nid=$this->obj->insert_into("blacklist",$data);
				$this->obj->DB_delete_all("userid_msg","`uid`='".$this->uid."' and `fid`='".$info['fid']."'"," ");
				if($nid){
					$this->obj->member_log("屏蔽公司 <".$info['fname']."> ，并删除邀请信息");
					
					$this->layer_msg('操作成功！',9,0,"index.php?c=msg");
				}else{
					$this->layer_msg('操作失败！',8,0,"index.php?c=msg");
				}
			}
		}
	}
	function del_action(){
		if($_GET['id']){
			$del=(int)$_GET['id'];
			$nid=$this->obj->DB_delete_all("userid_msg","`id`='".$del."' and `uid`='".$this->uid."'");
			if($nid){
				
				$this->obj->member_log("删除邀请信息");
				$this->layer_msg('删除成功！',9,0,"index.php?c=msg");
			}else{
				$this->layer_msg('删除失败！',8,0,"index.php?c=msg");
			}
		}
	}
	function ajax_action(){
		if($_POST['id']){
			$this->obj->DB_update_all("userid_msg","`is_browse`='2'","`uid`='".$this->uid."' and `id`='".(int)$_POST['id']."' and `is_browse`='1'");
			
			$row=$this->obj->DB_select_once("userid_msg","`uid`='".$this->uid."' and `id`='".(int)$_POST['id']."'");
			$arr['jobname']=iconv("gbk","utf-8",$row['jobname']);
			$arr['linkman']=iconv("gbk","utf-8",$row['linkman']);
			$arr['linktel']=iconv("gbk","utf-8",$row['linktel']);
			$arr['intertime']=iconv("gbk","utf-8",$row['intertime']);
			$arr['address']=iconv("gbk","utf-8",$row['address']);
			$arr['content']=iconv("gbk","utf-8",$row['content']);
			$arr['comname']=iconv("gbk","utf-8",$row['fname']);
			$arr['datetime']=iconv("gbk","utf-8",date('Y-m-d',$row['datetime']));
			echo json_encode($arr);die;
		}
	}
    function inviteset_action(){
		$id=(int)$_GET['id'];
		$browse=(int)$_GET['browse'];
		if($id){
			$nid=$this->obj->update_once("userid_msg",array('is_browse'=>$browse),array("id"=>$id,"uid"=>$this->uid));
			
			$comuid=$this->obj->DB_select_once("userid_msg","`id`='".$id."'",'fid,jobid');
			$comarr=$this->obj->DB_select_once("company_job","`id`='".$comuid['jobid']."' and `r_status`<>'2' and `status`<>'1'");
			$uid=$this->obj->DB_select_once("company","`uid`='".$comuid['fid']."'","linkmail,linktel,name");
			$name=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","name");
			$data['uid']=$comuid['fid'];
			$data['cname']=$this->username;
			$data['name']=$uid['name'];
			$data['type']="yqmshf";
			$data['cuid']=$this->uid;
			$data['cusername']=$name['name'];
			if($browse==3){
				$data['typemsg']='同意';
			}elseif($browse==4){
				$data['typemsg']='拒绝';
			}	
			if($this->config['sy_msg_yqmshf']=='1'&&$uid["linktel"]&&$this->config["sy_msguser"]&&$this->config["sy_msgpw"]&&$this->config["sy_msgkey"]&&$this->config['sy_msg_isopen']=='1'){$data["moblie"]=$uid["linktel"]; }
			if($this->config['sy_email_yqmshf']=='1'&&$uid["linkmail"]&&$this->config['sy_email_set']=="1"){$data["email"]=$uid["linkmail"]; }
			if($data["email"]||$data['moblie']){
				$this->send_msg_email($data);
			}
			$nid?$this->layer_msg("操作成功！",9,0,"index.php?c=msg"):$this->layer_msg("操作失败！",8,0,"index.php?c=msg");
		}
	}
}
?>