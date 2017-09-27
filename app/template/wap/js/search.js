$(document).ready(function(){
	$(".jobindex").click(function(){
		var aid=$(this).attr("aid");
		$(".jobindex").removeClass("job_pop_function_selected");
		$(this).addClass("job_pop_function_selected");
		$(".job_pop_function_list_tj").hide();
		$("#joblist"+aid).show();
	})
	$(".jobtype").click(function () {
		var aid=$(this).attr("aid");
		var style=$("#joblist"+aid).attr("style");
		$(".job_pop_function_b_list").attr("style","display:none;");
		if(style=="display:none;"){
			$("#joblist"+aid).show();
		}
		var height = 0;
		$(this).parent().parent().find('li:lt(' + ($(this).parent().index()) + ')').each(function () {
		    height += $(this).height()+21;
		});		
		window.city_list2.css('top', -height);
	})
	$(".cityindex").click(function(){
		var aid=$(this).attr("aid");
		$(".cityindex").removeClass("job_pop_function_selected");
		$(this).addClass("job_pop_function_selected");
		$(".job_pop_function_list_tj").hide();
		$("#citylist"+aid).show();
	})
	$(".citytype").click(function () {
		var aid=$(this).attr("aid");
		var style=$("#citylist"+aid).attr("style");
		$(".job_pop_function_b_list").attr("style","display:none;");
		if(style=="display:none;"){
			$("#citylist"+aid).show();
		}
		var height = 0;
		$(this).parent().parent().find('li:lt(' + ($(this).parent().index()) + ')').each(function () {
		    height += $(this).height() + 21;
		});
		window.city_list2.css('top', -height);
	})
})
function Close_div(id){
	$("#"+id).hide();
}
function show_div(id) {
    var is_hidden=$("#" + id).is(':hidden');
    $(".openlist").hide();
    if (is_hidden) {
        $("#" + id).show();
    } else {
        $("#" + id).hide();
    }
}

function check_city_li(id,type){
	var url=$("#searchurl").val();
	$.post(wapurl+"/?c=job&a=ajax_url",{url:url,type:type,id:id},function(data){
		location.href=wapurl+data;
	})
}
function check_job_li(id,type){
	var url=$("#searchurl").val();
	$.post(wapurl+"/?c=job&a=ajax_url",{url:url,type:"jobin",id:id},function(data){
		location.href=wapurl+data;
	})
}

function getT3d(elem, ename) {
    var elem = elem[0];
    var str1 = elem.style.webkitTransform;
    if (str1 == "") return "0";
    str1 = str1.replace("translate3d(", "");
    str1 = str1.replace(")", "");
    var carr = str1.split(",");

    if (ename == "x") return carr[0];
    else if (ename == "y") return carr[1];
    else if (ename == "z") return carr[2];
    else return "";
}
$(function () {
    window.city_list1 = $('#city_list1,#job_list1');
    window.city_list1.on("touchstart", function (event) {
        window.scroll_top = document.body.scrollTop;
        var event = event.originalEvent;
        window.gundongX = 0;
        window.gundongY = 0;
        window.stTop = parseInt($(this).css('top'));
        window.stTop = window.stTop ? window.stTop : 0; 

        window.etx = parseInt(getT3d($(this), "x"));
        window.ety = parseInt(getT3d($(this), "y"));

        window.stx = event.touches[0].pageX;
        window.sty = event.touches[0].pageY;
    });
    window.city_list1.on("touchmove", function (event) {
        document.body.scrollTop = window.scroll_top;
        event.preventDefault();
        var event = event.originalEvent;
        event.preventDefault();

        window.gundongX = event.touches[0].pageX - window.stx;
        window.gundongY = event.touches[0].pageY - window.sty;

        window.curX = window.gundongX + window.etx;
        window.curY = window.gundongY + window.ety;

        if (((window.stTop + window.curY) > (-39 * $(this).find('li').length + 250)) && ((window.stTop + window.curY) <= 0)) {
            $(this).css('top', window.stTop + window.curY);
        } else if (((window.stTop + window.curY) <= (-39 * $(this).find('li').length + 250))) {
            $(this).css('top', -39 * $(this).find('li').length + 250);
        } else if ( ((window.stTop + window.curY) > 0)) {
            $(this).css('top', 0);
        }
    });

    window.city_list2 = $('#city_list2,#job_list2');
    window.city_list2.on("touchstart", function (event) {
        window.scroll_top = document.body.scrollTop;
        var event = event.originalEvent;
        window.gundongX2 = 0;
        window.gundongY2 = 0;
        window.stTop2 = parseInt($(this).css('top'));
        window.stTop2 = window.stTop2 ? window.stTop2 : 0;

        window.etx2 = parseInt(getT3d($(this), "x"));
        window.ety2 = parseInt(getT3d($(this), "y"));

        window.stx2 = event.touches[0].pageX;
        window.sty2 = event.touches[0].pageY;
    });
    window.city_list2.on("touchmove", function (event) {
        document.body.scrollTop = window.scroll_top;
        event.preventDefault();
        var event = event.originalEvent;
        event.preventDefault();

       
        window.gundongX2 = event.touches[0].pageX - window.stx2;
        window.gundongY2 = event.touches[0].pageY - window.sty2;

      
        window.curX2 = window.gundongX2 + window.etx2;
        window.curY2 = window.gundongY2 + window.ety2;
        var max_top = -$(this).find('ul:visible').height() + 280;
        max_top = max_top > 0 ? 0 : max_top;
        if (((window.stTop2 + window.curY2) > max_top) && ((window.stTop2 + window.curY2) <= 0)) {
            $(this).css('top', window.stTop2 + window.curY2);
        } else if (((window.stTop2 + window.curY2) <= max_top)) {
            $(this).css('top', max_top);
        } else if (((window.stTop2 + window.curY2) > 0)) {
            $(this).css('top', 0);
        }
    });
});