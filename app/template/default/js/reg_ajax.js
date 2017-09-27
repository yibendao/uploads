function checkreg(type){
	$(".reg_cur").removeClass("reg_cur");
	$("#reg"+type).addClass("reg_cur");
	$("#regtype"+type).show();
	if(type=="1"){
		$("#regtype2").hide();
		$("#regtype3").hide();
	}else if(type=="2"){
		$("#regtype1").hide();
		$("#regtype3").hide();
	}else{
		$("#regtype1").hide();
		$("#regtype2").hide();
		$("#reg2").addClass("reg_cur");
	}
}
function uppassword(id){
	var password = $("#password"+id).val();
	S_level=checkStrong(password);
	switch(S_level) { 
	case 0:
		$(".psw_span").removeClass("psw_span_cur");
	break; 
	case 1:
		$("#pass1_"+id).addClass("psw_span_red");
		$("#pass2_"+id).removeClass("psw_span_yellow");
		$("#pass3_"+id).removeClass("psw_span_green");
	break; 
	case 2: 
		$("#pass1_"+id).removeClass("psw_span_red");
		$("#pass2_"+id).addClass("psw_span_yellow");
		$("#pass3_"+id).removeClass("psw_span_green");
	break; 
	default: 
		$("#pass1_"+id).removeClass("psw_span_red");
		$("#pass2_"+id).removeClass("psw_span_yellow");
		$("#pass3_"+id).addClass("psw_span_green");
	} 
}

function checkStrong(sPW){
	if (sPW.length<=4) 
	return 0; 
	Modes=0; 
	for (i=0;i<sPW.length;i++){
	Modes|=CharMode(sPW.charCodeAt(i)); 
	}
	return bitTotal(Modes); 
} 
function CharMode(iN){ 
	if (iN>=48 && iN <=57) 
	return 1; 
	if (iN>=65 && iN <=90)
	return 2; 
	if (iN>=97 && iN <=122) 
	return 4; 
	else 
	return 8; 
} 

function bitTotal(num){ 
	modes=0; 
	for (i=0;i<4;i++){ 
	if (num & 1) modes++; 
	num>>>=1; 
	} 
	return modes; 
} 

function get_def_email(email,type){
	var def=$("#def").val();
	if(def==email || $("#event").val()==13){
		return false;
	}
	if(email==""){
		$(".reg_email_box").hide();
		return false;
	}
	$.post("index.php?m=ajax&c=def_email",{email:email,type:type},function(data){
		var data=data.split("##");
		if(data[0]>0){
			$(".reg_email_box").html(data[1]);
			$(".reg_email_box").show();
			$("#def").val(email);
			$("#default").val(0);
			$("#allnum").val(data[0]);
		}
	})
}
function hover_email(id){
	$(".reg_email_box_list_hover").removeClass("reg_email_box_list_hover");
	$(".email"+id).addClass("reg_email_box_list_hover");
	$("#default").val(id);
}
function click_email(id,type){
	var email=$(".email"+id).html();
	email=email.replace('<span class="eg_email_box_list_left">','');
	email=email.replace('</span>','');
	email=email.replace('<SPAN class=eg_email_box_list_left>','');
	email=email.replace('</SPAN>','');
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(myreg.test(email)){
		$("#email"+type).val(email);
	}else{
		$("#email"+type).val('');
	}
	$("#email"+type).val(email);
	$(".reg_email_box").hide();
	reg_checkAjax("email"+type);
}

