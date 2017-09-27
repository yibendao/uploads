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
 class cache{
	public $cachedir;
	public $obj;
	public function __construct($cachedir,$obj) {
		$this->cachedir = $cachedir;
		$this->obj=$obj;
	}
	public function city_cache($dir){
		$cityarr=$this->obj->DB_select_all("city_class","`display`='1' order by sort asc");

		if(is_array($cityarr)){
			foreach($cityarr as $v){
				if($v['keyid']==0){
					$city_index[]=$v['id'];
				}
				if($v['keyid']!=0){
					$city_type[$v['keyid']][]=$v['id'];
				}
				$cityname[$v['id']]=$v['name'];
			}
		}

        $this->made_web_js($this->cachedir.'city.cache.js',array('ci'=>$city_index,'ct'=>count($city_type)?$city_type:'new Array()','cn'=>$cityname));

		$data['city_index']=ArrayToString($city_index,false);

		$data['city_type']=ArrayToString($city_type);
		$data['city_name']=ArrayToString($cityname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function ask_cache($dir){
		$askarr=$this->obj->DB_select_all("q_class"," 1 order by sort asc");

		if(is_array($askarr)){
			foreach($askarr as $v){
				if($v['pid']==0){
					$ask_index[]=$v['id'];
				}
				if($v['pid']!=0){
					$ask_type[$v['pid']][]=$v['id'];
				}

				$askpic[$v['id']]=$v['pic'];
				$askintro[$v['id']]=$v['intro'];
				$askname[$v['id']]=$v['name'];
			}
		}
		$data['ask_index']=ArrayToString($ask_index,false);
		$data['ask_type']=ArrayToString($ask_type);
		$data['ask_pic']=ArrayToString($askpic);
		$data['ask_intro']=ArrayToString($askintro);
		$data['ask_name']=ArrayToString($askname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	function made_web_js($dir,$array,$preffix='o'){
		$content='';
		if(is_array($array)){
			foreach($array as $key=>$v){
                if(is_array($v)&&(!is_array(current($v)))){
                    $content.='var '.$key.'=new Array();'."\n";
					$content.=$this->made_js_string($v,$key,$preffix);
                }else if(is_array($v)){
                    $content.='var '.$key.'=new Array();'."\n";
					$content.=$this->made_js_string($v,$key,$preffix);
				}else{
					$v = str_replace("'","\\'",$v);
					$v = str_replace("\"","'",$v);
					$v = str_replace("\$","",$v);
					$content.="$key='".$v."';";
				}
				$content.=" \n";
			}
		}
        $fpindex=@fopen($dir,"w+");
        $fw=@fwrite($fpindex,$content);
        @fclose($fpindex);
        return $fw;
	}
    function made_js_string($array,$objkey='',$preffix='o'){
		$i = 0;$string='';
		foreach($array as $key=>$value){
			if(is_array($value)&&(!is_array(current($value)))){
                $ItemList=array();
                foreach($value as $v){
                    if(is_numeric($v)){
                        $ItemList[]=$v;
                    }else{
                        $ItemList[]='\''.$v.'\'';
                    }
                }
                if(count($ItemList)==1){
                    $ItemList[0]='\''.$ItemList[0].'\'';
                }
                $string.=$objkey.'['.(is_numeric($key)?$key:('\''.$key.'\''))."]=new Array(".implode(',',$ItemList).');'."\n";
			}else if(is_array($value)){
                $string.=$objkey.'.'.$preffix.$key."=new Array();\n";
                foreach($value as $k=>$v){
                    $ItemList[]=$objkey.'.'.$preffix.$key."=new Array();\n".$this->made_js_string($v,$objkey.".".$preffix.$k)."\n";
                }

			}else{
                if(is_numeric($value)){
                    $string.=$objkey.'['.(is_numeric($key)?$key:('\''.$key.'\''))."]=".$value.";\n";
                }else{
				    $string.=$objkey.'['.(is_numeric($key)?$key:('\''.$key.'\''))."]='".$value."';\n";
                }
			}
			$i++;
		}
		return $string;
	}
	public function cron_cache($dir){
		$rows=$this->obj->DB_select_all("cron","`display`='1' order by id asc");
		if(is_array($rows)){
			foreach($rows as $key=>$value){
				$cron_cache[$key]['id']=$value["id"];
				$cron_cache[$key]['dir']=$value["dir"];
				$cron_cache[$key]['type']=$value["type"];
				$cron_cache[$key]['week']=$value["week"];
				$cron_cache[$key]['month']=$value["month"];
				$cron_cache[$key]['hour']=$value["hour"];
				$cron_cache[$key]['minute']=$value["minute"];
				$cron_cache[$key]['nexttime']=$value["nexttime"];
			}
		}
		$data['cron']=ArrayToString($cron_cache);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function job_cache($dir){
		$rows=$this->obj->DB_select_all("job_class"," 1 order by sort asc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v['keyid']==0){
					$job_index[]=$v['id'];
				}
				if($v['keyid']!=0){
					$jobtype[$v['keyid']][]=$v['id'];
				}
				if($v['content']){
					$content[]=$v['id'];
				}
				$jobname[$v['id']]=$v['name'];
			}
		}
        $this->made_web_js($this->cachedir.'job.cache.js',array('content'=>$content,'ji'=>$job_index,'jt'=>count($jobtype)?$jobtype:'new Array()','jn'=>$jobname));
		$data['content']=ArrayToString($content,false);
		$data['job_index']=ArrayToString($job_index,false);
		$data['job_type']=ArrayToString($jobtype);
		$data['job_name']=ArrayToString($jobname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function industry_cache($dir){
		$rows=$this->obj->DB_select_all("industry","1 order by sort desc");
		if(is_array($rows)){
			foreach($rows as $v){
				$industry_index[]=$v['id'];
				$industryname[$v['id']]=$v['name'];
			}
		}
        $this->made_web_js($this->cachedir.'industry.cache.js',array('hi'=>$industry_index,'ht'=>count($industrytype)?$industrytype:'new Array()','hn'=>$industryname));

		$data['industry_index']=ArrayToString($industry_index,false);
		$data['industry_name']=ArrayToString($industryname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function subject_cache($dir){
		$rows=$this->obj->DB_select_all("px_subject_class","1 order by sort desc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v['keyid']==0){
					$subject_index[]=$v['id'];
				}
				if($v['keyid']!=0){
					$subjecttype[$v['keyid']][]=$v['id'];
				}
				$subjectname[$v['id']]=$v['name'];
			}
		}
		$data['subject_index']=ArrayToString($subject_index,false);
		$data['subject_type']=ArrayToString($subjecttype);
		$data['subject_name']=ArrayToString($subjectname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function circleclass_cache($dir){
		$rows=$this->obj->DB_select_all("circleclass","1 order by `sort` asc");
		$circle_type=$circle_name=array();
		if(is_array($rows)){
			foreach($rows as $v){
				if($v['threecityid']){
					$circle_type[$v['threecityid']][]=$v['id'];
				}else if($v['cityid']&&$v['threecityid']<1){
					$circle_type[$v['cityid']][]=$v['id'];
				}else if($v['provinceid']&&$v['cityid']<1){
					$circle_type[$v['provinceid']][]=$v['id'];
				} 
				$circle_name[$v['id']]=$v['name'];
			}
		}
		$data['circle_type']=ArrayToString($circle_type);
		$data['circle_name']=ArrayToString($circle_name);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function redeem_cache($dir){
		$rows=$this->obj->DB_select_all("redeem_class","1 order by sort desc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v['keyid']==0){
					$redeem_index[]=$v['id'];
				}
				if($v['keyid']!=0){
					$redeemtype[$v['keyid']][]=$v['id'];
				}
				$redeemname[$v['id']]=$v['name'];
			}
		}
		$data['redeem_index']=ArrayToString($redeem_index,false);
		$data['redeem_type']=ArrayToString($redeemtype);
		$data['redeem_name']=ArrayToString($redeemname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function subject_type_cache($dir){
		$rows=$this->obj->DB_select_all("px_subject_type","1 order by sort desc");
		if(is_array($rows)){
			foreach($rows as $v){
				$subject_type_index[]=$v['id'];
				$subject_type_name[$v['id']]=$v['name'];
			}
		}
		$data['subject_type_index']=ArrayToString($subject_type_index,false);
		$data['subject_type_name']=ArrayToString($subject_type_name);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function user_cache($dir){
		$rows=$this->obj->DB_select_all("userclass","1 order by sort asc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v['keyid']!=0){
					$com_index[$v["keyid"]][]=$v["id"];
				}
				$jobname[$v['id']]=$v['name'];
			}
			foreach($rows as $v){
				if($v['keyid']==0){
					$data2[$v['variable']]=$com_index[$v['id']];
				}
			}
		}
		$data['userdata']=ArrayToString($data2);
		$data['userclass_name']=ArrayToString($jobname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	
	public function com_cache($dir){
		$rows=$this->obj->DB_select_all("comclass","1 order by sort asc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v["keyid"]!=0){
					$com_index[$v["keyid"]][]=$v["id"];
				}
				$comname[$v['id']]=$v['name'];
			}
			foreach($rows as $v){
				if($v['keyid']==0){
					$data2[$v['variable']]=$com_index[$v['id']];
				}
			}
		}
		$data['comdata']=ArrayToString($data2);
		$data['comclass_name']=ArrayToString($comname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function part_cache($dir){
		$rows=$this->obj->DB_select_all("partclass","1 order by sort asc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v["keyid"]!=0){
					$com_index[$v["keyid"]][]=$v["id"];
				}
				$comname[$v['id']]=$v['name'];
			}
			foreach($rows as $v){
				if($v['keyid']==0){
					$data2[$v['variable']]=$com_index[$v['id']];
				}
			}
		}
		$data['partdata']=ArrayToString($data2);
		$data['partclass_name']=ArrayToString($comname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function menu_cache($dir){
		$rows=$this->obj->DB_select_all("navigation","display=1 order by sort asc");

		if(is_array($rows)){
			foreach($rows as $key=>$v){
				if(!is_array($com_index[$v["nid"]]))
					$a[$v["nid"]]=0;
					$com_index[$v["nid"]][$a[$v["nid"]]]['name']=$v['name'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['url']=$v['url'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['furl']=$v['furl'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['eject']=$v['eject'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['type']=$v['type'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['color']=$v['color'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['model']=$v['model'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['bold']=$v['bold'];
					$com_index[$v["nid"]][$a[$v["nid"]]]['sort']=$v['sort'];
					$a[$v["nid"]]++;
			}
		}
		$data['menu_name']=ArrayToString($com_index,true,true);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function navmap_cache($dir){
		$rows=$this->obj->DB_select_all("navmap","`display`='1' order by `sort` desc");
		if(is_array($rows)){
			foreach($rows as $key=>$v){
				$navmap[$v['nid']][$key]['id']=$v['id'];
				$navmap[$v['nid']][$key]['name']=$v['name'];
				$navmap[$v['nid']][$key]['url']=$v['url'];
				$navmap[$v['nid']][$key]['furl']=$v['furl'];
				$navmap[$v['nid']][$key]['eject']=$v['eject'];
				$navmap[$v['nid']][$key]['type']=$v['type'];
			}
		}
		$data['navmap']=ArrayToString($navmap);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function seo_cache($dir){
		$rows=$this->obj->DB_select_all("seo");
		if(is_array($rows)){
			foreach($rows as $key=>$v){
				$seo_index[$v["ident"]][$key]['title']=$v["title"];
				$seo_index[$v["ident"]][$key]['keywords']=$v["keywords"];
				$seo_index[$v["ident"]][$key]['description']=$v["description"];
				$seo_index[$v["ident"]][$key]['did']=$v["did"];
				$seo_index[$v["ident"]][$key]['php_url']=$v["php_url"];
				$seo_index[$v["ident"]][$key]['rewrite_url']=$v["rewrite_url"];
			}
		}
		$data['seo']=ArrayToString($seo_index);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function domain_cache($dir){
		$rows=$this->obj->DB_select_all("domain","`type`='1'");
		include(PLUS_PATH."/city.cache.php");
		include(PLUS_PATH."/industry.cache.php");
		if(is_array($rows)){
			foreach($rows as $key=>$value){
				if($value["three_cityid"]){
					$site_domain[$key]['cityname'] =$city_name[$value["three_cityid"]];
					$site_domain[$key]['three_cityid']=$value["three_cityid"];
				}elseif($value["cityid"]){
					$site_domain[$key]['cityname'] =$city_name[$value["cityid"]];
					$site_domain[$key]['cityid']=$value["cityid"];
				}else{
					$site_domain[$key]['cityname'] =$city_name[$value["province"]];
					$site_domain[$key]['province']=$value["province"];
				}

				$hyname =$industry_name[$value["hy"]];
				$site_domain[$key]['id']=$value["id"];
				$site_domain[$key]['webname']=$value["title"];
				$site_domain[$key]['host']=$value["domain"];
				$site_domain[$key]['hy']=$value["hy"];
				$site_domain[$key]['type']=$value["type"];
				$site_domain[$key]['tpl']=$value["tpl"];
				$site_domain[$key]['hyname']=$hyname;
				$site_domain[$key]['style']=$value["style"];
				$site_domain[$key]['fz_type']=$value["fz_type"];
				$site_domain[$key]['webtitle']=$value["webtitle"];
				$site_domain[$key]['webkeyword']=$value["webkeyword"];
				$site_domain[$key]['webmeta']=$value["webmeta"];
				$site_domain[$key]['weblogo']=$value["weblogo"];
			}
		}
		$data['site_domain']=ArrayToString($site_domain);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function company_cache($dir){
		$rows=$this->obj->DB_select_all("company","1");
		if(is_array($rows)){
			foreach($rows as $v){
				$comname[$v['uid']]=$v['name'];
			}
		}
		$data['company_name']=ArrayToString($comname);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function keyword_cache($dir){
		$rows=$this->obj->DB_select_all("hot_key","`check`='1' ORDER BY `num` DESC");

		if(is_array($rows)){
			foreach($rows as $key=>$value){
				$row[$key]['id']=$value["id"];
				$row[$key]['key_name']=$value["key_name"];
				$row[$key]['num']=$value["num"];
				$row[$key]['type']=$value["type"];
				$row[$key]['size']=$value["size"];
				$row[$key]['color']="#".$value["color"];
				$row[$key]['bold']=$value["bold"];
				$row[$key]['tuijian']=$value["tuijian"];
			}
		}
		$data['keyword']=ArrayToString($row);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function link_cache($dir){
		$rows=$this->obj->DB_select_all("admin_link","`link_state`='1' ORDER BY `link_sorting` DESC");
		if(is_array($rows)){
			foreach($rows as $key=>$value){
				$row[$key]['id']=$value["id"];
				$row[$key]['link_name']=$value["link_name"];
				$row[$key]['link_url']=$value["link_url"];
				$row[$key]['img_type']=$value["img_type"];
				$row[$key]['pic']=$value["pic"];
				$row[$key]['link_type']=$value["link_type"];
				$row[$key]['did']=$value["did"];
				$row[$key]['tem_type']=$value["tem_type"];
			}
		}
		$data['link']=ArrayToString($row);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function comrating_cache($dir){
		$rows=$this->obj->DB_select_all("company_rating","1");
		if(is_array($rows)){
			foreach($rows as $key=>$value){
				$row[$key]['id']=$value["id"];
				$row[$key]['display']=$value["display"];
				$row[$key]['name']=$value["name"];
				$row[$key]['com_pic']=$value["com_pic"];
				$row[$key]['jobrec']=$value["jobrec"];
				$row[$key]['category']=$value["category"];
				$row[$key]['service_discount']=$value["service_discount"];
				if($value["com_color"]){
					$row[$key]['com_color']="#".str_replace("#","",$value["com_color"]);
				}else{
					$row[$key]['com_color']='';
				}
			}
		}
		$data['comrat']=ArrayToString($row);
		return made_web_array($this->cachedir.$dir,$data);
	}
    public function reason_cache($dir){
		$rows=$this->obj->DB_select_all("reason","1 ORDER BY `id` DESC");

		$data['reason']=ArrayToString($rows);
		return made_web_array($this->cachedir.$dir,$data);
	}
    public function database_cache($dir){
		global $db;
    	$query=$db->query("show TABLES;");
    	while($row=$db->fetch_array($query)){$TableList[]=$row;}
    	foreach($TableList as $k=>$v){
    		$query=$db->query("desc `".$v[0]."`;");

            while($row=$db->fetch_array($query)){$TableStructList[$v[0]][]=$row;}
            $TableStructListNew=array();
            foreach($TableStructList[$v[0]] as $key=>$val){
                $TableStructListNew[$val['Field']]=$val['Type'];
            }
            $data[$v[0]]=ArrayToString($TableStructListNew,true,true);
        }
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function group_cache($dir){
		$rows=$this->obj->DB_select_all("news_group","1 order by sort asc");
		if(is_array($rows)){
			foreach($rows as $v){
				if($v['keyid']==0){
					$group_index[]=$v['id'];
				}
				if($v['keyid']!=0){
					$grouptype[$v['keyid']][]=$v['id'];
				}
				if($v['rec']=='1'){
					$group_rec[]=$v['id'];
				}
				if($v['rec_news']=='1'){
					$group_recnews[]=$v['id'];
				}
				$groupname[$v['id']]=$v['name'];
			}
		}
		if(!empty($group_rec)){
			$data['group_rec']=ArrayToString($group_rec,false);
		}
		if(!empty($group_recnews)){
			$data['group_recnews']=ArrayToString($group_recnews,false);
		}
		if(!empty($group_index)){
			$data['group_index']=ArrayToString($group_index,false);
		}
		if(!empty($grouptype)){
			$data['group_type']=ArrayToString($grouptype);
		}
		if(!empty($groupname)){
			$data['group_name']=ArrayToString($groupname);
		}
		return made_web_array($this->cachedir.$dir,$data);
	}
    public function desc_cache($dir){
		$DescClassList=$this->obj->DB_select_all('desc_class','1 order by sort asc');
		$DescList=$this->obj->DB_select_all('description','1 AND `is_nav`=1 order by sort asc','`id`,`nid`,`name`,`url`,`title`,`is_type`');
        foreach($DescList as $k=>$v){
            foreach($DescClassList as $k=>$val){
                if($v['nid']==$val['id']){
                    $DescList[$k]['classname']=$val['name'];
                }
            }
        }
        $data['desc_class']=ArrayToString($DescClassList,true,true);
        $data['desc_list']=ArrayToString($DescList,true,true);
		return made_web_array($this->cachedir.$dir,$data);
	}
	public function emailconfig_cache($dir){
		$rows=$this->obj->DB_select_all("admin_email");
		if(is_array($rows)){
			foreach($rows as $key=>$value){
				if($value["smtpserver"] && $value["smtpuser"] && $value["smtppass"] && $value["default"]=='1'){

					$row[$key]['id']=$value["id"];
					$row[$key]['smtpserver']=$value["smtpserver"];
					$row[$key]['smtpuser']=$value["smtpuser"];
					$row[$key]['smtppass']=$value["smtppass"];
					$row[$key]['smtpport']=$value["smtpport"];
					$row[$key]['smtpnick']=$value["smtpnick"];
				}
				
			}
		}
		if(empty($row)){
			$row = array();
			$setVal = '0';
		}else{
			$setVal = '1';
		}
		$config=$this->obj->DB_select_num("admin_config","`name`='sy_email_set'");
		if($config==false)
		{
			$this->obj->DB_insert_once("admin_config","`name`='sy_email_set',`config`='".$setVal."'");
		}else{
			$this->obj->DB_update_all("admin_config","`config`='".$setVal."'","`name`='sy_email_set'");
		}
		$config=$this->obj->DB_select_all('admin_config');
		if(is_array($config)){
			foreach($config as $v){
				$configarr[$v['name']]=$v['config'];
			}
		}
		made_web(PLUS_PATH.'config.php',ArrayToString($configarr),'config');


		$data['emailconfig']=ArrayToString($row);
		return made_web_array($this->cachedir.$dir,$data);
	}
 }
?>