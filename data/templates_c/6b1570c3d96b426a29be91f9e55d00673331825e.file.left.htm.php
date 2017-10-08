<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:50:28
         compiled from "D:\phpStudy\WWW\uploads\\app\template\member\user\left.htm" */ ?>
<?php /*%%SmartyHeaderCode:3135359cdb4f4c39a86-71857543%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b1570c3d96b426a29be91f9e55d00673331825e' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\member\\user\\left.htm',
      1 => 1492512554,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3135359cdb4f4c39a86-71857543',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'left' => 0,
    'msgnum' => 0,
    'config' => 0,
    'myresumenum' => 0,
    'uid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdb4f4d770f0_39866403',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdb4f4d770f0_39866403')) {function content_59cdb4f4d770f0_39866403($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo '<script'; ?>
>
    $(document).ready(function () {
        $(".left_sidebar_icon").click(function () {
            var aid = $(this).attr("aid");
            var style = $("#leftlist" + aid).attr("style");
            if ($(this).hasClass("left_sidebar_icon")) {
                $(this).parent().prev().find('li.overflow').show();
                $(this).attr("class", "left_sidebar_icon1");
                $(this).parent().prev().prev().height($(this).parent().prev().find('ul li').length * 30);
            } else {
                $(this).parent().prev().find('li.overflow').hide();
                $(this).attr("class", "left_sidebar_icon");
                $(this).parent().prev().prev().height(($(this).parent().prev().find('ul li').length - $(this).parent().prev().find('ul li.overflow').length) * 30);
            }
        })
    });
<?php echo '</script'; ?>
>

<div class="left_sidebar">
<div class="left_sidebar_box">
<?php if ($_smarty_tpl->tpl_vars['left']->value==1) {?>
  <div class="left_sidebar_box" style="display:block">
    <div class="left_sidebar_tit user_bg">个人中心</div>
    <ul class="left_sidebar_leftmune">
      <li><a href="index.php?c=resume"><i class="left_navicon left_navicon_i1"></i>我的简历</a></li>
      <li><a href="index.php?c=info"><i class="left_navicon left_navicon_i3"></i>基本信息</a></li>
      <li><a href="index.php?c=msg"><i class="left_navicon left_navicon_i9"></i>我的职位</a><?php if ($_smarty_tpl->tpl_vars['msgnum']->value) {?><i class="left_sidebar_leftmune_icon"><?php echo $_smarty_tpl->tpl_vars['msgnum']->value;?>
</i><?php }?></li>
      <li><a href="index.php?c=privacy"><i class="left_navicon left_navicon_i6"></i>隐私设置</a></li>
       <li><a href="index.php?c=passwd"><i class="left_navicon left_navicon_i21"></i>修改密码</a></li>
      <li><a href="index.php?c=binding"><i class="left_navicon left_navicon_i22"></i>账户绑定</a></li>
    </ul>
  </div>
<?php } elseif ($_smarty_tpl->tpl_vars['left']->value==2) {?>
  <div class="left_sidebar_box" style="display:block">
    <div class="left_sidebar_tit user_bg">简历管理</div>
    <ul class="left_sidebar_leftmune">
    
      <li <?php if ($_GET['c']=='resume'||$_GET['c']=='show') {?>class="left_sidebar_leftmune_cur"<?php }?>><i class="left_navicon left_navicon_i1"></i><a href="index.php?c=resume">我的简历</a></li>
      <?php if ($_smarty_tpl->tpl_vars['config']->value['user_number']>$_smarty_tpl->tpl_vars['myresumenum']->value) {?>
      <li><i class="left_navicon left_navicon_i2"></i><a href="index.php?c=expect">创建简历</a></li>
      <?php } else { ?>
      <li><i class="left_navicon left_navicon_i2"></i><a href="javascript:void(0)" onclick="layer.msg('你的简历数已经达到系统设置的简历数了',2,8);return false;">创建简历</a></li>
      <?php }?>
      <li <?php if ($_GET['c']=='info') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=info"><i class="left_navicon left_navicon_i3"></i>基本信息</a></li>
      <li <?php if ($_GET['c']=='uppic') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=uppic"><i class="left_navicon left_navicon_i4"></i>上传照片</a></li>
      <li <?php if ($_GET['c']=='look') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=look"><i class="left_navicon left_navicon_i5"></i>谁看过我的简历 </a></li>
      <li <?php if ($_GET['c']=='privacy') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=privacy"><i class="left_navicon left_navicon_i6"></i>隐私设置</a></li>
      <li <?php if ($_GET['c']=='resumeout') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=resumeout"><i class="left_navicon left_navicon_i7"></i>简历外发</a></li>
     
      <li <?php if ($_GET['c']=='resumetpl') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=resumetpl"><i class="left_navicon left_navicon_i8"></i>简历模板</a></li>
    </ul>
  </div>
<?php } elseif ($_smarty_tpl->tpl_vars['left']->value==3) {?>
  <div class="left_sidebar_box" style="display:block">
    <div class="left_sidebar_tit user_bg">求职管理</div>
    <ul class="left_sidebar_leftmune">
      <li <?php if ($_GET['c']=='msg'||$_GET['c']=='job'||$_GET['c']=='favorite'||$_GET['c']=='look_job') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=msg"><i class="left_navicon left_navicon_i9"></i>我的职位</a><?php if ($_smarty_tpl->tpl_vars['msgnum']->value) {?><i class="left_sidebar_leftmune_icon"><?php echo $_smarty_tpl->tpl_vars['msgnum']->value;?>
</i><?php }?></li>
      <li <?php if ($_GET['c']=='partapply'||$_GET['c']=='partcollect') {?>class="left_sidebar_leftmune_cur"<?php }?>> <a href="index.php?c=partapply"><i class="left_navicon left_navicon_i10"></i>我的兼职</a></li>
      <li <?php if ($_GET['c']=='atn') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=atn"><i class="left_navicon left_navicon_i11"></i>关注的企业</a></li>
		<li <?php if ($_GET['c']=='finder') {?>class="left_sidebar_leftmune_cur"<?php }?>> <a href="index.php?c=finder"><i class="left_navicon left_navicon_i12"></i>职位搜索器</a> </li>
		<li <?php if ($_GET['c']=='commsg') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=commsg"><i class="left_navicon left_navicon_i13"></i>求职咨询 </a></li>
      <li <?php if ($_GET['c']=='subscribe') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=subscribe"><i class="left_navicon left_navicon_i14"></i>订阅管理</a> </li>
    </ul>
  </div>
<?php } elseif ($_smarty_tpl->tpl_vars['left']->value==5) {?>
    <div class="left_sidebar_box" style="display:block">
    <div class="left_sidebar_tit user_bg">财务管理</div>
    <ul class="left_sidebar_leftmune">
    <li <?php if ($_GET['c']=='pay') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=pay"><i class="left_navicon left_navicon_i17"></i>立即充值</a></li>
      <li <?php if ($_GET['c']=='paylog'||$_GET['c']=='paylist') {?>class="left_sidebar_leftmune_cur"<?php }?>> <a href="index.php?c=paylist"><i class="left_navicon left_navicon_i18"></i>财务明细</a> </li>
      <li <?php if ($_GET['c']=='integral'||$_GET['c']=='integral_reduce'||$_GET['c']=='reward_list') {?>class="left_sidebar_leftmune_cur"<?php }?>> <a href="index.php?c=integral"><i class="left_navicon left_navicon_i19"></i><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
管理</a> </li>
      <li><a href="<?php echo smarty_function_url(array('m'=>'invitereg'),$_smarty_tpl);?>
" target="_blank"><i class="left_navicon left_navicon_i20"></i>邀请注册</a></li>
      </ul>
    </div>
<?php } elseif ($_smarty_tpl->tpl_vars['left']->value==6) {?>
  <div class="left_sidebar_box" style="display:block">
    <div class="left_sidebar_tit user_bg">账号中心</div>
    <ul class="left_sidebar_leftmune">
     <li <?php if ($_GET['c']=='passwd') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=passwd"><i class="left_navicon left_navicon_i21"></i>修改密码</a></li>
      <li <?php if ($_GET['c']=='binding'||$_GET['c']=='setname') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=binding"><i class="left_navicon left_navicon_i22"></i>账户绑定</a></li>
      <li <?php if ($_GET['c']=='sysnews') {?>class="left_sidebar_leftmune_cur"<?php }?>><a href="index.php?c=sysnews"><i class="left_navicon left_navicon_i24"></i>系统消息</a></li>
      <li><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);?>
" target="_blank"><i class="left_navicon left_navicon_i26"></i>我的提问</a></li>
    </ul>
  </div>
<?php }?>
</div>
<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode']!='') {?>
<div class="left_wx_box">
<dl class="left_wx_box_dl">
<dt><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wx_qcode'];?>
" width="130" height="130"></dt>
<dd class="">
<div class="left_wx_box_tit">手机挑工作!</div>
<div class="left_wx_box_p">微信扫一扫,入职更快速</div>
</dd>
</dl>

</div>
<?php }?>
</div>


<?php }} ?>
