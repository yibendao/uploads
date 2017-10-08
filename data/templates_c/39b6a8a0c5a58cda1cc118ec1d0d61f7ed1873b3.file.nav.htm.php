<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 14:38:21
         compiled from "D:\phpStudy\WWW\uploads\\app\template\ask\nav.htm" */ ?>
<?php /*%%SmartyHeaderCode:630659cf3bdd1470c7-42264151%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39b6a8a0c5a58cda1cc118ec1d0d61f7ed1873b3' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\ask\\nav.htm',
      1 => 1490265632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '630659cf3bdd1470c7-42264151',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'uid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf3bdd22adc1_93115459',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf3bdd22adc1_93115459')) {function content_59cf3bdd22adc1_93115459($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><div class="answer_left_sidebar fl">
  <div class="answer_left_sidebar_tit"><?php if ($_smarty_tpl->tpl_vars['uid']->value&&($_GET['uid']==''||$_GET['uid']==$_smarty_tpl->tpl_vars['uid']->value)) {?> 我的消息<?php } elseif ($_GET['uid']) {?>他的消息<?php }?></div>
  <ul>
  <?php if ($_smarty_tpl->tpl_vars['uid']->value&&($_GET['uid']==''||$_GET['uid']==$_smarty_tpl->tpl_vars['uid']->value)) {?> 
    <li  <?php if ($_GET['a']=='myquestion') {?>class="answer_left_cur"<?php }?>><?php if ($_GET['type']=='types') {?><i class="answer_left_line"></i><?php }?> <a href="<?php if ($_smarty_tpl->tpl_vars['uid']->value) {
echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);
}?>">我的提问</a></li>
    <li <?php if ($_GET['a']=='myanswer') {?>class="answer_left_cur"<?php }?>><span ><a href="<?php if ($_smarty_tpl->tpl_vars['uid']->value) {
echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myanswer','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);
}?>">我的回答</a></span></li>
    <li <?php if ($_GET['a']=='attenquestion') {?>class="answer_left_cur"<?php }?>><span ><a href="<?php if ($_smarty_tpl->tpl_vars['uid']->value) {
echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'attenquestion','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);
}?>">我的关注</a></span> </li>
    <?php } elseif ($_GET['uid']) {?>
     <li  <?php if ($_GET['a']=='myquestion') {?>class="answer_left_cur"<?php }?>><?php if ($_GET['type']=='types') {?><i class="answer_left_line"></i><?php }?> <a href="<?php if ($_smarty_tpl->tpl_vars['uid']->value) {
echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','uid'=>$_GET['uid']),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);
}?>">他的提问</a></li>
    <li <?php if ($_GET['a']=='myanswer') {?>class="answer_left_cur"<?php }?>><span ><a href="<?php if ($_smarty_tpl->tpl_vars['uid']->value) {
echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myanswer','uid'=>$_GET['uid']),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);
}?>">他的回答</a></span></li>
    <li <?php if ($_GET['a']=='attenquestion') {?>class="answer_left_cur"<?php }?>><span ><a href="<?php if ($_smarty_tpl->tpl_vars['uid']->value) {
echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'attenquestion','uid'=>$_GET['uid']),$_smarty_tpl);
} else {
echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);
}?>">他的关注</a></span> </li>
    
    <?php }?>
  </ul>
</div>
<?php }} ?>
