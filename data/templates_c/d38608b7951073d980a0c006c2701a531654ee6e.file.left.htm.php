<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 18:01:42
         compiled from "D:\phpStudy\WWW\uploads\\app\template\member\com\left.htm" */ ?>
<?php /*%%SmartyHeaderCode:1337959ce4a4d7ccf37-36784875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd38608b7951073d980a0c006c2701a531654ee6e' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\member\\com\\left.htm',
      1 => 1506765621,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1337959ce4a4d7ccf37-36784875',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce4a4da6e676_43422923',
  'variables' => 
  array (
    'js_def' => 0,
    'config' => 0,
    'uid' => 0,
    'addjobnum' => 0,
    'addpartjobnum' => 0,
    'guweninfo' => 0,
    'atn' => 0,
    'report' => 0,
    'kfqq' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce4a4da6e676_43422923')) {function content_59ce4a4da6e676_43422923($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><div class="left_box">
  <?php if ($_smarty_tpl->tpl_vars['js_def']->value==2) {?>
  <div class="subnav_h1"><span>��ҵ����</span>  </div>
  <ul class="left_nav_ul">
    <li <?php if ($_GET['c']=="info") {?> class="style01 left_nav_hover"<?php } else { ?>class="style01"<?php }?>><span><a href="index.php?c=info" title="������Ϣ"><i class="com_left_icon com_left_icon_info"></i>������Ϣ</a></span> </li>
        <li <?php if ($_GET['c']=="uppic") {?> class="style01 left_nav_hover"<?php } else { ?>class="style08"<?php }?>><span><a href="index.php?c=uppic" title="��ҵLOGO"><i class="com_left_icon com_left_icon_logo"></i>��ҵLogo</a></span> </li>
    <li <?php if ($_GET['c']=="map") {?> class="style01 left_nav_hover"<?php } else { ?>class="style02"<?php }?>><span><a href="index.php?c=map" title="��ҵ��ͼ"><i class="com_left_icon com_left_icon_map"></i>��ҵ��ͼ</a></span> </li>
    <li <?php if ($_GET['c']=="news") {?> class="style01 left_nav_hover"<?php } else { ?>class="style03"<?php }?>><span><a href="index.php?c=news" title="��ҵ����"><i class="com_left_icon com_left_icon_news"></i>��ҵ����</a></span> </li>
    <li <?php if ($_GET['c']=="product") {?> class="style01 left_nav_hover"<?php } else { ?>class="style04"<?php }?>><span><a href="index.php?c=product" title="��ҵ��Ʒ"><i class="com_left_icon com_left_icon_cp"></i>��ҵ��Ʒ</a></span> </li>
    <li <?php if ($_GET['c']=="show") {?> class="style01 left_nav_hover"<?php } else { ?>class="style05"<?php }?>><span><a href="index.php?c=show" title="��ҵ����"><i class="com_left_icon com_left_icon_hj"></i>��ҵ����</a></span> </li>
     <li <?php if ($_GET['c']=="comtpl") {?> class="style01 left_nav_hover"<?php } else { ?>class="style09"<?php }?>><span><a href="index.php?c=comtpl" title="ģ���л�"><i class="com_left_icon com_left_icon_mb"></i>ģ���л�</a></span></li>
    <li <?php if ($_GET['c']=="binding") {?> class="style01 left_nav_hover"<?php } else { ?>class="style07"<?php }?>><span><a href="index.php?c=binding"><i class="com_left_icon com_left_icon_bd"></i>�˻���֤</a></span></li> 
	 <li <?php if ($_GET['c']=="tongji") {?> class="style01 left_nav_hover"<?php } else { ?>class="style07"<?php }?>><span><a href="index.php?c=tongji"><i class="com_left_icon com_left_icon_fx"></i>��Ƹ����</a></span></li> 
  </ul>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['js_def']->value==5) {?>
    <div class="subnav_h1"><span>�˲Ź���</span>  </div>
  <ul class="left_nav_ul">
  <?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']==1) {?><li <?php if ($_GET['c']=="resume") {?> class="style01 left_nav_hover"<?php } else { ?>class="style06"<?php }?>><span><a href="index.php?c=resume" class="f60"><i class="com_left_icon com_left_icon_search"></i>���˲�<i class="com_icon com_icon_new"></i></a></span></li><?php }?>
  <li <?php if ($_GET['c']=="my_create_resume"||$_GET['c']=="hr"||$_GET['c']=="down"||$_GET['c']=="talent_pool"||$_GET['c']=="look_resume"||$_GET['c']=="record") {?> class="style01 left_nav_hover"<?php } else { ?>class="style01"<?php }?>><span><a href="index.php?c=hr" title="�ҵļ���"><i class="com_left_icon com_left_icon_jl"></i>�ҵļ���</a></span> </li>
   <li <?php if ($_GET['c']=="invite") {?> class="style01 left_nav_hover"<?php } else { ?>class="style03"<?php }?>><span><a href="index.php?c=invite" title="���������Ե��˲�"><i class="com_left_icon com_left_icon_yq"></i>��������</a></span> </li>
     <li <?php if ($_GET['c']=="subscribe") {?> class="style01 left_nav_hover"<?php } else { ?>class="style06"<?php }?>><span><a href="index.php?c=subscribe"><i class="com_left_icon com_left_icon_info"></i>�˲Ŷ���</a></span> </li>
    <li <?php if ($_GET['c']=="finder") {?> class="style01 left_nav_hover"<?php } else { ?>class="style06"<?php }?>><span><a href="index.php?c=finder"><i class="com_left_icon com_left_icon_sq"></i>�˲�������</a></span> </li>
	<li <?php if ($_GET['c']=="attention_me") {?> class="style01 left_nav_hover"<?php } else { ?>class="style06"<?php }?>><span><a href="index.php?c=attention_me" ><i class="com_left_icon com_left_icon_gz"></i>��ע�ҵ��˲�</a></span> </li>
    <li <?php if ($_GET['c']=="look_job") {?> class="style01 left_nav_hover"<?php } else { ?>class="style06"<?php }?>><span><a href="index.php?c=look_job"><i class="com_left_icon com_left_icon_eye"></i>�������ְλ</a></span> </li>
    <li class="style09"><span><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'myquestion','uid'=>$_smarty_tpl->tpl_vars['uid']->value),$_smarty_tpl);?>
" target="_blank" title="�ҵ��ʴ�"><i class="com_left_icon com_left_icon_ask"></i>�ҵ��ʴ�</a></span> </li>
   
  </ul>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['js_def']->value==3) {?>
        <div class="subnav_h1"><span>��Ƹ����</span>  </div>
     <ul class="left_nav_ul"> 
     <li><span><a href="javascript:void(0)"  onclick="jobadd_url('<?php echo $_smarty_tpl->tpl_vars['addjobnum']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_job'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
');return false;" class="f60 bold"><i class="com_left_icon com_left_icon_fb"></i>������ְλ</a></span> </li>
     <li <?php if ($_GET['c']=="job") {?> class="style01 left_nav_hover"<?php } else { ?>class="style03"<?php }?>><span><a href="index.php?c=job&w=1" title="�����е�ְλ"><i class="com_left_icon com_left_icon_zwgl"></i>ְλ����</a></span></li>   
    <li <?php if ($_GET['c']=="special") {?> class="style01 left_nav_hover"<?php } else { ?>class="style07"<?php }?>><span><a href="index.php?c=special"><i class="com_left_icon com_left_icon_zt"></i>ר����Ƹ</a></span></li>
    <li <?php if ($_GET['c']=="partadd") {?> class="style01 left_nav_hover"<?php } else { ?>class="style07"<?php }?>><span><a onclick="jobadd_url('<?php echo $_smarty_tpl->tpl_vars['addpartjobnum']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_partjob'];?>
','<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
','part');" title="������ְ" class="f60 bold" style="cursor:pointer"><i class="com_left_icon com_left_icon_jz"></i>������ְ</a></span> </li>
    <li <?php if ($_GET['c']=="partok"||$_GET['c']=="part") {?> class="style01 left_nav_hover"<?php } else { ?>class="style07"<?php }?>><span><a href="index.php?c=partok&w=1" title="ȫ����ְ"><i class="com_left_icon com_left_icon_jzgl"></i>��ְ����</a></span></li>
    <li <?php if ($_GET['c']=="partapply") {?> class="style01 left_nav_hover"<?php } else { ?>class="style07"<?php }?>><span><a href="index.php?c=partapply" title="��ְ����"><i class="com_left_icon com_left_iconbm"></i>��ְ����</a></span></li>
  </ul>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['js_def']->value==4) {?>
     <div class="subnav_h1"><span>�������</span>  </div>
  <ul class="left_nav_ul">
    <li <?php if ($_GET['c']=="pay") {?> class="style01 left_nav_hover"<?php } else { ?>class="style05"<?php }?>><span><a href="index.php?c=pay" title="���̳�ֵ"><font color="#FF0000"><i class="com_left_icon com_left_icon_cz"></i>���̳�ֵ</font></a></span></li>  
    <li <?php if ($_GET['c']=="paylogtc") {?> class="style01 left_nav_hover"<?php } else { ?>class="style08"<?php }?>><span><a href="index.php?c=paylogtc" title="�ҵĻ�Ա"><i class="com_left_icon com_left_icon_myhy"></i>�ҵĻ�Ա</a></span></li>
    <li <?php if ($_GET['c']=="right"&&$_GET['act']==''||$_GET['c']=="right"&&$_GET['act']=="time"||$_GET['c']=="right"&&$_GET['act']=="added") {?> class="style01 left_nav_hover"<?php } else { ?>class="style12"<?php }?>><span><a href="index.php?c=right"><i class="com_left_icon com_left_icon_fw"></i>��Ա����<i class="com_icon com_icon_new"></i></a></span></li>
    <li <?php if ($_GET['c']=="com"||$_GET['c']=="paylog") {?> class="style01 left_nav_hover"<?php } else { ?>class="style09"<?php }?>><span><a href="index.php?c=com" title="������ϸ"><i class="com_left_icon com_left_icon_mx"></i>������ϸ</a></span></li>
    <li <?php if ($_GET['c']=="integral"||$_GET['c']=="reward_list"||$_GET['c']=="integral_reduce") {?> class="style01 left_nav_hover"<?php } else { ?>class="style12"<?php }?>><span><a href="index.php?c=integral"><i class="com_left_icon com_left_icon_gl"></i><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
����</a></span></li>
   
  </ul>
  <?php }?>
 <?php if ($_smarty_tpl->tpl_vars['js_def']->value==7) {?>
     <div class="subnav_h1"><span>ϵͳ����</span>  </div>
    <ul class="left_nav_ul">
    <li <?php if ($_GET['c']=="vs") {?> class="style01 left_nav_hover"<?php } else { ?>class="style03"<?php }?>><span><a href="index.php?c=vs" title="�޸�����"><i class="com_left_icon com_left_icon_m"></i>�޸�����</a></span> </li>  
    <li <?php if ($_GET['c']=="sysnews") {?> class="style01 left_nav_hover"<?php } else { ?>class="style11"<?php }?>><span><a href="index.php?c=sysnews" title="ϵͳ��Ϣ"><i class="com_left_icon com_left_icon_xin"></i>ϵͳ��Ϣ</a></span> </li>
    <li <?php if ($_GET['c']=="msg") {?> class="style01 left_nav_hover"<?php } else { ?>class="style03"<?php }?>><span><a href="index.php?c=msg" title="��ְ��ѯ"><i class="com_left_icon com_left_icon_zx"></i>��ְ��ѯ</a></span> </li>
  </ul>
  <?php }?>

<?php if ($_smarty_tpl->tpl_vars['guweninfo']->value['id']) {?>
<div class="com_index_kf">
<div class="com_m_index_h1"><span class="com_m_index_h1_s">��Ƹ����</span></div>
<div class="com_index_kf_box">
<div class="com_index_kf_box_user">
<div class="com_index_kf_box_user_photo"><img src="<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['logo'];?>
" style="width:64px;height:64px"></div>
<div class="com_index_kf_box_username"><?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['username'];?>
</div>
<div class="">
<?php if ($_smarty_tpl->tpl_vars['guweninfo']->value) {?>
<a target="_blank" href="tencent://message/?uin=<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['qq'];?>
&Site=<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
&Menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['qq'];?>
:12" alt="���������ҷ���Ϣ"></a>
<?php }?></div>
</div>
<div class="com_index_kf_p">�绰��<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['mobile'];?>
</div>
<div class="com_index_kf_p">΢�ţ�<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['weixin'];?>
</div>
<div class="com_index_kf_p">Q Q��<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['qq'];?>
</div>

<div class="com_index_kf_p">
<?php if ($_smarty_tpl->tpl_vars['atn']->value['uid']) {?>
<a href="javascript:void(0)" class="com_index_kf_dz_left">�ѵ���</a>
<?php } else { ?>
<a href="javascript:void(0)" onclick="zan('<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['id'];?>
');" class="com_index_kf_dz_left">����</a>
<?php }?>
<?php if (is_array($_smarty_tpl->tpl_vars['report']->value)&&!$_smarty_tpl->tpl_vars['report']->value['result']) {?>
<a href="index.php?c=report&act=show"  class="com_index_kf_ts_left">��Ͷ��</a>
<?php } else { ?>
<a href="javascript:void(0)" onclick="reportgw('<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['id'];?>
','Ͷ�߹���');"  class="com_index_kf_ts_left">Ͷ��</a>
<?php }?></div>
</div>
</div>

<?php } else { ?>
<div class="com_index_kf">
<div class="com_m_index_h1"><span class="com_m_index_h1_s">��Ƹ����</span></div>
<div class="com_index_kf_box">
<div class="com_index_kf_box_user">
<div class="com_index_kf_box_user_photo"><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_guwen'];?>
" style="width:64px;height:64px"></div>
<div class="com_index_kf_box_username">��վ�ͷ�</div>
<div class="">
<?php if ($_smarty_tpl->tpl_vars['kfqq']->value) {?>
<a target="_blank" href="tencent://message/?uin=<?php echo $_smarty_tpl->tpl_vars['kfqq']->value;?>
&Site=<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
&Menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $_smarty_tpl->tpl_vars['kfqq']->value;?>
:12" alt="���������ҷ���Ϣ"></a>
<?php }?>
</div>
</div>
<div class="com_index_kf_p">�绰��<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</div>
<div class="com_index_kf_p">�ֻ���<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webmoblie'];?>
</div>
<div class="com_index_kf_p">Q  Q��<?php echo $_smarty_tpl->tpl_vars['kfqq']->value;?>
</div>
<?php if ($_smarty_tpl->tpl_vars['config']->value['wx_name']) {?><div class="com_index_kf_p">΢�Ź��ںţ�<?php echo $_smarty_tpl->tpl_vars['config']->value['wx_name'];?>
</div><?php }?>
</div>
</div>

<?php }?>
</div>
<div id="<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['id'];?>
" style="display:none;">
  <div class="Binding_pop_box" style="padding:10px;width:330px;height:200px ;background:#fff;">
    <div class="Binding_pop_box_msg">��ҪͶ�ߵĹ����ǣ�<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['username'];?>
</div>
   
       <div class="popjb_tip">Ϊ���ܹ������ṩ�������ķ��񣬷���������������ǻ��һʱ������𸴣�</div>
    
     <div class="">
     	 <textarea id="reason" name="reason" class="popjb_text"></textarea>
      </div>
      <div class="Binding_pop_sub" style="margin-top:15px;"> <span class="Binding_pop_box_list_left">&nbsp;</span>
        <input class="com_pop_bth_qd" onclick="reportSub('index.php?c=report')" type="button" value="ȷ��">
		<input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['guweninfo']->value['id'];?>
" id='eid' name='eid'> 
        <input class="com_pop_bth_qx" type="button" value="ȡ��" onclick="layer.closeAll();">
      </div>
    </div>
  </div>
<?php echo '<script'; ?>
 type="text/javascript">
function reportgw(eid,title){
	$.layer({
		type : 1,
		title :title,
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['350px','auto'],
		page : {dom :"#"+eid}
	});
}
function reportSub(url){
	var reason=$("#reason").val();
	var eid=$("#eid").val();
	if(reason==''){
		layer.msg('����дͶ�����ݣ�', 2, 8);return false;
	}
	$.post(url,{reason:reason,eid:eid},function(data){ 
		layer.closeAll();
		if(data=='0'){
			layer.msg('Ͷ��ʧ�ܣ�', 2, 8);
		}else if(data=='1'){
			layer.msg('Ͷ�߳ɹ���', 2, 9,function(){window.location.reload();});
		}else if(data=='2'){			
			layer.msg('��Ͷ�߳ɹ����ȴ�����Ա�ظ���', 2, 8);
		}
	});
}
function zan(id){
	$.post("index.php?m=ajax&c=guwenZan",{id:id},function(data){ 
		if(data=='2'){
			layer.msg('�벻Ҫ�ظ����ޣ�', 2, 8);
		}else if(data=='1'){
			layer.msg('���޳ɹ���',2,9,function(){window.location.reload();});
		}
	});
}
<?php echo '</script'; ?>
><?php }} ?>
