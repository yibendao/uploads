<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:45:07
         compiled from "D:\phpStudy\WWW\uploads\app\template\default\index\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:257559cdb3b3cbdbd6-51395295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60634e2ecbc49f11994dede30b513a3471e796c0' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\default\\index\\index.htm',
      1 => 1501490218,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '257559cdb3b3cbdbd6-51395295',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'style' => 0,
    'ishtml' => 0,
    'adlist_73' => 0,
    'adlist_72' => 0,
    'lunbo' => 0,
    'config' => 0,
    'alist' => 0,
    'keylist' => 0,
    'hotjoblist' => 0,
    'urgent_list' => 0,
    'adlist_13' => 0,
    'adlist_15' => 0,
    'rec_list' => 0,
    'new_list' => 0,
    'ulist' => 0,
    'pkey' => 0,
    'plist' => 0,
    'indexnews' => 0,
    'linklist' => 0,
    'linklist2' => 0,
    'footer_ad' => 0,
    'key' => 0,
    'left_ad' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdb3b429ad47_14394014',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdb3b429ad47_14394014')) {function content_59cdb3b429ad47_14394014($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_listurl')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.listurl.php';
if (!is_callable('smarty_function_formatpicurl')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.formatpicurl.php';
?><?php $alist=array();$time=time();eval('$paramer=array("limit"=>"2","item"=>"\'alist\'","t_len"=>"20","nocache"=>"")
;');
		global $db,$db_config,$config;
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where = 1;
		if($config['did']){
			$where.=" and `did`='".$config['did']."'";
		}else if($config['sy_web_site']=="1"){
			$where.=" and `did`='0'";
		}  
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"admin_announcement",$where,$Purl,"",0,$_smarty_tpl);
		}
		if($paramer[order]){
			$where.="  ORDER BY `".$paramer[order]."`";
		}else{
			$where.="  ORDER BY `datetime`";
		}
		if($paramer[sort]){
			$where.=" ".$paramer[sort];
		}else{
			$where.=" DESC";
		}

		$alist=$db->select_all("admin_announcement",$where.$limit);
		if(is_array($alist)){
			foreach($alist as $key=>$value){
				if($paramer[t_len]){
					$alist[$key][title_n] = mb_substr($value['title'],0,$paramer[t_len],"GBK");
				}
				$alist[$key][time]=date("Y-m-d",$value[datetime]);
				$alist[$key][url] = Url("announcement",array("id"=>$value[id]),"1");
			}
		} ?>
<?php global $db,$db_config,$config;
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		if($config[sy_web_site]=="1"){
			$jobwhere="";
			if($config[province]>0 && $config[province]!=""){
				$jobwhere.=" and `provinceid`='$config[province]'";
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$jobwhere.=" and `cityid`='$config[cityid]'";
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$jobwhere.=" and `three_cityid`='$config[three_cityid]'";
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$jobwhere.=" and `hy`='".$config[hyclass]."'";
			} 
			if($jobwhere){
				$comlist=$db->select_all("company","1 ".$jobwhere,"`uid`");
				if(is_array($comlist)){
					foreach($comlist as $v){
						$cuid[]=$v[uid];
					}
				}
				$hotwhere=" and `uid` in (".@implode(",",$cuid).")";
			} 
		}
		$time = time();
		$where = "`time_start`<$time AND `time_end`>$time".$hotwhere;$order = " ORDER BY `sort` ";$sort = 'ASC';$limit=" LIMIT 24";$where.=$order.$sort;
        $Query = $db->query("SELECT * FROM $db_config[def]hotjob where ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			$hotjoblist[] = $rs;
			$ListId[] =  $rs[uid];
		}

		$JobId = @implode(",",$ListId);
		$JobList=$db->select_all("company_job","`uid` IN ($JobId) and `edate`>'".mktime()."' and state=1 and r_status<>'2' and status<>'1' $jobwhere");
		$statis=$db->select_all("company_statis","`uid` IN ($JobId)","`uid`,`comtpl`");
		if(is_array($ListId)){
			$cache_array = $db->cacheget();
			foreach($hotjoblist as $key=>$value){
				$i=0;
				if(is_array($JobList)){
					$hotjoblist[$key]["job"].="<div class=\"area_left\"> ";
					foreach($JobList as $k=>$v){
						if($value[uid]==$v[uid] && $i<5){
							$job_url = Url("job",array("c"=>"comapply","id"=>"$v[id]"),"1");
							$v[name] = mb_substr($v[name],0,10,"GBK");
							$hotjoblist[$key]["job"].="<a href='".$job_url."'>".$v[name]."</a>";
							$i++;
						}
					}
					foreach($statis as $v){
						if($value['uid']==$v['uid']){
							if($v['comtpl'] && $v['comtpl']!="default"){
								$jobs_url = Url("company",array("c"=>"show","id"=>$value[uid]))."#job";
							}else{
								$jobs_url = Url("company",array("c"=>"show","id"=>$value[uid]));
							}
						}
					}
					$com_url = Url("company",array("c"=>"show","id"=>$value[uid]));
					$beizhu=mb_substr($value['beizhu'],0,50,"GBK")."...";
					$hotjoblist[$key]["job"].="</div><div class=\"area_right\"><a href='".$com_url."'>".$value["username"]."</a>".$beizhu."</div>";
					$hotjoblist[$key]["url"]=$com_url;
				}
			}
		} ?>
<?php global $db,$db_config,$config;
		$time = time();
		
		
        eval('$paramer=array("namelen"=>"30","comlen"=>"30","urgent"=>"\'1\'","limit"=>"12","item"=>"\'urgent_list\'","name"=>"\'urgent_list1\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		 
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `edate`>'$time' and `state`=1";
		}else{
			$where = "`state`=1 and `edate`>'$time'";
		}
        
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[rec]){
			include_once  PLUS_PATH."/comrating.cache.php";
			$recRating = array();
		
			if($comrat){
				foreach($comrat as $value){
					if($value[display]=='1' && $value[category]=='1' && $value[jobrec]=='2'){
						$recRating[] = $value['id'];
					}
				}
			}
			if(!empty($recRating)){
				$recRaringId = implode(',',$recRating);
				
				$where.=" AND (`rating` IN (".$recRaringId.") OR `rec_time`>=".time().")";

			}else{
				$where.=" AND `rec_time`>=".time();
			}
		}
		if($paramer['cert']){
			$job_uid=array();
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`<>2";
		}
		if($paramer[status]){
			$where.= " and `status`=1";
		}else{
			$where.= " and `status`<>1";
		}
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		} 
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		if($paramer[job1_son]){
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		if($paramer[job_post]){
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		if($paramer['jobids']){
			$where.= " AND (`job1` = $paramer[jobids] OR `job1_son`=$paramer[jobids] OR `job_post`=$paramer[jobids])";
		}
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		if($paramer[edu]){
			$where .= " AND `edu` = $paramer[edu]";
		}
		if($paramer[exp]){
			$where .= " AND `exp` = $paramer[exp]";
		}
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary])."))";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`>=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`!=0 and  `maxsalary`=0))";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).")
						or (`minsalary`<=".intval($paramer[maxsalary])." and maxsalary=0) 
						or (`minsalary`=0 and  `maxsalary`!=0)
						)";
		}
		if($paramer[cityin]){
			$where .= " AND (`provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
    			$where.=" AND lastupdate>$beginToday";
    		}else{
    			$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
    		}
		}
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		if($paramer[bid]){
			$where.="  and `xsdate`>'".time()."'";
		} 
		if($paramer[noids]==1 && !empty($noids)){
			$where.=" AND `id` NOT IN (".@implode(',',$noids).")";
		}
		if($paramer[where]){
			$where = $paramer[where];
		}

		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);
          
		} 
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;  
		 
		$urgent_list = $db->select_all("company_job",$where.$limit);
		if(is_array($urgent_list)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($urgent_list as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`,`logo`,`pr`,`hy`,`mun`");
				include  PLUS_PATH."/com.cache.php";
				include  PLUS_PATH."/industry.cache.php";
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value['logo']){
							$value['logo'] = $config['sy_weburl']."/".$value['logo'];
						}else{
							$value['logo'] = $config['sy_weburl']."/".$config['sy_unit_icon'];
						}
						
						$value['pr_n'] = $comclass_name[$value[pr]];
						$value['hy_n'] = $industry_name[$value[hy]];
						$value['mun_n'] = $comclass_name[$value[mun]];
						$r_uid[$value['uid']] = $value;
					}
				}
			}

			include_once  PLUS_PATH."/comrating.cache.php";
			include(CONFIG_PATH."db.data.php");
			$noids=array();
			foreach($urgent_list as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$urgent_list[$key] = $db->array_action($value,$cache_array);
				$urgent_list[$key][stime] = date("Y-m-d",$value[sdate]);
				$urgent_list[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$urgent_list[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$urgent_list[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);
				if($value[minsalary]&&$value[maxsalary]){
					$urgent_list[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
				}elseif($value[minsalary]){
					$urgent_list[$key][job_salary] =$value[minsalary]."以上";
				}else{
                    $urgent_list[$key][job_salary] ="面议";
                }
				
				$urgent_list[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
				$urgent_list[$key][logo] =$r_uid[$value['uid']][logo];
				$urgent_list[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$urgent_list[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$urgent_list[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				$time=$value['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$urgent_list[$key]['time'] ="一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$urgent_list[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$urgent_list[$key]['time'] = date("H:i",$value['lastupdate']);
					$urgent_list[$key]['redtime'] =1;
				}else{
					$urgent_list[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($urgent_list[$key]['welfare'])&&$urgent_list[$key]['welfare']){
					foreach($urgent_list[$key]['welfare'] as $val){
						$urgent_list[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$urgent_list[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$urgent_list[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$urgent_list[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$urgent_list[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$urgent_list[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$urgent_list[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$urgent_list[$key][color] = str_replace("#","",$v[com_color]);
						$urgent_list[$key][ratlogo] = $v[com_pic];
						$urgent_list[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$urgent_list[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$urgent_list[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$urgent_list[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$urgent_list[$key][name_n]);
					$urgent_list[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$urgent_list[$key][com_n]);
					$urgent_list[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$urgent_list[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
    			}
			}

			if(is_array($urgent_list)){
				if($paramer[keyword]!=""&&!empty($urgent_list)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php global $db,$db_config,$config;
		$time = time();
		
		
        eval('$paramer=array("namelen"=>"10","comlen"=>"14","rec"=>"\'1\'","limit"=>"20","item"=>"\'rec_list\'","name"=>"\'rec_list1\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		 
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `edate`>'$time' and `state`=1";
		}else{
			$where = "`state`=1 and `edate`>'$time'";
		}
        
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[rec]){
			include_once  PLUS_PATH."/comrating.cache.php";
			$recRating = array();
		
			if($comrat){
				foreach($comrat as $value){
					if($value[display]=='1' && $value[category]=='1' && $value[jobrec]=='2'){
						$recRating[] = $value['id'];
					}
				}
			}
			if(!empty($recRating)){
				$recRaringId = implode(',',$recRating);
				
				$where.=" AND (`rating` IN (".$recRaringId.") OR `rec_time`>=".time().")";

			}else{
				$where.=" AND `rec_time`>=".time();
			}
		}
		if($paramer['cert']){
			$job_uid=array();
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`<>2";
		}
		if($paramer[status]){
			$where.= " and `status`=1";
		}else{
			$where.= " and `status`<>1";
		}
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		} 
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		if($paramer[job1_son]){
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		if($paramer[job_post]){
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		if($paramer['jobids']){
			$where.= " AND (`job1` = $paramer[jobids] OR `job1_son`=$paramer[jobids] OR `job_post`=$paramer[jobids])";
		}
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		if($paramer[edu]){
			$where .= " AND `edu` = $paramer[edu]";
		}
		if($paramer[exp]){
			$where .= " AND `exp` = $paramer[exp]";
		}
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary])."))";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`>=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`!=0 and  `maxsalary`=0))";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).")
						or (`minsalary`<=".intval($paramer[maxsalary])." and maxsalary=0) 
						or (`minsalary`=0 and  `maxsalary`!=0)
						)";
		}
		if($paramer[cityin]){
			$where .= " AND (`provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
    			$where.=" AND lastupdate>$beginToday";
    		}else{
    			$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
    		}
		}
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		if($paramer[bid]){
			$where.="  and `xsdate`>'".time()."'";
		} 
		if($paramer[noids]==1 && !empty($noids)){
			$where.=" AND `id` NOT IN (".@implode(',',$noids).")";
		}
		if($paramer[where]){
			$where = $paramer[where];
		}

		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);
          
		} 
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;  
		 
		$rec_list = $db->select_all("company_job",$where.$limit);
		if(is_array($rec_list)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($rec_list as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`,`logo`,`pr`,`hy`,`mun`");
				include  PLUS_PATH."/com.cache.php";
				include  PLUS_PATH."/industry.cache.php";
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value['logo']){
							$value['logo'] = $config['sy_weburl']."/".$value['logo'];
						}else{
							$value['logo'] = $config['sy_weburl']."/".$config['sy_unit_icon'];
						}
						
						$value['pr_n'] = $comclass_name[$value[pr]];
						$value['hy_n'] = $industry_name[$value[hy]];
						$value['mun_n'] = $comclass_name[$value[mun]];
						$r_uid[$value['uid']] = $value;
					}
				}
			}

			include_once  PLUS_PATH."/comrating.cache.php";
			include(CONFIG_PATH."db.data.php");
			$noids=array();
			foreach($rec_list as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$rec_list[$key] = $db->array_action($value,$cache_array);
				$rec_list[$key][stime] = date("Y-m-d",$value[sdate]);
				$rec_list[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$rec_list[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$rec_list[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);
				if($value[minsalary]&&$value[maxsalary]){
					$rec_list[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
				}elseif($value[minsalary]){
					$rec_list[$key][job_salary] =$value[minsalary]."以上";
				}else{
                    $rec_list[$key][job_salary] ="面议";
                }
				
				$rec_list[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
				$rec_list[$key][logo] =$r_uid[$value['uid']][logo];
				$rec_list[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$rec_list[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$rec_list[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				$time=$value['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$rec_list[$key]['time'] ="一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$rec_list[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$rec_list[$key]['time'] = date("H:i",$value['lastupdate']);
					$rec_list[$key]['redtime'] =1;
				}else{
					$rec_list[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($rec_list[$key]['welfare'])&&$rec_list[$key]['welfare']){
					foreach($rec_list[$key]['welfare'] as $val){
						$rec_list[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$rec_list[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$rec_list[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$rec_list[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$rec_list[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$rec_list[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$rec_list[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$rec_list[$key][color] = str_replace("#","",$v[com_color]);
						$rec_list[$key][ratlogo] = $v[com_pic];
						$rec_list[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$rec_list[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$rec_list[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$rec_list[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$rec_list[$key][name_n]);
					$rec_list[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$rec_list[$key][com_n]);
					$rec_list[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$rec_list[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
    			}
			}

			if(is_array($rec_list)){
				if($paramer[keyword]!=""&&!empty($rec_list)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php global $db,$db_config,$config;
		$time = time();
		
		
        eval('$paramer=array("namelen"=>"10","comlen"=>"14","limit"=>"20","item"=>"\'new_list\'","name"=>"\'new_list1\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		 
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `edate`>'$time' and `state`=1";
		}else{
			$where = "`state`=1 and `edate`>'$time'";
		}
        
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[rec]){
			include_once  PLUS_PATH."/comrating.cache.php";
			$recRating = array();
		
			if($comrat){
				foreach($comrat as $value){
					if($value[display]=='1' && $value[category]=='1' && $value[jobrec]=='2'){
						$recRating[] = $value['id'];
					}
				}
			}
			if(!empty($recRating)){
				$recRaringId = implode(',',$recRating);
				
				$where.=" AND (`rating` IN (".$recRaringId.") OR `rec_time`>=".time().")";

			}else{
				$where.=" AND `rec_time`>=".time();
			}
		}
		if($paramer['cert']){
			$job_uid=array();
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`<>2";
		}
		if($paramer[status]){
			$where.= " and `status`=1";
		}else{
			$where.= " and `status`<>1";
		}
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		} 
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		if($paramer[job1_son]){
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		if($paramer[job_post]){
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		if($paramer['jobids']){
			$where.= " AND (`job1` = $paramer[jobids] OR `job1_son`=$paramer[jobids] OR `job_post`=$paramer[jobids])";
		}
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		if($paramer[edu]){
			$where .= " AND `edu` = $paramer[edu]";
		}
		if($paramer[exp]){
			$where .= " AND `exp` = $paramer[exp]";
		}
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary])."))";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`>=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`!=0 and  `maxsalary`=0))";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).")
						or (`minsalary`<=".intval($paramer[maxsalary])." and maxsalary=0) 
						or (`minsalary`=0 and  `maxsalary`!=0)
						)";
		}
		if($paramer[cityin]){
			$where .= " AND (`provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
    			$where.=" AND lastupdate>$beginToday";
    		}else{
    			$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
    		}
		}
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		if($paramer[bid]){
			$where.="  and `xsdate`>'".time()."'";
		} 
		if($paramer[noids]==1 && !empty($noids)){
			$where.=" AND `id` NOT IN (".@implode(',',$noids).")";
		}
		if($paramer[where]){
			$where = $paramer[where];
		}

		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);
          
		} 
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		} 
		$where.=$order.$sort;  
		 
		$new_list = $db->select_all("company_job",$where.$limit);
		if(is_array($new_list)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($new_list as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`,`logo`,`pr`,`hy`,`mun`");
				include  PLUS_PATH."/com.cache.php";
				include  PLUS_PATH."/industry.cache.php";
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						if($value['logo']){
							$value['logo'] = $config['sy_weburl']."/".$value['logo'];
						}else{
							$value['logo'] = $config['sy_weburl']."/".$config['sy_unit_icon'];
						}
						
						$value['pr_n'] = $comclass_name[$value[pr]];
						$value['hy_n'] = $industry_name[$value[hy]];
						$value['mun_n'] = $comclass_name[$value[mun]];
						$r_uid[$value['uid']] = $value;
					}
				}
			}

			include_once  PLUS_PATH."/comrating.cache.php";
			include(CONFIG_PATH."db.data.php");
			$noids=array();
			foreach($new_list as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$new_list[$key] = $db->array_action($value,$cache_array);
				$new_list[$key][stime] = date("Y-m-d",$value[sdate]);
				$new_list[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$new_list[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$new_list[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);
				if($value[minsalary]&&$value[maxsalary]){
					$new_list[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
				}elseif($value[minsalary]){
					$new_list[$key][job_salary] =$value[minsalary]."以上";
				}else{
                    $new_list[$key][job_salary] ="面议";
                }
				
				$new_list[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
				$new_list[$key][logo] =$r_uid[$value['uid']][logo];
				$new_list[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$new_list[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$new_list[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				$time=$value['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$new_list[$key]['time'] ="一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$new_list[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$new_list[$key]['time'] = date("H:i",$value['lastupdate']);
					$new_list[$key]['redtime'] =1;
				}else{
					$new_list[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($new_list[$key]['welfare'])&&$new_list[$key]['welfare']){
					foreach($new_list[$key]['welfare'] as $val){
						$new_list[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$new_list[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$new_list[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$new_list[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$new_list[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$new_list[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$new_list[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$new_list[$key][color] = str_replace("#","",$v[com_color]);
						$new_list[$key][ratlogo] = $v[com_pic];
						$new_list[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$new_list[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$new_list[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$new_list[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$new_list[$key][name_n]);
					$new_list[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$new_list[$key][com_n]);
					$new_list[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$new_list[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
    			}
			}

			if(is_array($new_list)){
				if($paramer[keyword]!=""&&!empty($new_list)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php $ulist=array();global $db,$db_config,$config;
		if(is_array($_GET)){
			foreach($_GET as $key=>$value){
				if($value=='0'){
					unset($_GET[$key]);
				}
			}
		}
		eval('$paramer=array("item"=>"\'ulist\'","post_len"=>"10","limit"=>"12","key"=>"\'key\'","name"=>"\'userlist1\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }

        include PLUS_PATH."/job.cache.php";
		$where = "status<>'2' and `r_status`<>'2' and `job_classid`<>'' and `open`='1' and `defaults`='1'";
		if($config['sy_web_site']=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config['cityid']>0 && $config['cityid']!=""){
				$paramer['cityid']=$config['cityid'];
			}
			if($config['three_cityid']>0 && $config['three_cityid']!=""){
				$paramer['three_cityid']=$config['three_cityid'];
			}
			if($config['hyclass']>0 && $config['hyclass']!=""){
				$paramer['hy']=$config['hyclass'];
			}
		}
		if($paramer[where_uid]){
			$where .=" AND `uid` in (".$paramer['where_uid'].")";
		}
		if($_COOKIE['uid']&&$_COOKIE['usertype']=="2"){
			$blacklist=$db->select_all("blacklist","`p_uid`='".$_COOKIE['uid']."'","c_uid");
			if(is_array($blacklist)&&$blacklist){
				foreach($blacklist as $v){
					$buid[]=$v['c_uid'];
				}
			$where .=" AND `uid` NOT IN (".@implode(",",$buid).")";
			}
		}
		if($paramer[topdate]){
			$where .=" AND `topdate`>'".time()."'";
		}
		if($paramer[noid]==1 && !empty($noids)){
			$where.=" AND `id` NOT IN (".@implode(',',$noids).")";
		}
		if($paramer[idcard]){
			$where .=" AND `idcard_status`='1'";
		}
		if($paramer[height_status]){
			$where .=" AND height_status=".$paramer[height_status];
		}else{
			$where .=" AND height_status<>'2'";
		}
		if($paramer[rec]){
			$where .=" AND `rec`=1";
		}
		if($paramer[rec_resume]){
			$where .=" AND `rec_resume`=1";
		}
		if($paramer[work]){
			$show=$db->select_all("resume_show","1 group by eid","`eid`");
			if(is_array($show)){
				foreach($show as $v){
					$eid[]=$v['eid'];
				}
			}
			$where .=" AND id in (".@implode(",",$eid).")";
		}
		if($paramer[tag]){
			$tag=$db->select_all("resume","`def_job`>0 and `r_status`<>2 and `status`=1 and FIND_IN_SET('".$paramer[tag]."',`tag`)","`def_job`");
			if(is_array($tag)){
				foreach($tag as $v){
					$tagid[]=$v['def_job'];
				}
			}
			$where .=" AND id in (".@implode(",",$tagid).")";
		}
		if($paramer[cid]){
			$where .= " AND (cityid=$paramer[cid] or three_cityid=$paramer[cid])";
		}
		if($paramer[keyword]){
			$where1[]="`uname` LIKE '%$paramer[keyword]%'";
			foreach($job_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$jobid[]=$k;
				}
			}
			if(is_array($jobid)){
				foreach($jobid as $value){
					$class[]="FIND_IN_SET('".$value."',job_classid)";
				}
				$where1[]=@implode(" or ",$class);
			}
			include_once  PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		if($paramer[pic]=="0" || $paramer[pic]){
			$where .=" AND photo<>''";
			$where .=" AND phototype!=1";
		}
		if($paramer[name]=="0"){
			$where .=" AND uname<>''";
		}
		if($paramer[hy]=="0"){
			$where .=" AND hy<>''";
		}elseif($paramer[hy]!=""){
			$where .= " AND (`hy` IN (".$paramer['hy']."))";
		}
		$job_classid="";
		if($paramer[jobids]){
			$joball=explode(",",$paramer[jobids]);
			foreach(explode(",",$paramer[jobids]) as $v){
				if($job_type[$v]){
					$joball[]=@implode(",",$job_type[$v]);
				}
			}
			$job_classid=implode(",",$joball);
		}
		if($paramer[jobin]){
			$joball=explode(",",$paramer[jobin]);
			foreach(explode(",",$paramer[jobin]) as $v){
				if($job_type[$v]){
					$joball[]=@implode(",",$job_type[$v]);
				}
			}
			$job_classid=implode(",",$joball);
		}
		if($paramer[job1]){
			$joball=$job_type[$paramer[job1]];
			foreach($job_type[$paramer[job1]] as $v){
				$joball[]=@implode(",",$job_type[$v]);
			}
			$job_classid=@implode(",",$joball);
		}
		if($paramer[job1_son]){
			$joball=$job_type[$paramer[job1_son]];
			foreach($job_type[$paramer[job1_son]] as $v){
				$joball[]=@implode(",",$v);
			}
			$job_classid=@implode(",",$joball);
		}
		if(!empty($job_classid)){
			$classid=@explode(",",$job_classid);
			foreach($classid as $value){
				$jobclass[]="FIND_IN_SET('".$value."',job_classid)";
			}
			$classid=@implode(" or ",$jobclass);
			$where .= " AND ($classid)";
		}
		if($paramer[job_post]){
			$where .=" AND FIND_IN_SET('".$paramer[job_post]."',job_classid)";
		}
		if($paramer[provinceid]){
			$where .= " AND provinceid = $paramer[provinceid]";
		}
		if($paramer[cityid]){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		if($paramer[three_cityid]){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer[cityin]){
			$where .= " AND(provinceid IN ($paramer[cityin]) OR cityid IN ($paramer[cityin]) OR three_cityid IN ($paramer[cityin]))";
		}
		if($paramer[exp]){
			$where .=" AND exp=$paramer[exp]";
		}else{
			$where .=" AND exp>0";
		}
		if($paramer[edu]){
			$where .=" AND edu=$paramer[edu]";
		}else{
			$where .=" AND edu>0";
		}
		if($paramer[sex]){
			$where .=" AND sex=$paramer[sex]";
		}
		if($paramer[report]){
			$where .=" AND report=$paramer[report]";
		}
		if($paramer[salary]){
			$where .=" AND salary=$paramer[salary]";
		}
		if($paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary])."))";
		}elseif($paramer[minsalary]&&!$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`>=".intval($paramer[minsalary])." and `maxsalary`>=".intval($paramer[minsalary]).")
						or (`minsalary`!=0 and  `maxsalary`=0))";
		}elseif(!$paramer[minsalary]&&$paramer[maxsalary]){
			$where.= " AND ((`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`>=".intval($paramer[maxsalary]).") 
						or (`minsalary`<=".intval($paramer[maxsalary])." and `maxsalary`<=".intval($paramer[maxsalary]).")
						or (`minsalary`<=".intval($paramer[maxsalary])." and maxsalary=0) 
						or (`minsalary`=0 and  `maxsalary`!=0)
						)";
		}
		
		if($paramer[type]){
			$where .= " AND type=$paramer[type]";
		}
		if($paramer[uptime]){
			if($paramer[uptime]==1){
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
    			$where.=" AND lastupdate>$beginToday";
    		}else{
    			$time=time();
				$uptime = $time-($paramer[uptime]*86400);
				$where.=" AND lastupdate>$uptime";
    		}
		}
		if($paramer[adtime]){
			$time=time();
			$adtime = $time-($paramer[adtime]*86400);
			$where.=" AND status_time>$adtime";
		}
		
		
		if($paramer[order] && $paramer[order]!="lastdate"){
			if($paramer[order]=='ant_num'){
				$order = " ORDER BY `ant_num`";
			}elseif($paramer[order]=='topdate'){
				$nowtime=time();
				$order = " ORDER BY if(topdate>$nowtime,topdate,lastupdate)";
			}else{
				$order = " ORDER BY `".str_replace("'","",$paramer[order])."`";
			}
		}else{
			$order = " ORDER BY lastupdate ";
		}
		
		$sort = $paramer[sort]?$paramer[sort]:'DESC';
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}

		if($paramer[where]){
			$where = $paramer[where];
		}
		if($paramer[ispage]){
			if($paramer["height_status"]){
				$limit = PageNav($paramer,$_GET,"resume_expect",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"3",$_smarty_tpl);
			}else{
				$limit = PageNav($paramer,$_GET,"resume_expect",$where,$Purl,"",'0',$_smarty_tpl);
			}
		}
		$where.=$order.$sort;
		$ulist=$db->select_all("resume_expect",$where.$limit,"*,uname as username");
        include(CONFIG_PATH."db.data.php");		
		if(is_array($ulist)){
			$cache_array = $db->cacheget();
			$userclass_name = $cache_array["user_classname"];
			$city_name      = $cache_array["city_name"];
			$job_name		= $cache_array["job_name"];
			$industry_name	= $cache_array["industry_name"];
			
			if($paramer['top']){
				$uids=$m_name=array();
				foreach($ulist as $k=>$v){
					$uids[]=$v[uid];
				}

				$member=$db->select_all($db_config[def]."member","`uid` in(".@implode(',',$uids).")","uid,username");
				foreach($member as $val){
					$m_name[$val[uid]]=$val['username'];
				}
			}
			foreach($ulist as $key=>$value){
				$uid[] = $value['uid'];
				$eid[] = $value['id'];
			}
			$eids = @implode(',',$eid);
			$uids = @implode(',',$uid);
            $resume=$db->select_all("resume","`uid` in(".$uids.")","uid,name,nametype,tag,sex,edu,exp,photo,phototype,birthday");
			foreach($ulist as $k=>$v){
			    foreach($resume as $val){
			        if($v['uid']==$val['uid']){
			    		$ulist[$k]['edu_n']=$userclass_name[$val['edu']];
				        $ulist[$k]['exp_n']=$userclass_name[$val['exp']];
			            if($val['birthday']){
							$year = date("Y",strtotime($val['birthday']));
							$ulist[$k]['age'] =date("Y")-$year;
						}
		                $ulist[$k]['sex'] =$val['sex'];   
		                $ulist[$k]['phototype']=$val[phototype];
		                if($val['photo'] && $val['phototype']!=1&&(file_exists(str_replace($config['sy_weburl'],APP_PATH,'.'.$val['photo']))||file_exists(str_replace($config['sy_weburl'],APP_PATH,$val['photo'])))){
            				$ulist[$k]['photo']=str_replace("./",$config['sy_weburl']."/",$val['photo']);
            			}else{
            				if($val['sex']==1){
            					$ulist[$k]['photo']=$config['sy_weburl']."/".$config['sy_member_icon'];
            				}else{
            					$ulist[$k]['photo']=$config['sy_weburl']."/".$config['sy_member_iconv'];
            				}
            			}
						if($val['tag']){
                            $ulist[$k]['tag']=explode(',',$val['tag']);
	                    }
                        $ulist[$k]['nametype']=$val[nametype];
						if($val['nametype']==3){
						    if($val['sex']==1){
						        $ulist[$k]['username_n'] = mb_substr($val['name'],0,1,'gbk')."先生";
						    }else{
						        $ulist[$k]['username_n'] = mb_substr($val['name'],0,1,'gbk')."女士";
						    }
						}elseif($val['nametype']==2){
						    $ulist[$k]['username_n'] = "NO.".$v['id'];
						}else{
							$ulist[$k]['username_n'] = $val['name'];
						}
                    }
                }
				if($paramer[topdate]){
					$noids[] = $v[id];
				}
				$time=$v['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$ulist[$k]['time'] = "一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$ulist[$k]['time'] = "昨天";
				}elseif($time>$beginToday){
					$ulist[$k]['time'] = date("H:i",$v['lastupdate']);
					$ulist[$k]['redtime'] =1;
				}else{
					$ulist[$k]['time'] = date("Y-m-d",$v['lastupdate']);
				} 
				$ulist[$k]['edu_n']=$userclass_name[$v['edu']];
				$ulist[$k]['exp_n']=$userclass_name[$v['exp']];
				$ulist[$k]['user_jobstatus_n']=$userclass_name[$v['jobstatus']];
				$ulist[$k]['job_city_one']=$city_name[$v['provinceid']];
				$ulist[$k]['job_city_two']=$city_name[$v['cityid']];
				$ulist[$k]['job_city_three']=$city_name[$v['three_cityid']];
				if($v['minsalary']&&$v['maxsalary']){
					$ulist[$k]["salary_n"] = "￥".$v['minsalary']."-".$v['maxsalary'];    
                }else if($v['minsalary']){
                    $ulist[$k]["salary_n"] = "￥".$v['minsalary']."以上";  
                }else{
    				$ulist[$k]["salary_n"] = "面议";
    			}
				$ulist[$k]['report_n']=$userclass_name[$v['report']];
				$ulist[$k]['type_n']=$userclass_name[$v['type']];
				$ulist[$k]['lastupdate']=date("Y-m-d",$v['lastupdate']);
					
				$ulist[$k]['user_url']=Url("resume",array("c"=>"show","id"=>$v['id']),"1");
				$ulist[$k]["hy_info"]=$industry_name[$v['hy']];
				if($paramer['top']){
					$ulist[$k]['m_name']=$m_name[$v['uid']];
					$ulist[$k]['user_url']=Url("ask",array("c"=>"friend","a"=>"myquestion","uid"=>$v['uid']));
				}
				$job_classid=@explode(",",$v['job_classid']);
				$job_classid=array_unique($job_classid);	
				$jobname=array();
				if(is_array($job_classid)){
					foreach($job_classid as $val){
					    if($val!=''){
					        $jobname[]=$job_name[$val];
                        }
					}
				}
				$ulist[$k]['job_post']=@implode(",",$jobname);
				$ulist[$k]['expectjob']=$jobname;
				if($paramer['post_len']){
					$postname[$k]=@implode(",",$jobname);
					$ulist[$k]['job_post_n']=mb_substr($postname[$k],0,$paramer[post_len],"GBK");
				}
				if($paramer['keyword']){
					$ulist[$k]['username']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$v['username']);
					$ulist[$k]['job_post']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$ulist[$k]['job_post']);
					$ulist[$k]['job_post_n']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$ulist[$k]['job_post_n']);
					$ulist[$k]['job_city_one']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$city_name[$v['provinceid']]);
					$ulist[$k]['job_city_two']=str_replace($paramer['keyword'],"<font color=#FF6600 >".$paramer['keyword']."</font>",$city_name[$v['cityid']]);
				}
			}
			if($paramer['keyword']!=""&&!empty($ulist)){
				addkeywords('5',$paramer['keyword']);
			}
		} ?>
