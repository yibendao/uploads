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
		
		if(!$this->config['did'] && $this->config['sy_gotocity']=='1' && !$_COOKIE['gotocity']){
			include(PLUS_PATH."domain_cache.php");
			go_to_city($site_domain);
		}
		if($this->config['sy_jobdir']!=""){
			$jobclassurl=$this->config['sy_weburl']."/job/?c=search&";
		}else{
			$jobclassurl=$this->config['sy_weburl']."/index.php?m=job&c=search&";
		}

		$this->yunset("jobclassurl",$jobclassurl);
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
        $this->yunset($CacheList);
		if($this->config["did"]){
			$this->seo("index",$this->config['sy_webtitle'],$this->config['sy_webkeyword'],$this->config['sy_webmeta']);
            $CacheDomainList=$CacheM->GetCache(array('domain'));
            $site_domain=$CacheDomainList['site_domain'];
			if(is_array($site_domain)){
				foreach($site_domain as $d){
					if($d['id']==$this->config["did"]){
						$domain['tpl']=$d['tpl'];
					}
				}
			}
			if($domain['tpl']!=""){
				$tpl=@explode(".",$domain['tpl']);
				$this->yun_tpl(array($tpl[0]));
			}else{
				$this->yun_tpl(array('index'));
			}
		}else{
			$this->seo("index");
			$this->yun_tpl(array('index'));
		}
	}
    function announcement_show(){
        if(is_numeric($_GET['id'])){
            $ID=(int)$_GET['id'];
        }else{
            echo '该公告不存在！';die;
            
        }

        $AnnouncementInfo=$this->MODEL()->DB_select_once('admin_announcement','`id`='.$ID);
        if(!$AnnouncementInfo){
            echo '该公告不存在！';die;
            
        }
        $this->yunset("Info",$AnnouncementInfo);
		$this->seo("announcement");
		$this->yuntpl(array($this->config['style'].'/announcement/show'));
	}
	function top_action(){
		$this->seo("top");
		$this->yun_tpl(array('top'));
	}
	function moblie_action(){
		$this->seo("moblie");
		$this->yun_tpl(array('moblie'));
	}
	function wap_action(){
		$this->seo("wap");
		$this->yun_tpl(array('wap'));
	}
	function weixin_action(){
		$this->seo("weixin");
		$this->yun_tpl(array('weixin'));
	}
	function android_action(){
		$this->seo("android");
		$this->yun_tpl(array('android'));
	}
	function ios_action(){
		$this->seo("ios");
		$this->yun_tpl(array('ios'));
	}
	function site_action(){
		if($this->config["sy_web_site"]!="1"){
			$this->ACT_msg($_SERVER['HTTP_REFERER'], $msg = "暂未开启多站点模式！");
		}
		$this->seo("index");
		$this->yun_tpl(array('site'));
	}
	function logout_action(){
		$this->logout();
	}
	function GetHits_action(){
    	if($_GET['id']){
    		$M=$this->MODEL('article');
    		$M->AddNewsHits(array("id"=>(int)$_GET['id']));
    		$news_info=$M->GetNewsBaseOnce(array("id"=>(int)$_GET['id']),array("field"=>"hits"));
    		echo "document.write('".$news_info["hits"]."')";
    	}
    }
	function get_action(){
		$M=$this->MODEL('index');
		$row=$M->GetDescOne(array("id"=>(int)$_GET['id']));
		$top="";$footer="";
		if($row['top_tpl']==1){
            $top=APP_PATH."/app/template/".$this->config['style']."/header";
		}else if($row['top_tpl']==3){
			 $top=APP_PATH."/app/template/".$row['top_tpl_dir'];
		}
		if($row['footer_tpl']==1){
            $footer=APP_PATH."/app/template/".$this->config['style']."/footer";
		}else if($row['footer_tpl']==3){
			 $footer=APP_PATH."/app/template/".$row['footer_tpl_dir'];
		}
		$seo['title']=$row['title'];
		$seo['keywords']=$row['keyword'];
		$seo['description']=$row['descs'];
		$this->yunset("seo",$seo);
		$this->yunset("name",$row['name']);
		$this->yunset("content",$row['content']);
		$this->header_desc($row['title'],$row['keyword'],$row['descs']);
		$make=APP_PATH."/app/template/".$this->config['style']."/make";
		$make_top=APP_PATH."/app/template/".$this->config['style']."/make_top";
		
		$this->yuntpl(array($make_top,$top,$make,$footer));
	}

	function clickhits_action(){
		if((int)$_GET['id']){
			$M=$this->MODEL("index");
			$id=(int)$_GET['id'];
			$ad=$M->GetAdOne(array("id"=>$id),array("field"=>"pic_src,id"));
			if(!empty($ad)){
				$ip = fun_ip_get();
				if($this->config['sy_adclick']>"0"){
					$num=$M->GetAdclickNum("`ip`='".$ip."' and `aid`='".$id."' and `addtime`>'".strtotime('-'.$this->config['sy_adclick'].' hour')."'");
					if($num>"0"){
						header('Location: '.$ad['pic_src']);
					}
				}
				$data['aid']=$id;
				$data['uid']=$this->uid;
				$data['ip']=$ip;
				$data['addtime']=time();
				$nid=$M->InsertAdclick($data);
				if($nid){
					$M->AddAdHits($id);
				}
				if(!$ad['pic_src']){
					$ad['pic_src']=$this->config['sy_weburl'];
				}
				header('Location: '.$ad['pic_src']);
			}
		}
	}
	 function savecompic_action(){
		if (!empty($_FILES)){
			$pic=$name='';
			$data=array();
			$tempFile = $_FILES['Filedata'];
			$upload=$this->upload_pic("data/upload/show/");
			$pic=$upload->picture($tempFile);
			$name=@explode('.',$_FILES['Filedata']['name']);
			$picurl=str_replace("data/upload/show","./data/upload/show",$pic);
			$data["picurl"]= $picurl;
			$data['title']=$this->stringfilter($name[0]);
			$data["ctime"]=time();
			$data['uid']=(int)$_POST['uid'];
			$id=$this->obj->insert_into("company_show",$data);
			if($id){
 				echo $name[0]."||".$picurl."||".$id;die;
			}else{
				echo "2";die;
			}
		}
	}
	function saveuserpic_action()
	{
		if (!empty($_FILES))
		{
			$pic=$name='';
			$data=array();
			$tempFile = $_FILES['Filedata'];
			$upload=$this->upload_pic("data/upload/show/");
			$pic=$upload->picture($tempFile);
			$name=@explode('.',$_FILES['Filedata']['name']);
			$picurl=str_replace("data/upload/show","./data/upload/show",$pic);
			$data['picurl']= $picurl;
			$data['title']=$this->stringfilter($name[0]);
			$data['ctime']=time();
			$data['uid']=(int)$_POST['uid'];
			$data['eid']=(int)$_GET['eid'];
			$id=$this->obj->insert_into("resume_show",$data);
			if($id){
 				echo $name[0]."||".$picurl."||".$id;die;
			}else{
				echo "2";die;
			}
		}
	}
	
}
?>