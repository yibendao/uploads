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
class comtpl_controller extends company{
   function index_action() {
		$statis=$this->company_satic();
		$this->yunset("buytpl",@explode(",",$statis['comtpl_all']));
		$list=$this->obj->DB_select_all("company_tpl","`status`='1' and (`service_uid`='0' or FIND_IN_SET('".$this->uid."',service_uid)) order by id desc");
		$this->yunset("list",$list);
		$bannernum=$this->obj->DB_select_num("banner","`uid`='".$this->uid."'","id");
		$this->yunset("bannernum",$bannernum);
		$this->public_action();
		$this->yunset("js_def",2);
		$this->com_tpl('comtpl');
	}
	function settpl_action(){
		if($_POST['savetpl']){
			$list=$this->obj->DB_select_all("company_tpl","`status`='1' and (`service_uid`='0' or FIND_IN_SET('".$this->uid."',service_uid)) order by id desc");
			foreach($list as $v){
				$tplid[]=$v['id'];
			}
			$statis=$this->company_satic();
			if(in_array($_POST['tpl'],$tplid)){
				$row=$this->obj->DB_select_once("company_tpl","`id`='".(int)$_POST['tpl']."'");
				if(strstr($statis['comtpl_all'],$row['url'])==false){
					if($row['type']==1){
						if($statis['integral']<$row['price']){
							$this->ACT_layer_msg("您的".$this->config['integral_pricename']."不足，请先充值！",8,"index.php?c=pay");
						}
						$content="够买了企业模板 <a href=\"".$this->config['sy_weburl']."/company/index.php?id=".$this->uid."\" target=\"_bank\">".$_POST[tplname.$_POST['tpl']]."</a>";
						$this->addstate($content,2);
						$nid=$this->company_invtal($this->uid,$row['price'],false,"购买企业模板",true,2,'integral',15);
					}else{
						if($statis['integral']<$row['price']){
							$this->ACT_layer_msg("您的余额不够购买，请先充值！",8,"index.php?c=pay");
						}
						$content="够买了企业模板 <a href=\"".$this->config['sy_weburl']."/company/index.php?id=".$this->uid."\" target=\"_bank\">".$_POST[tplname.$_POST['tpl']]."</a>";
						$this->addstate($content,2);
						$nid=$this->company_invtal($this->uid,$row['price'],false,"购买企业模板",true,2,"integral",15);
					}
					if($statis['comtpl_all']==''){
						$this->obj->update_once("company_statis",array("comtpl_all"=>$row['url']),array("uid"=>$this->uid));
					}else{
						$this->obj->DB_update_all("company_statis","`comtpl_all`=concat(`comtpl_all`,',$row[url]')","`uid`='".$this->uid."'");
					}
				}
				$oid=$this->obj->update_once("company_statis",array("comtpl"=>$row['url']),array("uid"=>$this->uid));
				if($oid){
					$this->obj->member_log("设置企业模版");
				}else{
					$this->ACT_layer_msg("设置失败，请稍后再试！",8,$_SERVER['HTTP_REFERER']);
				}
			}else{
 				$this->ACT_layer_msg("请正确选择模版！",8,"index.php?c=comtpl");
			}
		}
	}
}
?>