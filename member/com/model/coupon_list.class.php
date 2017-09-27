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
class coupon_list_controller extends company
{	

	function index_action(){
		$this->obj->DB_update_all("coupon_list","`status`='3'","`uid`='".$this->uid."' and `validity`<'".time()."' and `status`='1'");
		$this->public_action();
		$urlarr['c']='coupon_list';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("coupon_list","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if($rows&&is_array($rows)){
			$source=array();
			foreach($rows as $val){
				if(in_array($val['source'],$source)==false&&$val['source']){
					$source[]=$val['source'];
				} 
			}
			if($source&&is_array($source)){
				$company=$this->obj->DB_select_all("company","`uid` in(".pylode(',',$source).")","`uid`,`name`"); 
				foreach($rows as $k=>$v){
					foreach($company as $val){
						if($val['uid']==$v['source']){
							$rows[$k]['sourcename']=$val['name'];
						}
					}
				}
			} 
			$info=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`name`"); 
			$this->yunset("info",$info);
		} 
		$this->yunset("js_def",4);
		$this->com_tpl('coupon_list');
	}
	function searchcomname_action(){
		$name=iconv('utf-8','gbk',trim($_POST['username']));
		if($name){
			$company=$this->obj->DB_select_all("company","`name` like '%".$name."%' and `uid`<>'".$this->uid."' order by `lastupdate` desc limit 100","`uid`,`name`");
			
			if($company&&is_array($company)){
				$html='';
				foreach($company as $val){
					$html.="<li class=\"cur\"><input class=\"re-company\" type=\"radio\" value=\"".$val['uid']."\" name=\"buid\"><a href=\"".Url('company',array('c'=>'show',"id"=>$val['uid']))."\" target=\"_blank\">".$val['name']."</a></li>";
				}
			}else{
				$html="<li class=\"cur\">暂无符合条件企业</li>";
			}
			echo $html;die;			
		}
	}
	function save_action(){
		$coupon=intval($_POST['coupon']);
		$buid=intval($_POST['buid']);
		if($buid==''){
			$this->ACT_layer_msg("请选择要赠送的企业！",8,$_SERVER['HTTP_REFERER']);
		}  
		$row=$this->obj->DB_select_once("coupon_list","`uid`='".$this->uid."' and `id`='".$coupon."' and `status`='1' and `validity`>'".time()."'");
		 
		if($row['id']){
			$nid=$this->obj->DB_update_all("coupon_list","`uid`='".$buid."',`source`='".$this->uid."'","`uid`='".$this->uid."' and `id`='".intval($row['id'])."'");
			$nid?$this->ACT_layer_msg("操作成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg("操作失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function del_action(){
		if($_GET['id']){
			$nid=$this->obj->DB_delete_all("coupon_list","`uid`='".$this->uid."' and `id`='".intval($_GET['id'])."' and `status` in('2','3')");
			if($nid){
				$this->obj->member_log("删除优惠券",3,3);
				$this->layer_msg('删除成功！',9,0,"index.php?c=coupon_list");
			}else{
				$this->layer_msg('删除失败！',8,0,"index.php?c=coupon_list");
			}
		}
	}
}
?>