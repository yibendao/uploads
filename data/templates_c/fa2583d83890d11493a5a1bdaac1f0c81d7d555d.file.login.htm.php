<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-29 13:14:15
         compiled from "D:\phpStudy\WWW\uploads\\app\template\default\public_search\login.htm" */ ?>
<?php /*%%SmartyHeaderCode:391959cdd6a7e98446-13575214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa2583d83890d11493a5a1bdaac1f0c81d7d555d' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\default\\public_search\\login.htm',
      1 => 1502264636,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '391959cdd6a7e98446-13575214',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'style' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cdd6a7f02277_22225855',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cdd6a7f02277_22225855')) {function content_59cdd6a7f02277_22225855($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?>
<!--��ǰ��¼-->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/tck_logoin.css" type="text/css"/>
<div class="none" id="onlogin">
  <div class="logoin_tck_left" style="margin-top: 25px;padding-left: 25px;">
<div style="position:absolute;right:14px;top;0;">
<?php if ($_smarty_tpl->tpl_vars['config']->value['wx_author']=='1') {?>

<div class="wxcode_login" title="΢��ɨһɨ��¼" style="display:block;"></div>
<div class="normal_login" title="��ͨ��¼" style="display:none;"></div>
<?php }?>

</div>
<!---------------ɨ���¼ҳ��---------------------->
<div class="wx_login_show" style="display:none;">
	 <div id="wx_login_qrcode" class="wxlogintext">���ڻ�ȡ��ά��...</div>
	 <div class="wxlogintxt">��ʹ��΢��ɨһɨ��¼</div>
</div>
<!------------------ɨ���¼ҳ��end--------------------->
  
  
  <div id="login_normal">
  <div class="logoin_tck_t_list"> 
    <div class="logoin_tck_tit">�û�����</div>
     <div class="logoin_tck_text" > 
      <i class="logoin_tck_text_icon"></i>
     <input type="text" id="login_username" placeholder="�������û���" tabindex="1" name="username" class="logoin_tck_text_t1" autocomplete="off"/>
    </div>
    </div>
            <div class="logoin_tck_t_list" >
    <div class="logoin_tck_tit">��&nbsp;&nbsp;&nbsp;&nbsp;�룺</div>
    <div class="logoin_tck_text"> <i class="logoin_tck_text_icon logoin_tck_text_icon_p"></i>
      <input type="password" id="login_password" tabindex="2" name="password" placeholder="����������" class="logoin_tck_text_t1" autocomplete="off"/>
    </div>
    </div>
    
	<?php if (strpos($_smarty_tpl->tpl_vars['config']->value['code_web'],"ǰ̨��¼")!==false) {?>   
        <?php if ($_smarty_tpl->tpl_vars['config']->value['code_kind']==3) {?>	
	
		<?php echo '<script'; ?>
 src="http://static.geetest.com/static/tools/gt.js"><?php echo '</script'; ?>
>
               <div class="logoin_tck_t_list" >
    <div class="logoin_tck_tit" style="line-height:42px;">��&nbsp;&nbsp;&nbsp;&nbsp;֤��</div>    
     <div class="fastlogin_verification ">
		<div id="popup-captcha-publiclogin" data-id='sublogin' data-type='click'></div>
		<input type='hidden' id="popup-submit-publiclogin">
		<input type='hidden' name="geetest_challenge_publiclogin" value=''>
		<input type='hidden' name="geetest_validate_publiclogin" value=''>
		<input type='hidden' name="geetest_seccode_publiclogin" value=''>
</div></div>
    <style>
		.fastlogin_verification .geetest_holder.geetest_wind{min-width:200px;}
		</style>
		<?php } else { ?>   
                      <div class="logoin_tck_t_list" >
    <div class="logoin_tck_tit">��֤�룺</div>    
        <div class="logoin_tck_text logoin_tck_text_yzm"> <i class="logoin_tck_text_icon logoin_tck_text_icon_y"></i>
          <input id="login_authcode" type="text" tabindex="3"  maxlength="4" name="authcode" class="logoin_tck_text_t1" placeholder="��������֤��"  style="width:80px;" autocomplete="off"/>
        </div>
        <div class=" logoin_tck_text_yzm_r"> <img id="vcode_img" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" onclick="checkCode('vcode_img');" style="margin-right:5px; margin-left:5px;cursor:pointer;"/> 
        <input type="hidden" id="login_codekind" value="1" />
        </div>
        </div>
		<?php }?>
<?php } else { ?>
         <div class="logoin_tck_t_list" >
    <div class="logoin_tck_tit">&nbsp;</div>
    <a href="<?php echo smarty_function_url(array('m'=>'forgetpw'),$_smarty_tpl);?>
" class="logoin_tck_fw">�������룿</a>
    </div>

	<input type="hidden" id="login_codekind" value="0" />
	<?php }?>

   <div class="logoin_tck_t_list" >
    <div class="logoin_tck_tit">&nbsp;</div>
      <div id="msg"></div>
    
    <input type="hidden" id="login_usertype" />
    <input id="loginsubmit" class="logoin_tck_submit" type="button" name="loginsubmit" onclick="checkajaxlogin('vcode_img')" value="��¼" ></div>
  </div>
   </div>
  <div class="logoin_tck_right" style="margin-top: 35px;padding-left: 20px;">
    <div class="logoin_tck_reg">��û���˺ţ�<a href="" id="onregister" target="_blank" class="Orange">����ע��</a></div>
  </div>
</div>
<?php echo '<script'; ?>
>
function showlogin(usertype){
	$("#login_usertype").val(usertype);
	if(usertype==1 || usertype==""){
		var url='<?php echo smarty_function_url(array('m'=>'register','usertype'=>1,'type'=>1),$_smarty_tpl);?>
';
	}else if(usertype==2){
		var url='<?php echo smarty_function_url(array('m'=>'register','usertype'=>2,'type'=>1),$_smarty_tpl);?>
';
	}else if(usertype==3){
		var url='<?php echo smarty_function_url(array('m'=>'lietou','c'=>'register'),$_smarty_tpl);?>
';
	}else if(usertype==4){
		var url='<?php echo smarty_function_url(array('m'=>'train','c'=>'register'),$_smarty_tpl);?>
';
	}
	$("#onregister").attr("href",url);
	$.layer({
		type : 1,
		title :'���ٵ�¼', 
		closeBtn : [0 , true],
		offset:['20%','30%'],
		border : [10 , 0.3 , '#000', true],
		area : ['580px','300px'],
		page : {dom :"#onlogin"}
	});
}
function checkajaxlogin(img){
	var username = $.trim($("#login_username").val());
	var password = $.trim($("#login_password").val());
	var usertype = $.trim($("#login_usertype").val());
	var geetest_challenge;
	var geetest_validate;
	var geetest_seccode;
	var authcode;
	if(username == "" || password=="" ){
		layer.closeAll();
		layer.msg('��׼ȷ��д�û���¼��Ϣ��', 2, 8,function(){showlogin(usertype);});return false;
	}
	var code_kind='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';
	var code_web='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
';
	var codesear=new RegExp('ǰ̨��¼');
	if(codesear.test(code_web)){

		if(code_kind=='1'){
			authcode=$.trim($("#login_authcode").val());  
			if(authcode==''){
				layer.closeAll();
				layer.msg('����д��֤�룡', 2, 8,function(){showlogin(usertype);});return false;
			}	
		}else if(code_kind=='3'){

			var geetest_challenge = $('input[name="geetest_challenge_publiclogin"]').val();
			var geetest_validate = $('input[name="geetest_validate_publiclogin"]').val();
			var geetest_seccode = $('input[name="geetest_seccode_publiclogin"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				
				$("#popup-submit-publiclogin").trigger("click");
				layer.msg('������ť������֤��', 2, 8,function(){showlogin(usertype);});
				return false;
			}
		
		}
	}
	layer.load('��¼��,���Ժ�...');

	$.post("<?php echo smarty_function_url(array('m'=>'login','c'=>'loginsave'),$_smarty_tpl);?>
",{comid:1,username:username,password:password,authcode:authcode,usertype:usertype,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_seccode},function(data){
		layer.closeAll(); 
		var jsonObject = eval("(" + data + ")"); 
		if(jsonObject.error == '3'){//UC��¼���� 
			$('#uclogin').html(jsonObject.msg);
			setTimeout("window.location.href='"+jsonObject.url+"';",500); 
		}else if(jsonObject.error == '2'){//UC��¼�ɹ� 
			$('#uclogin').html(jsonObject.msg); 
			setTimeout("location.reload();",500); 
		}else if(jsonObject.error == '1'){//������¼�ɹ� 
			if ( $("#finderusertype").length > 0 ) {//����������ʾ��������������
				var finderusertype=$("#finderusertype").val();
				var finderparas=$("#finderparas").val();
				addfinder(finderparas,finderusertype,1);
			}else{
				location.reload();return false; 
			} 
		}else if(jsonObject.error == '0'){//��¼ʧ�ܻ���Ҫ��˵���ʾ 

			if(codesear.test(code_web)){
				if(code_kind=='1'){

		    	checkCode(img);

				}else if(code_kind=='3'){
				
					$("#popup-submit-publiclogin").trigger("click");
				
				}
			}
			layer.msg(jsonObject.msg, 2, 8,function(){showlogin(usertype);});
		   
		    return false;
			
		}
	});
}
$(document).ready(function(){


var handlerPopupLogin = function (captchaObj) {
	// �ɹ��Ļص�
	
	captchaObj.onSuccess(function () {

		var validate = captchaObj.getValidate();
		
		if(validate){
			$("input[name='geetest_challenge_publiclogin']").val(validate.geetest_challenge);
			$("input[name='geetest_validate_publiclogin']").val(validate.geetest_validate);
			$("input[name='geetest_seccode_publiclogin']").val(validate.geetest_seccode);
		}

	});
	$("#popup-submit-publiclogin").click(function(){
		
		$("input[name='geetest_challenge_publiclogin']").val('');
		$("input[name='geetest_validate_publiclogin']").val('');
		$("input[name='geetest_seccode_publiclogin']").val('');
		
		captchaObj.reset();
	});
	
	captchaObj.appendTo("#popup-captcha-publiclogin");

};

if($("#popup-captcha-publiclogin").length>0){
	$.ajax({
			url: weburl+"/?m=geetest&t=" + (new Date()).getTime(),
			type: "get",
			dataType: "json",
			success: function (data) {
			
				initGeetest({
					gt: data.gt,
					challenge: data.challenge,
					product: "popup",
					width:"100%",
					offline: !data.success,
					new_captcha: data.new_captcha
				}, handlerPopupLogin);
			}
	});
}
	var setval;
	$('.wxcode_login').click(function(data){
		
		$('.wxcode_login').hide();
		$('.normal_login').show();
		$('#login_normal').hide();
		$('.wx_login_show').show();
		$.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'wxlogin'),$_smarty_tpl);?>
',{t:1},function(data){
			if(data==0){
				$('#wx_login_qrcode').html('��ά���ȡʧ��..');
			}else{
				$('#wx_login_qrcode').html('<img src="'+data+'" width="100" height="100">');
				setval = setInterval("wxorderstatus()", 2000); 
			}
		});

	});
	$('.normal_login').click(function(data){
	
		$('.wxcode_login').show();
		$('.normal_login').hide();
		$('#login_normal').show();
		$('.wx_login_show').hide();
		clearInterval(setval);
	});
});
function wxorderstatus() { 
	$.post('<?php echo smarty_function_url(array('m'=>'login','c'=>'getwxloginstatus'),$_smarty_tpl);?>
',{t:1},function(data){
		
		var data=eval('('+data+')');
		if(data.url!='' && data.msg!=''){
			layer.msg(data.msg, 2, 9,function(){window.location.href=data.url;});
		}else if(data.url){
			
			window.location.href='';
		}
	});
}
<?php echo '</script'; ?>
><?php }} ?>
