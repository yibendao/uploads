<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 16:31:40
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\talent_pool.htm" */ ?>
<?php /*%%SmartyHeaderCode:724159ce5aab8525e4-44611226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '004de8040ad7d8d248fc13069ae07c2214220f49' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\talent_pool.htm',
      1 => 1506760247,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '724159ce5aab8525e4-44611226',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce5aab9c9f25_81179374',
  'variables' => 
  array (
    'comstyle' => 0,
    'now_url' => 0,
    'rows' => 0,
    'v' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce5aab9c9f25_81179374')) {function content_59ce5aab9c9f25_81179374($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
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
         <li <?php if ($_GET['c']=="hr") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=hr">应聘简历</a></li>
         <li <?php if ($_GET['c']=="down") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=down">已下载简历</a></li>
         <li <?php if ($_GET['c']=="talent_pool") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=talent_pool">收藏简历</a></li>
         <li <?php if ($_GET['c']=="look_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=look_resume">浏览简历</a></li>
         <li <?php if ($_GET['c']=="record") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=record" title="网站为您推荐的简历">网站推荐简历</a></li>
         <li <?php if ($_GET['c']=="my_create_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=my_create_resume" title="我创建的简历">我创建的简历</a></li>
         </ul>
         </div>
     <div class="clear"></div>
        <form action="index.php" method="get">
        <div class="news_search">
          <input name="c" type="hidden" value="talent_pool">
          <input name="keyword" type="text" class="news_text" placeholder="请输入简历关键字" value="<?php echo $_GET['keyword'];?>
">
          <input name="" type="submit" class="news_bth" value="搜索">
        </div>
        </form>
      <div class="com_body">
        <div class=admin_textbox_04>
          <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
          <form action="<?php echo $_smarty_tpl->tpl_vars['now_url']->value;?>
&act=del" target="supportiframe" method="post" id='myform'>
            <div class=table>
              <div id="job_checkbokid" >
               <?php if (!empty($_smarty_tpl->tpl_vars['rows']->value)) {?>
                <div class="job_news_list job_news_list_h1"> 
                <span class="job_news_list_span job_w30" style="padding-right:5px;">&nbsp;</span> 
                <span class="job_news_list_span job_w120" style="text-align:left">姓名</span>
                 <span class="job_news_list_span job_w160">求职意向</span>  
                <span class="job_news_list_span job_w120">工作经验</span> 
                <span class="job_news_list_span job_w140">期望薪资</span> 
                <span class="job_news_list_span job_w100">收藏时间</span> 
                <span class="job_news_list_span job_w150" style="text-align:center">操作</span>
                </div>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="job_news_list"> <span class="job_news_list_span job_w30" style="padding-right:5px;">
                  <input type=checkbox name="delid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"   class="com_Release_job_qx_check" style="margin-top:2px;">
                  </span> 
                   <span class="job_news_list_span job_w120" style="text-align:left">  
                   <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.eid`'),$_smarty_tpl);?>
" class="com_Release_name" target=_blank><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>&nbsp;</span> 
                  <span class="job_news_list_span job_w160"><span class="yxjob_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
&nbsp;</span></span> 
                 <span class="job_news_list_span job_w120"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
&nbsp;</span> 
                   <span class="job_news_list_span job_w140"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?>&nbsp;</span> 
                  <span class="job_news_list_span job_w100"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['ctime'],'%Y-%m-%d');?>
&nbsp;</span> 
                   <span class="job_news_list_span job_w150" style="text-align:center"> <?php if ($_smarty_tpl->tpl_vars['v']->value['userid_msg']==1) {?> <font color="red">已邀请</font> <?php } else { ?> <a href="javascript:;" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" class="sq_resume uesr_name_a" style="position:relative; "> 邀请面试</a> <?php }?> <span class="com_m_line">|</span> <a href="javascript:;" class="uesr_name_a" onclick="remark('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['remark'];?>
');">备注</a><span class="com_m_line">|</span> <a href="javascript:void(0)" onclick="layer_del('确定要删除？','<?php echo $_smarty_tpl->tpl_vars['now_url']->value;?>
&act=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="uesr_name_a">删除</a></span> </div>
                <?php } ?>
                <div>
                  <div class="com_Release_job_bot"> <span class="com_Release_job_qx">
                    <input id='checkAll'  type="checkbox" onclick='m_checkAll(this.form)' class="com_Release_job_qx_check">
                    全选</span>
                    <INPUT  class="c_btn_02" type="button" name="subdel" value="批量删除" onclick="return really('delid[]');">
                  </div>
                  <div class="diggg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
                </div>
                <?php } elseif ($_GET['keyword']!='') {?>
                 <div class="msg_no">
                   <p>没有搜索到简历记录！</p>
                   <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit"  target="_blank">我要主动找人才</a></div>
                <?php } else { ?>
                <div class="msg_no">
                   <p>亲爱的用户，目前还没有收藏简历记录！</p>
                   <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit"  target="_blank">我要主动找人才</a></div>
                <?php }?> </div>
            </div>
            <div> </div>
          </form>
          <div class="clear"></div>
          <div class="infoboxp22" id="infobox" style="display:none; ">
            <div>
              <form action="index.php?c=talent_pool&act=remark" method="post" id="formstatus" target="supportiframe">
                <input name="id" value="0" type="hidden">
                <div class="jb_infobox" style="width: 100%;">
                  <textarea id="remark" style="width:310px;margin:5px" name="remark" class="hr_textarea"></textarea>
                </div>
                <div class="jb_infobox" style="width: 100%;">
                  <button type="submit" name='submit' value='1' class="submit_btn" style="margin-left:80px;">确认</button>
                  &nbsp;&nbsp;
                  <button type="button" id='zxxCancelBtn'  class="cancel_btn">取消</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo '<script'; ?>
> 
function remark(id,remark){
	$("input[name=id]").val(id);
	$("#remark").val(remark);
	$.layer({
		type : 1,
		title :'备注', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['320px','160px'],
		page : {dom :"#infobox"}
	});
}
$(document).ready(function(){ 
	$('#zxxCancelBtn').click(function(){
		layer.closeAll();
	}); 
}); 
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
