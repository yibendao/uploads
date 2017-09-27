<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:19:06
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:2108159cbb35a74dc37-66259842%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19aa958ce27b3bec1b30b9bc9e17e4d5c64d8a5e' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\index.htm',
      1 => 1506403038,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2108159cbb35a74dc37-66259842',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'navigation' => 0,
    'v' => 0,
    'navigation_url' => 0,
    'nav_user' => 0,
    'menu' => 0,
    'one_menu' => 0,
    'val' => 0,
    'two_menu' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb35a9fa436_00983732',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb35a9fa436_00983732')) {function content_59cbb35a9fa436_00983732($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="off">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
 - 后台管理中心</title>
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 language="javascript" type="text/javascript" src="../js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="./js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
  DD_belatedPNG.fix('.png,.header .logo,.header .nav li a,.header .nav li.on,.left_menu h3 span.on,.admin_adv_search_bth,admin_infoboxp_tj');
<?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
 type="text/javascript">
	var pc_hash = 'l9Yqpa' 
	function check_web(id){
		$("html").removeClass("on");
		var timestamp=Math.round(new Date().getTime()/1000) ;
		var pytoken=$("#pytoken").val();
		$.get("index.php?c=topmenu&id="+id,function(data){
			document.getElementById("current_pos").innerHTML = data;
		})
	}
<?php echo '</script'; ?>
>
</head>
<body scroll="no">
<div class="header" style="width:auto;">
<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
  <div class="header_bg">
    <div class="logo lf"><a href="http://www.phpyun.com" target="_blank"><span class="invisible">PHPyun人才网后台管理系统</span></a></div>
    <div class="col-auto" style="overflow: visible">
      <ul class="nav white" id="top_menu">
        <li id="_M1000" class="on top_menu"><a href="javascript:_M(1000,'index.php?m=admin_right')"  onclick="check_web('1000');" hidefocus="true" style="outline:none;">首页</a></li>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <li id="_M<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="top_menu"><a class="<?php echo $_smarty_tpl->tpl_vars['v']->value['classname'];?>
" href="javascript:_M(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['navigation_url']->value[$_smarty_tpl->tpl_vars['v']->value['id']];?>
')" onclick="check_web(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
);" hidefocus="true" style="outline:none;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
        <?php } ?>
      </ul>
    </div>
    <div>
      <div class="admin-header_top">
        <div class="admin-header_top_wz">
            <a href="http://www.phpyun.com" target="_blank">PHP云官网</a> |
            <a href="http://www.phpyun.com" target="_blank"><font color="#F3AF23">授权</font></a> |
        <a href="javascript:void(0)" target="right" onclick="layer_del('','index.php?m=index&c=del_cache');"><span>更新缓存</span></a> |
        <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank" id="site_homepage">站点首页</a>
        </div>
        </div>
    </div>
  </div>
</div>
<div id="content" style="width:auto;">
  <div class="col-left left_menu">
    <div id="leftMain"> </div>
    <a href="javascript:;" id="openClose" style="outline-style:none;outline-color:invert;outline-width:medium;height:539px;" hidefocus="hidefocus" class="open" title="展开与关闭"><span class="hidden"> </span></a>
    </div>
  <div class="col-1 lf cat-menu" id="display_center_id" style="display:none" height="100%">
    <div class="content"> </div>
  </div>
  <div class="col-auto">
    <div class="crumbs-admin-top">
      <div class="crumbs">
        <div class="admin_top_shortcut ">
        您好！<font color="#0066FF"><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['name'];?>
</font> <?php echo $_smarty_tpl->tpl_vars['nav_user']->value['group_name'];?>
  <a href="javascript:void(0)" onclick="layer_logout('index.php?m=index&c=logout');" class="admin_logout">退出登录</a> | <a href="javascript:void(0)" onclick="adminmap()"> <span>后台地图</span></a>&nbsp;&nbsp;
        </div>
        当前位置：<span id="current_pos">管理首页</span> </div>
    </div>
    <div class="">
      <div class="" style="position:relative; overflow:hidden">
        <iframe name="right" id="rightMain" src="index.php?m=admin_right" frameborder="false" scrolling="auto" style="border:none;" width="100%" height="470" allowtransparency="true"></iframe>
      </div>
    </div>
  </div>
</div>
<ul class="tab-web-panel hidden" style="position: absolute; z-index: 999; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(255, 255, 255); left: 680px; top: 82px; display: none; background-position: initial initial; background-repeat: initial initial; ">
  <li style="margin:0"><a href="javascript:site_select(1, '默认站点', '#', '1')">默认站点</a></li>
</ul>
<div style="display:none;">
  <div id="DIV_M1000">
    <h3 class="f14">
        <div class="shortcut_menu_bb" ><em class="switchs_sz" onclick="shortcut_menu()"></em>快捷菜单</div>
    </h3>
    <ul id='keyid_1000' class="left_mune_ul">
      <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
          <li id="_MP<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="sub_menu" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['keyid'];?>
'>
            <a href="javascript:_MP(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
');" onclick="check_web(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
);" hidefocus="true" style="outline:none;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a>
          </li>
      <?php } ?>
    </ul>
  </div>
  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
  <div id="DIV_M<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
      <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['one_menu']->value[$_smarty_tpl->tpl_vars['v']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
        <h3 class="f14">
            <div class="shortcut_menu_bb"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</div>
        </h3>
        <ul id="keyid_<?php echo $_smarty_tpl->tpl_vars['val']->value['keyid'];?>
" class="left_mune_ul">
           <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['two_menu']->value[$_smarty_tpl->tpl_vars['val']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
          <li id="_MP<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="sub_menu" > <a href="javascript:_MP(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['value']->value['url'];?>
');" onclick="check_web(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
);" hidefocus="true" style="outline:none;"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</a> </li>
          <?php } ?>
        </ul>
        <?php } ?>
  </div>
  <?php } ?>
  </div>

