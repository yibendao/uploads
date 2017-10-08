<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-06 16:50:38
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\admin_addresume.htm" */ ?>
<?php /*%%SmartyHeaderCode:1174659d7436c8919c7-27611131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8894c6fe75bf328a4dd26c1d5e1af01ed3d6d8c5' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\admin_addresume.htm',
      1 => 1507279828,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1174659d7436c8919c7-27611131',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59d7436c9f7ef8_36319985',
  'variables' => 
  array (
    'comstyle' => 0,
    'config' => 0,
    'user_style' => 0,
    'row' => 0,
    'pytoken' => 0,
    'arr_data' => 0,
    'j' => 0,
    'v' => 0,
    'userdata' => 0,
    'userclass_name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59d7436c9f7ef8_36319985')) {function content_59d7436c9f7ef8_36319985($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link href="<?php echo $_smarty_tpl->tpl_vars['comstyle']->value;?>
/images/index_style.css" type=text/css rel=stylesheet>
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/evaluation/images/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/evaluation/images/system.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/evaluation/images/table_form.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/evaluation/js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/css/font-awesome.min.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/foundation-datepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="javascript"> 
var userstyle="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
";
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
function addresume(){
	var username=$.trim($("#username").val());
	var password=$.trim($("#password").val());
	var passconfirm=$.trim($("#passconfirm").val());
	var resume_name=$.trim($("#resume_name").val());
	var sex=$.trim($("input[name='sex']:checked").val());
	var living=$.trim($("#living").val());
	var birthday=$.trim($("#birthday").val());
	var telphone=$.trim($("#telphone").val());
	var email=$.trim($("#email").val());
	var description=$.trim($("#description").val());
	var reg= /^[1][34578]\d{9}$/;
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;		
	'<?php if ($_smarty_tpl->tpl_vars['row']->value['uid']=='') {?>'
	if(username==''){parent.layer.msg("登录账户不能为空！",2,8);return false;}
	if(password.length<6){parent.layer.msg("密码长度错误！",2,8);return false;}
	if(password!=passconfirm){parent.layer.msg("两次密码不一致！",2,8);return false;}
	'<?php }?>'
	if(resume_name==''){parent.layer.msg("用户姓名不能为空！",2,8);return false;}
	if(sex==''){parent.layer.msg("性别不能为空！",2,8);return false;}
	if(living==''){parent.layer.msg("现居住地不能为空！",2,8);return false;}
	if(birthday==''){parent.layer.msg("出生日期不能为空！",2,8);return false;}
	if(telphone==''){parent.layer.msg("手机号码不能为空！",2,8);return false;}else if(!reg.test(telphone)){
		parent.layer.msg("手机号码格式错误！",2,8);return false;
	}
	if(email==''){parent.layer.msg("邮箱不能为空！",2,8);return false;}else if(!myreg.test(email)){
		parent.layer.msg("邮箱格式错误！",2,8);return false;
	}
	if(description==''){parent.layer.msg("自我评价不能为空！",2,8);return false;}
} 
<?php echo '</script'; ?>
>
<div class="w1000">
  <div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class=right_box>
      <div class=admincont_box>
        <div class="job_list_tit">
          <ul class="">
          <li <?php if ($_GET['c']=="hr") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=hr">应聘简历</a></li>
          <li <?php if ($_GET['c']=="down") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=down">已下载简历</a></li>
          <li <?php if ($_GET['c']=="talent_pool") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=talent_pool">收藏简历</a></li>
          <li <?php if ($_GET['c']=="look_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=look_resume">浏览简历</a></li>
          <li <?php if ($_GET['c']=="record") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=record" title="网站为您推荐的简历">网站推荐简历</a></li>
          <li <?php if ($_GET['c']=="my_create_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=my_create_resume" title="我创建的简历">我创建的简历</a></li>
          </ul>
        </div>
        <div class="com_body">
          <div class="admin_table_border">
            <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
            <form action=""  method="post" onSubmit="return addresume()"  target="supportiframe">
              <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
              <table width="100%" class="table_form" style="background:#fff;">
                <?php if ($_smarty_tpl->tpl_vars['row']->value['uid']=='') {?>
                <tr>
                  <td colspan='4'><div style="font-size:14px; padding-left:30px;">账户信息</div></td>
                </tr>
                <tr>
                  <th>登录账户：</th>
                  <td colspan='3'><input type="text" name="username" id="username" class="input-text" value="" onblur="check_username();"></td>
                </tr>
                <tr class="admin_table_trbg">
                  <th>密码：</th>
                  <td colspan='3'><input type="password" name="password" id="password" class="input-text" value=""></td>
                </tr>
                <tr>
                  <th>确认密码：</th>
                  <td colspan='3'><input type="password" name="passconfirm" id="passconfirm" class="input-text" value=""></td>
                </tr>
                <?php }?>
                <tr>
                  <td colspan='4'><div style="font-size:14px; padding-left:30px;">基本资料</div></td>
                </tr>
                <tr class="admin_table_trbg">
                  <th>用户姓名：</th>
                  <td colspan='3'><input type="text" name="resume_name" id="resume_name" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
"></td>
                </tr>
                <tr  >
                  <th>性 别：</th>
                  <td colspan='3'> 
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arr_data']->value['sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
              <input id="sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" type="radio" <?php if ($_smarty_tpl->tpl_vars['row']->value['sex']==$_smarty_tpl->tpl_vars['j']->value) {?>checked="checked"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" name="sex">
              <label for="sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</label>
                  <?php } ?>     
                    
                    
                    </td>
                </tr>
                <tr class="admin_table_trbg">
                  <th>教育程度：</th>
                  <td colspan='3'><div class="yun_admin_select_box z_index15"> <?php if ($_smarty_tpl->tpl_vars['row']->value['edu']) {?>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <?php if ($_smarty_tpl->tpl_vars['row']->value['edu']==$_smarty_tpl->tpl_vars['v']->value) {?>
                      <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" class="yun_admin_select_box_text" id="user_edu_name" onClick="select_click('user_edu');">
                      <input name="edu" type="hidden" id="user_edu_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
">

                      <?php }?>
                      <?php } ?>
                      <?php } else { ?>
                      <input type="button" value="请选择" class="yun_admin_select_box_text" id="user_edu_name" onClick="select_click('user_edu');">
                      <input name="edu" type="hidden" id="user_edu_val" value="0">

                      <?php }?>
                      <div class="yun_admin_select_box_list_box dn" id="user_edu_select"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                        <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('user_edu','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
                        <?php } ?> </div>
                    </div></td>
                </tr>
                <tr>
                  <th>现居住地：</th>
                  <td colspan='3'><input type="text" name="living" id="living" class="input-text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['living'];?>
"></td>
                </tr>
                <tr class="admin_table_trbg">
                  <th>工作经验：</th>
                  <td colspan='3'><div class="yun_admin_select_box z_index14"> <?php if ($_smarty_tpl->tpl_vars['row']->value['exp']) {?>
                      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <?php if ($_smarty_tpl->tpl_vars['row']->value['exp']==$_smarty_tpl->tpl_vars['v']->value) {?>
                      <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" class="yun_admin_select_box_text" id="user_exp_name" onClick="select_click('user_exp');">
                      <input name="exp" type="hidden" id="user_exp_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
">

                      <?php }?>
                      <?php } ?>
                      <?php } else { ?>
                      <input type="button" value="请选择" class="yun_admin_select_box_text" id="user_exp_name" onClick="select_click('user_exp');">
                      <input name="exp" type="hidden" id="user_exp_val" value="0">

                      <?php }?>
                      <div class="yun_admin_select_box_list_box dn" id="user_exp_select"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                        <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('user_exp','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
                        <?php } ?> </div>
                    </div></td>
                </tr>
                <tr >
                  <th>出生日期：</th>
                  <td colspan='3'><input name="birthday" id="birthday"  type="text" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['birthday'];?>
" class="input-text" />
                    <?php echo '<script'; ?>
 type="text/javascript">
              $('#birthday').fdatepicker({format: 'yyyy-mm-dd',initialDate: '1988-08-08',startView:4,minView:2});   
                <?php echo '</script'; ?>
></td>
                </tr>
                <tr class="admin_table_trbg">
                  <th>手机：</th>
                  <td colspan='3'><input type="text" name="moblie" id='telphone' onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['telphone'];?>
"></td>
                </tr>
                <tr >
                  <th>邮箱：</th>
                  <td colspan='3'><input type="text" name="email" id="email" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
"></td>
                </tr>
                <tr class="admin_table_trbg">
                  <th>自我评价：</th>
                  <td colspan='3'><textarea id="description" class="expect_text_textarea  " name="description" ><?php echo $_smarty_tpl->tpl_vars['row']->value['description'];?>
</textarea></td>
                </tr>
                <tr class="admin_table_trbg" >
                  <th width="120"></th>
                  <td><input name='uid' type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
'>
                    <input class="admin_submit4" type="submit" name="next" value="&nbsp;下一步&nbsp;" /></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
