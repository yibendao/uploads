<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-06 18:30:59
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\com\my_create_resume.htm" */ ?>
<?php /*%%SmartyHeaderCode:2387859cf5c127c5b36-86104570%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd55e82298b4c51b3ffd0bf0bc9202ca3c5255db9' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\com\\my_create_resume.htm',
      1 => 1507285853,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2387859cf5c127c5b36-86104570',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf5c12a19773_46286309',
  'variables' => 
  array (
    'comstyle' => 0,
    'get_type' => 0,
    'StateList' => 0,
    'one' => 0,
    'rows' => 0,
    'v' => 0,
    'pytoken' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf5c12a19773_46286309')) {function content_59cf5c12a19773_46286309($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link href="<?php echo $_smarty_tpl->tpl_vars['comstyle']->value;?>
/images/index_style.css" type=text/css rel=stylesheet>
<div class="w1000">
  <div class="admin_mainbody"> <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/left.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class=right_box>
      <div class=admincont_box>
        <div class="job_list_tit">
          <ul class="">
            <li <?php if ($_GET['c']=="hr") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=hr">应聘简历</a></li>
            <li <?php if ($_GET['c']=="down") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=down">已下载简历</a></li>
            <li <?php if ($_GET['c']=="talent_pool") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=talent_pool">收藏简历</a></li>
            <li <?php if ($_GET['c']=="look_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=look_resume">浏览简历</a></li>
            <li <?php if ($_GET['c']=="record") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=record" title="网站为您推荐的简历">网站推荐简历</a></li>
            <li <?php if ($_GET['c']=="my_create_resume") {?> class="job_list_tit_cur"<?php }?>><a href="index.php?c=my_create_resume" title="我创建的简历">我创建的简历</a></li>
          </ul>
        </div>
        <div class="com_body">
          <div class=admin_textbox_04>
            <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
            <!--操作区  -->
            <div class="hr_tip_box my_create_resume">
              <div class="hr_subMetx"> 
                <div class="left">
                  <span class="hr_resumesearch_span fltL">搜索类型：</span>
                  <div class="text_seclet text_seclet_cur2 re resume_type">
                    <input id="qypr" class="SpFormLBut text_seclet_w250 resume_type" type="button" onclick="search_show('job_qypr');" <?php if ($_smarty_tpl->tpl_vars['get_type']->value['keytype']==''||$_smarty_tpl->tpl_vars['get_type']->value['keytype']=='1') {?> value="简历名称"  <?php } elseif ($_smarty_tpl->tpl_vars['get_type']->value['keytype']=='2') {?> value="用户姓名"  <?php }?>>
                    <div id="job_qypr" class="cus-sel-opt-panel resume_type" style="display: none;">
                      <ul class="Search_Condition_box_list resume_type">
                          <li><a href="javascript:void(0)" onClick="formselect('1','keytype','简历名称')">简历名称</a></li>
                          <li><a href="javascript:void(0)" onClick="formselect('2','keytype','用户姓名')">用户姓名</a></li>
                      </ul>
                    </div>
                  </div>
                  <form action="index.php" method="get" >
                    <span class="hr_resumesearch_span fltL">关 键 字：</span>
                    <div class="hr_subMetx_se">
                      <input name="c" type="hidden" value="hr">
                      <input name="resumetype" type="hidden" value="<?php echo $_GET['resumetype'];?>
">
                      <input name="jobid" type="hidden" value="<?php echo $_GET['jobid'];?>
">
                        <input name="state" type="hidden" value="<?php echo $_GET['state'];?>
">
                      <input name="keyword" type="text" class="hr_resumesearch_text" placeholder="请输入姓名查找" value="<?php echo $_GET['keyword'];?>
">
                      <input type="submit"  class="hr_resumesearch_bth" value="搜索">
                    </div>
                  </form>
                </div>
                <div class="right">
                  <div>
                    <a href="index.php?c=my_create_resume&act=addresume" class="admin_infoboxp_tj" style="margin-right:5px;"> 添加简历</a>
                  </div>
                </div>
              </div>
              <!-- <div class="hr_subMetx"> <span class="hr_resumesearch_span fltL">简历状态：</span> <a href="index.php?c=hr&jobid=<?php echo $_GET['jobid'];?>
&resumetype=<?php echo $_GET['resumetype'];?>
&keyword=<?php echo $_GET['keyword'];?>
" class="hr_subMetx_a <?php if ($_GET['state']=='') {?>hr_subMetx_cur<?php }?>">不限</a> <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['StateList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?> <a <?php if ($_GET['state']==$_smarty_tpl->tpl_vars['one']->value['id']) {?>class="hr_subMetx_cur"<?php }?> href="index.php?c=hr&jobid=<?php echo $_GET['jobid'];?>
&state=<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
&resumetype=<?php echo $_GET['resumetype'];?>
&keyword=<?php echo $_GET['keyword'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</a> <?php } ?> </div> -->
            </div>
            <!--end操作区  -->
            <div class="clear"></div>

            <form action="index.php?c=my_create_resume&act=del" method="post" target="supportiframe" id='myform'>
              <div class=table>
                <div id="job_checkbokid">
                  <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
                  <div class="job_news_list job_news_list_h1"> 
                    <span class="job_news_list_span job_w30" style="padding-right:5px;">&nbsp;</span>
                    <span class="job_news_list_span job_w100">简历名称</span>
                    <span class="job_news_list_span job_w80">用户姓名</span>
                    <span class="job_news_list_span job_w80">意向职位</span>
                    <span class="job_news_list_span job_w80">工作地点</span>
                    <span class="job_news_list_span job_w80">待遇要求</span>
                    <span class="job_news_list_span job_w80">工作性质</span>
                    <span class="job_news_list_span job_w80">到岗时间</span>
                    <span class="job_news_list_span job_w80"><?php if ($_GET['t']=="time"&&$_GET['order']=="asc") {?> <a href="index.php?m=my_create_resume&order=desc&t=time">更新时间<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=my_create_resume&order=asc&t=time">更新时间<img src="images/sanj2.jpg"/></a> <?php }?></span>
                    <span class="job_news_list_span job_w120">操作</span>
                  </div>
                  <?php }?>
                  <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                  <div class="job_news_list" style="font-size: 12px;"> 
                    <span class="job_news_list_span job_w30" style="padding-right:5px;">
                      <input type='checkbox' name="del[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  class="com_Release_job_qx_check" style="margin-top:2px;">
                    </span>
                    <span class="job_news_list_span job_w100"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>  	
                    <span class="job_news_list_span job_w80"><?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>
</span>  	
                    <span class="job_news_list_span job_w80"><?php if ($_smarty_tpl->tpl_vars['v']->value['job_post_n']) {
echo $_smarty_tpl->tpl_vars['v']->value['job_post_n'];?>
(<a href="javascript:void(0)" class="job_name_all"  v="<?php echo $_smarty_tpl->tpl_vars['v']->value['job_class_name'];?>
"><font color="red">共<?php echo $_smarty_tpl->tpl_vars['v']->value['jobnum'];?>
个</font></a>)<?php }?></span>  	
                    <span class="job_news_list_span job_w80"><?php echo $_smarty_tpl->tpl_vars['v']->value['cityid_n'];?>
</span>  	
                    <span class="job_news_list_span job_w80"><?php if ($_smarty_tpl->tpl_vars['v']->value['minsalary']&&$_smarty_tpl->tpl_vars['v']->value['maxsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['maxsalary'];
} elseif ($_smarty_tpl->tpl_vars['v']->value['minsalary']) {?>￥<?php echo $_smarty_tpl->tpl_vars['v']->value['minsalary'];?>
以上<?php } else { ?>面议<?php }?></span>  	
                    <span class="job_news_list_span job_w80"><?php echo $_smarty_tpl->tpl_vars['v']->value['type_n'];?>
</span>  	
                    <span class="job_news_list_span job_w80"><?php echo $_smarty_tpl->tpl_vars['v']->value['report_n'];?>
</span>  	
                    <span class="job_news_list_span job_w80"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['lastupdate'],"%Y-%m-%d");?>
</span> 
                    <span class="job_news_list_span job_w120"  >
                      <a style="color:blue;" href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$v.id`'),$_smarty_tpl);?>
" target="_blank" class="admin_cz_sc" >预览</a> | 
                      <a style="color:blue;" href="javascript:void(0)" onClick="layer_del('确认刷新？', 'index.php?c=my_create_resume&act=refresh&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" title="刷新" class="admin_cz_sc">刷新</a><br/>
                      <a style="color:blue;" href="index.php?c=my_create_resume&act=evaluation&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
&by=qiye"  class="admin_cz_sc">评价</a> | 
                      <a style="color:blue;" href="index.php?c=my_create_resume&act=saveresume&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
&e=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_cz_sc">修改</a>
                    </span>
                  <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
                  <div class="msg_no">
                    <p>亲爱的用户，目前您还没有创建过简历！</p>
                    <a href="<?php echo smarty_function_url(array('m'=>'resume'),$_smarty_tpl);?>
" class="com_msg_no_bth com_submit">我要创建简历</a>
                  </div>
                  <?php } ?> 
                </div>
              </div>
              <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
              <div class="com_Release_job_bot"> 
                <span class="com_Release_job_qx">
                  <input id='checkAll'  type="checkbox" onclick='m_checkAll(this.form)' class="com_Release_job_qx_check">全选
                </span>
                <input  class="c_btn_02" type="button" name="subdel" value="批量删除" onclick="return really('del[]');">
                <!-- <input class="admin_submit4" type="button" name="delsub" value="删除所选" onClick="return really('del[]')" /> -->
                <input class="admin_submit4" type="button" name="delsub" value="批量刷新" onClick="Refreshs();"/>
                <input type="hidden" name="pytoken"  id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
              </div>
              <div class="clear"></div>
              <div class="diggg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
              <?php }?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/yqms.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['comstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
