function sendmoblie(){
	if($("#send").val()=="1"){
		return false;
	}
	var moblie=$("input[name=moblie]").val();
	var reg= /^[1][34578]\d{9}$/; 
	if(moblie==''){
		layermsg('手机号不能为空！',2);return false;
	}else if(!reg.test(moblie)){
		layermsg('手机号码格式错误！',2);return false;
	}
	layer_load('执行中，请稍候...',0);
	$.post(wapurl+"/index.php?c=ajax&a=mobliecert", {str:moblie},function(data) {
		layer.closeAll();
		if(data=="发送成功!"){ 
			layermsg('发送成功！',2,function(){send(121);}); 
		}else if(data==1){
			layermsg('同一手机号一天发送次数已超！', 2);
		}else if(data==2){
			layermsg('同一IP一天发送次数已超！', 2);
		}else if(data==3){
			layermsg('短信通知已关闭，请联系管理员！',2);
		}else if(data==4){
			layermsg('还没有配置短信，请联系管理员！',2);
		}else if(data==5){
			layermsg('请不要重复发送！',2);
		}else{
			layermsg(data,2);
		}
	})
}
function send(i){
	i--;
	if(i==-1){
		$("#time").html("重新获取");
		$("#send").val(0)
	}else{
		$("#send").val(1)
		$("#time").html(i+"秒");
		setTimeout("send("+i+");",1000);
	}
}
function check_moblie(img){
	var moblie=$("input[name=moblie]").val();
	var authcode=$("input[name=authcode]").val();
	var code=$("#moblie_code").val();
	if(moblie==""){ 
		layermsg('请输入手机号码！',2);return false;
	}else if(code==""){ 
		layermsg('请输入短信验证码！',2);return false;
	}else if(!authcode){
		layermsg('请输入验证码！',2);return false;
	}
	layer_load('执行中，请稍候...',0);
	$.post("index.php?c=binding",{moblie:moblie,code:code,authcode:authcode},function(data){
		layer.closeAll();
		if(data==1){
			layermsg('手机绑定成功！',2,function(){window.location.href = 'index.php?c=binding'}); 
		}else if(data==3){
			layermsg('短信验证码不正确！',2);
		}else if(data==4){
			layermsg('验证码不能为空！',2);
		}else if(data==5){
			layermsg('验证码不正确！',2,function(){checkCode(img)});
		}else{
			layermsg('操作出错！',2); 
		}
	})
}
function check_email(img){
	var email=$("input[name=email]").val();
	var authcode=$("input[name=authcode]").val();
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(email==''){
		layermsg('邮箱不能为空！',2);return false;
	}else if(!myreg.test(email)){
		layermsg('邮箱格式错误！',2);return false;
	}else if(!authcode){
		layermsg('验证码不能为空！',2);return false;
	}
	layer_load('执行中，请稍候...',0);
	$.post(wapurl+"/index.php?c=ajax&a=emailcert",{email:email,authcode:authcode},function(data){
		layer.closeAll();
		if(data){
			if(data=="3"){
				layermsg('邮件没有配置，请联系管理员！',2);
			}else if(data=="2"){
				layermsg('邮件通知已关闭，请联系管理员！',2);
			}else if(data=="1"){
				layermsg('邮件已发送到您邮箱，请注意查收验证！',2,function(){window.location.href = 'index.php?c=binding'});
			}else if(data=="5"){
				layermsg('验证码不能为空！',2);
			}else if(data=="4"){
				layermsg('验证码不正确！',2,function(){checkCode(img)});
			}
		}else{
			layermsg('请重新登录！',2);
		} 
	})
}
