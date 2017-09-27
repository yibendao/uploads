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
class redeem_controller extends common{
	function index_action(){
		$M=$this->MODEL('redeem');
		$lipin=$M->GetChange(array('1'),array('orderby'=>'id desc','field'=>'username,name,integral,gid','limit'=>'10'));
		$this->yunset('lipin',$lipin);
		$recommended=$M->GetReward(array('status'=>1,'rec'=>1),array("field"=>"id,nid,pic,name,integral,stock","limit"=>"16"));
		$this->yunset("recommended",$recommended);
		$remen=$M->GetReward(array('status'=>1,'hot'=>'1'),array('orderby'=>'id desc','limit'=>'16'));
		$this->yunset('remen',$remen);
		$this->yunset('headertitle','商城');
		$this->seo("redeem");
		$this->yuntpl(array('wap/redeem'));
	}
	function list_action(){
		$CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('redeem'));
		$this->yunset($CacheList);
		$where="`status`='1' ";
		$M=$this->MODEL('redeem');
		if((int)$_GET['id']){
			$where.=' and `nid`=\''.(int)$_GET['id'].'\'';
			$urlarr['id']=(int)$_GET['id'];
		}
		if(in_array($_GET['t'],array('sdate','sort','integral'))){
			$where.=' order by '.$_GET['t'].' desc';
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=' order by id desc';
		}
		$urlarr['c']='redeem';
		$urlarr['a']='list';
		$urlarr['page']='{{page}}';
		$pageurl=Url('wap',$urlarr);
		$rows=$M->get_page('reward',$where,$pageurl,'10');
		$this->yunset($rows);
		$this->seo('redeem');
		$this->yunset('headertitle','商城');
		$this->yuntpl(array('wap/redeemlist'));
	}
	function show_action(){
		$M=$this->MODEL('redeem');
		$where='`gid`=\''.(int)$_GET['id'].'\' order by `id` desc';
		$urlarr['c']='redeem';
		$urlarr['a']='show';
		$urlarr['id']=(int)$_GET['id'];
		$urlarr['page']='{{page}}';
		$pageurl=Url('wap',$urlarr);
		$rows=$M->get_page('change',$where,$pageurl,'13','*','jilu');
		$this->yunset($rows);
		$row=$M->GetRewardOne(array('id'=>(int)$_GET['id']));
		if($row['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],'没有找到相关商品！');
		} 
		$this->yunset('row',$row);
		if($this->uid){
			$statis=$this->MODEL('userinfo')->GetUserstatisOne(array('uid'=>(int)$this->uid),array('usertype'=>$this->usertype));
		}
		$this->yunset("statis",$statis);
		$this->seo('redeem');
		$this->yunset('headertitle',$row['name']);
		$this->yuntpl(array('wap/redeemshow'));
	}
	function dh_action(){
		if(!$this->uid && !$this->username){
		     $this->ACT_layer_msg('您还没有登录，请先登录！',8,$_SERVER['HTTP_REFERER']);
		}
		$CacheM=$this->MODEL('cache');
		$CacheList=$CacheM->GetCache(array('city','hy','com'));
		$this->yunset($CacheList);
		$uinfo=$this->MODEL('userinfo')->GetMemberOne(array('uid'=>(int)$this->uid));
		$this->yunset('uinfo',$uinfo);
		$M=$this->MODEL('redeem');
		$row=$M->GetRewardOne(array('id'=>(int)$_GET['id']));
		
		
		$integral=$row['integral']*(int)$_GET['num'];
		$this->yunset('integral',$integral);	
						
		$this->yunset('row',$row);				
		$this->yunset('headertitle','兑换确认 ');
		$this->seo('redeem');
		$this->yuntpl(array('wap/redeemdh'));
	}
	function savedh_action(){
		$Member=$this->MODEL('userinfo');
		$M=$this->MODEL('redeem');
		$num=(int)$_POST['num'];
		$id=(int)$_POST['id'];
		$infos=$Member->GetMemberOne(array('uid'=>$this->uid),array('field'=>'password,salt'));
		$passwrod=md5(md5($_POST['password']).$infos['salt']);
		$info=$Member->GetUserstatisOne(array('uid'=>$this->uid),array('usertype'=>$this->usertype,'field'=>'integral'));
		$gift=$M->GetRewardOne(array('id'=>$id));
		$nums=$M->GetChangeNum(array('gid'=>$gift['id'],'uid'=>$this->uid));
		$integral=$gift['integral']*$num;
		if(!$this->uid && !$this->username){
			$res['msg']=yun_iconv('gbk','utf-8','您还没有登录，请先登录！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif(!$_POST['linkman'] || !$_POST['linktel'] ){
			$res['msg']=yun_iconv('gbk','utf-8','收件人和手机号码不能为空！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif($_POST['linktel']&&$this->CheckMoblie($_POST['linktel'])==false){
			$res['msg']=yun_iconv('gbk','utf-8','手机格式错误！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif(!$_POST['password']){
			$res['msg']=yun_iconv('gbk','utf-8','密码不能为空！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif($infos['password']!=$passwrod){
			$res['msg']=yun_iconv('gbk','utf-8','密码不正确！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif($num<1){
			$res['msg']=yun_iconv('gbk','utf-8','请填写正确的数量！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif($num>$gift['stock']){
			$res['msg']=yun_iconv('gbk','utf-8','已超出库存数量！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif($gift['restriction']!='0'&&$nums+$num>$gift['restriction']){
			$res['msg']=yun_iconv('gbk','utf-8','已超出限购数量！');
			$res['type']='8';
			echo json_encode($res);die;
		}elseif($info['integral']<$integral){
			$res['msg']=yun_iconv('gbk','utf-8','您的'.$this->config['integral_pricename'].'不足！');
			$res['type']='8';
			echo json_encode($res);die;
		}else{
			$Member->company_invtal($this->uid,$integral,false,$this->config['integral_pricename'].'兑换',true,2,'integral',24);
			$data['uid']=$this->uid;
			$data['username']=$this->username;
			$data['usertype']=$this->usertype;
			$data['name']=$gift['name'];
			$data['gid']=$gift['id'];
			$data['linkman']=$res['msg']=yun_iconv('utf-8','gbk',$_POST['linkman']);
			$data['linktel']=$_POST['linktel'];
			$data['body']=yun_iconv('utf-8','gbk',$_POST['body']);
			$data['integral']=$integral;
			$data['num']=$num;
			$data['ctime']=time();
			$M->AddChange($data);
			$M->UpdateReward(array('num=`num`+\''.$num.'\'','stock=`stock`-\''.$num.'\''),array('id'=>$id));
			$res['msg']=yun_iconv('gbk','utf-8','兑换成功，请等待管理员审核！');
			$res['type']='9';
			$res['url']='index.php?c=redeem&a=show&id='.$id.'';
			echo json_encode($res);die;
		}		
	}
}
?>