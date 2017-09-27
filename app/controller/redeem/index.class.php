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
class index_controller extends common{
	function public_action(){
		if($this->config['sy_redeem_web']=="2"){
			header("location:".Url('error'));
		}
	}
	function index_action(){
		$this->public_action();
		$M=$this->MODEL("redeem");

		$rows=$M->GetReward(array('status'=>1),array("field"=>"id,nid,pic,name,integral,stock"));

		$statis=$M->GetRewardOnes(array("uid"=>$this->uid));
		$this->yunset("statis",$statis);
		$recommended=$M->GetReward(array('status'=>1,'rec'=>1),array("field"=>"id,nid,pic,name,integral,stock","limit"=>"16"));
		$this->yunset("recommended",$recommended);
		$remen=$M->GetReward(array('status'=>1,"hot"=>"1"),array("orderby"=>"id desc","limit"=>"16"));
		$this->yunset("remen",$remen);
		$lipin=$M->GetChange(array('1','status'=>1),array("orderby"=>"id desc","field"=>"uid,username,name,ctime,integral,gid","limit"=>"10"));
		if(is_array($lipin)){
        	foreach($lipin as $k=>$v){
        		foreach($rows as $val){
        			if($v['gid']==$val['id']){
        				$lipin[$k]['pic'] = $val['pic'];
        			}
        		}
        		
        	}
        
        	$this->yunset("lipin",$lipin);
        }
		
		$this->seo("redeem");
		$this->yun_tpl(array('index'));
	}
	function list_action(){
		$CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('redeem'));
		$this->yunset($CacheList);
		$where="`status`='1'";
		$this->public_action();
		$integlist=array('1'=>'1-300','2'=>'300-1000','3'=>'1000-5000','4'=>'5000-10000','5'=>'10000-50000','6'=>'50000-100000','7'=>'100000-500000');
		$this->yunset('integlist',$integlist);

