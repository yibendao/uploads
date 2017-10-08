<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 16:27:35
         compiled from "D:\phpStudy\WWW\uploads\app\template\resume\resume_share.htm" */ ?>
<?php /*%%SmartyHeaderCode:872759ce03f7526112-68561683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea1dcdd34e3177f33a7b70bf864745633c3d655c' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\resume\\resume_share.htm',
      1 => 1492523048,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '872759ce03f7526112-68561683',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'style' => 0,
    'config' => 0,
    'id' => 0,
    'Info' => 0,
    'UserMember' => 0,
    'one' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce03f78b4a45_53010526',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce03f78b4a45_53010526')) {function content_59ce03f78b4a45_53010526($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_image')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.image.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"/>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/template/resume/css/new_resume.css" type="text/css"/>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png');
<?php echo '</script'; ?>
>
<![endif]--> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/lazyload.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/resume.js" language="javascript"><?php echo '</script'; ?>
>
<style>
#contentDiv ul li {list-style:none;}
.td_title1 {color: #fff;}
.td04 {COLOR: #00659c;TEXT-INDENT: 0px}
.mail{ padding-top:20px; margin-bottom:20px;}
.mail li{width:100%;height:40px; line-height:40px; float:left; margin-top:10px;color:#666}
.mail li span{width:160px; line-height:35px; text-align:right; display:block; float:left;color:#666}
.zhiw1{width:680px; background:#e0f0ff;border:1px solid #aad8f0; margin-top:10px; margin-bottom:10px;font-size:12px;}
.zhiw{width:680px; background:#e0f0ff;border:1px solid #aad8f0; margin-top:10px; margin-bottom:10px;font-size:12px; float:left; list-style:none;}
.zhiw li{width:300px; line-height:26px; float:left; margin-left:20px;_margin-left:10px; list-style:none;}
.resume_text{border:1px solid #ccc;height:35px; line-height:35px;}
.image_gall{ margin-right:10px;}
.resume_table_td_p{ line-height:25px;}
.send_yun_bth_jl{width:160px;height:40px; background:#f60;color:#fff; font-size:14px; font-weight:bold;border:none; cursor:pointer}
</style>
</head>
<body style="background:#f8f8f8">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
 type="text/javascript">
function sendjob(img){
	var femail = $("#femail").val();
	var myemail = $("#myemail").val();
	var authcode = $("#authcode").val();
	var html =  $("#html").html();
	var id = "<?php echo $_GET['id'];?>
";

	if(femail=="" || myemail=="" || authcode==""){ 
		layer.msg('请完整填写信息！', 2, 8);return false; 
	}
	layer.load('执行中，请稍候...',0);
	$.post("<?php echo smarty_function_url(array('m'=>'resume','c'=>'resumeshare'),$_smarty_tpl);?>
",{femail:femail,myemail:myemail,authcode:authcode,id:id},function(data){
		layer.closeAll();
		checkCode(img);
		if(data==1){ 
			layer.msg('邮件发送成功！', 2, 9,function(){location.reload();});return false; 
		}else if(data==""){ 
			layer.msg('未知错误，请联系管理员！', 2, 8);
		}else{ 
			layer.msg(data, 2, 8);
		}
		return false; 
	});
}
<?php echo '</script'; ?>
>
<div class="clear"></div>
  <div style="width:1200px;  margin:20px auto; padding-bottom:10px;">

<div style="width:1200px;font-size:14px; margin-bottom:10px; background:#fff;">
<div style="line-height:40px; line-height:40px;color:#fff; text-indent:10px; background:#2c81d6; font-size:16px; font-family:'microsoft yahei';"><font color="#FFf">★ </font><strong class="td_title1">推荐简历给好友:</strong> </div>
      <ul class="mail" style="width:100%; margin-bottom:10px; float:left;background:#fff; padding-bottom:20px;">
        <li><span><font color="red">*</font> 朋友的E-mail：</span>
          <input type="text" id="femail" value="" name="femail" class="resume_text" style="width:230px;"/>
        </li>
        <li><span><font color="red">*</font> 朋友对您的昵称：</span>
          <input type="text" id="myemail"  value="" name="myemail" class="resume_text"/>
          让朋友知道是您推荐的简历，与其他垃圾邮件推广简历区分</li>
        <li><span><font color="red">*</font> 验证码：</span>
          <input id="authcode" type="text" tabindex="3"  class="resume_text" style="width:90px; float:left; margin-right:5px;" maxlength="4" name="authcode"/>
          <img id="vcode_img" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" />&nbsp;<a href="javascript:void(0);" onclick="checkCode('vcode_img');">看不清?</a> </li>
        <li> <span>&nbsp;</span>
          <input type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id" />
          <input type="button" onClick="sendjob('vcode_img');" value="发送" class="send_yun_bth_jl"  />
        </li>
      </ul>
    </div>

<div style="clear:both"></div>
<div class="user_resume_bg" style="width:1200px;">
 <div class="yun_resume_content"> 
  <?php if ($_GET['see']!='member'&&$_GET['see']!='userd') {?>
  <!--header-->
  <div class="yun_resume_header">
    <div class="yun_resume_logo"> <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
" class="png" style=" border:none;"/></a> </div>
    <div class="yun_resume_logo_zt"> 编号：<span class="yun_resume_logo_zt_n"><?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
</span> <em class="yun_resume_logo_zt_list"> 简历更新：<span class="yun_resume_logo_zt_n"><?php echo $_smarty_tpl->tpl_vars['Info']->value['lastupdate'];?>
 </span> </em> 浏览：<span class="yun_resume_logo_zt_n"><?php echo '<script'; ?>
 language="javascript" src="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','a'=>'GetHits','id'=>'`$Info.id`'),$_smarty_tpl);?>
"><?php echo '</script'; ?>
>次 </span> </div>
  </div>

  <?php }?>

  <div class="yun_resume_box"> 
 
    <div class="yun_resume_info">
      <div class="yun_resume_name"><?php echo $_smarty_tpl->tpl_vars['Info']->value['username_n'];?>
  <?php if ($_smarty_tpl->tpl_vars['UserMember']->value['source']==6&&$_smarty_tpl->tpl_vars['UserMember']->value['claim']==0&&$_smarty_tpl->tpl_vars['UserMember']->value['email']!='') {?>
<a class="myresume_rl " href="javascript:void(0);" onClick="claim('<?php echo smarty_function_url(array('m'=>'ajax','c'=>'claim','uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid']),$_smarty_tpl);?>
')">认领</a>
<?php }?>
 </div>
      <div class="yun_resume_p">
      
      <?php echo $_smarty_tpl->tpl_vars['Info']->value['sex'];?>
<span class="yun_resume_info_line">|</span>
      
      <?php if ($_smarty_tpl->tpl_vars['Info']->value['age']) {
echo $_smarty_tpl->tpl_vars['Info']->value['age'];?>
岁<span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['Info']->value['living']) {
echo $_smarty_tpl->tpl_vars['Info']->value['living'];?>
 <span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['Info']->value['useredu']) {
echo $_smarty_tpl->tpl_vars['Info']->value['useredu'];?>
学历<span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['Info']->value['user_exp']) {
echo $_smarty_tpl->tpl_vars['Info']->value['user_exp'];?>
经验<?php }?></div>
 <div class="yun_resume_tel">
 <?php if ($_smarty_tpl->tpl_vars['Info']->value['basic_info']=='1') {?>
<div class="one_vita_Basic_info_c">
<?php if ($_smarty_tpl->tpl_vars['Info']->value['user_marriage']) {?><span class="one_vita_Identity"><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_marriage'];?>
</span>  
 <span class="yun_resume_info_line">|</span><?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['domicile']) {?><span class="one_vita_Identity">户籍：<?php echo $_smarty_tpl->tpl_vars['Info']->value['domicile'];?>
 </span>  
 <span class="yun_resume_info_line">|</span><?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']||$_smarty_tpl->tpl_vars['Info']->value['height']) {?><span class="one_vita_Identity"><?php if ($_smarty_tpl->tpl_vars['Info']->value['height']) {
echo $_smarty_tpl->tpl_vars['Info']->value['height'];?>
CM<?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']&&$_smarty_tpl->tpl_vars['Info']->value['height']) {?>/<?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']) {?> <?php echo $_smarty_tpl->tpl_vars['Info']->value['weight'];?>
KG<?php }?> </span> 
 <span class="yun_resume_info_line">|</span><?php }?>    
<?php if ($_smarty_tpl->tpl_vars['Info']->value['nationality']) {?><span class="one_vita_Identity"><?php echo $_smarty_tpl->tpl_vars['Info']->value['nationality'];?>
</span><?php }?>   
</div>
<?php }?>

</div>
      <div class="yun_resume_photo"><img src="<?php echo $_smarty_tpl->tpl_vars['Info']->value['resume_photo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" width="80" height="100"> </div>
    </div>
    
  
    <div class="yun_resume_job_intention">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconyx"></i>求职意向</span></div>
      <ul class="yun_resume_job_intention_list ">
        <li>期望从事行业：<?php echo $_smarty_tpl->tpl_vars['Info']->value['hy'];?>
</li>
        <li>工作地点：<?php echo $_smarty_tpl->tpl_vars['Info']->value['city_one'];?>
 <?php echo $_smarty_tpl->tpl_vars['Info']->value['city_two'];?>
 <?php echo $_smarty_tpl->tpl_vars['Info']->value['city_three'];?>
</li>
        <li>期望薪资：<?php if ($_smarty_tpl->tpl_vars['Info']->value['maxsalary']&&$_smarty_tpl->tpl_vars['Info']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['Info']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['Info']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['Info']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['Info']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?></li>
        <li>到岗时间：<?php echo $_smarty_tpl->tpl_vars['Info']->value['report'];?>
</li>
        <li>求职状态：<?php echo $_smarty_tpl->tpl_vars['Info']->value['jobstatus'];?>
</li>
        <li>期望工作性质：<?php echo $_smarty_tpl->tpl_vars['Info']->value['type'];?>
</li>
        <li class="yun_resume_job_intention_list_end">期望从事职位：<?php echo $_smarty_tpl->tpl_vars['Info']->value['jobname'];?>
</li>
      </ul>
    </div>
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_work'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_work'])) {?>
  
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjl"></i>工作经历</span></div>
      <ul class="yun_resume_tabulation">
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_work']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
        <li class="yun_resume_exp_list">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y.%m");?>
-<?php if ($_smarty_tpl->tpl_vars['one']->value['edate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y.%m");
} else { ?>至今<?php }?></div>
          <div class="yun_resume_exp_r">
            <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</span></div>
            <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
</div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <?php }?>
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_edu'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_edu'])) {?>
    <!--教育经历-->
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjy"></i>教育经历</span></div>
      <ul class="">
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
        <li class="yun_resume_exp_list ">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y.%m");?>
-<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y.%m");?>
</div>
          <div class="yun_resume_exp_r">
            <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['one']->value['specialty'];?>
</span></div>
            <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['one']->value['education_n'];?>
学历</div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <?php }?>
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_tra'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_tra'])) {?>
    
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconpx"></i>培训经历</span></div>
      <ul class="">
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_tra']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
        <li class="yun_resume_exp_list  ">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y.%m");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y.%m");?>
 </div>
          <div class="yun_resume_exp_r ">
            <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</span></div>
            <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
 </div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <?php }?>
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_skill'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_skill'])) {?>
    
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjn"></i>职业技能</span></div>
      <ul class="resume_skill">
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_skill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
        <li class=""> <i class="resume_skill_icon"></i>   <div  class=" "> 技能名称：<span class="resume_table_blod"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</span> <span class="yun_resume_exp_name_job">掌握时间：<?php echo $_smarty_tpl->tpl_vars['one']->value['longtime'];?>
年</span></div>
        <?php if ($_smarty_tpl->tpl_vars['one']->value['pic']) {?>
        <div class=" ">技能证书：<img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['one']->value['pic'];?>
"  width="95" height="70" ></div> 
        <?php }?>
        </li>
      <?php } ?>
      </ul>
    </div>
    <?php }?>
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_xm'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_xm'])) {?>
    
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconxm"></i>项目经验</span></div>
      <ul class="">
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_xm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
        <li class="yun_resume_exp_list ">
          <div class="yun_resume_exp_timt"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['sdate'],"%Y.%m");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['one']->value['edate'],"%Y.%m");?>
</div>
          <div class="yun_resume_exp_r">
            <div class="yun_resume_exp_name"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</span></div>
            <div class="yun_resume_exp_p"> <?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
 </div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <?php }?>
                 
       <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_show'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_show'])) {?>
       <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconry"></i>我的作品</span></div>
      

        
            <div class="fairs_introduction_p" >
        <ul class="fairs_introduction_img" id="rolling_img1">
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_show']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <li>
                <a class="image_gall" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['picurl'];?>
">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['picurl'];?>
" width="210" height="153" />
                </a>
            </li>
		<?php } ?>
        </ul>
    </div>
    
    
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/popImage/jquery.popImage.mini.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/ScrollPic.js" language="javascript"><?php echo '</script'; ?>
>
 <?php echo '<script'; ?>
>
<!--//--><![CDATA[//><!--

var li_num=$("#rolling_img1 li").length;
if(li_num>3){//如果图片数量不足，就不执行切换
	var scrollPic_02 = new ScrollPic();
	scrollPic_02.scrollContId   = "rolling_img1"; //内容容器ID
	scrollPic_02.arrLeftId      = "LeftArr";//左箭头ID
	scrollPic_02.arrRightId     = "RightArr"; //右箭头ID
	scrollPic_02.frameWidth     = 680;//显示框宽度
	scrollPic_02.pageWidth      = 231; //翻页宽度
	scrollPic_02.speed          = 10; //移动速度(单位毫秒，越小越快)
	scrollPic_02.space          = 10; //每次移动像素(单位px，越大越快)
	scrollPic_02.autoPlay       = true; //自动播放
	scrollPic_02.autoPlayTime   = 2; //自动播放间隔时间(秒)
	scrollPic_02.initialize(); //初始化
}
//--><!]]> 
$(function(){
	$("a.image_gall").popImage();
})
<?php echo '</script'; ?>
> 
        
</div>

            <?php }?> 
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_other'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_other'])) {?>
    
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconqt"></i>其他信息</span></div>
      <ul class="resume_skill">
      <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['user_other']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
        <li class=""> <i class="resume_skill_icon"></i>标题：<span class="resume_table_blod"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</span>
          <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['one']->value['content'];?>
</div>
        </li>
        <?php } ?> 
      </ul>
    </div>
    <?php }?> 
    <?php if (!empty($_smarty_tpl->tpl_vars['Info']->value['description'])) {?>
    
    <div class="yun_resume_joblist yun_resume_joblist_mt20">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconpj"></i>自我评价</span></div>
      <ul class="resume_skill">
        <li class=""><i class="resume_skill_icon"></i>
          <div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['Info']->value['description'];?>
</div>
        </li>
         <?php if ($_smarty_tpl->tpl_vars['Info']->value['arrayTag']) {?>
		 <li class=""><i class="resume_skill_icon"></i>
          <div class="yun_resume_exp_p">
		  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['arrayTag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
		  <span class="resume_user_bq"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
		  <?php } ?>          
		  </div>
        </li>
        <?php }?>
      </ul>
    </div>
    <?php }?>
     <?php if ($_smarty_tpl->tpl_vars['Info']->value['doc']) {?>
        
    <div class="yun_resume_joblist yun_resume_joblist_mt20">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconpj"></i>简历内容</span></div>
      
          <div class="yun_resume_zt_p"><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_doc']['doc'];?>
</div>
       
    </div>
       <?php }?>
   
        
    <div class="yun_resume_joblist yun_resume_joblist_mt20">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconlx"></i>联系方式</span></div>
      <?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {?>

	<?php if ($_smarty_tpl->tpl_vars['Info']->value['telphone']) {?>
    <div class="one_vita_Intention one_vita_Intention_w420"><i class="one_vita_Intention_i one_vita_red"></i>联系手机：<?php echo smarty_function_image(array('number'=>$_smarty_tpl->tpl_vars['Info']->value['telphone'],'uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid'],'action'=>'telphone','width'=>200),$_smarty_tpl);?>
</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['telhome']) {?>
    <div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系座机：<?php echo smarty_function_image(array('number'=>$_smarty_tpl->tpl_vars['Info']->value['telhome'],'uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid'],'action'=>'telhome','width'=>200),$_smarty_tpl);?>
 </div>        
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['Info']->value['email']) {?>
    <div class="one_vita_Intention one_vita_Intention_w420"><i class="one_vita_Intention_i one_vita_red"></i>电子邮箱：<?php echo $_smarty_tpl->tpl_vars['Info']->value['email'];?>
 </div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['Info']->value['homepage']) {?>
    <div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>个人主页：<?php echo $_smarty_tpl->tpl_vars['Info']->value['homepage'];?>
</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['qq']) {?>
	<div class="one_vita_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系Q Q：<?php echo $_smarty_tpl->tpl_vars['Info']->value['qq'];?>
</div>
  	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['address']) {?>
    <div class="one_vita_Intention one_vita_Intention_w420"><i class="one_vita_Intention_i one_vita_red"></i>详细地址：<?php echo $_smarty_tpl->tpl_vars['Info']->value['address'];?>
</div>
	<?php }?>
    

    <?php if ($_smarty_tpl->tpl_vars['Info']->value['idcard']) {?><div class="one_vita_Intention one_vita_Intention_w420"><i class="one_vita_Intention_i one_vita_red"></i><span>身份证号</span>
    <span class="one_vita_Identity">
    <?php echo smarty_function_image(array('uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid'],'action'=>'idcard','width'=>180),$_smarty_tpl);?>

    <?php if ($_smarty_tpl->tpl_vars['Info']->value['idcard_status']==1&&$_smarty_tpl->tpl_vars['Info']->value['idcard']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/template/resume/images/sfrz.png" title="身份已认证">已认证<?php }?>
    </span> </div>
    <?php }?> 
<?php if ($_smarty_tpl->tpl_vars['Info']->value['wxewm']) {?>
    <div class="two_vita_ewm_box"><img src=".<?php echo $_smarty_tpl->tpl_vars['Info']->value['wxewm'];?>
" width="120" height="120"><div class="two_vita_ewm_box_p">个人二维码</div></div>
    <?php }?>
   <?php } else { ?>
   <div class="re_touch"><?php echo $_smarty_tpl->tpl_vars['Info']->value['link_msg'];?>
</div>
   <?php }?>
    </div>
  </div>
  
</div>

</div></div>
<div style="clear:both;"></div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