function keyDown(event) {
	var aevt=event;
	var evt = (aevt) ? aevt : ((window.event) ? window.event : ""); 
	var key = evt.keyCode?evt.keyCode:evt.which; 
    if (key==38){//上
		var def=$("#default").val();
		if(def>0){
			var num=parseInt(def)-1;
			$("#default").val(num);
			$(".reg_email_box_list_hover").removeClass("reg_email_box_list_hover");
			$(".email"+num).addClass("reg_email_box_list_hover");
		}
	}
    if (key==40){//下
		var def=$("#default").val();
		var num=parseInt(def)+1;
		var allnum=$("#allnum").val();
		if(num<allnum){
			$("#default").val(num);
			$(".reg_email_box_list_hover").removeClass("reg_email_box_list_hover");
			$(".email"+num).addClass("reg_email_box_list_hover");
		}
	}
    if (key==13){//回车
		var type=$(".reg_email_box_list_hover").attr("aid");
		var email=$(".reg_email_box_list_hover").html();
		if(email){
			email=email.replace('<span class="eg_email_box_list_left">','');
			email=email.replace('</span>','');
			email=email.replace('<SPAN class=eg_email_box_list_left>','');
			email=email.replace('</SPAN>','');
			$("#event").val('13');
			var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			if(myreg.test(email)){
				$("#email"+type).val(email);
			}else{
				$("#email"+type).val('');
			}
			$(".reg_email_box").hide();
			reg_checkAjax("email"+type);
			setTimeout(function (){ $("#event").val('1');},1000);
		}
	}
}
$(function(){
	$('body').click(function(evt){
		if($(evt.target).parents("#defemail1").length==0 && evt.target.id != "defemail1") {
			$('#defemail1').hide();
		}
		if($(evt.target).parents("#defemail2").length==0 && evt.target.id != "defemail2") {
			$('#defemail2').hide();
		}
	})
})
document.onkeydown = keyDown;

