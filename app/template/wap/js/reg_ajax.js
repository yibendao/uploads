function exitsid(id){
	if(document.getElementById(id))
	{
		return true;
	}else{
		return false;
	}
}
function checkRegUser(target_form) {
	var oneid=$("#regway1").val();
	var twoid=$("#regway2").val();
	var threeid=$("#regway3").val();
	var authcode;
	var geetest_challenge;
	var geetest_validate;
	var geetest_seccode;
	if(oneid==1){
		var username=$("#username").val(); 
     	if(username==''){
		   layermsg("用户名不能为空！");return false;  
	    }else if(username.length<2||username.length>20){
	    	layermsg("用户名应在2-10位字符之间！");return false;   
	    }
		var password=$("#password").val(); 
		if(password==""){
			layermsg("密码不能为空！");return false;  
		}else if(password.length<6||password.length>20){
			layermsg("密码长度应在6-20位！");return false;   
		}
		if(exitsid("passconfirm")){
			var passconfirm=$("#passconfirm").val(); 
			if(passconfirm==""){
				layermsg("确认密码不能为空！");return false;  
			}else if(password!=passconfirm){
				layermsg("两次密码不一致！");return false;  
			}
		}
		if(exitsid("email")){
			var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			var email=$("#email").val(); 
			if(email==""){
				layermsg("邮箱不能为空！");return false;  
			}else if(!myreg.test(email)){
				layermsg("邮箱格式不正确！");return false;  
			}
		}
		if(exitsid("moblie")){
			var reg= /^[1][34578]\d{9}$/; 
			var moblie=$("#moblie").val(); 
			if(moblie==""){
				layermsg("请填写手机号！");return false;  
			}else if(!reg.test(moblie)){
				layermsg("手机格式不正确！");return false;  
			}
		}
		var usertype=$("#usertype").val();
		if(usertype==1){
			if(exitsid("name")){
				var name=$("#name").val(); 
				if(name==""){
					layermsg("真实名称不能为空！");return false;  
				}
			}
		}else{
			if(exitsid("comname")){
				var comname=$("#comname").val(); 
				if(comname==""){
					layermsg("企业名称不能为空！");return false;  
				}
			}
			if(exitsid("linkman")){
				var linkman=$("#linkman").val(); 
				if(linkman==""){
					layermsg("联系人不能为空！");return false;  
				}
			}
			if(exitsid("address")){
				var address=$("#address").val(); 
				if(address==""){
					layermsg("企业地址不能为空！");return false;  
				}
			}
		}
		
		var codesear=new RegExp('注册会员');
		
		if(codesear.test(code_web)){
		
			if(code_kind==1){
				authcode=$.trim($("#checkcode").val());  
				if(!authcode){
					layermsg('图片验证码不能为空！');return false;
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
	}else if(twoid==2){
		var reg= /^[1][34578]\d{9}$/; 
	    var moblie=$("#moblie").val(); 
	    if(moblie==""){
		   layermsg("请填写手机号！");return false;  
	    }else if(!reg.test(moblie)){
		   layermsg("手机格式不正确！");return false;  
	    }
	    
		if($("#moblie_code").val()==""){
		    layermsg('短信验证码不能为空！');return false; 
	    }
		var password=$("#password2").val(); 
	    if(password==""){
		    layermsg("密码不能为空！");return false;  
	    }else if(password.length<6||password.length>20){
		    layermsg("密码长度应在6-20位！");return false;   
	    }
	    if(exitsid("passconfirm2")){
		    var passconfirm=$("#passconfirm2").val(); 
		    if(passconfirm==""){
			    layermsg("确认密码不能为空！");return false;  
		    }else if(password!=passconfirm){
			    layermsg("两次密码不一致！");return false;  
		    }
	    }
		if($("#xieyi"+twoid).attr("checked")!='checked'){  
			layermsg('您必须同意注册协议才能成为本站会员！');return false;  
		}
	}else if(threeid==3){
		var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		var email=$("#email").val(); 
		if(email==""){
			layermsg("邮箱不能为空！");return false;  
		}else if(!myreg.test(email)){
			layermsg("邮箱格式不正确！");return false;  
		}
		
		var password=$("#password3").val(); 
	    if(password==""){
		    layermsg("密码不能为空！");return false;  
	    }else if(password.length<6||password.length>20){
		    layermsg("密码长度应在6-20位！");return false;   
	    }
	    if(exitsid("passconfirm3")){
		    var passconfirm=$("#passconfirm3").val(); 
		    if(passconfirm==""){
			    layermsg("确认密码不能为空！");return false;  
		    }else if(password!=passconfirm){
			    layermsg("两次密码不一致！");return false;  
		    }
	    }
		if($("#xieyi"+threeid).attr("checked")!='checked'){  
			layermsg('您必须同意注册协议才能成为本站会员！');return false;  
		}
	    var codesear=new RegExp('注册会员');
		
		if(codesear.test(code_web)){
		
			if(code_kind==1){
				authcode=$.trim($("#checkcode").val());  
				if(!authcode){
					layermsg('图片验证码不能为空！');return false;
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
		
	}
	post2ajax(target_form);
	return false;	
}
function sendmsg(img){
	var send=$("#send").val();
	var reg= /^[1][34578]\d{9}$/;
	var moblie=$("#moblie").val();
	var code;
	var geetest_challenge;
	var geetest_validate;
	var geetest_seccode;
	var codesear=new RegExp('注册会员');
	if(moblie==""){
		layermsg("请填写手机号！");return false;  
	}
	var date=$("#moblie").attr("date");
	if(send>0){ 
		layermsg('请不要频繁重复发送！');return false;  
	}
	if(date==1 && send==0){
		if(codesear.test(code_web)){
			if(code_kind==1){
				code=$.trim($("#checkcode").val());  
				if(!code){
					layermsg('请填写图片验证码！');return false;
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
		layer_load('执行中，请稍候...');
		$.post(wapurl+"/index.php?c=ajax&a=regcode",{moblie:moblie,code:code,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_seccode},function(data){ 
			layer.closeAll();
			if(data==0){
				layermsg('手机不能为空！', 2,function(){
					if(code_kind==1){checkCode(img);
				}else if(code_kind==3){
						$("#popup-submit").trigger("click");
					}
				});
				return false; 
			}else if(data==1){
				layermsg('同一手机号一天发送次数已超！', 2,function(){
					if(code_kind==1){checkCode(img);}else if(code_kind==3){
						$("#popup-submit").trigger("click");
				}});
			}else if(data==2){
				layermsg('同一IP一天发送次数已超！', 2,function(){
					if(code_kind==1){checkCode(img);}else if(code_kind==3){$("#popup-submit").trigger("click");}});
			}else if(data==3){
				layermsg('短信还没有配置，请联系管理员！', 2,function(){
					if(code_kind==1){checkCode(img);}else if(code_kind==3){$("#popup-submit").trigger("click");}});return false; 
			}else if(data==4){
				layermsg('请不要频繁重复发送！', 2,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$("#popup-submit").trigger("click");
						}
					});return false; 
			}else if(data==5){
				layermsg('图片验证码错误！', 2,function(){checkCode(img);});return false; 
			}else if(data==6){
				$("#popup-submit").trigger("click");
				return false; 
			}else if(data=="发送成功!"){
				sendtime("121"); 
			}else{
				layermsg(data, 2,function(){
					if(code_kind==1){
						checkCode(img);
					}else if(code_kind==3){
						$("#popup-submit").trigger("click");
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
function checkreg(type){
	$(".reg_cur").removeClass("reg_cur");
	$("#reg"+type).addClass("reg_cur");
	$("#regtype"+type).show();
	if(type=="1"){
		$("#regway2").val(2);
		$("#regway3").val('');
		$("#regtype2").hide();
	}else if(type=="2"){
		$("#regway3").val(3);
		$("#regway2").val('');
		$("#regtype1").hide();
	}
}
function check_email(){
	var email=$("#email").val();
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(email==""){
		layermsg('请填写邮箱！');return false;  
	}else if(!myreg.test(email)){
		layermsg('邮箱格式错误！');return false;  
	}else{
		$.post("index.php?c=register&a=ajaxreg",{email:email},function(data){
			if(data!=0){				
				layermsg('邮箱已经被使用！');return false; 
			}
		});
	}
}
function check_moblie(){
	var moblie=$("#moblie").val();
	var reg= /^[1][34578]\d{9}$/;
	if(moblie==""){
		layermsg('请填写手机号码！');return false;  
	}else if(!reg.test(moblie)){
		layermsg('手机号码格式错误！');return false;  
	}else{
		$.post("index.php?c=register&a=regmoblie",{moblie:moblie},function(data){
			if(data==0){
				$("#moblie").attr('date','1');
			}else if(data==1){
				$("#moblie").attr('date','0');
				layermsg('手机已经被使用！');return false; 
			}else{
				$("#moblie").attr('date','0');
				layermsg('手机已经被禁止使用！');return false; 
			}
		})
	}
}
function check_username(){
	var username=$("#username").val();
	if(username==""){
		layermsg('请填写用户名！');return false;  
	}else if(username.length<2||username.length>20){
		   ("用户名应在2-20位字符之间！");return false;   
    }else{
		$.post("index.php?c=register&a=ajaxreg",{username:username},function(data){
			if(data==1){
				layermsg('用户名已存在！');return false;
			}else if(data==2){
				layermsg('用户名不得包含特殊字符！');return false;
			}else if(data==3){
				layermsg('该用户名已被禁止注册！');return false;
			} 
			if(data!=0){
				layermsg('邮箱已经被使用！');return false;
			}
		});
	}
}

function showservices(){
	$('#services').show();
}