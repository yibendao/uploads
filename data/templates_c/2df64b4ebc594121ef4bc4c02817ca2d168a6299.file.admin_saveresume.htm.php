<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 00:41:21
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_saveresume.htm" */ ?>
<?php /*%%SmartyHeaderCode:2564259ce77b12bdea2-25883646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2df64b4ebc594121ef4bc4c02817ca2d168a6299' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_saveresume.htm',
      1 => 1492849236,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2564259ce77b12bdea2-25883646',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'style' => 0,
    'uid' => 0,
    'pytoken' => 0,
    'row' => 0,
    'industry_index' => 0,
    'v' => 0,
    'industry_name' => 0,
    'job_classname' => 0,
    'city_name' => 0,
    'city_index' => 0,
    'city_type' => 0,
    'show' => 0,
    'userdata' => 0,
    'userclass_name' => 0,
    'work' => 0,
    'work_l' => 0,
    'edu' => 0,
    'edu_l' => 0,
    'training' => 0,
    'training_l' => 0,
    'skill' => 0,
    'skill_l' => 0,
    'project' => 0,
    'project_l' => 0,
    'other' => 0,
    'other_l' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce77b18025d0_86741039',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce77b18025d0_86741039')) {function content_59ce77b18025d0_86741039($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/template/member/user/js/search.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/check_public.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="javascript">
function saveexpect(){
	var pytoken = $.trim($("#pytoken").val());
	var name = $.trim($("#expect_name").val());
	var hy = $.trim($("#hy_val").val());
	var job_classid = $.trim($("#job_class").val());
	var provinceid = $.trim($("#provinceid").val());
	var cityid = $.trim($("#cityidid").val());
	var three_cityid = $.trim($("#three_cityid").val());
	var minsalary = $.trim($("#minsalary").val());
	var maxsalary = $.trim($("#maxsalary").val());
	var uid = $.trim($("#uid").val());
	var report = $.trim($("#user_report_val").val());
	var typeid = $.trim($("#user_type_val").val());
	var jobstatus = $.trim($("#user_jobstatus_val").val());
	var eid = $.trim($("#eid").val());
	if(name==""){parent.layer.msg('请填写简历名称！', 2, 8);return false; }
	if(hy==""){parent.layer.msg('请选择从事行业！', 2, 8);return false;}
	if(job_classid==""){parent.layer.msg('请选择从事职位！', 2, 8);return false;}
	if(minsalary==""||minsalary=="0"){parent.layer.msg('请填写期望月薪！', 2, 8);return false;}
	if(maxsalary&&parseInt(maxsalary)<=parseInt(minsalary)){parent.layer.msg('最高薪资必须大于最低薪资！', 2, 8);return false;}
	if(provinceid==''){parent.layer.msg('请选择工作地点！', 2, 8);return false;}
	if(report==""){parent.layer.msg('请选择到岗时间！', 2, 8);return false;}
	if(jobstatus==""){parent.layer.msg('请选择求职状态！', 2, 8);return false;}
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=saveexpect",{name:name,hy:hy,job_classid:job_classid,provinceid:provinceid,cityid:cityid,three_cityid:three_cityid,minsalary:minsalary,maxsalary:maxsalary,report:report,eid:eid,submit:"1",uid:uid,pytoken:pytoken,type:typeid,jobstatus:jobstatus},function(data){
		parent.layer.closeAll();
		if(data==0){
			parent.layer.msg('操作失败！', 2, 8);return false;
		}else if(data==1){
			parent.layer.msg('简历数已经超过系统设置的简历数了！', 2, 8);return false;
		}else{
			data=eval('('+data+')');
			if(eid==""){
				window.location.href="index.php?m=admin_resume&c=saveresume&uid="+uid+"&e="+data.id;
			}else{
				$("#addresume").hide();
				if(three_cityid<1){
				    $("#cityshowth").addClass('dn');
				}
				$("#resume").show();
				$("#expect_name_html").html('<div class="admin_td_h">'+data.name+'</div>');
				$("#hy_html").html('<div class="admin_td_h">'+data.hy+'</div>');
				$("#job_class_html").html('<div class="admin_td_h">'+data.job_classname+'</div>');
				$("#salary_html").html('<div class="admin_td_h">￥'+data.minsalary+'-'+data.maxsalary+'</div>');
				$("#cityid_html").html('<div class="admin_td_h">'+data.city+'</div>');
				$("#report_html").html('<div class="admin_td_h">'+data.report+'</div>');
				$("#type_html").html('<div class="admin_td_h">'+data.type+'</div>');
				$("#jobstatus_html").html('<div class="admin_td_h">'+data.jobstatus+'</div>');
				$("#eid").val(data.id);
			}
		}
	});
}
function checkmore(type){
	$("#add"+type).show();
	$("#"+type).hide();
}
function layerClose(type){
	$("#add"+type).hide();
	$("#"+type).show();
	$("#"+type+"_add_button").show();
}
function savework(){
	var eid = $.trim($("#eid").val());
	var id = $.trim($("#workid").val());
	var sdate = $.trim($("#work_sdate").val());
	var edate = $.trim($("#work_edate").val());
	var name = $.trim($("#work_name").val());
	var department = $.trim($("#work_department").val());
	var title = $.trim($("#work_title").val());
	var salary = $.trim($("#work_salary").val());
	var content = $.trim($("#work_content").val());
	var pytoken = $.trim($("#pytoken").val());
	var uid = $.trim($("#uid").val());
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2,8);
		return false;
	}
	if(name==""){
		parent.layer.msg('请填写单位名称！', 2,8);
		return false;
	}
	if(sdate==""){
		parent.layer.msg('开始时间不能为空！', 2,8);
		return false
	}else{
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){
			parent.layer.msg('开始时间不得大于结束时间', 2,8);
			return false
		}
	}
    if(edate=='至今'){
	    edate='';
	}	
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=work",{sdate:sdate,edate:edate,name:name,department:department,eid:eid,salary:salary,title:title,content:content,id:id,table:"resume_work",submit:"1",uid:uid,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		if(data!=0){
			data=eval('('+data+')');
			$("#work").show();
			$("#addwork").hide();
			if(id>0){
				var html='<div class="admin_saversume_tit"><span class="admin_saversume_tit_b">'+data.name+'</span> 担任职位： <span class="admin_saversume_tit_b">'+data.title+'</span> </div><div>'+data.sdate+' - '+data.edate+'</div><div>'+data.content+'</div><div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume(\'work\',\''+data.id+'\')" class="admin_save_sub1">【修改】</a><a href="javascript:void(0)" onclick="resume_del(\'work\',\''+data.id+'\')" class="admin_save_sub2">【删除】</a></div>';
				$("#work_"+id).html(html);
			}else{
				var html='<div class="admin_saversume_list" id="work_'+data.id+'"><div class="admin_saversume_tit"><span class="admin_saversume_tit_b">'+data.name+'</span> 担任职位： <span class="admin_saversume_tit_b">'+data.title+'</span> </div><div>'+data.sdate+' - '+data.edate+'</div><div>'+data.content+'</div><div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume(\'work\',\''+data.id+'\')" class="admin_save_sub1">【修改】</a><a href="javascript:void(0)" onclick="resume_del(\'work\',\''+data.id+'\')" class="admin_save_sub2">【删除】</a></div></div>';
				$("#work_list").append(html);
			}
			$("#work_add_button").show();
		}else{
			parent.layer.msg('操作失败！', 2,8);
		}
	});
}
function saveedu(){
	var eid = $.trim($("#eid").val());
	var id = $.trim($("#eduid").val());
	var sdate = $.trim($("#edu_sdate").val());
	var edate = $.trim($("#edu_edate").val());
	var name = $.trim($("#edu_name").val());
	var title = $.trim($("#edu_title").val());
	var education = $.trim($("#user_education_val").val());
	var specialty = $.trim($("#edu_specialty").val());
	var uid = $.trim($("#uid").val());
	var pytoken = $.trim($("#pytoken").val());
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2,8);
		return false;
	}
	if(name==""){
		layer.msg('请填写学校名称！', 2,8);
		return false;
	}
	if(sdate==""){
		parent.layer.msg('开始时间不能为空！', 2,8);
		return false
	}else{
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){
			parent.layer.msg('开始时间不得大于结束时间', 2,8);
			return false
		}
	}
	if(edate=='至今'){
	    edate='';
	}
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=edu",{sdate:sdate,edate:edate,name:name,education:education,specialty:specialty,eid:eid,title:title,id:id,table:"resume_edu",submit:"1",uid:uid,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		if(data!=0){
			data=eval('('+data+')');
			$("#edu").show();
			$("#addedu").hide();
			if(id>0){
				var html='<div class=\"admin_saversume_tit\"><span class=\"admin_saversume_tit_b\">'+data.name+'</span> 班级职务： <span class=\"admin_saversume_tit_b\">'+data.title+'</span></div><div>'+data.sdate+' - '+data.edate+'</div><div> 最高学历：'+data.educationval+' 所学专业：'+data.specialty+'</div><div class=\"admin_saversume_cz\"><a href="javascript:void(0)" onclick="getresume(\'edu\',\''+data.id+'\')"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del(\'edu\',\''+data.id+'\')\"class=\"admin_save_sub2\">【删除】</a></div>';
				$("#edu_"+id).html(html);
			}else{
				var html='<div class=\"admin_saversume_list\" id="edu_'+data.id+'"><div class=\"admin_saversume_tit\"><span class=\"admin_saversume_tit_b\">'+data.name+'</span> 班级职务： <span class=\"admin_saversume_tit_b\">'+data.title+'</span></div><div>'+data.sdate+' - '+data.edate+'</div><div> 最高学历：'+data.educationval+' 所学专业：'+data.specialty+'</div><div class=\"admin_saversume_cz\"><a href="javascript:void(0)" onclick="getresume(\'edu\',\''+data.id+'\')"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del(\'edu\',\''+data.id+'\')\"class=\"admin_save_sub2\">【删除】</a></div></div>';
				$("#edu_list").append(html);
			}
			$("#edu_add_button").show();
		}else{
			parent.layer.msg('操作失败！', 2,8);
		}
	});
}
function savetraining(){
	var eid = $.trim($("#eid").val());
	var id = $.trim($("#trainingid").val());
	var sdate = $.trim($("#training_sdate").val());
	var edate = $.trim($("#training_edate").val());
	var name = $.trim($("#training_name").val());
	var title = $.trim($("#training_title").val());
	var content = $.trim($("#training_content").val());
	var uid = $.trim($("#uid").val());
	var pytoken = $.trim($("#pytoken").val());
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2,8);
		return false;
	}
	if(name==""){
		parent.layer.msg('请填写培训中心！', 2,8);
		return false;
	}
	if(sdate==""){
		parent.layer.msg('开始时间不能为空！', 2,8);
		return false
	}else{
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){
			parent.layer.msg('开始时间不得大于结束时间', 2,8);
			return false
		}
	}
	if(edate=='至今'){
	    edate='';
	}
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=training",{sdate:sdate,edate:edate,name:name,eid:eid,title:title,content:content,id:id,table:"resume_training",submit:"1",uid:uid,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		if(data!=0){
			data=eval('('+data+')');
			$("#training").show();
			$("#addtraining").hide();
			if(id>0){
				var html='<div class="admin_saversume_tit"><span class="admin_saversume_tit_b">'+data.name+'</span> 培训方向： <span class="admin_saversume_tit_b">'+data.title+'</span> </div><div>'+data.sdate+' - '+data.edate+'</div><div>'+data.content+'</div><div class="admin_saversume_cz"><a href="javascript:void(0)" onclick="getresume(\'training\',\''+data.id+'\')"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del(\'training\',\''+data.id+'\')\"class=\"admin_save_sub2\">【删除】</a></div>';
				$("#training_"+id).html(html);
			}else{
				var html='<div class="admin_saversume_list" id="training_'+data.id+'"><div class="admin_saversume_tit"><span class="admin_saversume_tit_b">'+data.name+'</span> 培训方向： <span class="admin_saversume_tit_b">'+data.title+'</span> </div><div>'+data.sdate+' - '+data.edate+'</div><div>'+data.content+'</div><div class="admin_saversume_cz"><a href="javascript:void(0)" onclick="getresume(\'training\',\''+data.id+'\')"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del(\'training\',\''+data.id+'\')\"class=\"admin_save_sub2\">【删除】</a></div></div>';
				$("#training_list").append(html);
			}
			$("#training_add_button").show();
		}else{
			parent.layer.msg('操作失败！', 2,8);
		}
	});
}
function saveskill(){
	var eid = $.trim($("#eid").val());
	var id = $.trim($("#skillid").val());
	var name = $.trim($("#skill_name").val());
	var longtime = $.trim($("#skill_longtime").val());
	var pic = $.trim($("#skill_pic").val());
	var uid = $.trim($("#uid").val());
	var pytoken = $.trim($("#pytoken").val());
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2, 8);
		return false;
	}
	if(name==""){
		parent.layer.msg('请填写技能名称！', 2, 8);
		return false;
	}
	if(longtime==""||longtime=="0"){
		parent.layer.msg('请填写掌握时间！', 2, 8);
		return false;
	}
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=skill",{name:name,longtime:longtime,pic:pic,eid:eid,id:id,table:"resume_skill",submit:"1",uid:uid,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		if(data!=0){
			data=eval('('+data+')');
			$("#addskill").hide();
			$("#skill").show();
			if(id>0){
				var html="<div clas=\"admin_saversume_tit\"><span class=\"admin_saversume_tit_b\">"+data.name+"</span> 掌握时间：<span class=\"admin_saversume_tit_b\">"+data.longtime+"年</span></div><div>技能证书：<img src=\"."+data.pic+"\" width='95' height='70'></div><div clas=\"admin_saversume_cz\"><a href=\"javascript:void(0)\" onclick=\"getresume('skill','"+data.id+"')\"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del('skill','"+data.id+"')\" class=\"admin_save_sub2\">【删除】</a></div>";
				$("#skill_"+id).html(html);
				$("#skill_add_button").show();
			}else{
				var html="<div class=\"admin_saversume_list\" id='skill_"+data.id+"'><div clas=\"admin_saversume_tit\"><span class=\"admin_saversume_tit_b\">"+data.name+"</span> 掌握时间：<span class=\"admin_saversume_tit_b\">"+data.longtime+"年</span></div><div>技能证书：<img src=\"."+data.pic+"\" width='95' height='70'></div><div clas=\"admin_saversume_cz\"><a href=\"javascript:void(0)\" onclick=\"getresume('skill','"+data.id+"')\"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del('skill','"+data.id+"')\" class=\"admin_save_sub2\">【删除】</a></div></div>";
				$("#skill_list").append(html);
				$("#skill_add_button").show();
			}
		}else{
			parent.layer.msg('操作失败！', 2,8);
		}
	});
}
function saveproject(){
	var eid = $.trim($("#eid").val());
	var id = $.trim($("#projectid").val());
	var sdate = $.trim($("#project_sdate").val());
	var edate = $.trim($("#project_edate").val());
	var name = $.trim($("#project_name").val());
	var sys = $.trim($("#project_sys").val());
	var title = $.trim($("#project_title").val());
	var content = $.trim($("#project_content").val());
	var uid = $.trim($("#uid").val());
	var pytoken = $.trim($("#pytoken").val());
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2,8);
		return false;
	}
	if(name==""){
		parent.layer.msg('请填写项目名称！', 2,8);
		return false;
	}
	if(sdate==""){
		parent.layer.msg('开始时间不能为空！', 2,8);
		return false
	}else{
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){
			parent.layer.msg('开始时间不得大于结束时间！', 2,8);
			return false
		}
	}	
	if(edate=='至今'){
	    edate='';
	}
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=project",{sdate:sdate,edate:edate,name:name,sys:sys,eid:eid,title:title,content:content,id:id,table:"resume_project",submit:"1",uid:uid,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		if(data!=0){
			data=eval('('+data+')');
			$("#project").show();
			$("#addproject").hide();
			if(id>0){
				var html='<div class="admin_saversume_tit"><span class=\"admin_saversume_tit_b\">'+data.name+'</span> 担任职位 <span class=\"admin_saversume_tit_b\">'+data.title+'</span></div><div>'+data.sdate+'-'+data.edate+'</div><div>'+data.content+'</div><div class="\admin_saversume_cz\"><a href="javascript:void(0)" onclick="getresume(\'project\','+data.id+')"class=\"admin_save_sub1\">【修改】</a></th><td><a href=\"javascript:void(0)\" onclick=\"resume_del(\'project\','+data.id+')\"class=\"admin_save_sub2\">【删除】</a></div>';
				$("#project_"+id).html(html);
			}else{
				var html='<div class=\"admin_saversume_list\"id="project_'+data.id+'"><div class="admin_saversume_tit"><span class=\"admin_saversume_tit_b\">'+data.name+'</span> 担任职位 <span class=\"admin_saversume_tit_b\">'+data.title+'</span></div><div>'+data.sdate+'-'+data.edate+'</div><div>'+data.content+'</div><div class="\admin_saversume_cz\"><a href="javascript:void(0)" onclick="getresume(\'project\','+data.id+')"class=\"admin_save_sub1\">【修改】</a></th><td><a href=\"javascript:void(0)\" onclick=\"resume_del(\'project\','+data.id+')\"class=\"admin_save_sub2\">【删除】</a></div></div>';
				$("#project_list").append(html);
			}

			$("#project_add_button").show();

		}else{
			parent.layer.msg('操作失败！', 2,8);
		}
	});
}
function saveother(){
	var eid = $.trim($("#eid").val());
	var id = $.trim($("#otherid").val());
	var name = $.trim($("#other_name").val());
	var content = $.trim($("#other_content").val());
	var uid = $.trim($("#uid").val());
	var pytoken = $.trim($("#pytoken").val());
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2,8);
		return false;
	}
	if(name==""){
		parent.layer.msg('请填写其他标题！', 2,8);
		return false;
	}
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=other",{eid:eid,name:name,content:content,id:id,table:"resume_other",submit:"1",uid:uid,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		if(data!=0){
			data=eval('('+data+')');
			$("#other").show();
			$("#addother").hide();
			if(id>0){
				var html='<div  class="admin_saversume_tit"><span class="admin_saversume_tit_b">'+data.name+'</span></div><div ></th><td style="width:320px"><em>'+data.content+'</em></div> <div class="admin_saversume_cz"><a href="javascript:void(0)" onclick="getresume(\'other\','+data.id+')"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del(\'other\','+data.id+')\"class=\"admin_save_sub2\">【删除】</a></div>';
				$("#other_"+id).html(html);
			}else{
				var html='<div class="admin_saversume_list"  id="other_'+data.id+'"><div  class="admin_saversume_tit"><span class="admin_saversume_tit_b">'+data.name+'</span></div><div ></th><td style="width:320px"><em>'+data.content+'</em></div> <div class="admin_saversume_cz"><a href="javascript:void(0)" onclick="getresume(\'other\','+data.id+')"class=\"admin_save_sub1\">【修改】</a><a href=\"javascript:void(0)\" onclick=\"resume_del(\'other\','+data.id+')\"class=\"admin_save_sub2\">【删除】</a></div></div>';
				$("#other_list").append(html);
			}
			$("#other_add_button").show();
		}else{
			parent.layer.msg('操作失败！', 2, 8);
		}
	});
}
function checkClose(type){
	$("#add"+type).hide();
	$("#"+type).show();
}

function getresume(type,id){ 
	$("#add"+type+" .admin_save_sub").val("修 改");
	var pytoken = $.trim($("#pytoken").val());
	$("#add"+type).show();
	parent.layer.load('执行中，请稍候...',0);
	$.post("index.php?m=admin_resume&c=resume_ajax",{type:type,id:id,pytoken:pytoken},function(data){
		parent.layer.closeAll();
		var data=eval('('+data+')');
		if(type=="skill"){
			$("#skill_name").val(data.name);
			$("#skill_longtime").val(data.longtime);
			$("#skillid").val(data.id);
			$("#skill_pic").val(data.pic);
		}
		if(type=="work"){
			$("#work_name").val(data.name);
			$("#work_sdate").val(data.sdate);
			$("#work_edate").val(data.edate);
			$("#work_department").val(data.department);
			$("#work_title").val(data.title);
			$("#work_salary").val(data.salary);
			$("#work_content").val(data.content);
			$("#workid").val(data.id);
		}
		if(type=="project"){
			$("#project_name").val(data.name);
			$("#project_sdate").val(data.sdate);
			$("#project_edate").val(data.edate);
			$("#project_sys").val(data.sys);
			$("#project_title").val(data.title);
			$("#project_content").val(data.content);
			$("#projectid").val(data.id);
		}
		if(type=="edu"){
			$("#edu_name").val(data.name);
			$("#edu_sdate").val(data.sdate);
			$("#edu_edate").val(data.edate);
			$("#user_education_val").val(data.education);	
			$("#user_education_name").val(data.educationval);	
			$("#edu_title").val(data.title);	
			$("#edu_specialty").val(data.specialty);						
			$("#eduid").val(data.id);
		}
		if(type=="training"){
			$("#training_name").val(data.name);
			$("#training_sdate").val(data.sdate);
			$("#training_edate").val(data.edate);
			$("#training_title").val(data.title);
			$("#training_content").val(data.content);
			$("#trainingid").val(data.id);
		}
		if(type=="other"){
			$("#other_name").val(data.name);
			$("#other_content").val(data.content);
			$("#otherid").val(data.id);
		}
		$("#"+type+"_add_button").hide();
	});
}
function checkmore2(type){
	var eid=$.trim($("#eid").val());
	$("#add"+type+" .admin_save_sub").val("添 加");
	if(eid==""){
		parent.layer.msg('请先完善求职意向！', 2, 8);return false;
	} 
	$("#"+type+"_add_button").hide();
	$("#"+type+"_botton").attr("class","jianli_list_noadd");
	$("#"+type+"_botton").html('<em>暂不填写</em>');
	$("#"+type+"_botton").attr("onclick","checkClose2('"+type+"');");
	$("#add"+type).show();
	if(type=="skill"){
		$("#skill_name").val('');
		$("#skill_longtime").val('');
		$("#skillid").val('');
		$("#skill_pic").val('');
	}
	if(type=="work"){
		$("#work_name").val('');
		$("#work_sdate").val('');
		$("#work_edate").val('');
		$("#work_department").val('');
		$("#work_title").val('');
		$("#work_content").val('');
		$("#workid").val('');
	}
	if(type=="project"){
		$("#project_name").val('');
		$("#project_sdate").val('');
		$("#project_edate").val('');
		$("#project_sys").val('');
		$("#project_title").val('');
		$("#project_content").val('');
		$("#projectid").val('');
	}
	if(type=="edu"){
		$("#edu_name").val('');
		$("#edu_sdate").val('');
		$("#edu_edate").val('');
		$("#educationcid").val('');
		$("#educationc").val('请选择最高学历');
		$("#edu_title").val('');
		$("#eduid").val('');
	}
	if(type=="training"){
		$("#training_name").val('');
		$("#training_sdate").val('');
		$("#training_edate").val('');
		$("#training_title").val('');
		$("#training_content").val('');
		$("#trainingid").val('');
	}
	if(type=="other"){
		$("#other_name").val('');
		$("#other_content").val('');
		$("#otherid").val('');
	}
}
function checkClose2(type){
	$("#"+type).hide();
	$("#"+type+"_botton").attr("class","jianli_list_add");
	$("#"+type+"_botton").html('<em>添加</em>');
	$("#"+type+"_botton").attr("onclick","checkmore2('"+type+"');");
	$("#Add"+type).show();
}
function toDate(str){
    var sd=str.split("-");
    return new Date(sd[0],sd[1],sd[2]);
}
function resume_del(table,id){
	var eid = $.trim($("#eid").val());
	var uid = $.trim($("#uid").val());
	var pytoken = $.trim($("#pytoken").val());
	parent.layer.confirm('确定要删除该项内容？', function(){
		parent.layer.load('执行中，请稍候...',0);
		$.post("index.php?m=admin_resume&c=resume_del",{table:table,id:id,eid:eid,uid:uid,pytoken:pytoken},function(data){
			parent.layer.closeAll();
			if(data!="0"){
				$("#"+table+'_'+id).remove();
				parent.layer.msg('删除成功！', 2,9);
			}else{
				parent.layer.msg('网络繁忙，请稍后！', 2,8);
			}
		});
	});
}
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
function showjob(id){
	$("#td"+id).attr("class","focusItemTop mOutItem");
	$("#span"+id).hide();
	$("#div"+id).show();
}
function guanbiselect(id){
   $("#td"+id).bind("mouseleave", function(){
	$("#td"+id).attr("class","blurItem");
	$("#span"+id).show();
	$("#div"+id).hide();
   });
}
function check_this(id){
	if($("#job_class_"+id).attr("disabled") != 'disabled'){
		if($("#job_class_"+id).attr("checked")!="checked"){
		 	var pid = $("#job_class_"+id).attr('data-pid');
			 $("#job_class_"+id).removeAttr("checked");
			 unsel(id,pid);
		}else{
			 var pid = $("#job_class_"+id).attr('data-pid');
			 $("#job_class_"+id).attr("checked","true");
			 addsel(id,pid);
		}
	}
}
function check_all(id){
	if($("#all"+id).attr("checked")!="checked"){
		$(".label"+id).removeAttr("disabled");
		$(".label"+id).removeAttr("checked");
		unsel(id);
	}else{
		$("#all"+id).attr("checked","true");
		$(".label"+id).attr("disabled","disabled");
		$(".label"+id).attr("checked","true");
		addsel(id);
	}
}
function addsel(id,pid){

	var i=0;
	$(".selall").each(function(){
		i++;
	});
	if(parseInt(pid)>0){
		if(i>5){
			unsel(id,pid);
			parent.layer.msg('您最多只能选择五项！', 2,8);
			return false;
		}else{
			var name = $('#job_class_'+id).attr('data-name');
			html = '<li class="job_class_'+id+' parent_'+pid+'"><a class="clean g3 selall" href="javascript:void(0);" data-val="'+id+'+'+name+'"><span class="text">'+name+'</span><span class="delete" data-id="'+id+'" data-pid ="'+pid+'">移除</span></a></li>';
			$('.job_class_'+id).remove();
			$('.selected').append(html);
		}
	}else{
		if(i>4){
			unsel(id);
			parent.layer.msg('您最多只能选择五项！', 2,8);
			return false;
		}else{
			var name = $('#all'+id).attr('data-name');
			html = '<li class="all'+id+'"><a class="clean g3 selall" href="javascript:void(0);"  data-val="'+id+'+'+name+'"><span class="text">'+name+'</span><span class="delete" data-id="'+id+'">移除</span></a></li>';
			$('.parent_'+id).remove();
			$('.all'+id).remove();
			$('.selected').append(html);
		}
	}
}
function unsel(id,pid){
	if(parseInt(pid)>0){
		$('.job_class_'+id).remove();
		$('#job_class_'+id).removeAttr("checked","");
	}else{
		$('.all'+id).remove();
		$('#all'+id).removeAttr("checked","");
		$('.label'+id).removeAttr("disabled");
		$('.label'+id).removeAttr("checked");
	}
}
function determine(id){
	var check_val,name_val;
	$(".selall").each(function(){
		var info =$(this).attr("data-val").split("+");
		check_val+=","+info[0];
		name_val+="+"+info[1];
	});
	if(check_val){
		 check_val = check_val.replace("undefined,","");
	  $("#job_class").val(check_val);
	}
 	if(name_val){
		name_val = name_val.replace("undefined+","");
  		$("#workadds_job").val(name_val);
	}
	layer.closeAll();
} 
function checkskill(){
	var name = $.trim($("#skill_name").val());
	var longtime = $.trim($("#skill_longtime").val());
	if(name==""){
		parent.layer.msg('请填写技能名称！', 2, 8);
		return false;
	}
	if(longtime==""||longtime=="0"){
		parent.layer.msg('请填写掌握时间！', 2, 8);
		return false;
	}
}
<?php echo '</script'; ?>
>
<style>
* {
	margin: 0;
	padding: 0;
}
body, div {
	margin: 0;
	padding: 0;
}
.no_border {
	border-bottom: medium none;
}
.table_form a {
	color: #3d84b8;
}
</style>
<title>后台管理</title>
</head>
<body class="body_ifm">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
<div class="admin_table_border">
  <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
  <input type="hidden" name="uid" id='uid' value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
">
  <input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
  <input type="hidden" name="eid" id='eid' <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?>value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"<?php }?>>
  <div id="addresume" <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?> style='display:none'<?php }?>>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120"  bgcolor="#f5f5f5">求职意向</th>
      <td colspan='4' style="padding:0px;"><table width="100%">
          <tr>
            <th width='120'>简历名称：</th>
            <td><input type="text" name="name" id="expect_name" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
"></td>
            <th>期望从事行业：</th>
            <td><div class="yun_admin_select_box z_index15"> 
			    <?php if ($_smarty_tpl->tpl_vars['row']->value['hy']) {?>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['hy']==$_smarty_tpl->tpl_vars['v']->value) {?>
                <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" class="yun_admin_select_box_text" id="hy_name" onClick="select_click('hy');">
                <input name="hy" type="hidden" id="hy_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
">
                 
                <?php }?>
                <?php } ?>
                <?php } else { ?>
                <input type="button" value="请选择" class="yun_admin_select_box_text" id="hy_name" onClick="select_click('hy');">
                <input name="hy" type="hidden" id="hy_val" value="">
                 
                <?php }?>
                <div class="yun_admin_select_box_list_box dn" id="hy_select"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                  <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('hy','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
                  <?php } ?> </div>
              </div></td>
          </tr>
          <tr >
            <th>期望从事职位：</th>
            <td><div class="admin_td_h">
                <input id="job_class" type="hidden" name='job_post' value="<?php echo $_smarty_tpl->tpl_vars['row']->value['job_classid'];?>
" name="job_class">
                <input id="workadds_job" class="expect_text"  type="button" onclick="index_job(5, '#workadds_job', '#job_class','','<?php echo $_smarty_tpl->tpl_vars['row']->value['job_classid'];?>
');" style=" float:left;" value="<?php if ($_smarty_tpl->tpl_vars['job_classname']->value) {
echo $_smarty_tpl->tpl_vars['job_classname']->value;
} else { ?>请选择职位<?php }?>">
              </div></td>
            <th>期望月薪：</th>
            <td>
               <div> 
                <input type="text" id="minsalary" name="minsalary" size="6" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['minsalary']) {
echo $_smarty_tpl->tpl_vars['row']->value['minsalary'];
}?>" class="admin_text_w70"> -
                <input type="text" id="maxsalary" name="maxsalary" size="6" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['maxsalary']) {
echo $_smarty_tpl->tpl_vars['row']->value['maxsalary'];
}?>"class="admin_text_w70">
              </div>
             </td>
          </tr>
          <tr >
            <th>工作地点：</th>
            <td>
            
              <div class="yun_admin_select_box yun_admin_select_boxw130 z_index15">
            <input type="button" id="province" onclick="search_show('job_province');" value="<?php if ($_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['provinceid']]) {
echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['provinceid']];
} else { ?>请选择<?php }?>" class="yun_admin_select_box_text">
            <input type="hidden" id="provinceid" name="provinceid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['provinceid'];?>
" />
            <div class="yun_admin_select_box_list_box yun_admin_select_box_list_boxw130 dn" style="display:none" id="job_province"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
              <div class="yun_admin_select_box_list"><a href="javascript:;" onclick="select_city('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','province','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
','cityid','city');"> <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></div>
              <?php } ?> </div>
          </div>
          <div class="yun_admin_select_box yun_admin_select_boxw130 z_index15">
            <input type="button" id="cityid" onclick="search_show('job_cityid');" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['cityid']) {
echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['cityid']];
} else { ?>请选择<?php }?>" class="yun_admin_select_box_text">
            <input type="hidden" id="cityidid" name="cityid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['cityid'];?>
"/>
            <div class="yun_admin_select_box_list_box yun_admin_select_box_list_boxw130 dn" style="display:none" id="job_cityid">
              <div class="yun_admin_select_box_list"><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['row']->value['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="javascript:;" onclick="select_city('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','cityid','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
','three_city','city');"> <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
            </div>
          </div>
          <div class="yun_admin_select_box yun_admin_select_boxw130 z_index15 <?php if ($_smarty_tpl->tpl_vars['show']->value['three_cityid']<1) {?>dn<?php }?>" id="cityshowth">
            <input type="button" id="three_city" onclick="three_city_show('job_three_city');" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['three_cityid']) {
echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['three_cityid']];
} else { ?>请选择<?php }?>" class="yun_admin_select_box_text">
            <input type="hidden" id="three_cityid" name="three_cityid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['three_cityid'];?>
" />
            <div class="yun_admin_select_box_list_box yun_admin_select_box_list_boxw130 dn" style="display:none" id="job_three_city">
              <div class="yun_admin_select_box_list"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['row']->value['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','three_city','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?> </div>
            </div>
          </div>
              </td>
            <th>到岗时间：</th>
            <td ><div class="yun_admin_select_box z_index12"> <?php if ($_smarty_tpl->tpl_vars['row']->value['report']) {?>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['report']==$_smarty_tpl->tpl_vars['v']->value) {?>
                <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" class="yun_admin_select_box_text" id="user_report_name" onClick="select_click('user_report');">
                <input name="report" type="hidden" id="user_report_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
">
                 
                <?php }?>
                <?php } ?>
                <?php } else { ?>
                <input type="button" value="请选择" class="yun_admin_select_box_text" id="user_report_name" onClick="select_click('user_report');">
                <input name="report" type="hidden" id="user_report_val" value="0">
                 
                <?php }?>
                <div class="yun_admin_select_box_list_box dn" id="user_report_select"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                  <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('user_report','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
                  <?php } ?> </div>
              </div></td>
          </tr>
          <tr>
            <th>工作性质：</th>
            <td><div class="yun_admin_select_box z_index11"> <?php if ($_smarty_tpl->tpl_vars['row']->value['type']) {?>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['type']==$_smarty_tpl->tpl_vars['v']->value) {?>
                <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" class="yun_admin_select_box_text" id="user_type_name" onClick="select_click('user_type');">
                <input name="type" type="hidden" id="user_type_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
">
                 
                <?php }?>
                <?php } ?>
                <?php } else { ?>
                <input type="button" value="请选择" class="yun_admin_select_box_text" id="user_type_name" onClick="select_click('user_type');">
                <input name="type" type="hidden" id="user_type_val" value="0">
                 
                <?php }?>
                <div class="yun_admin_select_box_list_box dn" id="user_type_select"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                  <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('user_type','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
                  <?php } ?> </div>
              </div></td>
            <th>求职状态：</th>
            <td ><div class="yun_admin_select_box z_index10"> <?php if ($_smarty_tpl->tpl_vars['row']->value['jobstatus']) {?>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['jobstatus']==$_smarty_tpl->tpl_vars['v']->value) {?>
                <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
" class="yun_admin_select_box_text" id="user_jobstatus_name" onClick="select_click('user_jobstatus');">
                <input name="jobstatus" type="hidden" id="user_jobstatus_val" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
">
                 
                <?php }?>
                <?php } ?>
                <?php } else { ?>
                <input type="button" value="请选择" class="yun_admin_select_box_text" id="user_jobstatus_name" onClick="select_click('user_jobstatus');">
                <input name="jobstatus" type="hidden" id="user_jobstatus_val" value="0">
                 
                <?php }?>
                <div class="yun_admin_select_box_list_box dn" id="user_jobstatus_select"> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                  <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('user_jobstatus','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
                  <?php } ?> </div>
              </div></td>
          </tr>
        </table></td>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr >
      <td colspan='5' align="center"><input class="admin_save_sub" type="button" value="修 改" name="submit" onclick="saveexpect()"  >
        <input class="admin_save_sub_qx" type="button" value="取 消" name="submit"  onclick="checkClose('resume');"  ></td>
    </tr>
  </table>
</div>
<div id='resume' <?php if ($_smarty_tpl->tpl_vars['row']->value['id']=='') {?> style='display:none'<?php }?>>
<table width="100%" class="table_form_resume" style="background:#fff;">
<tr>
<th width="120"  bgcolor="#f5f5f5">求职意向</th>
<td colspan='4' style="padding:0px;">
<table width="100%">
  <tr>
    <th  width="120">简历名称：</th>
    <td id="expect_name_html"><div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</div></td>
    <th  width="120" class="admin_td_liner">期望从事行业：</th>
    <td id="hy_html"><div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['row']->value['hy']];?>
</div></td>
  </tr>
  <tr >
    <th>期望从事职位：</th>
    <td id="job_class_html"><div class="" style="width:450px; line-height:36px;"><?php echo $_smarty_tpl->tpl_vars['job_classname']->value;?>
</div></td>
    <th class="admin_td_liner">期望月薪：</th>
    <td id="salary_html"><div class="admin_td_h"><?php if ($_smarty_tpl->tpl_vars['row']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['row']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['row']->value['maxsalary'];
} else { ?>￥<?php echo $_smarty_tpl->tpl_vars['row']->value['minsalary'];?>
以上<?php }?></div></td>
  </tr>
  <tr >
    <th>工作地点：</th>
    <td id="cityid_html"><div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['provinceid']];?>
 <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['cityid']];?>
 <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['three_cityid']];?>
</div></td>
    <th class="admin_td_liner">到岗时间：</th>
    <td id="report_html"><div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['row']->value['report']];?>
</div></td>
  </tr>
  <tr>
    <th>工作性质：</th>
    <td  id="type_html"><div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['row']->value['type']];?>
</div></td>
    <th class="admin_td_liner">求职状态：</th>
    <td id="jobstatus_html"><div class="admin_td_h"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['row']->value['jobstatus']];?>
</div></td>
  </tr>
  <table>
      </td>
    
      </tr>
    
  </table>
    </td>
  
    </tr>
  
</table>
<table width="100%" class="table_form_resume" style="background:#fff;">
  <tr>
    <td colspan="5" align="center"><input class="admin_save_sub" type="button" value="修 改" name="submit" onclick="checkmore('resume')" ></td>
  </tr>
</table>
</div>
<div id='work' >
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120" bgcolor="#f5f5f5">工作经历：</th>
      <td colspan='4'><div id='work_list'> 
	     <?php if ($_smarty_tpl->tpl_vars['work']->value) {?>
          <?php  $_smarty_tpl->tpl_vars['work_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['work_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['work']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['work_l']->key => $_smarty_tpl->tpl_vars['work_l']->value) {
$_smarty_tpl->tpl_vars['work_l']->_loop = true;
?>
          <div class="admin_saversume_list" id="work_<?php echo $_smarty_tpl->tpl_vars['work_l']->value['id'];?>
">
            <div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['work_l']->value['name'];?>
</span> 
            	<?php if ($_smarty_tpl->tpl_vars['work_l']->value['title']) {?>担任职位： <span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['work_l']->value['title'];?>
</span><?php }?> 
            </div>
            <div><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['work_l']->value['sdate'],"%Y-%m");?>
 - <?php if ($_smarty_tpl->tpl_vars['work_l']->value['edate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['work_l']->value['edate'],"%Y-%m");
} else { ?>至今<?php }?></div>
            <div><?php echo $_smarty_tpl->tpl_vars['work_l']->value['content'];?>
</div>
            <div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume('work','<?php echo $_smarty_tpl->tpl_vars['work_l']->value['id'];?>
')" class="admin_save_sub1">【修改】</a> <a href="javascript:void(0)" onclick="resume_del('work','<?php echo $_smarty_tpl->tpl_vars['work_l']->value['id'];?>
')" class="admin_save_sub2">【删除】</a> </div>
          </div>
          <?php } ?>
          <?php }?> 
		  </div></td>
    </tr>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr id='work_add_button'>
      <td colspan="5" align="center"><input class="admin_save_sub" type="button" value="添加工作经历" onclick="checkmore2('work');"name="com_update" ></td>
    </tr>
  </table>
</div>
<div id='addwork' style="display:none">
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr  >
      <th width="120">单位名称：</th>
      <td   colspan="4" ><input type="text" name="work_name" id="work_name" class="input-text"   size='40'></td>
    </tr>
    <tr  >
      <th>工作时间：</th>
      <td colspan='3'><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/css/font-awesome.min.css" type="text/css">
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/datepicker/foundation-datepicker.min.js"><?php echo '</script'; ?>
>
        <input class="input-text  text_resume_date " type="text" name="sdate" value="" size="15"  id="work_sdate"/>
        <em>到</em>
        <input class="input-text text_resume_date" type="text" name="edate" value="" size="15"  id="work_edate">
        时间格式：2014-07 
        <?php echo '<script'; ?>
 type="text/javascript">
			   $('#work_sdate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3});
			   $('#work_edate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3}); 
        <?php echo '</script'; ?>
></td>
    </tr>
    <tr >
      <th>担任职位：</th>
      <td colspan='3'><input type="text" name="title" id="work_title" class="input-text"  ></td>
    </tr>
    <tr >
      <th>工作内容：</th>
      <td colspan='3'><textarea id="work_content" class="expect_text_textarea " ></textarea></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="hidden" id="workid" />
        <input class="admin_save_sub" type="button" value=" 添 加 " name="submit" onclick="savework();" >
        <input class="admin_save_sub_qx" type="button" value=" 取 消 " onclick="layerClose('work')" ></td>
    </tr>
  </table>
</div>
<div id='edu' >
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120"  bgcolor="#f5f5f5">教育经历：</th>
      <td   colspan='4'><div id="edu_list">
        <?php if ($_smarty_tpl->tpl_vars['edu']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['edu_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['edu_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['edu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['edu_l']->key => $_smarty_tpl->tpl_vars['edu_l']->value) {
$_smarty_tpl->tpl_vars['edu_l']->_loop = true;
?>
        <div class="admin_saversume_list" id="edu_<?php echo $_smarty_tpl->tpl_vars['edu_l']->value['id'];?>
">
          <div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['edu_l']->value['name'];?>
</span> 
          	<?php if ($_smarty_tpl->tpl_vars['edu_l']->value['title']) {?>班级职务： <span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['edu_l']->value['title'];?>
</span> <?php }?>
          </div>
          <div><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['edu_l']->value['sdate'],"%Y-%m");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['edu_l']->value['edate'],"%Y-%m");?>
</div>
          <div> <?php if ($_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['edu_l']->value['education']]) {?> 最高学历：<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['edu_l']->value['education']];
}?>
          		<?php if ($_smarty_tpl->tpl_vars['edu_l']->value['specialty']) {?>所学专业：<?php echo $_smarty_tpl->tpl_vars['edu_l']->value['specialty'];
}?>
          </div>
          <div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume('edu','<?php echo $_smarty_tpl->tpl_vars['edu_l']->value['id'];?>
')"class="admin_save_sub1">【修改】</a> <a href="javascript:void(0)" onclick="resume_del('edu','<?php echo $_smarty_tpl->tpl_vars['edu_l']->value['id'];?>
')" class="admin_save_sub2">【删除】</a> </div>
        </div>
        <?php } ?>
        <?php }?> </td>
    </tr>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr id='edu_add_button'>
      <td colspan="5" align="center"><input class="admin_save_sub" type="button" value="添加教育经历" onclick="checkmore2('edu');"name="com_update" ></td>
    </tr>
  </table>
</div>
<div id='addedu' style="display:none">
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr  >
      <th width="120">学校名称：</th>
      <td   colspan="4" ><input type="text" name="name" id="edu_name" class="input-text"   size='40'></td>
    </tr>
    <tr  >
      <th>在校时间：</th>
      <td colspan='3'><input class="input-text text_resume_date " type="text" name="sdate" value="" size="15"  id="edu_sdate"/>
        <em>到</em>
        <input class="input-text text_resume_date " type="text" name="edate" value="" size="15"  id="edu_edate">
        时间格式：2014-07 
        <?php echo '<script'; ?>
 type="text/javascript">
			$('#edu_sdate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3});
			$('#edu_edate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3});  
        <?php echo '</script'; ?>
></td>
    </tr>
    <tr class="admin_table_trbg">
      <th>最高学历：</th>
      <td colspan='3'><div class="yun_admin_select_box zindex100"> 
          <input type="button" value="请选择" class="yun_admin_select_box_text" id="user_education_name" onClick="select_click('user_education');">
          <input name="education" type="hidden" id="user_education_val" value="0">
          <div class="yun_admin_select_box_list_box dn" id="user_education_select"> 
		    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new('user_education','<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
')"><?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> </div>
            <?php } ?> </div>
        </div></td>
    </tr>
    <tr >
      <th>班级职务：</th>
      <td colspan='3'><input type="text" name="title" id="edu_title" class="input-text"  ></td>
    </tr>
    <tr >
      <th>所学专业：</th>
      <td colspan='3'><input type="text" name="specialty" id="edu_specialty" class="input-text"  ></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="hidden" id="eduid" />
        <input class="admin_save_sub" type="button" value=" 添 加 " name="submit" onclick="saveedu();" >
        <input class="admin_save_sub_qx" type="button" value=" 取 消 " onclick="layerClose('edu')" ></td>
    </tr>
  </table>
</div>
<div id='training' >
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120"  bgcolor="#f5f5f5">培训经历：</th>
      <td   colspan='4'><div id="training_list"> <?php if ($_smarty_tpl->tpl_vars['training']->value) {?>
          <?php  $_smarty_tpl->tpl_vars['training_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['training_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['training']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['training_l']->key => $_smarty_tpl->tpl_vars['training_l']->value) {
$_smarty_tpl->tpl_vars['training_l']->_loop = true;
?>
          <div class="admin_saversume_list" id="training_<?php echo $_smarty_tpl->tpl_vars['training_l']->value['id'];?>
">
            <div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['training_l']->value['name'];?>
</span> 
            	<?php if ($_smarty_tpl->tpl_vars['training_l']->value['title']) {?>培训方向： <span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['training_l']->value['title'];?>
</span><?php }?> 
            </div>
            <div><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['training_l']->value['sdate'],"%Y-%m");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['training_l']->value['edate'],"%Y-%m");?>
</div>
            <div><?php echo $_smarty_tpl->tpl_vars['training_l']->value['content'];?>
</div>
            <div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume('training','<?php echo $_smarty_tpl->tpl_vars['training_l']->value['id'];?>
')"class="admin_save_sub1">【修改】</a> <a href="javascript:void(0)" onclick="resume_del('training','<?php echo $_smarty_tpl->tpl_vars['training_l']->value['id'];?>
')" class="admin_save_sub2">【删除】</a> </div>
          </div>
          <?php } ?>
          <?php }?> </div></td>
    </tr>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr id='training_add_button'>
      <td colspan="5" align="center"><input class="admin_save_sub" type="button" value="添加培训经历" onclick="checkmore2('training');"name="com_update" ></td>
    </tr>
  </table>
</div>
<div id='addtraining' style="display:none">
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr  >
      <th width="120">培训中心：</th>
      <td   colspan="4" ><input type="text" name="name" id="training_name" class="input-text"   size='40'></td>
    </tr>
    <tr  >
      <th>培训时间：</th>
      <td colspan='3'><input class="input-text text_resume_date " type="text" name="sdate" value="" size="15"  id="training_sdate"/>
        <em>到</em>
        <input class="input-text text_resume_date " type="text" name="edate" value="" size="15"  id="training_edate">
        时间格式：2014-07 
        <?php echo '<script'; ?>
 type="text/javascript">
			$('#training_sdate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3});
			$('#training_edate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3}); 
        <?php echo '</script'; ?>
></td>
    </tr>
    <tr >
      <th>培训方向：</th>
      <td colspan='3'><input type="text" name="title" id="training_title" class="input-text"  ></td>
    </tr>
    <tr >
      <th>培训描述：</th>
      <td colspan='3'><textarea id="training_content" class="expect_text_textarea "></textarea></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="hidden" id="trainingid" />
        <input class="admin_save_sub" type="button" value=" 添 加 " name="submit" onclick="savetraining();" >
        <input class="admin_save_sub_qx" type="button" value=" 取 消 " onclick="layerClose('training')" ></td>
    </tr>
  </table>
</div>
<div id='skill' >
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120"  bgcolor="#f5f5f5">职业技能：</th>
      <td   colspan='4'><div id="skill_list"> <?php if ($_smarty_tpl->tpl_vars['skill']->value) {?>
          <?php  $_smarty_tpl->tpl_vars['skill_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['skill_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['skill']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['skill_l']->key => $_smarty_tpl->tpl_vars['skill_l']->value) {
$_smarty_tpl->tpl_vars['skill_l']->_loop = true;
?>
          <div class="admin_saversume_list" id="skill_<?php echo $_smarty_tpl->tpl_vars['skill_l']->value['id'];?>
">
            <div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['skill_l']->value['name'];?>
</span> 掌握时间 <span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['skill_l']->value['longtime'];?>
年</span> </div>
            <div> <?php if ($_smarty_tpl->tpl_vars['skill_l']->value['pic']) {?>
              技能证书： <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['skill_l']->value['pic'];?>
" width="95" height="70"> <?php }?></div>
            <div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume('skill','<?php echo $_smarty_tpl->tpl_vars['skill_l']->value['id'];?>
')" class="admin_save_sub1">【修改】</a> <a href="javascript:void(0)" onclick="resume_del('skill','<?php echo $_smarty_tpl->tpl_vars['skill_l']->value['id'];?>
')"class="admin_save_sub2">【删除】</a> </div>
          </div>
          <?php } ?>
          <?php }?> </div></td>
    </tr>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr id='skill_add_button'>
      <td colspan="5" align="center"><input class="admin_save_sub" type="button" value="添加技能" onclick="checkmore2('skill');"name="com_update" ></td>
    </tr>
  </table>
</div>
<div id='addskill' style="display:none">
  <form method="post" action="index.php?m=admin_resume&c=skill" target="supportiframe" enctype="multipart/form-data" onsubmit="return checkskill()">
    <table width="100%" class="table_form_resume" style="background:#fff;">
      <tr>
        <th width="120">技能名称：</th>
        <td  colspan='4'><input type="text" name="name" id="skill_name" class="input-text" value="">
          例：英语、C语言、速记 </td>
      </tr>
      <tr>
        <th width="120">掌握时间：</th>
        <td colspan='4'><input type="text" name="longtime" id="skill_longtime" class="input-text" value="" size='5' onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
          年</td>
      </tr>
      <tr>
        <th>技能证书：</th>
        <td colspan='4'><input type="file" name="pic" id="skill_pic" class="input-text" value=""/></td>
      </tr>
      <tr>
        <td colspan="5" align="center"><input type="hidden" id="skillid" name="id"/>
          <input type="hidden" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
">
          <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
          <input type="hidden" name="eid" <?php if ($_smarty_tpl->tpl_vars['row']->value['id']) {?>value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"<?php }?>>
          <input class="admin_save_sub" type="submit" value=" 添 加 " name="submit" >
          <input type="button" class="admin_save_sub_qx"value=" 取 消 " onclick="layerClose('skill')" ></td>
      </tr>
    </table>
  </form>
</div>
<div id='project' >
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120"  bgcolor="#f5f5f5">项目经历：</th>
      <td   colspan='4'><div id="project_list"> <?php if ($_smarty_tpl->tpl_vars['project']->value) {?>
          <?php  $_smarty_tpl->tpl_vars['project_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['project']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project_l']->key => $_smarty_tpl->tpl_vars['project_l']->value) {
$_smarty_tpl->tpl_vars['project_l']->_loop = true;
?>
          <div class="admin_saversume_list" id="project_<?php echo $_smarty_tpl->tpl_vars['project_l']->value['id'];?>
">
            <div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['project_l']->value['name'];?>
</span> 
            	<?php if ($_smarty_tpl->tpl_vars['project_l']->value['title']) {?>担任职位 <span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['project_l']->value['title'];?>
</span><?php }?> 
            </div>
            <div><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['project_l']->value['sdate'],"%Y-%m");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['project_l']->value['edate'],"%Y-%m");?>
</div>
            <div><?php echo $_smarty_tpl->tpl_vars['project_l']->value['content'];?>
</div>
            <div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume('project','<?php echo $_smarty_tpl->tpl_vars['project_l']->value['id'];?>
')" class="admin_save_sub1">【修改】</a> <a href="javascript:void(0)" onclick="resume_del('project','<?php echo $_smarty_tpl->tpl_vars['project_l']->value['id'];?>
')" class="admin_save_sub2">【删除】</a> </div>
          </div>
          <?php } ?>
          <?php }?> </div></td>
    </tr>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr id='project_add_button'>
      <td colspan="4" align="center"><input class="admin_save_sub" type="button" value="添加项目经历" onclick="checkmore2('project');"name="com_update"></td>
    </tr>
  </table>
</div>
<div id='addproject' style="display:none">
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr  >
      <th width="120">项目名称：</th>
      <td   colspan="4" ><input type="text" name="project_name" id="project_name" class="input-text"   size='40'></td>
    </tr>
    <tr  >
      <th>项目时间：</th>
      <td colspan='3'><input class="input-text text_resume_date " type="text" name="sdate" value="" size="15"  id="project_sdate"/>
        <em>到</em>
        <input class="input-text text_resume_date " type="text" name="edate" value="" size="15"  id="project_edate">
        时间格式：2014-07 
        <?php echo '<script'; ?>
 type="text/javascript">
			$('#project_sdate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3});
			$('#project_edate').fdatepicker({format: 'yyyy-mm',startView:4,minView:3}); 
        <?php echo '</script'; ?>
></td>
    </tr>
    <tr >
      <th>担任职位：</th>
      <td colspan='3'><input type="text" name="title" id="project_title" class="input-text"  ></td>
    </tr>
    <tr >
      <th>项目内容：</th>
      <td colspan='3'><textarea id="project_content" class="expect_text_textarea " ></textarea></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="hidden" id="projectid" />
        <input class="admin_save_sub" type="button" value=" 添 加 " name="submit" onclick="saveproject();" >
        <input class="admin_save_sub_qx" type="button" value=" 取 消 " onclick="layerClose('project')" ></td>
    </tr>
  </table>
</div>
<div id='other' >
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr>
      <th width="120"  bgcolor="#f5f5f5">其他：</th>
      <td   colspan='4'><div id="other_list"> <?php if ($_smarty_tpl->tpl_vars['other']->value) {?>
          <?php  $_smarty_tpl->tpl_vars['other_l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['other_l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['other']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['other_l']->key => $_smarty_tpl->tpl_vars['other_l']->value) {
$_smarty_tpl->tpl_vars['other_l']->_loop = true;
?>
          <div class="admin_saversume_list"  id="other_<?php echo $_smarty_tpl->tpl_vars['other_l']->value['id'];?>
">
            <div class="admin_saversume_tit"><span class="admin_saversume_tit_b"><?php echo $_smarty_tpl->tpl_vars['other_l']->value['name'];?>
</span></div>
            <div><?php echo $_smarty_tpl->tpl_vars['other_l']->value['content'];?>
</div>
            <div class="admin_saversume_cz"> <a href="javascript:void(0)" onclick="getresume('other','<?php echo $_smarty_tpl->tpl_vars['other_l']->value['id'];?>
')" class="admin_save_sub1">【修改】</a> <a href="javascript:void(0)" onclick="resume_del('other','<?php echo $_smarty_tpl->tpl_vars['other_l']->value['id'];?>
')"class="admin_save_sub2">【删除】</a> </div>
          </div>
          <?php } ?>
          <?php }?> </div></td>
  </table>
  <table width="100%" class="table_form_resume" style="background:#fff;">
    <tr id='other_add_button'>
      <td colspan="5" align="center"><input class="admin_save_sub" type="button" value="添加其他" onclick="checkmore2('other');"name="com_update" ></td>
    </tr>
  </table>
</div>
<div id='addother' style="display:none">
  <table width="100%" class=" table_form_resume" style="background:#fff;">
    <tr  >
      <th width="120">其他标题：</th>
      <td   colspan="4" ><input type="text" name="name" id="other_name" class="input-text"   size='40'></td>
    </tr>
    <tr >
      <th>其他描述：</th>
      <td colspan='3'><textarea id="other_content" class="expect_text_textarea "></textarea></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="hidden" id="otherid" />
        <input class="admin_save_sub" type="button" value=" 添 加 " name="submit" onclick="saveother();" >
        <input class=" admin_save_sub_qx" type="button" value=" 取 消 " onclick="layerClose('other')" ></td>
    </tr>
  </table>
</div>
</div>
</div>
<div style="margin-top:30px"></div>
</body>
</html><?php }} ?>
