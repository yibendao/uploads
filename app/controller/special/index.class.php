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
class index_controller extends special_controller{
	function index_action(){

		$this->seo("spe_index");
		$this->spetpl('index');
	}
	function show_action(){
		$SpecialM=$this->MODEL('special');
		$info=$SpecialM->GetSpecial(array("id"=>(int)$_GET['id'],"display"=>1));
		$tpl=@explode('.',$info['tpl']);
		if($info['limit']>$info['num']){
			$info['apply']='1';
		}
		if($this->uid && $this->usertype=='2'){
			$SpecialM=$this->MODEL('special');
			$isapply=$SpecialM->GetComNum(array("uid"=>$this->uid,"sid"=>(int)$_GET['id']));
			$this->yunset("isapply",$isapply);
		} 
		$this->data=array('spename'=>$info['title']);
		$this->yunset("info",$info);
		$this->seo("spe_show");
		$this->spetpl($tpl[0]);
	}
	function apply_action(){
		$id=(int)$_POST['id'];
		

		if($this->uid&&$this->usertype=='2'){
			$JobM=$this->MODEL('job');
			$UserInfoM=$this->MODEL('userinfo');
			$SpecialM=$this->MODEL('special');
			$info=$SpecialM->GetSpecial(array("id"=>$id,"display"=>1));
			if($info['com_bm']!='1'){
				$this->layer_msg('该专题禁止报名！',8,0);
			}
			$cominfo=$UserInfoM->GetUserinfoOne(array("uid"=>$this->uid),array('usertype'=>2,'field'=>'name'));
			$statis=$UserInfoM->GetUserstatisOne(array("uid"=>$this->uid),array("usertype"=>'2','field'=>'integral,`rating`'));
			$isapply=$SpecialM->GetComNum(array("uid"=>$this->uid,"id"=>$id,"`status`<'2'"));
			if($isapply){
				$this->layer_msg('您已报名该专题，请等待管理员审核！',8,0);
			}
			
			if($info['rating']){
				$rating=@explode(',',$info['rating']);
			}
			$time=time();
			$jobnum=$JobM->GetComjobNum(array("uid"=>$this->uid,"state"=>'1',"`edate`>'".$time."' and `sdate`<'".$time."'"));
			if($info['limit']<=$info['num']){
				$this->layer_msg('报名已满，请下次提前报名！',8,0);
			}
			if($jobnum<1){
				$this->layer_msg('您暂无公开且合适职位！',8,0);
			}  
			if($rating&&is_array($rating)){ 
				
				if(!in_array($statis['rating'],$rating)){
					$ratings=$UserInfoM->GetRatinginfoAll(array("display"=>1,'category'=>1,"`id` in(".$info['rating'].")"),array("field"=>"`id`,`name`"));
					$rname=array();
					foreach($ratings as $val){
						$rname[]=$val['name'];
					}
					$this->layer_msg("只有".@implode('、',$rname)."才能报名该专题！",8,0);
				}
			}
			if($statis['integral']<$info['integral']){
				$this->layer_msg($this->config['integral_pricename'].'不足，请先充值！',8,0);
			}
			$nid=$this->company_invtal($this->uid,$info['integral'],false,"报名专题招聘",true,2,'integral',9);
			if($nid){
				$SpecialM->AddSpecialCom(array("sid"=>$id,"uid"=>$this->uid,'integral'=>$info['integral'],'status'=>'0','time'=>time()));
				$SpecialM->UpdateSpecial(array("`limit`=`limit`+'1'"),array("id"=>$info['id']));
				$this->layer_msg('报名成功，请耐心等我们工作人员审核！',9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('报名失败，请稍后重试！',8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->layer_msg('只有企业用户才能报名！',8,0);
		}
	}
}
?>