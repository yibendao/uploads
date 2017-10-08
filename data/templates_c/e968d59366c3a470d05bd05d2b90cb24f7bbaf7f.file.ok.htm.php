<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 16:30:00
         compiled from "D:\phpStudy\WWW\uploads\app\template\default\register\ok.htm" */ ?>
<?php /*%%SmartyHeaderCode:1381259ce0488d270b5-10810159%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e968d59366c3a470d05bd05d2b90cb24f7bbaf7f' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\default\\register\\ok.htm',
      1 => 1492517712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1381259ce0488d270b5-10810159',
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
    'uid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce0488eb8642_92847752',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce0488eb8642_92847752')) {function content_59ce0488eb8642_92847752($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
/style/message.css" type="text/css">
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="prompt_message">
<?php if ($_GET['type']==1) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_zq.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">恭喜您  注册成功</div>
<div class="prompt_message_right_p">非常感谢您注册<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
<span class="prompt_message_right_s">（<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
）</span>会员！<br>
贵单位的注册资料已经成功提交，本站工作人员正在进行审核！</div>
</div>
</div>
<div class="prompt_message_touch">如需马上开通会员,欢迎拨打我们客服电话：<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==2) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_sd.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">很抱歉  您的帐号被锁定</div>
<div class="prompt_message_right_p">很抱歉，由于在您的账户中发现了不安全的情况，您的账户暂时无法<br>
使用！请联系客服解除锁定！</div>
</div>
</div>
<div class="prompt_message_touch">欢迎拨打我们客服电话：<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==3) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/sh_wtg1.gif"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">审核暂未通过</div>
<div class="prompt_message_right_p">您的账户暂时还没有通过审核，如果您有什么疑问,请联系管理员。</div>
</div>
</div>
<div class="prompt_message_touch">欢迎拨打我们客服电话：<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==4) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_jh.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">恭喜您，邮件认证成功</div>
<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member" class="prompt_message_right_member">进入会员中心</a>
<?php } else { ?>
<div class="prompt_message_right_p">欢迎成为<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
<span class="prompt_message_right_s">（<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
）</span>会员中的一员！</div>
<a href="<?php echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);?>
" class="prompt_message_right_member">进入会员中心</a>
<?php }?>
</div>
</div>
<div class="prompt_message_touch">欢迎拨打我们客服电话：<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==5) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/sh_wtg1.gif"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">审核进行中</div>
<div class="prompt_message_right_p">您的账户正在审核中，如果您有什么疑问,请联系管理员。</div>
</div>
</div>
<div class="prompt_message_touch">欢迎拨打我们客服电话：<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==6) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_jh.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">恭喜您，订阅成功</div>
<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member" class="prompt_message_right_member">进入会员中心</a>
<?php } else { ?>
<div class="prompt_message_right_p">想长期保存及管理订阅信息？</div>
<div class="prompt_message_right_p">
想成为<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
<span class="prompt_message_right_s">（<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
）</span>会员中的一员？</div>
<a href="<?php echo smarty_function_url(array('m'=>'register','usertype'=>1,'type'=>1),$_smarty_tpl);?>
" class="prompt_message_right_member">前往注册</a>
<?php }?>
</div>
</div>
<div class="prompt_message_touch">欢迎拨打我们客服电话：<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php }?>
</div>
<div class="clear"></div>
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
/js/reg_ajax.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
