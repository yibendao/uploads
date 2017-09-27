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
class admin_news_controller extends common{

	function set_search(){
		$cate=$this->obj->DB_select_all("news_group","1","`id`,`name`,`keyid`");
		if(!empty($cate)){
			foreach($cate as  $k=>$v){
        if($v['keyid']==0){
         $newsarr[$v['id']]=$v['name']; 
        }else{
          if($_GET['cate']){
            $cat=$this->obj->DB_select_all("news_group","`keyid`='".$_GET['cate']."'","`id`,`name`,`keyid`");
            if(is_array($cat)){
              foreach($cat as $va){
                 $newsarrs[$va['id']]=$va['name'];
               }
            }    
          }else{
            $newsarrs[$v['id']]=$v['name'];
          } 
        }     
			}
		}
		if($_GET['cate']){
			foreach($cate as $val){
				if($_GET['cate']==$val['id']){
					$this->yunset("cateinfo", $val);
				}
			}
		}
		
		$this->yunset("cate", $cate);
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"publish","name"=>'发布时间',"value"=>$lo_time);
		$search_list[]=array("param"=>"cate","name"=>'新闻类别',"value"=>$newsarr);
		if($newsarrs && $_GET['cate']){
			$search_list[]=array("param"=>"cates","name"=>'新闻子类',"value"=>$newsarrs);
		}
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
        $where="1";
		if ($_GET['cate']!=''){
        $cates=$this->obj->DB_select_all("news_group","`keyid`='".$_GET['cate']."'","`id`,`name`,`keyid`");
        if(is_array($cates)){
           foreach($cates as $val){
              $ids[]=$val['id'];
            }
         }
         $ids[].=$_GET['cate'];
			$where.=" and nid in(".@implode(",",$ids).")";
			$urlarr['cate']=$_GET['cate'];
		}
        if ($_GET['cates']!=''){     
            $where.=" and `nid`='".$_GET['cates']."'";
			$urlarr['cates']=$_GET['cates'];
		}
		if($_GET['adtime']){
			if($_GET['adtime']=='1'){
				$where .=" and `datetime`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `datetime`>'".strtotime('-'.intval($_GET['adtime']).' day')."'";
			}
			$urlarr['adtime']=$_GET['adtime'];
		}
		if($_GET['publish']){
			if($_GET['publish']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['publish'].'day')."'";
			}
			$urlarr['publish']=$_GET['publish'];
		}
		if($_GET['news_search']){
			if ($_GET['type']=='1'){
				$where.=" and `title` like '%".trim($_GET['keyword'])."%'";
			}elseif ($_GET['type']=='2'){
				$where.=" and `author` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['news_search']=$_GET['news_search'];
		}

		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$adminnews=$this->get_page("news_base",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($adminnews)){
			foreach($adminnews as $v){
				$classid[]=$v['nid'];
			}
		}
		if(is_array($classid)){
			$group=$this->obj->DB_select_all("news_group","id in (".@implode(",",$classid).")");
		}
		$property=$this->obj->DB_select_all("property");
		if(is_array($group)){
			foreach($adminnews as $k=>$v){
				$adminnews[$k]['url']=Url('article',array('c'=>'show','id'=>$v['id']));
                $adminnews[$k]['classurl']=Url('article',array('c'=>'list','nid'=>$v['nid']));
				$adminnews[$k]['title']=mb_substr($v['title'],0,20,"GBK");
				foreach($group as $key=>$value){
					if($value['id']==$v['nid']){
						$adminnews[$k]['name']=$value['name'];
					}
				}
				if($v['newsphoto']!=""){
					$type.=" 图";
				}
				if($v['describe']!=""){
					$describe=@explode(",",$v['describe']);
					foreach($property as $val){
						if(in_array($val['value'],$describe)){
							$ms=mb_substr($val['name'],0,1,"GBK");
							$type.=" ".$ms;
						}
					}
				}
				if($type!=""){
					$adminnews[$k]['titype']="[<font color='red'>".$type."</font> ]";
				}
				$type=$describe="";
				if($value['did']<1){
				    $adminnews[$key]['did'] = 0;
				}
			}
		}
		

		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);

		$news_group=$this->obj->DB_select_all("news_group");
		$a=0;$b=0;
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
		            $b++;
		        }
		    }
		}
		$this->yunset("one_class",$one_class);
		$this->yunset("two_class",$two_class);

        $this->yunset("get_type", $_GET);
		$this->yunset("adminnews",$adminnews);
		$this->yunset("property",$property);
		$this->yunset("propertys",$property);
		$this->yuntpl(array('admin/admin_news_list'));
	}
	function property_action(){
		if(!$_POST['id']){
			$nbid=$this->obj->DB_insert_once("property","`name`='".$_POST['name']."',`value`='".$_POST['value']."'");
			isset($nbid)?$this->ACT_layer_msg( "新闻属性(ID:".$nbid.")添加成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg( "添加失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$nbid=$this->obj->DB_update_all("property","`name`='".$_POST['name']."',`value`='".$_POST['value']."'","`id`='".$_POST['id']."'");
			isset($nbid)?$this->ACT_layer_msg( "新闻属性(ID:".$_POST['id'].")更新成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg( "更新失败！",8);
		}
	}
	function savepro_action(){
		if($_POST['type']=="add"){
			$describe=@implode(",",$_POST['describe']);

			$row=$this->obj->DB_select_all("news_base","`id` in (".$_POST['proid'].")");
			foreach($row as $k=>$v){
				if($v['describe']==""){
					$this->obj->DB_update_all("news_base","`describe`='".$describe."'","`id`='".$v['id']."'");
				}else{
					$describes = @explode(',',$v['describe']);

					foreach($_POST['describe'] as $key=>$value){

						if(!in_array($value,$describes))
						{

							$describes[] = $value;
						}
					}
					$this->obj->DB_update_all("news_base","`describe`='".@implode(',',$describes)."'","`id`='".$v['id']."'");
				}
			}
			$this->ACT_layer_msg("新闻(ID:".$_POST['proid'].")设置属性成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		if($_POST['type']=="del" && $_POST['proid']){
			if($_POST['describe']){
				$list = $this->obj->DB_select_all("news_base","`id` in(".$_POST['proid'].") AND `describe`<>''","`id`,`describe`");
				if(is_array($list)){
					foreach($list as $key=>$value){

						if($value['describe']){
							$describe = @explode(',',$value['describe']);

							foreach($describe as $key=>$v){

								if(in_array($v,$_POST['describe'])){
									unset($describe[$key]);
								}
							}
							$this->obj->DB_update_all("news_base","`describe`='".@implode(',',$describe)."'","`id`='".$value['id']."'");
						}
					}
				}
			}

			$this->ACT_layer_msg("新闻(ID:".$_POST['proid'].")删除属性成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
	}
	function delpro_action(){
		$this->check_token();
		if($_GET['id']){
			$this->obj->DB_delete_all("property","`id`='".(int)$_GET['id']."'");
			$this->layer_msg("新闻属性(ID:".$_POST['id'].")删除成功",9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function news_action(){
		if($_GET[nid]){
			$news[nid]=$_GET[nid];
			$this->yunset("news",$news[nid]);
		}
		$news_group=$this->obj->DB_select_all("news_group");
		$a=0;$b=0;
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
					$b++;
				}
			}
		}
        $this->yunset("one_class",$one_class);
	    $this->yunset("two_class",$two_class);
		$property=$this->obj->DB_select_all("property");
		$this->yunset("property",$property);

		include PLUS_PATH."/domain_cache.php";
		$Dname[0] = '总站';
		if(is_array($site_domain)){
			foreach($site_domain as $key=>$value){
				$Dname[$value['id']]  =  $value['webname'];
			}
		}
		$this->yunset("Dname", $Dname);
		
		if($_GET['id']){
			$info = $this->obj->DB_select_once("news_base","`id`='".$_GET['id']."'");
			$row = $this->obj->DB_select_once("news_content","`nbid`='".$_GET['id']."'");
			$info['content']=str_replace("&","&amp;",$row['content']);
			$describe=@explode(',',$info['describe']);
			$this->yunset("describe",$describe);
			$this->yunset("info",$info);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
		}else{
			$info['sort']=rand(1, 300 );
			$this->yunset("info",$info);
		}
		$this->yuntpl(array('admin/admin_news_add'));
	}
	function addnews_action(){
		if($_POST['updatenews']){
			$news_base=$this->obj->DB_select_once('news_base',"`id`='".$_POST['id']."'","`newsphoto`,`s_thumb`,`datetime`");
			if($_POST['uplocadpic']){
				if($news_base['s_thumb']!=$_POST['uplocadpic']){
					if($news_base['s_thumb']){
						unlink_pic('../'.$news_base['s_thumb']);
						unlink_pic('../'.$news_base['newsphoto']);
					}
					$upload=$this->upload_pic("../data/upload/news/");
					if(file_exists('..'.$_POST['uplocadpic'])){
						$uplocadpic=$upload->picture('..'.$_POST['uplocadpic'],false,1);
 						$s_thumb=$upload->news_makeThumb($uplocadpic,120,120,'_S_');
						$value.="`newsphoto`='" . str_replace("../data/upload/new","data/upload/new",$uplocadpic) . "',";
						$value.="`s_thumb`='" . str_replace("../data/upload/new","data/upload/new",$s_thumb) . "',";
					}else{
						$s_thumb=$upload->news_makeThumb('..'.$_POST['uplocadpic'],120,120,'_S_');
						$value.="`newsphoto`='" . str_replace("/config/","config/",$_POST['uplocadpic']) . "',";
						$value.="`s_thumb`='" . str_replace("../config/","config/",$s_thumb) . "',";
					}
				}
				unlink_pic('..'.$_POST['uplocadpic']);
			}
			$content = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',""),html_entity_decode($_POST["content"],ENT_QUOTES,"GB2312"));

			$str1 = preg_replace("/<a[^>]*><span[^>]*>/","", $content);
			$content = preg_replace("/<\/span><\/a>/","", $str1);
			
			$keyname=$this->obj->DB_select_all('hot_key',"`type`=3 and `check`=1","key_name");
			if($keyname){
				foreach($keyname as $val){
					$keynamearr[]=$val['key_name'];
					$href[]='<a href="'.searchListRewrite(array('type'=>'keyword','v'=>$val['key_name'])).'"target="_bank"><span style="color:#E53333;">'.$val['key_name'].'</span></a>';
				}
			}
			$content=str_replace($keynamearr,$href,$content); 
			$describe = @implode(",",$_POST['describe']);
			$time = time();
			if(empty($_POST['did'])){
				$_POST['did']=0;
			}
			$value.="`did`='".$_POST['did']."',";
			$value.="`color`='".$_POST['color']."',";
			$value.="`sort`='".$_POST['sort']."',";
			$value.="`nid`='".$_POST['nid']."',";
			$value.="`author`='".$_POST['author']."',";
			$value.="`source`='".$_POST['source']."',";
			$value.="`title`='".$_POST['title']."',";
			$value.="`describe`='".$describe."',";
			$value.="`lastupdate`='".$time."',";
			if(!$_POST['keyword']){
				require(LIB_PATH."lib_splitword_class.php");
				$sp = new SplitWord();
				$keywordarr=$sp->getkeyword(strip_tags($content));
				$value.="`keyword`='".@implode(",",$keywordarr)."',";
			}else{
				$value.="`keyword`='".$_POST['keyword']."',";
			}
			$value.="`description`='".$_POST['description']."'";
			$nbid=$this->obj->DB_update_all("news_base",$value,"`id`='".$_POST['id']."'");

			$row=$this->obj->DB_select_once('news_content',"`nbid`='".$_POST['id']."'","nbid");
			if(is_array($row)){
				$cont = $this->obj->DB_update_all("news_content", "`content`='".$content."'","`nbid`='".$_POST['id']."'");
			}else{
				$cont = $this->obj->DB_insert_once("news_content", "`nbid`='".$_POST['id']."',`content`='".$content."'");
			}
			$this->autohtml($_POST['id'],$news_base['datetime']);
			isset($nbid)?$this->ACT_layer_msg( "新闻(ID:".$_POST['id'].")更新成功！",9,Url('admin_news',null,'admin'),2,1):$this->ACT_layer_msg( "更新失败！",8,Url('admin_news',null,'admin'));
		}
	    if($_POST['newsadd']){
			if($_POST['uplocadpic']){
				$upload=$this->upload_pic("../data/upload/news/");
				if(file_exists('..'.$_POST['uplocadpic'])){
					$uplocadpic=$upload->picture('..'.$_POST['uplocadpic'],false,1);
 					$s_thumb=$upload->news_makeThumb($uplocadpic,120,120,'_S_');
					$value.="`newsphoto`='" . str_replace("../data/upload/new","data/upload/new",$uplocadpic) . "',";
					$value.="`s_thumb`='" . str_replace("../data/upload/new","data/upload/new",$s_thumb) . "',";
				}else{
					$s_thumb=$upload->news_makeThumb('..'.$_POST['uplocadpic'],120,120,'_S_');
					$value.="`newsphoto`='" . str_replace("/config/","config/",$_POST['uplocadpic']) . "',";
					$value.="`s_thumb`='" . str_replace("../config/","config/",$s_thumb) . "',";
				}
				unlink_pic('..'.$_POST['uplocadpic']);
			}
			$content = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',""),html_entity_decode($_POST["content"],ENT_QUOTES,"GB2312"));
			$keyname=$this->obj->DB_select_all('hot_key',"`type`=3 and `check`=1","key_name");
			if($keyname){
				foreach($keyname as $val){
					$keynamearr[]=$val['key_name'];
					$href[]='<a href="'.searchListRewrite(array('type'=>'keyword','v'=>$val['key_name'])).'" target="_bank"><span style="color:#E53333;">'.$val['key_name'].'</span></a>';
				}
			}
			$content=str_replace($keynamearr,$href,$content); 
			$describe = @implode(",",$_POST['describe']);
			$time = time();
			if($_POST['sort']!=''){
				$value.="`sort`='".$_POST['sort']."',";
			}else{
				$value.="`sort`='0',";
			}
			if(empty($_POST['did']))
			{
				$_POST['did']=0;
			}
			$value.="`did`='".$_POST['did']."',";
			$value.="`color`='".$_POST['color']."',";
			$value.="`nid`='".$_POST['nid']."',";
			$value.="`author`='".$_POST['author']."',";
			$value.="`source`='".$_POST['source']."',";
			$value.="`title`='".$_POST['title']."',";
			$value.="`datetime`='".$time."',";
			$value.="`lastupdate`='".$time."',";
			$value.="`describe`='".$describe."',";

			if(!$_POST["keyword"]){
				require(LIB_PATH."lib_splitword_class.php");
				$sp = new SplitWord();
				$keywordarr=$sp->getkeyword(strip_tags($content));
				$value.="`keyword`='".@implode(",",$keywordarr)."',";
			}else{
				$value.="`keyword`='".$_POST['keyword']."',";
			}
			$value.="`description`='".$_POST["description"]."'";
			$nbid=$this->obj->DB_insert_once("news_base",$value);
			$cont = $this->obj->DB_insert_once("news_content", "`nbid`='$nbid',`content`='" .$content. "'");
			$this->autohtml($nbid,$time); 
			isset($cont)?$this->ACT_layer_msg( "新闻(ID:".$nbid.")添加成功！",9,Url('admin_news',null,'admin'),2,1):$this->ACT_layer_msg( "添加失败！",8,Url('admin_news',null,'admin'));
		}
	} 
	function group_action(){
		$news_group = $this->obj->DB_select_all("news_group","1 order by `id` desc");
		if(is_array($news_group)){
			foreach($news_group as $key=>$value){
				if($value['keyid']!=0){
					$rootid[$value['keyid']][] = $value['id'];
				}else{
					$rootid[$value['id']][] = $value['id'];
				}
			}
		}
		if(is_array($rootid)){
			foreach($rootid as $k=>$v){
				$root_arr = @implode(",",$v);
				$count = $this->obj->DB_select_num("news_base","`nid`='$k' or nid IN ($root_arr)");
				foreach($news_group as $key=>$value){
					if($value['id']==$k){
						$news_group[$key]['count'] = $count;
						$news_group[$key]['roots'] = count($v)-1;
						$news_group[$key]['url'] =Url($_GET['m'],array('cate'=>$value['id']),'admin');

					}
				}
			}
		}
	    $info=$this->obj->DB_select_once("news_group","`id`='".$_GET['id']."'");
      $info['url'] =Url($_GET['m'],array('cate'=>$_GET['id']),'admin');
      $list[]=$info['id'];
      $key=$this->obj->DB_select_all("news_group","`keyid`='".$_GET['id']."'","id");
      foreach($key as $k=>$v){
        $list[].=$v['id'];
      }
      $ids = @implode(",",$list);
			$cou = $this->obj->DB_select_num("news_base","`nid`='".$_GET['id']."' or nid IN ($ids)");
      $roo = $this->obj->DB_select_num("news_group","`keyid`='".$_GET['id']."'");
	    $subclass=$this->obj->DB_select_all("news_group","`keyid`='".$_GET['id']."'");
      if(is_array($subclass)){
        foreach($subclass as $key=>$value){         
            $countid[]= $value['id'];
        }
      }
      if(is_array($countid)){
        foreach($countid as $v){
          $counts = $this->obj->DB_select_num("news_base","`nid`='".$v."'");
          foreach($subclass as $key=>$value){         
            if($value['id']==$v){
              $subclass[$key]['counts'] = $counts;
              $subclass[$key]['url'] =Url($_GET['m'],array('cates'=>$value['id']),'admin');
            }
          }
        }
      }
	    $news=$this->obj->DB_select_all("news_group","keyid!=0");
        $this->yunset("info",$info);
        $this->yunset("cou",$cou);
        $this->yunset("roo",$roo);
        $this->yunset("news_group",$news_group);
        $this->yunset("subclass",$subclass);

        $news_group=$this->obj->DB_select_all("news_group");
        $a=0;
        if(is_array($news_group)){
            foreach($news_group as $key=>$v){
                if($v['keyid']==0){
                    $one_class[$a]['id']=$v['id'];
                    $one_class[$a]['name']=$v['name'];
                    $a++;
                }
            }
        }
        $this->yunset("one_class",$one_class);

		$type=$this->obj->DB_select_all("navigation_type");
		$this->yunset("type",$type);
		$this->yuntpl(array('admin/admin_news_group'));
	}
	function addgroup_action(){
	    $_POST=$this->post_trim($_POST);
	    $position=explode('-',$_POST['name']);
	    foreach ($position as $val){
	        $name[]=iconv('utf-8','gbk',$val);
	    }
	    $newsclass=$this->obj->DB_select_all("news_group","`name` in ('".implode("','", $name)."')");
	    if(empty($newsclass)){
	        $fid=intval($_POST['fid']);
	        $rec=intval($_POST['rec']);
	            foreach ($name as $key=>$val){
	                if($fid==0){
	                    $value="`name`='".$val."',`keyid`='".$fid."',`rec`='".$rec."'";
	                }else{
	                    $value="`name`='".$val."',`keyid`='".$fid."'";
	                }
	                $add=$this->obj->DB_insert_once("news_group",$value);
	            }   
	                
	        $this->get_cache();
	        $add?$msg=2:$msg=3;
	        $this->admin_log("新闻类别(ID:".$add.")添加成功");
	    }else{
	        $msg=1;
	    }
	    echo $msg;die;
	}
	function recommend_action(){
		$nid=$this->obj->DB_update_all("news_group","`".$_GET['type']."`='".$_GET['rec']."'","`id`='".$_GET['id']."' and `keyid`='0'");
		$this->get_cache();
		echo $nid?1:0;die;
	}
	function recnews_action(){
		$nid=$this->obj->DB_update_all("news_group","`".$_GET['type']."`='".$_GET['rec_news']."'","`id`='".$_GET['id']."' and `keyid`='0'");
		$this->get_cache();
		echo $nid?1:0;die;
	}
	function delnews_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
	    		$rows=$this->obj->DB_select_all("news_base","`id` in(".@implode(',',$del).")");
				foreach($rows as $v){
					unlink_pic('../'.$v['newsphoto']);
					unlink_pic('../'.$v['s_thumb']);
				}
				$this->obj->DB_delete_all("news_base","`id` in(".@implode(',',$del).")","");
				$this->obj->DB_delete_all("news_content","`nbid` in(".@implode(',',$del).")","");
 				$this->layer_msg('新闻(ID:'.@implode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的新闻！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
	   		 $info=$this->obj->DB_select_once("news_base",$where);
			if($info['newsphoto']){
				unlink_pic('../'.$info['newsphoto']);
				unlink_pic('../'.$info['s_thumb']);
			}
			$result=$this->obj->DB_delete_all("news_base", $where);
			$nid=$this->obj->DB_delete_all("news_content","`nbid`='".$_GET['id']."'");
			isset($nid)?$this->layer_msg('新闻(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}

	function delgroup_action(){
		$this->check_token();
	   if(isset($_GET['id'])){
			$result=$this->obj->DB_delete_all("news_group","`id`='".$_GET['id']."' or `keyid`='".$_GET['id']."'","");
			$this->get_cache();
			isset($result)?$this->layer_msg('新闻类别(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
	   }
	}
	function autohtml($id,$time){
        $this->articleshow($id);
	}
	function ajax_action(){
		if($_POST['sort']){
			$this->obj->DB_update_all("news_group","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->admin_log("新闻类别(ID:".$_POST['id'].")修改排序");
		}
		if($_POST['name']){
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("news_group","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$row=$this->obj->DB_select_once("news_group","`id`='".$_POST['id']."'");
			if($row['is_menu']=="1")
			{
				$this->obj->DB_update_all("navigation","`name`='".$_POST['name']."'","`news`='".$_POST['id']."'");
				$this->menu_cache_action();
			}
			$this->admin_log("新闻类别(ID:".$_POST['id'].")修改名称");
		}
		$this->get_cache();
		echo '1';die;
	}
	function make_cache_action(){
		$result=$this->get_cache();
		echo $result? 1:0;die;
	}
	function get_cache(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		return $makecache=$cacheclass->group_cache("group.cache.php");
	}
	function ajax_menu_action(){
		if($_POST['id']){
			$row=$this->obj->DB_select_once("news_group","`id`='".$_POST['id']."'");
			if($row['is_menu']=="1"){
				$info=$this->obj->DB_select_once("navigation","`news`='".$_POST['id']."'");
				$type=$this->obj->DB_select_once("navigation_type","`id`='".$info['nid']."'");
				$arr['id']=$info['id'];
				$arr['nid']=$info['nid'];
				$arr['name']=iconv("gbk","utf-8",$info['name']);
				$arr['typename']=iconv("gbk","utf-8",$type['typename']);
				$arr['color']=$info['color'];
				$arr['url']=$info['url'];
				$arr['furl']=$info['furl'];
				$arr['type']=$info['type'];
				$arr['sort']=$info['sort'];
				$arr['eject']=$info['eject'];
				$arr['model']=$info['model'];
				$arr['bold']=$info['bold'];
				$arr['display']=$info['display'];
			}else{
				$arr['name']=iconv("gbk","utf-8",$row['name']);
				$arr['url']="news/".$row['id']."/";
				$arr['furl']="article/c_list-nid_".$row['id'].".html";
			}
			echo urldecode(json_encode($arr));die;
		}
	}
	function set_menu_action(){
	    if($_POST['submit']){
	    	if($_POST['id']){
	    		$where=" and `id`<>'".$_POST['id']."'";
	    	}
	    	$row=$this->obj->DB_select_once("navigation","name='".$_POST['name']."' and `nid`='".$_POST['nid']."'".$where);
	    	if(!is_array($row)){
				$value.="`nid`='".$_POST['nid']."',";
				$value.="`eject`='".$_POST['eject']."',";
				$value.="`display`='".$_POST['display']."',";
				$value.="`name`='".$_POST['name']."',";
				$url = str_replace("amp;","",$_POST['url']);
				$value.="`url`='".$url."',";
				$value.="`furl`='".$_POST['furl']."',";
				$value.="`sort`='".$_POST['sort']."',";
				$value.="`color`='".$_POST['color']."',";
				$value.="`model`='".$_POST['model']."',";
				$value.="`bold`='".$_POST['bold']."',";
				$value.="`type`='".$_POST['type']."'";
				if($_POST['id']){
					$nbid=$this->obj->DB_update_all("navigation",$value,"`id`='".$_POST['id']."'");
					$msg="新闻类别导航更新";
				}else{
					$value.=",`news`='".$_POST['did']."'";
					$nbid=$this->obj->DB_insert_once("navigation",$value);
					$this->obj->DB_update_all("news_group","`is_menu`='1'","`id`='".$_POST['did']."'");
					$msg="新闻类别导航添加";
				}
				$this->menu_cache_action();
				isset($nbid)?$this->ACT_layer_msg( $msg."成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg( $msg."失败！",8,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->ACT_layer_msg( "已经存在此导航！",8,$_SERVER['HTTP_REFERER']);
	    	}
		}
	}
	function delmenu_action(){
		if($_GET['id']){
			$this->check_token();
			$this->obj->DB_update_all("news_group","`is_menu`='0'","`id`='".$_GET['id']."'");
			$this->obj->DB_delete_all("navigation","`news`='".$_GET['id']."'");
			$this->menu_cache_action();
			$this->layer_msg("新闻类别导航(".$_GET['id'].")取消成功",9,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function menu_cache_action(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->menu_cache("menu.cache.php");
	}
    function articleshow($id){
		$M=$this->MODEL('article');
		$news=$M->GetNewsBaseOnce(array('id'=>$id));
		$row=$M->GetNewsContentOnce(array('nbid'=>$id));
		$news['content']=$row['content'];
		$news_last=$M->GetNewsBaseOnce(array("`id`<'".$id."'"),array('orderby'=>" `id` desc"));

		if(!empty($news_last)){
			if($this->config[sy_news_rewrite]=="2"){
				$news_last["url"]=$this->config['sy_weburl']."/news/".date("Ymd",$news_last["datetime"])."/".$news_last['id'].".html";
			}else{
				$news_last["url"]= Url("article",array('c'=>'show',"id"=>$news_last[id]),"1");
			}
		}
		$news_next=$M->GetNewsBaseOnce(array("`id`>'".$id."'"),array('orderby'=>" `id` desc"));
		if(!empty($news_next)){
			if($this->config[sy_news_rewrite]=="2"){
				$news_next["url"]=$this->config['sy_weburl']."/news/".date("Ymd",$news_next["datetime"])."/".$news_next['id'].".html";
			}else{
				$news_next["url"]= Url("article",array('c'=>'show',"id"=>$news_next[id]),"1");
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
							$about[$k]["url"]= Url("article",array('c'=>'show',"id"=>$v[id]),"1");
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
		$this->yunset("Info",$info);

		$this->seo("news_article");
        global $phpyun;
        
        $contect = $phpyun->fetch(TPL_PATH.'default/article/show.htm',$id);
        if (!file_exists(APP_PATH.'news/'.date("Ymd",$news["datetime"]))){
        	 mkdir (APP_PATH.'news/'.date("Ymd",$news["datetime"]));
        }
        $fp = fopen(APP_PATH.'news/'.date("Ymd",$news["datetime"]).'/'.$id.'.html', "w");
        fwrite($fp, $contect);
        fclose($fp);
	}

	function checksitedid_action(){
		if($_POST['uid']){
			$uids=@explode(',',$_POST['uid']);
			$uid = pylode(',',$uids);
			if($uid){
				$siteDomain = $this->MODEL('site');
				$siteDomain->UpDid(array('news_base'),$_POST['did'],"`id` IN (".$uid.")");
				$siteDomain->UpDid(array('news_content'),$_POST['did'],"`nbid` IN (".$uid.")");
				$this->ACT_layer_msg( "新闻(ID:".$_POST['uid'].")分配站点成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("请正确选择需分配新闻！",8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg( "参数不全请重试！",8,$_SERVER['HTTP_REFERER']);
		}
	}

	function selclass_action(){
	    $_POST=$this->post_trim($_POST);
	    if($_POST['keyword']){
    		$keyword=iconv("utf-8","gbk",trim($_POST['keyword']));
    		$NewsM = $this->MODEL('article');
    		$group=$NewsM->GetNewsGroupList(array('`name` LIKE \'%'.$keyword.'%\''),array('field'=>'id,name,keyid'));
    		if(is_array($group) && !empty($group)){
    		    foreach($group as $value){
    		        if($value['keyid']==0){
						$html .='<div class="yun_admin_select_box_list"> <a href="javascript:;" onclick="select_new(\'nid\',\''.$value['id'].'\',\''.$value['name'].'\')">'.$value['name'].'</a> </div>';
    		        }else{
						$html .='<div class="yun_admin_select_box_list"> <a href="javascript:;" onclick="select_new(\'nid\',\''.$value['id'].'\',\''.$value['name'].'\')"> 　┗'.$value['name'].'</a> </div>';
    		        }
    		        
    		    }
    		}else{
    		   $html .='<div class="yun_admin_select_box_list"> <a href="javascript:;">未找到相关数据</a> </div>';
    		}
    		echo  $html;
	    }
	}

	function fatherclass_action(){
	    $_POST=$this->post_trim($_POST);
	    if($_POST['keyword']){
	        $keyword=iconv("utf-8","gbk",trim($_POST['keyword']));
	        $NewsM = $this->MODEL('article');
	        $group=$NewsM->GetNewsGroupList(array('`name` LIKE \'%'.$keyword.'%\'','keyid'=>0),array('field'=>'id,name,keyid'));
	        if(is_array($group) && !empty($group)){
	            foreach($group as $value){
	              $html .='<option value="'.$value['id'].'">'.$value['name'].'</option>';
	            }
	        }else{
	            $html .='<option value="0">未查询到相关数据</option>';
	        }
	        echo  $html;
	    }
	}
	
	function changeClass_action(){
	    $_POST=$this->post_trim($_POST);
	    if($_POST['id']){
	        $ids=@explode(',',$_POST['id']);
	        $id = pylode(',',$ids);
	        $nid=intval($_POST['nid']);
	        if($id){
	            $NewsM = $this->MODEL('article');
	            $NewsM->UpdateNews(array('nid'=>$nid),array("`id` in (".$id.")"));
	            $this->ACT_layer_msg("新闻转移类别成功！",9,$_SERVER['HTTP_REFERER']);
	        }else{
	            $this->ACT_layer_msg("请正确选择需转移的新闻！",8,$_SERVER['HTTP_REFERER']);
	        }
	    }else{
	       $this->ACT_layer_msg( "参数不全请重试！",8,$_SERVER['HTTP_REFERER']);
	    }
	}
	function changeSon_action(){
	    $_POST=$this->post_trim($_POST);
	    if($_POST['id']){
	    	$ids=@explode(',',$_POST['id']);
	    	if($ids[0]==intval($_POST['fid'])){
	    	    array_shift($ids);
	    	}
	        $id = pylode(',',$ids);
	        $nid=intval($_POST['nid']);
	        if($id){
	            $NewsM = $this->MODEL('article');
	            $NewsM->UpdateNewsGroup(array('keyid'=>$nid),array('`id` in ('.$id.')'));
	            $this->get_cache();
	            $this->ACT_layer_msg('转移类别成功！',9,$_SERVER['HTTP_REFERER']);
	        }else{
	            $this->ACT_layer_msg("请正确选择需转移的类别！",8,$_SERVER['HTTP_REFERER']);
	        }
	    }else{
	       $this->ACT_layer_msg( "参数不全请重试！",8,$_SERVER['HTTP_REFERER']);
	    }
	}
}
?>