<?php global $db,$db_config,$config;include PLUS_PATH.'/group.cache.php';$plist=array();$rs=null;$nids=null;eval('$paramer=array("pic"=>"1","t_len"=>"20","limit"=>"3","item"=>"\'plist\'","key"=>"\'pkey\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr['arr'];
		$Purl =  $ParamerArr['purl'];
        if($paramer[cache]){
			$Purl="{{page}}.html";
		}
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where=1;
		if($config['did']){
			$where.=" and `did`='".$config['did']."'";
		}
		include PLUS_PATH."/group.cache.php"; 
		if(is_array($paramer)){
			if($paramer['nid']){
				$nid_s = @explode(',',$paramer[nid]);				
				foreach($nid_s as $v){
					if($group_type[$v]){
						$paramer[nid] = $paramer[nid].",".@implode(',',$group_type[$v]);
					}
				}
			}
			
			if($paramer['nid']!=""){
				$where .=" AND `nid` in ($paramer[nid])";
				$nids = @explode(',',$paramer['nid']);$paramer['nid']=$paramer['nid'];
			}else if($paramer['rec']!=""){
				$nids=array();if(is_array($group_rec)){
					foreach($group_rec as $key=>$value){
						if($key<=2){
							$nids[]=$value;
						}
					}
					$paramer[nid]=@implode(',',$nids);
				}
			}
			
			if($paramer['type']){
				$type = str_replace("\"","",$paramer[type]);
				$type_arr =	@explode(",",$type);
				if(is_array($type_arr) && !empty($type_arr)){
					foreach($type_arr as $key=>$value){
						$where .=" AND FIND_IN_SET('".$value."',`describe`)";
						if(count($nids)>0){
							$picwhere .=" AND FIND_IN_SET('".$value."',`describe`)";
						}
					}
				}
			}
			if($paramer['pic']!=""){
				$where .=" AND `newsphoto`<>''";
			}
			if($paramer['keyword']!=""){
				$where .=" AND `title` LIKE '%".$paramer[keyword]."%'";
			}
			
			if(intval($paramer['limit'])>0){
				$limit = intval($paramer['limit']);
				$limit = " limit ".$limit;
			}
			if($paramer['ispage']){
				if($Purl["m"]=="wap"){
					$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","6",$_smarty_tpl);
				}else{
					$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","5",$_smarty_tpl);
				}
			}
			if($paramer['order']!=""){
				$order = str_replace("'","",$paramer['order']);
				$where .=" ORDER BY $order";
			}else{
				$where .=" ORDER BY `datetime`";
			}
			if($paramer['sort']){
				$where.=" ".$paramer[sort];
			}else{
				$where.=" DESC";
			}
		}

		if(!intval($paramer['ispage']) && count($nids)>0){
			$nidArr = @explode(',',$paramer[nid]);
			$rsnids = '';
			if(is_array($group_type)){
				foreach($group_type as $key=>$value){
					if(in_array($key,$nidArr)){						
						if(is_array($value)){
							foreach($value as $v){
								$rsnids[$v] = $key;
								$nidArr[] = $v;
							}
						}
					}
				}							
			}
			$where = " `nid` IN (".@implode(',',$nidArr).")";
			if($config['did']){
				$where.=" and `did`='".$config['did']."'";
			}
			if($paramer['pic']){
				if(!$paramer['piclimit']){
					$piclimit = 1;
				}else{
					$piclimit = $paramer['piclimit'];
				}
				$db->query("set @f=0,@n=0");
				$query = $db->query("select * from (select id,title,color,datetime,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE ".$where." AND `newsphoto` <>''  order by nid asc,datetime desc) a where aid <=".$piclimit);
				while($rs = $db->fetch_array($query)){
					if($rsnids[$rs['nid']]){
						$rs['nid'] = $rsnids[$rs['nid']];
					}
					if(intval($paramer[t_len])>0){

						$len = intval($paramer[t_len]);
						$rs[title] = mb_substr($rs[title],0,$len,"GBK");
					}
					if($rs[color]){
						$rs[title] = "<font color='".$rs[color]."'>".$rs[title]."</font>";
					}
					if(intval($paramer[d_len])>0){
						$len = intval($paramer[d_len]);
						$rs[description] = mb_substr($rs[description],0,$len,"GBK");
					}
					$rs['name'] = $group_name[$rs['nid']];

					if($config[sy_news_rewrite]=="2"){
						$rs["url"]=$config['sy_weburl']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
					}else{
						$rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
					}
					if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config['sy_weburl']."/".$rs[newsphoto];
					}
					$rs[time]=date("Y-m-d",$rs[datetime]);
					$rs['datetime']=date("m-d",$rs[datetime]);
					if(count($plist[$rs['nid']]['pic'])<$piclimit){
					    $plist[$rs['nid']]['pic'][] = $rs;
					}
				
				}
			}
			
            $db->query("set @f=0,@n=0");
            $query = $db->query("select * from (select id,title,datetime,color,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE ".$where." order by nid asc,datetime desc) a where aid <=$paramer[limit]");

            while($rs = $db->fetch_array($query)){
				if($rsnids[$rs['nid']]){
						$rs['nid'] = $rsnids[$rs['nid']];
					}
                if(intval($paramer[t_len])>0){

					$len = intval($paramer[t_len]);
					$rs[title] = mb_substr($rs[title],0,$len,"GBK");
				}
				if($rs[color]){
					$rs[title] = "<font color='".$rs[color]."'>".$rs[title]."</font>";
				}
                if(intval($paramer[d_len])>0){
                    $len = intval($paramer[d_len]);
                    $rs[description] = mb_substr($rs[description],0,$len,"GBK");
                }
                $rs['name'] = $group_name[$rs['nid']];
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config['sy_weburl']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
                }
				if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config['sy_weburl']."/".$rs[newsphoto];
					}
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
				if(count($plist[$rs['nid']]['arclist'])<$paramer[limit]){
					$plist[$rs['nid']]['arclist'][] = $rs;
				}
                
            }
		}else{
			$query = $db->query("SELECT * FROM `$db_config[def]news_base` WHERE ".$where.$limit);
			while($rs = $db->fetch_array($query)){
				if(intval($paramer[t_len])>0){
					$len = intval($paramer[t_len]);
					$rs[title] = mb_substr($rs[title],0,$len,"GBK");
				}
				if($rs[color]){
					$rs[title] = "<font color='".$rs[color]."'>".$rs[title]."</font>";
				}
                if(intval($paramer[d_len])>0){
                    $len = intval($paramer[d_len]);
                    $rs[description] = mb_substr($rs[description],0,$len,"GBK");
                }
                $rs['name'] = $group_name[$rs['nid']];
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config['sy_weburl']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
                }
				if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config['sy_weburl']."/".$rs[newsphoto];
					}
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
                $plist[] = $rs;
            }
		} ?>
