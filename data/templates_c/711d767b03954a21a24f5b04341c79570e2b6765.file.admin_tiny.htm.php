<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 20:33:00
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_tiny.htm" */ ?>
<?php /*%%SmartyHeaderCode:912059ce3d7c5c8834-48726209%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '711d767b03954a21a24f5b04341c79570e2b6765' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_tiny.htm',
      1 => 1492497246,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '912059ce3d7c5c8834-48726209',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'rows' => 0,
    'key' => 0,
    'v' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ce3d7c76c6c5_02583768',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ce3d7c76c6c5_02583768')) {function content_59ce3d7c76c6c5_02583768($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
function audall(status){
	var codewebarr="";
	$(".check_all:checked").each(function(){ //���ڸ�ѡ��һ��ѡ�е��Ƕ��,���Կ���ѭ�����
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	if(codewebarr==""){
		 parent.layer.msg('����δѡ���κ���Ϣ��', 2, 8);	return false;
	}else{
		var pytoken=$("#pytoken").val();
		$.post("index.php?m=admin_tiny&c=status",{allid:codewebarr,status:status,pytoken:pytoken},function(data){
			if(data=="1") {
				parent.layer.msg('������˳ɹ���', 2, 9,function(){window.location.reload();});

			}else{
				parent.layer.msg('����ȡ����˳ɹ���', 2, 9,function(){window.location.reload();});
			}
		});
	}
}
function show_status(id){
	$.get("index.php?m=admin_tiny&c=ajax&id="+id,function(data){
		var data=eval('('+data+')');
		$("#username").html(data.username);
		$("#sex").html(data.sex);
		$("#exp").html(data.exp);
		$("#job").html(data.job);
		$("#mobile").html(data.mobile);
		$("#production").html(data.production);
		$("#time").html(data.time);
		$("#status_"+data.status).attr("checked","checked");
		$("#statusid").val(id);
		$.layer({
			type : 1,
			title : '��˲���',
			closeBtn : [0 , true],
			offset : ['20%' , '30%'],
			border : [10 , 0.3 , '#000', true],
			area : ['460px','auto'],
			page : {dom : '#preview'}
		});
	})
}
function check_status(){
	var id=$("#statusid").val();
	var status=$("input[name='status']:checked").val();
	var pytoken=$("#pytoken").val();
	$.post("index.php?m=admin_tiny&c=status",{allid:id,status:status,pytoken:pytoken},function(data){
		if(data=="1"){
			parent.layer.msg('��˳ɹ���', 2, 9,function(){window.location.reload();});
		}else{
			parent.layer.msg('ȡ����˳ɹ���', 2, 9,function(){window.location.reload();});
		}
	});
}
<?php echo '</script'; ?>
>
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />

<title>��̨����</title>
</head>
<body class="body_ifm">
<div class="infoboxp">
  <div class="infoboxp_top_bg"></div>
  <form action="index.php" name="myform" method="get">
    <input name="m" value="admin_tiny" type="hidden"/>
    <div class="admin_Filter"> <span class="complay_top_span fl">�չ������б�</span>
      <div class="admin_Filter_span">�������ͣ�</div>
      <div class="admin_Filter_text formselect" did='dtype'>
        <input type="button" <?php if ($_GET['type']=='1'||$_GET['type']=='') {?> value="�û�����" <?php } elseif ($_GET['type']=='2') {?> value="����ְλ" <?php } elseif ($_GET['type']=='3') {?> value="�ֻ�����" <?php }?> class="admin_Filter_but" id="btype">
        <input type="hidden" name="type" id="type" value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>"/>
        <div class="admin_Filter_text_box" style="display:none" id="dtype">
          <ul>
            <li><a href="javascript:void(0)" onClick="formselect('1','type','�û�����')">�û�����</a></li>
            <li><a href="javascript:void(0)" onClick="formselect('2','type','����ְλ')">����ְλ</a></li>
            <li><a href="javascript:void(0)" onClick="formselect('3','type','�ֻ�����')">�ֻ�����</a></li>
 
          </ul>
        </div>
      </div>
      <input type="text" placeholder="������Ҫ�����Ĺؼ���" value="<?php echo $_GET['keyword'];?>
" name='keyword' class="admin_Filter_search">
      <input type="submit" name='search' value="����" class="admin_Filter_bth">
      <span class='admin_search_div'>
      <div class="admin_adv_search">
        <div class="admin_adv_search_bth">�߼�����</div>
      </div>
      </span> </div>
  </form>
  <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <div class="table-list">
    <div class="admin_table_border">
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php" target="supportiframe" name="myform" method="get" id='myform'>
        <input name="m" value="admin_tiny" type="hidden"/>
        <input name="c" value="del" type="hidden"/>
        <input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th width="20"><label for="chkall">
                <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)'/>
                </label></th>
              <th width="80"> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_tiny&order=desc&t=id">�������<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=admin_tiny&order=asc&t=id">�������<img src="images/sanj2.jpg"/></a> <?php }?> </th>
              <th align="left">����</th>
              <th align="left">�Ա�</th>
              <th align="left">��������</th>
              <th align="left">����ְλ</th>
              <th>�ֻ�</th>
              <th> <?php if ($_GET['t']=="time"&&$_GET['order']=="asc") {?> <a href="index.php?m=admin_tiny&order=desc&t=time">����ʱ��<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="index.php?m=admin_tiny&order=asc&t=time">����ʱ��<img src="images/sanj2.jpg"/></a> <?php }?> </th>
              <th>״̬</th>
              <th class="admin_table_th_bg">����</th>
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
          <tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><input type="checkbox" class="check_all" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk"/></td>
            <td align="center" class="td1" width="80"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
            <td class="ud" align="left"><a href="index.php?m=admin_tiny&c=show&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_cz_sc"><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</a></td>
            <td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['sex'];?>
</td>
            <td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['exp'];?>
</td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['job'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['mobile'];?>
</td>
            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['time'],"%Y-%m-%d");?>
</td>
            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?><span class="admin_com_Audited">�����</span><?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==0) {?><span class="admin_com_noAudited">δ���</span><?php } else { ?><span class="admin_com_Lock">�ѹ���</span><?php }?></td>
            <td><a href="javascript:void(0)" class="status admin_cz_sc" onClick="show_status('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">���</a> | <a href="index.php?m=admin_tiny&c=show&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"class="admin_cz_sc">Ԥ��</a> | <a href="index.php?m=admin_tiny&c=edit&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"class="admin_cz_sc">�޸�</a> | <a href="javascript:void(0)" onClick="layer_del('ȷ��Ҫɾ����','index.php?m=admin_tiny&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"class="admin_cz_sc">ɾ��</a></td>
          </tr>
          <?php } ?>
          <tr style="background:#f1f1f1;">
            <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
            <td colspan="5" ><label for="chkAll2">ȫѡ</label>
              &nbsp;
              <input class="admin_submit4" type="button" name="delsub" value="ɾ����ѡ" onClick="return really('del[]')" />
              &nbsp;&nbsp;
              <input class="admin_submit4" type="button" name="delsub" value="�������" onClick="audall('1');" />
              &nbsp;&nbsp;
              <input class="admin_submit6" type="button" name="delsub" value="����ȡ�����" onClick="audall('0');" /></td>
            <td colspan="5" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
          </tr>
          </tbody>
          
        </table>
      </form>
    </div>
  </div>
</div>
<div id="preview"  style="display:none;width:460px ">
  <div style="width:460px;" >
    <input id="statusid" type="hidden">
    
    
  <table cellspacing='1' cellpadding='1' class="admin_examine_table table_form" style="width:100%; font-size:12px;">      <tr class="admin_table_trbg">
         <th width="110">������</th>
        <td id="username"></td>
      </tr>
      <tr>
        <th>�Ա�</th>
        <td id="sex"></td>
      </tr>
      <tr class="admin_table_trbg">
        <th>�������ޣ�</th>
        <td id="exp"></td>
      </tr>
      <tr>
        <th>����ְλ��</th>
        <td id="job"></td>
      </tr>
      <tr class="admin_table_trbg">
        <th>�ֻ���</th>
        <td id="mobile"></td>
      </tr>
      <tr>
        <th>���ҽ��ܣ�</th>
        <td><div style="max-height:70px; _height:70px; overflow:hidden; overflow-y:auto"><div class="" id="production"></div></div></td>
      </tr>
      <tr class="admin_table_trbg">
        <th>ʱ�����䣺</th>
        <td id="time"></td>
      </tr>
     <tr>
    <th width="80">��˲�����</th>
      <td align="left">
        <div class="admin_examine_right">
      	<label><span class="admin_examine_table_s"><input name='status' type='radio' value='1' id='status_1'>�����</span></label>
          	<label><span class="admin_examine_table_s">  <input name='status' type='radio' value='0' id='status_0'>δ���</span></label>
    
       </div>
     </tr>
     
 <tr>
           <td colspan='2' align="center">
   <div class="admin_Operating_sub">         <input class="admin_examine_bth" type="button" onClick="check_status();" value="�ύ" ></div></td>
   </tr>
   
    
     </table>
  </div>
</div>
</body>
</html>
<?php }} ?>
