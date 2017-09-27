<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:22:49
         compiled from "D:\phpStudy\WWW\uploads\\app\template\member\user\footer.htm" */ ?>
<?php /*%%SmartyHeaderCode:1285759cbb439af1989-21009711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '1285759cbb439af1989-21009711',
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
  'unifunc' => 'content_59cbb439c17497_63976720',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb439c17497_63976720')) {function content_59cbb439c17497_63976720($_smarty_tpl) {?><div class="Commissioned_Resume_box" style="position:absolute; display:none;background:none">
    <div class="Commissioned_Resume_cont  ">
        <div class="com_resume_ct">委托简历给管理员，管理员将您的简历推荐给企业</div>
        <table class="Commissioned_table" cellpadding="1" cellspacing="1" style="width:510px;">
            <tbody>
                <tr>
                    <th>简历名称</th>
                    <th>电话号码</th>
                    <th>简历类型</th>
                    <th>更新日期</th>
                    <th>状态</th>
                    <th>操作</th>
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
				<em>委托简历将扣除您<?php echo $_smarty_tpl->tpl_vars['config']->value['pay_trust_resume'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</em>
			</div>
        </div>
    <div class="job_box_msg" style="margin-left:10px;_margin-left:5px;margin-top:10px; padding:5px;background:#f8f8f8;border:1px solid #ccc">
        <p>提示：让我们帮您快速找到工作，那就委托简历吧！</p>
    </div>
    <div class="job_box_inp">
        <span class="job_box_botton" style="width:71px; margin-top:0px;">
            <a class="job_box_yes job_box_botton2" href="javascript:void(0);" style="margin-top:0px;">确定</a>
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
         <div class="stick_msg">置顶简历：<i id="resumename"></i></div>
         <div class="stick_msg">置顶结束时间：<span id='topdate'></span></div>
         <div class="stick_tm">
              <div class="stick_tm_ft">置顶时长：</div>
              <ul class="stick_tm_box">
                   <lable for="dis1">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="1" name="dis" onclick="cktop('1','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('1','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">1天</span>
                          </li>
                   </lable>
                   <lable for="dis3">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="3" name="dis" onclick="cktop('3','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('3','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">3天</span>
                          </li>
                   </lable>
                   <lable for="dis7">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="7" name="dis" onclick="cktop('7','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('7','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">7天</span>
                          </li>
                   </lable>
                   <lable for="dis15">
                          <li>
                              <input type="radio" class="stick_tm_box_radio" value="15" name="dis" onclick="cktop('15','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('15','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">15天</span>
                          </li>
                   </lable>
                   <lable for="dis30">
                          <li style="margin-top:10px;">
                              <input type="radio" class="stick_tm_box_radio" value="30" name="dis" onclick="cktop('30','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')"/>
                              <span class="stick_tm_box_time" onclick="cktopspan('30','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_resume_top'];?>
')">30天</span>
                          </li>
                   </lable>
              </ul>
         </div>
         <div class="stick_rage">
              <span>应付<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：<em id="price">0</em><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];?>
</span> <br/>
              <span>您当前可用<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：<em><?php echo $_smarty_tpl->tpl_vars['statis']->value['integral'];?>
</em><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];?>
</span>
         </div>
         <div class="stick_rage_bt">
              <input type="hidden" name="eid" value="">
              <input class="stick_rage_bt_but" type="submit" name="submit" value="确定支付"/>
         </div>
         </form>
    </div>
</div>
<div class="clear"></div>
<div class=foot>
<div class="copyright"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webcopyright'];
echo $_smarty_tpl->tpl_vars['config']->value['sy_webrecord'];?>
  <div class="">地址:<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webadd'];?>
  电话(Tel):<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
  EMAIL:<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webemail'];?>
</div>
<div class="">Powered By <a target="_blank" href="http://www.phpyun.com">PHPYun.</a></div>
</div>
     
</div>
<div id="uclogin" style="display:none"></div>
<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
</body>
</html><?php }} ?>
