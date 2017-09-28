<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 00:12:48
         compiled from "D:\phpStudy\WWW\uploads\app\template\default\error\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:76259cd1f809e4157-31529033%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfa5bc8821e255884c984c7159253a5cedaa51e5' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\default\\error\\index.htm',
      1 => 1487216956,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '76259cd1f809e4157-31529033',
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
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cd1f80aa9985_03593482',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cd1f80aa9985_03593482')) {function content_59cd1f80aa9985_03593482($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
/style/error.css" type="text/css"/>
</head>
<body onLoad="TimeOut('10')">
<div class="index_w1000 error_box">
  <div class="error_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/error_01.png"></div>
  <div class="error_text">
    <h3>很抱歉，您访问的页面不存在……</h3>
    <div class="error_h"><span id="times">10</span>秒后自动跳转到首页，如没有跳转请点击以下链接</div>
    <div class="error_h">
      <input class="error_bth" value="返回首页 " type="button" onclick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
'">
    </div>
  </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
>
function TimeOut(i){
	if(i>1){
		i=i-1;
		$("#times").html(i);
		setTimeout("TimeOut("+i+");",1000);
	}else{
		window.location.href='<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
	}
} 
<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
