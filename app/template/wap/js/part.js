
function PartCollect(jobid,comid){
	layer_load('执行中，请稍候...');
	$.post(wapurl+"?c=part&a=collect",{jobid:jobid,comid:comid},function(data){
		layer.closeAll();
		if(data==1){
			layermsg("只有个人用户才能收藏！",2);
		}else if(data==2){
			layermsg("您已经收藏过该兼职！",2);
		}else if(data==0){
			layermsg("收藏成功！",2,function(){location.reload();});
			
		}
	})
}

function PartApply(jobid){
	layer_load('执行中，请稍候...');
	$.post(wapurl+"/index.php?c=part&a=apply",{jobid:jobid},function(data){
		layer.closeAll();
		if(data==1){
			layermsg("只有个人用户才能申请报名！",2);
		}else if(data==2){
			layermsg("您已经报名过该兼职！",2);
		}else if(data==3){
			layermsg("拥有简历才可以报名兼职！",2);
		}else if(data==5){
			layermsg("报名已过期！",2);
		}else if(data==4){
			layermsg("报名已截止！",2);
		}else if(data==0){
			layermsg("报名成功！",2,function(){ 
				location.reload();
			});
			
		}
	})
}
function checkcity(id,type){
	if(id>0){
		$.post(wapurl+"?c=ajax&a=wap_city",{id:id,type:type},function(data){
			if(type==1){
				$("#cityid").html(data);
				$("#cityshowth").hide();
			}else{
				if(data){
					$("#cityshowth").show();
					$("#three_cityid").html(data);
				}
			}
		})
	}else{
		if(type==1){
			$("#cityid").html('<option value="">请选择</option>');
		}
	}
	$("#three_cityid").html('<option value="">请选择</option>');
}
function toDate(str){
	var sd=str.split("-");
	return new Date(sd[0],sd[1],sd[2]);
}
function CheckPost_part(){
	if($.trim($("#name").val())==""){
		layermsg("请输入职位名称！",2);return false;
	}
	if($.trim($("#typeid").val())<1){
		layermsg("请选择工作类型！",2);return false;
	}
	if($.trim($("#number").val())==""||$.trim($("#number").val())=="0"){
		layermsg("请输入招聘人数！",2);return false;
	}
	var chk_value =[];
	$('input[name="worktime[]"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	if(chk_value.length==0){
		layermsg("请选择兼职时间！",2);return false;
	}
	var today=$("#today").val();
	var sdate=$("#sdate").val().split(' ');
	var edate=$("#edate").val().split(' ');
	var timetype=$("input[name='timetype']:checked").val();
	if(sdate==""){
		layermsg("请选择开始日期！",2);return false;
	} 
	if(timetype!='1'){
		if(edate==""){
			layermsg("请选择结束日期！",2);return false;
		}
		if(toDate(edate[0])<toDate(sdate[0])){
			layermsg("开始日期不能大于结束日期！",2);return false;
		}
	}	
	if(!timetype){
		var end=$("#deadline").val().split(' ');	
		if(end==""){
			layermsg("请选择截止日期！",2);return false;
		} 	
		if(toDate(end[0])<toDate(today)){
			layermsg("报名截止时间不能小于当前时间！",2);return false;
		}
		 
		if(timetype!='1'&&toDate(end[0])>toDate(edate[0])){
			layermsg("报名截止时间不能超过有效期结束时间！",2);return false;
		}	
	}
	if($.trim($("#salary").val())==""||$.trim($("#salary").val())=="0"){
		layermsg("请输入薪水！",2);return false;
	}
	if($.trim($("#salary_typeid").val())==""){
		layermsg("请选择薪水类型！",2);return false;
	}
	if($.trim($("#billing_cycleid").val())<1){
		layermsg("请选择结算周期！",2);return false;
	}
		if($.trim($("#cityid").val())==""){
		layermsg("请选择工作地点！",2);return false;
	}	
	if($.trim($("#address").val())==""){
		layermsg("请输入详细地址！",2);return false;
	}
	if($.trim($("#map_x").val())==""||$.trim($("#map_y").val())==""){
		layermsg("请选择地图！",2);return false;
	}	
	var content=UE.getEditor('description').hasContents();  
	
	if(content==""||content==false){
		layermsg("请输入兼职内容！",2);return false;
	}else{
		var description =UE.getEditor('description').getContent();  
		document.getElementById("description").value=description;
	} 
	if($.trim($("#linkman").val())==""){
		layermsg("请输入联系人！",2);return false;
	}
	
    var linktel=isjsMobile($.trim($("#linktel").val()));
	if($.trim($("#linktel").val())==""){
		layermsg("请输入联系手机！",2);return false;
	}else if(linktel==false){
        layermsg("请输入正确的联系手机！",2);return false;
  }
}
function ckpartjob(type){
	var val=$("#"+type+"id").find("option:selected").text();
	$('.'+type).html(val);
}