<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 15:01:10
         compiled from "D:\phpStudy\WWW\uploads\app\template\ask\myanswer.htm" */ ?>
<?php /*%%SmartyHeaderCode:2677659cf4136470233-70166834%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e0d62bddc7bd50bc5a0afd15ef78bb6561402dc' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\ask\\myanswer.htm',
      1 => 1492523048,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2677659cf4136470233-70166834',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'uid' => 0,
    'rows' => 0,
    'alist' => 0,
    'pagenav' => 0,
    'config' => 0,
    'ask_style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf41366138f2_56208371',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf41366138f2_56208371')) {function content_59cf41366138f2_56208371($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?>  
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
  
<div class="answer_con">
	<div class="content con_answer"> 
		<div class="content_hot ">
			<div class="left left_con">
               <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/nav.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
        <div class="answer_content fl">
          <div class="answer_content_top fl"><span><?php if ($_smarty_tpl->tpl_vars['uid']->value&&($_GET['uid']==''||$_GET['uid']==$_smarty_tpl->tpl_vars['uid']->value)) {?> 我的回答<?php } elseif ($_GET['uid']) {?>他的回答<?php }?></span></div>
		  <div class="">
		   <div class=" ">
			<div class="">
					
                    <div class="wt_content_t fl">
						<?php  $_smarty_tpl->tpl_vars['alist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['alist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['alist']->key => $_smarty_tpl->tpl_vars['alist']->value) {
$_smarty_tpl->tpl_vars['alist']->_loop = true;
?>
						<div class="ask_anwser_items fl">
						<div class="ask_anwser_title fl"><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'content','id'=>'`$alist.qid`'),$_smarty_tpl);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['alist']->value['title'];?>
</a></div>
						<div class="ask_anwser_on_t">
						<div class="ask_anwser_tra"></div>
						<?php echo $_smarty_tpl->tpl_vars['alist']->value['content'];?>
<font color="#999" style="padding-left:30px;"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['alist']->value['add_time'],"%Y-%m-%d");?>
</font>
						<?php if ($_smarty_tpl->tpl_vars['uid']->value==$_smarty_tpl->tpl_vars['alist']->value['uid']) {?>
									<span class="friend_delect" style="float:right"><a href="javascript:void(0)" onclick="layer_del('确定要删除该提问？','<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'delask','type'=>1,'id'=>$_smarty_tpl->tpl_vars['alist']->value['id']),$_smarty_tpl);?>
')">删除</a></span>
									<?php }?>
						</div>
						</div>
						<?php }
if (!$_smarty_tpl->tpl_vars['alist']->_loop) {
?>  
						<div class="noresult">
						<span>
						<a class="noresult_cr" href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'index'),$_smarty_tpl);?>
#answer">暂无数据！</a>
						</span>
						</div>
						<?php } ?>  
                    </div>
                   
					<div class="clear"></div>
					<div class="pages"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div> 
				</div>	
		     </div>
	         </div>
            </div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/right.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		</div>
	</div>
</div>  
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ask_style']->value;?>
/js/question.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png,.attention .watch_gz');
<?php echo '</script'; ?>
>
<![endif]-->
<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
   

<?php }} ?>