<?php global $db,$db_config,$config;include PLUS_PATH.'/group.cache.php';$indexnews=array();$rs=null;$nids=null;eval('$paramer=array("limit"=>"7","type"=>"\'indextj\'","item"=>"\'indexnews\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr['arr'];
		$Purl =  $ParamerArr['purl'];
        if($paramer[cache]){
			$Purl="{{page}}.html";
		}
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where=1;
		if($config['did']){
			$where.=" and `did`='".$config['did']."'";
		}
		include PLUS_PATH."/group.cache.php"; 
		if(is_array($paramer)){
			if($paramer['nid']){
				$nid_s = @explode(',',$paramer[nid]);				
				foreach($nid_s as $v){
					if($group_type[$v]){
						$paramer[nid] = $paramer[nid].",".@implode(',',$group_type[$v]);
					}
				}
			}
			
			if($paramer['nid']!=""){
				$where .=" AND `nid` in ($paramer[nid])";
				$nids = @explode(',',$paramer['nid']);$paramer['nid']=$paramer['nid'];
			}else if($paramer['rec']!=""){
				$nids=array();if(is_array($group_rec)){
					foreach($group_rec as $key=>$value){
						if($key<=2){
							$nids[]=$value;
						}
					}
					$paramer[nid]=@implode(',',$nids);
				}
			}
			
			if($paramer['type']){
				$type = str_replace("\"","",$paramer[type]);
				$type_arr =	@explode(",",$type);
				if(is_array($type_arr) && !empty($type_arr)){
					foreach($type_arr as $key=>$value){
						$where .=" AND FIND_IN_SET('".$value."',`describe`)";
						if(count($nids)>0){
							$picwhere .=" AND FIND_IN_SET('".$value."',`describe`)";
						}
					}
				}
			}
			if($paramer['pic']!=""){
				$where .=" AND `newsphoto`<>''";
			}
			if($paramer['keyword']!=""){
				$where .=" AND `title` LIKE '%".$paramer[keyword]."%'";
			}
			
			if(intval($paramer['limit'])>0){
				$limit = intval($paramer['limit']);
				$limit = " limit ".$limit;
			}
			if($paramer['ispage']){
				if($Purl["m"]=="wap"){
					$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","6",$_smarty_tpl);
				}else{
					$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","5",$_smarty_tpl);
				}
			}
			if($paramer['order']!=""){
				$order = str_replace("'","",$paramer['order']);
				$where .=" ORDER BY $order";
			}else{
				$where .=" ORDER BY `datetime`";
			}
			if($paramer['sort']){
				$where.=" ".$paramer[sort];
			}else{
				$where.=" DESC";
			}
		}

		if(!intval($paramer['ispage']) && count($nids)>0){
			$nidArr = @explode(',',$paramer[nid]);
			$rsnids = '';
			if(is_array($group_type)){
				foreach($group_type as $key=>$value){
					if(in_array($key,$nidArr)){						
						if(is_array($value)){
							foreach($value as $v){
								$rsnids[$v] = $key;
								$nidArr[] = $v;
							}
						}
					}
				}							
			}
			$where = " `nid` IN (".@implode(',',$nidArr).")";
			if($config['did']){
				$where.=" and `did`='".$config['did']."'";
			}
			if($paramer['pic']){
				if(!$paramer['piclimit']){
					$piclimit = 1;
				}else{
					$piclimit = $paramer['piclimit'];
				}
				$db->query("set @f=0,@n=0");
				$query = $db->query("select * from (select id,title,color,datetime,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE ".$where." AND `newsphoto` <>''  order by nid asc,datetime desc) a where aid <=".$piclimit);
				while($rs = $db->fetch_array($query)){
					if($rsnids[$rs['nid']]){
						$rs['nid'] = $rsnids[$rs['nid']];
					}
					if(intval($paramer[t_len])>0){

						$len = intval($paramer[t_len]);
						$rs[title] = mb_substr($rs[title],0,$len,"GBK");
					}
					if($rs[color]){
						$rs[title] = "<font color='".$rs[color]."'>".$rs[title]."</font>";
					}
					if(intval($paramer[d_len])>0){
						$len = intval($paramer[d_len]);
						$rs[description] = mb_substr($rs[description],0,$len,"GBK");
					}
					$rs['name'] = $group_name[$rs['nid']];

					if($config[sy_news_rewrite]=="2"){
						$rs["url"]=$config['sy_weburl']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
					}else{
						$rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
					}
					if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config['sy_weburl']."/".$rs[newsphoto];
					}
					$rs[time]=date("Y-m-d",$rs[datetime]);
					$rs['datetime']=date("m-d",$rs[datetime]);
					if(count($indexnews[$rs['nid']]['pic'])<$piclimit){
					    $indexnews[$rs['nid']]['pic'][] = $rs;
					}
				
				}
			}
			
            $db->query("set @f=0,@n=0");
            $query = $db->query("select * from (select id,title,datetime,color,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE ".$where." order by nid asc,datetime desc) a where aid <=$paramer[limit]");

            while($rs = $db->fetch_array($query)){
				if($rsnids[$rs['nid']]){
						$rs['nid'] = $rsnids[$rs['nid']];
					}
                if(intval($paramer[t_len])>0){

					$len = intval($paramer[t_len]);
					$rs[title] = mb_substr($rs[title],0,$len,"GBK");
				}
				if($rs[color]){
					$rs[title] = "<font color='".$rs[color]."'>".$rs[title]."</font>";
				}
                if(intval($paramer[d_len])>0){
                    $len = intval($paramer[d_len]);
                    $rs[description] = mb_substr($rs[description],0,$len,"GBK");
                }
                $rs['name'] = $group_name[$rs['nid']];
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config['sy_weburl']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
                }
				if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config['sy_weburl']."/".$rs[newsphoto];
					}
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
				if(count($indexnews[$rs['nid']]['arclist'])<$paramer[limit]){
					$indexnews[$rs['nid']]['arclist'][] = $rs;
				}
                
            }
		}else{
			$query = $db->query("SELECT * FROM `$db_config[def]news_base` WHERE ".$where.$limit);
			while($rs = $db->fetch_array($query)){
				if(intval($paramer[t_len])>0){
					$len = intval($paramer[t_len]);
					$rs[title] = mb_substr($rs[title],0,$len,"GBK");
				}
				if($rs[color]){
					$rs[title] = "<font color='".$rs[color]."'>".$rs[title]."</font>";
				}
                if(intval($paramer[d_len])>0){
                    $len = intval($paramer[d_len]);
                    $rs[description] = mb_substr($rs[description],0,$len,"GBK");
                }
                $rs['name'] = $group_name[$rs['nid']];
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config['sy_weburl']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
                }
				if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config['sy_weburl']."/".$rs[newsphoto];
					}
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
                $indexnews[] = $rs;
            }
		} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/index.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css" rel="stylesheet" type="text/css" />
