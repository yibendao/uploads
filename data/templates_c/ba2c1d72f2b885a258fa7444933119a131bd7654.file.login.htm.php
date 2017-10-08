<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:13:50
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\login.htm" */ ?>
<?php /*%%SmartyHeaderCode:1671959cdac5eb126e0-93613068%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba2c1d72f2b885a258fa7444933119a131bd7654' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\login.htm',
      1 => 1501490228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1671959cdac5eb126e0-93613068',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdac5ebe02f2_76709267',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdac5ebe02f2_76709267')) {function content_59cdac5ebe02f2_76709267($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="images/admin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="http://static.geetest.com/static/tools/gt.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/geetest/pc.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",code_web='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
',code_kind='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';
function checkform(){
	if($('#username').val()==''){
		layer.msg('请填写管理员账户！', 2, 8);return false;  
	}
	if($('#password').val()==''){
		layer.msg('请填写登录密码！', 2, 8);return false;  
	}
	var codesear=new RegExp('后台登录');
	if(codesear.test(code_web)){

		if(code_kind==1){
			authcode=$("#ipt_code").val();
			if(authcode==''){
				layer.msg('请填写验证码！', 2, 8);return false;  
			}
		}else if(code_kind==3){
			var geetest_challenge = $('input[name="geetest_challenge"]').val();
			var geetest_validate = $('input[name="geetest_validate"]').val();
			var geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layer.msg('请点击按钮进行验证！', 2, 8);return false;  
			}
		}
	}
	return true;
}
function checkCode(id){
	document.getElementById(id).src=weburl+"/app/include/authcode.inc.php?"+Math.random();
}
<?php echo '</script'; ?>
>
<title><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
 - 后台管理中心</title>
</head>
<body>
<div class="admin_logo_bg">
<div class="logoin_top"></div>
<div class="logoin_cont">
<div class="login_box">
<div class="logoin_c">
<div class="logoin_logo"><img src="images/logoin_logo.png"></div>
<div class="logoin_title"><div class=""><img src="images/logo_t.png"></div></div>
	<div class="login_iptbox">
	<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
	<form action="" method="post" target="supportiframe" autocomplete="off" id='sublogin' onsubmit='return checkform();'>
    <ul class="logoin_list">
		<li><span class="admin_login_s"><label for="username">用户名：</label></span><input type="text" class="ipt" size="10" name="username" id="username" value="" /></li>
		<li><span class="admin_login_s"><label for="password">密&nbsp; 码：</label></span><input type="password" class="ipt" name="password" id="password" value="" /></li>
       	<?php if (strpos($_smarty_tpl->tpl_vars['config']->value['code_web'],"后台登录")!==false) {?>


		  <li>

	   <?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']==3) {?>	
		
		<span class="admin_login_s"><label for="username">验&nbsp; 证：</label></span>
        <div class="admin_verification"><div id="popup-captcha" data-id='sublogin' data-type='submit'></div>
		<input type='hidden' id="popup-submit">
        </div>
		<?php } else { ?>
		
		<span class="admin_login_s"><label for="code">验证码：</label></span>
		<input type="text" id="ipt_code" class="ipt_code" name="authcode" value="" />
        <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" align="absmiddle" id='vcode_imgs' onclick="checkCode('vcode_imgs');">
		
		
		<?php }?>
		 </li>
	    <?php }?>        
		<li><span class="admin_login_s">&nbsp;</span><input type="submit" class="admin_login_sub" name="login_sub"  value="登录" /><input type="reset" class="admin_login_sub admin_login_sub1" name="login_sub" value="重置" /></li>
      </ul>
	  <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	</form>
	</div>
</div>
</div>
</div>
</div>
</body>
</html><?php }} ?>
