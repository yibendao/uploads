<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 00:12:05
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_right.htm" */ ?>
<?php /*%%SmartyHeaderCode:2606559cd1f554dca55-09588618%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12a19902a72d8b997b54d4aec8798833442a68b8' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_right.htm',
      1 => 1505105188,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2606559cd1f554dca55-09588618',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'nav_user' => 0,
    'dirname' => 0,
    'mruser' => 0,
    'url' => 0,
    'company_job' => 0,
    'company' => 0,
    'comcert' => 0,
    'once_job' => 0,
    'admin_link' => 0,
    'company_order' => 0,
    'comproduct' => 0,
    'comnews' => 0,
    'version' => 0,
    'soft' => 0,
    'kongjian' => 0,
    'banben' => 0,
    'yonghu' => 0,
    'server' => 0,
    'pytoken' => 0,
    'base' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cd1f556cc196_66174292',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cd1f556cc196_66174292')) {function content_59cd1f556cc196_66174292($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_searchurl')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.searchurl.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="images/reset.css" rel="stylesheet" type="text/css" /> 
<?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
> 
<title>��̨����</title>
<?php echo '<script'; ?>
> 
function killerrors() {return true;}
window.onerror = killerrors;
function logout(){
	if (confirm("��ȷ��Ҫ�˳����������"))
	top.location = 'index.php?c=logout';
	return false;
}
var integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
';  
<?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="./js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
  DD_belatedPNG.fix('.png,.header .logo,.header .nav li a,.header .nav li.on,.left_menu h3 span.on');
<?php echo '</script'; ?>
>
<![endif]-->
</head>
<body style="font-size:12px; padding-bottom:0; ">
<div id="sysinfobox" class="sysinfobox" style="display:none;">
	<?php echo '<script'; ?>
>
    	setTimeout("document.getElementById('sysinfobox').style.display='none'",10000);
    <?php echo '</script'; ?>
>
	<div class="sysinfoboxtop" id="sysinfoboxtop"><strong style="float:left;margin-left:10px;">��������</strong><span style="float:left;">(10����Զ��˳�)</span><span style="float:right;margin-right:10px;"><a href="#" onclick="javascript:document.getElementById('sysinfobox').style.display='none';">[�ر�]</a></span></div> 
</div>
<div style="height:455px;">
<div class="admin_index_center">
<div class="admin_message_left">
<div class="admin_message_left_cont">
<div class="admin_message_name"><span class="admin_message_up">��ã�</span><span class="admin_message_yun"><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['name'];?>
</span><a  href="javascript:void(0)" onclick="layer_logout('index.php?m=index&c=logout');" class="admin_message_zh">[�����ʻ�]</a></div>
<div class="admin_message_login">���ĵ�¼�ʻ���<strong><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['username'];?>
</strong>
������ɫ��<strong><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['group_name'];?>
</strong> �ϴε�¼ʱ�䣺<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['nav_user']->value['lasttime'],'%Y-%m-%d %H:%M:%S');?>
</div>
<div class="admin_message_jy">
    <?php if ($_smarty_tpl->tpl_vars['dirname']->value||$_smarty_tpl->tpl_vars['mruser']->value==1) {?><div>
        <?php if ($_smarty_tpl->tpl_vars['dirname']->value) {?>
     <p class="admin_message_jy_p">ǿ�ҽ��齫 <?php echo $_smarty_tpl->tpl_vars['dirname']->value;?>
 �ļ�������Ϊ�������ƣ�
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['mruser']->value==1) {?>
       û�и���Ĭ�ϵĹ���Ա���ƺ�����!</p><a href="index.php?m=admin_user&c=pass" class="admin_message_jy_pd">�������޸ġ�</a><?php }?>
        </div>
	<?php }?></div>
</div>
</div>
<div class="admin_message_right">
<div class="admin_message_left_cont">
<div class="admin_message_h1">��վ��Ϣ</div>
<div class="admin_message_list">
<?php if (in_array("index.php?m=admin_company_job",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('state'=>4,'m'=>'admin_company_job'),$_smarty_tpl);?>
"
<?php if (!$_smarty_tpl->tpl_vars['company_job']->value) {?> 
class="admin_message_bg"
<?php }?>
>�����ְλ��<strong><?php echo $_smarty_tpl->tpl_vars['company_job']->value;?>
</strong></a>
<?php }?>
<?php if (in_array("index.php?m=admin_company",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('status'=>4,'m'=>'admin_company'),$_smarty_tpl);?>
"
<?php if ($_smarty_tpl->tpl_vars['company']->value) {?> 
class="admin_message_bg2"
<?php } else { ?>
class="admin_message_bg"
<?php }?>
>�������ҵ��<strong><?php echo $_smarty_tpl->tpl_vars['company']->value;?>
</strong></a>
<?php }?>
<?php if (in_array("index.php?m=comcert",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('status'=>3,'m'=>'comcert'),$_smarty_tpl);?>
"
<?php if ($_smarty_tpl->tpl_vars['comcert']->value) {?> 
class="admin_message_bg3"
<?php } else { ?>
class="admin_message_bg"
<?php }?>
>�������ҵ��֤��<strong><?php echo $_smarty_tpl->tpl_vars['comcert']->value;?>
</strong></a>
<?php }?>
<?php if (in_array("index.php?m=admin_once",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('status'=>3,'m'=>'admin_once'),$_smarty_tpl);?>
"
<?php if ($_smarty_tpl->tpl_vars['once_job']->value) {?> 
class="admin_message_bg4"
<?php } else { ?>
class="admin_message_bg"
<?php }?>
>����˵�����Ƹ��<strong><?php echo $_smarty_tpl->tpl_vars['once_job']->value;?>
</strong></a>
<?php }?>
<?php if (in_array("index.php?m=link",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('state'=>2,'m'=>'link'),$_smarty_tpl);?>
"
<?php if ($_smarty_tpl->tpl_vars['admin_link']->value) {?> 
class="admin_message_bg5"
<?php } else { ?>
class="admin_message_bg"
<?php }?> 
>��������ӣ�<strong><?php echo $_smarty_tpl->tpl_vars['admin_link']->value;?>
</strong></a>    
<?php }?>
<?php if (in_array("index.php?m=company_order",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('order_state'=>3,'m'=>'company_order'),$_smarty_tpl);?>
"
<?php if ($_smarty_tpl->tpl_vars['company_order']->value) {?> 
class="admin_message_bg6"
<?php } else { ?>
class="admin_message_bg"
<?php }?> 
>����������<strong><?php echo $_smarty_tpl->tpl_vars['company_order']->value;?>
</strong></a>
<?php }?>
<?php if (in_array("index.php?m=comproduct",$_smarty_tpl->tpl_vars['url']->value)) {?>
<a href="<?php echo smarty_function_searchurl(array('status'=>3,'m'=>'comproduct'),$_smarty_tpl);?>
" 
<?php if ($_smarty_tpl->tpl_vars['comproduct']->value) {?> 
class="admin_message_bg5"
<?php } else { ?>
class="admin_message_bg"
<?php }?> 
>�������ҵ��Ʒ��<strong><?php echo $_smarty_tpl->tpl_vars['comproduct']->value;?>
</strong>
</a>   
<?php }?>
<?php if (in_array("index.php?m=comnews",$_smarty_tpl->tpl_vars['url']->value)) {?> 
<a href="<?php echo smarty_function_searchurl(array('status'=>3,'m'=>'comnews'),$_smarty_tpl);?>
" 
<?php if ($_smarty_tpl->tpl_vars['comnews']->value) {?> 
class="admin_message_bg6"
<?php } else { ?>
class="admin_message_bg"
<?php }?> 
>
�������ҵ���ţ�<strong><?php echo $_smarty_tpl->tpl_vars['comnews']->value;?>
</strong>
</a>
<?php }?>
</div>
</div>
</div>
</div>
<div class="admin_index_center">
<div class="admin_index_Data">
<div class="admin_index_Data_bor">
<div class="admin_message_h1">
<div class="admin_message_h1_tit">
    <span class="admin_message_h1_s admin_message_h1_cur" data-a="index_tj">����ͳ��</span>
    <span class="admin_message_h1_s" data-a="index_dt">��վ��̬</span>
    <span class="admin_message_h1_s" data-a="index_rz">��Ա��־</span>
    </div>
</div>
    <div class="admin_index_Data_cont" style=" position:relative"  id="index_tj">
        <div class="admin_index_Data_cont_left" style="width:850px; float:left;height:300px;">
            <div class="admin_index_fw" id="main22" style="width:800px;height:300px;">
                <iframe name="right" id="tbrightMain" src="index.php?m=admin_right&c=getweb" frameborder="false" scrolling="auto" style="border:none;" width="850" height="300" allowtransparency="true"></iframe>
            </div>
        </div>
        <div class="admin_index_date_list">
            <ul>
                <li><a href="javascript:clicktb('resumetj');" class="admin_index_date_a png">����ͳ��</a></li>
                <li><a href="javascript:clicktb('jobtj');" class="admin_index_date_b png">ְλͳ��</a></li>
                <li><a href="javascript:clicktb('comtj');" class="admin_index_date_c png">��ҵע��ͳ��</a></li>
                <li><a href="javascript:clicktb('getweb');" class="admin_index_date_d png">����ע��ͳ��</a></li>
                <li><a href="javascript:clicktb('newstj');" class="admin_index_date_e png">����ͳ��</a></li>
                <li><a href="javascript:clicktb('adtj');" class="admin_index_date_f png">�����ͳ��</a></li>
                <li><a href="javascript:clicktb('wzptj');" class="admin_index_date_g png">������Ƹͳ��</a></li>
                <li><a href="javascript:clicktb('wjltj');" class="admin_index_date_h png">�չ�����ͳ��</a></li>
                <li><a href="javascript:clicktb('payordertj');" class="admin_index_date_i png">��ֵͳ��</a></li>
            </ul>
        </div>
    </div>
    <div class="admin_index_Data_cont" style="position:relative; display:none" id="index_dt">
        <div class="admin_index_Data_cont_left" style="width:850px; float:left;height:300px;">
            <div class="admin_index_fw" id="main22" style="width:800px;height:300px;">
                <iframe name="right" id="tbrightMaindt" src="index.php?m=admin_right&c=downresumedt" frameborder="false" scrolling="auto" style="border:none;" width="850" height="300" allowtransparency="true"></iframe>
            </div>
        </div>
        <div class="admin_index_date_list">
	           <div class="" style="width:340px; float:left;height:40px; line-height:40px; text-align:center">
	            <div class=""  style="width:100%;" id="tbrightMaindthy">
	            </div>
	        </div>
            <ul>
                <li><a href="javascript:clicktbdt('downresumedt');" class="admin_index_date_d png">���ؼ�����̬</a></li>
                <li><a href="javascript:clicktbdt('useridjobdt');" class="admin_index_date_e png">ְλ���붯̬</a></li>
                <li><a href="javascript:clicktbdt('lookjobdt');" class="admin_index_date_f png">ְλ�����̬</a></li>
                <li><a href="javascript:clicktbdt('lookresumedt');" class="admin_index_date_g png">���������̬</a></li>
                <li><a href="javascript:clicktbdt('favjobdt');" class="admin_index_date_h png">ְλ�ղض�̬</a></li>
                <li><a href="javascript:clicktbdt('payorderdt');" class="admin_index_date_i png">��ֵ��̬</a></li>
            </ul>
         
        </div>
    </div>
    
     <div class="admin_index_Data_cont" style="position:relative; display:none" id="index_rz">
        <div class="admin_index_Data_cont_left" style="width:850px; float:left;height:300px;">
            <div class="admin_index_fw" id="main22" style="width:800px;height:300px;">
                <iframe name="right" id="tbrightMainrz" src="index.php?m=admin_right&c=userrz" frameborder="false" scrolling="auto" style="border:none;" width="850" height="300" allowtransparency="true"></iframe>
            </div>
        </div>
        <div class="admin_index_date_list">
        <div class="" style="width:340px; float:left;height:60px; line-height:25px; text-align:center">
	            <div class=""  style="width:100%;"  id="tbrightMainrzhy">
	            </div>
	        </div>
            <ul>
                
                <li><a href="javascript:clicktbrz('userrz');" class="admin_index_date_d png">���˻�Ա��־</a></li>
                <li><a href="javascript:clicktbrz('comrz');" class="admin_index_date_e png">��ҵ��Ա��־</a></li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
<div class="mainleft">
<div class="maininfo" style="height:180px">
    	<div class="mainboxtop"><h6>�����Ŷ�</h6></div>
        <div class="maincontent">
        <p>�����Ŷӣ�haowubai , ���� , Kstar , Marine , Mylgl , Neo , ��ǰ ��</p>
        <p>�ر��л������ , Фǿ , ���� , ��ң , ��Ȫ , С�� , ����ý</p>
        <p>��ϵ�绰��400-880-5523</p>
		<p>�ٷ���վ��<a href="http://www.phpyun.com/" target="_blank">http://www.phpyun.com/</a> �ٷ���̳��<a href="http://bbs.phpyun.com/" target="_blank">http://bbs.phpyun.com/</a></p>
<p>��ѯQQ��3367562 , 721799845 , 721799844</p>
        </div>
    </div>
</div>
<div class="mainright">
    <div class="maininfo" style="height:180px">
    	<div class="mainboxtop"><h6>ϵͳ��Ϣ</h6></div>
        <div class="maincontent">
        <p style="float:left;">PHPYun����汾�� <?php echo $_smarty_tpl->tpl_vars['version']->value;?>
 [ <div id="version_msg" style="float:left;">�������!</div>]</p>
		<p style="clear:both;">�����������<?php echo $_smarty_tpl->tpl_vars['soft']->value;?>
</p>
        <p>���ÿռ�(������)��<?php echo $_smarty_tpl->tpl_vars['kongjian']->value;?>
&nbsp;M</p>
		<p>MySQL �汾��<?php echo $_smarty_tpl->tpl_vars['banben']->value;?>
</p>
		<p>�û� - ��������<?php echo $_smarty_tpl->tpl_vars['yonghu']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['server']->value;?>
</p>
        </div>
    </div>
  </div>
</div>
<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"/>
<?php echo '<script'; ?>
>
function clicktb(name){
	$("#tbrightMain").attr("src","index.php?m=admin_right&c="+name);
}
function clicktbdt(name){
	$("#tbrightMaindt").attr("src","index.php?m=admin_right&c="+name);
	$.post("index.php?m=admin_right&c="+name+"hy",{},function(data){
		$("#tbrightMaindthy").html(data);
	})
}
function clicktbrz(name){
	$("#tbrightMainrz").attr("src","index.php?m=admin_right&c="+name);
	$.post("index.php?m=admin_right&c="+name+"hy",{},function(data){
		$("#tbrightMainrzhy").html(data);
	})
}
$(document).ready(function(){
	$(".admin_message_h1_s").click(function(){
		$(".admin_message_h1_s").attr("class","admin_message_h1_s");
		$(this).attr("class","admin_message_h1_s admin_message_h1_cur");
		var a=$(this).attr("data-a");
		$(".admin_index_Data_cont").hide();
		$("#"+a).show();
	});
	$.post("index.php?m=admin_right&c=downresumedthy",{},function(data){
		$("#tbrightMaindthy").html(data);
	});
	$.post("index.php?m=admin_right&c=userrzhy",{},function(data){
		$("#tbrightMainrzhy").html(data);
	})
})
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="http://init.phpyun.com/site.php?site=<?php echo $_smarty_tpl->tpl_vars['base']->value;?>
"><?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
