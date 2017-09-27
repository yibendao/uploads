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
class article_controller extends common{
	function index_action(){
		$this->rightinfo();
		$this->get_moblie();
   		 
  	 	 $M=$this->MODEL('article');
		$news_group=$M->GetNewsGroupList();
    	$a=0;$b=0;
    	$one_class=$two_class=array();
    	if(is_array($news_group)){
      		foreach($news_group as $key=>$v){
				if($v['keyid']==0){
				  $one_class[$a]['id']=$v['id'];
				  $one_class[$a]['name']=$v['name'];
				  $a++;
				}
				if($v['keyid']!=0){
				  if(!is_array($two_class[$v['keyid']]))$b=0;
				  $two_class[$v['keyid']][$b]['id']=$v['id'];
				  $two_class[$v['keyid']][$b]['name']=$v['name'];
				  $two_class[$v['keyid']][$b]['keyid']=$v['keyid'];
				  $b++;
				}
     		 }
    	}
    	$this->yunset("one_class",$one_class);
   	 	$this->yunset("two_class",$two_class);

		if ($_COOKIE['newc']){
		    $newc=explode(',', $_COOKIE['newc']);
		    $this->yunset('newc',$newc);
		    $this->group_cache();
		}
		$this->yunset("headertitle","职场资讯");
		$this->yunset('backurl','index.php');
		$this->seo("news");
		$this->yuntpl(array('wap/article'));
	}
	function show_action(){
		$this->rightinfo();
		$this->get_moblie();
        $NewsM=$this->MODEL('article');
		$id=(int)$_GET[id];
        $NewBaseInfo=$NewsM->GetNewsBaseOnce(array('id'=>$id));
        $NewContentInfo=$NewsM->GetNewsContentOnce(array('nbid'=>$id));
        $NewsInfo=array_merge($NewBaseInfo,$NewContentInfo);
		if($NewsInfo["keyword"]!=""){
		
			$keyarr = @explode(",",$NewsInfo["keyword"]);
			if(is_array($keyarr) && !empty($keyarr)){
				foreach($keyarr as $key=>$value){
					$sqlkeyword[]= " `keyword` LIKE '%$value%'";
				}
				$sqlkw = @implode(" OR ",$sqlkeyword); 
				$about=$NewsM->GetNewsBaseList(array("(".$sqlkw.") and `id`<>'".$id."'"),array("orderby"=>'`id` desc ','limit'=>6));
				if(is_array($about)){
					foreach($about as $k=>$v){
						if($this->config[sy_news_rewrite]=="2"){
							$about[$k]["url"]=$this->config['sy_weburl']."/article/".date("Ymd",$v["datetime"])."/".$v['id'].".html";
						}else{
							$about[$k]["url"]= Url("wap",array('c'=>'article','a'=>'show',"id"=>$v[id]),"1"); 
						} 
					}
				}
			}
		} 
		$info=$NewsInfo;
		$this->yunset("about",$about);

		$data['news_title']=$NewsInfo['title'];
		$data['news_keyword']=$NewsInfo['keyword'];  
		$description=$NewsInfo['description']?$NewsInfo['description']:$NewsInfo['content'];
		$data['news_desc']=$this->GET_content_desc($description);
		$this->data=$data; 
		$info["like"]=$about;
        $info['content']=htmlspecialchars_decode($info['content']);
		$this->yunset("Info",$info);
		
		$this->seo("news_article");
		$this->yunset("headertitle","职场资讯");
		
		$this->yuntpl(array('wap/article_show'));
	}
	function channels_action(){
	    if ($_COOKIE['newc']&&$_COOKIE['oldc']){
		    $newc=explode(',', $_COOKIE['newc']);
		    $oldc=explode(',', $_COOKIE['oldc']);
		    $this->yunset('newc',$newc);
		    $this->yunset('oldc',$oldc);
		    $this->group_cache();
		}
	    $this->seo("news");
	    $this->yunset("headertitle","频道管理");
	    $this->yuntpl(array('wap/article_channels'));
	}
	function editchannels_action(){
	    if ($_POST['newc']){
	        $oldc=@pylode(',', $_POST['oldc']);
	        $newc=@pylode(',', $_POST['newc']);
	        $this->addcookie('oldc',$oldc,time()+86400);
	        $this->addcookie('newc',$newc,time()+86400);
	        echo Url('wap',array('c'=>'article'));die;
	    }else{
	        echo 1;die();
	    }
	}
	function GetHits_action() {
	    if($_GET['id']){
	        $NewsM=$this->MODEL('article');
	        $NewsM->AddNewsHits(array('id'=>(int)$_GET['id']));
	        $hits=$NewsM->GetNewsBaseOnce(array('id'=>(int)$_GET['id']),array('field'=>'hits'));
	        echo 'document.write('.$hits['hits'].')';
	    }
	}
}
?>