
$(function(){
imgscrool('#ban');
})
function imgscrool(obj){
	var width = $(obj+" .banner .img img").width();
	var i=0;
	var clone=$(obj+" .banner .img li").first().clone();
	$(obj+" .banner .img").append(clone);
	var size=$(obj+" .banner .img li").size();
	for(var j=0;j<size-1;j++){
		$(obj+" .banner .num").append("<li><a></a></li>");
	}
	$(obj+" .banner .num li").first().addClass("hp_banner_gd_list_cur");

	$(obj+" .banner .num li").hover(function(){
		var index=$(this).index();
		i=index;
		$(obj+" .banner .img").stop().animate({left:-index*width},500);
		$(this).addClass("hp_banner_gd_list_cur").siblings().removeClass("hp_banner_gd_list_cur");	
	})

	var t=setInterval(function(){
		i++;
		move();
	},2000)

	$(obj+" .banner").hover(function(){
		clearInterval(t);
	},function(){
		t=setInterval(function(){
			i++;
			move();
		},2000)
	})

	$(obj+" .banner .hp_banner_icon_ft").stop(true).delay(800).click(function(){
		i--;
		move();	
	})

	$(obj+" .banner .hp_banner_icon_rt").stop(true).delay(800).click(function(){
		i++;
		move();
	})
	function move(){
		if(i==size){
			$(obj+" .banner  .img").css({left:0});
			i=1;
		}

		if(i==-1){
			$(obj+" .banner .img").css({left:-(size-1)*width});
			i=size-2;
		}
		$(obj+" .banner .img").stop(true).animate({left:-i*width},500);
		if(i==size-1){
			$(obj+" .banner .num li").eq(0).addClass("hp_banner_gd_list_cur").siblings().removeClass("hp_banner_gd_list_cur")	
		}else{
			$(obj+" .banner .num li").eq(i).addClass("hp_banner_gd_list_cur").siblings().removeClass("hp_banner_gd_list_cur")	
		}
	}	
}	