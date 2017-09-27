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
class com_res_controller extends user{
 	function index_action(){
		$telphone=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`telphone`");
		$resume_expect=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."' and `open`='1'","`name`,`doc`,`lastupdate`,`defaults`,`id`,`is_entrust`");
		if(is_array($resume_expect)&& !empty($resume_expect)){
			$html="";
			foreach($resume_expect as $key=>$val){
				if($val['doc']){
					$doc_type='快速简历';
				}else{
					$doc_type='标准简历';
				}
				if($val['is_entrust']=='1'){
					$entrust="<a href='javascript:void(0)' onclick=\"entrust('确定取消？','".$val['id']."')\">取消委托</a>";
					$status="已申请";
				}else if($val['is_entrust']=='2'){
					$entrust="<a href='javascript:void(0)' onclick=\"layer_del('委托已通过审核，取消将不退还金额，确定取消？','".$val['id']."')\">取消委托</a>";
					$status="已通过";
				}else if($val['is_entrust']=='3'){
					$entrust="<a href='javascript:void(0)' onclick=\"entr_resume('".$val['id']."')\">委托</a>";
					$status="未通过";
				}else{
					$entrust="<a href='javascript:void(0)' onclick=\"entr_resume('".$val['id']."')\">委托</a>";
					$status="未申请";
				}
				$html.="<tr class=\"result_class\"><td>".mb_substr($val['name'],0,8,"GBK")."</td><td>".$telphone['telphone']."</td><td><span>".$doc_type."</span></td><td>".date('Y-m-d',$val['lastupdate'])."</td><td>".$status."</td><td>".$entrust."</td></tr>";
			}
			echo $html;die;
		}else{
			echo 1;die;
		}
	}
	function canceltrust_action(){ 
		$resume_expect=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `id`='".(int)$_POST['id']."'","`is_entrust`,`id`");
		if((int)$this->config['user_trust_number']<1&&$resume_expect['is_entrust']=='0'){
			$data['type']='8';
			$data['msg']='网站已关闭此服务。';
		}else if($resume_expect['id']){
			if($resume_expect['is_entrust']=='0'){
				$entrust_num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."' and `is_entrust`>'0'","`id`");
				if($entrust_num<(int)$this->config['user_trust_number']){
					$member_statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","`integral`");
					if($member_statis['integral']<$this->config['pay_trust_resume']&&$this->config['pay_trust_resume']){
						$data['type']='8';
						$data['msg']=$this->config['integral_pricename'].'不足，无法委托。';
						$data['url']='index.php?c=pay';
					}else{						
						$res=$this->company_invtal($this->uid,$this->config['pay_trust_resume'],false,"委托简历",true,2,'integral'); 						
						if($res){
							$idata['uid']      = $this->uid;
							$idata['did']      = $this->userdid;
							$idata['username'] = $this->username;
							$idata['eid']      = $resume_expect['id'];
							$idata['status']   = $this->config['user_trust_status'];
							$idata['price']    = $this->config['pay_trust_resume'];
							$idata['add_time'] = time();
							$nid=$this->obj->insert_into("user_entrust",$idata);
							if($nid){
								if($this->config['pay_trust_resume']=='1'){
									$this->obj->update_once("resume_expect",array('is_entrust'=>2),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
								}else{
									$this->obj->update_once("resume_expect",array('is_entrust'=>1),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
								}
								$data['type']='9';
								$data['msg']='简历委托成功。';
							}else{
								$data['type']='8';
								$data['msg']='简历委托失败。';
							}
						}else{
							$data['type']='8';
							$data['msg']=$this->config['integral_pricename'].'扣除失败，请稍后再试。';
						}
					}
				}else{
					$data['type']='8';
					$data['msg']='您已委托'.$entrust_num.'份简历，无法再次操作。';
				}
			}else if($resume_expect['is_entrust']=='1'){
				$user_entrust=$this->obj->DB_select_once("user_entrust","`uid`='".$this->uid."' and `eid`='".$resume_expect['id']."'");
				if($user_entrust['id']){
					$res=$this->obj->update_once("resume_expect",array('is_entrust'=>0),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
					if($res){
						if($user_entrust['status']=='0'){
							$this->company_invtal($this->uid,$user_entrust['price'],true,"退还委托简历".$this->config['integral_pricename'],true,2,'integral');   
						}
						$this->obj->DB_delete_all("user_entrust","`uid`='".$this->uid."' and `eid`='".$resume_expect['id']."'");
						$data['type']='9';
						$data['msg']='操作成功。';
					}else{
						$data['type']='8';
						$data['msg']='取消失败，请稍后再试。';
					}
				}else{$data['type']='3';$data['msg']='非法操作。';}
			}
		}else{$data['type']='3';$data['msg']='非法操作。';} 
		$data['msg']=iconv("gbk","utf-8",$data['msg']);
		echo json_encode($data);die;
	}
}
?>