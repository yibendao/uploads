<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:14:06
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_member_userlist.htm" */ ?>
<?php /*%%SmartyHeaderCode:891159cdac6e7c27e0-58882468%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e7b6e603538855620f8fb899132272e36f7841b' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_member_userlist.htm',
      1 => 1501490228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '891159cdac6e7c27e0-58882468',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'userrows' => 0,
    'key' => 0,
    'v' => 0,
    'email_promiss' => 0,
    'moblie_promiss' => 0,
    'source' => 0,
    'Dname' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdac6e9c4842_38219253',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdac6e9c4842_38219253')) {function content_59cdac6e9c4842_38219253($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(function(){
	$(".status").click(function(){
		$("input[name=pid]").val($(this).attr("pid"));
		var uid=$(this).attr("pid");
		var status=$(this).attr("status");
		$("#status"+status).attr("checked",true);
		$("input[name=uid]").val(uid);
		$.get("index.php?m=user_member&c=lockinfo&uid="+uid,function(msg){
			$("#alertcontent").val($.trim(msg));
			status_div('锁定用户','350','230');
		});
	});
});
function SendMsg(){
	var codewebarr="";
	$(".check_all:checked").each(function(){
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	$("#userid").val(codewebarr);
	setTimeout(function(){$('#checkform').submit()},0);
}
<?php echo '</script'; ?>
>
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />

<title>后台管理</title>
</head>
<body class="body_ifm">
<form action="index.php?m=admin_message&c=show" method="post" id='checkform'>
  <input type="hidden" name="userid" id="userid" value="">
  <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
</form>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/member_send_email.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="status_div"  style="display:none; width: 350px; ">
  <div class="" style=" margin-top:10px; "  >
    <form action="index.php?m=user_member&c=status" target="supportiframe" method="post" id="formstatus">
      <table cellspacing='1' cellpadding='1' class="admin_examine_table">
     <tr>
    <th width="80">锁定操作：</th>
     <td align="left">
         		<label for="status1"> <span class="admin_examine_table_s"><input type="radio" name="status" value="1" id="status1" >正常</span></label>
            	<label for="status2"> <span class="admin_examine_table_s"><input type="radio" name="status" value="2" id="status2">锁定</span></label>
          </td>
        </tr>
        </tr>
          <tr>
            <th>锁定说明：</th>
           <td align="left"> <textarea id="alertcontent" name="lock_info" class="admin_explain_textarea"></textarea> </td>
        
           </tr>
        <tr>
           <td colspan='2' align="center"><input type="submit"  value='确认' class="admin_examine_bth">
          
            <input type="button" id="zxxCancelBtn" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'></td>
        </tr>
   
      <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      <input name="uid" value="0" type="hidden">
         </table>
    </form>
  </div>
</div>
<div class="infoboxp">
  <div class="infoboxp_top_bg"></div>
  <form action="index.php" name="myform" method="get">
    <input name="m" value="user_member" type="hidden"/>
    <div class="admin_Filter">
    	<span class="complay_top_span fl">个人会员列表</span>
      <div class="admin_Filter_span">搜索类型：</div>
      <div class="admin_Filter_text formselect" did='duser_type'>
        <input type="button" <?php if ($_GET['type']==''||$_GET['type']=='1') {?> value="用户名" <?php } elseif ($_GET['type']=='2') {?> value="姓名" <?php } elseif ($_GET['type']=='3') {?> value="EMAIL" <?php } elseif ($_GET['type']=='4') {?> value="手机号" <?php } elseif ($_GET['type']=='5') {?> value="用户ID"<?php }?> class="admin_Filter_but" id="buser_type">
        <input type="hidden" name="type" id="user_type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"/>
        <div class="admin_Filter_text_box" style="display:none" id="duser_type">
          <ul> 
            <li><a href="javascript:void(0)" onClick="formselect('1','user_type','用户名')">用户名</a></li>
            <li><a href="javascript:void(0)" onClick="formselect('2','user_type','姓名')">姓名</a></li>
            <li><a href="javascript:void(0)" onClick="formselect('3','user_type','EMAIL')">EMAIL</a></li>
            <li><a href="javascript:void(0)" onClick="formselect('4','user_type','手机号')">手机号</a></li>
			<li><a href="javascript:void(0)" onClick="formselect('5','user_type','用户ID')">用户ID</a></li>
          </ul>
        </div>
      </div>
      <input type="text" placeholder="输入你要搜索的关键字"  name='keyword' class="admin_Filter_search">
      <input type="submit" name='search' value="搜索" class="admin_Filter_bth">
      <span class='admin_search_div'>
      <div class="admin_adv_search">
        <div class="admin_adv_search_bth">高级搜索</div>
      </div>
      </span> <a href="index.php?m=user_member&c=add" class="admin_infoboxp_tj">添加会员</a> </div>
  </form>
  <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <div class="table-list">
    <div class="admin_table_border">
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php"  target="supportiframe" name="myform" method="get" id='myform'>
        <input name="m" value="user_member" type="hidden"/>
        <input name="c" value="del" type="hidden"/>
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th style="width:20px;"><label for="chkall">
                  <input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)'/>
                </label></th>
              <th align="left"> <?php if ($_GET['t']=="uid"&&$_GET['order']=="asc") {?> <a href="index.php?m=user_member&order=desc&t=uid">用户ID<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=user_member&order=asc&t=uid">用户ID<img src="images/sanj2.jpg"/></a> <?php }?></th>
              <th align="left">用户名</th>
              <th align="left">姓名</th>
              <th align="left">EMAIL/手机号</th>
              <th align="left"> <?php if ($_GET['t']=="reg_date"&&$_GET['order']=="asc") {?> <a href="index.php?m=user_member&order=desc&t=reg_date">注册时间<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=user_member&order=asc&t=reg_date">注册时间<img src="images/sanj2.jpg"/></a> <?php }?></th>
              <th> <?php if ($_GET['t']=="login_date"&&$_GET['order']=="asc") {?> <a href="index.php?m=user_member&order=desc&t=login_date">最近登录时间<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=user_member&order=asc&t=login_date">最近登录时间<img src="images/sanj2.jpg"/></a> <?php }?></th>
              <th>登录IP</th>
              <th>来源</th>
              <th>站点</th>
              <th>添加/重置</th>
              <th class="admin_table_th_bg">操作</th>
            </tr>
          </thead>
          <tbody>
          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userrows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          <tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
">
            <td width="20"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="check_all"  name='del[]' onclick='unselectall()' rel="del_chk" email="<?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
" moblie="<?php echo $_smarty_tpl->tpl_vars['v']->value['telphone'];?>
"/></td>
            <td align="left" class="td1" style="text-align:center; width:60px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</td>
            <td align="left"><a href="index.php?m=user_member&c=Imitate&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</a> <?php if ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?><img src="../config/ajax_img/suo.png" alt="已锁定"><?php }?> </td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
            <td class="od" align="left"> 
              <div style="width:190px;"><?php if ($_smarty_tpl->tpl_vars['v']->value['email']) {?>
              <?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>

              <?php if ($_smarty_tpl->tpl_vars['email_promiss']->value) {?><a onClick="send_email('<?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
');" style="color:green; cursor:pointer;">发邮件</a><?php }?></div>
              <?php }?>
              <div style="width:190px;"><?php if ($_smarty_tpl->tpl_vars['v']->value['moblie']) {?>
              <?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>

              <?php if ($_smarty_tpl->tpl_vars['moblie_promiss']->value) {?><a onClick="send_moblie('<?php echo $_smarty_tpl->tpl_vars['v']->value['moblie'];?>
');" style="color:green; cursor:pointer;">发信息</a> <?php }?>
              <?php }?></div> </td>
            <td class="td" align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['reg_date'],"%Y-%m-%d");?>
</td>
            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['login_date']!='') {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['login_date'],"%Y-%m-%d");?>

              <?php } else { ?><font color="#FF0000">从未登录</font><?php }?></td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['login_ip'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['source']->value[$_smarty_tpl->tpl_vars['v']->value['source']];?>
</td>
			<td>
			<div><?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['v']->value['did']];?>
</div>
			<div><a href="javascript:;" onclick="checksite('<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
','index.php?m=user_member&c=checksitedid');" class="admin_company_xg_icon">重新分配</a></div>
			</td>
            <td><div><a href="index.php?m=admin_resume&c=addresume&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_cz_sc">添加简历</a></div>
              <a href="javascript:void(0);" onClick="resetpw('<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');" class="admin_com_cz">点我重置</a></td>
            <td><a href="index.php?m=user_member&c=Imitate&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" target="_blank" class="admin_cz_sc">管理</a> | <a href="javascript:;" class="admin_cz_sc status" pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
">锁定</a><br/>
              <a href="index.php?m=user_member&c=edit&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="admin_cz_sc">修改</a> | <a href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=user_member&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');"class="admin_cz_sc">删除</a></td>
          </tr>
          <?php } ?>
          <tr style="background:#f1f1f1;">
            <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
            <td colspan="4" ><label for="chkAll2">全选</label>
              &nbsp;
              <input class="admin_submit4" type="button" name="delsub" value="删除所选"  onclick="return really('del[]')"/>
              <?php if ($_smarty_tpl->tpl_vars['email_promiss']->value) {?>
              <input class="admin_submit4" type="button"  value="发邮件"  onclick="return confirm_email('确定发邮件吗？','email_div')"/>
              <?php }?>
              <?php if ($_smarty_tpl->tpl_vars['moblie_promiss']->value) {?>
              <input class="admin_submit4" type="button" value="发信息"  onclick="return confirm_email('确定发信息吗？','moblie_div')"/>
              <?php }?>
			  <input class="admin_submit4" type="button" name="delsub" value="批量选择分站" onClick="checksiteall('index.php?m=user_member&c=checksitedid');" />
			  </td>
            <td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
          </tr>
            </tbody>
        </table>
        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      </form>
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html>
<?php }} ?>
