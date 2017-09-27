<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:23:32
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\user\expect_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:996959cbb46488b362-96562952%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa790738344ba9d1c34401d4e17bcdd1e46665f9' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\user\\expect_add.htm',
      1 => 1496713262,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '996959cbb46488b362-96562952',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'style' => 0,
    'user_style' => 0,
    'save' => 0,
    'resume' => 0,
    'arr_data' => 0,
    'j' => 0,
    'v' => 0,
    'userclass_name' => 0,
    'userdata' => 0,
    'industry_name' => 0,
    'industry_index' => 0,
    'city_name' => 0,
    'city_index' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb464b6c898_51609231',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb464b6c898_51609231')) {function content_59cbb464b6c898_51609231($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js" type="text/javascript"><?php echo '</script'; ?>
> 
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/css/font-awesome.min.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/foundation-datepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/lssave.js" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
>
var userstyle='<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
';
var start = 30;
	var step = -1;
	var save=$("#save").val();
	if(!save){
		function count()
			{
			$("#atime").click(function(){ start=30});
			document.getElementById("totalSecond").innerHTML = start;
			start += step;
			if(start < 0 ){
				saveexpform();
				start = 30;
			}
		setTimeout("count()",1000);
	}
	window.onload = count;	
	}
function checkexpect(){
	var arrayObj = new Array();
	arrayObj.push('name');
	checkonblur("name");
	arrayObj.push('hyid');
	checkonblur("hyid");
	arrayObj.push('job_class');
	checkonblur("job_class");
	arrayObj.push('maxsalary');
	checkonblur("maxsalary");
	arrayObj.push('minsalary');
	checkonblur("minsalary");
	arrayObj.push('citysid');
	checkonblur("citysid");
	arrayObj.push('typeid');
	checkonblur("typeid");
	arrayObj.push('reportid');
	checkonblur("reportid");
	arrayObj.push('statusid');
	checkonblur("statusid");
	arrayObj.push('uname');
	checkonblur("uname");
	arrayObj.push('sex');
	checkonblur("sex");
	arrayObj.push('birthday');
	checkonblur("birthday");
	arrayObj.push('educid');
	checkonblur("educid");
	arrayObj.push('expid');
	checkonblur("expid");
	arrayObj.push('telphone');
	checkonblur("telphone");
	arrayObj.push('email');
	checkonblur("email");
	arrayObj.push('living');
	checkonblur("living");
	for(i=0;i<arrayObj.length;i++){
		if(exitsdate(arrayObj[i])==false){
			return false;
		}
	}
	var loadi = layer.load('保存中，请稍候...',0);
} 
function checkonblur(id){
	var obj = $.trim($("#"+id).val());
	var msg; 
	if(id=="name"){
		if(obj==""){
			msg='请填写简历名称！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="hyid"){
		if(obj==""){
			msg='请选择从事行业！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="job_class"){
		if(obj==""){
			msg='请选择期望职位！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="maxsalary"){
	    var minsalary=parseInt($('#minsalary').val());
		if(parseInt(obj)>0&&parseInt(obj)<minsalary){
			msg='最高薪资必须大于最低薪资！';
			showblurmsg('minsalary',"0",msg);
		}else{
			msg='';
			showblurmsg('minsalary',"1",msg);
			$("#"+id).attr('date','1');
		}
	}
	if(id=="minsalary"){
	    var maxsalary=parseInt($('#maxsalary').val());
		if(obj==""){
			msg='请填写期望薪资！';
			showblurmsg(id,"0",msg);
		}else if(parseInt(obj)>maxsalary){
			msg='最高薪资必须大于最低薪资！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}	
	if(id=="citysid"){
		if(obj==""){
			msg='请选择工作地区！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="typeid"){
		if(obj==""){
			msg='请选择工作性质！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="reportid"){
		if(obj==""){
			msg='请选择到岗时间！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="statusid"){
		if(obj==""){
			msg='请选择求职状态！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="uname"){
		if(obj==""){
			msg='请输入真实姓名！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="sex"){
		if(obj==""){
			msg='请选择性别！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="birthday"){
		if(obj==""){
			msg='请选择出生日期！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="educid"){
		if(obj==""){
			msg='请选择最高学历！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="expid"){
		if(obj==""){
			msg='请选择工作经验！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	if(id=="telphone"){
		var reg= /^[1][034578]\d{9}$/; //验证手机号码  
		if(obj==''){
			msg="请输入手机号码！";
			showblurmsg(id,"0",msg);
		}else if(!reg.test(obj)){
			msg="手机号码格式错误！";
			showblurmsg(id,"0",msg);
		}else{
			$.post(weburl+"/member/index.php?c=expect&act=regmoblie",{telphone:obj},function(data){
				if(data==0){	
					msg='';
			        showblurmsg(id,"1",msg);
					return true;
				}else{					
					msg="号码已存在！";					
					showblurmsg(id,"0",msg);					
				}
			});	
		 }		
	}
	if(id=="email"){
		var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(obj==""){
			 msg='请输入联系邮箱！';
			 showblurmsg(id,"0",msg);
		 }else if(!myreg.test(obj)){
			msg="邮箱格式错误！";
			showblurmsg(id,"0",msg);
	     }else{			 			 
			 $.post(weburl+"/member/index.php?c=expect&act=ajaxreg",{email:obj},function(data){
				if(data==0){
					msg='';
			        showblurmsg(id,"1",msg);
				}else{
					msg="邮箱已被使用！";
					showblurmsg(id,"0",msg);
				}
			});			 			 			 			
		}
	}
	if(id=="living"){
		if(obj==""){
			msg='请输入现居住地！';
			showblurmsg(id,"0",msg);
		}else{
			msg='';
			showblurmsg(id,"1",msg);
		}
	}
	
}
function showblurmsg(id,type,msg){
	$("#hid_"+id).show();
	$("#hid"+id).html(msg); 
	if(type=="0"){  
		$("#hid"+id).attr("class","");
		$("#"+id).removeClass("resume_tipfalse");
		$("#"+id).attr('date','0');
		return false;
	}else{ 
		$("#hid"+id).attr("class","resume_tipok");
		$("#"+id).addClass("resume_tipfalse");
		$("#"+id).attr('date','1');
	}
}
function exitsdate(id){
	if(document.getElementById(id)){
		if($('#'+id).attr('date')!='1'){
			return false;
		}else{
			return true;
		}
	}else{
		return true;
	}
}
<?php echo '</script'; ?>
>
 <form action="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/?c=expect&act=add" method="post" target="supportiframe" onsubmit="return checkexpect();" autocomplete="off">
  <div class="news_expect_body">
 <div class="news_expect">
<div class="news_expect_cont">
<div class="news_expect_cont_h1">
<div class="news_expect_cont_h1_box">
<span class="news_expect_cont_h1_s">简历是求职的利器，好的简历才能更快找到好工作！</span>
<div class="news_expect_cont_h1_p">填写简历要像对待每一次考试那样认真哦！</div>
</div><?php if ($_smarty_tpl->tpl_vars['save']->value) {?>
 <div id="forms" class="text_tips">您有上次未提交成功的数据 <a href="javascript:;" onclick="saveexp();"  class="text_tips_a">恢复数据</a> <i  id="close"class="text_tips_close"></i></div>
 <?php }?>
</div>




<div class="news_expect_content">

 
<div class="news_expect_tit"><span class="news_expect_tit_s">基本信息</span></div>
<div class="news_expect_n_box">
<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>姓名：</span>
<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
" name="uname" id="uname" class="news_expectadd_text"onBlur="checkonblur('uname');"/>
<div class="resume_tip"><span class="none" id="hiduname"></span></div>
</div>
	
<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>性别：</span>
	<input type="hidden" id="sex" name="sex" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['sex'];?>
" />
    
   
              <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arr_data']->value['sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
              <span class="yun_info_sex_t yun_info_sex <?php if ($_smarty_tpl->tpl_vars['j']->value==$_smarty_tpl->tpl_vars['resume']->value['sex']) {?>yun_info_sex_cur<?php }?>" id="sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
" onclick="checksex('<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
')"><i class="usericon_sex usericon_sex<?php echo $_smarty_tpl->tpl_vars['j']->value;?>
"></i><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>                     
              <?php } ?>            
    
<div class="resume_tip"><span class="none" id="hidsex"></span></div>

</div>
<div class="news_expect_list"> 
	<span class="news_expect_list_span"><i class="news_expectfont">*</i>出生年月：</span>
	   <div class="text"> 
			<input name="birthday" id="birthday"  type="text"  value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['birthday'];?>
" class="news_expect_text_t1" onBlur="checkonblur('birthday');"/>
			<?php echo '<script'; ?>
 type="text/javascript">
				$('#birthday').fdatepicker({format: 'yyyy-mm-dd',initialDate: '1989-02-12',startView:4,minView:2});   
			<?php echo '</script'; ?>
>
		</div> 
        <div class="resume_tip"><span class="none" id="hidbirthday"></span>	</div>
	</div>
<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>现居住地：</span><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['living'];?>
" name="living" class="news_expect_text_t1" id="living" onBlur="checkonblur('living');"/>
<div class="resume_tip"><span class="none" id="hidliving"></span></div>
</div>

<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>最高学历：</span>
<div class="news_expect_text_big   news_expect_text_re2">

<input class="news_expect_bth_big" type="button" <?php if ($_smarty_tpl->tpl_vars['resume']->value['edu']=='') {?>value="请选择最高学历"<?php } else { ?> value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['edu']];?>
"<?php }?> id="educ" onclick="search_show('job_educ');">
	<input type="hidden" id="educid" name="edu" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['edu'];?>
" />
	<div class="news_expect_text_box " style="display:none" id="job_educ">
		<ul class="news_expect_text_box_list">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<li>
				<a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','educ','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
			</li>
			<?php } ?>
		</ul>
	</div>


</div>
<div class="resume_tip"><span class="none" id="hideducid"></span></div>
</div>
<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>工作经验：</span>
<div class="news_expect_text_big   news_expect_text_re1">

<input class="news_expect_bth_big" type="button" <?php if ($_smarty_tpl->tpl_vars['resume']->value['exp']=='') {?>value="请选择工作经验"<?php } else { ?> value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['exp']];?>
"<?php }?> id="exp" onclick="search_show('job_exp');">
	<input type="hidden" id="expid" name="exp" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['exp'];?>
" />
	<div class="news_expect_text_box" style="display:none" id="job_exp">
		<ul class="news_expect_text_box_list">
			 <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_word']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','exp','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="resume_tip"><span class="none" id="hidexpid"></span></div>
</div>
<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>手机号码：</span>
<?php if ($_smarty_tpl->tpl_vars['resume']->value['moblie_status']==1) {?>
<span class="news_phe_ok"><?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
 </span><a href="index.php?c=binding" class="news_ok_rz">重新认证</a>
  <input type="text" id="telphone" name="telphone" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
" style="display:none;">
<?php } else { ?>
<input name="telphone" id="telphone" type="text" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['telphone'];?>
" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" class="news_expect_text_t1" onBlur="checkonblur('telphone');"/>
<span id="by_telphone" style="display:none">请正确填写手机号码</span>
<?php }?>
<div class="resume_tip"><span class="none" id="hidtelphone"></span></div>
</div>

<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>联系邮箱：</span>
<?php if ($_smarty_tpl->tpl_vars['resume']->value['email_status']==1) {?>
<span class="news_email_ok"><?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
</span><a href="index.php?c=binding"  class="news_ok_rz">重新认证</a>
  <input type="text" id="email" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
" style="display:none;">
<?php } else { ?>
 <input name="email" id="email" type="text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['email'];?>
" class="news_expect_text_t1" onBlur="checkonblur('email');"/>
<span id="by_email" class="errordisplay">邮件格式错误</span>
<?php }?>
<div class="resume_tip"><span class="none" id="hidemail"></span></div>
</div>
</div>



<div class="news_expect_tit"><span class="news_expect_tit_yxicon">求职意向</span></div>
<div class="news_expect_n_box">
<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>简历名称：</span>
<input type="text" value="" name="name" id="name" class="news_expectadd_text" onBlur="checkonblur('name');"/>
<span class="news_expect_name">如：销售总监,经理</span>     
<div class="resume_tip"><span class="none" id="hidname"></span></div>
</div>


<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>从事行业：</span>
<div class="news_expect_text_big  news_expect_text_re10">
<input class="news_expect_bth_big" type="button" <?php if ($_smarty_tpl->tpl_vars['resume']->value['hy']) {?> value="<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['resume']->value['hy']];?>
"<?php } else { ?> value="请选择行业" <?php }?> id="hy" onclick="search_show('job_hy');"/>
	<input type="hidden" id="hyid" name="hy" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['hy'];?>
" />
	<div class="news_expect_text_box " style="display:none" id="job_hy">
		<ul class="news_expect_text_box_list">
			 <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','hy','<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
				<?php } ?>
		</ul>
	</div>
	
</div>
<div class="resume_tip"><span class="none" id="hidhyid"></span></div>
</div>

<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>期望职位：</span>
<div class="news_expect_text_big  news_expect_text_re9">
<input type="button" <?php if ($_smarty_tpl->tpl_vars['resume']->value['job_classid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['job_classname'];?>
"<?php } else { ?> value="请选择" <?php }?>style=" float:left;" class="news_expect_bth_big" onclick="index_job(5,'#workadds_job','#job_class','left:100px;top:100px; position:absolute;');" id="workadds_job" >
 <input name='job_class' id='job_class'  value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['job_classid'];?>
"type='hidden' />

</div>
<div class="resume_tip"><span class="none" id="hidjob_class"></span></div>
</div>


<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>期望薪资：</span>
	<div class="news_expect_xztext_box">
		<input type="text" id="minsalary" name="minsalary" size="5" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['minsalary'];?>
" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="news_expect_xztext " onBlur="checkonblur('minsalary');" placeholder="最低薪资" />
          <span class="job_expectxz_dw">元/月</span>
        </div>
		<span class="news_expect_text_xzline">-</span>
        <div class="news_expect_xztext_box">
		<input type="text" id="maxsalary" name="maxsalary" size="5" placeholder="最高薪资" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['maxsalary'];?>
" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"class="news_expect_xztext" />
          <span class="job_expectxz_dw">元/月</span>
    </div>
	<div class="resume_tip"><span class="none" id="hidminsalary"></span></div>
</div>


<div class="news_expect_list" style="position:relative; z-index:6">

<span class="news_expect_list_span"><i class="news_expectfont">*</i>期望城市：</span>
<div class="news_expect_listcity_box">
<div class="news_expect_text_w90  news_expect_text_re7">
<input class="news_expect_bth_w90" type="button"  <?php if ($_smarty_tpl->tpl_vars['resume']->value['provinceid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['resume']->value['provinceid']];?>
" <?php } else { ?>value="请选择"<?php }?> id="province" onclick="search_show('job_province');">
<input type="hidden" id="provinceid" name="provinceid" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['provinceid'];?>
" />

<div class="news_expect_text_box news_expect_text_box_90" id="job_province" style="display:none;">
<ul class="news_expect_text_box_list">
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<li>
		<a href="javascript:;" onclick="select_city('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','province','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
','citys','city');"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
	</li>
	<?php } ?>
</ul>
</div>
</div>
<div class="news_expect_text_w90  news_expect_text_re7">
 <input class="news_expect_bth_w90" type="button"<?php if ($_smarty_tpl->tpl_vars['resume']->value['cityid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['resume']->value['cityid']];?>
" <?php } else { ?>value="请选择"<?php }?> id="citys" onclick="search_show('job_citys');">
 <input type="hidden" id="citysid" name="citysid" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['cityid'];?>
" />

<div class="news_expect_text_box news_expect_text_box_city  news_expect_text_box_90" id="job_citys" style="display:none;">
<ul class="news_expect_text_box_list">

</ul>
</div>
</div>
<div class="news_expect_text_w90  news_expect_text_re7 none" id="cityshowth">
 <input class="news_expect_bth_w90" type="button" <?php if ($_smarty_tpl->tpl_vars['resume']->value['three_cityid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['resume']->value['three_cityid']];?>
" <?php } else { ?>value="请选择"<?php }?> id="three_city" onclick="three_city_show('job_three_city');">

<input type="hidden" id="three_cityid" name="three_cityid" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['three_cityid'];?>
" />

<div class="news_expect_text_box news_expect_text_box_city news_expect_text_box_90" id="job_three_city" style="display:none;">
<ul class="news_expect_text_box_list">

</ul>
</div>
</div>
<div class="resume_tip"><span class="none" id="hidcitysid"></span></div>
</div>
</div>
<div class="news_expect_list"><span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>工作性质：</span>
<input type="hidden" id="typeid" name="type" <?php if ($_smarty_tpl->tpl_vars['row']->value['type']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>
" <?php }?> />
<div class="news_expect_xz_close"><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<span class="m_name_tag type <?php if ($_smarty_tpl->tpl_vars['row']->value['type']==$_smarty_tpl->tpl_vars['v']->value) {?>m_name_tag01<?php }?>" id="type<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" onclick="ck_box('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','type');"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</span>
<?php } ?>
</div>
<div class="resume_tip"><span class="none" id="hidtypeid"></span></div>
</div>


<div class="news_expect_list"><span class="news_expect_list_span"><i class="news_expectfont">*</i>到岗时间：</span>
<div class="news_expect_text_big  news_expect_text_re5">

<input class="news_expect_bth_big" type="button" <?php if ($_smarty_tpl->tpl_vars['resume']->value['report']) {?> value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['resume']->value['report']];?>
"<?php } else { ?> value="请选择到岗时间" <?php }?> id="report" onclick="search_show('job_report');">
	<input type="hidden" id="reportid" name="report" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['report'];?>
" />
	<div class="news_expect_text_box " style="display:none" id="job_report">
		<ul class="news_expect_text_box_list">
			  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
', 'report', '<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
				<?php } ?>
		</ul>
	</div>
</div>
<div class="resume_tip"><span class="none" id="hidreportid"></span></div>
</div>

<div class="news_expect_list">
<span class="news_expect_list_span news_expect_list_spanw160"><i class="news_expectfont">*</i>求职状态：</span>
<div class="news_expect_text_big  news_expect_text_re4">

<input class="news_expect_bth_big" type="button" value="请选择求职状态" id="status" onclick="search_show('jobstatus');">
	<input type="hidden" id="statusid" name="jobstatus" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['jobstatus'];?>
" />
	<div class="news_expect_text_box" style="display:none" id="jobstatus">
		<ul class="news_expect_text_box_list">
			  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
', 'status', '<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
				<?php } ?>
		</ul>
	</div>
</div>
<div class="resume_tip"><span class="none" id="hidstatusid"></span></div>
</div>

<div class="news_expect_n_box">

<div class="news_expect_nbth"><input type="submit"  class="news_expect_list_sub" value="保存" name="submit">
<input id="save" name="save" value="<?php echo $_smarty_tpl->tpl_vars['resume']->value['name'];?>
" type="hidden"/>
<input id="addtype" value="addexpect" type="hidden"/>
</div>
</div>
   <div class="text_tips_bc">
   <div class="text_tips_bc_h1"> 信息保存</div>
   <div class="text_tips_bc_cont"> 
   <?php if ($_smarty_tpl->tpl_vars['save']->value['time']) {?>
   <div class="text_tips_bc_l">信息已于<?php echo $_smarty_tpl->tpl_vars['save']->value['time'];?>
保存</div>
   <?php }?> 
   <div class="text_tips_bc_time">   <span id="totalSecond"></span>s后将自动保存<br>已填信息</div>
   <a  id="atime"href="javascript:;" onclick="saveexpform();" class="text_tips_bc_bth">保存数据</a>
   </div>
   </div>
    </div>
</div>
</div>
</div>
</div>
</form>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
