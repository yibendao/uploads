<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:19:29
         compiled from "D:\phpStudy\WWW\uploads\app\template\resume\resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:174759cbb37160d918-47914889%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d0cf997bac3e1685ac57557f5cc75dbb38e7a9e' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\resume\\resume.htm',
      1 => 1492764176,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '174759cbb37160d918-47914889',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'resumestyle' => 0,
    'config' => 0,
    'Info' => 0,
    'UserMember' => 0,
    'key' => 0,
    'v' => 0,
    'one' => 0,
    'talent_pool' => 0,
    'usertype' => 0,
    'usermsgnum' => 0,
    'uid' => 0,
    'jobnum' => 0,
    'style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb371d26448_63764694',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb371d26448_63764694')) {function content_59cbb371d26448_63764694($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_image')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.image.php';
?><!DOCtYPE html PUBLIC "-//W3C//DtD XHtML 1.0 transitional//EN" "http://www.w3.org/tR/xhtml1/DtD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name=keywords content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"/>
<meta name=description content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
"/>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['resumestyle']->value;?>
/css/new_resume.css" type="text/css"/>
</head>
<body class="resume_bg_c">
<div class="yun_resume_content"> 
  <?php if ($_GET['see']!='member'&&$_GET['see']!='userd') {?>
  
  <div class="yun_resume_header">
    <div class="yun_resume_logo"> <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_logo'];?>
" class="png" style=" border:none;"></a> </div>
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
      <div class="yun_resume_name"><?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {
echo $_smarty_tpl->tpl_vars['Info']->value['name'];
} else {
echo $_smarty_tpl->tpl_vars['Info']->value['username_n'];
}?>  
	  <?php if ($_smarty_tpl->tpl_vars['UserMember']->value['source']==6&&$_smarty_tpl->tpl_vars['UserMember']->value['claim']==0&&$_smarty_tpl->tpl_vars['UserMember']->value['email']!='') {?>
	  <a class="myresume_rl " href="javascript:void(0);" onClick="claim('<?php echo smarty_function_url(array('m'=>'ajax','c'=>'claim','uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid']),$_smarty_tpl);?>
')">认领</a>
	  <?php }?>
 </div>
      <div class="yun_resume_p"><?php echo $_smarty_tpl->tpl_vars['Info']->value['sex'];?>
<span class="yun_resume_info_line">|</span><?php if ($_smarty_tpl->tpl_vars['Info']->value['age']) {
echo $_smarty_tpl->tpl_vars['Info']->value['age'];?>
岁<span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['Info']->value['living']) {
echo $_smarty_tpl->tpl_vars['Info']->value['living'];?>
 <span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['Info']->value['useredu']) {
echo $_smarty_tpl->tpl_vars['Info']->value['useredu'];?>
学历<span class="yun_resume_info_line">|</span><?php }
if ($_smarty_tpl->tpl_vars['Info']->value['exp']) {
echo $_smarty_tpl->tpl_vars['Info']->value['user_exp'];?>
经验<?php }?></div>
 <div class="yun_resume_tel">
 <?php if ($_smarty_tpl->tpl_vars['Info']->value['basic_info']=='1') {?>
<div class="one_vita_Basic_info_c">
<?php if ($_smarty_tpl->tpl_vars['Info']->value['user_marriage']) {?><span class="one_vita_Identity"><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_marriage'];?>
</span>  
<span class="yun_resume_info_line">|</span><?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['domicile']) {?><span class="one_vita_Identity">户籍：<?php echo $_smarty_tpl->tpl_vars['Info']->value['domicile'];?>
 </span>  <span class="yun_resume_info_line">|</span><?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']||$_smarty_tpl->tpl_vars['Info']->value['height']) {?><span class="one_vita_Identity">
<?php if ($_smarty_tpl->tpl_vars['Info']->value['height']) {
echo $_smarty_tpl->tpl_vars['Info']->value['height'];?>
cm<?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']&&$_smarty_tpl->tpl_vars['Info']->value['height']) {?>/<?php }?>
<?php if ($_smarty_tpl->tpl_vars['Info']->value['weight']) {?> <?php echo $_smarty_tpl->tpl_vars['Info']->value['weight'];?>
kg<?php }?> </span> <span class="yun_resume_info_line">|</span>
<?php }?>    
<?php if ($_smarty_tpl->tpl_vars['Info']->value['nationality']) {?> <span class="one_vita_Identity"><?php echo $_smarty_tpl->tpl_vars['Info']->value['nationality'];?>
</span><?php }?>   
</div>
<?php }?>

</div>
<div class="yun_resume_photo_bg"></div>
      <div class="yun_resume_photo"><img src="<?php echo $_smarty_tpl->tpl_vars['Info']->value['resume_photo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_member_icon'];?>
',2);" width="80" height="100"> </div>
    </div>
    
    
    <div class="yun_resume_job_intention">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconyx"></i>求职意向</span></div>
      <ul class="yun_resume_job_intention_list ">
                <li class="yun_resume_job_intention_list_end">期望从事职位：
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Info']->value['expectjob']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<?php if ($_smarty_tpl->tpl_vars['key']->value<5) {?>
				<span class="resume_job_tag"><i class="resume_job_tag_icon"></i><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
				<?php }?>
				<?php } ?>
				</li>
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

      </ul>
    </div>
    <?php if (is_array($_smarty_tpl->tpl_vars['Info']->value['user_work'])&&!empty($_smarty_tpl->tpl_vars['Info']->value['user_work'])) {?>
    
    <div class="yun_resume_joblist">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconjl"></i>工作经历</span>
      <span class="yun_resume_jobtime">平均工作时长：<?php echo $_smarty_tpl->tpl_vars['Info']->value['avghourInfo'];?>
</span></div>
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
<span class="yun_resume_exp_name_job"><?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</span></div>
            <?php if ($_smarty_tpl->tpl_vars['one']->value['education_n']||$_smarty_tpl->tpl_vars['one']->value['specialty']) {?><div class="yun_resume_exp_p"><?php echo $_smarty_tpl->tpl_vars['one']->value['education_n'];?>
学历 <span class="yun_resume_exp_name_zy"><?php echo $_smarty_tpl->tpl_vars['one']->value['specialty'];?>
专业</span></div><?php }?>
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
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {?>
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
        <div class="">技能证书：<img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['one']->value['pic'];?>
" width="95" height="70"></div> 
        <?php }?>
        </li>
      <?php } ?>
      </ul>
    </div>
    <?php }?>
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
    <div class="resume_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系手机：<?php echo smarty_function_image(array('number'=>$_smarty_tpl->tpl_vars['Info']->value['telphone'],'uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid'],'action'=>'telphone','width'=>200),$_smarty_tpl);?>
