function CheckPost_part(){
	if($.trim($("#name").val())==""||$("#name").val()==$("#name").attr('placeholder')){
		layer.msg("请输入兼职名称！",2,8);return false;
	}
	if($.trim($("#typeid").val())==""&&$.trim($("#part_type_val").val())==""){
		layer.msg("请选择兼职类型！",2,8);return false;
	}
	if($.trim($("#number").val())<1||$("#number").val()==$("#number").attr('placeholder')){
		layer.msg("请输入招聘人数！",2,8);return false;
	}
	var chk_value =[];
	$('input[name="worktime[]"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	if(chk_value.length==0){
		layer.msg("请选择兼职时间！",2,8);return false;
	}
	var sdate=$("#sdate").val();
	var edate=$("#edate").val();
	var today=$("#today").val();
	var timetype=$("input[name='timetype']:checked").val();
	if(timetype){
		if(sdate==""||sdate==$("#sdate").attr('placeholder')){
			layer.msg("请选择开始日期！",2,8);return false;
		}
	}else{
		if(sdate=="" ||sdate==$("#sdate").attr('placeholder')){
			layer.msg("请选择开始日期！",2,8);return false;
		} 
		if(edate==""||edate==$("#edate").attr('placeholder')){
			layer.msg("请选择结束日期！",2,8);return false;
		} 
		if(toDate(edate).getTime()<toDate(sdate).getTime() || toDate(edate).getTime()<toDate(today).getTime()){
			layer.msg("请正确选择工作日期！",2,8);return false;
		}
	}	
	if(!timetype){
		var end=$("#deadline").val();
		var st=toDate(today).getTime();
		var ed=toDate(end).getTime();
		if(end==''||end==$("#deadline").attr('placeholder')){
			layer.msg("请选择报名截止时间！",2,8);return false;
		}else if(ed<=st){ 
			layer.msg("报名截止时间不能小于当前时间！",2,8);return false;
		}			
	}
	if($.trim($("#salary").val())==""||$.trim($("#salary").val())<1 ||$("#salary").val()==$("#salary").attr('placeholder')){
		layer.msg("请输入薪资水平！",2,8);return false;
	}
	if($.trim($("#salary_typeid").val())=="" && $.trim($("#user_salary_val").val())==""){
		layer.msg("请选择薪水类型！",2,8);return false;
	}
	
	if($.trim($("#billing_cycleid").val())=="" && $.trim($("#user_billing_val").val())==""){
		layer.msg("请选择结算周期！",2,8);return false;
	}
	var html = editor.text();
	if($.trim(html)==""){
		layer.msg("请输入兼职内容！",2,8);return false;
	}
	if($.trim($("#citysid").val())==""){
		layer.msg("请选择工作地点！",2,8);return false;
	}	
	if($.trim($("#address").val())==""||$("#address").val()==$("#address").attr('placeholder')){
		layer.msg("请输入详细地址！",2,8);return false;
	}
	if($.trim($("#map_x").val())==""||$.trim($("#map_y").val())==""){
		layer.msg("请选择地图！",2,8);return false;
	}		
	if($.trim($("#linkman").val())==""||$("#linkman").val()==$("#linkman").attr('placeholder')){
		layer.msg("请输入联系人！",2,8);return false;
	}
	if($.trim($("#linktel").val())==""||$("#linktel").val()==$("#linktel").attr('placeholder')){
		layer.msg("请输入联系手机！",2,8);return false;
	}
	var iftelphone = isjsMobile($.trim($("#linktel").val()));
	if(iftelphone==false){layer.msg('请正确填写联系手机！',2,8);return false;}
}
function change(){
	if($("#timetype").attr("checked")=='checked'){
		$("#edate").hide();
		$("#dline").hide();
	}else{
	    $("#dline").show();
		$("#edate").show();
	}
}