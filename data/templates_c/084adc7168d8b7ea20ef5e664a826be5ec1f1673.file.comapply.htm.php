<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 22:39:01
         compiled from "D:\phpStudy\WWW\uploads\app\template\default\job\comapply.htm" */ ?>
<?php /*%%SmartyHeaderCode:87159ce5b05705112-68445414%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '084adc7168d8b7ea20ef5e664a826be5ec1f1673' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\default\\job\\comapply.htm',
      1 => 1501490214,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '87159ce5b05705112-68445414',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'style' => 0,
    'config' => 0,
    'Info' => 0,
    'stop' => 0,
    'entype' => 0,
    'usertype' => 0,
    'userid_job' => 0,
    'uid' => 0,
    'favjob' => 0,
    'wlist' => 0,
    'comclass_name' => 0,
    'langlist' => 0,
    'pre' => 0,
    'report_job' => 0,
    'job' => 0,
    'city_type' => 0,
    'v' => 0,
    'city_name' => 0,
    'city_index' => 0,
    'job_type' => 0,
    'job_name' => 0,
    'job_index' => 0,
    'keylist' => 0,
    'job_jia' => 0,
    'usertypemsg' => 0,
    'arr_data' => 0,
    'j' => 0,
    'userdata' => 0,
    'userclass_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce5b05cd9eb3_84886809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce5b05cd9eb3_84886809')) {function content_59ce5b05cd9eb3_84886809($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_listurl')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.listurl.php';
if (!is_callable('smarty_function_ad')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.ad.php';
?><?php global $db,$db_config,$config;
		$time = time();
		
		
        eval('$paramer=array("uid"=>"\'@Info.uid\'","noid"=>"\'@Info.id\'","namelen"=>"9","limit"=>"3","item"=>"\'job\'","nocache"=>"")
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
		 
		$job = $db->select_all("company_job",$where.$limit);
		if(is_array($job)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($job as $key=>$value){
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
			foreach($job as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$job[$key] = $db->array_action($value,$cache_array);
				$job[$key][stime] = date("Y-m-d",$value[sdate]);
				$job[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$job[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$job[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);
				if($value[minsalary]&&$value[maxsalary]){
					$job[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
				}elseif($value[minsalary]){
					$job[$key][job_salary] =$value[minsalary]."以上";
				}else{
                    $job[$key][job_salary] ="面议";
                }
				
				$job[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
				$job[$key][logo] =$r_uid[$value['uid']][logo];
				$job[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$job[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$job[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				$time=$value['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$job[$key]['time'] ="一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$job[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$job[$key]['time'] = date("H:i",$value['lastupdate']);
					$job[$key]['redtime'] =1;
				}else{
					$job[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($job[$key]['welfare'])&&$job[$key]['welfare']){
					foreach($job[$key]['welfare'] as $val){
						$job[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$job[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$job[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$job[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$job[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$job[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$job[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$job[$key][color] = str_replace("#","",$v[com_color]);
						$job[$key][ratlogo] = $v[com_pic];
						$job[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$job[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$job[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$job[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job[$key][name_n]);
					$job[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job[$key][com_n]);
					$job[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$job[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
    			}
			}

			if(is_array($job)){
				if($paramer[keyword]!=""&&!empty($job)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php global $db,$db_config,$config;
		$time = time();
		
		
        eval('$paramer=array("limit"=>"4","rec"=>"1","noid"=>"\'@Info.id\'","jobids"=>"\'@Info.job1\'","namelen"=>"6","item"=>"\'job_jia\'","key"=>"\'key\'","nocache"=>"")
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
		 
		$job_jia = $db->select_all("company_job",$where.$limit);
		if(is_array($job_jia)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($job_jia as $key=>$value){
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
			foreach($job_jia as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$job_jia[$key] = $db->array_action($value,$cache_array);
				$job_jia[$key][stime] = date("Y-m-d",$value[sdate]);
				$job_jia[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$job_jia[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$job_jia[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);
				if($value[minsalary]&&$value[maxsalary]){
					$job_jia[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
				}elseif($value[minsalary]){
					$job_jia[$key][job_salary] =$value[minsalary]."以上";
				}else{
                    $job_jia[$key][job_salary] ="面议";
                }
				
				$job_jia[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
				$job_jia[$key][logo] =$r_uid[$value['uid']][logo];
				$job_jia[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$job_jia[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$job_jia[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				$time=$value['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$job_jia[$key]['time'] ="一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$job_jia[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$job_jia[$key]['time'] = date("H:i",$value['lastupdate']);
					$job_jia[$key]['redtime'] =1;
				}else{
					$job_jia[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($job_jia[$key]['welfare'])&&$job_jia[$key]['welfare']){
					foreach($job_jia[$key]['welfare'] as $val){
						$job_jia[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$job_jia[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$job_jia[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$job_jia[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$job_jia[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$job_jia[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$job_jia[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$job_jia[$key][color] = str_replace("#","",$v[com_color]);
						$job_jia[$key][ratlogo] = $v[com_pic];
						$job_jia[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$job_jia[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$job_jia[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$job_jia[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job_jia[$key][name_n]);
					$job_jia[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job_jia[$key][com_n]);
					$job_jia[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$job_jia[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
    			}
			}

			if(is_array($job_jia)){
				if($paramer[keyword]!=""&&!empty($job_jia)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"/>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/comapply.css" type="text/css"/>
</head>
<body class="body_bg">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="yun_content">
  <div class="current_Location png"> 您当前的位置：<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">首页</a> > <a href="<?php echo smarty_function_url(array('m'=>'job'),$_smarty_tpl);?>
">职位列表</a> > 职位详情 </div>
  <div class="clear"></div>
  
  <div class="comappiy_left_box fl">
  <div class="Company_post_box">
   <div class="Company_post_top fl">
        <div class="Company_post_name fl"> <h1 class="Company_post_name_h1"><?php echo $_smarty_tpl->tpl_vars['Info']->value['jobname'];?>
</h1> 
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['urgent_time']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobjp.png" title="紧急招聘" class="Company_post_name_img"><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['xuanshang']&&$_smarty_tpl->tpl_vars['Info']->value['xsdate']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobtj.png"  title="置顶职位"class="Company_post_name_img"><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['rec_time']>time()) {?><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/jobtj.png" title="站长推荐" class="Company_post_name_img"><?php }?> </div>

        <div class="Company_post_State"> <?php if ($_smarty_tpl->tpl_vars['Info']->value['minsalary']&&$_smarty_tpl->tpl_vars['Info']->value['maxsalary']) {?>
          <span class="Company_Basic_information_xz">￥<?php echo $_smarty_tpl->tpl_vars['Info']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['Info']->value['maxsalary'];?>
</span> 
          <?php } elseif ($_smarty_tpl->tpl_vars['Info']->value['minsalary']) {?><span class="Company_Basic_information_xz"><?php echo $_smarty_tpl->tpl_vars['Info']->value['minsalary'];?>
以上</span>
          <?php } else { ?><span class="Company_Basic_information_xz">面议</span>
          <?php }?><span class="Company_post_State_s"> <span class="com_gx">更新于：</span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['Info']->value['lastupdate'],"%Y-%m-%d");?>
</span> </div>
		<div>
          <div class="stamp_exceed"> <?php if ($_smarty_tpl->tpl_vars['stop']->value=='1') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/stamp.png" title="已下架"> <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['entype']->value=='1') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/stamp_gq.png" title="已过期"> <?php }?> </div>
        </div>
      
         <?php if ($_smarty_tpl->tpl_vars['stop']->value!='1'&&$_smarty_tpl->tpl_vars['entype']->value!='1') {?>
   <div class="Company_post_td"> 
		<?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
			<?php if ($_smarty_tpl->tpl_vars['userid_job']->value) {?> 
				<a  class="Company_post_td_ysq" rel="nofollow">已申请</a>
			<?php } else { ?> 
				<a id="sq_job" href="javascript:;" class="Company_post_td_bth" rel="nofollow">投个简历</a>
			<?php }?>
      <?php } else { ?>
		<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?> 
			<a onclick="notuser();" href="javascript:;" class="Company_post_td_bth" rel="nofollow">投个简历</a> 
		<?php } else { ?> 
			<a onclick="applyjobuid();" href="javascript:;" class="Company_post_td_bth" rel="nofollow">投个简历</a> 
		<?php }?>
      <?php }?>
      <div class="Company_post_sub">
	  <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?> 
			<?php if ($_smarty_tpl->tpl_vars['favjob']->value) {?>
			<a href="javascript:void(0);" class="Company_post_sub_a Company_post_sub_a_ysc" rel="nofollow">已收藏</a> 
			<?php } else { ?>
			<a href="javascript:void(0);" onclick="fav_job('<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','2');" id="favjobid<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
" class="Company_post_sub_a Company_post_sub_a_sc" rel="nofollow">收藏</a> 
			<?php }?>
       <?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?> 
			<a href="javascript:void(0);" onclick="notuser();" class="Company_post_sub_a Company_post_sub_a_sc" rel="nofollow">收藏</a>  
            <?php } else { ?>
			<a href="javascript:void(0);" onclick="showlogin('1');" class="Company_post_sub_a Company_post_sub_a_sc" rel="nofollow">收藏</a>  
        <?php }?>
	<?php }?> 
	<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'recommend','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" target="_blank"  class="Company_post_sub_a Company_post_sub_a_tj" rel="nofollow">推荐</a>
        <div class="com_mok"><a href="javascript:void(0);" onmousemove="$('#getwapurl').show();" onmouseout="$('#getwapurl').hide();" class="Company_post_sub_a Company_post_sub_a_wx"  rel="nofollow">微信</a>
          <div class="comapply_sq_r_cy none" id="getwapurl">
            <div class="comapply_sq_r_cont"><i class="comapply_sq_r_cont_icon"></i> 
              <img src="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'pubqrcode','toc'=>'job','toa'=>'share','toid'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" width="130" height="130"/> </div>
			  
          </div>
        </div>
      </div>
    </div>
    <?php }?>
    
        </div>
      </div>
   <div class="comappiy_left_sidebar fl">
    <div class="Company_left_cont">
      <div class="Company_Basic_information">
        <div class="Company_Basic_information_list"> <i class="Company_Basic_information_icon Company_Basic_information_icon_b"></i>
          <div class="Company_Basic_information_r">
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_exp']) {?><span class="Company_Basic_information_l"><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_exp'];?>
经验</span><?php }?>
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_edu']) {?><i class="Company_Basic_information_line">|</i><span class="Company_Basic_information_l"><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_edu'];?>
学历</span><?php }?>
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_report']) {?><i class="Company_Basic_information_line">|</i><span class="Company_Basic_information_l"><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_report'];?>
到岗</span> <?php }?>
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_age']) {?><i class="Company_Basic_information_line">|</i><span class="Company_Basic_information_l">年龄<?php echo $_smarty_tpl->tpl_vars['Info']->value['job_age'];?>
</span><?php }?>
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['sex']) {?><i class="Company_Basic_information_line">|</i><span class="Company_Basic_information_l">性别<?php echo $_smarty_tpl->tpl_vars['Info']->value['sex'];?>
</span> <?php }?>
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_marriage']) {?><i class="Company_Basic_information_line">|</i><span class="Company_Basic_information_l">婚况<?php echo $_smarty_tpl->tpl_vars['Info']->value['job_marriage'];?>
</span><?php }?>
           <span class="Company_Basic_information_sm">（对求职者的要求）</span></div>
        </div>
        <div class="Company_Basic_information_list"><i class="Company_Basic_information_icon Company_Basic_information_icon_c"></i>
          <div class="Company_Basic_information_r">
           <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_city_one']||$_smarty_tpl->tpl_vars['Info']->value['job_city_two']||$_smarty_tpl->tpl_vars['Info']->value['job_city_three']) {?> 
           <?php echo $_smarty_tpl->tpl_vars['Info']->value['job_city_one'];?>
-<?php echo $_smarty_tpl->tpl_vars['Info']->value['job_city_two'];
if ($_smarty_tpl->tpl_vars['Info']->value['job_city_three']) {?>-<?php echo $_smarty_tpl->tpl_vars['Info']->value['job_city_three'];?>

           <?php }
}
if ($_smarty_tpl->tpl_vars['Info']->value['job_number']) {?><i class="Company_Basic_information_line">|</i><span class="Company_Basic_information_l">招聘<?php echo $_smarty_tpl->tpl_vars['Info']->value['job_number'];?>
</span> <?php }?>
            <i class="Company_Basic_information_line">|</i><?php echo $_smarty_tpl->tpl_vars['Info']->value['edate'];?>
结束招聘
             </div>
        </div> 
        <?php if ($_smarty_tpl->tpl_vars['Info']->value['welfare_info']) {?>
         <div class="Company_Basic_information_list"> <i class="Company_Basic_information_icon Company_Basic_information_icon_f"></i>
          <div class="Company_Basic_information_r"> 
       
        <?php  $_smarty_tpl->tpl_vars['wlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['wlist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['welfare']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['wlist']->key => $_smarty_tpl->tpl_vars['wlist']->value) {
$_smarty_tpl->tpl_vars['wlist']->_loop = true;
?> 
        <span class="yun_com_fl_dy yun_com_fl_dy_cor"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['wlist']->value];?>
</span><?php } ?> </div>
      
        </div> 
         <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['Info']->value['lang_info']) {?>
        <div class="clear"></div>
        <div class="Company_Basic_information_list"> <i class="Company_Basic_information_icon Company_Basic_information_icon_e"></i>
          <div class="Company_Basic_information_r">
            <div class="Company_Basic_information_r_y"> <?php  $_smarty_tpl->tpl_vars['langlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['langlist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['lang']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['langlist']->key => $_smarty_tpl->tpl_vars['langlist']->value) {
$_smarty_tpl->tpl_vars['langlist']->_loop = true;
?> <span class="yun_com_fl_dy "><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['langlist']->value];?>
</span> <?php } ?> </div>
          </div>
        </div>
        <?php }?> 
		<?php if ($_smarty_tpl->tpl_vars['Info']->value['address']) {?> 
        <div class="Company_Basic_information_list"> <i class="Company_Basic_information_icon Company_Basic_information_icon_d"></i>
          <div class="Company_Basic_information_r"><?php echo $_smarty_tpl->tpl_vars['Info']->value['address'];?>
 
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['y']!=''&&$_smarty_tpl->tpl_vars['Info']->value['x']!='') {?> <a href="javascript:showmap('map_show');" class="Company_Basic_information_map" rel="nofollow">查看上班路线</a> 
          <div class="frc_map">  
          </div>
          <?php }?></div>
        </div>
		<?php }?> 
		<?php if ($_smarty_tpl->tpl_vars['config']->value['com_login_link']=='1') {?>
		<div class="Company_Basic_information_list"> <i class="Company_Basic_information_icon Company_Basic_information_icon_g"></i>
          <div class="Company_Basic_information_r">
		<?php if ($_smarty_tpl->tpl_vars['Info']->value['linktel']) {?><span class="Company_Basic_information_tel"><?php echo $_smarty_tpl->tpl_vars['Info']->value['linktel'];?>
</span><?php }?> 

         <?php if ($_smarty_tpl->tpl_vars['Info']->value['linkman']) {?> ( <?php echo $_smarty_tpl->tpl_vars['Info']->value['linkman'];?>
 ) <?php }?>
		</div></div>

		<?php } elseif ($_smarty_tpl->tpl_vars['Info']->value['is_link']=='1'&&$_smarty_tpl->tpl_vars['Info']->value['linktel']&&$_smarty_tpl->tpl_vars['config']->value['com_login_link']!='2') {?>
        <div class="Company_Basic_information_list"> <i class="Company_Basic_information_icon Company_Basic_information_icon_g"></i>
          <div class="Company_Basic_information_r">
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['linktel']) {?><span class="Company_Basic_information_tel"><?php echo $_smarty_tpl->tpl_vars['Info']->value['linktel'];?>
</span><?php }?> 
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['linkman']) {?> ( <?php echo $_smarty_tpl->tpl_vars['Info']->value['linkman'];?>
 ) <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['linktel']) {
if ($_smarty_tpl->tpl_vars['Info']->value['is_link']=='1') {?>
          
          <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
             <a href="javascript:void(0)" onclick="showtel('<?php echo $_GET['id'];?>
');" class="Company_Basic_information_hm">显示号码</a>
          <?php } else { ?>
             <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
             <a href="javascript:void(0);" onclick="layer.msg('只有个人用户才能查看', 2, 8)" class="Company_Basic_information_hm">显示号码</a> 		
             <?php } else { ?>
             <a href="javascript:void(0);"  onclick="showlogin('1');" class="Company_Basic_information_hm">显示号码</a> 
             <?php }?>
          <?php }?>
          <?php }?>
          
          <?php }?>
		  <span class="Company_Basic_information_sm">(联系时请说明是在<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
上看到的)</span></div>
        </div>
		<?php }?>
		
        </div>
    </div>
    <div class="Company_post_msg"><i class="Company_h1_line yun_bg_color"></i><i class="Company_h1_line_bor"></i><span class="Company_co">职位描述</span></div>
    <div class="Company_content fl Company_toggle" id="Company_job_info" >
      <div class="Job_Description"> <?php echo $_smarty_tpl->tpl_vars['Info']->value['description'];?>
 </div>
    </div>
    <div class="clear"></div>
    <div class="job_hr">
    <div class="job_hr_tit">职位发布者</div>
    <div class="job_hr_icon">HR</div>
    <div class="job_hr_left">
   你好！我是企业的HR<a href="javascript:void(0);" class="job_hr_left_ly"></a><br/>想了解更多职位信息请留言给我
    <div class="job_hr_ly_box dn" id="hrmsg"> <div class="Company_post_more" ><i class="Company_post_more_icon"></i>对职位感兴趣 <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?> <a class="comapply_lea_a" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=commsg" target="_blank">
          查看我的咨询>>
          </a> <?php }?> </div>
      <form action="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','a'=>'msg'),$_smarty_tpl);?>
" method="post" target="supportiframe" onsubmit="return com_msg();">
        <div>
          <textarea  class="comapply_Leave_fb_text" name="content" id='msg_content' placeholder='请输入您对该职位的疑问。比如所在地、年薪、福利等等，我会及时给您回复！期待与您合作。'></textarea>
          <input type="hidden" name="jobid" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
" />
          <input type="hidden" name="job_uid" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
" />
          <input type="hidden" name="com_name" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['com_name'];?>
" />
          <input type="hidden" name="job_name" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['jobname'];?>
" />
        </div>
		<div class="affirm affirm_yz"> 
			<input class="zx_yx_input fl" id="msg_CheckCode" type="text"  placeholder="请输入验证码" value="" maxlength="4" name="authcode" />
			<img  class="zx_yx_input_img fl" id="vcode_imgs" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" onclick="checkCode('vcode_imgs');"/>
             <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
          <input type="submit" value="提交咨询" name="submit" class="comapply_Leave_fb_sub "/>
          <?php } else { ?>
          <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
          <input type="button" value="提交咨询" onclick="layer.msg('只有个人用户才能咨询', 2, 8)" class="comapply_Leave_fb_sub"/>
          <?php } else { ?>
          <input type="button" value="提交咨询" onclick="showlogin('1');" class="comapply_Leave_fb_sub "/>
          <?php }?>
          <?php }?>
		</div>
        <div class="comapply_Leave_fb_s"> 
       </div>
      </form></div>
      </div>
    <div class="job_hr_right">
    <div class="job_hr_list"><span class="job_hr_list_n"><?php echo '<script'; ?>
 src="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','a'=>'GetHits','id'=>$_tmp1),$_smarty_tpl);?>
"><?php echo '</script'; ?>
> <em class="job_hr_list_dw">次</em></span>职位被浏览</div>
    <div class="job_hr_list"><span class="job_hr_list_n"><?php echo $_smarty_tpl->tpl_vars['Info']->value['snum'];?>
 <em class="job_hr_list_dw">份</em></span>简历投递</div>
    <div class="job_hr_listbig"><span class="job_hr_list_n"><?php echo $_smarty_tpl->tpl_vars['pre']->value;?>
 <em class="job_hr_list_dw">%</em></span>简历平均回复率</div>
    <div class="job_hr_listbig job_hr_listbig_end"><span class="job_hr_list_n"><?php echo $_smarty_tpl->tpl_vars['Info']->value['operatime'];?>
</span>简历平均回复时长</div>
    </div>
    <div class="job_hare"> 
	<span class="job_hare_fl">分享到：</span> 
    <span >
	    
		  
		
			<div class="pyshare bdsharebuttonbox bdshare-button-style0-16" data-tag="share_1">
				<a class="li s1 bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
				<a class="li s2 bds_renren" data-cmd="renren" title="分享到人人网"></a>
				<a class="li s3 bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
				<a class="li s4 bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
				<a class="li s5 bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
				<a class="li s6 bds_weixin" data-cmd="weixin" title="分享到微信"></a>
				<div class="clear"></div>
			</div>
		
		  
		 
		  
      </span>
       </div>
       </div>
  
        
        
    </div>

	<div  class="job_show_tip">
		<span class="job_show_tip_tip_i fl">!</span>
            <div class="job_show_tip_p">
            特别申明：
           <p><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_shenming'];?>

		   <?php if ($_smarty_tpl->tpl_vars['config']->value['user_report']==1) {?>
				<?php if ($_smarty_tpl->tpl_vars['usertype']->value=='1') {?>
					<?php if ($_smarty_tpl->tpl_vars['report_job']->value) {?>
				<a class="job_show_tip_cr" >您已举报该职位</a> 
					<?php } else { ?>
					您还可以<a href="javascript:void(0)" class="job_show_tip_cr" onclick="report_com();" rel="nofollow">举报此职位</a> 
					<?php }?>
				<?php } elseif ($_smarty_tpl->tpl_vars['uid']->value) {?>
					您还可以<a href="javascript:void(0)" class="job_show_tip_cr" rel="nofollow" onclick="notuser();">举报此职位</a> 
				<?php } else { ?>
					您还可以<a href="javascript:void(0)" class="job_show_tip_cr" onclick="showlogin('1');" rel="nofollow">举报此职位</a>
				<?php }?>
			<?php }?>
			</p>
		</div>  
	</div>
   <div class="comappiy_left_sidebar mt20 fl">
  
    <div class="Company_post_msg m10"><i class="Company_h1_line  yun_bg_color"></i><i class="Company_h1_line_bor"></i><span class="Company_co">公司简介</span></div>
    <div class="Company_content fl">
      <div class="Company_Profile" style="padding-bottom:0px;">
	  <?php if ($_smarty_tpl->tpl_vars['Info']->value['content']) {?>
        <div style="width:100%;height:auto; overflow:hidden" id="job_content">
        <?php echo $_smarty_tpl->tpl_vars['Info']->value['content'];?>

        </div>
        <div class="company_show_more none"><a href="javascript:;" onclick="showcc()">查看更多</a></div>
        <?php } else { ?>
		<div class="evaluate_pj_no">该职位尚未填写公司简介! </div>
		<?php }?>
		</div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="comappiy_left_sidebar mt20">
     <div class="Company_post_msg"><i class="Company_h1_line yun_bg_color"></i><i class="Company_h1_line_bor"></i><span class="Company_co">该公司的其TA职位</span></div>
 <ul class="comappiy_left_c_list">
        <?php  $_smarty_tpl->tpl_vars['job'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job']->_loop = false;
$job = $job; if (!is_array($job) && !is_object($job)) { settype($job, 'array');}
foreach ($job as $_smarty_tpl->tpl_vars['job']->key => $_smarty_tpl->tpl_vars['job']->value) {
$_smarty_tpl->tpl_vars['job']->_loop = true;
?>
        <li>
         <div class="comappiy_left_jobname"><a href="<?php echo $_smarty_tpl->tpl_vars['job']->value['job_url'];?>
" target="_blank" class="yun_text_color"><?php echo $_smarty_tpl->tpl_vars['job']->value['name'];?>
</a> </div>
        
        <div class="comappiy_left_sidebar_otherjob_x"> 
		<?php echo $_smarty_tpl->tpl_vars['job']->value['job_city_one'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['job']->value['job_city_two'];?>

        <?php if ($_smarty_tpl->tpl_vars['job']->value['job_salary']) {?><span class="comappiy_left_sidebar_otherjob_line">|</span>薪水：<span class="Company_other_fd8"><?php echo $_smarty_tpl->tpl_vars['job']->value['job_salary'];?>
</span><?php }?>
        <?php if ($_smarty_tpl->tpl_vars['job']->value['job_edu']) {?><span class="comappiy_left_sidebar_otherjob_line">|</span>学历：<?php echo $_smarty_tpl->tpl_vars['job']->value['job_edu'];
}?>
        <?php if ($_smarty_tpl->tpl_vars['job']->value['job_exp']) {?><span class="comappiy_left_sidebar_otherjob_line">|</span>经验：<?php echo $_smarty_tpl->tpl_vars['job']->value['job_exp'];
}?>
          </div>
          <a class="comappiy_left_sidebar_otherjob_sq" href="<?php echo $_smarty_tpl->tpl_vars['job']->value['job_url'];?>
" target="_blank">查看</a>
          </li>
        <?php } ?>
        <?php if (!$_smarty_tpl->tpl_vars['job']->value) {?>
        <div class="comappiy_left_jobname_mag">暂无其他职位</div>
        <?php }?>
  </ul>
	
    <div class="maincenters">
      <div id="sortBoxs">
        <div class="search_menuBoxs">
          <ul>
            <li class="search_curs" id="typezb" onmousemove="searchtype('zb');">周边招聘</li>
            <li id="typezp" onmousemove="searchtype('zp');">招聘频道</li>
            <li id="typerm" onmousemove="searchtype('rm');">热门搜索</li>
          </ul>
        </div>
        <div class="contentBoxs">
         
        <div class="contentBox_conts " id="type_zb">
        <div class="Industry_lists">
			<?php if ($_smarty_tpl->tpl_vars['Info']->value['three_cityid']) {?>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['Info']->value['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<a href="<?php echo smarty_function_listurl(array('provinceid'=>$_smarty_tpl->tpl_vars['Info']->value['provinceid'],'cityid'=>$_smarty_tpl->tpl_vars['Info']->value['cityid'],'type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
				<?php } ?>
			<?php } elseif ($_smarty_tpl->tpl_vars['Info']->value['cityid']) {?>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['Info']->value['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<a href="<?php echo smarty_function_listurl(array('type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
				<?php } ?>
			<?php } else { ?>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<a href="<?php echo smarty_function_listurl(array('type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
				<?php } ?>
			<?php }?>
        </div>
        </div>
          
          <div class="contentBox_conts none" id="type_zp" >
           <div class="Industry_lists">
			  <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_post']) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['Info']->value['job1_son']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_listurl(array('job1'=>$_smarty_tpl->tpl_vars['Info']->value['job1'],'job1_son'=>$_smarty_tpl->tpl_vars['Info']->value['job1_son'],'type'=>'job_post','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php } elseif ($_smarty_tpl->tpl_vars['Info']->value['job1_son']) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['Info']->value['job1']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_listurl(array('job1'=>$_smarty_tpl->tpl_vars['Info']->value['job1'],'type'=>'job1_son','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php } else { ?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_listurl(array('type'=>'job1','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php }?>
          </div> </div>
          
          <div class="contentBox_conts none" id="type_rm">
            <div class="Industry_lists">
                <?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;eval('$paramer=array("limit"=>"20","recom"=>"1","type"=>"3","item"=>"\'keylist\'","nocache"=>"")
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
?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a> 
                <?php } ?>
          </div> </div>
         
        </div>
      </div>
    </div>

    
    
  </div>
  </div>
  
  <div class="Compply_right_sidebar">
    <div class="Compply_right_qy">
      <div class="Compply_logo"> <img src="<?php echo $_smarty_tpl->tpl_vars['Info']->value['logo'];?>
" width="185" height="75" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_unit_icon'];?>
',2);"/> </div>
      <div class="Compply_right_name"> <a href="<?php echo $_smarty_tpl->tpl_vars['Info']->value['com_url'];?>
" target="_blank" class=""><?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['com_name'],0,13,'gbk');?>
</a>
	  <?php if ($_smarty_tpl->tpl_vars['Info']->value['yyzz_status']=='1') {?>
	  <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/disc_icon10.png" title="营业执照已审核" class="png"/>
	  <?php }?></div>
      <div class="clear"></div>
      <div class="Compply_right_js">
        <ul>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_hy']) {?>
          <li><span class="Compply_right_span_c"><i class="Compply_right_icon Compply_right_icon_hy"></i><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_hy'];?>
</span></li>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_pr']) {?>
          <li><span class="Compply_right_span_c"><i class="Compply_right_icon Compply_right_icon_xz"></i><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_pr'];?>
</span> </li>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['com_city']) {?>
          <li><span class="Compply_right_span_c"><i class="Compply_right_icon Compply_right_icon_city"></i><?php echo $_smarty_tpl->tpl_vars['Info']->value['com_city'];?>
</span></li>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['job_mun']) {?>
          <li><span class="Compply_right_span_c"><i class="Compply_right_icon Compply_right_icon_rs"></i><?php echo $_smarty_tpl->tpl_vars['Info']->value['job_mun'];?>
</span></li>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['Info']->value['money']) {?>
          <li><span class="Compply_right_span_c"><i class="Compply_right_icon Compply_right_icon_zj"></i><?php echo $_smarty_tpl->tpl_vars['Info']->value['money'];?>
万</span></li>
          <?php }?>
            
        </ul>
      </div>	</div>

    <div class="Compply_right_post">
         <div class="Company_post_msg"><i class="Company_h1_line yun_bg_color"></i><i class="Company_h1_line_bor"></i><span class="Company_co">相似职位</span></div>
      
      <?php  $_smarty_tpl->tpl_vars['job_jia'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job_jia']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$job_jia = $job_jia; if (!is_array($job_jia) && !is_object($job_jia)) { settype($job_jia, 'array');}
foreach ($job_jia as $_smarty_tpl->tpl_vars['job_jia']->key => $_smarty_tpl->tpl_vars['job_jia']->value) {
$_smarty_tpl->tpl_vars['job_jia']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['job_jia']->key;
?>
      <div class="Company_other_job">
          <ul><li>
          <div><a href="<?php echo $_smarty_tpl->tpl_vars['job_jia']->value['job_url'];?>
" class="Company_other_name yun_text_color" style="font-size:16px;"><?php echo $_smarty_tpl->tpl_vars['job_jia']->value['name'];?>
</a><br>
          <span class="company_ct"><?php if ($_smarty_tpl->tpl_vars['job_jia']->value['job_city_one']) {?>工作城市：<?php echo $_smarty_tpl->tpl_vars['job_jia']->value['job_city_one'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['job_jia']->value['job_city_two'];?>
</span> <br>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['job_jia']->value['job_salary']) {?>  薪水：<span class="Company_other_fd8"><?php echo $_smarty_tpl->tpl_vars['job_jia']->value['job_salary'];?>
</span><?php }?></div>
          </li>
          </ul>
      </div>
      <?php } ?>
      <?php if (!$_smarty_tpl->tpl_vars['job_jia']->value) {?>
      <div class="Company_other_no_msg" style="font-size:14px;padding:30px 0;float:left">暂无相似职位</div>
      <?php }?> </div>
      <div class="Compply_right_banner fl"><?php echo smarty_function_ad(array('cid'=>27,'id'=>58),$_smarty_tpl);?>
</div>
  </div>
  
</div>
<div id="sqjob_show" class="Pop-up_logoin none" style="background:none;">
  <div class="Pop-up_logoin_sq"> <span>职位名称：</span><em class="yun_red"><?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['jobname'],0,14,'gbk');?>
</em> </div>
  <div class="Pop-up_logoin_sq"> <span>公司名称： </span><em><?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['com_name'],0,14,'gbk');?>
</em> </div>
  <div class="Pop-up_logoin_sq" id="resume_job"> <span>选择简历：</span>
    <div class="POp_up_r"></div>
  </div>
  <div class="Pop-up_logoin_sq" style="clear:both"> <span>&nbsp;</span>
    <input id="companyname" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['com_name'];?>
"/>
    <input id="jobname" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['jobname'];?>
"/>
    <input id="companyuid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
"/>
    <input id="jobid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
"/>
    <input id="click_sq" class="login_button2" type="button" value="提交申请" name="Submit"/>
  </div>
</div>
<div class="none" id="jobreport">
  <div class="Pop-up_logoin  Pop-up_logoin_pad" style="background:none;padding: 10px 20px 20px;">
    <div class="Pop-up_logoin_jb" style="margin-bottom:15px;">举报原因</div>
    <input id="r_uid" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
" type="hidden"/>
    <input id="id" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
" type="hidden"/>
    <input id="r_name" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['com_name'];?>
" type="hidden"/>
    <div class="Pop-up_logoin_sq" style="margin-bottom:10px;"> <em>
      <textarea class="Pop-cottextarea" rows="2" cols="38" id="r_reason" style="width:338px;height:60px;"></textarea>
      </em> </div>
    <div class="Pop-up_logoin_sq" style="margin-bottom:10px;"> <span class=" Pop-up_logoin_jb_span" style="width:80px;">验 证 码： </span>
      <input type="text" class="Pop-cottextarea_text" id="report_authcode" style="float:left; margin-right:5px;" maxlength="4"/>
      <img id="vcodeimg" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" /> 
      <a href="javascript:void(0);" onclick="checkCode('vcodeimg');">看不清?</a></div>
    <div class="Pop-up_logoin_sq"> <span>&nbsp;</span>
      <input class="login_button_jb" type="button" value="举报"  onclick="reportSub('vcodeimg');"/>
    </div>
  </div>
</div>   

<div id="notuser" style="width:350px;" class="none">
<div class="job_user_box">
<div class="job_user_name" style="margin-top:10px;"><?php echo $_smarty_tpl->tpl_vars['usertypemsg']->value;?>
</div>
<div class="job_user_name_tip" style="margin-top:10px;margin-bottom:15px;padding:0;">请登录个人用户</div>
<div style="margin-bottom:20px;"><a href="javascript:void(0)" onclick="layer.closeAll()" class="job_user_box_hn">忽略</a><a href="javascript:void(0)" style="margin-left:10px;" onclick="switching('<?php echo smarty_function_url(array('c'=>'logout'),$_smarty_tpl);?>
')" class="job_user_box_qh">切换账户</a></div>
</div>
</div>
<div id="map_show" class="none">
  <div id="map_container" style="width:580px;height:350px;"></div>
</div>
<div id="tel_show" class="none">
 <div class="jobtel_box">
   <div class="jobtel_box_tel">
   <div class="jobtel_touch_box">
   <div class="jobtel_touch_box_wx">
      <div class="jobtel_box_wx_gz">关注微信公众号</div>
   <div class="jobtel_box_wx">申请结果早知道</div>
     <div class="jobtel_box_wxewm"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
" width="100" height="100"></div>
      <div class="jobtel_box_bot"></div>
   </div>
    <div class="jobtel_box_tip">联系时请说明是在<span class="jobtel_box_tip_name"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</span>上看到的</div> 

 <!--   有简历的情况-->
    <div class="jobtel_box_t_box">
    <i class="jobtel_box_t_box_icon"></i> 
    <div class="jobtel_box_t_hrl">
	
<div class="jobtel_touch_hr" id='linkman'> 
<?php echo $_smarty_tpl->tpl_vars['Info']->value['linkman'];?>

</div>
<div class="jobtel_touch"><span id='linktel'><?php echo $_smarty_tpl->tpl_vars['Info']->value['linktel'];?>
</span></div>

<div class="jobtel_box_t_box_cj_tip none" id='addresume'></div>
</div> </div>

<div class="jobtel_touch_p none" id='linkqq'></div>

<div class="jobtel_touch_p" id='busstops'></div>
 <!--   有简历的情况 end-->

 </div> 
</div>
  </div>
  </div>
  </div>
</div>

<div id="applydiv" class="none">
<div class="yun_reg_BasicInfo">
    <div class="yun_reg_BasicInfo_h1"> <span class="yun_reg_BasicInfo_h1_span yun_text_color">10秒填写简历好工作轻松搞定！</span> <em class="yun_reg_BasicInfo_h1_em">已有账号，立即<a href="javascript:void(0);" onclick="OnLogin();" class="yun_reg_BasicInfo_h1_bth yun_bg_color">登录</a></em> </div>
    <div class="yun_reg_BasicInfo_box">
   <div class="yun_reg_BasicInfo_left">
        <div class="yun_reg_BasicInfo_list"><span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>真实姓名：</span>
          <input type="text"  name="uname" id="uname" class="yun_reg_BasicInfo_text yun_reg_BasicInfo_text_w155"/>
                  
          	<input type="hidden" id="sex" name="sex" value="1" />
              <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arr_data']->value['sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			  <?php if ($_smarty_tpl->tpl_vars['j']->value!=3) {?><span class="yun_info_sex <?php if ($_smarty_tpl->tpl_vars['j']->value==1) {?>yun_info_sex_cur<?php }?>" id="sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" onclick="checksex('<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
')"><i class="usericon_sex usericon_sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
"></i><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span><?php }?>                     
              <?php } ?>     
          </div>
        <div class="yun_reg_BasicInfo_list"> <span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>出生年月：</span>
          <div class="yun_reg_BasicInfo_l_r yun_reg_BasicInfo_l_date">
            <input type="button" value="1988-08-08" name="birthday" id="birthday" class="yun_reg_BasicInfo_date_text"/>
          </div>
        </div>
        <div class="yun_reg_BasicInfo_list"><span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>最高学历：</span>
          <div class="yun_reg_BasicInfo_l_r z-index100">
            <input type="button" value="请选择" class="yun_reg_BasicInfo_but" id="educ" onclick="search_show('job_educ');"/>
            <input type="hidden" id="educid" name="edu" />
            <i class="yun_reg_BasicInfo_list_icon"></i>
            <div class="yun_reg_BasicInfo_l_box none" id="job_educ">
              <ul class="yun_reg_BasicInfo_text_list">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <li> <a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','educ','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');" rel="nofollow"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="yun_reg_BasicInfo_list"><span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>工作经验：</span>
          <div class="yun_reg_BasicInfo_l_r  z-index90">
            <input type="button" value="请选择" class="yun_reg_BasicInfo_but" id="exp" onclick="search_show('job_exp');"/>
            <input type="hidden" id="expid" name="exp" />
            <i class="yun_reg_BasicInfo_list_icon"></i>
            <div class="yun_reg_BasicInfo_l_box none" id="job_exp">
              <ul class="yun_reg_BasicInfo_text_list">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','exp','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="yun_reg_BasicInfo_list"><span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>工作性质：</span>
          <div class="yun_reg_BasicInfo_l_r  z-index60">
            <input type="button" value="请选择" class="yun_reg_BasicInfo_but" id="type" onclick="search_show('job_type');"/>
            <input type="hidden" id="typeid" name="type"/>
            <i class="yun_reg_BasicInfo_list_icon"></i>
            <div class="yun_reg_BasicInfo_l_box none" id="job_type">
              <ul class="yun_reg_BasicInfo_text_list">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
', 'type', '<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');" rel="nofollow"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="yun_reg_BasicInfo_list"><span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>到岗时间：</span>
          <div class="yun_reg_BasicInfo_l_r  z-index50">
            <input type="button" value="请选择" class="yun_reg_BasicInfo_but" id="report" onclick="search_show('job_report');"/>
            <input type="hidden" id="reportid" name="report"/>
            <i class="yun_reg_BasicInfo_list_icon"></i>
            <div class="yun_reg_BasicInfo_l_box none" id="job_report">
              <ul class="yun_reg_BasicInfo_text_list">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
', 'report', '<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
		<div class="yun_reg_BasicInfo_list"><span class="yun_reg_BasicInfo_s"><i class="yun_reg_BasicInfo_i">*</i>手机号码：</span>
          <input type="text" name="telphone" id="telphone" onblur="ckjobreg('1')" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="yun_reg_BasicInfo_text"/>
		</div>
	
        </div>
      <div class="yun_reg_BasicInfo_bot" style="margin-top:10px;">
        <input type="button" value="立即申请" class="yun_reg_BasicInfo_bth" onclick="checkaddresume('<?php echo smarty_function_url(array('m'=>'ajax','c'=>'temporaryresume'),$_smarty_tpl);?>
');"/>
      </div>
    </div>
  </div>
</div>

<div class="none" id="userregdiv">
  <div class="yun_reg_box">
    <div class="yun_reg_list_tip_s">保存成功；离完成只差一步</div>
    <div class="yun_reg_Switching_box">
      <ul class="yun_reg_list">
        <li class="mt20"><em><font color="#FF0000">*</font> 密&nbsp;&nbsp;码：</em> <span id="pass1">
          <input type="password" class="yun_reg_text"id="reg_password"/>
        </span> </li>
        <li class="m10"><em><font color="#FF0000">*</font> 验证码：</em>
          <input  type="text" class="yun_reg_text_yz" maxlength="4" id="reg_authcode"/>
          <img id="vcodeimgs" class="authcode" onclick="checkCode('vcodeimgs');" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php"/>
        </li>
        <li class="mt10"><em>&nbsp;</em>
          <input type="hidden" id="resumeid"/>
          <input type="button" value="保存" class="yun_reg_submit" onclick="checkreg('vcodeimgs','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'userreg'),$_smarty_tpl);?>
');"/>
        </li>
      </ul>
    </div>
  </div>
</div>

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
/js/lazyload.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/company.js" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/member_public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $_smarty_tpl->tpl_vars['config']->value['map_key'];?>
" charset="utf-8"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/map.js" language="javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/css/font-awesome.min.css" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/foundation-datepicker.min.js"><?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png');
<?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
>
$('#birthday').fdatepicker({format: 'yyyy-mm-dd',startView:4,minView:2}); 
$(function() {
	$(".job_hr_left_ly").click(function(){
		$("#hrmsg").show(500);
	});
	$("#hrmsg").hover(function(){
		$("#hrmsg").show();
	},function(){
	   $("#hrmsg").hide(500);
	});
	var cheight=$("#job_content").height();
	if(parseInt(cheight)>270){
	    $("#job_content").attr('style','width:100%;height:270px; overflow:hidden');
		$(".company_show_more").show();
	}
});
function showcc(){
    $("#job_content").attr('style','width:100%;height:auto; overflow:hidden');
	$(".company_show_more").find('a').html('收起');
	$(".company_show_more").find('a').attr('onclick','hidecc()');
}
function hidecc(){
    $("#job_content").attr('style','width:100%;height:270px; overflow:hidden');
	$(".company_show_more").find('a').html('查看更多');
	$(".company_show_more").find('a').attr('onclick','showcc()');
}
function showmap(id) {
	$.layer({
		type: 1,
		title: '地图展示',
		closeBtn: [0, true],
		offset: ['100px', ''],
		border: [10, 0.3, '#000', true],
		area: ['580px', 'auto'],
		page: { dom: "#" + id }
	});
	getmapshowcont('map_container', "<?php echo $_smarty_tpl->tpl_vars['Info']->value['x'];?>
", "<?php echo $_smarty_tpl->tpl_vars['Info']->value['y'];?>
", "<?php echo $_smarty_tpl->tpl_vars['Info']->value['com_name'];?>
", "<?php echo $_smarty_tpl->tpl_vars['Info']->value['address'];?>
");
}
function checksm(){
	$('#shenming').hide();
	$("#smtext").show();
}
function searchtype(id){
	$(".search_curs").removeClass("search_curs");
	$("#type"+id).addClass("search_curs");
	$(".contentBox_conts").hide();
	$("#type_"+id).show();
}
function subsm(id){
	var shenming=$("#smname").val();
	$.post(weburl+"/index.php?m=job&c=shenming",{id:id,shenming:shenming},function(data){
		if(data){
			location.reload();
		}
	});
}
function showtel(id){
    var loadi = layer.load('请稍后...',0);
	$.post(weburl+"/job/?c=comapply&a=gettel",{id:id},function(data){
	    layer.close(loadi);
		if(data==0){
			layer.msg('暂未开放联系方式，请直接投递简历！', 2, 8);

		}else if(data==2){
		
			layer.msg('只有求职者才能查看企业联系方式！', 2, 8);

		}else{

			$('#linkman').html(data.linkman);
			if(data==1){
				$('#addresume').html('花1分钟填个简历，联系电话任意看   <a href="<?php echo smarty_function_url(array('m'=>'member','c'=>'expect'),$_smarty_tpl);?>
" target=\'_blank\' class="jobtel_box_t_box_cj">立即创建</a>');
				$('#addresume').show();
			}else{
				var data=eval('('+data+')');
				$('#linktel').html(data.linktel);
				if(data.linkqq){
					
					$('#linkqq').html('联系Q Q：'+data.linkqq+' <a target="_blank" href="tencent://message/?uin='+data.linkqq+'&Site=<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
&Menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:'+data.linkqq+':13" alt="点击这里给我发消息"></a>');
					$('#linkqq').show();
				}
				if(data.busstops){
					$('#busstops').html(data.busstops);
					$('#busstops').show();
				}
			}
			$.layer({
					type: 1,
					title: '联系方式',
					closeBtn: [0, true],
					offset: ['100px', ''],
					border: [10, 0.3, '#000', true],
					area: ['450px', 'auto'],
					page: { dom: "#tel_show"}
			});
		}

		
	});
}

<?php echo '</script'; ?>
>
 <!--------shareJS--------->
<?php echo '<script'; ?>
>
	window._bd_share_config = {
		common : {
			bdText : '<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
',
			bdDesc : '<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
',	
			bdUrl : '<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
',
			bdPic : '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
'
		},
		share : [{
			"tag" : "share_1",
			"bdSize" : 24,
			"bdCustomStyle":'<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/share.css'
		}]
	}
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
<?php echo '</script'; ?>
>
<!--------shareJS END--------->
<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" class="none"></iframe>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