</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['telhome']) {?>
    <div class="resume_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系座机：<?php echo smarty_function_image(array('number'=>$_smarty_tpl->tpl_vars['Info']->value['telhome'],'uid'=>$_smarty_tpl->tpl_vars['Info']->value['uid'],'action'=>'telhome','width'=>200),$_smarty_tpl);?>
 </div>        
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['Info']->value['email']) {?>
    <div class="resume_Intention "><i class="one_vita_Intention_i one_vita_red"></i>电子邮箱：<?php echo $_smarty_tpl->tpl_vars['Info']->value['email'];?>
 </div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['Info']->value['homepage']) {?>

    <div class="resume_Intention"><i class="one_vita_Intention_i one_vita_red"></i>个人主页：<?php echo $_smarty_tpl->tpl_vars['Info']->value['homepage'];?>
</div>
	<?php }?>
    <?php if ($_smarty_tpl->tpl_vars['Info']->value['qq']) {?>
	<div class="resume_Intention"><i class="one_vita_Intention_i one_vita_red"></i>联系Q Q：<?php echo $_smarty_tpl->tpl_vars['Info']->value['qq'];?>
</div>
   <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['address']) {?>
    <div class="resume_Intention "><i class="one_vita_Intention_i one_vita_red"></i>详细地址：<?php echo mb_substr($_smarty_tpl->tpl_vars['Info']->value['address'],0,16,'gbk');?>
</div>
	<?php }?>
    

    <?php if ($_smarty_tpl->tpl_vars['Info']->value['idcard']) {?><div class="one_vita_Intention "><i class="one_vita_Intention_i one_vita_red"></i><span>身份证号：</span>
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

	 
	<?php if ($_smarty_tpl->tpl_vars['Info']->value['user_jy']['annex']) {?>
    <div class="yun_resume_joblist yun_resume_joblist_mt20">
      <div class="yun_resume_h1"><span class="yun_resume_h1_s"><i class="yun_resume_h1_icon yun_resume_h1_iconfj"></i>简历附件</span></div>
       
   <div class="re_touch fl"><?php if ($_smarty_tpl->tpl_vars['Info']->value['m_status']=="1") {?><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];
echo $_smarty_tpl->tpl_vars['Info']->value['user_jy']['annex'];?>
"><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_jy']['annexname'];?>
</a><?php } else { ?><a ><?php echo $_smarty_tpl->tpl_vars['Info']->value['user_jy']['annexname'];?>
</a>(请先下载简历！)<?php }?></div> 
    </div>
	<?php }?>
  </div>

