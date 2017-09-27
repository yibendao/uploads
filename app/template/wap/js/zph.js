
$(document).ready(function(){
	$(".fairs_disp_position").hover(function(){
		var aid=$(this).attr("aid");
		content=$("#showstatus"+aid).html();
		$("#showstatus"+aid).show();		
	},function(){
		var aid=$(this).attr("aid");
		content=$("#showstatus"+aid).html();
		$("#showstatus"+aid).hide();
	})   
});
function clickzph(id,zid,price){ 
	var usertype=$("#usertype").val();
	if(usertype>0){
		if(usertype!=2){
			layermsg("只有企业用户才可以预定展位！");return false;
		}
	}
	var stime=$("#zph_stime").val();
	var etime=$("#zph_etime").val();
	if(stime<'0' && etime>'0'){
		layermsg('招聘会已经开始！');return false;
	}else if(etime<'0'){
		layermsg("招聘会已经结束！");return false;
	} 
	layer_load('执行中，请稍候...');
	$.post(wapurl+"/index.php?c=ajax&a=ajaxzphjob",{zid:zid,id:id},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		if(data.status=='1'){
			layermsg(data.msg);
		}else if(data.html){ 
			if(data.addjobnum=='1'){
				$("#zphaddjob").html('<a href="'+wapurl+'member/index.php?c=jobadd" class="Corporate_box_tj" target="_blank">新增职位</a>');
			}else{
				$("#zphaddjob").html('<a href="javascript:void(0)"  onclick="jobaddurl(\''+data.addjobnum+'\',\''+data.integral_job+'\',\''+data.integral_pricename+'\')" class="Corporate_box_tj">新增职位</a>');
			}
			$("#joblist").html(data.html);
			$("#bid").val(id);
			$("#zph_price").html(price);
			content=$("#TB_window").html();
			$("#TB_window").html('');
			layer.open({
				type : 1,
				title :'预定招聘会', 
				closeBtn : [0 , true],
				area : ['320px','308px'],
				content:content,
				cancal:$("#TB_window").html(content)
			}); 
		}
	}) 
}
function jobaddurl(num,integral_job,integral_pricename){ 
	if(num==0){
		var msg='套餐已用完，请先购买会员！';
		layer.open({
			content: msg,
			btn: ['确定', '取消'],
			yes: function(){location.href=wapurl+'/index.php?c=rating';}
		});
	}else if(num==2){
		var msg='套餐已用完，继续操作将会扣除'+integral_job+' '+integral_pricename+'，是否继续？';
		layer.open({
			content: msg,
			btn: ['确定', '取消'],
			yes: function(){location.href=wapurl+'/member/index.php?c=jobadd';}
		});
	}
}
function submitzph(){
	var bid=$("#bid").val();
	var zid=$("#zid").val();
	var jobid=get_comindes_jobid();
	layer_load('执行中，请稍候...');
	$.get(wapurl+"/index.php?c=ajax&a=zphcom&bid="+bid+"&zid="+zid+"&jobid="+jobid, function(data){
		var data=eval('('+data+')');
		var status=data.status;
		var content=data.content;
		layer.closeAll();
		if(status==0){
			layermsg(content);
		}else{
			layermsg(content,2,function(){location.reload();});
		} return false;
	})
}
function get_comindes_jobid(){
	var codewebarr="";
	$("input[name=checkbox_job]:checked").each(function(){
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	return codewebarr;
}