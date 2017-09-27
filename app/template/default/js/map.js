var decodeURIComponentEx = function (uriComponent) {
    if (!uriComponent) {
        return uriComponent;
    }
    var ret;
    try {
        ret = decodeURIComponent(uriComponent);
    } catch (ex) {
        ret = unescape(uriComponent);
    }
    return ret;
};
(function (e, f, b) { var d = /\+/g; function g(j) { return j } function h(j) { return c(decodeURIComponentEx(j.replace(d, " "))) } function c(j) { if (j.indexOf('"') === 0) { j = j.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\") } return j } function i(j) { return a.json ? JSON.parse(j) : j } var a = e.cookie = function (r, q, w) { if (q !== b) { w = e.extend({}, a.defaults, w); if (q === null) { w.expires = -1 } if (typeof w.expires === "number") { var s = w.expires, v = w.expires = new Date(); v.setDate(v.getDate() + s) } q = a.json ? JSON.stringify(q) : String(q); return (f.cookie = [encodeURIComponent(r), "=", a.raw ? q : encodeURIComponent(q), w.expires ? "; expires=" + w.expires.toUTCString() : "", w.path ? "; path=" + w.path : "", w.domain ? "; domain=" + w.domain : "", w.secure ? "; secure" : ""].join("")) } var j = a.raw ? g : h; var u = f.cookie.split("; "); var x = r ? null : {}; for (var p = 0, n = u.length; p < n; p++) { var o = u[p].split("="); var k = j(o.shift()); var m = j(o.join("=")); if (r && r === k) { x = i(m); break } if (!r) { x[k] = i(m) } } return x }; a.defaults = {}; e.removeCookie = function (k, j) { if (e.cookie(k) !== null) { e.cookie(k, null, j); return true } return false } })(jQuery, document);

jQuery.fn.pagination=function(a,b){b=jQuery.extend({items_per_page:10,num_display_entries:10,current_page:0,num_edge_entries:0,link_to:"#",prev_text:"Prev",next_text:"Next",ellipse_text:"...",prev_show_always:true,next_show_always:true,callback:function(){return false}},b||{});return this.each(function(){function f(){return Math.ceil(a/b.items_per_page)}function h(){var k=Math.ceil(b.num_display_entries/2);var l=f();var j=l-b.num_display_entries;var m=g>k?Math.max(Math.min(g-k,j),0):0;var i=g>k?Math.min(g+k,l):Math.min(b.num_display_entries,l);return[m,i]}function e(j,i){g=j;c();var k=b.callback(j,d);if(!k){if(i.stopPropagation){i.stopPropagation()}else{i.cancelBubble=true}}return k}function c(){d.empty();var k=h();var o=f();var p=function(i){return function(q){return e(i,q)}};var n=function(i,q){i=i<0?0:(i<o?i:o-1);q=jQuery.extend({text:i+1,classes:""},q||{});if(i==g){var r=jQuery("<span class='current'>"+(q.text)+"</span>")}else{var r=jQuery("<a>"+(q.text)+"</a>").bind("click",p(i)).attr("href",b.link_to.replace(/__id__/,i))}if(q.classes){r.addClass(q.classes)}d.append(r)};if(b.prev_text&&(g>0||b.prev_show_always)){n(g-1,{text:b.prev_text,classes:"prev"})}if(k[0]>0&&b.num_edge_entries>0){var j=Math.min(b.num_edge_entries,k[0]);for(var l=0;l<j;l++){n(l)}if(b.num_edge_entries<k[0]&&b.ellipse_text){jQuery("<span>"+b.ellipse_text+"</span>").appendTo(d)}}for(var l=k[0];l<k[1];l++){n(l)}if(k[1]<o&&b.num_edge_entries>0){if(o-b.num_edge_entries>k[1]&&b.ellipse_text){jQuery("<span>"+b.ellipse_text+"</span>").appendTo(d)}var m=Math.max(o-b.num_edge_entries,k[1]);for(var l=m;l<o;l++){n(l)}}if(b.next_text&&(g<o-1||b.next_show_always)){n(g+1,{text:b.next_text,classes:"next"})}}var g=b.current_page;a=(!a||a<0)?1:a;b.items_per_page=(!b.items_per_page||b.items_per_page<0)?1:b.items_per_page;var d=jQuery(this);this.selectPage=function(i){e(i)};this.prevPage=function(){if(g>0){e(g-1);return true}else{return false}};this.nextPage=function(){if(g<f()-1){e(g+1);return true}else{return false}};c();b.callback(g,this)})};

jQuery.guide=function(b){$.cookie("mg","1",{expires:900});var c=jQuery("#guide_background");var a=jQuery("#guide_content").show();c.width($(document).width()).height($(document).height()).css({left:"0px",top:"0px"}).fadeIn();jQuery.each(b,function(e,f){var d=jQuery(f.tag);if(e===0){d.fadeIn()}d.children(".close").css({top:f.closetop,left:f.closeleft}).click(function(){c.fadeOut();d.fadeOut();});d.children(".next").css({top:f.nexttop,left:f.nextleft}).click(function(){if(f.next==""){c.fadeOut();a.fadeOut();d.fadeOut();$("html,body").animate({scrollTop:"0px"},500);}else{d.fadeOut();jQuery(f.next).fadeIn();$("html,body").animate({scrollTop:jQuery(f.next).offset().top},1000)}});c.click(function(){c.fadeOut();a.fadeOut();d.fadeOut()})})};$(function(){if($.cookie("mg")!="1"){startguide()}$("#startguide").click(function(){startguide()})});function startguide(){var a=[{tag:"#guide_content .step1",closetop:"245px",closeleft:"325px",nexttop:"470px",nextleft:"155px",next:"#guide_content .step2"},{tag:"#guide_content .step2",closetop:"420px",closeleft:"455px",nexttop:"630px",nextleft:"290px",next:"#guide_content .step3"},{tag:"#guide_content .step3",closetop:"365px",closeleft:"475px",nexttop:"580px",nextleft:"310px",next:"#guide_content .step4"},{tag:"#guide_content .step4",closetop:"360px",closeleft:"440px",nexttop:"580px",nextleft:"260px",next:"#guide_content .step5"},{tag:"#guide_content .step5",closetop:"30px",closeleft:"330px",nexttop:"230px",nextleft:"165px",next:""}];$.guide(a)};


String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "")
};
String.prototype.ltrim = function() {
	return this.replace(/(^\s*)/g, "")
};
String.prototype.rtrim = function() {
	return this.replace(/(\s*$)/g, "")
};
var map = new BMap.Map("map-container",{enableMapClick:false});
map.setMaxZoom(19);
var point = new BMap.Point(x,y);
map.centerAndZoom(point,13);
map.enableScrollWheelZoom();
map.addControl(new BMap.ScaleControl());
map.addControl(new BMap.NavigationControl());
var Timer = null;
var MarkerIndex = 1;
var BlueIcon = new BMap.Icon(marker_icon_blue,new BMap.Size(26,37),{
	anchor: new BMap.Size(13,37)
});
map.addEventListener("dragend",function() {
	if (Timer != null) {
		clearTimeout(Timer)
	}
	Timer = setTimeout("searchWhenMoving("+0+","+true+")",1000);
});
map.addEventListener("zoomend", function() {
	if (Timer != null) {clearTimeout(Timer)}
	Timer = setTimeout("searchWhenMoving("+0+","+true+")",1000);
});

function searchByKeyword(page,e){
	$("#map .map-loader").show();
	var keyword = $.trim($("#keyword").val());
	var b = $("#searchtype").val();
	if (keyword == "") {
		searchByLocation(0,true);
		$("#map .map-loader").hide();
	} else {
		var k=map.getBounds();
		var a=k.getSouthWest();
		var d=k.getNorthEast(); 
		get_data_map(keyword,a.lng,d.lng,a.lat,d.lat,page,e,3,b); 
	}
}

function searchByLocation(page,f) {
	var b=map.getBounds();
	var a=b.getSouthWest();
	var d=b.getNorthEast();
	get_data_map('',a.lng,d.lng,a.lat,d.lat,page,f,2);
}

function searchWhenMoving(page,h) {
	$("#map .map-loader-box").show();
	var d = map.getBounds();
	var a = d.getSouthWest();
	var f = d.getNorthEast();
	var keyword = $.trim($("#keyword").val());
	var c = $("#searchtype").val();
	if(keyword==""){
		searchByLocation(0,true);
	}else{
		get_data_map(keyword,a.lng,f.lng,a.lat,f.lat,page,h,1,c); 
	}
}

function get_data_map(keyword,min_lng,max_lng,min_lat,max_lat,page,t,ttype,type){
	var keyword,min_lng,max_lng,min_lat,max_lat,page,t,type;
	$.post(getdataurl,{keyword:keyword,min_lng:min_lng,max_lng:max_lng,min_lat:min_lat,max_lat:max_lat,page:page,type:type},function(data){
		var data=eval('('+data+')');
		addMarker(data.list,false);
		$("#count").html(data.count);
		$("#map .map-loader").hide();
		$("#map .map-loader-box").hide();
		if(data.count==0){
			layer.msg(decodeURI('没有获取到数据,您还可以拖动地图看看其它地区的招聘信息！'),2,8);
			$("#Pagination").hide();
		}else{
			$("#Pagination").show();
			if(t && ttype==1){
				updatePageWhenMoving(data.count);
			}
			if(t && ttype==2){
				updatePageByLocation(data.count);
			}
			if(t && ttype==3){
				updatePageByKeyword(data.count); 
			}	
		}
		
	})
}

var _current_iw = null;

function addMarker(d,c){
	map.clearOverlays();
	var b = $("#content");
	b.empty();
	var a = 0;
	$.each(d,function(g,r) {
		var f=new BMap.Icon(marker_icon_url,new BMap.Size(23,25),{anchor:new BMap.Size(10,25),imageOffset:new BMap.Size(0,0-a*25)
		});
		var n = new BMap.Point(r.x, r.y);
		var h = new BMap.Marker(n,{icon: f});
		map.addOverlay(h);
		var q = $("<dl class='markerinfo'></dl>");
		var l = $("<dt><a href='"+r.com_url+"' target='_blank'>"+r.name+(r["is_vip"]?'<span class="vip" title="VIP会员企业">V</span>':'')+"</a></dt>");
		var i = r.joblist;
		var p = "";
		for (var v in i) {
			p+="<dd style='height:25px;'><a href='"+i[v]["job_url"]+"'target='_blank'>"+i[v]["name"]+"</a></dd>"
		}
		p+="<dd class='more'><a href='"+r.com_url+"' target='_blank'>更多…</a></dd>";
		var t = $(p);
		q.append(l);
		q.append(t);
		q = q[0];
		var k = {message:r.name,enableCloseOnClick:false};
		var u = new BMap.InfoWindow(q, k);
		u.addEventListener("clickclose", function() {
			_current_iw = null
		});
		h.addEventListener("click", function() {
			_current_iw = r.id;
			this.openInfoWindow(u);
			radius()
		});
		var m = $("<li></li>");
		var s = $("<dl></dl>");
		var o = $("<dt><a href='"+r.com_url+"' target='_blank'>"+r.name+(r["is_vip"]?'<span class="vip" title="VIP会员企业">V</span>' : '') + "</a></dt>");
		var j = "";
		for (var v in i) {
			j+="<dd style='height:25px;'><a href='"+i[v]["job_url"]+"' target='_blank'>"+i[v]["name"]+"</a></dd>"
		}
		var e=$(j);
		s.append(o);
		s.append(e);
		m.append("<i class='marker marker"+(a+1)+"'></i>");
		m.append(s);
		b.append(m);
		h.addEventListener("mouseover",function(w) {
			m.css("background-color","#fff");
		});
		h.addEventListener("mouseout",function() {
			m.css("background-color","#f8f8f8");
		});
		m.click(function(w) {
			if(w.target.tagName!="a" && w.target.tagName!="A"){
				_current_iw = r.id;
				h.openInfoWindow(u);
				radius();
			}
		});
		m.hover(function(w) {
			h.setIcon(BlueIcon);
			h.setZIndex(MarkerIndex++);
			m.css("background-color","#fff");
		},function(w) {
			h.setIcon(f);
			m.css("background-color","#f8f8f8");
		});
		if(c){
			map.centerAndZoom(n,13);
			c=false;
		}
		if(_current_iw==r.id){
			h.openInfoWindow(u);
		}
		a++;
	})
}
function updatePageByKeyword(a) {
	$("#Pagination").pagination(a, {
		callback:callbackKeyword,
		prev_text:" ",
		next_text:" ",
		items_per_page:10,
		num_edge_entries:1,
		num_display_entries:3,
		link_to: "javascript:;"
	})
}
function callbackKeyword(a, b){
	searchByKeyword(a, false)
}
function updatePageByLocation(a){
	$("#Pagination").pagination(a,{
		callback: callbackLocation,
		prev_text: " ",
		next_text: " ",
		items_per_page: 10,
		num_edge_entries: 1,
		num_display_entries: 3,
		link_to: "javascript:;"
	})
}
function callbackLocation(a,b){
	searchByLocation(a, false)
}
function updatePageWhenMoving(a){
	$("#Pagination").pagination(a,{
		callback: callbackWhenMoving,
		prev_text: " ",
		next_text: " ",
		items_per_page:10,
		num_edge_entries: 1,
		num_display_entries: 3,
		link_to: "javascript:;"
	})
}
function callbackWhenMoving(a,b){
	searchWhenMoving(a,false);
}
function radius(){
	$(".BMap_top").next().children().css("border-top-right-radius","10px 10px");
	$(".BMap_top").prev().children().css("border-top-left-radius","10px 10px");
	$(".BMap_bottom").next().children().css("border-bottom-right-radius","10px 10px");
	$(".BMap_bottom").prev().children().css("border-bottom-left-radius","10px 10px");
}
function get_current_loaction(page) {
	    var geolocation = new BMap.Geolocation();
	    geolocation.getCurrentPosition(function (r) {
	        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
	            location_r = r;
	           
				var point = new BMap.Point(r.point.lng,r.point.lat);
				
				map.centerAndZoom(point,13);
				var k=map.getBounds();
				var a=k.getSouthWest();
				var d=k.getNorthEast(); 
	            get_data_map('',a.lng,d.lng,a.lat,d.lat,page,true,2);
	        }
	        else {
	           
	        }
	    }, { enableHighAccuracy: true });
}

$(document).ready(function() {
	$('#title').children('a').click(function(){ 
		$('#title').children('a').attr("class","nselect");
		var a=$("#title i");
		$(this).attr("class","select");
		$(this).append(a);
		$input=$("#searchtype");
		if($(this).attr("title")=="company"){
			$input.val("company");
		}else{
			$input.val("job");
		}
	});
	$("#keyword").keydown(function(a) {
		if(a.keyCode==13){
			searchByKeyword(0,true)
		}
	});
	$("#submitbutton").click(function() {
		searchByKeyword(0,true)
	});
	$("#search .hot a").click(function() {
		$("#map .map-loader").show();
		var a = $(this).html();
		a.trim();
		$("#keyword").val(a);
		$("#title a").attr("class", "nselect");
		var b = $("#title i");
		b.detach();
		$("#title a[title=job]").attr("class", "select").append(b);
		$("#searchtype").val("job");
		searchByKeyword(0,true)
	});
	get_current_loaction(0)
});