<?php if ($_smarty_tpl->tpl_vars['ishtml']->value) {?>
<?php echo '<script'; ?>
 src="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'wjump'),$_smarty_tpl);?>
" language="javascript"><?php echo '</script'; ?>
>
<?php }?>
</head>

<body>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="w1000">
<div class="index_banner none" id="js_ads_banner_top"><?php  $_smarty_tpl->tpl_vars['adlist_73'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['adlist_73']->_loop = false;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[73];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 1;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars['adlist_73']->key => $_smarty_tpl->tpl_vars['adlist_73']->value) {
$_smarty_tpl->tpl_vars['adlist_73']->_loop = true;
?>
<?php echo $_smarty_tpl->tpl_vars['adlist_73']->value['html'];?>

<?php } ?></div>
<div class="index_banner" id="js_ads_banner_top_slide"><?php  $_smarty_tpl->tpl_vars['adlist_72'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['adlist_72']->_loop = false;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[72];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 1;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars['adlist_72']->key => $_smarty_tpl->tpl_vars['adlist_72']->value) {
$_smarty_tpl->tpl_vars['adlist_72']->_loop = true;
?>
<?php echo $_smarty_tpl->tpl_vars['adlist_72']->value['html'];?>

<?php } ?></div>
<div class="hp_kk fl">
<div class="hp_login fl">
     <div class="hp_login_tit"><i class="hp_login_tit_icon"></i>会员登录</div>
     <div class="hp_login_hy">
          <i class="hp_login_hy_icon fl"></i>
          <input class="hp_login_hy_but fl" type="text" id="username" name="username" placeholder="邮箱/手机号/用户名"/>
     </div>
     <div class="hp_login_hy">
          <i class="hp_login_mm_icon fl"></i>
          <input class="hp_login_mm_but fl" type="password" id="password" name="password" placeholder="请输入密码"/>
     </div>
     <div class="hp_login_box">
          <div class="hp_login_box_ft fl">
               <input type="checkbox"/>
               <span class="hp_login_box_r">下次自动登录</span>
          </div>
          <div class="hp_login_box_rt fr"><a href="<?php echo smarty_function_url(array('m'=>'forgetpw'),$_smarty_tpl);?>
