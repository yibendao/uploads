<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 16:30:12
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\down.htm" */ ?>
<?php /*%%SmartyHeaderCode:1740359ce4af8311c31-13796514%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b12ba197c36ba643157c87a873e13252ab312e4' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\down.htm',
      1 => 1506760195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1740359ce4af8311c31-13796514',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce4af850ed86_25850855',
  'variables' => 
  array (
    'comstyle' => 0,
    'now_url' => 0,
    'rows' => 0,
    'v' => 0,
    'com_style' => 0,
    'report' => 0,
    'pagenav' => 0,
    'total' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce4af850ed86_25850855')) {function content_59ce4af850ed86_25850855($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
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
          <input name="c" type="hidden" value="down">
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
            <div class="" style="margin-top:10px;">
              <div id="job_checkbokid">
              <?php if (!empty($_smarty_tpl->tpl_vars['rows']->value)) {?>
                <div class="job_news_list job_news_list_h1"> 
                <span class="job_news_list_span job_w30">&nbsp;</span> 
                 <span class="job_news_list_span job_w80" style="text-align:left">姓名</span> 
                 <span class="job_news_list_span job_w270">求职意向</span> 
                 <span class="job_news_list_span job_w100">工作经验</span> 
                <span class="job_news_list_span job_w100">期望薪资</span> 
                <span class="job_news_list_span job_w120">下载时间</span> 
                <span class="job_news_list_span job_w150" style="text-align:center">操作</span> 
                </div>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="job_news_list"> <span class="job_news_list_span job_w30" style="padding-right:6px;">
                  <input type="checkbox" name="delid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  class="com_Release_job_qx_check" style="margin-top:2px;">
                  </span>
                  <span class="job_news_list_span job_w80" style="text-align:left"><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.eid`'),$_smarty_tpl);?>
"  target=_blank class="com_Release_name" ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
&nbsp;</a>
				  <?php if ($_smarty_tpl->tpl_vars['v']->value['height_status']==2) {?><img src="<?php echo $_smarty_tpl->tpl_vars['com_style']->value;?>
/images/yun_gj.png" title="高级简历"><?php }?></span>
                  <span class="job_news_list_span job_w270"><span class="yxjob_name"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
</span>&nbsp;</span>  
                   <span class="job_news_list_span job_w100"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
&nbsp;</span> 
                   <span class="job_news_list_span job_w100"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?>&nbsp;</span> 
                   <span class="job_news_list_span job_w120"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['downtime'],'%Y-%m-%d');?>
&nbsp;</span> 
                
                   <span class="job_news_list_span job_w150" style="text-align:center"> <?php if ($_smarty_tpl->tpl_vars['v']->value['userid_msg']==1) {?> <font color="#aaa">已经邀请</font> <?php } else { ?> <a href="javascript:;" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" id="b" class="sq_resume uesr_name_a" style="position:relative; "> 邀请面试</a> <?php }?> 
                  <?php if ($_smarty_tpl->tpl_vars['report']->value==1) {?> 
                  <span class="com_m_line">|</span> <a href="javascript:;" r_uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" eid="<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
" r_name="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" id="r"  class="status uesr_name_a" >举报</a><?php }?> <span class="com_m_line">|</span> <a href="javascript:void(0)" onclick="layer_del('确定要删除？','<?php echo $_smarty_tpl->tpl_vars['now_url']->value;?>
&act=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" class="uesr_name_a">删除</a> </span>
                   </div>
                <?php } ?>
                <div>
                  <div class="com_Release_job_bot"> <span class="com_Release_job_qx">
                    <input id='checkAll'  type="checkbox" onclick='m_checkAll(this.form)' class="com_Release_job_qx_check">
                    全选</span>
                    <INPUT class="c_btn_02"  type="button" name="subdel" value="批量删除" onclick="return Delete('delid[]');">
                    <INPUT class="c_btn_02"  type="button" name="subdel" value="批量导出" onclick="check_xls('delid[]');">
                  </div>
                  <div class="diggg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
                </div>
                <?php } elseif ($_GET['keyword']!='') {?>
                 <div class="msg_no"><p>没有搜索到下载简历！</p>
                 <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit">我要主动找人才</a></div>
                <?php } else { ?>
                 <div class="msg_no"><p>亲爱的用户，目前您还没有下载简历。</p>
                 <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit">我要主动找人才</a></div>
                <?php }?> </div>
              <?php if (!empty($_smarty_tpl->tpl_vars['rows']->value)) {?>
              <div class="wxts_box wxts_box_mt30">
			  <div class="wxts">温馨提示：</div>
			 您已下载（<span class="f60"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span>）份简历,  <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="fb_Com_xz"  target="_blank" style="text-align:center; line-height:25px;">找人才</a><br>       
			</div>
              <?php }?>
			  </div>
              <div  class="clear"></div>
    
          </form>
          <div class="clear"></div>
          <div class="infoboxp22" id="infobox" style="display:none; ">
            <div>
              <form action="index.php?c=down&act=report" method="post" id="formstatus" target="supportiframe">
                <input name="r_uid" value="0" type="hidden">
                <input name="eid" value="0" type="hidden">
                <input name="r_name" value="0" type="hidden">
                <div class="jb_infobox" style="width: 100%;">
                  <textarea id="alertcontent" style="width:310px;margin:5px" name="r_reason" cols="30" rows="9" class="hr_textarea"></textarea>
                </div>
                <div class="jb_infobox" style="width: 100%;">
                  <button type="submit"   name='submit' value='1' class="submit_btn" style="margin-left:80px;">确认</button>
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
function Delete(name){
	var chk_value =[];    
	$('input[name="'+name+'"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});   
	if(chk_value.length==0){
		layer.msg("请选择要删除的数据！",2,8);return false;
	}else{
		layer.confirm("确定删除吗？",function(){
			$("#myform").attr("action","index.php?c=down&act=del");
			setTimeout(function(){$('#myform').submit()},0); 
		});
	} 
} 
function check_xls(name){
	var chk_value =[];    
	$('input[name="'+name+'"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});
	if(chk_value.length==0){
		layer.msg("请选择您要导出的数据！",2,8);return false;
	}else{
		layer.confirm("确定导出吗？",function(){
			$("#myform").attr("action","index.php?c=down&act=xls");
			setTimeout(function(){$('#myform').submit()},0); 
			layer.closeAll();
		});
	} 
}	
$(document).ready(function(){ 
	$('#zxxCancelBtn').click(function(){
		layer.closeAll();
	});
	$(".status").click(function(){
		$("input[name=eid]").val($(this).attr("eid"));
		$("input[name=r_uid]").val($(this).attr("r_uid"));
		$("input[name=r_name]").val($(this).attr("r_name")); 
		$.layer({
			type : 1,
			title :'举报', 
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['320px','160px'],
			page : {dom :"#infobox"}
		});
	}); 
}); 
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
