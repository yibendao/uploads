<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 15:00:56
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\finder.htm" */ ?>
<?php /*%%SmartyHeaderCode:2778659cf4128bee5b2-61776820%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b75294d3ad9d84d9aec002affd372c6301b3147' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\finder.htm',
      1 => 1489137120,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2778659cf4128bee5b2-61776820',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'finder' => 0,
    'flist' => 0,
    'addnew' => 0,
    'config_com_finder_num' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf4128da02e5_70543982',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf4128da02e5_70543982')) {function content_59cf4128da02e5_70543982($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="w1000">
  <div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class=right_box>
      <div class=admincont_box>
           <div class="com_tit"><span class="com_tit_span">人才搜索器</span> 
        </div>
        <div class="com_body"> 
        <div class=admin_textbox_04>
        <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>      
        <?php  $_smarty_tpl->tpl_vars['flist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['flist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['finder']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['flist']->key => $_smarty_tpl->tpl_vars['flist']->value) {
$_smarty_tpl->tpl_vars['flist']->_loop = true;
?> 
            <ul class="index_Job_Finder_ul fltL">
            <li class="index_Job_Finder fltL">
            <i class="index_Job_Finder_icon fltL png"></i>
            <div class="index_Job_Finder_cont fltL">
            <div class="index_Job_Finder_cont_name">
            <a class="index_Job_Finder_cont_name_a" href="<?php echo $_smarty_tpl->tpl_vars['flist']->value['url'];?>
"><?php if ($_smarty_tpl->tpl_vars['flist']->value['name']) {
echo $_smarty_tpl->tpl_vars['flist']->value['name'];
} else { ?>未命名<?php }?></a>
            </div>
            <div class="index_Job_Finder_cont_name_condition">搜索条件：<?php echo $_smarty_tpl->tpl_vars['flist']->value['findername'];?>
</div>
            <div class="index_Job_Finder_cont_search">
            <a class="index_Job_Finder_cont_search_a" href="<?php echo $_smarty_tpl->tpl_vars['flist']->value['url'];?>
" target="_blank" title="搜索">立即搜索</a>
           <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['flist']->value['addtime'],'%Y-%m-%d %H:%M');?>

            </div>
            </div>
            <div class="index_Job_Finder_Operating fltL">
            	<a href="index.php?c=finder&act=edit&id=<?php echo $_smarty_tpl->tpl_vars['flist']->value['id'];?>
" title="修改">修改</a>
            |
            <a class="re_sc" onclick="layer_del('确定要删除？', 'index.php?c=finder&act=del&id=<?php echo $_smarty_tpl->tpl_vars['flist']->value['id'];?>
');" href="javascript:void(0)">删除</a>
            </div>
            </li>
             </ul>
             <?php }
if (!$_smarty_tpl->tpl_vars['flist']->_loop) {
?>
            
              <?php } ?>
			  <?php if ($_smarty_tpl->tpl_vars['addnew']->value) {?>
               <div class="index_Job_Finder_bot fltL">
               <div class="job_scq_gs">您总共可以拥有<?php echo $_smarty_tpl->tpl_vars['config_com_finder_num']->value;?>
个搜索器</div>
				<input class="job_new_tj" type="button" value="添加搜索器" onclick="location.href='index.php?c=finder&act=edit'" style="float:none">
				
				</div> 
			<?php }?>
			<div style="clear:both"></div>
            <div class="diggg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
        </div>
      </div>
    </div>    </div>    
	</div>
	</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