">忘记密码？</a></div>
     </div>
     <div class="hp_login_lg"><input class="hp_login_lg_but" type="submit" value="登录" onclick="check_login('<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
');"/></div>
     <div class="hp_login_rg">
          <a href="<?php echo smarty_function_url(array('m'=>'register','usertype'=>2,'type'=>1),$_smarty_tpl);?>
">企业注册</a>
          <a style="margin-left:8px;" href="<?php echo smarty_function_url(array('m'=>'register','usertype'=>1,'type'=>1),$_smarty_tpl);?>
">个人注册</a>
     </div>
</div>

<div class="hp_banner fl" id="ban">
     <div class="banner">
     <ul class="img">
     <?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[3];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 0;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars["lunbo"]->key => $_smarty_tpl->tpl_vars["lunbo"]->value) {
$_smarty_tpl->tpl_vars["lunbo"]->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars["lunbo"]->key;
?>
     <li><?php echo $_smarty_tpl->tpl_vars['lunbo']->value['html'];?>
</li>
     <?php } ?>
     </ul>
     <div class="hp_banner_icon_ft"><div class="hp_br_icon_f"></div><div class="hp_br_icon_r"></div></div>
     <div class="hp_banner_icon_rt"><div class="hp_br_icon_fr"></div><div class="hp_br_icon_tt"></div></div>
     <div class="hp_banner_gd">
          <div class="hp_banner_gd_list"></div>
          <div class="hp_banner_gd_list_ab">
              <ul class="num">
              </ul>
          </div>
     </div>
     </div>
