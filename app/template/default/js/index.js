
$(function(){	

	marquee("2000",".hp_web .hp_web_ct ul"); 

    $(".hp_z_w").hover(function() {
		$('.hp_z_w_icon').show();
		$('.hp_z_s_icon').hide();
        $('#hp_weixin').show();
		$('#hp_phone').hide();
    });

	$(".hp_z_s").hover(function() {
		$('.hp_z_w_icon').hide();
		$('.hp_z_s_icon').show();
        $('#hp_phone').show();
        $('#hp_weixin').hide();
    });

	$('body').click(function(evt) {
		if($(evt.target).parents("#job_hy").length==0 && evt.target.id != "hy") {
			$('#job_hy').hide();
		}
		if($(evt.target).parents("#job_exp").length==0 && evt.target.id != "exp") {
			$('#job_exp').hide();
		}
		if($(evt.target).parents("#job_edu").length==0 && evt.target.id != "edu") {
			$('#job_edu').hide();
		}
		if($(evt.target).parents("#job_salary").length==0 && evt.target.id != "salary") {
			$('#job_salary').hide();
		}
		if($(evt.target).parents("#job_mun").length==0 && evt.target.id != "mun") {
			$('#job_mun').hide();
		}  
		if($(evt.target).parents("#job_report").length==0 && evt.target.id != "report") {
	       $('#job_report').hide();
	    }	
		if($(evt.target).parents("#job_uptime").length==0 && evt.target.id != "uptime") {
		   $('#job_uptime').hide();
		}	
		if($(evt.target).parents(".index_r_wap_l").length==0&&$(evt.target).attr('class')!='index_r_wap_l') {
			$(".index_r_wap_l>.index_r_wap_box").hide();
		} 
		if($(evt.target).parents(".index_r_weixin").length==0&&$(evt.target).attr('class')!='index_r_weixin') {
			$(".index_r_wap_box_weixin").hide();
		} 
		if($(evt.target).parents(".index_r_wap_box").length){
			$(".index_r_wap_box").hide();
		}
		if($(evt.target).parents(".index_nav_tit").length==0){
			$("#boxNav").hide();
		}
	});  

	$(".yun_index_h1_list li").hover(function(){
		var num=$(this).index(); 
		$(".yun_index_h1_list li").removeClass("yun_index_h1_cur");
		$(this).addClass("yun_index_h1_cur");
		$(".yuin_index_r .yun_index_cont").hide();
		$(".yun_index_cont:eq("+num+")").show(); 
	}); 
	$(".index_r_wap_l").click(function(){
		$(".index_r_wap_box").hide();
		$(this).find(".index_r_wap_box").show();
	});
	$(".index_r_weixin").click(function(){
		$(".index_r_wap_box").hide();
		$(this).find(".index_r_wap_box").show();
	});

	$("#navMenu").click(function(){
		$("#boxNav").show();
	});
	
	$("#navLst li").hover(function(){
		$(this).attr('class','show');
	},function(){$(this).attr('class','');});

})

$(document).ready(function(){	
	$('#bottom_ad_is_show').val('1');
	var duilian = $("div.duilian");
	var duilian_close = $(".btn_close");
	var scroll_Top = $(window).scrollTop();
	var window_w = $(window).width();
	if(window_w>1000){duilian.show();}
	buttom_ad();
	$("div .duilian").css("top",scroll_Top+200);
	$(window).scroll(function(){
		buttom_ad();
		var scroll_Top = $(window).scrollTop();
		duilian.stop().animate({top:scroll_Top+200});
	});
	duilian_close.click(function(){
		$(this).parents('.duilian').hide();
		return false;
	});
});
function colse_bottom(){
	$("#bottom_ad_fl").parent().hide();
	$('#bottom_ad_is_show').val('0');
}
function buttom_ad(){
	if($("#bottom_ad").length>0&&$("#bottom_ad_is_show").length>0){
		var scrollTop = $(window).scrollTop();
		var w_height=$(document).height();
		var bottom_ad=$("#bottom_ad").offset().top;
		var bottom_ad_fl=$("#bottom_ad_fl").offset().top;
		var poor_height=parseInt(w_height)-parseInt(scrollTop);
		var bottom_ad_is_show=$('#bottom_ad_is_show').val();
		if(window.attachEvent){
			poor_height=parseInt(poor_height)-parseInt(22);
		}
		if(poor_height<=880){
			$("#bottom_ad_fl").parent().hide();
		}else if(bottom_ad_is_show=='1'){
			$("#bottom_ad_fl").parent().show();
		}
	}
}

function show_job(id,showhtml){
	if(showhtml=="1"){
		$.post("index.php?m=ajax&c=show_leftjob",{},function(data){	
			$("#menuLst").html(data);	
			$(".lst"+id).attr("class","lst"+id+" hov");			
		});
	}else{
		var num=$(".lstCon").length/3;
		if(id<num){
			var height=id*35;
			var heightdiv=$(".lst"+id+" .lstCon").height();
			if(heightdiv-height<35){
				height=heightdiv=$(".lst"+id+" .lstCon").height()/2;
			}
			$(".lst"+id+" .lstCon").attr("style","top:-"+height+"px");
		}else if(id<num*2){
			var height=id*35;
			var heightdiv=$(".lst"+id+" .lstCon").height()/2;
			$(".lst"+id+" .lstCon").attr("style","top:-"+heightdiv+"px");
		}else{
			var height=($(".lstCon").length-id)*35;
			var heightdiv=$(".lst"+id+" .lstCon").height();
			if(heightdiv>height){
				heightdiv=heightdiv-height;
			}else{
				heightdiv=0;
			}
			$(".lst"+id+" .lstCon").attr("style","top:-"+heightdiv+"px");
		}
		$(".lst"+id).attr("class","lst"+id+" hov");	
	}
}
function selects(id,type,name){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#"+type+"id").val(id);
} 
function hide_job(id){
	$("#menuLst li").removeClass("hov"); 
}
function showDiv2(obj){
	if($(obj).attr("class")=="current1"){
		$(obj).removeClass();
	}
	else{
		$(obj).addClass("current1");
		$(obj).find(".shade").height($(obj).find(".area").height()+60)
	}
}
function clean(){
	$("#edu").val("请选择");
	$("#eduid").val("");
	$("#exp").val("请选择");
	$("#expid").val("");
	$("#mun").val("请选择")
	$("#munid").val("");;
	$("#salary").val("请选择");
	$("#salaryid").val("");
	$("#index_job_class_val").val("请选择职位类别");
	$("#job_class").val("");
	$("#city").val("请选择工作地点");
	$("#cityid").val("");
	$("#hy").val("请选择行业类别");
	$("#hyid").val("");
}