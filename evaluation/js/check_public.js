$(document).ready(function(){
	$(".job1").change(function(){
		var job=$(this).val();
		var lid=$(this).attr("lid");
		if(job==""){
			$("#"+lid+" option").remove()
			$("<option value=''>请选择</option>").appendTo("#"+lid);
			lid2=$("#"+lid).attr("lid");
			if(lid2){
				$("#"+lid2+" option").remove();
				$("<option value=''>请选择</option>").appendTo("#"+lid2);
			}
		}
		$.post(weburl+"/index.php?m=ajax&c=ajax_job", {"str":job},function(data) {
			if(lid!="" && data!=""){
				$('#'+lid+' option').remove();
				$(data).appendTo("#"+lid);
				job_type(lid);
			}
		})
	})
	$(".jobone").change(function(){
		var jobid=$(this).val();
		$.post(weburl+"/index.php?m=ajax&c=ajax_ltjob", {"str":jobid},function(data) {
			$("#jobtwo").html(data);
		})
	})
	$(".province").change(function(){
		var province=$(this).val();
		var lid=$(this).attr("lid");
		if(lid){ 
			if(province==""){
				$("#"+lid+" option").remove()
				$("<option value='0'>请选择城市</option>").appendTo("#"+lid);
				lid2=$("#"+lid).attr("lid");
				if(lid2){
					$("#"+lid2+" option").remove();
					$("<option value='0'>请选择城市</option>").appendTo("#"+lid2);
					$("#"+lid2).hide();
				}
			}
			$.post(weburl+"/index.php?m=ajax&c=ajax", {"str":province},function(data) {
				if(lid!="" && data!=""){
					$('#'+lid+' option').remove();
					$(data).appendTo("#"+lid);
					city_type(lid);
				}
			})
		}
	})
})

function job_type(id){
	var id;
	var job=$("#"+id).val();
	var lid=$("#"+id).attr("lid");
	$.post(weburl+"/index.php?m=ajax&c=ajax_job", {"str":job},function(data) {
		if(lid!="" && data!=""){
			$('#'+lid+' option').remove();
			$(data).appendTo("#"+lid);
		}
	})
}
function city_type(id){
	var id;
	var province=$("#"+id).val();
	var lid=$("#"+id).attr("lid");
	$.post(weburl+"/index.php?m=ajax&c=ajax", {"str[]":[province]},function(data) {
		if(lid!=""){
			if(lid!="three_cityid" && lid!="three_city" && data!=""){
				$('#'+lid+' option').remove();
				$(data).appendTo("#"+lid);
			}else{
				if(data!=""){
					$('#'+lid+' option').remove();
					$(data).appendTo("#"+lid);
					$('#'+lid).show();
				}else{
					$('#'+lid+' option').remove();
					$("<option value='0'>请选择城市</option").appendTo("#"+lid);
					$('#'+lid).hide();
				}
			}
		}
	})
}
function toDate(str){
	var sd=str.split("-");
	return new Date(sd[0],sd[1],sd[2]);
}
function check_form_job(){
	var end = $("#edate").val();
	var name = $.trim($("#name").val());
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	if($("#salary_type").attr("checked")!='checked'){
	if(minsalary==''||minsalary=='0'){
		parent.layer.msg('请填写工资！', 2, 8);return false;
	}
	if(maxsalary){
		if(parseInt(maxsalary)<=parseInt(minsalary)){
			parent.layer.msg('最高工资必须大于最低工资！', 2, 8);return false;
		}
	}
	}
	if(name==''){
		parent.layer.msg('职位名称不能为空！',2,8);return false;
	}
	if($("#job1_son").val()==''){
		parent.layer.msg('请选择职位类别！',2,8);return false;
	}

	if($("#provinceid").val()==''){
		parent.layer.msg('请选择工作地点！',2,8);return false;
	}
	var content = editor.text(); 
	if(content==""){
		parent.layer.msg('职位描述不能为空！',2,8);return false;
	}else{
		$("#content").val(content);
	}
	if(end==""){
		parent.layer.msg('结束时间不能为空！', 2, 8);return false;
	}else{
        var now = new Date();
        var year = now.getFullYear(); 
        var month = now.getMonth() + 1;
        var day = now.getDate();    
		var st=toDate(year+"-"+month+"-"+day);
		var edate=end.split("-");
		var ed=new Date(edate[0],parseInt(edate[1].replace(/\b(0+)/gi,"")),edate[2]);
		if(st>ed){
			parent.layer.msg('结束日期必须大于今天日期！', 2,8);return false;
			
		}
	}
}
function check_form_jobs(){
	var end = $("#edate").val();
	var name = $.trim($("#name").val());
	if(name==''){
		parent.layer.msg('职位名称不能为空！',2,8);return false;
	}
	
	if($("#provinceid").val()==''){
		parent.layer.msg('请选择工作地点！',2,8);return false;
	}
	if($("#number").val()==''){
		parent.layer.msg('请选择招聘人数！',2,8);return false;
	}
	if($("#sex").val()==''){
		parent.layer.msg('请选择性别！',2,8);return false;
	}
	if($("#salary").val()==''){
		parent.layer.msg('请输入薪水',2,8);return false;
	}
	if($("#salary_type").val()==''){
		parent.layer.msg('请选择薪水类型',2,8);return false;
	}
	if($("#billing_cycle").val()==''){
		parent.layer.msg('请选择结算类型',2,8);return false;
	}
	var content = editor.text(); 
	if(content==""){
		parent.layer.msg('职位描述不能为空！',2,8);return false;
	}else{
		$("#content").val(content);
	}
	if(end==""){
		parent.layer.msg('结束时间不能为空！', 2, 8);return false;
	}else{
        var now = new Date();
        var year = now.getFullYear();  
        var month = now.getMonth() + 1; 
        var day = now.getDate();    
		var st=toDate(year+"-"+month+"-"+day);
		var ed=toDate(end);
		if(st>ed){
			parent.layer.msg('结束日期必须大于今天日期！', 2, 8);return false;
		}
	}
	if($("#linkman").val()==''){
		parent.layer.msg('联系人不能为空',2,8);return false;
	}
	if($("#linktel").val()==''){
		parent.layer.msg('联系电话不能为空',2,8);return false;
	}
}