<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:19:29
         compiled from "D:\phpStudy\WWW\uploads\\app\template\default\public_search\resume_include.htm" */ ?>
<?php /*%%SmartyHeaderCode:1531459cbb371d7a1b7-99197692%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '034d0e656f89d49231f04f6da6def3e45286e7a7' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\default\\public_search\\resume_include.htm',
      1 => 1489664330,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1531459cbb371d7a1b7-99197692',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'company_job' => 0,
    'v' => 0,
    'Info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb371df2539_65226796',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb371df2539_65226796')) {function content_59cbb371df2539_65226796($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><div id="packlist" class="none">
<iframe id="fdingdan"  name="fdingdan" onload="returnmessage('fdingdan');" class="dn"></iframe>
<form action="<?php echo smarty_function_url(array('m'=>'member','c'=>'pay','act'=>'dingdan'),$_smarty_tpl);?>
" method="post" target="fdingdan" id='myform' onSubmit="return checkpack();">
<input type="hidden" id="buypack" value="1"/>
<div class="Download_resume_tips">
<div class="Download_resume_cont" id="ratinglist">

</div>
<div class="Download_resume_tips_jine none">应付金额：<em class="Download_resume_tips_f">￥460</em></div>
<div class="Download_resume_tips_bth"><input type="submit" value="立即购买" class="Download_resume_tips_sub"></div>
</div>
</form>
</div>

<div id='job_box' class="none" style="float:left">


<div class="r_Interview" style="z-index:10"><span class="Interview_span">面试职位：</span>
<div class="Interview_text_box">
<input type="button" value="请选择" class="Interview_text_box_t"  id="name" onClick="search_show('job_name');"/>
<input type="hidden" id="nameid" name="name" value=''/>
<div class="Interview_text_box_list none" id="job_name">
<ul>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['company_job']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>    
<li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
', 'name', '<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
');"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
<?php } ?> 
</ul>
</div>
</div></div>
<div class="r_Interview" style="z-index:9"><span class="Interview_span">联系人：</span><input size='5'  id='linkman' value='' class="Interview_text Interview_text_w200"/></div>
<div class="r_Interview"><span class="Interview_span">联系电话：</span><input size='19'  id='linktel' value='' class="Interview_text"/></div>
<div class="r_Interview"><span class="Interview_span">面试时间：</span><input size='40' id='intertime' value=''  class="Interview_text  Interview_text_w200"/></div>
<div class="r_Interview"><span class="Interview_span">面试地址：</span><input size='40' id='address' value=''  class="Interview_text"/></div>
<div class="r_Interview"><span class="Interview_span">面试备注：</span><textarea id="content" cols="40" rows="5"  class="Interview_textarea_text"></textarea></div>
<div class="r_Interview " style="padding-bottom:20px;"><span class="Interview_span">&nbsp;</span><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
" id="eid">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
" id="uid"/>
		<input type="hidden" id="username" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['name'];?>
"/> 
		<input class="resume_sub_yq" id="click_invite" type="button" value="邀请面试"  />
        
        </div>
 </div>
 
<div id="talent_pool_beizhu" class="none">
<div class="resume_beizu" style="margin-left:18px; margin-top:18px;"><textarea id="remark" cols="40" rows="5" class="resume_beizu_text" style="width:340px;height:90px;border:1px solid #ddd"></textarea></div>
<div style="text-align:center; padding:10px 0;"><input type="button" value="保存" onClick="talent_pool('<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
','<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'talent_pool'),$_smarty_tpl);?>
')" class="resume_beizu_bth"/></div>
</div>
<?php echo '<script'; ?>
>
function search_show(id){
	$("#"+id).show();
}
function selects(id,type,name){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#"+type+"id").val(id);
	
}
$(document).ready(function () {
   $('body').click(function (evt) {		
	if($(evt.target).parents("#name").length==0 && evt.target.id != "name") {
	   $('#job_name').hide();
	}
  });
})
<?php echo '</script'; ?>
><?php }} ?>