</div>
 
<?php if ($_GET['see']!='member'&&$_GET['see']!='used') {?>
<div class="yun_resume_operation" id="operation_box">
  <div class="yun_resume_operation_box"> 
  <div class="yun_resume_operation_box_h1">操作区</div>
  <?php if (is_array($_smarty_tpl->tpl_vars['talent_pool']->value)) {?>
    <div class="vita_Opera_cz_list">
    <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_sc"></i>
      <input class="vita_btn_1 yun_resume_cz_sub yun_resume_cz_sub_cor"type="button" onClick="layer.msg('该简历已加入到人才库！',2,8);" value="已收藏简历">
      
    </div>
    <?php } else { ?>
    <div class="vita_Opera_cz_list">
        <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_sc"></i>
      <input class="vita_btn_1 yun_resume_cz_sub" type="button" onClick="add_user_talent('<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['usertype']->value;?>
')" value="收藏简历">
    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['usertype']->value==2) {?>
    <?php if ($_smarty_tpl->tpl_vars['usermsgnum']->value) {?>
    <div class="vita_Opera_cz_list">
        <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_yq"></i>
      <input class="vita_btn_1 yun_resume_cz_sub yun_resume_cz_sub_cor" type="button" onClick="layer.msg('该简历已邀请面试！',2,8);" value="已邀请面试">
    </div>
    <?php } else { ?>
    <div class="vita_Opera_cz_list">
       <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_yq"></i>
      <input class="vita_btn_1 sq_resume yun_resume_cz_sub" type="button" value="邀请面试 " name="submit" username="<?php echo $_smarty_tpl->tpl_vars['Info']->value['name'];?>
" eid="" uid="<?php echo $_smarty_tpl->tpl_vars['Info']->value['uid'];?>
">
    </div>
    <?php }?>
    <?php } else { ?>
    <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
    <div class="vita_Opera_cz_list">
        <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_yq"></i>
      <input class="vita_btn_1 yun_resume_cz_sub" onClick="layer.msg('只有企业用户，才可以邀请！',2,8);" type="button" value="邀请面试 ">
    </div>
    <?php } else { ?>
    <div class="vita_Opera_cz_list">
            <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_yq"></i>
      <input class="vita_btn_1 yun_resume_cz_sub" onClick="showlogin('2');" type="button" value="邀请面试 ">
    </div>
    <?php }?>
    <?php }?>
   <div class="vita_Opera_cz_list">
    <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_xz"></i>
  <?php if ($_smarty_tpl->tpl_vars['uid']->value==$_smarty_tpl->tpl_vars['Info']->value['uid']) {?>
  <input class="vita_btn_1 yun_resume_cz_sub" onClick="for_link('<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'for_link'),$_smarty_tpl);?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'resume_word','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
');" type="button" name="submit" value="下载简历 ">
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['usertype']->value==2||$_smarty_tpl->tpl_vars['uid']->value==$_smarty_tpl->tpl_vars['Info']->value['uid']) {?>
  <?php if ($_smarty_tpl->tpl_vars['jobnum']->value) {?>
  <?php if ($_smarty_tpl->tpl_vars['Info']->value['downresume']==1) {?>
      <a href="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'resume_word','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" class="vita_btn_1 yun_resume_cz_sub">下载简历</a>
      <?php } else { ?>
        <input class="vita_btn_1 yun_resume_cz_sub" onClick="for_link('<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'for_link'),$_smarty_tpl);?>
','<?php echo smarty_function_url(array('m'=>'ajax','c'=>'resume_word','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
');" type="button" name="submit" value="下载简历 ">
        <?php }?>
    <?php } else { ?>
       <input class="vita_btn_1 yun_resume_cz_sub" onClick="addjob();" type="button" name="submit" value="下载简历 ">             
    <?php }?>
    <?php } else { ?>
   	 <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
       <input class="vita_btn_1 yun_resume_cz_sub" onClick="layer.msg('只有企业用户，才可以下载！',2,8);" type="button" name="submit" value="下载简历 ">
       <?php } else { ?>
       <input class="vita_btn_1 yun_resume_cz_sub" onClick="showlogin('2');" type="button" name="submit" value="下载简历 ">
       <?php }?>
    <?php }?>
    </div>
    <div class="vita_Opera_cz_list">
        <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_dy"></i>
      <input class="vita_btn_1 vita_red yun_resume_cz_sub" type="button" onClick="dayin()" value="打印简历 " name="button">
    </div>
    <div class="vita_Opera_cz_list">
        <i class="vita_Opera_cz_list_icon vita_Opera_cz_list_icon_fx"></i>
      <input class="vita_btn_1 vita_red yun_resume_cz_sub" type="button" onClick="javascript:window.location.href='<?php echo smarty_function_url(array('m'=>'resume','c'=>'resumeshare','id'=>'`$Info.id`'),$_smarty_tpl);?>
'" value="分享简历" name="submit">
    </div>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['Info']->value['id'];?>
" id="eid">
     
  </div>
  
</div>

<div id='for_link'  class="none"  style="float:left;width:350px">
	<div class="city_1" style="padding-top:5px;"></div>
	<div class="btn" style="float: left; padding-bottom: 20px; padding-top: 10px; width: 100%; text-align: center;">  
       <a href="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'resume_word','id'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
" class="resume_bthxz">下载简历</a>
	</div>
    
</div>
<?php }?> 

