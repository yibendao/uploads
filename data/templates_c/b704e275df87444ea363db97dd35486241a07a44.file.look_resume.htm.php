<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 16:31:44
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\look_resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:2276559ce5aae950e26-77167756%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b704e275df87444ea363db97dd35486241a07a44' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\look_resume.htm',
      1 => 1506760267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2276559ce5aae950e26-77167756',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce5aaeb1afd9_67237328',
  'variables' => 
  array (
    'comstyle' => 0,
    'rows' => 0,
    'v' => 0,
    'now_url' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce5aaeb1afd9_67237328')) {function content_59ce5aaeb1afd9_67237328($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link href="<?php echo $_smarty_tpl->tpl_vars['comstyle']->value;?>
/images/index_style.css" type=text/css rel=stylesheet>
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
        <div class=admin_textbox_04>
          <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
          <form action="index.php?c=look_resume&act=del" method="post" target="supportiframe" id='myform'>
            <div class=table>
              <div id="job_checkbokid">
              <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
                <div class="job_news_list job_news_list_h1"> 
                <span class="job_news_list_span job_w30" style="padding-right:5px;">&nbsp;</span> 
                <span class="job_news_list_span job_w80" style="text-align:left">姓名</span>
                <span class="job_news_list_span job_w270">求职意向</span> 
                <span class="job_news_list_span job_w120">工作经验</span> 
                <span class="job_news_list_span job_w100">期望薪资</span>
                <span class="job_news_list_span job_w120">浏览时间</span> 
                <span class="job_news_list_span job_w120">操作</span> 
                </div>
                <?php }?>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="job_news_list"> 
					<span class="job_news_list_span job_w30" style="padding-right:5px;">
						<input type='checkbox' name="delid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  class="com_Release_job_qx_check" style="margin-top:2px;">
					</span>
                    	<span class="job_news_list_span job_w80" style="text-align:left">
						<a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.resume_id`'),$_smarty_tpl);?>
" target="_blank" class="com_Release_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
&nbsp;</a>
					</span> 
					<span class="job_news_list_span job_w270"><span class="yxjob_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
&nbsp;</span></span> 
					<span class="job_news_list_span job_w120"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
&nbsp;</span>  
                   <span class="job_news_list_span job_w100"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?>&nbsp;</span> 
					<span class="job_news_list_span job_w120"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['datetime'],'%Y-%m-%d ');?>
&nbsp;</span> 
					<span class="job_news_list_span job_w120">
						<?php if ($_smarty_tpl->tpl_vars['v']->value['userid_msg']==1) {?> 
							<font color="#999">已邀请</font> 
						<?php } else { ?> 
							<a href="javascript:;" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" class="sq_resume uesr_name_a" style="position:relative; "> 邀请面试</a> 
						<?php }?> 
						<span class="com_m_line">|</span>  
						<a href="javascript:void(0)" onclick="layer_del('确定要删除？','<?php echo $_smarty_tpl->tpl_vars['now_url']->value;?>
&act=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="uesr_name_a">删除</a>
					</span>
				</div>
                <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
                <div class="msg_no">
                   <p>亲爱的用户，目前您还没有浏览过简历！</p>
                   <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit">我要主动找人才</a></div>
                <?php } ?> </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
          <div class="com_Release_job_bot"> <span class="com_Release_job_qx">
              <input id='checkAll'  type="checkbox" onclick='m_checkAll(this.form)' class="com_Release_job_qx_check">
              全选</span>
              <input  class="c_btn_02" type="button" name="subdel" value="批量删除" onclick="return really('delid[]');">
            </div>
        <div class="clear"></div>
            <div class="diggg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
            <?php }?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
