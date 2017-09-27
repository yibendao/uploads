function getshow(id,title){
	var moblie=$("#linktel").val();
	$("input[name=moblie]").val(moblie);
	var email=$("#linkmail").val();
	$("input[name=email]").val(email);
	$.layer({
		type : 1,
		title :title,
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['500px','auto'],
		page : {dom :"#"+id}
	});
}
function sendmoblie(){
	if($("#send").val()=="1"){
		return false;
	}
	var moblie=$("input[name=moblie]").val();
	var mobile=$("input[name=mobile]").val();
	var reg= /^[1][34578]\d{9}$/; 
	if(moblie==''){
		layer.msg('手机号不能为空！',2,8);return false;
	}else if(mobile==moblie){
		layer.msg('请绑定新的号码！',2,8);return false;
	}else if(!reg.test(moblie)){
		layer.msg('手机号码格式错误！',2,8);return false;
	}  
	var i=layer.load('执行中，请稍候...',0);
	$.ajaxSetup({cache:false});
	$.post(weburl+"/member/index.php?m=ajax&c=mobliecert", {str:moblie},function(data) {
		layer.close(i);
		if(data=="发送成功!"){ 
			layer.msg('发送成功！',2,9,function(){send(121);}); 
		}else if(data==1){
			layer.msg('同一手机号一天发送次数已超！', 2, 8);
		}else if(data==2){
			layer.msg('同一IP一天发送次数已超！', 2, 8);
		}else if(data==3){
			layer.msg('短信通知已关闭，请联系管理员！',2,8);
		}else if(data==4){
			layer.msg('还没有配置短信，请联系管理员！',2,8);
		}else if(data==5){
			layer.msg('请不要重复发送！',2,8);
		}else{
			layer.msg(data,2,8);
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
function check_moblie(){
	var moblie=$("input[name=moblie]").val();
	
	if(moblie==""){ 
		layer.msg('请输入手机号码！',2,8,function(){getshow('moblie','绑定手机号码');});return false;
	}
	var code=$("#moblie_code").val();
	if(code==""){ 
		layer.msg('请输入短信验证码！',2,8,function(){getshow('moblie','绑定手机号码');});return false;
	}
	
	layer.load('执行中，请稍候...',0);
	$.ajaxSetup({cache:false});
	$.post("index.php?c=binding&act=save",{moblie:moblie,code:code},function(data){
		if(data==1){
			if($("#info").val()==1){
				$("#bdphone").html("<input type=\"text\" size=\"35\" name=\"linktel\" value=\""+moblie+"\" class=\"com_info_text\" style=\"width:250px;background:#D3D3D3;\" readonly=\"readonly\"/><a href=\"javascript:void(0)\"  onclick=\"getshow('moblie','绑定手机号码');\" class=\"com_set_a\" >重新绑定</a>");
				layer.closeAll();
				layer.msg('手机绑定成功！',2,9); 
			}else{
				layer.msg('手机绑定成功！',2,9,function(){location.reload();}); 
			}
		}else if(data==3){
			layer.msg('短信验证码不正确！',2,8,function(){$("#moblie_code").val('');});
		}else{
			layer.msg('操作出错！',2,8); 
		}
	})
}
function sendbemail(img){
	var email=$("input[name=email]").val();
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/; 
	if(email==''){
		layer.msg('邮箱不能为空！',2,8,function(){getshow('email','绑定邮箱');});return false;
	}else if(!myreg.test(email)){
		layer.msg('邮箱格式错误！',2,8,function(){getshow('email','绑定邮箱');});return false;
	}
	var authcode=$("input[name=email_code]").val();
	if(authcode==""){
		layer.msg('验证码不能为空！',2,8,function(){getshow('email','绑定邮箱');});return false;
	}
	
	layer.load('执行中，请稍候...',0);
	$.ajaxSetup({cache:false});
	$.post(weburl+"/member/index.php?m=ajax&c=emailcert",{email:email,authcode:authcode},function(data){
		if(data){
			if(data=="4"){
				layer.msg('验证码不正确！',2,8,function(){checkCode(img);});
			}
			if(data=="3"){
				layer.msg('邮件没有配置，请联系管理员！',2,8);
			}
			if(data=="2"){
				layer.msg('邮件通知已关闭，请联系管理员！',2,8);
			}
			if(data=="1"){
				if($("#info").val()==1){
					$("#bdmail").html("<input type=\"text\" size=\"35\" name=\"linkmail\" value=\""+email+"\" class=\"com_info_text\" style=\"width:250px;background:#D3D3D3;\" readonly=\"readonly\"/><a href=\"javascript:void(0)\"  onclick=\"getshow('email','绑定邮箱');\" class=\"com_set_a\" >重新绑定</a>");
					layer.closeAll();
					layer.msg('邮件已发送到您邮箱，请注意查收验证！',2,9);
				}else{
					layer.msg('邮件已发送到您邮箱，请注意查收验证！',2,9,function(){location.reload();});
				}
			}
		}else{
			layer.msg('请重新登录！',2,8,function(){window.location.href =weburl;});
		} 
	})
}
function check_company_cert(){
	if($.trim($("#company_name").val())==''){
		layer.msg('企业全称不能为空！',2,8);
		return false;
	}
	if($.trim($("#com_cert").val())==''){
		layer.msg('请上传营业执照！',2,8);
		return false;
	}
	layer.load('执行中，请稍候...',0);return true;
}
function check_user_cert(){
	if($.trim($("#idcard").val())==''){
		layer.msg('请填写身份证号码！',2,8);return false;
	}
	if(checkIdcard($.trim($("#idcard").val()))==false){
		layer.msg('请填写正确身份证号码！',2,8);return false;
	}
	if($("#user_cert").val()==''){
		layer.msg('请上传身份证照片！',2,8);return false;
	}
	layer.load('执行中，请稍候...',0);return true;
}
function getyyzz(title,width,height){
	$.layer({
		type : 1,
		title :title,
		closeBtn : [0 , true], 
		offset: ['150px', ''],
		border : [10 , 0.3 , '#000', true],
		area : [width+'px',height+'px'],
		page : {dom :"#yyzz"}
	});
}