<div id="shortcut_menu"  style="display:none; width: 710px;top:0px ">
	<div class=" " style="height:450px; overflow:auto;overflow-x: hidden;_width:710px">
	  <div class="common-form">
		  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
			<table width="100%" bgcolor="#dfdfdf">
			  <tr><td height="30" style="padding-left:10px"><strong><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</strong></td></tr>
			  <tr>
				<td>
					<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one_menu']->value[$_smarty_tpl->tpl_vars['v']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
				  <table width="100%" bgcolor="#f7f7f7">
					<tr><td height="30" style="padding-left:40px;"><strong><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</strong></td></tr>
					<tr>
					  <td bgcolor="#fdfeff" height="30" style="padding-left:70px;"> <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['two_menu']->value[$_smarty_tpl->tpl_vars['val']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
						<div style="float:left; width:100px; height:30px; line-height:30px; "><input name='shortcut_menu[]' value='<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
' type='checkbox' <?php if ($_smarty_tpl->tpl_vars['value']->value['menu']=='2') {?>checked<?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</div>
						<?php } ?> </td>
					</tr>
					<?php } ?>
				  </table></td>
			  </tr>
			</table>
			<?php } ?>
			<div style="text-align:center"><input class="admin_submit4" type="button" value="提交" onclick="check_menu();"></div>
		</div>
	</div>
</div>

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function(){
	$(".admin_index_city_list").hover(function(){
		$(".admin_index_city_list").show();
	},function(){
		$(".admin_index_city_list").hide();
	});
})
function check_menu(){
	var chk_value =[];
	var pytoken=$("#pytoken").val();
	$('input[name="shortcut_menu[]"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	if(chk_value.length==0){
		parent.layer.msg('请至少选择一个！', 2,8);return false;
	}else{
		$.post("index.php?c=shortcut_menu",{chk_value:chk_value,pytoken:pytoken},function(msg){
			parent.layer.msg('设置成功！', 2,9,function(){location=location ;});return false;
		});
	}
}
function shortcut_menu(){
	$.layer({
		type : 1,
		title : '快捷菜单管理',
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		shade: [0.5, '#000'], 
		area : ['710px','490px'],
		page : {dom : '#shortcut_menu'}
	});
}

$('#DIV_M1000').clone().appendTo('#leftMain');
function windowW(){
	if($(window).width()<980){
		$('.header').css('width',980+'px');
		$('#content').css('width',980+'px');
		$('body').attr('scroll','');
		$('body').css('overflow','');
	}
}
windowW();
$(window).resize(function(){
	if($(window).width()<980){
		windowW();
	}else{
		$('.header').css('width','auto');
		$('#content').css('width','auto');
		$('body').attr('scroll','no');
		$('body').css('overflow','hidden');
	}
});
window.onresize = function(){
	var heights = document.documentElement.clientHeight-150;document.getElementById('rightMain').height = heights+30;
	var openClose = $("#rightMain").height()+39;
	$('#center_frame').height(openClose+9);
	$("#openClose").height(openClose+30);
}
window.onresize();

$("#openClose").click(function(){
	if($(this).data('clicknum')==1) {
		$("html").removeClass("on");
		$(".left_menu").removeClass("left_menu_on");
		$(this).removeClass("close");
		$(this).data('clicknum', 0);
	} else {
		$(".left_menu").addClass("left_menu_on");
		$(this).addClass("close");
		$("html").addClass("on");
		$(this).data('clicknum', 1);
	}
	return false;
});
function _M(menuid,targetUrl) {
	$('.top_menu').removeClass("on");
	$('#_M'+menuid).addClass("on");
	$("#menuid").val(menuid);
	$("#bigid").val(menuid);
	var menu="#DIV_M"+menuid;
	$('#leftMain').html("");
	$(menu).clone().appendTo($("#leftMain"));
	$(".left_menu").removeClass("left_menu_on");
	$("#openClose").removeClass("close");
	$("#openClose").data('clicknum', 0);
	$("#current_pos").data('clicknum', 1);
	$('#keyid_'+menuid).find("li:lt(1)").addClass("on fb blue");
	$("#rightMain").attr('src', targetUrl);
}
function _MP(menuid,targetUrl) {
	$("#menuid").val(menuid);
	$("#paneladd").html('<a class="panel-add" href="javascript:add_panel();"><em>添加</em></a>');
	$("#rightMain").attr('src', targetUrl);
	$('.sub_menu').removeClass("on fb blue");
	$('#_MP'+menuid).addClass("on fb blue");
	$("#current_pos").data('clicknum', 1);
}
function admin_site(id){
	var pytoken=$("#pytoken").val();
	$.post("index.php?c=site",{id:id,pytoken:pytoken},function(data){window.location.href="index.php";})
}
function for_menu(id){
	$("#keyid_"+id).slideToggle();
	$("#span_"+id).toggleClass("on"); return false;
}
$(function() {

   $.get('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?m=cron');
});
<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
