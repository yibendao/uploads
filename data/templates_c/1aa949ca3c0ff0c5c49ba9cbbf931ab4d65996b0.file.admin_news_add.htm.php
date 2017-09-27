<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 23:52:03
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_news_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:2597559cbc92335ca96-02138939%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1aa949ca3c0ff0c5c49ba9cbbf931ab4d65996b0' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_news_add.htm',
      1 => 1492764198,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2597559cbc92335ca96-02138939',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'info' => 0,
    'one_class' => 0,
    'v' => 0,
    'two_class' => 0,
    'val' => 0,
    'Dname' => 0,
    'property' => 0,
    'property_row' => 0,
    'describe' => 0,
    'lasturl' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbc92357f9d7_71439834',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbc92357f9d7_71439834')) {function content_59cbc92357f9d7_71439834($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php echo '<script'; ?>
>var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 charset="utf-8" src="../js/kindeditor/kindeditor-min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 charset="utf-8" src="../js/kindeditor/lang/zh_CN.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="../js/kindeditor/themes/default/default.css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="javascript">
KindEditor.ready(function(K) {
	var editor = K.editor({
		allowFileManager : false
	}); 
	K.create('#content', {
		themeType : 'default'
		
	});
	K('#insertfile').click(function() {
		editor.loadPlugin('images', function() {
			editor.plugin.imageDialog({
				imageUrl : K('#pic_url').val(),
				clickFn : function(url, title, width, height, border, align) {
					K('#pic_url').val(url);
					K('#news_pic').html(url);
					editor.hideDialog();
				}
			});
		});
	});
	var colorpicker;
	K('#colorpicker').bind('click', function(e) {
		e.stopPropagation();
		if (colorpicker) {
			colorpicker.remove();
			colorpicker = null;
			return;
		}
		var colorpickerPos = K('#colorpicker').pos();
		colorpicker = K.colorpicker({
			x : colorpickerPos.x,
			y : colorpickerPos.y + K('#colorpicker').height(),
			z : 19811214,
			selectedColor : 'default',
			noColor : '无颜色',
			click : function(color) {
				K('#color').val(color);
				$('#color + font').css('color', color);
				colorpicker.remove();
				colorpicker = null;
			}
		});
	});
	K(document).click(function() {
		if (colorpicker) {
			colorpicker.remove();
			colorpicker = null;
		}
	});
});
function news_preview(url){
	$(".job_box_div").html("<img src='"+url+"' style='max-width:500px' />");
 	$.layer({
		type : 1,
		title : '查看图片',
		closeBtn : [0 , true],
		offset : ['20%' , '30%'],
		border : [10 , 0.3 , '#000', true],
		area : ['560px','auto'],
		page : {dom : '#news_preview'}
	}); 
}
function checkform(myform){
	if (myform.nid.value=="") {
		parent.layer.msg('请选择新闻类别！', 2,8,function(){myform.title.focus();});return false;
	}
	if (myform.title.value=="") {
		parent.layer.msg('请填写新闻标题！', 2,8,function(){myform.title.focus();});return false;
	}
	var content = editor.text();
	if (content=="") {
		parent.layer.msg('请填写新闻内容！', 2,8,function(){myform.title.focus();});return false;
	}
}
<?php echo '</script'; ?>
>
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />

<title>后台管理</title>
</head>
<body class="body_ifm">
<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
  <div class="infoboxp_top">
     <span class="admin_title_span">添加新闻</span>
        <a href="index.php?m=admin_news" class="admin_infoboxp_nav admin_infoboxp_gl">新闻列表</a>
          <em class="admin-tit_line"></em>
        <a href="index.php?m=admin_news&c=group" class="admin_infoboxp_nav admin_infoboxp_lb">类别管理</a>
  </div>
  <div class="clear"></div>
  <div class="admin_table_border">
    <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
    <form name="myform" target="supportiframe" action="index.php?m=admin_news&c=addnews" method="post" onSubmit="return checkform(this);">
      <table width="100%" class="table_form"  style="background:#fff;">
        <tr >
          <th width="120">新闻类别：</th>
          <td>
          
          <div class="yun_admin_select_box zindex100">
            <?php if ($_smarty_tpl->tpl_vars['info']->value['nid']) {?>
	 		  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one_class']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['info']->value['nid']) {?>
                    <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" class="yun_admin_select_box_text" id="newsclass_name" onClick="select_click('newsclass');">
                    <input name="nid" type="hidden" id="newsclass_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                    <?php }?>
                    
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['two_class']->value[$_smarty_tpl->tpl_vars['v']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['info']->value['nid']) {?>
                        <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
" class="yun_admin_select_box_text" id="newsclass_name" onClick="select_click('newsclass');">
                        <input name="nid" type="hidden" id="newsclass_val" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
                        <?php }?>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <input type="button" value="请选择" class="yun_admin_select_box_text" id="newsclass_name" onClick="select_click('newsclass');">
                <input name="nid" type="hidden" id="newsclass_val" value="">
            <?php }?>
            
            
            <div class="yun_admin_select_box_list_box dn" id="newsclass_select">     
	 		 <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one_class']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="yun_admin_select_box_list">
                    <a href="javascript:;" onClick="select_new('newsclass','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
                </div>
                	  <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['two_class']->value[$_smarty_tpl->tpl_vars['v']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                      <div class="yun_admin_select_box_list">
                                <a href="javascript:;" onClick="select_new('newsclass','<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
')"> 　┗<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</a>
                            </div>
                      <?php } ?>                    
                <?php } ?>
            </div>
        </div>
            
         <a href="index.php?m=admin_news&c=group" class="on" style="background:#498CD0; color:#FFF; padding:5px 10px 5px 10px; float:left; margin-left:10px; margin-top:5px;">添加分类</a></td>
        </tr>
        <tr class="admin_table_trbg" >
          <th>新闻标题：</th>
          <td><input class="input-text" type="text" name="title" size="40" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['title'];?>
" style="width:330px;"><input type="hidden" name='color' id="color" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['color'];?>
" /> <font color="<?php echo $_smarty_tpl->tpl_vars['info']->value['color'];?>
">字体颜色</font><input type="button" id="colorpicker" value="打开取色器" class="admin_submit6" style="background:#F60; margin-left:5px;"/></td>
        </tr>
     	<tr>
        <th>使用范围：</th>
        <td><input type="button" value="<?php if ($_smarty_tpl->tpl_vars['info']->value['did']) {
echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];
} else { ?>总站<?php }?>" class="city_news_but" onClick="add_site('<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
','<?php echo $_smarty_tpl->tpl_vars['Dname']->value[$_smarty_tpl->tpl_vars['info']->value['did']];?>
');">
        <input type="hidden" id="did" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['did'];?>
" name="did"></td>
      </tr> 
        <tr class="admin_table_trbg" >
          <th>作　　者：</th>
          <td><input class="input-text" type="text" name="author" size="20" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['author'];?>
"/></td>
        </tr>
        <tr >
          <th>来　　源：</th>
          <td><input class="input-text" type="text" name="source" size="50" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['source'];?>
"/></td>
        </tr>
        <tr class="admin_table_trbg" >
          <th>关 键 词：</th>
          <td><input class="input-text" type="text" name="keyword" size="50" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['keyword'];?>
"/>
            <span class="admin_web_tip">多个关键字，请用,隔开</span> </td>
        </tr>
        <tr >
          <th>描　　述：</th>
          <td><textarea name="description" cols="55" rows="3" class="admin_comdit_textarea"><?php echo $_smarty_tpl->tpl_vars['info']->value['description'];?>
</textarea></td>
        </tr>
        <tr class="admin_table_trbg" >
          <th>新闻内容： </th>
          <td><textarea  id="content" name="content" cols="100" rows="8" style="width:800px;height:300px;"><?php echo $_smarty_tpl->tpl_vars['info']->value['content'];?>
</textarea></td>
        </tr>
        <tr >
          <th>缩 略 图：</th>
          <td><span id='news_pic'><?php echo $_smarty_tpl->tpl_vars['info']->value['s_thumb'];?>
</span><input type="hidden"  class="input-text" name="uplocadpic"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['s_thumb'];?>
"   id='pic_url' /><?php if ($_smarty_tpl->tpl_vars['info']->value['s_thumb']) {?><a href="javascript:void(0)" onClick="news_preview('../<?php echo $_smarty_tpl->tpl_vars['info']->value['newsphoto'];?>
')"class="admin_chlose_img_look">查看图片</a><?php }?><input   type="button" id="insertfile" value=" " class="admin_chlose_img" /></td>
        </tr>
        <tr class="admin_table_trbg" >
          <th>类　　型：</th>
          <td>
            <?php  $_smarty_tpl->tpl_vars['property_row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['property_row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['property']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['property_row']->key => $_smarty_tpl->tpl_vars['property_row']->value) {
$_smarty_tpl->tpl_vars['property_row']->_loop = true;
?>
             <label><span class="admin_radio_box" style="margin-right:10px;"> <input type="checkbox"  class="admin_radio_box_r" name="describe[]" value="<?php echo $_smarty_tpl->tpl_vars['property_row']->value['value'];?>
"<?php if (in_array($_smarty_tpl->tpl_vars['property_row']->value['value'],$_smarty_tpl->tpl_vars['describe']->value)) {?> checked="checked" <?php }?>/><?php echo $_smarty_tpl->tpl_vars['property_row']->value['name'];?>
 </span></label>
            <?php } ?></td>
        </tr>
        <tr >
          <th>排　　序：</th>
          <td><input name="sort" type="text"  size="10" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['sort'];?>
" /></td>
        </tr>
        <tr class="admin_table_trbg" >
          <td align="center" colspan="2"> 
            <?php if ($_smarty_tpl->tpl_vars['info']->value['id']) {?>
            <input type="hidden" name="id" size="40" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
"/>
            <input type="hidden" name="lasturl" value="<?php echo $_smarty_tpl->tpl_vars['lasturl']->value;?>
">
            <input class="admin_submit4" type="submit" name="updatenews" value="&nbsp;更 新&nbsp;"  />
            <?php } else { ?>
            <input class="admin_submit4" type="submit" name="newsadd" value="&nbsp;添 加&nbsp;"  />
            <?php }?>
            <input class="admin_submit4" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" /></td>
        </tr>
      </table>
	  <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
    </form>
  </div>
</div>
<div id="news_preview"  style="display:none;width:560px ">
	<div style="height:300px; overflow:auto;width:560px;" >
		<div class="job_box_div" style="text-align:center;margin-top:10px;"></div>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/checkdomain.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html><?php }} ?>
