
$(document).ready(function(){

	$("#comindex_sqjob").click(function(){
		var loadi = layer.load('正在加载……',0);
		var codewebarr=get_comindes_jobid();
		if(!codewebarr){layer.msg('您还没有选择职位！', 2, 8);return false;}
		$.post(weburl+"/index.php?m=ajax&c=index_ajaxjob",{jobid:codewebarr},function(data){
			layer.close(loadi);
			if(data==0){ 
				layer.msg('对不起，您不是个人用户，无法申请职位！', 2, 8);return false;
			}else if(data==2){ 
				layer.msg('您还没有简历,请先添加简历！', 2, 8);return false;
			}else if(data==3){ 
				layer.msg('您已经申请过该职位，请重新选择！', 2, 8);return false;
			}else if(data==5){ 
				layer.msg('您还没有选择职位！', 2, 8);return false;
			}else{
				$(".POp_up_r").html('');	 	
				$(".POp_up_r").append(data); 
				$.layer({
					type : 1,
					title :'申请职位',
					offset: [($(window).height() - 380)/2 + 'px', ''],
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['380px','auto'],
					page : {dom :"#sqjob_show"}
				});
			}
		});
	})

	$("#click_comindex_sqjob").click(function(){
		var codewebarr=get_comindes_jobid();
		if(!codewebarr){layer.msg('您还没有选择职位！', 2, 8);return false;}
		var eid=$("input[name=resume]:checked").val();
		layer.closeAll();
		var loadi = layer.load('执行中，请稍候...',0); 
		$.post(weburl+"/index.php?m=ajax&c=comindex_sqjob",{codewebarr:codewebarr,eid:eid},function(data){
			layer.close(loadi); 
			if(data=='1'){
				layer.msg('恭喜您，您已成功申请该职位，请等待企业的回复！', 2, 1,function(){
					location.reload();
				});
			}else if(data=='0'){
				layer.alert('请先登录！', 0, '提示',function(){location.href ="index.php?m=login&usertype=1" });
			}else{
				layer.msg('系统繁忙！', 2, 8);
			} 
		});	
	})
	
	$("#comindex_favjob").click(function(){
		var codewebarr=get_comindes_jobid();
		if(!codewebarr){layer.msg('您还没有选择职位！', 2, 8);return false;}
		$.post(weburl+"/index.php?m=ajax&c=comindex_favjob",{codewebarr:codewebarr,type:1},function(data){ 
			if(data==0){
				layer.msg('对不起，您不是个人用户，无法收藏职位！', 2, 8);return false;	
			}else if(data==1){ 
				$("input[name=checkbox_job]:checked").each(function(){ 
					$(".scjobid"+$(this).val()).html("已收藏");
					$(".scjobid"+$(this).val()).attr('class','yun_job_operation_ysc');
				});
				layer.msg('您已成功收藏该职位！', 2, 9,function(){
					location.reload();
				});return false;
			}else if(data==2){ 
				layer.msg('系统出错，请稍后再试！', 2, 8);return false;
			}else if(data==3){ 
				layer.msg('有职位已收藏过，请重新选择！', 2, 8);return false;
			}else{
				layer.alert('请先登录！', 0, '提示',function(){location.href ="index.php?m=login&usertype=1" });return false; 
			}
			$('.job_box').hide();
		});	
	})	
	$(".checkbox_job").click(function(data){
		var val=$(this).attr("class");
		if(val=="checkbox_job"){
			$(this).addClass("iselect")
			var pid=$(this).attr("pid");
			$("#checkbox"+pid).attr("checked","checked");
		}else{
			$(this).removeClass("iselect")
			var pid=$(this).attr("pid");
			$("#checkbox"+pid).attr("checked",false);
			$(".checkbox_all").removeClass("iselect")
		}
	})
	$('body').mouseout(function(evt){
		if($(evt.target).parents('.com-list-wrapper').length==0){
		   $('.ks-popup').hide();
		}
	})
})
function checkAll(){
	var val=$(".checkbox_all").attr("class");
	if(val=="checkbox_all"){
		$("input[name=checkbox_job]").attr("checked","checked");
		$(".checkbox_job").addClass("iselect")
		$(".checkbox_all").addClass("iselect")
	}else{
		$("input[name=checkbox_job]").attr("checked",false);
		$(".checkbox_job").removeClass("iselect")
		$(".checkbox_all").removeClass("iselect")
	}
}
function exchange(){
	var exchangep=$("#exchangep").val();
	$.get(weburl+"/index.php?m=ajax&c=exchange&page="+exchangep,function(data){
		
		$(".job_recommendation_list").html(data);
	});
}
$(document).ready(function(){
	$(".yun_Looking_work_name").hover(function(){
		var aid=$(this).attr("aid");
		$("#i"+aid).addClass("All_post_seach_lbg");
	},function(){
		var aid=$(this).attr("aid");
		$("#i"+aid).removeClass("All_post_seach_lbg");
	}); 
}); 