<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-06 13:16:42
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:2649459cd1f569788a7-95279551%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e2228481f0926cc7f85b5b77ca9a266351b7eb4' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_resume.htm',
      1 => 1507002293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2649459cd1f569788a7-95279551',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cd1f56c84508_64133606',
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'where' => 0,
    'get_type' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'source' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cd1f56c84508_64133606')) {function content_59cd1f56c84508_64133606($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
function Refreshs(){
	var codewebarr="";
	$(".check_all:checked").each(function(){ 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	if(codewebarr==""){
		parent.layer.msg("请选择要刷新的简历！",2,8);return false;
	}else{
		$.post("index.php?m=admin_resume&c=refreshs",{ids:codewebarr,pytoken:$('#pytoken').val()},function(data){
			parent.layer.msg("批量刷新成功！",2,9,function(){window.location.reload();}); 
		})
	}
}
function Export(){
	var codewebarr="";
	$(".check_all:checked").each(function(){ 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	}); 
	if(codewebarr){
		$("input[name='ids']").val(codewebarr);
	}
	add_class('选择导出字段','650','400','#export','');
}
function check_xls(){
	var type="";
	$(".type:checked").each(function(){ 
		if(type==""){type=$(this).val();}else{type=type+","+$(this).val();}
	});
	if(type==""){
		layer.msg("请选择导出字段！",2,8);return false;
	}  
	setTimeout(function(){$('.myform').submit()},0);
	layer.closeAll(); 
}
function checkdel(type,status){
	var codewebarr="";
	$(".check_all:checked").each(function(){ 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	if(codewebarr==""){
		parent.layer.msg("请选择简历！",2,8);return false;
	}else if(type=='top'){
		if(status!='1'){
			$('input[name=s]').attr('checked','true');
		} 
		resumttop(codewebarr,0);
	}else{ 
		$.post("index.php?m=admin_resume&c=rec",{ids:codewebarr,pytoken:$('#pytoken').val(),type:type,status:status},function(data){
			if(data==0){
				parent.layer.msg("操作出错，请稍后再试！",2,8);
			}else{
				parent.layer.msg("设置成功！",2,9,function(){window.location.reload();});
			}
		})
	}
}
$(document).ready(function(){
	$(".job_name_all").hover(function(){
		var job_name=$(this).attr('v');
		if($.trim(job_name)!=''){
			layer.tips(job_name, this, {guide: 1, style: ['background-color:#5EA7DC; color:#fff;top:-7px', '#5EA7DC']}); 
			$(".xubox_layer").addClass("xubox_tips_border");
		} 
	},function(){
		var job_name=$(this).attr('v'); 
		if($.trim(job_name)!=''){
			layer.closeTips();
		} 
	}); 
})
function resumttop(id,topday,topdate){
	if(topdate){
		$(".top").html(topdate);
		$(".topdiv").show();
		$("input[name='eid']").val(id);
		add_class('简历置顶','290','250','#resumttop','');
	}else{
		$("input[name='eid']").val(id);
		add_class('简历置顶','290','250','#resumttop','');
	}
}

$(function(){
	$(".status").click(function(){
		// $("input[name=pid]").val($(this).attr("pid"));
		var id=$(this).attr("id");
		var uid=$(this).attr("uid");
		var status=$(this).attr("status");
		$("#status"+status).attr("checked",true);
		$("input[name=id]").val(id);
		$("input[name=uid]").val(uid);
		// $.get("index.php?m=admin_resume_evaluation&c=undisturb&id="+id+"&uid="+uid,function(msg){
		// 	$("#alertcontent").val($.trim(msg));
			status_div('勿扰用户','350','230');
		// });
	});
});
<?php echo '</script'; ?>
>
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />
<title>后台管理</title>
</head>
<body class="body_ifm">
<div id="status_div"  style="display:none; width: 350px; ">
  <div class="" style=" margin-top:10px; "  >
    <form action="index.php?m=admin_resume_evaluation&c=undisturb" target="supportiframe" method="post" id="formstatus">
      <table cellspacing='1' cellpadding='1' class="admin_examine_table">
     <tr>
    <th width="80">勿扰操作：</th>
     <td align="left">
         		<label for="status1"> <span class="admin_examine_table_s"><input type="radio" name="status" value="0" id="status0" >正常</span></label>
            	<label for="status2"> <span class="admin_examine_table_s"><input type="radio" name="status" value="1" id="status1">勿扰</span></label>
          </td>
        </tr>
        </tr>
        <tr>
           <td colspan='2' align="center"><input type="submit"  value='确认' class="admin_examine_bth">
          
            <input type="button" id="zxxCancelBtn" onClick="layer.closeAll();" class="admin_examine_bth_qx" value='取消'></td>
        </tr>
   
      <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      <input name="id" value="0" type="hidden">
      <input name="uid" value="0" type="hidden">
         </table>
    </form>
  </div>
</div>
<div id="export" style="display:none;">
	<div style=" margin-top:10px;">
    <div>
      <form action="index.php?m=admin_resume&c=xls" target="supportiframe" method="post" id="formstatus" class="myform">
      <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      <input type="hidden" name="where" value="<?php echo $_smarty_tpl->tpl_vars['where']->value;?>
">
      <input type="hidden" name="ids">
		<div class="admin_resume_dc">
			<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="id"> 简历ID</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="name"> 简历名称</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="uid"> 用户UID</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="name"> 姓名</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="sex"> 性别</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="birthday"> 生日</span></label>
           <label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="marriage"> 婚姻</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="height"> 身高</span></label>
           <label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="nationality"> 民族</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="weight"> 体重</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="idcard"> 身份证</span></label>
           <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="telphone"> 手机</span></label>
           <label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="telhome"> 座机</span></label>
    		<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="email"> 邮件</span></label>
			<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="edu"> 教育程度</span></label>
          <label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="homepage"> 个人主页</span></label>
			<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="address"> 详细地址</span></label>
          <label>  <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="exp"> 工作经验</span></label>
         <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="domicile"> 户籍</span></label>
          <label>  <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="living"> 现居住地</span></label>
		<label>	<span class="admin_resume_dc_s"><input type="checkbox" class="type" name="type[]" value="description"> 个人说明</span></label>
          <label>     <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="hy"> 意向行业</span></label>
           <label>    <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="job_classid"> 意向职位</span></label>
			<label><span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="provinceid"> 省</span></label>
          <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="cityid"> 市</span></label>
          <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="three_cityid"> 县</span></label>
          <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="minsalary,maxsalary"> 薪水</span></label>
		<label>	<span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="type"> 工作性质</span></label>
          <label>   <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="report"> 到岗时间</span></label>
          <label> <span class="admin_resume_dc_s"><input type="checkbox" class="type" name="rtype[]" value="lastdate"> 更新时间</span></label>
         </div>
         
         <div class="admin_resume_dc_p" style=" padding:10px 0;"><span class="admin_resume_dc_n">导出数量：</span><input name='limit' type='text' class="admin_resume_dc_ntext"><span class="admin_web_tip admin_resume_dc_tip">数字太大会导致运行缓慢，请慎重填写。</span></div>
			<div class="admin_resume_dc_sub" style=" padding-top:10px;">
            <input type="button" onClick="check_xls();"  value='确认' class="admin_resume_dc_bth1">
          &nbsp;&nbsp;<input type="button" onClick="layer.closeAll();" class="admin_resume_dc_bth2" value='取消'></div>
      </form>
    </div>
  </div>
</div>
 <div id="resumttop"  style="display:none; "> 
 <div class="admin_com_t_box"> 
      <form action="index.php?m=admin_resume&c=recommend" target="supportiframe" method="post" id="formstatus"> 
	  <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
		
        <div class=" admin_com_smbox_list_pd">
          <span class="admin_com_smbox_span">置顶天数：</span>
   <input class="admin_com_smbox_text"  value="" name="addday" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')"><span class="admin_com_smbox_list_s">天</span>    </div>
   <div class="topdiv" style="display:none">
          <span class="admin_com_smbox_span">当前结束日期：</span> 
			<span class="admin_com_smbox_list_s top" style="color:#f60"></span>    
		</div>
  <div class="admin_com_smbox_qx_box"> 如需取消置顶简历请单击 <input type="checkbox" name="s" value="1"> 点击确认即可</div>
   
    <div class="admin_com_smbox_opt admin_com_smbox_opt_mt"><input type="submit" onclick="loadlayer();" value='确认' id='topsubmit' class="admin_examine_bth"><input type="button" onClick="layer.closeAll();"class="admin_examine_bth_qx"  value='取消'></div>
    
 
		<input name="eid" type="hidden">
      </form> 
</div>
</div>
<div class="infoboxp"> 
  <div class="infoboxp_top_bg"></div>
	<form action="index.php" name="myform" method="get"> 
    <div class="admin_Filter"> 
	<input name="m" value="admin_resume" type="hidden"/>
	<input type="hidden" name="salary" value="<?php echo $_GET['salary'];?>
"/>
	<input type="hidden" name="type" value="<?php echo $_GET['type'];?>
"/>
	<input type="hidden" name="report" value="<?php echo $_GET['report'];?>
"/>
	
		<span class="complay_top_span fl">简历管理</span>
		<div class="admin_Filter_span">搜索类型：</div>
      <div class="admin_Filter_text formselect" did='dkeytype'>
        <input type="button" <?php if ($_smarty_tpl->tpl_vars['get_type']->value['keytype']==''||$_smarty_tpl->tpl_vars['get_type']->value['keytype']=='1') {?> value="简历名称"  <?php } elseif ($_smarty_tpl->tpl_vars['get_type']->value['keytype']=='2') {?> value="用户姓名"  <?php } elseif ($_smarty_tpl->tpl_vars['get_type']->value['keytype']=='3') {?> value="EMAIL" <?php } elseif ($_smarty_tpl->tpl_vars['get_type']->value['keytype']=='4') {?> value="手机号" <?php }?> class="admin_Filter_but" id="bkeytype">
        <input type="hidden" name="keytype" id="keytype" <?php if ($_smarty_tpl->tpl_vars['get_type']->value['keytype']==''||$_smarty_tpl->tpl_vars['get_type']->value['keytype']=='1') {?> value="1"  <?php } elseif ($_smarty_tpl->tpl_vars['get_type']->value['keytype']=='2') {?> value="2"  <?php }?>/>
        <div class="admin_Filter_text_box" style="display:none" id="dkeytype">
          <ul> 
            <li><a href="javascript:void(0)" onClick="formselect('1','keytype','简历名称')">简历名称</a></li>
			      <li><a href="javascript:void(0)" onClick="formselect('2','keytype','用户姓名')">用户姓名</a></li>
          </ul>
        </div>
      </div>
      
		  <input type="text" placeholder="输入你要搜索的关键字" value="<?php echo $_GET['keyword'];?>
" name="keyword" class="admin_Filter_search">
		  <input type="submit" name="search" value="搜索" class="admin_Filter_bth"> 
		  <span class='admin_search_div'>
		  <div class="admin_adv_search"><div class="admin_adv_search_bth">高级搜索</div></div>  
 		  </span>
		  <a href="index.php?m=admin_resume&c=addresume" class="admin_infoboxp_tj" style="margin-right:5px;"> 添加简历</a>  
	  </div> 
	 </form>
	<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
  


  <div class="table-list">
    <div class="admin_table_border">
    
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php" target="supportiframe" name="myform" method="get" id='myform'>
        <input name="m" value="admin_resume" type="hidden"/>
        <input name="c" value="del" type="hidden"/>
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th style="width:20px;">
              <label for="chkall"><input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)'/></label>
              </th>
              <th width="60"> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_resume&order=desc&t=id">简历ID<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=admin_resume&order=asc&t=id">简历ID<img src="images/sanj2.jpg"/></a> <?php }?> </th>
              <th width="100" align="left">简历名称</th>
			        <th width="100" align="left">用户姓名</th>
              <th width="150" align="left">意向职位</th>
              <th align="left">工作地点</th>
              <th align="left">待遇要求</th>
              <th align="left">工作性质</th>
              <th align="left">到岗时间</th>
              <th> <?php if ($_GET['t']=="time"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_resume&order=desc&t=time">更新时间<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=admin_resume&order=asc&t=time">更新时间<img src="images/sanj2.jpg"/></a> <?php }?> </th>
              <th>来源</th>
              <th>推荐</th>
              <th>置顶</th>
              <th class="admin_table_th_bg">操作</th>
            </tr>
          </thead>
          <tbody>
          
          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          <tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="check_all"  name='del[]' onclick='unselectall()' rel="del_chk" /></td>
            <td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
            <td class="ud" align="left" ><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.id`','look'=>'admin'),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a> <?php if ($_smarty_tpl->tpl_vars['v']->value['undisturb']==1) {?><img src="../config/ajax_img/suo.png" alt="已勿扰"><?php }?></td>
			      <td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>
 </td>
            <td class="od" align="left"><?php if ($_smarty_tpl->tpl_vars['v']->value['job_post_n']) {
echo $_smarty_tpl->tpl_vars['v']->value['job_post_n'];?>
(<a href="javascript:void(0)" class="job_name_all"  v="<?php echo $_smarty_tpl->tpl_vars['v']->value['job_class_name'];?>
"><font color="red">共<?php echo $_smarty_tpl->tpl_vars['v']->value['jobnum'];?>
个</font></a>)<?php }?></td>
            <td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['cityid_n'];?>
</td>
            <td class="td" align="left"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?></td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['type_n'];?>
</td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['report_n'];?>
</td>
            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['lastupdate'],"%Y-%m-%d");?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['source']->value[$_smarty_tpl->tpl_vars['v']->value['source']];?>
</td>
            <td id="rec_resume<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['v']->value['rec_resume']=="1") {?><a href="javascript:void(0);" onClick="rec_up('index.php?m=admin_resume&c=recommend','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','0','rec_resume');"><img src="../config/ajax_img/doneico.gif"></a><?php } else { ?><a href="javascript:void(0);" onClick="rec_up('index.php?m=admin_resume&c=recommend','<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','1','rec_resume');"><img src="../config/ajax_img/errorico.gif"></a><?php }?></td>
            <td id="top<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            	<?php if ($_smarty_tpl->tpl_vars['v']->value['top']=="1"&&$_smarty_tpl->tpl_vars['v']->value['topdate']>time()) {?>
            		<a href="javascript:void(0);" onClick="resumttop('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['top_day'];?>
','<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['topdate'],"%Y-%m-%d");?>
')">
            		<img src="../config/ajax_img/doneico.gif"></a>
            	<?php } else { ?>
            		<a href="javascript:void(0);" onClick="resumttop('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['top_day'];?>
')">
            		<img src="../config/ajax_img/errorico.gif"></a>
            	<?php }?>
            </td>
            <td><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.id`','look'=>'admin'),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc">预览</a> | <a href="javascript:void(0)" onClick="layer_del('确认刷新？', 'index.php?m=admin_resume&c=refresh&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" title="刷新" class="admin_cz_sc">刷新</a> | <a href="index.php?m=admin_resume_evaluation&c=evaluation&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
&by=admin"  class="admin_cz_sc">评价</a><br/><a href="index.php?m=admin_resume&c=saveresume&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&e=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_cz_sc">修改</a> | <a href="javascript:void(0)"  onclick="layer_del('确定要删除？', 'index.php?m=admin_resume&c=del&del=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
');"class="admin_cz_sc">删除</a> | <a href="javascript:;" class="admin_cz_sc status" id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['undisturb'];?>
">勿扰</a></td>
          </tr>
          <?php } ?>
        <tr style="background:#f1f1f1;">
            <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
            <td colspan="6" >
            <label for="chkAll2">全选</label>&nbsp;
            <input class="admin_submit4" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
              <input class="admin_submit4" type="button" name="delsub" value="批量刷新" onClick="Refreshs();"/>
              <input class="admin_submit2" type="button" name="delsub" value="推荐" onClick="checkdel('rec_resume','1');"/>
              <input class="admin_submit4" type="button" name="delsub" value="取消推荐" onClick="checkdel('rec_resume','0');"/>
              <input class="admin_submit2" type="button" name="delsub" value="置顶" onClick="checkdel('top','1');"/>
              <input class="admin_submit4" type="button" name="delsub" value="取消置顶" onClick="checkdel('top','0');"/>
              <input class="admin_submit2" type="button" name="delsub" value="导出" onClick="Export();" />
              </td>
            <td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
          </tr>
            </tbody>
        </table>
        <input type="hidden" name="pytoken"  id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      </form>
    </div>
  </div>
</div> 
</body>
</html><?php }} ?>
