<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:50:28
         compiled from "D:\phpStudy\WWW\uploads\\app\template\member\user\footer.htm" */ ?>
<?php /*%%SmartyHeaderCode:2870959cdb4f4d921f4-45415194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58f591aeecd598e56302a7ee8a1d69667d1949c0' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\member\\user\\footer.htm',
      1 => 1501490222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2870959cdb4f4d921f4-45415194',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'statis' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdb4f4df4e19_51058965',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdb4f4df4e19_51058965')) {function content_59cdb4f4df4e19_51058965($_smarty_tpl) {?><div class="Commissioned_Resume_box" style="position:absolute; display:none;background:none">
    <div class="Commissioned_Resume_cont  ">
        <div class="com_resume_ct">ί�м���������Ա������Ա�����ļ����Ƽ�����ҵ</div>
        <table class="Commissioned_table" cellpadding="1" cellspacing="1" style="width:510px;">
            <tbody>
                <tr>
                    <th>��������</th>
                    <th>�绰����</th>
                    <th>��������</th>
                    <th>��������</th>
                    <th>״̬</th>
                    <th>����</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="entr_resume" style="display:none; width: 300px;">
    <div style="height: 160px;" class="job_box_div">
        <div class="job_box_title">
			<div class="resume_ask_qr">
				<span class="resume_ask" style="margin-left:10px;"></span>
				<em>ί�м������۳���<?php echo $_smarty_tpl->tpl_vars['config']->value['pay_trust_resume'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</em>
			</div>
        </div>
    <div class="job_box_msg" style="margin-left:10px;_margin-left:5px;margin-top:10px; padding:5px;background:#f8f8f8;border:1px solid #ccc">
        <p>��ʾ�������ǰ��������ҵ��������Ǿ�ί�м����ɣ�</p>
    </div>
    <div class="job_box_inp">
        <span class="job_box_botton" style="width:71px; margin-top:0px;">
            <a class="job_box_yes job_box_botton2" href="javascript:void(0);" style="margin-top:0px;">ȷ��</a>
        </span>
    </div>
</div>
</div>
<?php echo '<script'; ?>
>
function cktopspan(day,price){
	var disval=$('input[name="dis"]:checked ').val();
	if(disval&&day!=disval){
		$("input[name=dis][value="+disval+"]").attr("checked",false);
	}
	$("input[name=dis][value="+day+"]").attr("checked",true);
	var needs=day*price;
	$("#price").html(needs);
}
<?php echo '</script'; ?>
>
<div id="resumetop" style="display:none;">
    <div class="admin_Operating_sh" style="padding:10px; ">
     <form action="index.php?c=resume&act=rtop" target="supportiframe" name="myform" method="post">
         <div class="stick_msg">�ö�������<i id="resumename"></i></div>
         <div class="stick_msg">�ö�����ʱ�䣺<span id='topdate'></span></div>
         <div class="stick_tm">
              <div class="stick_tm_ft">�ö�ʱ����</div>
              <ul class="stick_tm_box">
                   <lable for="dis1">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="1" name="dis" onclick="cktop('1','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('1','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">1��</span>
                          </li>
                   </lable>
                   <lable for="dis3">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="3" name="dis" onclick="cktop('3','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('3','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">3��</span>
                          </li>
                   </lable>
                   <lable for="dis7">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="7" name="dis" onclick="cktop('7','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('7','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">7��</span>
                          </li>
                   </lable>
                   <lable for="dis15">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="15" name="dis" onclick="cktop('15','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('15','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">15��</span>
                          </li>
                   </lable>
                   <lable for="dis30">
                          <li style="margin-top:10px;">
                              <input type="radio" class="stick_tm_box_radio" value="30" name="dis" onclick="cktop('30','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('30','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">30��</span>
                          </li>
                   </lable>
              </ul>
         </div>
         <div class="stick_rage">
              <span>Ӧ��<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
��<em id="price">0</em><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];?>
</span> <br/>
              <span>����ǰ����<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
��<em><?php echo $_smarty_tpl->tpl_vars['statis']->value['integral'];?>
</em><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];?>
</span>
         </div>
         <div class="stick_rage_bt">
              <input type="hidden" name="eid" value="">
              <input class="stick_rage_bt_but" type="submit" name="submit" value="ȷ��֧��"/>
         </div>
         </form>
    </div>
</div>
<div class="clear"></div>
<div class=foot>
<div class="copyright"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webcopyright'];
echo $_smarty_tpl->tpl_vars['config']->value['sy_webrecord'];?>
  <div class="">��ַ:<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webadd'];?>
  �绰(Tel):<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
  EMAIL:<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webemail'];?>
</div>
<div class="">Powered By <a target="_blank" href="http://www.phpyun.com">PHPYun.</a></div>
</div>
     
</div>
<div id="uclogin" style="display:none"></div>
<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
</body>
</html><?php }} ?>
