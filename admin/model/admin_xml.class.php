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
class admin_xml_controller extends common{
	function index_action(){ 
		$this->yuntpl(array('admin/admin_xml'));
	}
	function archive_action(){

		if($_POST['limit']){
			
			$type=trim($_POST['type']);
			if($type=='ask'||$type=='sitemap'){
				if($_POST['order']=='uptime'){
					$order='lastupdate';
				}else{$order='add_time';}
				$rows['ask']=$this->obj->DB_select_all("question","1 order by ".$order." desc limit ".intval($_POST['limit']),"`id` as `id`,`".$order."` as `time`");
			}
			if($type=='news'||$type=='sitemap'){
				if($_POST['order']=='uptime'){
					$order='lastupdate';
				}else{$order='datetime';}
				$rows['news']=$this->obj->DB_select_all("news_base","1 order by ".$order." desc limit ".intval($_POST['limit']),"`id`,`".$order."` as `time`,`datetime`");
			}
			if($type=='company'||$type=='sitemap'){
				
				if($_POST['order']=='uptime'){
					$order='lastupdate';
				}else{$order='jobtime';}
				$rows['company']=$this->obj->DB_select_all("company","1 order by ".$order." desc limit ".intval($_POST['limit']),"`uid` as `id`,`".$order."` as `time`");
			}
			if($type=='job'||$type=='sitemap'){
				if($_POST['order']=='uptime'){
					$order='lastupdate';
				}else{$order='sdate';}
				$rows['job']=$this->obj->DB_select_all("company_job","`sdate`<'".time()."' and `edate`>'".time()."' and `state`='1' order by ".$order." desc limit ".intval($_POST['limit']),"`id`,`".$order."` as `time`");
			}
			if($type=='resume'||$type=='sitemap'){
				if($_POST['order']=='uptime'){
					$order='lastupdate';
				}else{$order='addtime';}
				$rows['resume']=$this->obj->DB_select_all("resume_expect","`status`<>'2' and `r_status`<>'2' and `job_classid`<>'' and `open`='1' ORDER BY `".$order."` desc limit ".intval($_POST['limit']),"`uid` as `id`,`".$order."` as `time`");
			}
			if(strpos(trim($_POST['name']),'.xml')==true){
				$_POST['name']=substr(trim($_POST['name']),0,strpos(trim($_POST['name']),'.xml'));
			}
			
			if($rows&&is_array($rows)){
				$show="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<urlset>\r\n"; 
				foreach($rows as $key=>$v){
					if($key=='ask'){
						foreach($v as $val){
							$url=Url('ask',array('c'=>'content','id'=>$val['id']));
							$url = str_replace("&","&amp;",$url);
							$show.="<url><loc>".$url."</loc><lastmod>".date("Y-m-d",$val['time'])."</lastmod><changefreq>".$_POST['frequency']."</changefreq></url>\r\n";
						}
					}
					if($key=='news'&&$this->config["sy_news_rewrite"]=='2'){
						foreach($v as $val){
							$url=$this->config['sy_weburl']."/news/".date("Ymd",$val["datetime"])."/".$val[id].".html";
							$show.="<url><loc>".$url."</loc><lastmod>".date("Y-m-d",$val['time'])."</lastmod><changefreq>".$_POST['frequency']."</changefreq></url>\r\n";
						}
					}
					if($key=='news'&&$this->config["sy_news_rewrite"]!='2'){
						foreach($v as $val){
							$url= Url("article",array("c"=>"show","id"=>$val[id]));
							$url = str_replace("&","&amp;",$url);
							$show.="<url><loc>".$url."</loc><lastmod>".date("Y-m-d",$val['time'])."</lastmod><changefreq>".$_POST['frequency']."</changefreq></url>\r\n";
						}
					}
					if($key=='company'){
						foreach($v as $val){
							$url= Url('company',array('c'=>'show',"id"=>$val['id']));
							$url = str_replace("&","&amp;",$url);
							$show.="<url><loc>".$url."</loc><lastmod>".date("Y-m-d",$val['time'])."</lastmod><changefreq>".$_POST['frequency']."</changefreq></url>\r\n";
						}
					}
					if($key=='job'){
						foreach($v as $val){
							$url= Url("job",array("c"=>"comapply","id"=>$val['id']));
							$url = str_replace("&","&amp;",$url);
							$show.="<url><loc>".$url."</loc><lastmod>".date("Y-m-d",$val['time'])."</lastmod><changefreq>".$_POST['frequency']."</changefreq></url>\r\n";
						}
					}
					if($key=='resume'){
						foreach($v as $val){
							$url=Url("resume",array("c"=>'show',"id"=>$val['id']));
							$url = str_replace("&","&amp;",$url);
							$show.="<url><loc>".$url."</loc><lastmod>".date("Y-m-d",$val['time'])."</lastmod><changefreq>".$_POST['frequency']."</changefreq></url>\r\n";
						}
					}
				}
				
				$show.="</urlset>";
				if(!$this->CheckRegUser($_POST['name'])){
					$this->layer_msg("XML名称包含特殊字符！",8,0,'index.php?m=admin_xml');
				}
				$path = APP_PATH."/".$_POST['name'].".xml";
				$fp = @fopen($path,"w");
				@fwrite($fp,$show);
				@fclose($fp);
				@chmod($path,0777);
				$this->layer_msg("生成成功！",9,0,'index.php?m=admin_xml');
			}else{
				$this->layer_msg("没有数据可以生成！",9,0,'index.php?m=admin_xml');
			}
		}
	}

}
?>