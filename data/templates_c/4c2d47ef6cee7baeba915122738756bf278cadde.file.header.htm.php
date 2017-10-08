<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 14:38:21
         compiled from "D:\phpStudy\WWW\uploads\\app\template\ask\header.htm" */ ?>
<?php /*%%SmartyHeaderCode:2826059cf3bdd029bc7-42146961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c2d47ef6cee7baeba915122738756bf278cadde' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\ask\\header.htm',
      1 => 1491894108,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2826059cf3bdd029bc7-42146961',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'ask_style' => 0,
    'config' => 0,
    'maplist' => 0,
    'navlist_app' => 0,
    'uid' => 0,
    'navtype' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf3bdd11f750_64730947',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf3bdd11f750_64730947')) {function content_59cf3bdd11f750_64730947($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name=keywords content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"/>
<meta name=description content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['ask_style']->value;?>
/style/style.css" type="text/css" rel="stylesheet" />
<?php echo '<script'; ?>
>
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',code_web='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
',code_kind='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';<?php echo '</script'; ?>
>
</head>
<body>
<div class="top_lietou">
  <div class="top_cot">
    <div class="top_cot_content">
      <div class="top_left fl">
        <div class="yun_welcome fl">欢迎来到<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
！</div>
      </div>
      <div class="top_right_re fr">
        <div class="top_right">
          <div class="yun_topNav fr"> 
		  <a class="yun_navMore" href="javascript:;">网站导航</a>
           <div class="yun_webMoredown none">
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
                <?php } ?> 
                 </ul>
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
           <?php echo '<script'; ?>
 language='JavaScript' src='<?php echo smarty_function_url(array('m'=>'ajax','c'=>'RedLoginHead'),$_smarty_tpl);?>
'><?php echo '</script'; ?>
> 
        </div>
      </div>
    </div>
  </div>
</div>	
 <div class="clear"></div>
<div class="ask_header">
<div class="ask_header_cont">
<div class="logo fl"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
"><img class="png" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
" /></a></div>
<div class="search">
		<div class="search_con">
			<div class="seek">
				<form action="index.php" name="myform" method="get" target="_blank" autocomplete="off" onsubmit="return asksearch();">
				<div class="seek_con">
					<div class="seek_det">  
						<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_askdir']) {?><input name='m' type='hidden' value='ask'/><?php }?>
						<input name='c' type='hidden' value='search'/>
						<input type="text" name='keyword' id="askkeyword" placeholder="请输入问题关键字" class="txt" autocomplete="off"  onblur="if(this.value==''){this.value='请输入问题关键字'}" onclick="if(this.value=='请输入问题关键字'){this.value=''}" value="请输入问题关键字"/>
						<span class="icon"></span>
					</div>
					<div class="seek_sear"><input type="submit" class="btn"  value="搜一下"/></div>
				</div>
				</form>
				<div class="seek_menu">
					<ul> 
						<span class="searchli"></span>
						<li class="option">搜索：<a href="#" target="_blank"></a></li>
						<li class="me_quiz"><span>
						<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
							<a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'addquestion'),$_smarty_tpl);?>
" target="_blank">我要提问</a>
						<?php } else { ?>
							<a href="javascript:void(0);" onclick="showlogin('');">我要提问</a>
						<?php }?></span>
						</li>
					</ul>
				</div>
			</div>
            <div class="header_ask_ask">
        <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
				<a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'addquestion'),$_smarty_tpl);?>
" target="_blank">我要提问</a>
			<?php } else { ?>
				<a href="javascript:void(0);" onclick="showlogin('');">我要提问</a>
			<?php }?>
	</div>
		</div>
	</div>
</div>

</div>
<div class="ask_header_nav">
	<div class="ask_header_nav_cont"> 
		<ul> 
			<li <?php if ($_smarty_tpl->tpl_vars['navtype']->value=='') {?>class="cur"<?php }?>><a href="<?php echo smarty_function_url(array('m'=>'ask'),$_smarty_tpl);?>
">首页</a></li>
			<li <?php if ($_smarty_tpl->tpl_vars['navtype']->value=='topic') {?>class="cur"<?php }?>><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'topic'),$_smarty_tpl);?>
">话题</a></li>
			<li <?php if ($_smarty_tpl->tpl_vars['navtype']->value=='hotweek') {?>class="cur"<?php }?>><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'hotweek'),$_smarty_tpl);?>
">一周热点</a></li>	 
			<?php if ($_smarty_tpl->tpl_vars['uid']->value&&($_GET['uid']==''||$_GET['uid']==$_smarty_tpl->tpl_vars['uid']->value)) {?> 
			<li <?php if ($_GET['c']=='friend') {?>class="cur"<?php }?>><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','type'=>'types','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);?>
">我的主页</a></li> 
			<?php } elseif ($_GET['uid']) {?>
			<li <?php if ($_GET['c']=='friend') {?>class="cur"<?php }?>><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','uid'=>$_GET['uid']),$_smarty_tpl);?>
">他的主页</a></li>
			<?php }?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">进入人才网首页</a></li>
		</ul> 
	</div>
</div>
<div class="clear"></div> <?php }} ?>
