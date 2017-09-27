function Close(id){
	$("#"+id).hide();
	$("#bg").hide();
}
 
function checked_input(id,name){
	$("#jobname").val(name);
	$("#jobid").val(id);
	$("#jobdiv").hide();
}
function checked_input2(id){
	var check_length = $("input[type='checkbox'][name='hy'][checked]").length;
	if($("#hy"+id).attr("checked")=="checked"){
			if(check_length>=5){ 
				layer.msg('�����ֻ��ѡ�������', 2, 8);
				$("#hy"+id).attr("checked",false);
			}else{
				var info = $("#hy"+id).val();
				var info_arr = info.split("+");
				$("#hy_"+id).remove();
				$("#hyname").append("<li id='hy_"+id+"'><input onclick='box_delete2("+id+");' type='checkbox' checked value='"+info+"' name='hy'>"+info_arr[1]+"</li>");
			}
	}else{
		$("#hy_"+id).remove();
	}
}
function box_delete(id){
	$("#job_"+id).remove();
	$("#zn"+id).attr("checked",false);
}
function box_delete2(id){
	$("#hy_"+id).remove();
	$("#hy"+id).attr("checked",false);
}
function input_check_show(){
	$("#jobdiv").hide();
	var skill_val = "";
	$("input[type='checkbox'][name='job'][checked]").each(function(){
	  var info = $(this).val().split("+");
	  skill_val+="<li id=\"sk"+info[0]+"\"><input onclick=\"del_type('"+info[0]+"');\" type=\"checkbox\" name=\"job[]\" checked=\"\" value="+info[0]+">"+info[1]+"</li>";
	  });
	  $("#job").html(skill_val);
}
function del_type(id){
	$("#sk"+id).remove();
}