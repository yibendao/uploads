<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 14:38:21
         compiled from "D:\phpStudy\WWW\uploads\\app\template\ask\footer.htm" */ ?>
<?php /*%%SmartyHeaderCode:3180659cf3bdd27fec7-09255181%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7879e9cd202fb439bf8175e955b4c2734d6b3350' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\ask\\footer.htm',
      1 => 1491894108,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3180659cf3bdd27fec7-09255181',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf3bdd2b7035_34276535',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf3bdd2b7035_34276535')) {function content_59cf3bdd2b7035_34276535($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><div id="formsg" class="none" style="width: 350px; ">   
	<form action="<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'save'),$_smarty_tpl);?>
" target="supportiframe" method="post" id="formstatus">
		<table cellspacing='2' cellpadding='3' width='330px' align="center"> 
          <tr> 
            <td align="left"><textarea id="statusbody"  name="content" class="ask_textarea_tw"></textarea></td>
          </tr>
          <tr style="text-align:center;margin-top:10px">
            <td ><input type="submit" name='submit' value='确认' class="submit_btn">
              &nbsp;&nbsp;
              <input type="button"  onClick="layer.closeAll();" class="cancel_btn" value='取消'></td>
          </tr>
        </table> 
        <input name="uid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['uid'];?>
" type="hidden">
	</form> 
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
