function forgetpw(img){
	var username =  $.trim($("#username").val());
	if(username==""){
		layermsg('请填写你注册时的用户名或手机号或邮箱！', 2);return false;    
	}
	layer_load('执行中，请稍候...');
	$.post(wapurl+"/index.php?c=forgetpw&a=checkuser",{username:username},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		var status=data.type; 
		var msg=data.msg; 
		if(status==1){
			$("#step1").hide();
			$("#step2").show();
			$("#nav2").attr("class","flowsfrist");
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
			layermsg("用户名不存在！",2);return false;
		}else{
			layermsg(msg);return false;
		}
	});
	return true;
}
function send_str(img){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 if(sendtype!="email" && sendtype!="moblie" && sendtype!="shensu"){
		 layermsg("请选择找回密码方式！",2);return false;
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
				layermsg('请填写验证码！');return false;
			}
		}else if(code_kind==3){
			geetest_challenge = $('input[name="geetest_challenge"]').val();
			geetest_validate = $('input[name="geetest_validate"]').val();
			geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layermsg('请点击按钮进行验证！');return false;
			}
		}
	}
	 if($.trim(username)=="") {
		layermsg('请填写你注册时的用户名！', 2);return false;
	 }else{
		layer_load('执行中，请稍候...');
		$.post(wapurl+"/index.php?c=forgetpw&a=send",{username:username,uid:uid,authcode:authcode,sendtype:sendtype,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_seccode},function(data){
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
					layermsg(data.msg)
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
				layermsg("用户名不存在！");
			}else{
				layermsg(data.msg);
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
		layermsg('请填写你注册时的用户名或手机号或邮箱！', 2);return false;
	 }else{
		 layer_load('执行中，请稍候...');
		$.post(wapurl+"/index.php?c=forgetpw&a=checksendcode",{username:username,uid:uid,sendtype:sendtype,code:code},function(data){
			layer.closeAll();
			var data=eval('('+data+')');			
			if(data.type=='1'){
				$(".password_cont").hide();
				$("#step4").show();
				$('.flowsteps li:eq(2)').addClass('flowsfrist');
			}else{
				layermsg(data.msg);return false;								
		    }
			return false;
		});
	 }
}
function editpw(){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 var code=$("input[name=code_"+sendtype+"]").val();
	 var password=$.trim($("input[name=password]").val());
	 var passwordconfirm=$.trim($("input[name=passwordconfirm]").val());
	 if($.trim(username)=="") {
		layermsg('请填写你注册时的用户名或手机号或邮箱！', 2);return false;
	 }else if(password!=passwordconfirm){
		layermsg('两次输入密码不一致！', 2);return false;
	 }else if(password.length<6){
		layermsg('密码长度必须大于等于6！', 2);return false;
	 }else{
		 layer_load('执行中，请稍候...');
		$.post(wapurl+"/index.php?c=forgetpw&a=editpw",{username:username,uid:uid,sendtype:sendtype,code:code,password:password,passwordconfirm:passwordconfirm},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			layermsg(data.msg,2,function(){if(data.type=='1'){
				$(".password_cont").hide();
				$('.flowsteps li:eq(3)').addClass('flowsfrist');
				$("#step5").show();
			}});
			return false;
		});
	 }
}
function checklink(img){
	var username = $("#username").val();
	var linkman = $("#linkman").val();
	var linkphone = $("#linkphone").val();
	var linkemail = $("#linkemail").val();
	if(linkman==''){
		layermsg("请填写联系人！");return false;
	}
	if(linkphone==''){
		layermsg("请填写联系电话！");return false;
	}else if(isjsMobile(linkphone)==false && isjsTell(linkphone)==false){
		layermsg("联系电话格式错误！");return false;
	}
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(linkemail==''){
	    layermsg("请填写联系邮箱！");return false;
	}else if(!myreg.test(linkemail)){
		layermsg("邮箱格式错误！");return false;
	}
	var sendtype=$("input[name=sendtype]:checked").val();
	$.post(wapurl+"/index.php?c=forgetpw&a=checklink",{username:username,linkman:linkman,linkphone:linkphone,linkemail:linkemail,sendtype:sendtype},function(data){
			var data=eval('('+data+')');
			if(data.type==1){
				$(".password_cont").hide();
				$("#nav3").hide();
				$("#shensu_i").html('3');
				$("#shensu_e").html('申诉完成');
				$('.flowsteps li:eq(3)').addClass('flowsfrist');
				$("#finish").show();
			}else{
				checkCode(img);
			}
	});
}