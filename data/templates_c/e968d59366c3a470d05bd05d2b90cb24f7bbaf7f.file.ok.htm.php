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
<div class="prompt_message_right_h1">��ϲ��  ע��ɹ�</div>
<div class="prompt_message_right_p">�ǳ���л��ע��<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
<span class="prompt_message_right_s">��<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
��</span>��Ա��<br>
��λ��ע�������Ѿ��ɹ��ύ����վ������Ա���ڽ�����ˣ�</div>
</div>
</div>
<div class="prompt_message_touch">�������Ͽ�ͨ��Ա,��ӭ�������ǿͷ��绰��<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==2) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_sd.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">�ܱ�Ǹ  �����ʺű�����</div>
<div class="prompt_message_right_p">�ܱ�Ǹ�������������˻��з����˲���ȫ������������˻���ʱ�޷�<br>
ʹ�ã�����ϵ�ͷ����������</div>
</div>
</div>
<div class="prompt_message_touch">��ӭ�������ǿͷ��绰��<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==3) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/sh_wtg1.gif"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">�����δͨ��</div>
<div class="prompt_message_right_p">�����˻���ʱ��û��ͨ����ˣ��������ʲô����,����ϵ����Ա��</div>
</div>
</div>
<div class="prompt_message_touch">��ӭ�������ǿͷ��绰��<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==4) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_jh.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">��ϲ�����ʼ���֤�ɹ�</div>
<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member" class="prompt_message_right_member">�����Ա����</a>
<?php } else { ?>
<div class="prompt_message_right_p">��ӭ��Ϊ<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
<span class="prompt_message_right_s">��<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
��</span>��Ա�е�һԱ��</div>
<a href="<?php echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);?>
" class="prompt_message_right_member">�����Ա����</a>
<?php }?>
</div>
</div>
<div class="prompt_message_touch">��ӭ�������ǿͷ��绰��<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==5) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/sh_wtg1.gif"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">��˽�����</div>
<div class="prompt_message_right_p">�����˻���������У��������ʲô����,����ϵ����Ա��</div>
</div>
</div>
<div class="prompt_message_touch">��ӭ�������ǿͷ��绰��<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</span></div>
</div>
<?php } elseif ($_GET['type']==6) {?>

<div class="prompt_message_cont">
<div class="prompt_message_cont_c">
<div class="prompt_message_img"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/msg_jh.png"></div>
<div class="prompt_message_right">
<div class="prompt_message_right_h1">��ϲ�������ĳɹ�</div>
<?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member" class="prompt_message_right_member">�����Ա����</a>
<?php } else { ?>
<div class="prompt_message_right_p">�볤�ڱ��漰��������Ϣ��</div>
<div class="prompt_message_right_p">
���Ϊ<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
<span class="prompt_message_right_s">��<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
��</span>��Ա�е�һԱ��</div>
<a href="<?php echo smarty_function_url(array('m'=>'register','usertype'=>1,'type'=>1),$_smarty_tpl);?>
" class="prompt_message_right_member">ǰ��ע��</a>
<?php }?>
</div>
</div>
<div class="prompt_message_touch">��ӭ�������ǿͷ��绰��<span class="prompt_message_touch_tel"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
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
