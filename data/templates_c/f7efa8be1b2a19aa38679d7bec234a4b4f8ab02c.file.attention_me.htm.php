<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 15:01:00
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\attention_me.htm" */ ?>
<?php /*%%SmartyHeaderCode:1402059cf412ce0b872-43326710%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7efa8be1b2a19aa38679d7bec234a4b4f8ab02c' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\attention_me.htm',
      1 => 1491894094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1402059cf412ce0b872-43326710',
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
  'unifunc' => 'content_59cf412d0203e2_93748946',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf412d0203e2_93748946')) {function content_59cf412d0203e2_93748946($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="w1000">
<div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <link href="<?php echo $_smarty_tpl->tpl_vars['comstyle']->value;?>
/images/index_style.css" type=text/css rel=stylesheet>
  <div class=right_box>
    <div class=admincont_box>
      <div class="com_tit"> <span class="com_tit_span">��ע�ҵ��˲�</span>
        <form action="index.php" method="get">
        <div class="news_search">
          <input name="c" type="hidden" value="attention_me">
          <input name="keyword" type="text" class="news_text" placeholder="����������ؼ���" value="<?php echo $_GET['keyword'];?>
">
          <input name="" type="submit" class="news_bth" value="����">
        </div>
        </form>
      </div>
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
                    <span class="job_news_list_span job_w120" style="text-align:left">����</span>
                     <span class="job_news_list_span job_w190">��ְ����</span>  
                    <span class="job_news_list_span job_w100">��������</span> 
                    <span class="job_news_list_span job_w120">����н��</span> 
                    <span class="job_news_list_span job_w100">��עʱ��</span> 
                    <span class="job_news_list_span job_w150" style="text-align:center">����</span>
                </div>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="job_news_list"> 
				<span class="job_news_list_span job_w30" style="padding-right:5px;">&nbsp;</span> 
                 <span class="job_news_list_span job_w120" style="text-align:left">  
                   <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.id`'),$_smarty_tpl);?>
"  class="com_Release_name" target=_blank><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
&nbsp;</a></span> 
                  <span class="job_news_list_span job_w190"><span class="yxjob_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
&nbsp;</span></span> 
                 <span class="job_news_list_span job_w100"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
&nbsp;</span> 
                   <span class="job_news_list_span job_w120"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>��<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>��<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
����<?php } else { ?>����<?php }?>&nbsp;</span> 
                  <span class="job_news_list_span job_w100"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['time'],'%Y-%m-%d');?>
</span> 
                   <span class="job_news_list_span job_w150" style="text-align:center"> 
					<?php if ($_smarty_tpl->tpl_vars['v']->value['userid_msg']==1) {?> <font color="red">������</font> <?php } else { ?> <a href="javascript:;" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
" class="sq_resume uesr_name_a" style="position:relative;">��������</a> <?php }?> 
				   </span> 
				 </div>
                <?php } ?>
                <div>
                  <div class="com_Release_job_bot"> 
                  </div>
                  <div class="diggg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
                </div>
                <?php } elseif ($_GET['keyword']!='') {?>
                <div class="msg_no">û��������ע����ҵ���˲š� </div>
                <?php } else { ?>
                 <div class="msg_no">�װ����û���Ŀǰ��û���˲Ź�ע����
                   <p>���������������˲�����</p>
                   <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit">��Ҫ�������˲�</a></div>
                   
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
                  <button type="submit" name='submit' value='1' class="submit_btn" style="margin-left:80px;">ȷ��</button>
                  &nbsp;&nbsp;
                  <button type="button"   class="cancel_btn">ȡ��</button>
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
		title :'��ע', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['320px','160px'],
		page : {dom :"#infobox"}
	});
} 
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