<?php if ($_GET['see']=='member') {?> 


<div class="expext_yl_box_bth"><a href="javascript:;" onClick="settemplate('确定使用该模版？', '<?php echo smarty_function_url(array('m'=>'ajax','c'=>'settpl','id'=>2,'eid'=>$_smarty_tpl->tpl_vars['Info']->value['id']),$_smarty_tpl);?>
');" class="expext_yl_box_sub">使用该模板</a></div>
<?php }?> 

<div id="bg"></div>
<a name="resume"></a> 
<div class="clear"></div>
<?php if ($_GET['see']!='member'&&$_GET['see']!='userd') {?>
<div class="yun_resume_foot"><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</a> &copy; 版权所有 <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
  本网招聘及简历信息等 ,未经书面授权不得转载 <br />
<div id="uclogin" class="none"></div>
</div>
<?php }?>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/resume.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jscolor/jscolor.js"><?php echo '</script'; ?>
>
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
var integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
'; 
var weburl="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
var downurl="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'down_resume'),$_smarty_tpl);?>
";
$(function(){
	$("a.image_gall").popImage();
})
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
<?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png,.yun_resume_photo_bg,.yun_resume_h1_icon,.yun_resume_jobtime,.vita_Opera_cz_list_icon');
<?php echo '</script'; ?>
>
<![endif]-->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/resume_include.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html><?php }} ?>
