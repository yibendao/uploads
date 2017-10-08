<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 16:31:48
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\record.htm" */ ?>
<?php /*%%SmartyHeaderCode:981559cf56747f2b71-36627739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cd70a50ae75b1265266ec4d506e2ca917cf1072' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\record.htm',
      1 => 1506760290,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '981559cf56747f2b71-36627739',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comstyle' => 0,
    'now_url' => 0,
    'rows' => 0,
    'v' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf5674916002_83622137',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf5674916002_83622137')) {function content_59cf5674916002_83622137($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="w1000">
  <div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <link href="<?php echo $_smarty_tpl->tpl_vars['comstyle']->value;?>
/images/index_style.css" type=text/css rel=stylesheet>
    <div class=right_box>
      <div class=admincont_box>
      <div class="job_list_tit">
         <ul class="">
         <li <?php if ($_GET['c']=="hr") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=hr"  title="收到的职位申请简历">应聘简历</a></li>
         <li <?php if ($_GET['c']=="down") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=down"  title="您已下载的简历记录">已下载简历</a></li>
         <li <?php if ($_GET['c']=="talent_pool") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=talent_pool"  title="加入人才库的简历">收藏简历</a></li>
         <li <?php if ($_GET['c']=="look_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=look_resume"  title="您浏览简历的记录">浏览简历</a></li>
         <li <?php if ($_GET['c']=="record") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=record" title="网站为您推荐的简历">网站推荐简历</a></li>
         <li <?php if ($_GET['c']=="my_create_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=my_create_resume" title="我创建的简历">我创建的简历</a></li>
         </ul>
         </div>
        <div class="com_body">      
        <div class=admin_textbox_04>
          <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
          <form action="<?php echo $_smarty_tpl->tpl_vars['now_url']->value;?>
&act=del" target="supportiframe" method="post" id='myform'>
            <div class=table>
              <div id="job_checkbokid" >
              <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
                <div class="job_news_list job_news_list_h1"> 
                <span class="job_news_list_span job_w30">&nbsp;</span> 
              
                <span class="job_news_list_span job_w80">姓名</span> 
                <span class="job_news_list_span job_w160">求职意向</span> 
                <span class="job_news_list_span job_w80">工作经验</span> 
                <span class="job_news_list_span job_w100">期望薪资</span> 
                  <span class="job_news_list_span job_w155">职位名称</span>
                <span class="job_news_list_span job_w100">推送时间</span> 
                <span class="job_news_list_span job_w120">操作</span> 
                </div>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="job_news_list"> 
					<span class="job_news_list_span job_w30">
					<input type="checkbox" name="delid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"   class="com_Release_job_qx_check" style="margin-top:2px;"> </span>
				  
                <span class="job_news_list_span job_w80">&nbsp;<a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.eid`'),$_smarty_tpl);?>
" class="cblue" target=_blank><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</a></span> 
				<span class="job_news_list_span job_w160">&nbsp;<span class="yxjob_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobclassidname'];?>
</span></span> 
				<span class="job_news_list_span job_w80">&nbsp;<?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
</span> 
               	<span class="job_news_list_span job_w100">&nbsp;<?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?>&nbsp;</span> 
                <span class="job_news_list_span job_w155">
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$v.jobid`'),$_smarty_tpl);?>
" target="_blank" class="cblue"><?php echo $_smarty_tpl->tpl_vars['v']->value['job_name'];?>
&nbsp;</a>
				</span> 
				<span class="job_news_list_span job_w100">&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],'%Y-%m-%d');?>
</span> 
				
				<span class="job_news_list_span job_w120"> 
					<?php if ($_smarty_tpl->tpl_vars['v']->value['userid_msg']==1) {?> 
						<font color="red">已邀请</font> 
					<?php } else { ?>  
						<a href="javascript:;" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['resume_name'];?>
" class="sq_resume">邀请面试</a> 
					<?php }?>
                  |
				  <a href="javascript:void(0)" onclick="layer_del('确定删除该条信息？', 'index.php?c=record&act=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
'); ">删除</a> 
				 </span>
				</div>
                <?php } ?>
                <div class="com_Release_job_bot"> <span class="com_Release_job_qx">
                  <input id='checkAll'  type="checkbox" onclick='m_checkAll(this.form)'class="com_Release_job_qx_check">
                  全选</span>
                  <INPUT  class="c_btn_02" type="button" name="subdel" value="批量删除" onclick="return really('delid[]');">
                </div>
                <?php } else { ?>
                <div class="msg_no">网站暂时还没有为您推荐人才简历！</div>
                <?php }?> </div>
            </div>
            <div class="diggg mt10 fltR"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
            <div class="clear"></div>
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
