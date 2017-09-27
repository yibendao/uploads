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
class cache_controller extends common{
	function index_action(){
		if($_POST["madeall"]){ 
			if($this->config['sy_web_site']==1){  
				$index='../index.html';
				if(file_exists($index)){
					@unlink($index);
				}
				$this->ACT_layer_msg("分站已开启，不支持生成首页静态！",8);
			}else{
				$fw=$this->webindex($_POST['make_index_url']);
				$config=$this->obj->DB_select_num("admin_config","`name`='make_index_url'");
				if($config==false)
				{
					$this->obj->DB_insert_once("admin_config","`name`='make_index_url',`config`='".$_POST['make_index_url']."'");
				}else{
					$this->obj->DB_update_all("admin_config","`config`='".$_POST['make_index_url']."'","`name`='make_index_url'");
				}
				$this->web_config();
				$fw?$this->ACT_layer_msg( "生成成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "生成失败！",8,$_SERVER['HTTP_REFERER']);
			}
		}
		$this->yunset("type","index");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function cache_action(){
		include_once(CONFIG_PATH."db.data.php");
		$this->yunset("type",$arr_data['cache']);
		if($_POST["madeall"]){
			
			$this->makecache_action();
		}
		$this->yuntpl(array('admin/admin_cache'));
	}
	function once_action(){
		set_time_limit(200);
		if($_POST['make']){
			$where="`is_type`='1'";
			if($_POST['desc']>0){
				$where.=" and  `id`='".$_POST['desc']."'";
			}
			$rows=$this->obj->DB_select_all("description",$where);

			if(@is_array($rows)){
				foreach($rows as $row){
                    $this->descriptionshow($row[id],$row['url']);
				}
			}
			echo 1;die;
		}
		$rows=$this->obj->DB_select_all("description","1","`id`,`name`");
		$this->yunset("rows",$rows);
		$this->yunset("type","once");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function news_action(){
		set_time_limit(200);
		if($_POST["madeall"]){
			if($this->config['sy_web_site']==1){
				$index='../news.html';
				if(file_exists($index)){
					@unlink($index);
				}
				$this->ACT_layer_msg("分站已开启，不支持生成文件！",8);
			}else{
            	$fw=$this->articleindex($_POST["make_new_url"]);
				$config=$this->obj->DB_select_num("admin_config","`name`='make_new_url'");
				if($config==false)
				{
					$this->obj->DB_insert_once("admin_config","`name`='make_new_url',`config`='".$_POST["make_new_url"]."'");
				}else{
					$this->obj->DB_update_all("admin_config","`config`='".$_POST["make_new_url"]."'","`name`='make_new_url'");
				}
				$this->web_config();
				$fw?$this->ACT_layer_msg( "新闻生成(ID:$fw)成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "新闻生成(ID:$fw)失败！",8,$_SERVER['HTTP_REFERER']);	
			}
		}
		$this->yunset("type","news");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function newsclass_action(){
		set_time_limit(200);
		if($_POST['action']=="makeclass"){
			$val=$this->mk_newsclass();
			if(is_array($val)){
				foreach($val as $va){
					if($name==""){$name=iconv("UTF-8","gbk",$va);}
				}
				$this->get_return("class",$val,"正在生成新闻类别--".$name);
			}else{
				$this->get_return("ok",0,"全部生成完成");
			}
		}
		$rows=$this->obj->DB_select_all("news_group");
		$this->yunset("rows",$rows);
		foreach($rows as $v){
			$classid[]=$v["id"];
		}
		$this->yunset("classid",@implode(',',$classid));
		$this->yunset("type","newsclass");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function archive_action(){
		set_time_limit(200);
		if($_POST['action']=="makearchive"){
			$pagesize=$_POST['limit'];
			$page=$this->mk_archive($pagesize);
			if($page){
				if($page!=1){
					$npage=$page;
					$page=$page-1;
					$spage=$page*$pagesize;
					$topage=$spage+$pagesize;
				}else{
					$npage=$page;
					$spage=$page;
					$topage=$pagesize;
				}
				$name=$spage."-".$topage;
				$this->get_return("archive",$npage,"正在生成".$name."新闻");
			}else{
				$this->get_return("ok",0,"全部生成完成");
			}
		}
		$rows=$this->obj->DB_select_all("news_group");
		$this->yunset("rows",$rows);
		$this->yunset("type","archive");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function all_action(){
		set_time_limit(200);
		if($_POST['action']=="makeall"){
			if($this->config['sy_web_site']==1){
				if($_POST['type']=="cache"){
					include_once(LIB_PATH."cache.class.php");
					include_once("model/model/advertise_class.php");
					$cacheclass= new cache(PLUS_PATH,$this->obj);
					include_once(CONFIG_PATH."db.data.php");
					$value=$_POST['value']+1;
				
					if($value==1){
						$makecache=$cacheclass->city_cache("city.cache.php");
					}
					if($value==2){
						$makecache=$cacheclass->industry_cache("industry.cache.php");
					}
					if($value==3){
						$makecache=$cacheclass->job_cache("job.cache.php");
					}
					if($value==4){
						$makecache=$cacheclass->user_cache("user.cache.php");
					}
					if($value==5){
						$makecache=$cacheclass->com_cache("com.cache.php");
					}
					if($value==6){
						$makecache=$cacheclass->menu_cache("menu.cache.php");
					}
					if($value==7){
						$cache=$this->del_dir("../data/templates_c",1);
						$cache=$this->del_dir("../data/cache",1);
					}
					if($value==8){
						$makecache=$cacheclass->seo_cache("seo.cache.php");
					}
					if($value==9){
						$makecache=$cacheclass->domain_cache("domain_cache.php");
					}
					if($value==10){
						$makecache=$cacheclass->keyword_cache("keyword.cache.php");
					}
					if($value==11){
						$makecache=$cacheclass->link_cache("link.cache.php");
					}
					if($value==12){
						$makecache=$cacheclass->group_cache("group.cache.php");
					}
					if($value==13){
						$makecache=$cacheclass->desc_cache("desc.cache.php");
					}
					if($value==14){
						$adver = new advertise($this->obj);
						$adver->model_ad_arr_action();
					}
					if($value==15){
						$makecache=$cacheclass->part_cache("part.cache.php");
					}
					
					if($value==16){
						$makecache=$cacheclass->redeem_cache("redeem.cache.php");
					}
					if($value==17){
						$makecache=$cacheclass->database_cache("dbstruct.cache.php");
					}
					if($value==18){
						$makecache=$cacheclass->emailconfig_cache("emailconfig.cache.php");
					}
					if($value<=18){
						$v=$value+1;
						$this->get_return("cache",$value,"正在生成".$arr_data['cache'][$v]);
					}
					$index='../index.html';
					$news='../news.html';
					if(file_exists($index)||file_exists($news)){
						@unlink($index);
						@unlink($news);
					}
					$this->get_return("ok",0,"全部生成完成");
					echo json_encode($data);die;
				}
			}else{
				if($_POST['type']=="cache"){
					include_once(LIB_PATH."cache.class.php");
					include_once("model/model/advertise_class.php");
					$cacheclass= new cache(PLUS_PATH,$this->obj);
					include_once(CONFIG_PATH."db.data.php");
					$value=$_POST['value']+1;
				
					if($value==1){
						$makecache=$cacheclass->city_cache("city.cache.php");
					}
					if($value==2){
						$makecache=$cacheclass->industry_cache("industry.cache.php");
					}
					if($value==3){
						$makecache=$cacheclass->job_cache("job.cache.php");
					}
					if($value==4){
						$makecache=$cacheclass->user_cache("user.cache.php");
					}
					if($value==5){
						$makecache=$cacheclass->com_cache("com.cache.php");
					}
					if($value==6){
						$makecache=$cacheclass->menu_cache("menu.cache.php");
					}
					if($value==7){
						$cache=$this->del_dir("../data/templates_c",1);
						$cache=$this->del_dir("../data/cache",1);
					}
					if($value==8){
						$makecache=$cacheclass->seo_cache("seo.cache.php");
					}
					if($value==9){
						$makecache=$cacheclass->domain_cache("domain_cache.php");
					}
					if($value==10){
						$makecache=$cacheclass->keyword_cache("keyword.cache.php");
					}
					if($value==11){
						$makecache=$cacheclass->link_cache("link.cache.php");
					}
					if($value==12){
						$makecache=$cacheclass->group_cache("group.cache.php");
					}
					if($value==13){
						$makecache=$cacheclass->desc_cache("desc.cache.php");
					}
					if($value==14){
						$adver = new advertise($this->obj);
						$adver->model_ad_arr_action();
					}
					if($value==15){
						$makecache=$cacheclass->part_cache("part.cache.php");
					}
					
					if($value==16){
						$makecache=$cacheclass->redeem_cache("redeem.cache.php");
					}
					if($value==17){
						$makecache=$cacheclass->database_cache("dbstruct.cache.php");
					}
					if($value==18){
						$makecache=$cacheclass->emailconfig_cache("emailconfig.cache.php");
					}
					if($value<=18){
						$v=$value+1;
						$this->get_return("cache",$value,"正在生成".$arr_data['cache'][$v]);
					}
					$fw=$this->webindex($_POST['make_index_url']);
					$config=$this->obj->DB_select_num("admin_config","`name`='make_index_url'");
					if($config==false)
					{
						$this->obj->DB_insert_once("admin_config","`name`='make_index_url',`config`='".$_POST['make_index_url']."'");
					}else{
						$this->obj->DB_update_all("admin_config","`config`='".$_POST['make_index_url']."'","`name`='make_index_url'");
					}
					$this->web_config();
					$this->get_return("index","index","正在生成首页");					
					echo json_encode($data);die;
				}
				if($_POST['type']=="index"){
					if($_POST['value']=="make_index_url"){
							
						$fw=$this->webindex($_POST['make_index_url']);
						$config=$this->obj->DB_select_num("admin_config","`name`='make_index_url'");
						if($config==false)
						{
							$this->obj->DB_insert_once("admin_config","`name`='make_index_url',`config`='".$_POST['make_index_url']."'");
						}else{
							$this->obj->DB_update_all("admin_config","`config`='".$_POST['make_index_url']."'","`name`='make_index_url'");
						}
						$this->web_config();
							
						$this->get_return("index","news","正在生成新闻首页");
					}else{
						 
						$this->articleindex($_POST["make_new_url"]);
						$config=$this->obj->DB_select_num("admin_config","`name`='make_new_url'");
						if($config==false)
						{
							$this->obj->DB_insert_once("admin_config","`name`='make_new_url',`config`='".$_POST["make_new_url"]."'");
						}else{
							$this->obj->DB_update_all("admin_config","`config`='".$_POST["make_new_url"]."'","`name`='make_new_url'");
						}
						$this->web_config();
							
						$this->get_return("class",0,"正在获取新闻类别数目");
					}
					echo json_encode($data);die;
				}
				if($_POST['type']=="class"){
					$val=$this->mk_newsclass();
					if(is_array($val)){
						foreach($val as $va){
							if($name==""){
								$name=iconv("UTF-8","gbk",$va);
							}
						}
						$this->get_return("class",$val,"正在生成新闻类别--".$name);
					}else{
						$this->get_return("archive",0,"正在获取新闻详细页数目");
					}
				}
				if($_POST['type']=="archive"){
					$pagesize="20";
					$page=$this->mk_archive($pagesize);
					if($page){
						if($page!=1){
							$npage=$page;
							$page=$page-1;
							$spage=$page*$pagesize;
							$topage=$spage+$pagesize;
						}else{
							$npage=$page;
							$spage=$page;
							$topage=$pagesize;
						}
						$name=$spage."-".$topage;
						$this->get_return("archive",$npage,"正在生成".$name."新闻");
					}else{
						$this->get_return("ok",0,"全部生成完成");
					}
				}
			}
		}
		$this->yunset("type","all");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function makecache_action(){
		set_time_limit(200);
		extract($_POST);
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);

		if(@in_array("1",$cache)){
			$makecache=$cacheclass->city_cache("city.cache.php");
		}
		if(@in_array("2",$cache)){
			$makecache=$cacheclass->industry_cache("industry.cache.php");
		}
		if(@in_array("3",$cache)){
			$makecache=$cacheclass->job_cache("job.cache.php");
		}
		if(@in_array("4",$cache)){
			$makecache=$cacheclass->user_cache("user.cache.php");
		}
		if(@in_array("5",$cache)){
			$makecache=$cacheclass->com_cache("com.cache.php");
		}
		if(@in_array("6",$cache)){
			$makecache=$cacheclass->menu_cache("menu.cache.php");
		}
		if(@in_array("7",$cache)){
			$makecache=$this->del_dir("../data/templates_c",1);
			$makecache=$this->del_dir("../data/cache",1);
		}
		if(@in_array("8",$cache)){
			$makecache=$cacheclass->seo_cache("seo.cache.php");
		}
		if(@in_array("9",$cache)){
			$makecache=$cacheclass->domain_cache("domain_cache.php");
		}
		if(@in_array("10",$cache)){
			$makecache=$cacheclass->keyword_cache("keyword.cache.php");
		}
		if(@in_array("11",$cache)){
			$makecache=$cacheclass->link_cache("link.cache.php");
		}
		if(@in_array("12",$cache)){
			$makecache=$cacheclass->group_cache("group.cache.php");
		}
        if(@in_array('13',$cache)){
            $makecache=$cacheclass->desc_cache("desc.cache.php");
        }
		if(@in_array('14',$cache)){
			include_once("model/model/advertise_class.php");
			$adver = new advertise($this->obj);
			$makecache=$adver->model_ad_arr_action();
		}
		if(@in_array('15',$cache)){
		    $makecache=$cacheclass->part_cache("part.cache.php");
		}
		
        if(@in_array('16',$cache)){
			$makecache=$cacheclass->redeem_cache("redeem.cache.php");
		}
		if(@in_array('17',$cache)){
			$makecache=$cacheclass->database_cache("dbstruct.cache.php");
		}
		if(@in_array('18',$cache)){
			$makecache=$cacheclass->emailconfig_cache("emailconfig.cache.php");
		}
		if($makecache){
			$this->ACT_layer_msg( "生成(ID:$makecache)成功！",9,"index.php?m=cache&c=cache",2,1);
		}else{
			$this->ACT_layer_msg( "生成(ID:$makecache)失败！",8,"index.php?m=cache&c=cache");
		}
       
        
	}
	function mk_newsclass(){
		if($_POST['value']==0){
			$where=1;
			if($_POST['group']!="all" && $_POST['group']){
				$where.=" and `id`='".$_POST['group']."'";
			}
			$rows=$this->obj->DB_select_all("news_group",$where);
			if(is_array($rows)){
				foreach($rows as $v){
					$val[$v['id']]=iconv("gbk","UTF-8",$v['name']);
				}
			}
		}else{
			$rows=$_POST['value'];
			if(is_array($rows)){
				foreach($rows as $k=>$va){
					if($nid==""){
						$nid=$k;
					}else{
						$val[$k]=$va;
					}
				}
			}
			$this->makenewsclass($nid);
		}
		return $val;
	}
	function mk_archive($pagesize){
		if($_POST['value']==0){
			$where="1";
			$stime=strtotime($_POST['stime']);
			$etime=strtotime($_POST['etime']);
			if($stime&&preg_match("/^\d*$/",$stime)){
				$where.=" and `datetime`>='".$stime."'";
			}
			if($etime&&preg_match("/^\d*$/",$etime)){
				$where.=" and `datetime`<='".$etime."'";
			}
			if($_POST['group']>0){
				$where.=" and `nid`='".$_POST['group']."'";
			}
			if($_POST['startid']>0){
				$where.=" and `id`>='".$_POST['startid']."'";
			}
			if($_POST['endid']>0){
				$where.=" and `id`<='".$_POST['endid']."'";
			}

			$news_list=$this->obj->DB_select_all("news_base",$where,"`id`,`datetime`");
			$allnum=count($news_list);
			$allpage=ceil(($allnum)/$pagesize);
			$i=1;
			foreach($news_list as $v){
				if(count($val[$i])<=$pagesize){
					$val[$i][$v['id']]=$v['datetime'];
				}else{
					$i++;
					$val[$i][$v['id']]=$v['datetime'];
				}
			}
			if($val&&is_array($val)){
				made_web("../data/plus/news.cache.php",ArrayToString($val),"newscache");
				$page=1;
			}
		}else{
			$page=$_POST['value'];
			include_once(PLUS_PATH."news.cache.php");
			if(is_array($newscache)){
				foreach($newscache as $k=>$va){
					if($k==$page){
                        $index=0;
						foreach($va as $key=>$value){
                            $NewsIDList[]=$key;
                        }
					}elseif($k>$page){
						$val[$k]=$va;
					}
				}
			}
            $news_list=$this->obj->DB_select_all("news_base",'`id` in ('.implode(',',$NewsIDList).') order by `id` desc','*');
            foreach($news_list as $k=>$v){
                $NewsIDList[]=$v['id'];
            }
            $contentrows=$this->obj->DB_select_all("news_content",'`nbid` in ('.implode(',',$NewsIDList).') order by `nbid` desc');
            foreach($news_list as $k1=>$v1){
                foreach($contentrows as $k2=>$v2){
                    if($v1['id']==$v2['nbid']){
                        $news_list[$k1]['content']=$v2['content'];
                    }
                }
            }
            foreach($news_list as $k1=>$v1){
                $this->articleshow($v1['id'],$v1['datetime'],$v1,$news_list[$k1+1],$news_list[$k1-1]);
            }
			$page=$page+1;
			if(!is_array($val)){$page=0;unlink("../data/plus/news.cache.php");}
		}
		return $page;
	}
	function get_return($type,$value,$msg){
		$data['type']=$type;
		$data['value']=$value;
		$data['msg']=iconv("gbk","UTF-8",$msg);
		echo json_encode($data);die;
	}
	function makenewsclass($nid){
		include_once(PLUS_PATH."group.cache.php");
		if($group_type[$nid]){
			$nids = $group_type[$nid];
			$nids[] = $nid;
			$where = "`nid` IN (".@implode(',',$nids).")";
			
		}else{
			$where = "`nid`='".$nid."'";
			
		}
		$allpage=ceil($this->obj->DB_select_num("news_base",$where)/20);
		$this->articleclass($nid,"../news/".$nid."/"."index.html",'index');
		for($i=1;$i<=$allpage;$i++){
			if($allpage>=$i){
                $fw=$this->articleclass($nid,"../news/".$nid."/"."$i.html",$i);
			}
		}
	}
    function webindex($path){
        global $phpyun;
		if($this->config['sy_jobdir']!=""){
			$jobclassurl=$this->config['sy_weburl']."/job/?c=search&";
		}else{
			$jobclassurl=$this->config['sy_weburl']."/index.php?m=job&c=search&";
		}
		global $ModuleName;
		$ModuleName = 'index';
		$this->yunset("jobclassurl",$jobclassurl);
		$this->yunset("ishtml",'1');
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
        $this->yunset($CacheList);
        $this->seo("index");
        $contect = $phpyun->fetch(TPL_PATH.$this->config['style'].'/index/index.htm','abc');

        $fp = fopen($path, "w");
        $fw=fwrite($fp, $contect);
        fclose($fp);
        return $fw;
    }
    function articleshow($id,$datetime,$news,$news_next,$news_last){
		
		$M=$this->MODEL('article');

		if(!empty($news_last)){
			if($this->config[sy_news_rewrite]=="2"){
				$news_last["url"]=$this->config['sy_weburl']."/news/".date("Ymd",$news_last["datetime"])."/".$news_last['id'].".html";
			}else{
				$news_last["url"]= Url('article',array('c'=>'show',"id"=>$news_last[id]),"1");
			}
		}
		if(!empty($news_next)){
			if($this->config[sy_news_rewrite]=="2"){
				$news_next["url"]=$this->config['sy_weburl']."/news/".date("Ymd",$news_next["datetime"])."/".$news_next['id'].".html";
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
							$about[$k]["url"]=$this->config['sy_weburl']."/news/".date("Ymd",$v["datetime"])."/".$v['id'].".html";
						}else{
							$about[$k]["url"]= Url("index",'news',array('c'=>'show',"id"=>$v[id]),"1");
						}

					}
				}
			}
		}
		$info=$news;
		$data['news_title']=$news['title'];
		$data['news_keyword']=$news['keyword'];
		$data['news_class']=$class['name'];
		$data['news_desc']=$this->GET_content_desc($news['description']);
		$this->data=$data;
		$info["news_class"]=$class['name'];
		$info["last"]=$news_last;
		$info["next"]=$news_next;
		$info["like"]=$about;
		$info['content']=htmlspecialchars_decode($info['content']);
		$this->yunset("Info",$info);

		$this->seo("news_article");
        global $phpyun;
		if(!is_dir(APP_PATH.'news/'.date('Ymd',$news['datetime']).'/'))@mkdir(APP_PATH.'news/'.date('Ymd',$news['datetime']).'/');
		@chmod(APP_PATH.'news/'.date('Ymd',$news['datetime']).'/',0777);
        $contect = $phpyun->fetch(TPL_PATH.$this->config['style'].'/article/show.htm',$id);
        $fp = fopen(APP_PATH.'news/'.date('Ymd',$news['datetime']).'/'.$id.'.html', "w");
        fwrite($fp, $contect);
        fclose($fp);
	}
    function descriptionshow($id,$path){
		
		$M=$this->MODEL('index');
		$row=$M->GetDescOne(array("id"=>$id));
		$top="";$footer="";
		if($row['top_tpl']==1){
            $top=APP_PATH."/app/template/".$this->config['style']."/header.htm";
		}else if($row['top_tpl']==3){
            $top=$row['top_tpl_dir'];
		}
		if($row['footer_tpl']==1){
            $footer=APP_PATH."/app/template/".$this->config['style']."/footer.htm";
		}else if($row['footer_tpl']==3){
            $footer=$row['footer_tpl_dir'];
		}
		$seo['title']=$row['title'];
		$seo['keywords']=$row['keyword'];
		$seo['description']=$row['descs'];
		$this->yunset("seo",$seo);
		$this->yunset("name",$row['name']);
		$this->yunset("content",$row['content']);
		$this->header_desc($row['title'],$row['keyword'],$row['descs']);
		$make=APP_PATH."/app/template/".$this->config['style']."/make.htm";
		$make_top=APP_PATH."/app/template/".$this->config['style']."/make_top.htm";

        global $phpyun;
        if($make_top){
            $contect = $phpyun->fetch($make_top,$id);
        }
        if($top){
            $contect .= $phpyun->fetch($top,$id);
        }
        if($make){
            $contect .= $phpyun->fetch($make,$id);
        }
        if($footer){
            $contect .= $phpyun->fetch($footer,$id);
        }
        $DirList=explode('/',$path);
        foreach($DirList as $k=>$v){
            $Dir.=$v.'/';
            if(!is_dir(APP_PATH.$Dir)&&!strstr($Dir,'.html')){
                mkdir(APP_PATH.$Dir,0777);
            }
        }
        $fp = fopen(APP_PATH.$path, "w");
        fwrite($fp, $contect);
        fclose($fp);
	}
  function articleindex($path){
		$this->seo("news");
		
		global $phpyun;
    $contect = $phpyun->fetch(APP_PATH."/app/template/".$this->config['style']."/article/index.htm");
    $path=$this->format_url($path);
    $DirList=explode('/',$path);
    foreach($DirList as $k=>$v){
      $Dir.=$v.'/';
      if(!is_dir(APP_PATH.$Dir)&&!strstr($Dir,'.html')){
        mkdir(APP_PATH.$Dir,0777);
      }
    }
    $fp = fopen(APP_PATH.$path, "w");
    $fw=fwrite($fp, $contect);
    fclose($fp);
    return $fw;
	}
  function articleclass($id,$path,$page){
    
    $_GET['nid']=$id;
    $_GET['page']=$page;
    $_GET['cache']='1';
    $M=$this->MODEL('article');
    $class=$M->GetNewsGroupOnce(array('id'=>(int)$_GET['nid']),array('field'=>"`name`"));
    $this->yunset("classname",$class['name']);
    $data['news_class']=$class['name'];
    $this->data=$data;
    $this->seo("newslist");
    global $phpyun;
    $contect = $phpyun->fetch(APP_PATH."/app/template/".$this->config['style']."/article/list.htm",'articleclass-nid'.$id.'-page'.$page);
    $path=$this->format_url($path);
    $DirList=explode('/',$path);
    foreach($DirList as $k=>$v){
      $Dir.=$v.'/';
      if(!is_dir(APP_PATH.$Dir)&&!strstr($Dir,'.html')){
        mkdir(APP_PATH.$Dir,0777);
      }
    }
    $fp = fopen(APP_PATH.$path, "w");
    $fw=fwrite($fp, $contect);
    fclose($fp);
    return $fw;
	}
  function articlelist($id,$path){
    
    $_GET['nid']=$id;
		$M=$this->MODEL('article');
    $group=$M->GetNewsGroupList(array('keyid'=>'0'),array('field'=>"`id`,`name`"));
    if(is_array($group)){
      foreach($group as $k=>$v){
        if($this->config[sy_news_rewrite]=="2"){
					$group[$k]['url']=$this->config['sy_weburl']."/news/".$v['id']."/";
				}else{
					$group[$k]['url']= Url("index",'news',array('c'=>'list',"id"=>$v[id]),"1");
				}
      }
    }
    $this->yunset("group",$group);
    $this->seo("newslist");
    global $phpyun;
    $contect = $phpyun->fetch(APP_PATH."/app/template/".$this->config['style']."/article/list.htm");
    $path=$this->format_url($path);
    $DirList=explode('/',$path);
    foreach($DirList as $k=>$v){
      $Dir.=$v.'/';
      if(!is_dir(APP_PATH.$Dir)&&!strstr($Dir,'.html')){
        mkdir(APP_PATH.$Dir,0777);
      }
    }
    $fp = fopen(APP_PATH.$path, "w");
    $fw=fwrite($fp, $contect);
    fclose($fp);
    return $fw;
	}
  function format_url($srcurl, $baseurl) {
    $SplitList=explode('/',$srcurl);
    foreach($SplitList as $v){
      switch($v){
        case '..':$URL.='';break;
        case '.':break;
        default:$URL.='/'.$v;break;
      }
    }
    return $URL;
       
    }
}
?>