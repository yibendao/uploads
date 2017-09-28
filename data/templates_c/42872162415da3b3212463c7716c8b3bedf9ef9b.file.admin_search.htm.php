<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 00:12:06
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_search.htm" */ ?>
<?php /*%%SmartyHeaderCode:1790059cd1f56cdc665-89844484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42872162415da3b3212463c7716c8b3bedf9ef9b' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_search.htm',
      1 => 1490926598,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1790059cd1f56cdc665-89844484',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'search_list' => 0,
    'row' => 0,
    'v' => 0,
    't' => 0,
    'k' => 0,
    'r' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cd1f56ddfcc7_56540157',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cd1f56ddfcc7_56540157')) {function content_59cd1f56ddfcc7_56540157($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.searchurl.php';
?>	  <div class="search_select">
        <?php if ($_GET['keyword']!='') {?>
        <a class="Search_jobs_c_a" href="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'untype'=>'keyword'),$_smarty_tpl);?>
">关键字：<?php echo $_GET['keyword'];?>
</a>
        <?php }?>
	</div>

<div class="clear"></div>
<div class="admin_screenlist_box">
<?php $_smarty_tpl->tpl_vars["v"] = new Smarty_variable(0, null, 0);?>
<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['search_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>
    <?php $_smarty_tpl->tpl_vars["t"] = new Smarty_variable($_smarty_tpl->tpl_vars['row']->value['param'], null, 0);?>
    <?php $_smarty_tpl->tpl_vars["v"] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value+1, null, 0);?>
    <div class="admin_screenlist" <?php if ($_smarty_tpl->tpl_vars['v']->value>3) {?>style="display:none"<?php }?>>
    <span class="admin_screenlist_name"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
：</span>
    	<a href="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'untype'=>$_smarty_tpl->tpl_vars['t']->value),$_smarty_tpl);?>
" <?php if ($_GET[$_smarty_tpl->tpl_vars['t']->value]!==true&&$_GET[$_smarty_tpl->tpl_vars['t']->value]=='') {?>class="admin_screenlist_cur"<?php }?>>全部</a>
        <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['row']->value['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['r']->key;
?>
            <a href="<?php echo smarty_function_searchurl(array('m'=>$_GET['m'],'c'=>$_GET['c'],'adv'=>$_smarty_tpl->tpl_vars['k']->value,'adt'=>$_smarty_tpl->tpl_vars['t']->value,'untype'=>$_smarty_tpl->tpl_vars['t']->value),$_smarty_tpl);?>
" 
            <?php if ($_GET[$_smarty_tpl->tpl_vars['t']->value]!==false&&$_GET[$_smarty_tpl->tpl_vars['t']->value]!=''&&$_GET[$_smarty_tpl->tpl_vars['t']->value]==$_smarty_tpl->tpl_vars['k']->value) {?>
            class="admin_screenlist_cur"
            <?php }?>><?php echo $_smarty_tpl->tpl_vars['r']->value;?>
</a> 
        <?php } ?>   
    </div>
<?php } ?>
<?php if ($_smarty_tpl->tpl_vars['v']->value>3) {?>
<div class="admin_screenlist_more"><a href="javascript:;" onclick="searchmore()">展开更多条件</a></div>
<?php }?>
</div>
<?php echo '<script'; ?>
>
function searchmore(){
    var html=$(".admin_screenlist_more a").html();
	if(html=='展开更多条件'){
	    $('.admin_screenlist:gt(2)').toggle();
		$(".admin_screenlist_more a").html('收起更多条件');
	}else{
	    $('.admin_screenlist:gt(2)').toggle();
		$(".admin_screenlist_more a").html('展开更多条件');
	}
	
}
<?php echo '</script'; ?>
><?php }} ?>
