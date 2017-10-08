<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:50:28
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\user\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:1224859cdb4f47c8145-18087118%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5aec818dc4a69c1c9be3ab7ba3d1d2aeca509fb3' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\user\\index.htm',
      1 => 1492512554,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1224859cdb4f47c8145-18087118',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'resume' => 0,
    'user_photo' => 0,
    'config' => 0,
    'username' => 0,
    'statis' => 0,
    'yqnum' => 0,
    'lookNum' => 0,
    'ainfo' => 0,
    'alist' => 0,
    'rlist' => 0,
    'resumelist' => 0,
    'uid' => 0,
    'blist' => 0,
    'userclass_name' => 0,
    'userdata' => 0,
    'v' => 0,
    'time' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdb4f4a74d72_85545534',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdb4f4a74d72_85545534')) {function content_59cdb4f4a74d72_85545534($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php global $db,$db_config,$config;
		$time = time();
		
		
        eval('$paramer=array("jobwhere"=>"\'auto.jobwhere\'","namelen"=>"19","comlen"=>"13","limit"=>"100","item"=>"\'blist\'","nocache"=>"")
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
		 
		$blist = $db->select_all("company_job",$where.$limit);
		if(is_array($blist)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($blist as $key=>$value){
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
			foreach($blist as $key=>$value){
				if($paramer[bid]){
					$noids[] = $value[id];
				}
				$blist[$key] = $db->array_action($value,$cache_array);
				$blist[$key][stime] = date("Y-m-d",$value[sdate]);
				$blist[$key][etime] = date("Y-m-d",$value[edate]);
				if($arr_data['sex'][$value['sex']]){
    				$blist[$key][sex_n]=$arr_data['sex'][$value['sex']];
    			}
				$blist[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);
				if($value[minsalary]&&$value[maxsalary]){
					$blist[$key][job_salary] =$value[minsalary]."-".$value[maxsalary];
				}elseif($value[minsalary]){
					$blist[$key][job_salary] =$value[minsalary]."以上";
				}else{
                    $blist[$key][job_salary] ="面议";
                }
				
				$blist[$key][yyzz_status] =$r_uid[$value['uid']][yyzz_status];
				$blist[$key][logo] =$r_uid[$value['uid']][logo];
				$blist[$key][pr_n] =$r_uid[$value['uid']][pr_n];
				$blist[$key][hy_n] =$r_uid[$value['uid']][hy_n];
				$blist[$key][mun_n] =$r_uid[$value['uid']][mun_n];
				$time=$value['lastupdate'];
				$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
				$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					$blist[$key]['time'] ="一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					$blist[$key]['time'] ="昨天";
				}elseif($time>$beginToday){	
					$blist[$key]['time'] = date("H:i",$value['lastupdate']);
					$blist[$key]['redtime'] =1;
				}else{
					$blist[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($blist[$key]['welfare'])&&$blist[$key]['welfare']){
					foreach($blist[$key]['welfare'] as $val){
						$blist[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$blist[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$blist[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$blist[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$blist[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$blist[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$blist[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$blist[$key][color] = str_replace("#","",$v[com_color]);
						$blist[$key][ratlogo] = $v[com_pic];
						$blist[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$blist[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$blist[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$blist[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$blist[$key][name_n]);
					$blist[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$blist[$key][com_n]);
					$blist[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$blist[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
    			}
			}

			if(is_array($blist)){
				if($paramer[keyword]!=""&&!empty($blist)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 

<div id="bg" <?php if ($_smarty_tpl->tpl_vars['resume']->value['name']=='') {?>style="display:block"<?php }?>></div>
<div class="yun_user_member_w1100" >
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="index_no_resume_box" id="yingdao" <?php if ($_smarty_tpl->tpl_vars['resume']->value['name']!='') {?>style="display:none;"<?php }?>>
   
      <div class="index_no_resume_cont">
       
        <div class="index_no_resume_p"> 
         <div class="index_no_resume_h1">请先填写简历信息</div>为了更快的找到工作，需填写个人简历！</div>
        <div class="index_no_resume_p2"><a href="javascript:Close_yd();">知道了</a></div>
      </div>
    </div>
 
<div class="index_mian_right fltR"> 
<div class="yun_user_index_info">
<div class="yun_user_index_info_box">
<div class="yun_user_index_info_photo"><a href="index.php?c=uppic"> 
    <?php if ($_smarty_tpl->tpl_vars['resume']->value['sex']==1) {?>
    <img src=".<?php echo $_smarty_tpl->tpl_vars['user_photo']->value;?>
" border="0" height="100" width="80" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);"/>
    <?php } else { ?>
    <img src=".<?php echo $_smarty_tpl->tpl_vars['user_photo']->value;?>
" border="0" height="100" width="80" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_iconv'];?>
',2);"/>
     <?php }?>     
 <div class="yun_user_index_info_photo_bg"></div></a></div>
<div class="yun_user_index_info_right">
<div class="yun_user_index_info_username">你好！<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</div>
<div class="yun_user_rz_cont"> 
<a href="index.php?c=binding"> 
<?php if ($_smarty_tpl->tpl_vars['resume']->value['moblie_status']!='1') {?>
<span class="yun_user_rz_box yun_user_rz_sj"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">未验证</em></span>
<?php } else { ?>
<span class="yun_user_rz_box yun_user_rz_sj"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">已验证</em></span>
<?php }?> 
<?php if ($_smarty_tpl->tpl_vars['resume']->value['email_status']!='1') {?>
<span class="yun_user_rz_box yun_user_rz_yx"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">未绑定</em></span>
<?php } else { ?>
<span class="yun_user_rz_box yun_user_rz_yx"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">已绑定</em></span>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['resume']->value['idcard_status']!='1') {?>
<span class="yun_user_rz_box yun_user_rz_sf"><i class="yun_user_rz_no_icon"></i><em class="yun_user_rz_no">未验证</em></span>
<?php } else { ?>
<span class="yun_user_rz_box yun_user_rz_sf"><i class="yun_user_rz_yes_icon"></i><em class="yun_user_rz_yes">已验证</em></span>
<?php }?>
</a>
</div>
<div class="yun_user_info_bg"><a href="index.php?c=info" class="yun_user_info_bg_a">编辑基本信息</a></div>
</div>
</div>
<div class="yun_user_indexpay">
<span class="yun_user_indexpay_l">我的<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：<em class="yun_user_indexpay_e"><?php echo $_smarty_tpl->tpl_vars['statis']->value['integral'];?>
</em><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</span>
<a href="index.php?c=pay" class="yun_user_indexpay_a">充值</a>
<a href="index.php?c=integral" class="yun_user_indexpay_a">赚<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a>
<a href="<?php echo smarty_function_url(array('m'=>'redeem'),$_smarty_tpl);?>
" class="yun_user_indexpay_a">兑换礼品</a>
</div>
</div>
<div class="yun_user_index_jobmsg">
<div class="yun_user_index_jobmsg_tit">求职信息</div>
<div class="yun_user_index_jobmsg_list"><a href="index.php?c=msg"><div class="yun_user_index_jobmsg_list_n"><?php if ($_smarty_tpl->tpl_vars['yqnum']->value=='') {?>0<?php } else { ?><i class="member_Information_amount_n_c"><?php echo $_smarty_tpl->tpl_vars['yqnum']->value;?>
</i><?php }?></div>面试通知</a></div>
<div class="yun_user_index_jobmsg_list"><a href="index.php?c=job"><div class="yun_user_index_jobmsg_list_n"><?php if ($_smarty_tpl->tpl_vars['statis']->value['sq_jobnum']<1) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['sq_jobnum'];
}?></div>申请记录</a></div>
<div class="yun_user_index_jobmsg_list"><a href="index.php?c=favorite" title="职位收藏"><div class="yun_user_index_jobmsg_list_n"><?php if ($_smarty_tpl->tpl_vars['statis']->value['fav_jobnum']<1) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['statis']->value['fav_jobnum'];
}?></div>收藏记录</a></div>
<div class="yun_user_index_jobmsg_list yun_user_index_jobmsg_list_end"><a href="index.php?c=look"><div class="yun_user_index_jobmsg_list_n"><?php echo $_smarty_tpl->tpl_vars['lookNum']->value;?>
</div>谁看了我的简历</a></div>
<div class="yun_user_index_jobmsg_gz  sxl">
<ul class="user_in_gz sxlist">
        <?php  $_smarty_tpl->tpl_vars['alist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['alist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ainfo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['alist']->key => $_smarty_tpl->tpl_vars['alist']->value) {
$_smarty_tpl->tpl_vars['alist']->_loop = true;
?>
        <li>你关注的 <a href="<?php echo smarty_function_url(array('m'=>'company','c'=>'show','id'=>$_smarty_tpl->tpl_vars['alist']->value['uid']),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['alist']->value['com_name'];?>
</a> 发布了<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>$_smarty_tpl->tpl_vars['alist']->value['id']),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['alist']->value['name'];?>
</a> 职位</li>
        <?php } ?>
    </ul>
    </div>
</div>
    <div class="member_right_box member_right_box_bor mt20 fltL">
   
    <div class="member_right_index_h1 fltL"> <span class="member_right_h1_span fltL">我的简历</span> <i class="member_right_h1_icon user_bg"></i></div>
    <?php  $_smarty_tpl->tpl_vars['resumelist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['resumelist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['resumelist']->key => $_smarty_tpl->tpl_vars['resumelist']->value) {
$_smarty_tpl->tpl_vars['resumelist']->_loop = true;
?>
    <div class="member_index_resume_box" id="resumelist<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['id']!=$_smarty_tpl->tpl_vars['resume']->value['def_job']) {?>style ="display:none;" <?php }?>>
      <div class="member_index_resume_t">
        <div class="member_index_resume_t_left">
          <div class="member_index_resume_t_name fltL">
            <div class="member_index_resume_t_name_l fltL"> 简历名称：</div>
            <div class="index_resume_my_n" id="show_resume" onclick="show_resume('resume_expect<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
')"> <?php echo $_smarty_tpl->tpl_vars['resumelist']->value['resumelist'];?>
 </div>
            <div class="index_resume_my_ll">被浏览：<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['hits'];?>
 次 
             <?php if ($_smarty_tpl->tpl_vars['resume']->value['status']==2) {?> 
             <span class="yun_user_index_r_yc">隐藏</span> 
             <?php } else { ?>
            <span class="yun_user_index_r_gk">公开</span> 
            <?php }?>  
            <a href="index.php?c=privacy" class="cblue">设置</a> 
            </div>
          </div>
          <div class="member_index_resume_t_wz fltL">
            <div class="member_index_resume_t_name_l fltL"> 简历完整度：</div>
            <div class="member_index_resume_t_wzd"> <span class="member_index_resume_t_wz_b"> <em class="ember_index_resume_t_wz_c" style="width:<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['integrity'];?>
%"></em> </span> <span class="member_index_resume_t_wz_n"><?php echo $_smarty_tpl->tpl_vars['resumelist']->value['integrity'];?>
%</span> </div>
          </div>
         <div class="member_index_resume_job fltL">

         <span class="member_index_resume_t_name_l fltL">期望职位：</span><span class="member_index_resume_jobname"><?php echo $_smarty_tpl->tpl_vars['resumelist']->value['jobname'];?>
</span>
         <span class="member_index_resume_jobxz">期望薪资：<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['user_salary'];?>
</span>
         <span class="member_index_resume_time">更新时间：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['resumelist']->value['lastupdate'],"%Y-%m-%d %H:%M:%S");?>
</span></div>

        </div>
        <div class="member_index_resume_t_cz fltR">

          <a href="javascript:void(0)" onclick="resumetop('<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['topdate'];?>
','<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['name'];?>
')" class="member_index_resume_t_cz_bth member_index_resume_t_cz_bth_hover ">简历置顶</a> <a href="index.php?c=expect<?php if ($_smarty_tpl->tpl_vars['resumelist']->value['doc']) {?>q<?php }?>&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
" class="member_index_resume_t_cz_bth ">修改简历</a> <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>$_smarty_tpl->tpl_vars['resumelist']->value['id']),$_smarty_tpl);?>
" target="_blank" class="member_index_resume_t_cz_bth ">预览简历</a> <a onclick="layer_del('确定要刷新？', 'index.php?c=resume&act=refresh&id=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
');" href="javascript:void(0)" class="member_index_resume_t_cz_bth ">刷新简历</a> </div>
      </div>
      <?php if (($_smarty_tpl->tpl_vars['resumelist']->value['edu']==0||$_smarty_tpl->tpl_vars['resumelist']->value['training']==0||$_smarty_tpl->tpl_vars['resumelist']->value['skill']==0||$_smarty_tpl->tpl_vars['resumelist']->value['work']==0||$_smarty_tpl->tpl_vars['resumelist']->value['project']==0||$_smarty_tpl->tpl_vars['resumelist']->value['other']==0)&&!$_smarty_tpl->tpl_vars['resumelist']->value['doc']) {?>
      <div class="member_index_resume_msg">
      
        <div class="member_index_resume_msg_r">
          <div class="member_index_resume_msg_r_t"> 您还有以下资料没有填写 <span class="member_index_resume_msg_span">（为了更快的找到工作，建议您立即完善简历！）</span> </div>
		  <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['work']==0) {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#work_upbox" class="member_index_resume_msg_a">+ 工作经历</a><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['edu']==0) {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#edu_upbox" class="member_index_resume_msg_a">+ 教育经历</a><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['training']==0) {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#training_upbox" class="member_index_resume_msg_a">+ 培训经历</a><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['skill']==0) {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#skill_upbox" class="member_index_resume_msg_a">+ 职业技能</a><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['project']==0) {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#project_upbox" class="member_index_resume_msg_a">+ 项目经验</a><?php }?>
          <?php if ($_smarty_tpl->tpl_vars['resumelist']->value['other']==0) {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#other_upbox" class="member_index_resume_msg_a">+ 其他信息</a><?php }?> 
		  <?php if ($_smarty_tpl->tpl_vars['resume']->value['description']=='') {?><a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
#description_upbox" class="member_index_resume_msg_a">+ 自我评价</a><?php }?></div>
      </div>
      <?php }?> </div>
    <?php }
if (!$_smarty_tpl->tpl_vars['resumelist']->_loop) {
?>
    <div class="member_index_no_resume">
      <p class="">你还没有创建简历，无法申请职位</p>
      <a href="index.php?c=expect&add=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" class="member_index_no_resume_a">创建简历</a> </div>
    <?php } ?> 
	</div>
	
     <div class="member_right_box_banner fltL" style="width:100%; overflow:hidden"></div>
	 
 
    <div class="member_right_box member_right_box_bor  mt20 fltL">
    <div class="member_right_index_h1 fltL"><i class="member_right_h1_icon user_bg"></i> <span class="member_right_h1_span fltL">合适的工作</span>  
	  </div>
    <?php if (empty($_smarty_tpl->tpl_vars['rlist']->value)) {?> 
    <div class="member_right_no_job">
      <div class="member_right_no_job_box ">
        <div class="member_right_no_jobl">！ </div>
        <div class="member_right_no_jobr"> 创建简历以后，系统会根据您的简历，<br>
          通过后台算法为您匹配最适合您的招聘职位<br>
          <a href="index.php?c=expect&add=<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" class="cblue" style="text-decoration:underline">创建简历</a> </div>
      </div>
    </div>
	
    <?php } else { ?>
    <div class="member_right_job_box">
      <ul id="joblist">
        <?php  $_smarty_tpl->tpl_vars['blist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blist']->_loop = false;
$blist = $blist; if (!is_array($blist) && !is_object($blist)) { settype($blist, 'array');}
foreach ($blist as $_smarty_tpl->tpl_vars['blist']->key => $_smarty_tpl->tpl_vars['blist']->value) {
$_smarty_tpl->tpl_vars['blist']->_loop = true;
?>
          <li> <a href="<?php echo $_smarty_tpl->tpl_vars['blist']->value['job_url'];?>
" class="member_right_job_box_name cblue"><?php echo $_smarty_tpl->tpl_vars['blist']->value['name_n'];?>
</a> <span class="member_right_job_xz"><?php echo $_smarty_tpl->tpl_vars['blist']->value['job_salary'];?>
</span> <a href="<?php echo $_smarty_tpl->tpl_vars['blist']->value['com_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['blist']->value['com_n'];?>
</a> </li>
        <?php }
if (!$_smarty_tpl->tpl_vars['blist']->_loop) {
?>
        <div class="member_right_no_job">
          <div class="member_right_no_job_box ">
            <div class="member_right_no_jobl">！ </div>
            <div class="member_right_no_jobr" style="margin-top:30px; font-size:22px;"> 没有适合的职位 </div>
          </div>
        </div>
        <?php } ?>
      </ul>
    </div>
    <?php }?> 
     </div>
</div>
<div class="clear">	</div>
</div>


<div id="shuaxin" class="" style="display:none;">
<div class="sx_pd">
<div class="sx_top">
<dl>
   <dt></dt>
   <dd>
       <div>今天还没刷新，刷新简历将<em class="sx_bot_or">简历排名提前</em><br/>让企业更容易看到你，<em class="sx_bot_or">提高求职成功率！</em></div>
       <div class="sx_top_t">
            <em class="sx_top_t_tt">刷新前请确认以下信息准确完整：</em>
            <p>手机号码：<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
</p>
            <p>上次刷新时间：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['resumelist']->value['lastupdate'],"%Y-%m-%d %H:%M:%S");?>
</p>
            <div style="height:40px;">
            <div id="jobstatuslist"><p>求职状态：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resumelist']->value['jobstatus']];?>
 <a class="sx_top_t_xg"  href="#">修改</a></p></div>
			<div id="jobstatusupadte" style="display:none;">
			<span class="fl">求职状态：</span>
			<input style="float:left;" type="hidden" id="id" value="<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
">
			<div class="news_expect_text  news_expect_text_re5">
			<input type="button" id="jobstatus" onclick="search_show('job_jobstatus');"  value="<?php if ($_smarty_tpl->tpl_vars['resumelist']->value['jobstatus']) {
echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resumelist']->value['jobstatus']];
} else { ?>请选择<?php }?>" class="news_expect_bth_button" >
			<input type="hidden" id="jobstatusid" name="jobstatus" value="<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['jobstatus'];?>
" />
			<div class="news_expect_text_box news_expect_text_box_200" style="display:none" id="job_jobstatus">
			<ul class="news_expect_text_box_list">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
					<li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
', 'jobstatus', '<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');" class="yun_resume_popup_chose_cont_a"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
			<?php } ?></ul></div>
			</div></div>
			</div>
	  </div>
    </dd>
</dl>
</div>
</div>
<div class="sx_bot">
     <a class="sx_bot_sx" href="javascript:void(0)" onclick="resumerefresh(<?php echo $_smarty_tpl->tpl_vars['resumelist']->value['id'];?>
);">刷新</a>
     <a class="sx_bot_qx" href="javascript:layer.closeAll();">取消</a>
</div>
</div>
			
<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function(){
		$("#jobstatuslist").show();
		$("#jobstatusupadte").hide();
		$(".sx_top_t_xg").click(function(){
			$("#jobstatuslist").hide();
			$("#jobstatusupadte").show();
		});
	});
<?php if ($_smarty_tpl->tpl_vars['resumelist']->value['name']!=''&&$_smarty_tpl->tpl_vars['resumelist']->value['lastupdate']<$_smarty_tpl->tpl_vars['time']->value&&$_COOKIE['exprefresh']!='1') {?>
	$.layer({
		type : 1,
		title : '刷新简历',
		closeBtn : [0 , false],
		border : [10 , 0.3 , '#000', true],
		area : ['500px','333px'],
		page : {dom :"#shuaxin"}
	});
	
<?php }?>

    function Close_yd() {
        $("#yingdao").hide();		
        $("#bg").hide();
    }
	
    function show_resume(id) {
        if($(".index_resume_my_n #" + id).is(':hidden')){
            $(".index_resume_my_n #" + id).css('display', 'block');
        }else{
            $(".index_resume_my_n #" + id).css('display', 'none');
        }
    }
    $(function () {
        $('#show_resume').delegate('span', 'click', function () {
            $(this).parent().click();
        })
    });
    function check_select_resume(id) {
        $(".member_index_resume_box").hide();
        $("#resumelist" + id).show();
        $("#resume_expect" + id).hide();
    }
	
	marquee("2000",".sxl .sxlist");
    function marquee(time,id){
	$(function(){
		var _wrap=$(id);
		var _interval=time;
		var _moving;
		_wrap.hover(function(){
			clearInterval(_moving);
		},function(){
			_moving=setInterval(function(){
			var _field=_wrap.find('li:first');
			var _h=_field.height();
			_field.animate({marginTop:-_h+'px'},800,function(){
			_field.css('marginTop',0).appendTo(_wrap);
			})
		},_interval)
		}).trigger('mouseleave');
	});
}
<?php echo '</script'; ?>
>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
