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
	function index_action(){
		if($this->config['cityid']){
			$_GET['cityid'] = $this->config['cityid'];
		}
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('city','com','hy','job'));
		$this->yunset($CacheList);
		$this->seo("firm");
		$this->yunset(array("gettype"=>$_SERVER["QUERY_STRING"],"getinfo"=>$_GET));

		include PLUS_PATH."keyword.cache.php";
		if(is_array($keyword)){
			foreach($keyword as $k=>$v){
				if($v['type']=='4'&&$v['tuijian']=='1'){
					$comkeyword[]=$v;
				}
			}
		}
		$this->yunset("comkeyword",$comkeyword);

        $this->city_cache();
		$this->job_cache();
		$this->com_cache();
		$this->yun_tpl(array('index'));
	}
	function public_action(){
		$M=$this->MODEL("job");
		$UserinfoM=$this->MODEL('userinfo');
		$CompanyM=$this->MODEL('company');
        $sq_num=$M->GetUserJobNum(array('com_id'=>(int)$_GET['id']));
        $this->yunset("sq_num",$sq_num);
        $pl_num=$M->GetComMsgNum(array('cuid'=>(int)$_GET['id']));
        $this->yunset("pl_num",$pl_num);

        $ComMember=$UserinfoM->GetMemberOne(array("uid"=>(int)$_GET['id']),array("field"=>"`source`,`email`,`claim`,`status`"));
		$this->yunset("ComMember",$ComMember);
        $userinfo=$UserinfoM->GetUserinfoOne(array("uid"=>(int)$_GET['id']),array('usertype'=>2));
        $userstatis=$UserinfoM->GetUserstatisOne(array("uid"=>(int)$_GET['id']),array('usertype'=>2));
        $row=array_merge($userinfo,$userstatis);
        if(!is_array($row)){
            $this->ACT_msg($this->config['sy_weburl'],"没有找到该企业！");
        }elseif($ComMember[status]==0){
            $this->ACT_msg($this->config['sy_weburl'],"该企业正在审核中，请稍后查看！");
        }elseif($ComMember[status]==3){
            $this->ACT_msg($this->config['sy_weburl'],"该企业未通过审核！");
        }elseif($row[r_status]==2){
            $this->ACT_msg($this->config['sy_weburl'],"该企业暂被锁定，请稍后查看！");
        } 
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('city','com','hy'));
        $this->yunset($CacheList);
        $city_name=$CacheList['city_name'];
        $comclass_name=$CacheList['comclass_name'];
        $industry_name=$CacheList['industry_name'];
        $city['provinceid']=$row['provinceid'];
        $city['cityid']=$row['cityid'];
        $city['three_cityid']=$row['three_cityid'];
        $row['provinceid']=$city_name[$row['provinceid']];
        $row['mun_info']=$comclass_name[$row['mun']];
        $row['pr_info']=$comclass_name[$row['pr']];
        $row['hy_info']=$industry_name[$row['hy']];
        if(!$row['logo'] || !file_exists(str_replace($this->config['sy_weburl'],APP_PATH,'.'.$row['logo']))){
            $row['logo']=$this->config['sy_weburl']."/".$this->config['sy_unit_icon'];
        }else{
            $row['logo']=str_replace("./",$this->config['sy_weburl']."/",$row['logo']);
        }
        if($row['comqcode']){
        	$row['comqcode']=str_replace("./",$this->config['sy_weburl']."/",$row['comqcode']);
        }
		
        $banner=$CompanyM->GetBannerOnes(array('uid'=>(int)$_GET['id']));
        if(!$banner['pic']||!file_exists(str_replace($this->config['sy_weburl'],APP_PATH,'.'.$banner['pic']))){
            $banner['pic']=$this->config['sy_weburl']."/".$this->config['sy_banner'];
        }else{
            $banner['pic']=str_replace("./",$this->config['sy_weburl']."/",$banner['pic']);
        }
		if($row['infostatus']=='2'){
			$row['linkphone']=$row['linktel']=$row['linkmail']=$row['linkqq']='';
		}
		$this->yunset("com",$row);
		$this->yunset("city",$city);
        $this->yunset("banner",$banner);
        $NewsList=$CompanyM->GetNewsAll(array('status'=>1,'uid'=>$_GET['id']));
        $this->yunset('NewsList',$NewsList);
        $ProductList=$CompanyM->GetProductAll(array('status'=>1,'uid'=>$_GET['id']));
        $this->yunset('ProductList',$ProductList);
        $data['infostatus']=$row['infostatus'];
		$data['company_name']=$row['name'];
		$data['company_name_desc']=$row['content'];
		$data['industry_class']=$row['hy_info'];
		
		if($this->config['com_login_link']=='2'){
		    $look_msg="网站没有开放企业联系信息！";
		    $looktype="2";
		}elseif($this->config['com_login_link']=='1'){
		    if($data['infostatus']==2){
		        $look_msg="企业没有公开联系信息！";
		        $looktype="3";
		    }else{
		        $looktype="1";
		    }
		}elseif($this->config['com_login_link']=="3"){
		    if($this->uid=='' &&$this->username==''){
		        $look_msg="您还没有登录，登录后才可以查看联系方式";
		        $looktype="4";
		    }elseif($this->usertype!=1&&(int)$_GET['id']!=$this->uid){
		        $look_msg="您不是个人用户，不能查看联系方式";
		        $looktype="5";
		    }elseif($this->usertype==2&&(int)$_GET['id']==$this->uid){
		        $looktype="1";
		    }else{
		        if($this->config['com_resume_link']=="1"){
		            $Resume=$this->MODEL('resume');
		            $rows=$Resume->GetResumeExpectNum(array("uid"=>$this->uid));
		            if($data['infostatus']==2){
		                $look_msg="企业没有公开联系信息！";
		                $looktype="3";
		            }else{
		                if($rows<1){
		                    $look_msg="您缺少一份正式的个人简历，暂时无法查看该企业联系方式！";
		                    $looktype="6";
		                }else{
		                    $looktype="1";
		                }
		            }
		        }else{
		            if($data['infostatus']==2){
		                $look_msg="企业没有公开联系信息！";
		                $looktype="3";
		            }else{
		                $looktype="1";
		            }
		        }
		    }
		}
		$this->yunset("look_msg",$look_msg);
		$this->yunset("looktype",$looktype);
		
		if($this->uid&&$this->usertype=='1'){
		    $AskM=$this->MODEL('ask');
		    $isatn=$AskM->GetAtnOne(array("uid"=>$this->uid,"sc_uid"=>(int)$_GET['id']));
		    $this->yunset("isatn",$isatn);
		}
		$id=(int)$_GET['id'];
		$memeber = $this->obj->DB_select_once("member","`uid`=$id","`login_date`");
		$this->yunset("member",$memeber);
		$invite_resume=$this->obj->DB_select_num("userid_msg","`fid`=$id");
		$de_resume=$this->obj->DB_select_num("userid_job","`com_id`=$id and `is_browse`='1'");
		$des_resume=$this->obj->DB_select_num("userid_job","`com_id`=$id");
		if ($de_resume&&!empty($de_resume)){
		    $pre=round((1-$de_resume/$des_resume)*100);
		}else{
		    $pre=100;
		}
		$time=strtotime("-14 day");
		$limit=2;
		$pageurl=Url('company',array('id'=>(int)$_GET['id'],'c'=>'show','page'=>'{{page}}'));
		$jobs=$this->get_page("company_job","`uid`='".(int)$_GET['id']."' and `r_status`='1' and `status`='0' and `state`='1' order by lastupdate desc",$pageurl,$limit);
		$this->yunset('jobs',$jobs);
		$this->yunset("pre",$pre);
		$M=$this->MODEL('job');
		$num=$M->GetComjobNum(array('uid'=>(int)$_GET['id'],'`r_status`<>2','`status`<>1','state'=>1));
		$this->yunset("num",$num);
		$this->yunset("invite_resume",$invite_resume);
		$this->yunset("id",$id);
		$this->lookcom();
		return $data;
	}
    function show_action(){
    	$data=$this->public_action();
    	$UserinfoM=$this->MODEL('userinfo');
		$JobM=$this->MODEL('job');
    	$CompanyM=$this->MODEL('company');
		$M=$this->MODEL('job');
		$CompanyM->UpdateCompany(array("`hits`=`hits`+1"),array("uid"=>(int)$_GET['id']));
        if($_GET['style']){
        	$urlmsg=Url('company',array('c'=>'msg','id'=>(int)$_GET['id'],'style'=>$_GET['style']));
        }else{
        	$urlmsg=Url('company',array('c'=>'msg','id'=>(int)$_GET['id']));
        }
        $this->yunset("urlmsg",$urlmsg);
		$this->data=$data;
		$this->seo("company_index");
    	$this->comtpl("index");
    }

	function lookcom(){
		$CompanyM=$this->MODEL('company');
		$M=$this->MODEL('job');
		$lookuser=$M->GetLookJobList(array('com_id'=>(int)$_GET['id']),array("orderby"=>"datetime","desc"=>"desc",'field'=>'id,uid'));
        if(is_array($lookuser)){
        	foreach ($lookuser as $v){
        		$uids[]=$v['uid'];
        	}
        	$lookcom=$M->GetLookJobList(array('`uid` in ('.pylode(',', $uids).') and `com_id` <> \''.(int)$_GET['id'].'\''),array('limit'=>6,"orderby"=>"datetime","desc"=>"desc",'field'=>'com_id'));
        	foreach ($lookcom as $v){
        		$comids[]=$v['com_id'];
        	}
        	$coms=$CompanyM->GetComList(array('`uid` in ('.pylode(',', $comids).')'),array('field'=>'uid,name'));
        	foreach ($lookcom as $key=>$val){
        		foreach ($coms as $v){
        			if($val['com_id']==$v['uid']){
        				$lookcom[$key]['comname']=$v['name'];
        			}
        		}
        		$jobnum=$M->GetComjobNum(array('uid'=>$val['com_id']));
        		$lookcom[$key]['jobnum']=$jobnum; 
        	}
        }
        $this->yunset("lookcom",$lookcom);	
	}
	function msg_action(){
	    $where='cuid='.(int)$_GET['id'].' and `status`=1';
	  
        $msglist=$this->obj->DB_select_all('company_msg',$where,'jobid');
		if(is_array($msglist)&&$msglist){
			foreach($msglist as $v){
				$jobid[]=$v['jobid'];
			}
			$job=$this->obj->DB_select_all('company_job', "id in (".pylode(',', $jobid).") limit 3","id,name");
		}

		$this->yunset("msgjob",$job);
		$data=$this->public_action();
		$this->data=$data;
		$this->seo("company_msg");
		$this->comtpl("msg");
	}
	function comtpl($tpl){
        if ($_GET['style'] && !preg_match('/^[a-zA-Z]+$/',$_GET['style'])){
            exit();
        }
        if ($_GET['tp'] && !preg_match('/^[a-zA-Z]+$/',$_GET['tp'])){
            exit();
        }
        $UserinfoM=$this->MODEL('userinfo');
        $statis=$UserinfoM->GetUserstatisOne(array("uid"=>(int)$_GET['id']),array('usertype'=>2));
        if($statis['comtpl'] && $statis['comtpl']!="default" && !$_GET['style']){
            $tplurl=$statis['comtpl'];
        }else{
            $tplurl="default";
        }
        if($_GET['style']){
            $tplurl=$_GET['style'];
        } 
		
		$this->yunset(array("com_style"=>$this->config['sy_weburl']."/app/template/company/".$tplurl."/","comstyle"=>TPL_PATH."company/".$tplurl."/")); 
		$this->yuntpl(array('company/'.$tplurl."/".$tpl));
	}
	function productshow_action(){
		$CompanyM=$this->MODEL("company");
        $Where['id']=(int)$_GET['pid'];
		session_start();
        if(!is_numeric($_SESSION['auid']) && (int)$_GET['id']!=$this->uid){
            $Where['status']=1;
        }
        $ProductInfo=$CompanyM->GetProductOne($Where);
        $this->yunset('ProductInfo',$ProductInfo);
		$data=$this->public_action();
		$data['company_product']=$ProductInfo['name'];
		$this->data=$data;
	    $this->seo("company_productshow");
		$this->comtpl("productshow");
	}
	function newsshow_action(){
		$CompanyM=$this->MODEL('company');
        $Where['id']=$_GET['nid'];
		session_start();
        if(!is_numeric($_SESSION['auid']) && (int)$_GET['id']!=$this->uid){
            $Where['status']=1;
        }
        $NewsInfo=$CompanyM->GetNewsOne($Where);
        $this->yunset('NewsInfo',$NewsInfo);
		$data=$this->public_action();
		$data['company_news']=$NewsInfo['title'];
		$this->data=$data;
	    $this->seo("company_newsshow");
		$this->comtpl("newsshow");
	}
	function prestr_action(){
		
	    if($_POST['page']){
	        $M=$this->MODEL('job');
	        $page=intval($_POST['page']);
	        $num=$M->GetComjobNum(array('uid'=>(int)$_POST['id'],'`r_status`<>2','`status`<>1','state'=>1));
	        $limit=intval($_POST['limit']);
	        $maxpage=intval(ceil($num/$limit));
	        if ($page>$maxpage){
	            $page=$maxpage;
	        }
	        if (intval($_POST['updown'])==1){
				$list['url'] = str_replace('compage','page',Url('company',array('c'=>'show','id'=>(int)$_POST['id'],'compage'=>max(1,($page-1)))));
	        }else if (intval($_POST['updown'])==2){
				$list['url'] = str_replace('compage','page',Url('company',array('c'=>'show','id'=>(int)$_POST['id'],'compage'=>min($maxpage,($page+1)))));
	        }
	        echo json_encode($list);
	    }
	}
}
?>