</div>
<div class="hp_zp fl">
     <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode']) {?>
     <div class="hp_z_w">
           <i class="hp_z_w_icon"></i>
           <a href="javascript:void(0);"><span class="hp_z_w_sp">微信招聘</span></a>
           <div class="hp_z_w_er" id="hp_weixin">
                <dl>
                    <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
"  width="70" height="70"></dt>
                    <dd>关注微信公众号<br/>轻松跟踪投递进展</dd>
                </dl>
           </div>
     </div>
     <?php }?>
     <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wap_qcode']) {?>
     <div class="hp_z_s">
           <i class="hp_z_s_icon dn"></i>
           <a href="javascript:void(0);"><span class="hp_z_w_sp">手机招聘</span></a>
           <div class="hp_z_s_er dn" id="hp_phone">
                <dl>
                    <dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wap_qcode'];?>
" width="70" height="70"></dt>
                    <dd>找工作更方便<br>随时随地找工作</dd>
                </dl>
           </div>
     </div>
     <?php }?>     
     <div class="hp_web"> 
          <div class="hp_web_top">网站公告<a href="<?php echo smarty_function_url(array('m'=>'announcement'),$_smarty_tpl);?>
" class="g_more">更多>></a></div>
          <div class="hp_web_ct">
          <ul>
               <?php  $_smarty_tpl->tpl_vars['alist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['alist']->_loop = false;
$alist = $alist; if (!is_array($alist) && !is_object($alist)) { settype($alist, 'array');}
foreach ($alist as $_smarty_tpl->tpl_vars['alist']->key => $_smarty_tpl->tpl_vars['alist']->value) {
$_smarty_tpl->tpl_vars['alist']->_loop = true;
?>
              <li><a href="<?php echo $_smarty_tpl->tpl_vars['alist']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['alist']->value['title_n'];?>
</a></li>
               <?php } ?>
               </ul>
          </div>
     </div>
</div>
</div>
<div class="hp_hotjob fl">
     <div class="hp_hotjob_h fl">热门<br/>职位</div>
     <div class="hp_hotjob_b fl">
          <ul>
       <?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;eval('$paramer=array("limit"=>"28","recom"=>"1","type"=>"3","item"=>"\'keylist\'","nocache"=>"")
;');$list=array();
		if($paramer[recom]){
			$tuijian = 1;
		}
		if($paramer[type]){
			$type = $paramer[type];
		}
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=5;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='店铺招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='店铺招聘';
					}elseif($v['type']=="2"){
						$v['url'] = Url("part",array("keyword"=>$v['key_name']));
						$v['type_name']='兼职';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}

					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['keylist']->key => $_smarty_tpl->tpl_vars['keylist']->value) {
$_smarty_tpl->tpl_vars['keylist']->_loop = true;
?> <li><a href="<?php echo smarty_function_listurl(array('type'=>'keyword','v'=>$_smarty_tpl->tpl_vars['keylist']->value['key_title']),$_smarty_tpl);?>
" class="jos_tag_a" title="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a> </li><?php } ?>
            
          </ul>
     </div>
</div>


<div class="hp_title fl">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>名企招聘</div>
     <div class="hp_title_rt fr"><a href="<?php echo smarty_function_url(array('m'=>'company','rec'=>1),$_smarty_tpl);?>
" target="_blank">查看更多>></a></div>
</div>
<section>    
 <div class="yunFamousenterprises fl">    
 
<div class="yunFamousenterprises_box fl">
          <div class="Famous_recruitment_cont">
            <div class="index_left15560">
              <div id="mainids"> 
              <?php  $_smarty_tpl->tpl_vars['hotjoblist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotjoblist']->_loop = false;
$hotjoblist = $hotjoblist; if (!is_array($hotjoblist) && !is_object($hotjoblist)) { settype($hotjoblist, 'array');}
foreach ($hotjoblist as $_smarty_tpl->tpl_vars['hotjoblist']->key => $_smarty_tpl->tpl_vars['hotjoblist']->value) {
$_smarty_tpl->tpl_vars['hotjoblist']->_loop = true;
?>
                <div class="tlogo">
                  <ul>
                    <li onmouseover="showDiv2(this)" onmouseout="showDiv2(this)"> <a href="<?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['url'];?>
" target="_blank" class="tlogo_p_a"><img width="185" height="75" border="1" class="on lazy" src="<?php echo smarty_function_formatpicurl(array('path'=>$_smarty_tpl->tpl_vars['hotjoblist']->value['hot_pic'],'type'=>'comlogo'),$_smarty_tpl);?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_unit_icon'];?>
',2);" alt="<?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['username'];?>
"/></a>
                    <div class="yunFamousenterprises_comname"><?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['username'];?>
</div>
                      <div class="show">
                        <div class="area"><i class="area_icon"></i><?php echo $_smarty_tpl->tpl_vars['hotjoblist']->value['job'];?>
</div>
                      </div>
                    </li>
                  </ul>
                </div>
                <?php } ?> 
                </div>
            </div>
</div>
</div>
</div>
</section>


<div class="hp_title fl">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>紧急招聘</div>
     <div class="hp_title_rt fr"><a href="<?php echo smarty_function_listurl(array('type'=>'tp','v'=>1),$_smarty_tpl);?>
