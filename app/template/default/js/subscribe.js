function check_class(id){
	$(".post_read_text_box").hide();
	$("#"+id).show();
}
function check_input(id,name,type){
	$("#button_"+type).val(name);
	$("input[name="+type+"]").val(id);
	$("#"+type).hide();
	if(type=="provinceid"){
		$.post("index.php?m=ajax&c=getcity_subscribe",{id:id,type:'cityid'},function(data){
			$("#cityid").html(data);
			$("#cityid_list").show();
		})
		$("input[name=cityid]").val('');
		$("input[name=three_cityid]").val('');
		$("#button_cityid").val('请选择');
		$("#button_three_cityid").val('请选择');
		$("#cityid").html('');
		$("#three_cityid").html('');
		$('#three_cityid_list').hide();
	}else if(type=="cityid"){
		$.post("index.php?m=ajax&c=getcity_subscribe",{id:id,type:'three_cityid'},function(data){
			if(data){
				$("#three_cityid").html(data);
				$("#three_cityid_list").show();
			}
			
		})
		$("input[name=three_cityid]").val('');
		$("#button_three_cityid").val('请选择');
		$("#three_cityid").html('');
	}else if(type=="job1"){
		$.post("index.php?m=ajax&c=getjob_subscribe",{id:id,type:'job1_son'},function(data){
			$("#job1_son").html(data);
			$("#job1_sonlist").show();
		})
		$("input[name=job1_son]").val('');
		$("input[name=job_post]").val('');
		$("#button_job1_son").val('请选择');
		$("#button_job_post").val('请选择');
		$("#cityid").html('');
		$("#job_post").html('');
	}else if(type=="job1_son"){
		$.post("index.php?m=ajax&c=getjob_subscribe",{id:id,type:'job_post'},function(data){
			$("#job_post").html(data);
			$("#job_post_list").show();
		})
		$("input[name=job_post]").val('');
		$("#button_job_post").val('请选择');
		$("#job_post").html('');
	}
}
function checktype(type){
	$.post("index.php?m=ajax&c=getsalary_subscribe",{type:type},function(data){
		$("#salary").html(data);
		$("input[name=salary]").val('');
		$("#button_salary").val('请选择');
	})
}
function clear_form(){
	$("input[name=email]").val('请输入接收邮箱');
	$("input[name=provinceid]").val('');
	$("input[name=cityid]").val('');
	$("input[name=three_cityid]").val('');
	$("input[name=job1]").val('');
	$("input[name=job1_son]").val('');
	$("input[name=job_post]").val('');
	$("input[name=salary]").val('');
	$("input[name=cycle_time]").val('');
	$("#button_provinceid").val('请选择');
	$("#button_cityid").val('请选择');
	$("#button_three_cityid").val('请选择');
	$("#button_job1").val('请选择');
	$("#button_job1_son").val('请选择');
	$("#button_job_post").val('请选择');
	$("#button_salary").val('请选择');
	$("#button_cycle_time").val('请选择');
}
function send_email(email){
	layer.load('执行中，请稍候...',0);
	$.post("index.php?m=subscribe&c=send_email",{email:email},function(data){
		if(data==1){
			layer.msg('发送成功！', 2, 9);
		}else{
			layer.msg('发送失败！', 2, 8);
		}
	})
}
function checksub(){
	var job_post=$("input[name=job_post]").val();
	var provinceid=$("input[name=provinceid]").val();
	var email=$("input[name=email]").val();
	var min=$("input[name=minsalary]").val();
	var max=$("input[name=maxsalary]").val();
	var time=$("input[name=time]").val();
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/; 
	if(job_post==""){
		layer.msg('请选择职位类别 ',2,8);return false;
	}
	if(cityid==""){
		layer.msg('请选择工作地点',2,8);return false;
	}
	if(min==""||min==0){
		layer.msg('请填写月薪范围',2,8);return false;
	}
	if(max&&parseInt(max)<parseInt(min)){
		layer.msg('最高月薪必须大于最低月薪',2,8);return false;
	}
	if(email==""){
		layer.msg('请输入接收邮件',2,8);return false;
	}
	if(email&&!myreg.test(email)){
		layer.msg('邮件格式不正确',2,8);return false;
	}
	if(time==""){
		layer.msg('请选择发送周期',2,8);return false;
	}
	layer.load('执行中，请稍候...',0);
}

$(function () {
    
    $('body').click(function (evt) {
    
	if($(evt.target).parents("#job1").length==0 && evt.target.id != "button_job1") {
	   $('#job1').hide();
	}
	if($(evt.target).parents("#job1_son").length==0 && evt.target.id != "button_job1_son") {
	   $('#job1_son').hide();
	}
	if($(evt.target).parents("#job_post").length==0 && evt.target.id != "button_job_post") {
	   $('#job_post').hide();
	}
	
	if($(evt.target).parents("#provinceid").length==0 && evt.target.id != "button_provinceid") {
	   $('#provinceid').hide();
	}
	if($(evt.target).parents("#cityid").length==0 && evt.target.id != "button_cityid") {
	   $('#cityid').hide();
	}
	if($(evt.target).parents("#three_cityid").length==0 && evt.target.id != "button_three_cityid") {
	   $('#three_cityid').hide();
	}
	if($(evt.target).parents("#salary").length==0 && evt.target.id != "button_salary") {
	   $('#salary').hide();
	}
	if($(evt.target).parents("#cycle_time").length==0 && evt.target.id != "button_cycle_time") {
	   $('#cycle_time').hide();
	}
   });
});