		$M=$this->MODEL("redeem");
		if((int)$_GET['id']){
			$where="`nid`='".(int)$_GET['id']."'";
			$urlarr['id']=(int)$_GET['id'];
		}
		if((int)$_GET['intinfo']){
			$bninfo=@explode('-',$integlist[$_GET['intinfo']]);
			$where.=" and `integral` between '".$bninfo[0]."' and '".$bninfo[1]."'";
			$urlarr['intinfo']=(int)$_GET['intinfo'];
		}
		if(in_array($_GET['t'],array('sdate','sort','integral'))){
			$where.=" order by ".$_GET['t']." desc";
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr['c']="list";
		$urlarr['page']="{{page}}";
		$pageurl=Url('redeem',$urlarr);
		$rows=$M->get_page("reward",$where,$pageurl,"15");
		$this->yunset($rows);
		
		$this->seo("redeem");
		$this->yun_tpl(array('list'));
	}
	function show_action(){
		$this->public_action();
		$M=$this->MODEL("redeem");
	    $where="`gid`='".(int)$_GET['id']."' order by `id` desc";
		$urlarr['c']="show";
		$urlarr["id"]=(int)$_GET['id'];
		$urlarr['page']="{{page}}";
		$pageurl=Url("redeem",$urlarr);
		$rows=$M->get_page("change",$where,$pageurl,"13",'*','jilu');
		$this->yunset($rows);
		$row=$M->GetRewardOne(array("id"=>(int)$_GET['id']));
		if($row['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],"没有找到相关商品！");
		}
		$this->yunset("row",$row);
		$remen=$M->GetReward(array("hot"=>"1"),array("orderby"=>"id desc","limit"=>"5"));
		$this->yunset("remen",$remen);
		$this->seo("redeem");
		$this->yun_tpl(array('show'));
	}
	function dh_action(){
		$this->public_action();
		if(!$this->uid && !$this->username){
		     $this->ACT_layer_msg("您还没有登录，请先登录！",8,$_SERVER['HTTP_REFERER']);
		}
		$uinfo=$this->MODEL("userinfo")->GetMemberOne(array("uid"=>(int)$this->uid));
		$this->yunset("uinfo",$uinfo);
		$M=$this->MODEL("redeem");
		$jilu=$M->GetChange(array("gid"=>(int)$_GET['id'],'status'=>1),array("orderby"=>"`id` desc","limit"=>"10"));
		if(is_array($jilu)){
        	foreach($jilu as $k=>$v){
		        $time=time()-$v['ctime'];
				if($time>86400 && $time<604800){
					$jilu[$k]['time'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					$jilu[$k]['time'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					$jilu[$k]['time'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					$jilu[$k]['time'] = "刚刚";
				}else{
					$jilu[$k]['time'] = date("Y-m-d",$v['ctime']);
				}
			} 
		}
		$this->yunset("jilu",$jilu);
		$row=$M->GetRewardOne(array("id"=>(int)$_GET['id']));
		$this->yunset("row",$row);
		$this->yunset("title","兑换确认 - ".$this->config['sy_webname']);
		$this->yun_tpl(array('dh_show'));
	}
	function savedh_action(){
		if($_POST['submit']){
			$Member=$this->MODEL("userinfo");
			$M=$this->MODEL("redeem");
			$_POST['num']=(int)$_POST['num'];
			$_POST['id']=(int)$_POST['id'];
			if(!$_POST['linkman'] || !$_POST['linktel'] ){
				$this->ACT_layer_msg("联系人和联系电话不能为空！",8);
			}
			if(!$_POST['body']){
				$this->ACT_layer_msg("请填写备注、地址！",8);
			}
			if(!$_POST['password']){
				$this->ACT_layer_msg("密码不能为空！",8);
			}
			$info=$Member->GetMemberOne(array("uid"=>$this->uid),array("field"=>"`password`,`salt`"));
			$passwrod=md5(md5($_POST['password']).$info['salt']);
			if($info['password']!=$passwrod){
				$this->ACT_layer_msg("密码不正确！",8);
			}
			if(!$this->uid && !$this->username){
				 $this->ACT_layer_msg("您还没有登录，请先登录！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$_POST['num'] = (int)$_POST['num'];
				$_POST['id'] = (int)$_POST['id'];
				if($_POST['num']<1){
					$this->ACT_layer_msg("请填写正确的数量！",8,$_SERVER['HTTP_REFERER']);
				}else{
					$info=$Member->GetUserstatisOne(array("uid"=>$this->uid),array("usertype"=>$this->usertype,"field"=>"`integral`"));
					$gift=$M->GetRewardOne(array("id"=>(int)$_POST['id']));
					if($_POST['num']>$gift['stock']){
						$this->ACT_layer_msg("已超出库存数量！",8,$_SERVER['HTTP_REFERER']);
					}else{
						if($gift['restriction']!="0"){
							$num=$M->GetChangeNum(array("gid"=>$gift['id'],"uid"=>$this->uid));
							if($num+$_POST['num']>$gift['restriction']){
								$this->ACT_layer_msg("已超出限购数量！",8,$_SERVER['HTTP_REFERER']);
							}
						}
						$integral=$gift['integral']*$_POST['num'];
						if($info['integral']<$integral){
							$this->ACT_layer_msg("您的".$this->config['integral_pricename']."不足！",8);
						}else{
							$Member->company_invtal($this->uid,$integral,false,$this->config['integral_pricename']."兑换",true,2,'integral',24);
							$data['uid']=$this->uid;
							$data['username']=$this->username;
							$data['usertype']=$this->usertype;
							$data['name']=$gift['name'];
							$data['gid']=$gift['id'];
							$data['linkman']=$_POST['linkman'];
							$data['linktel']=$_POST['linktel'];
							$data['body']=$_POST['body'];
							$data['integral']=$integral;
							$data['num']=$_POST['num'];
							$data['ctime']=time();
							$M->AddChange($data);
							$M->UpdateReward(array("num=`num`+'".$_POST['num']."'","stock=`stock`-'".$_POST['num']."'"),array("id"=>$_POST['id']));
							$this->ACT_layer_msg("兑换成功，请等待管理员审核！",9,"index.php?c=show&id=".$_POST['id'] );
						}
					}
				}
			}
		}
	}
}
?>