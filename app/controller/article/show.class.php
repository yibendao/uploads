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
class show_controller extends article_controller{
	function index_action(){   
		$id=(int)$_GET['id'];
		$M=$this->MODEL('article');
		$news=$M->GetNewsBaseOnce(array('id'=>$id));
		$nid=$news['nid'];
		$row=$M->GetNewsContentOnce(array('nbid'=>$id)); 
		$news['content']=$row['content'];
		$news_last=$M->GetNewsBaseOnce(array("`id`<'".$id."'and `nid`='".$nid."'"),array('orderby'=>" `id` desc"));
		if($news['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],"没有找到该文章！");
		}
		if(!empty($news_last)){ 
			if($this->config[sy_news_rewrite]=="2"){
				$news_last["url"]=$this->config['sy_weburl']."/article/".date("Ymd",$news_last["datetime"])."/".$news_last['id'].".html";
			}else{
				$news_last["url"]= Url('article',array('c'=>'show',"id"=>$news_last[id]),"1"); 
			}
		} 
		$news_next=$M->GetNewsBaseOnce(array("`id`>'".$id."'and `nid`='".$nid."'"),array('orderby'=>" `id` asc"));
		if(!empty($news_next)){
			if($this->config[sy_news_rewrite]=="2"){
				$news_next["url"]=$this->config['sy_weburl']."/article/".date("Ymd",$news_next["datetime"])."/".$news_next['id'].".html";
			}else{
				$news_next["url"]= Url('article',array('c'=>'show',"id"=>$news_next[id]),"1"); 
			} 
		}
		$class=$M->GetNewsGroupOnce(array("id"=>$news['nid']));
		
		if($news["keyword"]!=""){
			
			$keyarr = @explode(",",$news["keyword"]);
			if(is_array($keyarr) && !empty($keyarr)){
				foreach($keyarr as $key=>$value){
					$sqlkeyword[]= " `keyword` LIKE '%$value%'";
				}
				
				$sqlkw = @implode(" OR ",$sqlkeyword); 
				$about=$M->GetNewsBaseList(array("(".$sqlkw.") and `id`<>'".$id."'"),array("orderby"=>'`id` desc ','limit'=>6));
				if(is_array($about)){
					foreach($about as $k=>$v){
						if($this->config[sy_news_rewrite]=="2"){
							$about[$k]["url"]=$this->config['sy_weburl']."/article/".date("Ymd",$v["datetime"])."/".$v['id'].".html";
						}else{
							$about[$k]["url"]= Url('article',array('c'=>'show',"id"=>$v[id]),"1"); 
						}
						
					}
				}
			}
		}
		$info=$news;
		$data['news_title']=$news['title'];
		$data['news_keyword']=$news['keyword']; 
		$data['news_class']=$class['name'];
		$description=$news['description']?$news['description']:$news['content'];
		$data['news_desc']=$this->GET_content_desc($description);
		$this->data=$data;

		
		$info["news_class"]=$class['name'];
		$info["last"]=$news_last;
		$info["next"]=$news_next;
		$info["like"]=$about;
        $info['content']=htmlspecialchars_decode($info['content']);
		preg_match_all('<img.*?src="(.*?)".*/>',$info['content'],$res);
		if(!empty($res[1])){
			foreach($res[1] as $v){
				if(strpos($v,'http:')===false && strpos($v,'https:')===false){
					
					$info['content'] = str_replace($v,$this->config['sy_weburl'].$v,$info['content']);
				}
			}
		}
		$this->yunset("Info",$info);
		
		$this->seo("news_article");
		$this->news_tpl('show');
	}	
}
?>