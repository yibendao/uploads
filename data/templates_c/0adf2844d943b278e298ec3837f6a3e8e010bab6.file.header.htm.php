<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-06 15:46:36
         compiled from "D:\phpStudy\WWW\uploads\\app\template\member\com\header.htm" */ ?>
<?php /*%%SmartyHeaderCode:2321959ce4a46e4b467-26968953%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0adf2844d943b278e298ec3837f6a3e8e010bab6' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\member\\com\\header.htm',
      1 => 1507275869,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2321959ce4a46e4b467-26968953',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce4a46f2d8b9_72977000',
  'variables' => 
  array (
    'config' => 0,
    'com_style' => 0,
    'maplist' => 0,
    'navlist_app' => 0,
    'cookie' => 0,
    'username' => 0,
    'js_def' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce4a46f2d8b9_72977000')) {function content_59ce4a46f2d8b9_72977000($_smarty_tpl) {?><!DOCTYPE span PUBLIC "-//W3C//DTD span 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>企业用户后台管理系统 - <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</title>
<meta http-equiv=Content-Type content="text/span; charset=gb2312"/> 
<meta http-equiv=X-UA-Compatible content="IE=edge"/>
<?php echo '<script'; ?>
>var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js"><?php echo '</script'; ?>
>  
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/member_public.js"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/resume_evaluation.js"><?php echo '</script'; ?>
> 
<link href="<?php echo $_smarty_tpl->tpl_vars['com_style']->value;?>
/images/m_style.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['com_style']->value;?>
/images/user-n2012.css" type="text/css" rel="stylesheet"/>
<meta content="MSHTML 6.00.6000.16939" name=GENERATOR/> 
<?php echo '<script'; ?>
>
function killerrors() {return true;}
window.onerror = killerrors;
var integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
';  
<?php echo '</script'; ?>
>
</head>
<body>
<header>
<div class="header_top_main">
<div class="w1000">
<div class="header_top_main_left">欢迎来到<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
！ </div>

<div class="yun_topNav fr">
<a class="yun_navMore" href="javascript:;">网站导航</a>
<div class="yun_webMoredown" style="display: none;">
      <div class="yun_top_nav_box">   <ul class="yun_top_nav_box_l"><?php  $_smarty_tpl->tpl_vars['maplist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['maplist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;eval('$paramer=array("key"=>"\'key\'","item"=>"\'maplist\'","nocache"=>"")
;');
		include(PLUS_PATH."/navmap.cache.php");$Navlist=array();
		if(is_array($navmap)){
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];
		}
		$Navlist =$navmap[0];
		if(is_array($navmap)){
			foreach($navmap as $k=>$v){
				foreach($Navlist as $key=>$val){
					if($k==$val[id]){
						foreach($v as $kk=>$value){
							if($value[type]=='1'){
								if($config[sy_seo_rewrite]=="1" && $value[furl]!=''){
									$v[$kk][url] = $config[sy_weburl]."/".$value[furl];
								}else{
									$v[$kk][url] = $config[sy_weburl]."/".$value[url];
								}
							}
						}
						$Navlist[$key]['list'][]=$v;
					}
				}
			}
			foreach($Navlist as $key=>$value){
				if($value[type]=='1'){
					if($config[sy_seo_rewrite]=="1" && $value[furl]!=''){
						$Navlist[$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$Navlist[$key][url] = $config[sy_weburl]."/".$value[url];
					}
				}
			}
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['maplist']->key => $_smarty_tpl->tpl_vars['maplist']->value) {
$_smarty_tpl->tpl_vars['maplist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['maplist']->key;
?>
          <li><a href="<?php echo $_smarty_tpl->tpl_vars['maplist']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['maplist']->value['eject']) {?> target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['maplist']->value['name'];?>
</a></li>
        <?php } ?> </ul>                 <ul class="yun_top_nav_box_wx">
               <?php  $_smarty_tpl->tpl_vars['navlist_app'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['navlist_app']->_loop = false;
global $db,$db_config,$config;include(PLUS_PATH."/menu.cache.php");$Navlist=array();
		if(is_array($menu_name)){
            eval('$paramer=array("item"=>"\'navlist_app\'","hovclass"=>"\'nav_list_hover\'","nid"=>"11","nocache"=>"")
;');
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];

			foreach($menu_name[12] as $key=>$val){
				
				if($val['type']=='2'){
					if($config['sy_seo_rewrite']=="1" && $val[furl]!=''){
						$menu_name[12][$key][url] = $val[furl];
					}else{
						$menu_name[12][$key][url] = $val[url];
					}
					$menu_name[12][$key][navclass] = navcalss($val,$paramer[hovclass]);
				}
			}
			foreach($menu_name[1] as $key=>$value){
				if($value[url]=="/"){
					$value[url]="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value[furl]!=''){
						$menu_name[1][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[1][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[1][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[2] as $key=>$value){
                if($value[url]=="/"){
					$value[url]="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value[furl]!=''){
						$menu_name[2][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[2][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[2][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
            $isCurrentFind=false;
			foreach($menu_name[4] as $key=>$value){
                if($value[url]=="/"){
					$value[url]="";
				}
				if($value['type']=='1' && $value[furl]!=''){
					if($config['sy_seo_rewrite']=="1"){
						$menu_name[4][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[4][$key][url] = $config[sy_weburl]."/".$value[url];
					}
				}
                if($isCurrentFind==false){
				    $menu_name[4][$key][navclass] = navcalss($value,$paramer[hovclass]);
                }
                if($menu_name[4][$key][navclass]){
                    $isCurrentFind=true;
                }
			}
			foreach($menu_name[5] as $key=>$value){
                if($value[url]=="/"){
					$value[url]="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value[furl]!=''){
						$menu_name[5][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[5][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[5][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
		}
		if($paramer[nid]){
			$Navlist =$menu_name[$paramer[nid]];
		}else{
			$Navlist =$menu_name[1];
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['navlist_app']->key => $_smarty_tpl->tpl_vars['navlist_app']->value) {
$_smarty_tpl->tpl_vars['navlist_app']->_loop = true;
?>          
            <li> <a class="move_0<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['sort'];?>
"<?php if ($_smarty_tpl->tpl_vars['navlist_app']->value['eject']) {?> target="_blank"<?php }?> href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['name'];?>
</a> </li>
          <?php } ?>
                </ul> </div>
    </div>
  </div>
  <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" class="header_m_tc_home">网站首页</a>
  <?php if ($_smarty_tpl->tpl_vars['cookie']->value['remind_num']>0) {?>
<div class="header_Remind fr header_Remind_hover"> <em class="header_Remind_em "><i class="header_Remind_msg"></i></em>
      <div class="header_Remind_list" style="display:none;">
      <div class="header_Remind_list_a"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=hr" class="fl">职位申请</a>  
      <span class="header_Remind_list_r fr">(<?php echo $_smarty_tpl->tpl_vars['cookie']->value['userid_job'];?>
)</span></div>
      <div class="header_Remind_list_a"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=sysnews"class="fl"> 系统消息</a>  <span class="header_Remind_list_r fr">(<?php echo $_smarty_tpl->tpl_vars['cookie']->value['sysmsg2'];?>
)</span></div>
     <div class="header_Remind_list_a"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=msg"class="fl">求职咨询</a> <span class="header_Remind_list_r fr">(<?php echo $_smarty_tpl->tpl_vars['cookie']->value['commsg'];?>
)</span> </div>
   </div>
</div> 
 <?php }?>
 <a  href="javascript:void(0)"  onclick="logout('index.php?act=logout')" class="header_m_tc">退出</a>
  <span class="header_m_username"><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</span>
</div>
</div>
<div class="header">
  <div class="w1000">
    <div class="header-logo fltL"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_unit_logo'];?>
" class="png" ></a></div>
   <nav>
    <div class="header_mune">
         <ul>
        <li	<?php if ($_smarty_tpl->tpl_vars['js_def']->value==1) {?> class=cur<?php }?>><a href="index.php?c=index">管理首页</a> </li>
        <li	<?php if ($_smarty_tpl->tpl_vars['js_def']->value==2) {?> class=cur<?php }?>><a href="index.php?c=info">企业资料</a> </li>
        <li	<?php if ($_smarty_tpl->tpl_vars['js_def']->value==3) {?> class=cur<?php }?>><a href="index.php?c=job&w=1">招聘管理</a> </li>
        <li	<?php if ($_smarty_tpl->tpl_vars['js_def']->value==5) {?> class=cur<?php }?>><a href="index.php?c=hr">人才管理</a> </li>
        <li	<?php if ($_smarty_tpl->tpl_vars['js_def']->value==4) {?> class=cur<?php }?>><a href="index.php?c=paylogtc">财务管理</a> </li>
        <li	<?php if ($_smarty_tpl->tpl_vars['js_def']->value==7) {?> class=cur<?php }?>><a href="index.php?c=vs">系统设置</a> </li>
      </ul>
      </div>
      </nav>
  </div>
</div>
<div class="clear"></div> 
</header><?php }} ?>
