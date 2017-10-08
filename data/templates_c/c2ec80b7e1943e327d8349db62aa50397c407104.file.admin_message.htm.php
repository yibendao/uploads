<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 14:59:44
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_message.htm" */ ?>
<?php /*%%SmartyHeaderCode:1103859cf40e0851f43-79229311%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2ec80b7e1943e327d8349db62aa50397c407104' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_message.htm',
      1 => 1492149138,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1103859cf40e0851f43-79229311',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf40e0a575c6_33505757',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf40e0a575c6_33505757')) {function content_59cf40e0a575c6_33505757($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />
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
 src="js/show_pub.js"><?php echo '</script'; ?>
>
<title>后台管理</title>
</head>
<body class="body_ifm">
<div class="infoboxp"> 
<div class="infoboxp_top_bg"></div>
    <form action="index.php" name="myform" method="get">
      <input name="m" value="admin_message" type="hidden"/>
      <div class="admin_Filter"><span class="complay_top_span fl">意见反馈</span>
        <div class="admin_Filter_span">检索类型：</div>
        <div class="admin_Filter_text formselect" did='dtype'>
          <input type="button" value="<?php if ($_GET['type']=='2') {?>意见内容 <?php } else { ?> 用户名<?php }?>" class="admin_Filter_but" id="btype">
         <input type="hidden" name="type" id="type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"/>
          <div class="admin_Filter_text_box" style="display:none" id='dtype'>
            <ul> 
              <li><a href="javascript:void(0)" onClick="formselect('1','type','用户名')">用户名</a></li>
              <li><a href="javascript:void(0)" onClick="formselect('2','type','反馈内容')">反馈内容</a></li>
            </ul>
          </div>
        </div>
        <input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_Filter_search">
        <input type="submit" name='search'  value="搜索" class="admin_Filter_bth">
        <span class='admin_search_div'>
        <div class="admin_adv_search">
          <div class="admin_adv_search_bth">高级搜索</div>
        </div> 
        </span>
		</div>
     </form> 
<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	 
  <div class="table-list">
    <div class="admin_table_border">
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php" target="supportiframe" id='myform' name="myform" method="get">
        <input name="m" value="admin_message" type="hidden"/>
        <input name="c" value="del" type="hidden"/>
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th style="width:20px;"><label for="chkall">
                <input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)'/>
                </label></th>
              <th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_message&order=desc&t=id">编号<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=admin_message&order=asc&t=id">编号<img src="images/sanj2.jpg"/></a> <?php }?>
              </th>
              <th align="left">意见类型</th>
              <th align="left">联系人</th>
               <th>联系手机</th>
              <th align="left">反馈内容</th>
              <th> <?php if ($_GET['t']=="ctime"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_message&order=desc&t=ctime">意见时间<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=admin_message&order=asc&t=ctime">意见时间<img src="images/sanj2.jpg"/></a> <?php }?> </th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          <tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  name='del[]' onclick='unselectall()' rel="del_chk" /></td>
            <td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
            <td class="ud" align="left"><?php if ($_smarty_tpl->tpl_vars['v']->value['infotype']==1) {?>建议<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['infotype']==2) {?>意见<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['infotype']==3) {?>求助<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['infotype']==4) {?>投诉<?php }?></td>
            <td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
            <td class="td"> <?php echo $_smarty_tpl->tpl_vars['v']->value['mobile'];?>
</td>
            <td class="td" width="400" align="left">
			<?php if ($_smarty_tpl->tpl_vars['v']->value['content']) {?> 
			<?php echo mb_substr($_smarty_tpl->tpl_vars['v']->value['content'],0,28,"GBK");?>

			<?php if (strlen($_smarty_tpl->tpl_vars['v']->value['content'])>28) {?> 
			<a href="javascript:void(0);" onclick="showbox('评论内容','index.php?m=admin_message&c=content&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','400px','220px')" class="admin_cz_sc">[更多]</a>
			<?php }?>
			<?php }?>
			</td>
            <td class="td"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],"%Y-%m-%d %H:%M");?>
</td>
            <td>
            <a href="javascript:void(0)" onClick="layer_del('确定要删除？','index.php?m=admin_message&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">删除</a></td>
          </tr> 
          <?php } ?>
          <tr style="background:#f1f1f1;">
            <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
            <td colspan="3" ><label for="chkAll2">全选</label>
              &nbsp;
              <input class="admin_submit4" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" /></td>
			  
            <td colspan="4" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
          </tr>
          </tbody>
        </table>
        <input type="hidden" name="pytoken"  id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      </form>
    </div>
  </div>
</div>
<div id="showbox"  style="display:none; width:400px; "> 
    <div id="infobox">
       
       <div class="admin_message_box" style="line-height:23px;">
      	<div class="admin_message_userlist" style="margin-top:8px;"><span class="admin_message_users">姓名：</span><span class="admin_message_userw" id="showname"></span>联系手机：<span id="showmoblie"></span></div>
      	<div class="admin_message_userlist" style="margin-top:8px;"><span class="admin_message_users">意见类型：</span><span class="admin_message_userw" id="showtype"></span>意见时间：<span id="showdate"></span></div>
      	<div class="admin_message_userlist" style="margin-top:8px;"><span class="admin_message_users">评论内容：</span>
        <div class="admin_message_usercont_box" id="showcontent">
            </div>
            </div>
      	<div class="admin_message_userbth" style="margin-top:10px;"><input style="margin-right:10px;" type="button" value="删除" id="showdelet" class="admin_message_userbth_sub"><input type="button" value="返回" onclick="javascript:layer.closeAll();"class="admin_message_userbth_sub admin_message_userbth_sub_h"></div>
        </div>
       
      </div>
</div>
</body>
</html><?php }} ?>