function reg_checkAjax(id){
	var obj = $.trim($("#"+id).val());
	var msg; 
	if(id=="username1"){
		if(obj==""){
			
			msg='用户名不能为空！';
			update_html(id,"0",msg); 
		}else if(obj.length<2||obj.length>16){
			msg='请输入2至16位不包含特殊字符的用户名！';
			update_html(id,"0",msg);
		}else{	
			$.post("index.php?m=register&c=ajaxreg",{username:obj},function(data){
				if(data==0){	
					msg='填写正确！';
					update_html(id,"1",msg);
				}else{
					if(data==1){
						msg="用户名已存在！";
					}else if(data==2){
						msg="用户名不得包含特殊字符！";
					}else if(data==3){
						msg="该用户名已被禁止注册！";
					} 
					update_html(id,"0",msg);
				}
			});	
		}
	}
	if(id=="password1" || id=="password2" || id=="password3"){
	
		if(obj==""){
			 msg='密码不能为空！';
			 update_html(id,"0",msg);
		 }else if(obj.length<6 || obj.length>20 ){
			 msg='只能输入6至20位密码！';
			update_html(id,"0",msg);
		 }else{
			 msg='输入正确！';
			 update_html(id,"1",msg);
		 }
	}
	if(id=="passconfirm1" || id=="passconfirm2" || id=="passconfirm3"){
		if(obj==""){
			 msg='确认密码不能为空！';
			 update_html(id,"0",msg);
		 }else if(obj.length<6 || obj.length>20 ){
			 msg='只能输入6至20位密码！';
			update_html(id,"0",msg);
		 }else{
			 if(id == "passconfirm1"){
				var password = $('#password1').val();
			 }
			 if(id == "passconfirm2"){
				var password = $('#password2').val();
			 }
			 if(id == "passconfirm3"){
				var password = $('#password3').val();
			 }
			 if(obj!=password){
				msg='两次输入密码不一致！';
				update_html(id,"0",msg);
			 }else{
				msg='输入正确！';
				update_html(id,"1",msg);
			 }			
		 }  
	}
	if(id=="email1"||id=="email3"){
	    var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(obj==""){
			 msg='邮箱不能为空！';
			 update_html(id,"0",msg);
		 }else if(!myreg.test(obj)){
			msg="邮箱格式错误！";
			update_html(id,"0",msg);
	     }else{ 
			 $.post("index.php?m=register&c=ajaxreg",{email:obj},function(data){
				if(data==0){
					$("#def"+id).hide();
					msg="输入成功！";
					update_html(id,"1",msg);
				}else{
					msg="邮箱已被使用！";
					update_html(id,"0",msg);
				}
			});
		}
	}
	if(id=="moblie" || id=="linkphone" || id=="usertel"){
		var reg= /^[1][034578]\d{9}$/;
		if(obj==''){
			msg="手机号不能为空！";
			 update_html(id,"0",msg);
		}else if(!reg.test(obj)){
			msg="手机号码格式错误！";
			 update_html(id,"0",msg);
		 }else{
			$.post("index.php?m=register&c=regmoblie",{moblie:obj},function(data){
				if(data==0){	
					msg='填写正确！';
					update_html(id,"1",msg); 
				}else{
					if(data==1){
						msg="号码已存在！";
					}else if(data==2){
						msg="该手机号已被禁止使用！";
					} 
					update_html(id,"0",msg);
 				}
			});	
		 }
	}
	if(id=="moblie_code"){
		 if(obj==""){
			msg="短信验证码不能为空！";
			 update_html(id,"0",msg);
		 }else{
			msg="输入成功！";
			update_html(id,"1",msg); 
		 }
	}
	if(id=="name"){
		 if(obj==""){
			msg="真实姓名不能为空!";
			update_html(id,"0",msg);
		 }else{
			msg="输入成功！";
			update_html(id,"1",msg); 
		 }
	}
	if(id=="unit_name"){
		 if(obj==""){
			msg="公司名称不能为空！";
			update_html(id,"0",msg);
		 }else{
			 $.post("index.php?m=register&c=checkcomname",{unit_name:obj},function(data){
				if(data==0){	
					msg='输入成功！';
					update_html(id,"1",msg);

				}else if(data==1){
					
					
					msg="公司名称已被使用！";
					
					update_html(id,"0",msg);
				}
			});
		 }
	}
	if(id=="linkman"){
		 if(obj==""){
			msg="联系人不能为空！";
			 update_html(id,"0",msg);
		 }else{
			msg="输入成功！";
			update_html(id,"1",msg);
		 }
	}
	if(id=="address"){
		 if(obj==""){
			msg="公司地址不能为空！";
			 update_html(id,"0",msg);
		 }else{
			msg="输入成功！";
			update_html(id,"1",msg);
		 }
	}
	if(id=="CheckCode"){
		if(obj==""){
			msg="请输入验证码！";
			 update_html(id,"0",msg);
		 }else{
			msg="输入成功！";
			update_html(id,"1",msg);
		 }
	}else if(id=="unlock"){
		if(obj=="0"){
			msg="请点击按钮进行验证！";
			 update_html(id,"0",msg);
		 }else{
			msg="完成验证！";
			update_html(id,"1",msg);
		 }
	}
}
function update_html(id,type,msg){
	$("#ajax_"+id).show();
	$("#ajax_"+id).html('<i class="reg_tips_icon"></i>'+msg); 
	if(type=="0"){  
		$("#ajax_"+id).attr("class","reg_tips reg_tips_red");
		$("#"+id).addClass("logoin_text_focus");
		$("#"+id).attr('date','0');
		return false;
	}else{ 
		$("#ajax_"+id).attr("class","reg_tips reg_tips_blue");
		$("#"+id).removeClass("logoin_text_focus");
		$("#"+id).attr('date','1');
	}
}
function showpw(id){
	if($("#showpw"+id).html()=="显示密码"){
		PasswordToText("password"+id);
		$("#showpw"+id).html('隐藏密码');
	}else{
		TextToPassword("password"+id);
		$("#showpw"+id).html('显示密码');
	}
}
function TextToPassword(name){
	var control=document.getElementById(name);
	var newpassword = document.createElement("input");
	newpassword.type="password";
	newpassword.id=control.id;
	newpassword.value=control.value;
	newpassword.setAttribute("class",control.getAttribute("class"));
	newpassword.setAttribute("className",control.getAttribute("className"));
	newpassword.setAttribute("onblur",control.getAttribute("onblur"));
	newpassword.setAttribute("onkeyup",control.getAttribute("onkeyup"));
	setTimeout('document.getElementById("'+control.id+'").focus()',200);
	$("#"+name).replaceWith(newpassword);
}
function PasswordToText(name){
	var control=document.getElementById(name);
	var newpassword = document.createElement("input");
	newpassword.type="text";
	newpassword.id=control.id;
	newpassword.value=control.value;
	newpassword.setAttribute("class",control.getAttribute("class"));
	newpassword.setAttribute("className",control.getAttribute("className"));
	newpassword.setAttribute("onblur",control.getAttribute("onblur"));
	newpassword.setAttribute("onkeyup",control.getAttribute("onkeyup"));
	$("#"+name).replaceWith(newpassword);
}
function showtip(id){
	$("#tip"+id).show();
}
function hidetip(id){
	$("#tip"+id).hide();
}
function sendmsg(img){
	reg_checkAjax("moblie");
	var date=$("#moblie").attr("date");
	var send=$("#send").val();
	var moblie=$("#moblie").val();
	var geetest_challenge='';
	var geetest_validate='';
	var geetest_seccode = '';
	var code = '';
	
	if(!moblie){
		layer.msg('手机不能为空！', 2, 8);return false;
	} 
	if(code_kind==1){
		if($("#CheckCode").length>0){
			code=$.trim($("#CheckCode").val());  
			if(!code){
				layer.msg('图片验证码不能为空！', 2, 8);return false;
			}	
	    } 
	}else if(code_kind==3){
		geetest_challenge = $('input[name="geetest_challenge"]').val();
		geetest_validate = $('input[name="geetest_validate"]').val();
		geetest_seccode = $('input[name="geetest_seccode"]').val();
		if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){

			$("#popup-submit").trigger("click");
			layer.msg('请点击按钮进行验证！', 2, 8);return false;
			return false;
		}
	}
	if(send>0){ 
		layer.msg('请不要频繁重复发送！', 2, 8);return false;  
	}
	if(date==1 && send==0){
		layer.load('执行中，请稍候...',0);
		$.post(weburl+"/index.php?m=ajax&c=regcode",{
			moblie:moblie,
				code:code,
				geetest_challenge:geetest_challenge,
				geetest_validate:geetest_validate,
				geetest_seccode:geetest_seccode
				},function(data){ 
			layer.closeAll();
			if(data==0){
				layer.msg('手机不能为空！', 2, 8,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$('input[name="geetest_challenge"]').val();
						$('input[name="geetest_validate"]').val();
						$('input[name="geetest_seccode"]').val();
					}
				});return false; 
			}else if(data==1){
				layer.msg('同一手机号一天发送次数已超！', 2, 8,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$('input[name="geetest_challenge"]').val();
						$('input[name="geetest_validate"]').val();
						$('input[name="geetest_seccode"]').val();
					}
				});
			}else if(data==2){
				layer.msg('同一IP一天发送次数已超！', 2, 8,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$('input[name="geetest_challenge"]').val();
						$('input[name="geetest_validate"]').val();
						$('input[name="geetest_seccode"]').val();
					}
				});
			}else if(data==3){
				layer.msg('短信还没有配置，请联系管理员！', 2, 8,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$('input[name="geetest_challenge"]').val();
						$('input[name="geetest_validate"]').val();
						$('input[name="geetest_seccode"]').val();
					}
				});return false; 
			}else if(data==4){
				layer.msg('请不要频繁重复发送！', 2, 8,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$('input[name="geetest_challenge"]').val();
						$('input[name="geetest_validate"]').val();
						$('input[name="geetest_seccode"]').val();
					}
				});return false; 
			}else if(data==5){
				layer.msg('图片验证码错误！', 2, 8,function(){checkCode(img);});return false; 
			}else if(data==6){
				$('input[name="geetest_challenge"]').val();
				$('input[name="geetest_validate"]').val();
				$('input[name="geetest_seccode"]').val();
			}else if(data=="发送成功!"){
				sendtime("121"); 
			}else{
				layer.msg(data, 2, 8,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$('input[name="geetest_challenge"]').val();
						$('input[name="geetest_validate"]').val();
						$('input[name="geetest_seccode"]').val();
					}
				});return false; 
			}
		})
	}
}
function sendtime(i){
	i--;
	if(i==-1){
		$("#time").html("重新获取");
		$("#send").val(0)
	}else{
		$("#send").val(1)
		$("#time").html(i+"秒");
		setTimeout("sendtime("+i+");",1000);
	}
}
function exitsid(id){
	if(document.getElementById(id)){
		return true;
	}else{
		return false;
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
function check_user(id,img){
	var email;
	var moblie;
	var moblie_code;
	var authcode;
	var unit_name;
	var address;
	var linkman;
	var name;
	var username;
	var usertype=$("#usertype").val();	
	var arrayObj = new Array();
	var telphone;
	var areacode;
	var exten;
	var geetest_challenge;
	var geetest_validate;
	var geetest_seccode;
	if(id=="1"){
		username=$.trim($("#username1").val());
		arrayObj.push('username1');
		reg_checkAjax("username1");
		reg_checkAjax("password1");
		password = $.trim($("#password1").val());
		arrayObj.push('password1');
		if(exitsid("passconfirm1")){
			reg_checkAjax("passconfirm1");
			arrayObj.push('passconfirm1');
		}

		if(exitsid("email1")){
			reg_checkAjax("email1");
			email = $.trim($('#email1').val());
			arrayObj.push('email1');
		}
		if(usertype=="2"){
			telphone=$.trim($("#telphone").val());
			if(telphone=="固定电话"){
				telphone='';
			}
			areacode=$.trim($("#areacode").val());
			if(areacode=='如：0527'){
				areacode='';
			}
			exten=$.trim($("#exten").val());
			if(exten=='分机号'){
				exten='';
			}
			if(exitsid("unit_name")){
				reg_checkAjax("unit_name");
				unit_name = $.trim($('#unit_name').val());
				arrayObj.push('unit_name');
			}
			if(exitsid("address")){
				reg_checkAjax("address");
				address = $.trim($('#address').val());
				arrayObj.push('address');
			}
			if(exitsid("linkphone")){
				reg_checkAjax("linkphone");
				moblie = $.trim($('#linkphone').val());
				arrayObj.push('linkphone');
			}
			if(exitsid("linkman")){
				reg_checkAjax("linkman");
				linkman = $.trim($('#linkman').val());
				arrayObj.push('linkman');
			}
			
		}else if(usertype=='1'){
			if(exitsid("name")){
				reg_checkAjax("name");
				name = $.trim($('#name').val());
				arrayObj.push('name');
			}
			if(exitsid("usertel")){
				reg_checkAjax("usertel");
				moblie = $.trim($('#usertel').val());
				arrayObj.push('usertel');
			}
		}
		
	}else if(id=="2"){
			reg_checkAjax("moblie");
			moblie = $.trim($('#moblie').val());
			var username=moblie;
			arrayObj.push('moblie');
			if(exitsid("passconfirm2")){
				reg_checkAjax("passconfirm2");
				arrayObj.push('passconfirm2');
			}
			if(exitsid("password2")){
				reg_checkAjax("password2");
				password = $.trim($('#password2').val());
				arrayObj.push('password2');
			}
			if(exitsid("moblie_code")){
				reg_checkAjax("moblie_code");
				arrayObj.push('moblie_code');
				moblie_code=$.trim($("#moblie_code").val());
			}
	}else if(id=="3"){
		reg_checkAjax("email3");
		email=$.trim($("#email3").val());
		var username=email;
		arrayObj.push('email3');
		reg_checkAjax("password3");
		password = $.trim($('#password3').val());
		arrayObj.push('password3');
		if(exitsid("passconfirm3")){
			reg_checkAjax("passconfirm3");
			arrayObj.push('passconfirm3');
		}
	}
	if(exitsid("CheckCode")){
			reg_checkAjax("CheckCode");
			arrayObj.push('CheckCode');
	}
	for(i=0;i<arrayObj.length;i++){
		if(!exitsdate(arrayObj[i])){
			return false;
		}
	}
	var codesear=new RegExp('注册会员');
	if(codesear.test(code_web)){
		if(code_kind==1){
			authcode=$("#CheckCode").val();
			if(authcode==''){
				return false;
			}
		}else if(code_kind==3){
			geetest_challenge = $('input[name="geetest_challenge"]').val();
			geetest_validate = $('input[name="geetest_validate"]').val();
			geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layer.msg('请点击按钮进行验证！', 2, 8);return false;
			}
		}
	}
	var loadi = layer.load('正在注册……',0);
	if($("#xieyi"+id).attr("checked")!='checked'){  
		layer.msg('您必须同意注册协议才能成为本站会员！', 2, 8);return false;  
	}else{
		$.post(weburl+"/index.php?m=register&c=regsave",{
				username:username,
				password:password,
				email:email,
				moblie:moblie,
				moblie_code:moblie_code,
				unit_name:unit_name,
				address:address,
				authcode:authcode,
				usertype:usertype,
				name:name,linkman:linkman,
				codeid:id,
				telphone:telphone,
				areacode:areacode,
				exten:exten,
				geetest_challenge:geetest_challenge,
				geetest_validate:geetest_validate,
				geetest_seccode:geetest_seccode
			},function(data){

			layer.close(loadi);
			var data=eval('('+data+')');
			var status=data.status; 
			var msg=data.msg; 
			if(usertype==1){
				if(status==1){
					window.location.href=weburl+"/member/index.php?c=expect";//注册成功
				}else if(status==7){
					layer.msg(msg, 2,status,function(){window.location.href ="index.php";});return false; 
				}else{  
					layer.msg(msg, 2,status,function(){
						if(code_kind==1){
							checkCode(img);
						}else if(code_kind==3){
							$("#popup-submit").trigger("click");
						}
					});return false;
				}
			}else{
				if(status==1){								
					layer.msg(msg, 2, 9,function(){window.location.href=weburl+"/member/";}); 
				}else if(status==8){
					layer.msg(msg, 2,status,function(){
						if(code_kind==1){
							checkCode(img);
						}else if(code_kind==3){
							$("#popup-submit").trigger("click");
						}
					});return false;
				}else if(status==7){
					window.location.href ="index.php?m=register&c=ok&type=1";
				}
			}
		});
	}
}
function check_login(url,img){
	
	var username=$("#username").val();
	var password=$("#password").val();
	if($("input[name=loginname]").attr("checked")=='checked'){
		var loginname=7;
	}else{
		var loginname=0;
	}
	var path=$("#path").val();
	if(username=="" || username=="用户名"|| username=="邮箱/手机号/用户名"){ 
		$("#show_name").show();
		$("#username").focus(
		    function(){
		       $("#show_name").hide();
		    }
		);
		return false;
	}else{
	    $("#show_name").hide();
	}
	if(password==""){
		$("#show_pass").show();
		$("#password").focus(
		    function(){
			    $("#show_pass").hide();
			}
		);
		return false;
	}else{
	    $("#show_pass").hide();
	}
	var geetest_challenge='';
	var geetest_validate='';
	var geetest_seccode = '';
	var authcode = '';
	var codesear=new RegExp('前台登录');
	if(codesear.test(code_web)){
		if(code_kind==1){
			if(exitsid("txt_CheckCode")){
				authcode=$("#txt_CheckCode").val();
				if(authcode==""||authcode=="验证码"){
					$("#show_code").show();
					
					$("#txt_CheckCode").focus(
						function(){
							$("#show_code").hide();
						}
					);
					return false;
				}else{
					$("#show_code").hide();
				}
			}
		}else if(code_kind==3){
			
			geetest_challenge = $('input[name="geetest_challenge"]').val();
			geetest_validate = $('input[name="geetest_validate"]').val();
			geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				
				$("#popup-submit").trigger("click");
				layer.msg('请点击按钮进行验证！', 2, 8);return false;
			}
		}
	}

	layer.load('登录中,请稍候...');
	$.post(url,{username:username,password:password,path:path,loginname:loginname,authcode:authcode,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_seccode},function(data){ 
		var jsonObject = eval("(" + data + ")"); 
		if(jsonObject.error == '3'){
			$('#uclogin').html(jsonObject.msg);
			setTimeout("window.location.href='"+jsonObject.url+"';",500); 
		}else if(jsonObject.error == '2'){
			$('#uclogin').html(jsonObject.msg); 
			setTimeout("window.location.href='"+jsonObject.url+"';",500); 
		}else if(jsonObject.error == '1'){		
			window.location.href=jsonObject.url; window.event.returnValue = false;return false;
		}else if(jsonObject.error == '0'){
			layer.msg(jsonObject.msg, 2, 8,function(){ 
				if(jsonObject.url){
					window.location.href=jsonObject.url; 
					window.event.returnValue = false;return false;
				}else{
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$("#popup-submit").trigger("click");
					
					}
				}
			}); 
			
		}
	})
}
function checktype(id){
	$(".login_box_tit>li").attr('class','');
	if(id=='login_cur'){
		$("#lilogin_fast").addClass("login_fast");
	}else{
		$("#lilogin_cur").addClass("login_cur");
	}
	$(".login_box_cont>.lgoin_box_cot").hide();
	$("#"+id).show(); 
}