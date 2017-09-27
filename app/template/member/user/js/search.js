$(document).ready(function(){	
	$('.delete').live('click',function(){		
		var id = $(this).attr('data-id');
		var pid = $(this).attr('data-pid');
		if(parseInt(pid)>0)	{
			unsel(id,pid);
		}else{			
			unsel(id)	
		}	
	});	
});
function showcity(id){
	$("#td_city"+id).attr("class","focusItemTop mOutItem");
	$("#span_city"+id).hide();
	$("#div_city"+id).show();
}

function guanbicity(id){
   $("#td_city"+id).bind("mouseleave", function(){
	$("#td_city"+id).attr("class","blurItem");
	$("#span_city"+id).show();
	$("#div_city"+id).hide();
   });
}
function checkcity(id,name){
	$("#city").val(name);
	$("#cityid").val(id);
	 layer.closeAll();
}
function showjob(id){
	$("#td"+id).attr("class","focusItemTop mOutItem");
	$("#span"+id).hide();
	$("#div"+id).show();
}
function determine(id){
	var check_val,name_val;
	$(".selall").each(function(){ 
		var info =$(this).attr("data-val").split("+");
		check_val+=","+info[0];
		name_val+="+"+info[1];  
	});
	if(check_val){
		 check_val = check_val.replace("undefined,","");
	  $("#job_class").val(check_val);
	}
 	if(name_val){
		name_val = name_val.replace("undefined+","");
  		$("#workadds_job").val(name_val);
	}  
	layer.closeAll(); 
}
function addsel(id,pid){
	
	
	var i=0;
	$(".selall").each(function(){
		i++;
	});	
	if(parseInt(pid)>0){		
		if(i>5){
			unsel(id,pid);
			layer.msg('您最多只能选择五项！', 2,8);
			return false;			
		}else{
			var name = $('#job_class_'+id).attr('data-name');
			html = '<li class="job_class_'+id+' parent_'+pid+'"><a class="clean g3 selall" href="javascript:void(0);" data-val="'+id+'+'+name+'"><span class="text">'+name+'</span><span class="delete" data-id="'+id+'" data-pid ="'+pid+'">移除</span></a></li>';
			$('.job_class_'+id).remove();
			$('.selected').append(html);
		}
	}else{
		if(i>4){
			unsel(id);
			layer.msg('您最多只能选择五项！', 2,8);
			return false;
		}else{
			var name = $('#all'+id).attr('data-name');
			html = '<li class="all'+id+'"><a class="clean g3 selall" href="javascript:void(0);"  data-val="'+id+'+'+name+'"><span class="text">'+name+'</span><span class="delete" data-id="'+id+'">移除</span></a></li>';
			$('.parent_'+id).remove();
			$('.all'+id).remove();
			$('.selected').append(html);
		}
	}
}
function unsel(id,pid){	
	if(parseInt(pid)>0){
		$('.job_class_'+id).remove();
		$('#job_class_'+id).removeAttr("checked","");
	}else{
		$('.all'+id).remove();
		$('#all'+id).removeAttr("checked","");
		$('.label'+id).removeAttr("disabled");
		$('.label'+id).removeAttr("checked");
	}
}

function closelayer(){
	layer.closeAll();
}
function guanbiselect(id){
   $("#td"+id).bind("mouseleave", function(){
	$("#td"+id).attr("class","blurItem");
	$("#span"+id).show();
	$("#div"+id).hide();
   });
}
function check_this(id){
	if($("#job_class_"+id).attr("disabled") != 'disabled'){
		if($("#job_class_"+id).attr("checked")!="checked"){			
		 	var pid = $("#job_class_"+id).attr('data-pid');
			 $("#job_class_"+id).removeAttr("checked");
			 unsel(id,pid);			
		}else{			 
			 var pid = $("#job_class_"+id).attr('data-pid');
			 $("#job_class_"+id).attr("checked","true");			
			 addsel(id,pid);
		}
	}
}
function check_all(id){
	if($("#all"+id).attr("checked")!="checked"){
		$(".label"+id).removeAttr("disabled");
		$(".label"+id).removeAttr("checked");
		unsel(id);
	}else{
		$("#all"+id).attr("checked","true");
		$(".label"+id).attr("disabled","disabled");
		$(".label"+id).attr("checked","true");
		addsel(id);
	}
}

function opendiv(){
	var obj=document.getElementById('divopen');
	if(obj.style.display=='none'){
		$('#opendiv').html('收起示例');
		$('#divopen').show();
	}else{
		$('#opendiv').html('不知道怎么写？看看示例');
		$('#divopen').hide();
	}
}
function showdiv(id,type,name){
	$('#'+id).toggle();
	if(name=='year'){
		$("#"+type+"month").hide();
		$("#"+type+"day").hide();
	}else if(name=="month"){
		$("#"+type+"year").hide();
		$("#"+type+"day").hide();
	}else if(name=="day"){
		$("#"+type+"year").hide();
		$("#"+type+"month").hide();
	}
}