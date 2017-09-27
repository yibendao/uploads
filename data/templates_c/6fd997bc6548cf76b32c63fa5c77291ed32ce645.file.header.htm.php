<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:22:49
         compiled from "D:\phpStudy\WWW\uploads\\app\template\member\user\header.htm" */ ?>
<?php /*%%SmartyHeaderCode:2330059cbb439669fc8-97796209%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6fd997bc6548cf76b32c63fa5c77291ed32ce645' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\member\\user\\header.htm',
      1 => 1501490222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2330059cbb439669fc8-97796209',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'user_style' => 0,
    'layerv' => 0,
    'maplist' => 0,
    'navlist_app' => 0,
    'cookie' => 0,
    'username' => 0,
    'left' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb4397aa063_88151103',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb4397aa063_88151103')) {function content_59cbb4397aa063_88151103($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>个人用户管理平台 - <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</title>
<meta http-equiv=Content-Type content="text/html; charset=GBK"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta content="MSHTML 6.00.6000.16939" name="Generator"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/images/m_css.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/images/m_header.css" type="text/css" rel="stylesheet"/>
<?php echo '<script'; ?>
>var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";var pricename = "<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
";<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['layerv']->value=='5') {?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.1.8.5.js"><?php echo '</script'; ?>
>
<?php } else { ?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js"><?php echo '</script'; ?>
>
<?php }?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/setday.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/member_public.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js"><?php echo '</script'; ?>
>
</head>
<body>
    <div class="yun_user_member_top user_bg">
    <div class="yun_user_member_w1100">
    <div class="top_left fltL">欢迎来到<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
！</div>
      <div class="top_right_re fltR">
                <div class="top_right">
                    <div class="yun_topNav fr">
                        <a class="yun_navMore png" href="javascript:void(0)">网站导航</a>
                        <div class="yun_webMoredown" style="display:none">
                            <div class="yun_top_nav_box">
                             <ul class="yun_top_nav_box_l">
                             <?php  $_smarty_tpl->tpl_vars['maplist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['maplist']->_loop = false;
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
                             <?php } ?> </ul>
                                 <ul class="yun_top_nav_box_wx">
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
                </ul>
                            </div>
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['cookie']->value['remind_num']>0) {?>
                    <div class="header_Remind fr header_Remind_hover" style=" margin-top:6px;">
                        <em class="header_Remind_em "><i class="header_Remind_msg"></i></em>
                        <div class="header_Remind_list" style="display:none;"> 
                            <div class="header_Remind_list_a">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=msg" class="fl">邀请面试</a>
                                <span class="header_Remind_list_r fr">(<?php echo $_smarty_tpl->tpl_vars['cookie']->value['userid_msg'];?>
)</span>
                            </div>
                          
                            <div class="header_Remind_list_a">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=sysnews" class="fl">系统消息 </a>
                                <span class="header_Remind_list_r fr">(<?php echo $_smarty_tpl->tpl_vars['cookie']->value['sysmsg1'];?>
)</span>
                            </div>
                            <div class="header_Remind_list_a">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/index.php?c=commsg" class="fl">企业回复咨询</a>
                                <span class="header_Remind_list_r fr">(<?php echo $_smarty_tpl->tpl_vars['cookie']->value['usermsg'];?>
)</span>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="header_seach_State fltR">
                        <span class="header_seach_State_name">你好！<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</span>
                        <span class="user_m_line">|</span>
                        <a href="javascript:void(0)" onClick="logout('index.php?act=logout')" class="header_seach_State_a">退出</a>
                        <span class="user_m_line">|</span>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank" title='返回网站首页' class="user_m_fanh">返回网站首页</a>
                        <span class="user_m_line">|</span>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <div class="header">
        <div class="yun_user_member_w1100">
            <div class="logo  fltL">
                <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank" title='返回网站首页'>
                <img alt="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_logo'];?>
" >
                </a>
            </div>
         <ul class="yun_user_member_nav">
         <li <?php if ($_smarty_tpl->tpl_vars['left']->value==1) {?>class="yun_user_member_nav_cur"<?php }?>><a href="index.php">个人中心</a></li>
         <li <?php if ($_smarty_tpl->tpl_vars['left']->value==2) {?>class="yun_user_member_nav_cur"<?php }?>><a href="index.php?c=resume"> 简历管理</a></li>
          <li <?php if ($_smarty_tpl->tpl_vars['left']->value==3) {?>class="yun_user_member_nav_cur"<?php }?>><a href="index.php?c=msg">求职管理</a></li>
          <li <?php if ($_smarty_tpl->tpl_vars['left']->value==5) {?>class="yun_user_member_nav_cur"<?php }?>><a href="index.php?c=paylog">财务管理</a></li>
          <li <?php if ($_smarty_tpl->tpl_vars['left']->value==6) {?>class="yun_user_member_nav_cur"<?php }?>><a href="index.php?c=binding">账号中心</a></li>
          </ul>
        </div>
    </div>
    <div class="clear"></div><?php }} ?>
