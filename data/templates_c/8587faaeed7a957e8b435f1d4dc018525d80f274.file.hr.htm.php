<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 16:33:46
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\hr.htm" */ ?>
<?php /*%%SmartyHeaderCode:3193059ce4a4d4d0758-21386342%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8587faaeed7a957e8b435f1d4dc018525d80f274' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\hr.htm',
      1 => 1506760339,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3193059ce4a4d4d0758-21386342',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce4a4d79ec73_32705640',
  'variables' => 
  array (
    'com_style' => 0,
    'current' => 0,
    'JobList' => 0,
    'one' => 0,
    'StateList' => 0,
    'now_url' => 0,
    'rows' => 0,
    'v' => 0,
    'pagenav' => 0,
    'jobnum' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce4a4d79ec73_32705640')) {function content_59ce4a4d79ec73_32705640($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<style>
</style>
<div class="w1000">
  <div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <link href="<?php echo $_smarty_tpl->tpl_vars['com_style']->value;?>
/images/index_style.css" type=text/css rel=stylesheet>
    <div class=right_box>
      <div class=admincont_box>
     <div class="job_list_tit">
         <ul class="">
         <li <?php if ($_GET['c']=="hr") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=hr"  title="ӦƸ����">ӦƸ����</a></li>
         <li <?php if ($_GET['c']=="down") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=down"  title="�������صļ�����¼">�����ؼ���</a></li>
         <li <?php if ($_GET['c']=="talent_pool") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=talent_pool"  title="�����˲ſ�ļ���">�ղؼ���</a></li>
         <li <?php if ($_GET['c']=="look_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=look_resume"  title="����������ļ�¼">�������</a></li>
         <li <?php if ($_GET['c']=="record") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=record" title="��վΪ���Ƽ��ļ���">��վ�Ƽ�����</a></li>
         <li <?php if ($_GET['c']=="my_create_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=my_create_resume" title="�Ҵ����ļ���">�Ҵ����ļ���</a></li>
         </ul>
         </div>
        <div class="com_body">
          <div class=admin_textbox_04>
          <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
          <div class="hr_tip_box">
           
            <div class="hr_subMetx"> <span class="hr_resumesearch_span fltL">��Ƹְλ��</span>
              <div class="text_seclet text_seclet_cur2 re">
                <input id="qypr" class="SpFormLBut text_seclet_w250" type="button" onclick="search_show('job_qypr');" <?php if ($_smarty_tpl->tpl_vars['current']->value['id']) {?>value="<?php echo $_smarty_tpl->tpl_vars['current']->value['name'];?>
"<?php } else { ?>value="ȫ��ְλ"<?php }?>>
                <div id="job_qypr" class="cus-sel-opt-panel " style="display: none;">
                  <ul class="Search_Condition_box_list">
                    <li><a href="index.php?c=hr&state=<?php echo $_GET['state'];?>
&resumetype=<?php echo $_GET['resumetype'];?>
&keyword=<?php echo $_GET['keyword'];?>
">ȫ��ְλ</a></li>
                    <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['JobList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
                    <li> <a href="index.php?c=hr&jobid=<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['one']->value['type'];?>
&state=<?php echo $_GET['state'];?>
&resumetype=<?php echo $_GET['resumetype'];?>
&keyword=<?php echo $_GET['keyword'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];
if ($_smarty_tpl->tpl_vars['one']->value['type']==2) {?>���ԣ�<?php }?></a> </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
               <form action="index.php" method="get" >
                <span class="hr_resumesearch_span fltL">�� �� �֣�</span>
                <div class="hr_subMetx_se">
                  <input name="c" type="hidden" value="hr">
                  <input name="resumetype" type="hidden" value="<?php echo $_GET['resumetype'];?>
">
                   <input name="jobid" type="hidden" value="<?php echo $_GET['jobid'];?>
">
                    <input name="state" type="hidden" value="<?php echo $_GET['state'];?>
">
                  <input name="keyword" type="text" class="hr_resumesearch_text" placeholder="��������������" value="<?php echo $_GET['keyword'];?>
">
                  <input type="submit"  class="hr_resumesearch_bth" value="����">
                </div>
              </form>
            </div>
            <div class="hr_subMetx"> <span class="hr_resumesearch_span fltL">����״̬��</span> <a href="index.php?c=hr&jobid=<?php echo $_GET['jobid'];?>
&resumetype=<?php echo $_GET['resumetype'];?>
&keyword=<?php echo $_GET['keyword'];?>
" class="hr_subMetx_a <?php if ($_GET['state']=='') {?>hr_subMetx_cur<?php }?>">����</a> <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['StateList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?> <a <?php if ($_GET['state']==$_smarty_tpl->tpl_vars['one']->value['id']) {?>class="hr_subMetx_cur"<?php }?> href="index.php?c=hr&jobid=<?php echo $_GET['jobid'];?>
&state=<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
&resumetype=<?php echo $_GET['resumetype'];?>
&keyword=<?php echo $_GET['keyword'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</a> <?php } ?> </div>
       
          </div>
          <div class="clear"></div>
          <form action="<?php echo $_smarty_tpl->tpl_vars['now_url']->value;?>
&act=hrset" target="supportiframe" method="post" id='myform'>
            <div class="clear"></div>
            <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <div class="job_hr_list_box">
            <div class="job_hr_list_boxcheckbox">  
            <input type="checkbox" name="delid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="job_hr_list_boxcheckbox_c">
            </div>           
           <div class="job_hr_resume_user">
           <div class="job_hr_resume_user_name">
           <a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.eid`'),$_smarty_tpl);?>
"  target="_blank" class="com_Release_name" style="color:#333"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
&nbsp;</a>
           </div>
           <div class="">
           <span class="hr_s_t_p"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
���� <span style="font-size:12px;color:#999; padding:0px 5px;">|</span> <?php echo $_smarty_tpl->tpl_vars['v']->value['edu'];?>
ѧ��</span>
           <span  class="hr_s_t">�����ְλ��<a <?php if ($_smarty_tpl->tpl_vars['v']->value['type']=='1') {?>href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$v.job_id`'),$_smarty_tpl);?>
"<?php }?> target="_blank" class="uesr_name_a"><?php echo $_smarty_tpl->tpl_vars['v']->value['job_name'];?>
</a>
           </span>
           <span class="hr_s_t"> �����ʱ�䣺 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['datetime'],'%Y-%m-%d');?>
   </span>
           </div>
             <div class="job_hr_resume_user_yx">  
             ����ְλ��<span class="" style="color:#f60; font-weight:bold"><?php echo $_smarty_tpl->tpl_vars['v']->value['jobname'];?>
</span>
             </div>
           </div>
        
              <div class="clear"></div>
              <div class="job_hr_list_l">
             
              <div class="com_mem_hr_list_b_b"> <span class="com_mem_hr_list_bzt ">���״̬��</span> 
              <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']!=4&&$_smarty_tpl->tpl_vars['v']->value['userid_msg']==1&&$_smarty_tpl->tpl_vars['v']->value['is_browse']!='5') {?><span class="browsebj com_mem_hr_list_bj com_mem_hr_list_bj_cur" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='5'> ���������� </span>
				<?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']!=4) {?><span class="browsebj com_mem_hr_list_bj <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']=='5') {?>com_mem_hr_list_bj_cur<?php }?>" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='5'> �޷���ϵ </span> <?php }?> 
				<?php } else { ?> 
              <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']<2) {?> 
             
              <span class="browsebj com_mem_hr_list_bj  <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']=='1') {?>com_mem_hr_list_bj_cur com_mem_hr_list_red<?php }?>" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='1'> δ�鿴<i class="com_mem_hr_no_icon"></i> <em class="job_hr_new_resume"></em></span>
              <?php }?>
                
                <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']<3) {?> <span class="browsebj com_mem_hr_list_bj <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']=='2') {?>com_mem_hr_list_bj_cur<?php }?>" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='2'> �Ѳ鿴</span><?php }?>
                
                <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']<4) {?><span class="browsebj com_mem_hr_list_bj <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']=='3') {?>com_mem_hr_list_bj_cur<?php }?>" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='3'> �ȴ�֪ͨ </span> <?php }?> 
                
                <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']<5) {?><span class="browsebj com_mem_hr_list_bj <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']=='4') {?>com_mem_hr_list_bj_cur<?php }?>" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='4'> �ܾ�����</span><?php }?>    
                
                <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']!=4) {?><span class="browsebj com_mem_hr_list_bj <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']=='5') {?>com_mem_hr_list_bj_cur<?php }?>" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='5'> �޷���ϵ </span> <?php }
}?>
                </div>
         
         <div class="job_hr_list_r">
              <!--20170929  -->
              <span class="job_hr_job_cz_a"> <a href="javascript:void(0);" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" eid="<?php echo $_smarty_tpl->tpl_vars['v']->value['eid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" jobid="<?php echo $_smarty_tpl->tpl_vars['v']->value['job_id'];?>
"   class="pj_resume uesr_name_a" jobtype='<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
'>����</a> </span>
              <i class="job_hr_job_cz_line">|</i>
              <span class="job_hr_job_cz_a"> <a href="javascript:void(0)" onclick="layer_del('ȷ��Ҫɾ������ְλ������', 'index.php?c=hr&act=hrset&delid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
'); " class="uesr_name_a">ɾ��</a> </span>
              <?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']!=4) {?> 
				  <?php if ($_smarty_tpl->tpl_vars['v']->value['userid_msg']==1) {?>
					<?php if ($_smarty_tpl->tpl_vars['v']->value['is_browse']==5) {?>
					<i class="job_hr_job_cz_line">|</i><span class="job_hr_job_cz_a">�޷���ϵ</span>
					<?php } else { ?>
					<i class="job_hr_job_cz_line">|</i><span class="job_hr_job_cz_a">����������</span>
					<?php }?>
				  <?php } else { ?>
				   <span class="job_hr_job_cz_ms"> <a href="javascript:void(0);" uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" username="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" jobid="<?php echo $_smarty_tpl->tpl_vars['v']->value['job_id'];?>
"   class="sq_resume uesr_name_a" jobtype='<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
'>��������</a></span>
				   <i class="job_hr_job_cz_line">|</i> <span class="job_hr_job_cz_a"><a href="javascript:void(0)" name='<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
' browse='4' class="browsebj uesr_name_a">�ܾ�����</a> </span>
				  <?php }?>
              <?php } else { ?>
			  <i class="job_hr_job_cz_line">|</i><span class="job_hr_job_cz_a">�Ѿܾ�</span>
              <?php }?>
              </div>   </div>
                 </div>
            <?php } ?>
            <div class="com_Release_job_bot" style="margin-top:10px;"> <span class="com_Release_job_qx">
              <input id='checkAll'  type="checkbox" onclick='m_checkAll(this.form)' class="com_Release_job_qx_check">
              ȫѡ</span>
              <INPUT class="c_btn_02" type="button" name="subdel" value="����ɾ��" onclick="return really('delid[]');">
              <INPUT class='c_btn_02' type="button" name="subdel" value="�����鿴" onclick="return really_read('delid[]');" style="margin-left:10px;">
            </div>
            <?php } else { ?>
            <div class="msg_no"> 
			 <?php if ($_GET['keyword']!='') {?>
              <p>û����������ؼ�����¼��</p>
              <?php } else { ?>
              <p> �װ����û���Ŀǰ����û���յ������˾ְλ���˲ż�����</p>
              <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit">��Ҫ�������˲�</a> 
			 <?php }?> </div>
            <?php }?>
            <div class="diggg mt10 fltR"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
          </form>
          <div  class="clear"></div>
          <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
          
          <?php }?>
          <div  class="clear"></div>
          <div class="wxts_box wxts_box_mt30">
            <div class="wxts">��ܰ��ʾ��</div>
            1. ���У�<span class="f60"><?php if ($_smarty_tpl->tpl_vars['jobnum']->value) {
echo $_smarty_tpl->tpl_vars['jobnum']->value;
} else { ?>0<?php }?></span>���ݼ��������˾������ְλ <br>
            2.������ְ����˵��ʹ�Ǳ��ܾ���Ҳʤ��������Ѷ�ĵȴ���<br>
            3.����Լ��������Ϊ�����ʸ���ְ��Ͷ�ݵļ�������һ������<br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo '<script'; ?>
><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(document).ready(function(){
	$(".browsebj").click(function(){
		var browse=$(this).attr('browse');
		var id=$(this).attr('name');
		$.post("index.php?c=hr&act=hrset",{id:id,browse:browse},function(data){
			location.reload();
		});
	});
});
<?php echo '</script'; ?>
> 
<div id='evaluation_box' style="display:none;float:left">
  <div class="resume_yqbox">
    <dl><dt>���۷�����</dt><dd><input size='100' name="score" id='address' value='' class="resume_yqbox_text"></dd></dl>
    <dl><dt>�������ݣ�</dt><dd> <textarea id="content" name="content" cols="40" rows="5" class="resume_yqbox_textarea"></textarea></dd></dl>
    <dl  id="resume_job" style="height:40px;"><dt>&nbsp;</dt><dd> <input type="hidden" id="uid" value="">
      <input type="hidden" id="username" value="">
      <input class="resume_sub_yq" id="click_invite" type="button" value="�ύ"  ></dd></dl>
  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
