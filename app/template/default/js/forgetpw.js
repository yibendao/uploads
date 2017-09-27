function forgetpw(img){
	var username =  $.trim($("#username").val());
	if(username==""){
		$('#usernamemsg').html('请填写你注册时的用户名或手机号或邮箱！');
		$('#usernamemsg').show();return false;   
	}else{
		$('#usernamemsg').hide();
	}  
    layer.load('执行中，请稍候...',0);	
	$.post(weburl+"/index.php?m=forgetpw&c=checkuser",{username:username},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		var status=data.type; 
		var msg=data.msg; 
		if(status==1){
			$("#step1").hide();
			$("#step2").show();
			$("#nav2").attr("class","flowcur");
			$("#username_halt").html(data.username);
			if(data.email!=""){
				$("#email_halt").html(data.email);
			}else{
				$("#checkemail").hide();
			}
			if(data.moblie!=""){
				$("#moblie_halt").html(data.moblie);
			}else{
				$("#checkmoblie").hide();
			}
			$("input[name=uid]").val(data.uid);
		}else if(status==2){
			layer.msg("用户名不存在！",2,8);return false;
		}else{
			layer.msg(msg,2,8);return false;
		}
	});
	return true;
}
function send_str(img){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 if(sendtype!="email" && sendtype!="moblie" &&sendtype!="shensu"){
		 layer.msg("请选择找回密码方式！",2,8);return false;
	 }
	var authcode;
	var geetest_challenge;
	var geetest_validate;
	var geetest_seccode;
	var codesear=new RegExp('前台登录');
	if(codesear.test(code_web)){
		if(code_kind==1){
			authcode=$.trim($("#checkcode").val());  
			if(!authcode){
				layer.msg('请填写验证码！',2,8);return false;
			}
		}else if(code_kind==3){
			geetest_challenge = $('input[name="geetest_challenge"]').val();
			geetest_validate = $('input[name="geetest_validate"]').val();
			geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layer.msg('请点击按钮进行验证！',2,8);return false;
			}
		}
	}
	 if($.trim(username)=="") {
		layer.msg('请填写你注册时的用户名！', 2, 8);return false;
	 }else{
		 layer.load('执行中，请稍候...',0);	
		$.post(weburl+"/index.php?m=forgetpw&c=send",{username:username,uid:uid,authcode:authcode,sendtype:sendtype,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_seccode},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			if(data.type==1){
				if(sendtype=="shensu"){
					$("#password_cont").hide();
					$("#nav3").hide();
					$("#step2").hide();
					$("#shensu_i").html('3');
					$("#shensu_e").html('申诉完成');
					$("#step2_shensu").show();
				}else{
					layer.msg(data.msg,2,9)
					$(".password_cont").hide();
					$("#step3_"+sendtype).show();
					$("#step3_email_halt").html(data.email);
					$("#step3_moblie_halt").html(data.moblie);
					window.time=90;				
					window.timer=setInterval(function(){
						if(window.time<=0){
							clearInterval(window.timer);
							window.time=90;
							$('.step3_'+sendtype+'_timer').html('如需从新发送，请<a href="javascript:send_str();" class="password_a_dj ">点击免费获取</a>');
						}else{
							window.time=window.time-1;
							$('.step3_'+sendtype+'_timer').html('如需从新发送，请<a href="javascript:;" class="password_a_dj ">'+window.time+' 秒后重新获取</a>');
						}
					},1000);	
				}			
			}else if(data.type==2){
				layer.msg("用户名不存在！",2,8);
			}else{
				layer.msg(data.msg,2,8);
				if(data.type==3){
					checkCode(img);
				}
			}
			return false;
		});
	 }
}
function checksendcode(){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 var code=$("input[name=code_"+sendtype+"]").val();
	 if($.trim(username)=="") {
		layer.msg('请填写你注册时的用户名或手机号或邮箱！', 2, 8);return false;
	 }else{
		 layer.load('执行中，请稍候...',0);	
		$.post(weburl+"/index.php?m=forgetpw&c=checksendcode",{username:username,uid:uid,sendtype:sendtype,code:code},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			layer.msg(data.msg, 2,Number(data.type),function(){if(data.type=='1'){
				$(".password_cont").hide();
				$("#step4").show();
				$('.flowsteps li:eq(2)').addClass('flowcur');
			}});
			return false;
		});
	 }
}
function checklink(){
	var username = $("#username").val();
	var linkman = $("#linkman").val();
	var linkphone = $("#linkphone").val();
	var linkemail = $("#linkemail").val();
	var arrayObj = new Array();
	fg_check("linkman");
	arrayObj.push('linkman');
	fg_check("linkphone");
	arrayObj.push('linkphone');
	fg_check("linkemail");
	arrayObj.push('linkemail');
	for(i=0;i<arrayObj.length;i++){
		if(!exitsdate(arrayObj[i])){
			return false;
		}
	}
	var sendtype=$("input[name=sendtype]:checked").val();
	layer.load('执行中，请稍候...',0);	
	$.post(weburl+"/index.php?m=forgetpw&c=checklink",{username:username,linkman:linkman,linkphone:linkphone,linkemail:linkemail,sendtype:sendtype},function(data){
		layer.closeAll();
			var data=eval('('+data+')');
			if(data.type==1){
				$(".password_cont").hide();
				$("#nav3").hide();
				$("#shensu_i").html('3.');
				$("#shensu_e").html('申诉完成');
				$('.flowsteps li:eq(3)').addClass('flowcur');
				$("#finish").show();
			}
	});
}
function editpw(){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 var code=$("input[name=code_"+sendtype+"]").val();
	 var password=$.trim($("input[name=password]").val());
	 var passwordconfirm=$.trim($("input[name=passwordconfirm]").val());
	 if($.trim(username)=="") {
		layer.msg('请填写你注册时的用户名或手机号或邮箱！', 2, 8);return false;
	 }else if(password!=passwordconfirm){
		layer.msg('两次输入密码不一致！', 2, 8);return false;
	 }else if(password.length<6){
		layer.msg('密码长度必须大于等于6！', 2, 8);return false;
	 }else{
		 layer.load('执行中，请稍候...',0);	
		$.post(weburl+"/index.php?m=forgetpw&c=editpw",{username:username,uid:uid,sendtype:sendtype,code:code,password:password,passwordconfirm:passwordconfirm},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			layer.msg(data.msg, 2,Number(data.type),function(){if(data.type=='1'){
				$(".password_cont").hide();
				$('.flowsteps li:eq(3)').addClass('flowcur');
				$("#step5").show();
			}});
			return false;
		});
	 }
}
function update_html(id,type,msg){
	$("#fg_"+id).removeClass('none');
	$("#fg_"+id).html('<i class="reg_tips_icon"></i>'+msg); 
	if(type=="0"){  
		$("#fg_"+id).attr("class","reg_tips reg_tips_red");
		$("#"+id).addClass("logoin_text_focus");
		$("#"+id).attr('date','0');
		return false;
	}else{ 
		$("#fg_"+id).attr("class","reg_tips reg_tips_blue");
		$("#"+id).removeClass("logoin_text_focus");
		$("#"+id).attr('date','1');
	}
}
function fg_check(id){
	var obj = $.trim($("#"+id).val());
	var msg; 
	if(id=="linkman"){
		if(obj==""){
			msg='请填写联系人！';
			update_html(id,"0",msg); 
		}else{
			msg='填写正确！';
			update_html(id,"1",msg);
		}
	}
	if(id=="linkphone"){
		if(obj==''){
			msg="请填写联系电话！";
			update_html(id,"0",msg);
		}else if(isjsMobile(obj)==false && isjsTell(obj)==false){
			msg="联系电话格式错误！";
			update_html(id,"0",msg);
		}else{
			msg='填写正确！';
			update_html(id,"1",msg);
		}
	}
	if(id=="linkemail"){
	    var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(obj==""){
			 msg='邮箱不能为空！';
			 update_html(id,"0",msg);
		 }else if(!myreg.test(obj)){
			msg="邮箱格式错误！";
			update_html(id,"0",msg);
	     }else{
			msg='填写正确！';
			update_html(id,"1",msg);
		}
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