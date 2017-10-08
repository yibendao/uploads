<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 10:14:06
         compiled from "D:\phpStudy\WWW\uploads\\app\template\admin\checkdomain.htm" */ ?>
<?php /*%%SmartyHeaderCode:3246059cdac6ea3f4a2-69792133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e8a1e8e4497e67dd07021a298b34a61561254b5' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\admin\\checkdomain.htm',
      1 => 1492764198,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3246059cdac6ea3f4a2-69792133',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'Dname' => 0,
    'key' => 0,
    'dlist' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdac6ea94d23_00729458',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdac6ea94d23_00729458')) {function content_59cdac6ea94d23_00729458($_smarty_tpl) {?><?php echo '<script'; ?>
 type="text/javascript">
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
function checksiteall(url){
	var codewebarr="";
	$(".check_all:checked").each(function(){ 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	if(codewebarr==""){
		parent.layer.msg('您还未选择任何信息！', 2, 8);	return false;
	}else{
		checksite('',codewebarr,url);
	}
}
function checksite(name,id,url){ 
	if(name==''){
		$("#com_name").html("");
	}else if(url=='index.php?m=admin_news&c=checksitedid'){
		$("#com_name").html("新闻标题：");
	}else if(url=='index.php?m=zhaopinhui&c=checksitedid'){
		$("#com_name").html("招聘会标题：");
	}else{
		$("#com_name").html("用户名：");
	}
	name=name.substr(0,15);
	$('#formDomain').attr('action', url);
	$('#siteusername').html(name);
    $('#siteuid').val(id);
	$.layer({
		type : 1,
		title :'分配站点', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['350px','260px'],
		offset: ['20px', ''],
		page : {dom :"#infoboxdomain"}
	});
}
function searchdomain(id){
	var pytoken = $('#pytoken').val();
	if(id==1){
	    var keyword = $.trim($('#sitekeyword').val());
	}else{
	    var keyword = $.trim($('#domainkeyword').val());
	}
	if(!keyword){
		parent.layer.msg('请输入搜索关键词！', 2, 8);return false;
	}
	var i=layer.load('执行中，请稍后...',0);
	$.post(weburl+"/index.php?m=ajax&c=selsite",{pytoken:pytoken,keyword:keyword,id:id},function(data){
	    layer.close(i);
		if(data==0){
			parent.layer.msg('请输入搜索关键词！', 2, 8);return false;
		}else if(data==1){
			parent.layer.msg('未查询到相关数据！', 2, 8);return false;
		}else{
		    if(id==1){
				$('#did_select').html(data);
			}else{
				$('#domain_select').html(data);
			}
		}
	});
}
function add_site(id,name){
    if(id!=''){
	   $("#domain_val").val(id);
	}
	if(name!=''){
	   $("#domain_name").val(name);
	}
	$.layer({
		type : 1,
		title :'分配站点', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['400px','200px'],
		offset: ['20px', ''],
		page : {dom :"#domainlist"}
	});
}
function check_domain(){
    var id=$("#domain_val").val();
	var name=$("#domain_name").val();
	$(".city_news_but").val(name);
	$("#did").val(id);
	layer.closeAll(); 
}
function domaincheck(){
   var did=$("#did_val").val();
   if(!did){
       layer.msg('请选择需要切换的站点',2,8);return false;
   }
}
<?php echo '</script'; ?>
>
<style>
.admin_compay_fp{width:340px; margin-top:15px;}
.admin_compay_fp_s{width:100px; text-align:right; font-weight:bold; display:inline-block}
.admin_compay_fp_sub{width:140px;height:25px;border:1px solid #ddd;}
.admin_compay_fp_sub1{width:40px;height:27px; background:#3692cf;color:#fff;border:none; cursor:pointer}
</style>
<div id="infoboxdomain"  style="display:none; width: 350px; ">
	<form action="" target="supportiframe" method="post" id="formDomain" onsubmit="return domaincheck()"> 
		<div class="admin_compay_fp">
			<span class="admin_compay_fp_s" id="com_name"></span> 
			<em  id="siteusername"></em>
		</div>
		
		<div class="admin_compay_fp">
			<span class="admin_compay_fp_s">分站搜索：</span>
			<input type="text" value="" id="sitekeyword" class="admin_compay_fp_sub">
			<input type='button' onclick="searchdomain('1')" value="搜索" class="admin_compay_fp_sub1">
		</div>
		<div class="admin_compay_fp" style="height:34px;">
			<span class="admin_compay_fp_s" style="float:left; line-height:34px; display:inline-block; margin-right:5px;">切换站点：</span>
            <div class="yun_admin_select_box zindex100"> 
                  <input type="button" value="请选择" class="yun_admin_select_box_text" id="did_name" onClick="select_click('did');">
                  <input name="did" type="hidden" id="did_val" value="">
                 
                  <div class="yun_admin_select_box_list_box dn" id="did_select"> 
				  <?php  $_smarty_tpl->tpl_vars['dlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dlist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Dname']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dlist']->key => $_smarty_tpl->tpl_vars['dlist']->value) {
$_smarty_tpl->tpl_vars['dlist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['dlist']->key;
?>
                    <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('did','<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['dlist']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['dlist']->value;?>
</a> </div>
                    <?php } ?> </div>
           </div>
            
            
		</div>
		<div class="admin_compay_fp">
			<span class="admin_compay_fp_s">&nbsp;</span>
			<input type="submit"  value='确认' class="admin_examine_bth"><input type="button"  onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消' style="margin-left:10px;">
		</div> 
		<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
		<input name="uid" value="0" id="siteuid" type="hidden">
	</form> 
</div>
<div id="domainlist" style="display:none;float:left">
	<div class="admin_compay_fp">
		<span class="admin_compay_fp_s">分站搜索：</span>
		<input type="text" value="" id="domainkeyword" class="admin_compay_fp_sub">
		<input type='button' onclick="searchdomain('2')" value="搜索" class="admin_compay_fp_sub1">
	</div>
	<div class="admin_compay_fp" style="height:34px;">
		<span class="admin_compay_fp_s" style="float:left; line-height:34px; display:inline-block; margin-right:5px;">切换站点：</span>
		<div class="yun_admin_select_box zindex100">
		<input type="button" value="请选择" class="yun_admin_select_box_text" id="domain_name" onClick="select_click('domain');">
        <input name="nid" type="hidden" id="domain_val" value="">
		
		<div class="yun_admin_select_box_list_box dn" id="domain_select">     
	 		<?php  $_smarty_tpl->tpl_vars['dlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dlist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Dname']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dlist']->key => $_smarty_tpl->tpl_vars['dlist']->value) {
$_smarty_tpl->tpl_vars['dlist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['dlist']->key;
?>
			 <div class="yun_admin_select_box_list">
				<a href="javascript:;" onClick="select_new('domain','<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['dlist']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['dlist']->value;?>
</a>
			 </div> 
			<?php } ?>
            </div>
		</div>

	</div>
	<div class="admin_compay_fp">
		<span class="admin_compay_fp_s">&nbsp;</span>
		<input type="button"  value='确认' onclick="check_domain()" class="admin_examine_bth"><input type="button"  onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消' style="margin-left:10px;">
	</div> 
</div><?php }} ?>