" target="_blank">查看更多>></a></div>
</div>
<div class="hp_urg_job fl">
     <ul>
         <?php  $_smarty_tpl->tpl_vars['urgent_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['urgent_list']->_loop = false;
$urgent_list = $urgent_list; if (!is_array($urgent_list) && !is_object($urgent_list)) { settype($urgent_list, 'array');}
foreach ($urgent_list as $_smarty_tpl->tpl_vars['urgent_list']->key => $_smarty_tpl->tpl_vars['urgent_list']->value) {
$_smarty_tpl->tpl_vars['urgent_list']->_loop = true;
?>
         <li>
             <div class="hp_urg_job_top"><a href="<?php echo $_smarty_tpl->tpl_vars['urgent_list']->value['job_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['urgent_list']->value['name'];?>
</a> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobjp.png"></div>
             <div class="hp_urg_job_ct">
                  <div class="hp_urg_job_ov"><i class="hp_urg_job_ct_r"><?php if ($_smarty_tpl->tpl_vars['urgent_list']->value['job_salary']!='面议') {?>￥<?php }
echo $_smarty_tpl->tpl_vars['urgent_list']->value['job_salary'];?>
</i> <?php echo $_smarty_tpl->tpl_vars['urgent_list']->value['job_exp'];?>
经验<i class="index_line">|</i><?php echo $_smarty_tpl->tpl_vars['urgent_list']->value['job_edu'];?>
学历</div>
                  <div  class="hp_urg_job_ov"><a class="hp_urg_job_city" href="<?php echo $_smarty_tpl->tpl_vars['urgent_list']->value['com_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['urgent_list']->value['com_name'];?>
</a></div>   
             </div>
         </li>
         <?php } ?>
     </ul>
</div>
<div class="hp_urg_job_l fl">
<div class="hp_urg_job_l_1250 fl">
<?php  $_smarty_tpl->tpl_vars['adlist_13'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['adlist_13']->_loop = false;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[13];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 2;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars['adlist_13']->key => $_smarty_tpl->tpl_vars['adlist_13']->value) {
$_smarty_tpl->tpl_vars['adlist_13']->_loop = true;
?>
<?php echo $_smarty_tpl->tpl_vars['adlist_13']->value['html'];?>

<?php } ?>
  
     <?php  $_smarty_tpl->tpl_vars['adlist_15'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['adlist_15']->_loop = false;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[15];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 10;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars['adlist_15']->key => $_smarty_tpl->tpl_vars['adlist_15']->value) {
$_smarty_tpl->tpl_vars['adlist_15']->_loop = true;
?>
     <?php echo $_smarty_tpl->tpl_vars['adlist_15']->value['html'];?>

     <?php } ?>
</div></div>
<div class="hp_title fl">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>推荐职位</div>
     <div class="hp_title_rt fr"><a href="<?php echo smarty_function_listurl(array('type'=>'tp','v'=>2),$_smarty_tpl);?>
" target="_blank">查看更多>></a></div>
</div>
<div class="hp_recommend fl">
     <ul>
         <?php  $_smarty_tpl->tpl_vars['rec_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rec_list']->_loop = false;
$rec_list = $rec_list; if (!is_array($rec_list) && !is_object($rec_list)) { settype($rec_list, 'array');}
foreach ($rec_list as $_smarty_tpl->tpl_vars['rec_list']->key => $_smarty_tpl->tpl_vars['rec_list']->value) {
$_smarty_tpl->tpl_vars['rec_list']->_loop = true;
?>
         <li>
             <div class="hp_recommend_top fl">
                  <div class="hp_recommend_top_ft fl"><a href="<?php echo $_smarty_tpl->tpl_vars['rec_list']->value['job_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['rec_list']->value['name_n'];?>
</a></div>
                  <div class="hp_recommend_top_rt fr"><?php if ($_smarty_tpl->tpl_vars['rec_list']->value['job_salary']!='面议') {?>￥<?php }
echo $_smarty_tpl->tpl_vars['rec_list']->value['job_salary'];?>
</div>
             </div>
             <div class="hp_recommend_d fl"><?php echo mb_substr($_smarty_tpl->tpl_vars['rec_list']->value['job_city_two'],0,4,"gbk");?>
 <?php echo mb_substr($_smarty_tpl->tpl_vars['rec_list']->value['job_city_three'],0,4,"gbk");?>
<i class="index_line">|</i><?php echo $_smarty_tpl->tpl_vars['rec_list']->value['job_exp'];?>
经验<i class="index_line">|</i><?php echo $_smarty_tpl->tpl_vars['rec_list']->value['job_edu'];?>
学历</div>
             <div class="hp_recommend_company fl"><a href="<?php echo $_smarty_tpl->tpl_vars['rec_list']->value['com_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['rec_list']->value['com_n'];?>
</a> 
			 <?php if ($_smarty_tpl->tpl_vars['rec_list']->value['ratlogo']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['rec_list']->value['ratlogo'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['rec_list']->value['ratname'];?>
"/><?php }?> 
			 <?php if ($_smarty_tpl->tpl_vars['rec_list']->value['yyzz_status']==1) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/disc_icon10.png" title="认证企业"/><?php }?>
			 </div>
         </li>
         <?php } ?>
     </ul>
</div>
<div class="hp_title fl">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>最新职位</div>
     <div class="hp_title_rt fr"><a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search'),$_smarty_tpl);?>
" target="_blank">查看更多>></a></div>
</div>
<div class="hp_newjob fl">
     <ul>
        <?php  $_smarty_tpl->tpl_vars['new_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['new_list']->_loop = false;
$new_list = $new_list; if (!is_array($new_list) && !is_object($new_list)) { settype($new_list, 'array');}
foreach ($new_list as $_smarty_tpl->tpl_vars['new_list']->key => $_smarty_tpl->tpl_vars['new_list']->value) {
$_smarty_tpl->tpl_vars['new_list']->_loop = true;
?>
        <li>
            <div class="hp_newjob_top fl">
                 <div class="hp_newjob_top_ft fl"><a href="<?php echo $_smarty_tpl->tpl_vars['new_list']->value['job_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['new_list']->value['name_n'];?>
</a></div>
                 <div class="hp_newjob_top_rt fr"><?php echo $_smarty_tpl->tpl_vars['new_list']->value['time'];?>
</div>
            </div>
            <div class="hp_newjob_m fl"><i class="hp_newjob_m_r"><?php if ($_smarty_tpl->tpl_vars['new_list']->value['job_salary']!='面议') {?>￥<?php }
echo $_smarty_tpl->tpl_vars['new_list']->value['job_salary'];?>
</i> <?php echo $_smarty_tpl->tpl_vars['new_list']->value['job_exp'];?>
经验/<?php echo $_smarty_tpl->tpl_vars['new_list']->value['job_edu'];?>
学历</div>
            <div class="hp_newjob_company fl"><a href="<?php echo $_smarty_tpl->tpl_vars['new_list']->value['com_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['new_list']->value['com_n'];?>
</a> 
			<?php if ($_smarty_tpl->tpl_vars['new_list']->value['ratlogo']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['new_list']->value['ratlogo'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['new_list']->value['ratname'];?>
"/><?php }?> 
			<?php if ($_smarty_tpl->tpl_vars['new_list']->value['yyzz_status']==1) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/disc_icon10.png" title="认证企业"/><?php }?>
			</div>
        </li>
        <?php } ?>
     </ul>
</div>
<div class="hp_title fl">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>人才推荐</div>
     <div class="hp_title_rt fr"><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'search'),$_smarty_tpl);?>
" target="_blank">查看更多>></a></div>
</div>
<div class="hp_people fl">
     <ul>
         <?php  $_smarty_tpl->tpl_vars['ulist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ulist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$ulist = $ulist; if (!is_array($ulist) && !is_object($ulist)) { settype($ulist, 'array');}
foreach ($ulist as $_smarty_tpl->tpl_vars['ulist']->key => $_smarty_tpl->tpl_vars['ulist']->value) {
$_smarty_tpl->tpl_vars['ulist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['ulist']->key;
?>
         <li>
             <div class="hp_people_box">
              <div class="hp_people_box_rt fl"><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$ulist.id`'),$_smarty_tpl);?>
" target="_blank"><img width="80" height="100"    src="<?php echo $_smarty_tpl->tpl_vars['ulist']->value['photo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" /><i class="hp_people_box_rt_bg"></i></a></div>
                  <div class="hp_people_box_ft fl">
                       <div class="hp_people_box_ft_nm"><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$ulist.id`'),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ulist']->value['username_n'];?>
</a></div>
                  
                       <div class="hp_people_box_ft_v"><?php echo $_smarty_tpl->tpl_vars['ulist']->value['exp_n'];?>
经验<i class="index_line">|</i><?php echo $_smarty_tpl->tpl_vars['ulist']->value['edu_n'];?>
学历</div>
                            <div class="hp_people_box_ft_y">意向：<?php echo $_smarty_tpl->tpl_vars['ulist']->value['job_post_n'];?>
</div>
                  </div>
                 
             </div>
         </li>
         <?php } ?>
     </ul>
</div>
<div class="hp_title fl">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>职场资讯</div>
     <div class="hp_title_rt fr"><a href="<?php echo smarty_function_url(array('m'=>'article'),$_smarty_tpl);?>
" target="_blank">查看更多>></a></div>
</div>
<div class="hp_news fl">
     <?php  $_smarty_tpl->tpl_vars['plist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['plist']->_loop = false;
 $_smarty_tpl->tpl_vars['pkey'] = new Smarty_Variable;
$plist = $plist; if (!is_array($plist) && !is_object($plist)) { settype($plist, 'array');}
foreach ($plist as $_smarty_tpl->tpl_vars['plist']->key => $_smarty_tpl->tpl_vars['plist']->value) {
$_smarty_tpl->tpl_vars['plist']->_loop = true;
 $_smarty_tpl->tpl_vars['pkey']->value = $_smarty_tpl->tpl_vars['plist']->key;
?>
     <?php if ($_smarty_tpl->tpl_vars['pkey']->value==0) {?>
     <div class="hp_news_t fl">
          <dl>
              <dt><a href="<?php echo $_smarty_tpl->tpl_vars['plist']->value['url'];?>
"><img style="width:302px;height:208px;" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['plist']->value['newsphoto'];?>
"/></a></dt>
              <dd><a href="<?php echo $_smarty_tpl->tpl_vars['plist']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['plist']->value['title'];?>
</a></dd>
          </dl>
     <?php } else { ?>
     <?php if ($_smarty_tpl->tpl_vars['pkey']->value==1) {?><div class="hp_news_w fl"><?php }?>
          <div class="hp_news_w_p fl" <?php if ($_smarty_tpl->tpl_vars['pkey']->value==2) {?>style="margin-top:25px;border:none;"<?php }?>>
               <div class="hp_news_p_img fl"><a href="<?php echo $_smarty_tpl->tpl_vars['plist']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['plist']->value['newsphoto'];?>
" width="134" height="92"/></a></div>
               <div class="hp_news_p_wr fl">
                    <div class="hp_news_p_wr_tit"><a href="<?php echo $_smarty_tpl->tpl_vars['plist']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['plist']->value['title'];?>
</a></div>
                    <div class="hp_news_p_ct"><?php echo $_smarty_tpl->tpl_vars['plist']->value['description'];?>
</div>
               </div>
          </div>
     <?php }?>
     <?php if ($_smarty_tpl->tpl_vars['pkey']->value!=1) {?></div><?php }?>
     <?php } ?>
     <div class="hp_news_list fl">
          <ul>
              <?php  $_smarty_tpl->tpl_vars['indexnews'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['indexnews']->_loop = false;
$indexnews = $indexnews; if (!is_array($indexnews) && !is_object($indexnews)) { settype($indexnews, 'array');}
foreach ($indexnews as $_smarty_tpl->tpl_vars['indexnews']->key => $_smarty_tpl->tpl_vars['indexnews']->value) {
$_smarty_tpl->tpl_vars['indexnews']->_loop = true;
?>              
              <li>【<?php echo $_smarty_tpl->tpl_vars['indexnews']->value['name'];?>
】<a class="hp_news_list_cr" href="<?php echo $_smarty_tpl->tpl_vars['indexnews']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['indexnews']->value['title'];?>
</a></li>
              <?php } ?>
          </ul>
     </div>
</div>
<div class="hp_link fl">
<div class="hp_title" style="border-bottom:none;width:1180px;">
     <div class="hp_title_ft fl"><i class="hp_title_icon"></i>友情链接</div>
     <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_linksq']==0) {?><div class="hp_title_rt fr"><a href="<?php echo smarty_function_url(array('m'=>'link'),$_smarty_tpl);?>
">申请链接</a></div><?php }?>
</div>
<div class="hp_link_banner">
     <ul class="hp_link_banner_img">
         <?php  $_smarty_tpl->tpl_vars['linklist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['linklist']->_loop = false;
global $config;
		$domain='';
		if($config["cityid"]!="" || $config["hyclass"]!=""){
			include(PLUS_PATH."/domain_cache.php");
			$host_url=$_SERVER['HTTP_HOST'];
			foreach($site_domain as $v){
				if($v['host']==$host_url){
					$domain=$v['id'];
				}
			}
		}$tem_type = 2;
        include PLUS_PATH."/link.cache.php";
		if(is_array($link)){$linkList=array();
			$i=0;
			foreach($link as $key=>$value)
			{
				if($config["did"]!=0 && $value["did"]!=$config["did"])
				{
					continue;
				}elseif(is_numeric('2') && $value['tem_type']!='2' && $value['tem_type']!='1'){
					continue;

				}elseif((!is_numeric('2') || '2'=='1') && $value['tem_type']!='1'){

					continue;
				}elseif(!$config["did"] && $value["did"]>0){
					continue;
				}
				if(is_numeric('2') && $value['link_type']!='2')
				{
					continue;
				}
				if(is_numeric('') && intval('')<=$i)
				{
					break;
				}
				$value[picurl] = $config[sy_weburl]."/".$value[pic];
				$linkList[] = $value;
				$i++;
			}
		}$linkList = $linkList; if (!is_array($linkList) && !is_object($linkList)) { settype($linkList, 'array');}
foreach ($linkList as $_smarty_tpl->tpl_vars['linklist']->key => $_smarty_tpl->tpl_vars['linklist']->value) {
$_smarty_tpl->tpl_vars['linklist']->_loop = true;
?>
         <li><a href="<?php echo $_smarty_tpl->tpl_vars['linklist']->value['link_url'];?>
" target="_blank"><img style="width:115px;height:30px;" src="<?php echo $_smarty_tpl->tpl_vars['linklist']->value['pic'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['linklist']->value['link_name'];?>
" /></a></li>
         <?php } ?>
     </ul>
     <div class="hp_link_banner_wr">
         <?php  $_smarty_tpl->tpl_vars['linklist2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['linklist2']->_loop = false;
global $config;
		$domain='';
		if($config["cityid"]!="" || $config["hyclass"]!=""){
			include(PLUS_PATH."/domain_cache.php");
			$host_url=$_SERVER['HTTP_HOST'];
			foreach($site_domain as $v){
				if($v['host']==$host_url){
					$domain=$v['id'];
				}
			}
		}$tem_type = 2;
        include PLUS_PATH."/link.cache.php";
		if(is_array($link)){$linkList=array();
			$i=0;
			foreach($link as $key=>$value)
			{
				if($config["did"]!=0 && $value["did"]!=$config["did"])
				{
					continue;
				}elseif(is_numeric('2') && $value['tem_type']!='2' && $value['tem_type']!='1'){
					continue;

				}elseif((!is_numeric('2') || '2'=='1') && $value['tem_type']!='1'){

					continue;
				}elseif(!$config["did"] && $value["did"]>0){
					continue;
				}
				if(is_numeric('1') && $value['link_type']!='1')
				{
					continue;
				}
				if(is_numeric('') && intval('')<=$i)
				{
					break;
				}
				$value[picurl] = $config[sy_weburl]."/".$value[pic];
				$linkList[] = $value;
				$i++;
			}
		}$linkList = $linkList; if (!is_array($linkList) && !is_object($linkList)) { settype($linkList, 'array');}
foreach ($linkList as $_smarty_tpl->tpl_vars['linklist2']->key => $_smarty_tpl->tpl_vars['linklist2']->value) {
$_smarty_tpl->tpl_vars['linklist2']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['linklist2']->value['link_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['linklist2']->value['link_name'];?>
</a>
         <?php } ?>
     </div>
</div>
</div>
</div>
<div class="tip_bottom" >
  <div class="tip_bottom_bg">
    <div class="tip_bottom_main" >
    <div class="tip_bottom_icon png"></div>
      <div class="tip_bottom_left fl">
        <a href="javascript:void(0);" onclick="$('.tip_bottom').hide();" class="tip_bottom_close png"></a>
        <span class="tip_bottom_logo fl">
          <h2>发现更多新的职位信息</h2>
        </span>
        <div class="tip_bottom_num fl"><span>0</span>公司</div>
        <div class="tip_bottom_num fl"><span>0</span>职位</div>
        <div class="tip_bottom_num fl"><span>0</span>简历数</div>
        <a href="<?php echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);?>
" class="tip_bottom_login fl">登录</a>
        <a href="<?php echo smarty_function_url(array('m'=>'register','usertype'=>1),$_smarty_tpl);?>
" class="tip_bottom_reg fl" >快速注册<i class="tip_bottom_reg_icon"></i></a>
      </div>
    </div>
  </div>
</div>
      <div id="bg"></div>
      <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/backtop.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

      <div id='footer_ad'> <?php  $_smarty_tpl->tpl_vars['footer_ad'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['footer_ad']->_loop = false;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[10];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 0;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars['footer_ad']->key => $_smarty_tpl->tpl_vars['footer_ad']->value) {
$_smarty_tpl->tpl_vars['footer_ad']->_loop = true;
?>
        <div class="footer_ban" id="">
          <div class="baner_footer" id='bottom_ad_fl'> <span class="ban_close" onclick="colse_bottom()">关闭</span> <?php echo $_smarty_tpl->tpl_vars['footer_ad']->value['html'];?>
 </div>
          <input type="hidden" value='1' id='bottom_ad_is_show' />
        </div>
        <?php } ?>
        <?php  $_smarty_tpl->tpl_vars['left_ad'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['left_ad']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$AdArr=array();$paramer=array();
			include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[11];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 0;$length = 0;
				foreach($add_arr as $key=>$value){
					if(($value['did']==$config['did'] ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars['left_ad']->key => $_smarty_tpl->tpl_vars['left_ad']->value) {
$_smarty_tpl->tpl_vars['left_ad']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['left_ad']->key;
?>
        <div class="duilian <?php if ($_smarty_tpl->tpl_vars['key']->value=='0') {?>duilian_left<?php } else { ?>duilian_right<?php }?>">
          <div class="duilian_con"><?php echo $_smarty_tpl->tpl_vars['left_ad']->value['html'];?>
</div>
          <div class="close_container">
            <div class="btn_close"></div>
          </div>
        </div>
        <?php } ?> </div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/index.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/reg_ajax.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/banner.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/slides.jquery.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="http://static.geetest.com/static/tools/gt.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
//顶部伸展广告
if ($("#js_ads_banner_top_slide").length){  //判断当前广告是否展开，如果没有，则执行下面代码
	var $slidebannertop = $("#js_ads_banner_top_slide"),$bannertop = $("#js_ads_banner_top");
	setTimeout(function(){$bannertop.slideUp(1000);$slidebannertop.slideDown(1000);},1500); //1500毫秒(1.5秒)后，小广告收回，大广告伸开，执行时间都是1秒(1000毫秒)
	setTimeout(function(){$slidebannertop.slideUp(1000,function (){$bannertop.slideDown(1000);});},2000); //2.0秒(2000毫秒)之后，大广告收回，小广告展开。
}
$("#slides").slides({
		preload: true,
		preloadImage: '<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/loading.gif',
		play: 5000,
		pause: 2500,
		hoverPause: true
	});
$(document).ready(function() {
    //首页登录框以及登录后显示各会员中心内容
	var loginIndex='<?php echo smarty_function_url(array('m'=>'ajax','c'=>'DefaultLoginIndex'),$_smarty_tpl);?>
';
    $.get(loginIndex,function(data){
		$(".hp_login").html(data);
	});
    $(".index_new_job li").hover(function(){
		var aid=$(this).attr("aid");
		$("#joblist"+aid).addClass("index_new_job_hover");	
	},function(){
		var aid=$(this).attr("aid");
		$("#joblist"+aid).removeClass("index_new_job_hover");	
	})   
	$(".menu_box").hover(function(){
		var aid=$(this).attr("aid");
		var ftop=Number($(this).offset().top); 
		var sheight=Number($("#jobclass_"+aid).height());  
		if(aid=='0'){ 
			$("#jobclass_"+aid).css("top","0px"); 
		}else if(sheight>ftop){ 
			$("#jobclass_"+aid).css("top","0px"); 
		}else if(ftop>sheight&&Number(sheight)<250){  
			var isIE6=!window.XMLHttpRequest;
			if (isIE6){
				var top=Number(ftop)-Number(99);
			}else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/9./i)=="9."){
				var top=Number(ftop)-Number(94);
			}else{ 
				var top=Number(ftop)-Number(94);
			}  
			$("#jobclass_"+aid).css("top",top+"px"); 
 		}else if(Number(sheight)>250){ 
			var top=Number(ftop)-Number(320);
			$("#jobclass_"+aid).css("top",top+"px"); 
		} 
		$("#jobclass"+aid).addClass("current");	
		$("#jobclass_"+aid).attr("class","menu_sub db");
	},function(){
		var aid=$(this).attr("aid");
		$("#jobclass"+aid).removeClass("current");	
		$("#jobclass_"+aid).attr("class","menu_sub dn");	
	})  
	$(".select_wrap").hover(function(){
		$(".select_wrap_list").show();
	},function(){
		$(".select_wrap_list").hide();
	})  
	
	$.get('<?php echo smarty_function_url(array('m'=>'ajax','c'=>'footertj'),$_smarty_tpl);?>
',function(data){
		$('.tip_bottom_left').html(data)
	});
});


<?php echo '</script'; ?>
> 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
