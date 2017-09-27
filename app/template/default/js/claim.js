function savepost(){
	 var username = $("#username").val();
	 var password=$.trim($("input[name=password]").val());
	 var passwordconfirm=$.trim($("input[name=passwordconfirm]").val());
	 if($.trim(username)=="") {
		layer.msg('输入新的用户名！', 2, 8);return false;
	 }else if(password.length<2 || password.length>16){
		 layer.msg('用户名长度应为2-16位！', 2, 8);return false;
	 }
	 if(password.length<6 || password.length>20){
		layer.msg('密码长度应为6-20位！', 2, 8);return false;
	 }
	 if(password!=passwordconfirm){
		layer.msg('两次输入密码不一致！', 2, 8);return false;
	 }
}