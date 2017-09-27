var timestamp=Math.round(new Date().getTime()/1000) ;
function loadlayer(){
	layer.load('执行中，请稍候...',0);
}
function toDate(str){
	var sd=str.split("-");
	return new Date(sd[0],sd[1],sd[2]);
}
function wait_result(){
	layer.closeAll();
	layer.load('执行中，请稍候...',0);
}
function showImgDelay(imgObj,imgSrc,maxErrorNum){  
    if(maxErrorNum>0){ 
        imgObj.onerror=function(){
            showImgDelay(imgObj,imgSrc,maxErrorNum-1);
        };
        setTimeout(function(){
            imgObj.src=imgSrc;
        },500);
		maxErrorNum=parseInt(maxErrorNum)-parseInt(1);
    }
}
function layer_del(msg,url){ 
	if(msg==''){
		var i=layer.load('执行中，请稍候...',0);
		$.get(url,function(data){
			layer.close(i);
			var data=eval('('+data+')');
			if(data.url=='1'){
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.reload();window.event.returnValue = false;return false;});return false;
			}else{
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;
			}
		});
	}else{
		layer.confirm(msg, function(){
			var i=layer.load('执行中，请稍候...',0);
			$.get(url,function(data){
				layer.close(i);
				var data=eval('('+data+')');
				if(data.url=='1'){
					layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.reload();window.event.returnValue = false;return false;});return false;
				}else{
					layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;
				}
			});
		});
	}
}
function addblack(){
	$(".Blacklist_box>form>ul").html("");
	$("#name").val('');	
	$.layer({
		type : 1,
		title : '搜索企业',
		closeBtn : [0 , true], 
		border : [10 , 0.3 , '#000', true],
		area : ['400px','320px'],
		page : {dom : '#blackdiv'}
	});
}
function canceljob(id){
	$("#qsid").val(id);
	$.layer({
		type : 1,
		title : '取消原因',
		closeBtn : [0 , true], 
		border : [10 , 0.3 , '#000', true],
		area : ['300px','180px'],
		page : {dom : '#blackdiv'}
	});
}
function logout(url){
	$.get(url,function(msg){
		if(msg==1 || msg.indexOf('script')){
			if(msg.indexOf('script')){
				$('#uclogin').html(msg);
			}
			layer.msg('您已成功退出！', 2, 9,function(){window.location.href =weburl;window.event.returnValue = false;return false;});
		}else{
			layer.msg('退出失败！', 2, 8);
		}
	});
}
function searchcom(){
	var name=$.trim($("#name").val());
	if(name==''){
		layer.closeAll();
		layer.msg('请输入搜索的公司名称！', 2, 8,function(){addblack();});return false;
	}else{
		var loadi = layer.load('执行中，请稍候...',0);
		$.post("index.php?c=privacy&act=searchcom",{name:name},function(data){
			layer.close(loadi);
			$(".Blacklist_box>form>ul").html(data);		
		});
	} 
}
function ckaddblack(){
	var chk_value=[];
	$('input[name="buid[]"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	layer.closeAll();
	if(chk_value.length==0){ 
		layer.msg("请选择要屏蔽的公司！",2,8,function(){addblack()});return false;
	} 
	layer.load('执行中，请稍候...',0);
}
function entrust(msg,id){
	wait_result();
	if(msg){
		layer.confirm(msg,function(){
			$.post("index.php?c=com_res&act=canceltrust",{id:id},function(data){
				var data=eval('('+data+')'); 
				if(data.url){
					layer.msg(data.msg, 2,Number(data.type),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;	
				}else{
					layer.msg(data.msg, 2,Number(data.type),function(){window.location.reload();window.event.returnValue = false;return false;});return false;	
				} 		
			});
		});
	}else{
		$.post("index.php?c=com_res&act=canceltrust",{id:id},function(data){
			var data=eval('('+data+')'); 
			if(data.url){
				layer.msg(data.msg, 2,Number(data.type),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;	
			}else{
				layer.msg(data.msg, 2,Number(data.type),function(){window.location.reload();window.event.returnValue = false;return false;});return false;	
			} 		
		});
	} 
} 
function entr_resume(id){
	layer.closeAll();
	$("#entr_resume .job_box_botton").html("<a class=\"job_box_yes job_box_botton2\" href=\"javascript:void(0);\" onclick=\"entrust('','"+id+"');\">委托</a>");
	$.layer({
		type : 1,
		title : '委托简历',
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['300px','200px'],
		page : {dom : '#entr_resume'}
	});
}
function com_res(){ 
	var loadi = layer.load('加载中…',0); 
	$.get("index.php?c=com_res",function(msg){
		if(msg==1){
			layer.msg('您暂无公开简历！', 2, 8);return false;
		}else { 
			layer.close(loadi);
			$(".result_class").remove();
			$(".Commissioned_table").append(msg);			
			$.layer({
				type : 1,
				title : '委托简历', 
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['530px','auto'],
				page : {dom :'.Commissioned_Resume_box'},
				close : function(index){layer.close(index);$(".result_class").remove();}
			}); 
		} 
	}); 
}
function buyad(){
	if($.trim($('#ad_name').val())==''){
		layer.msg('请输入广告名称！', 2, 8);return false;
	}
	if($.trim($('#pic_url').val())==''){
		layer.msg('请选择广告图片！', 2,8);return false;
	}
	if($.trim($('#pic_src').val())==''){
		layer.msg('请输入广告链接！', 2,8);return false;
	}
	if($.trim($('#buy_time').val())==''){
		layer.msg('请输入购买时间！', 2,8);return false;
	}
	buy_vip_ad();
}
function buy_vip_ad(){ 
	var integral_buy=$("input[name=integral_buy]").val();
	var yh_integral=$("input[name=yh_integral]").val();   
	if(isNaN(yh_integral)==false){ 
		integral_buy=parseInt(integral_buy)-parseInt(yh_integral);
	}  
	var msg="购买此项服将扣除"+integral_buy+integral_pricename+"，是否继续？"; 
	layer.confirm(msg,function(){ 
		setTimeout(function(){$('#myform').submit()},0);
	});
}
$(document).ready(function(){
	$(".signdiv").hover();
	$(".signdiv").hover(function(){
		$("#sign_layer").show(); 
	},function(){
		$("#sign_layer").hide();	
	});
	$(".left_box_zp_qd").click(function(){
		if($(this).hasClass("yqd")==false){ 
			$.get(weburl+"/member/index.php?m=ajax&c=sign",function(data){ 
				var data=eval('('+data+')');
				if(data.type=='-2'){
					layer.msg('操作失败！',2,8);return false;
				}else{ 
					if(data.type>0){  
						var $_font=$("<div class='f_18 f_red mod_join_coin'>+"+data.integral+"</div>").appendTo("body");
						var $_btned=$(".left_box_zp_qd");
						var pos=$_btned.offset(),btnedH=$_btned.outerHeight();
						var _fontTop=pos.top+2;
						$_font.css({
						  "left":pos.left+30,
						  "top":_fontTop,
						  "position":"absolute"
						});
						$_font.animate({
						   "opacity": "show",
						   "top":_fontTop-45
						}, 1500,function(){
							$(this).remove(); 
						}); 
						$(".signdiv .left_box_zp_qd").addClass('yqd');
						$(".signdiv .left_box_zp_qd").html('已签到');
						$("#sign_cal .day"+data.type).addClass('on');
						$("#integral").html(parseInt($("#integral").html())+parseInt(data.integral));
					}  
				}
			}) 
		}
    });

	$("#dingdan_submit").click(function(){
		var paytype=$("input[name=p1]:checked").val();
		var order=$("input[name=dingdan]").val();
		$.post(weburl+"/member/index.php?m=ajax&c=order_type",{order:order,paytype:paytype},function(data){return false;})
	})
	$("input[name=default_resume],.default_resume").click(function(){
		var value=$(this).val();
		if(value==''){value=$(this).attr('value');} 
		$.post(weburl+"/member/index.php?m=ajax&c=default_resume",{eid:value},function(data){
			if(data==0){
				layer.alert('请先登录！', 0, '提示',function(){window.location.href ="index.php?m=login&usertype=1";window.event.returnValue = false;return false;});
			}else if(data==1){ 
				layer.msg('设置成功！', 2, 9,function(){ window.location.reload();window.event.returnValue = false;return false;});return false; 
			}else{ 
				layer.msg('系统出错，请稍后再试！', 2, 8,function(){ window.location.reload();window.event.returnValue = false;return false;});return false; 
			}
		}) 
	}) 
	$(".seemsg").click(function(){
		var id=$(this).attr("id");
		$.post("index.php?c=up_msg",{id:id},function(msg){
			if(msg==1){
				$("#msg"+id).toggle();
			}else{
				layer.msg('非法操作！', 2,8);return false; 
			}
		});
	})
	$("#colse_box").click(function(){$('.job_box').hide();})
	$("#price_int").blur(function(){
		var value=parseInt($(this).val());
		var min_recharge=$("input[name='integral_min_recharge']").val();
		if(min_recharge>0&&value<min_recharge){
			value=min_recharge;
			$("#price_int").val(value);
		}
		var proportion=$(this).attr("int");
		var price=value/proportion;
		$("#com_vip_price").val(price);
		$("#span_com_vip_price").html(price);
	}) 
	$(".province").change(function(){
		var province=$(this).val();
		var lid=$(this).attr("lid");
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
		$.post(weburl+"/index.php?m=ajax&c=ajax&"+timestamp, {"str":province},function(data) {  
			if(lid!="" && data!=""){
				$('#'+lid+' option').remove();
				$(data).appendTo("#"+lid);
				city_type(lid); 
			}
		})
	})
	$(".job1").change(function(){
		var province=$(this).val();
		var lid=$(this).attr("lid");
		$.post(weburl+"/index.php?m=ajax&c=ajax_job&"+timestamp, {"str":province},function(data) {
			if(lid!="" && data!=""){
				$('#'+lid+' option').remove();
				$(data).appendTo("#"+lid);
				job_type(lid);
			}
		})
	})
	$(".jobone").change(function(){
		var province=$(this).val();
		var lid=$(this).attr("lid");
		$.post(weburl+"/index.php?m=ajax&c=ajax_ltjob&"+timestamp, {"str":province},function(data) {
			if(lid!="" && data!=""){
				$('#'+lid+' option').remove();
				$(data).appendTo("#"+lid);
			}
		})
	})
	$("#details-ul li").click(function(){
		$("#details-ul li").attr("class","");
		$(this).attr("class","hover");
		$(".xinxi-guanli-box").hide();
		var name=$(this).attr("name");
		$("#details-con-"+name).show();
	})
})
 
function city_type(id){
	var id;
	var province=$("#"+id).val();
	var lid=$("#"+id).attr("lid");
	$.post(weburl+"/index.php?m=ajax&c=ajax&"+timestamp, {"str":province},function(data) {
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
function showrebate(id,url){
	$.post(url, {id:id},function(data) {
		 var data=eval('('+data+')');
			$("#rebateuname").html(data.uname); 
			$("#rebatesex").html(data.sex); 
			$("#rebatebirthday").html(data.birthday); 
			$("#rebateedu").html(data.edu); 
			$("#rebateexp").html(data.exp); 
			$("#rebatetelphone").html(data.telphone); 
			$("#rebateemail").html(data.email); 
			$("#rebatehy").html(data.hy); 
			$("#rebatejob_classid").html(data.job_classid); 
			$("#rebatecity").html(data.city); 
			$("#rebatesalary").html(data.salary); 
			$("#rebatetype").html(data.type); 
			$("#rebatereport").html(data.report); 
			$("#rebatecontent").html(data.content); 
			$.layer({
				type : 1,
				title :'人才详情',  
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['600px','auto'],
				page : {dom :"#showrebate"}
			});
	})
}
function job_type(id){
	var id;
	var province=$("#"+id).val();
	var lid=$("#"+id).attr("lid");
	$.post(weburl+"/index.php?m=ajax&c=ajax_job&"+timestamp, {"str":province},function(data) {
		if(lid!="" && data!=""){
			$('#'+lid+' option').remove();
			$(data).appendTo("#"+lid);
		}
	})
}
function check_form(ifidname,byidname){
	var ifidname;
	var byidname;
	if (ifidname){ 
		var msg=$("#"+byidname).html(); 
		layer.msg(msg, 2, 8);return false;
	}else{
		$("#"+byidname).hide(); 
		return true;
	}
}
function isQQ(QQ) {
	var QQreg=/[1-9][0-9]{4,}/;
	if (QQreg.test(QQ)){
		return true;
	}else{
		return false;
	}
}
function check_url(strUrl){
	var Reg=/^((([hH][tT][tT][pP][sS]?|[fF][tT][pP])\:\/\/)?([\w\.\-]+(\:[\w\.\&%\$\-]+)*@)?((([^\s\(\)\<\>\\\"\.\[\]\,@;:]+)(\.[^\s\(\)\<\>\\\"\.\[\]\,@;:]+)*(\.[a-zA-Z]{2,4}))|((([01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}([01]?\d{1,2}|2[0-4]\d|25[0-5])))(\b\:(6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]\d{4}|[1-9]\d{0,3}|0)\b)?((\/[^\/][\w\.\,\?\'\\\/\+&%\$#\=~_\-@]*)*[^\.\,\?\"\'\(\)\[\]!;<>{}\s\x7F-\xFF])?)$/;
	if (Reg.test(strUrl)){
		return true;
	}else{
	    return false;
	}
}
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
 }
function isjsMobile(obj){
	if(obj.length!=11) return false;
	else if (obj.substring(0, 2) != "13" && obj.substring(0, 2) != "14" && obj.substring(0, 2) != "15" && obj.substring(0, 2) != "18" && obj.substring(0, 2) != "17") return false;
	else if(isNaN(obj)) return false;
	else  return true;
}
function isjsTell(str) {
    var result = str.match(/\d{3}-\d{8}|\d{4}-\d{7}/);
    if (result == null) return false;
    return true;
}
function checkIdcard(num){
   var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;  
   if(reg.test(num) === false)  
   {  
       return  false;  
   }  
}
function isIdCardNo(v_card)
{
	
   var reg=/^d{15}(d{2}[0-9X])?$/i;

   if (!reg.test(v_card)){
       return false;
   }

   if(v_card.length==15){
       var n=new Date();
       var y=n.getFullYear();
       if(parseInt("19" + v_card.substr(6,2)) <1900 || parseInt("19" + v_card.substr(6,2)) >y){
           return false;
       }
       var birth="19" + v_card.substr(6,2) + "-" + v_card.substr(8,2) + "-" + v_card.substr(10,2);
       if(!isDate(birth)){
           return false;
       }
   }
   if(v_card.length==18){
       var n=new Date();
       var y=n.getFullYear();
       if(parseInt(v_card.substr(6,4)) <1900 || parseInt(v_card.substr(6,4)) >y){
           return false;
       }
       var birth=v_card.substr(6,4) + "-" + v_card.substr(10,2) + "-" + v_card.substr(12,2);
       if(!isDate(birth)){
           return false;
       }
       iW=new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
       iSum=0;
       for( i=0;i<17;i++){
           iC=v_card.charAt(i);
           iVal=parseInt(iC);
           iSum += iVal * iW[i];
       }
       iJYM=iSum % 11;
       if(iJYM == 0) sJYM="1";
       else if(iJYM == 1) sJYM="0";
       else if(iJYM == 2) sJYM="x";
       else if(iJYM == 3) sJYM="9";
       else if(iJYM == 4) sJYM="8";
       else if(iJYM == 5) sJYM="7";
       else if(iJYM == 6) sJYM="6";
       else if(iJYM == 7) sJYM="5";
       else if(iJYM == 8 ) sJYM="4";
       else if(iJYM == 9) sJYM="3";
       else if(iJYM == 10) sJYM="2";
       var cCheck=v_card.charAt(17).toLowerCase();
       if( cCheck != sJYM ){
           return false;
       }
   }
   try{
       var lvAreaId=v_card.substr(0,2);
       return lvAreaId == "11" || lvAreaId == "12" || lvAreaId == "13" || lvAreaId == "14" || lvAreaId == "15" || lvAreaId == "21" || lvAreaId == "22" || lvAreaId == "23" || lvAreaId == "31" || lvAreaId == "32" || lvAreaId == "33" || lvAreaId == "34" || lvAreaId == "35" || lvAreaId == "36" || lvAreaId == "37" || lvAreaId == "41" || lvAreaId == "42" || lvAreaId == "43" || lvAreaId == "44" || lvAreaId == "45" || lvAreaId == "46" || lvAreaId == "50" || lvAreaId == "51" || lvAreaId == "52" || lvAreaId == "53" || lvAreaId == "54" || lvAreaId == "61" || lvAreaId == "62" || lvAreaId == "63" || lvAreaId == "64" || lvAreaId == "65" || lvAreaId == "71" || lvAreaId == "82" || lvAreaId == "82";
   }
   catch(ex){
   }

   return true;
}

function isDate(strDate) {
   var strSeparator="-";
   var strDateArray;
   var intYear;
   var intMonth;
   var intDay;
   var boolLeapYear;
   strDateArray=strDate.split(strSeparator);
   if (strDateArray.length != 3) 
       return false;
   intYear=parseInt(strDateArray[0], 10);
   intMonth=parseInt(strDateArray[1], 10);
   intDay=parseInt(strDateArray[2], 10);
   if (isNaN(intYear) || isNaN(intMonth) || isNaN(intDay)) 
       return false;
   if (intMonth >12 || intMonth <1) 
       return false;
   if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) &&(intDay >31 || intDay <1)) 
       return false;
   if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) &&(intDay >30 || intDay <1)) 
       return false;
   if (intMonth == 2) {
       if (intDay <1) 
           return false;
       boolLeapYear=false;
       if ((intYear % 100) == 0) {
           if ((intYear % 400) == 0) 
               boolLeapYear=true;
       }else {
           if ((intYear % 4) == 0) 
               boolLeapYear=true;
       }
       if (boolLeapYear) {
           if (intDay >29) 
               return false;
       }else {
           if (intDay >28) 
               return false;
       }
   }
   return true;
}
function checkDate(date){return true;}
$(document).ready(function(){
	$("#wysc").click(function(){
		$("#uploadname").val('');
		$("#upload_img").css("top","10%");
		$("#upload_img").show();
		$("#bg").show();
	})
	$("#qd").click(function(){
		var name=$("#uploadname").val();
		if(name==""){$("#close").click();return false;}
		var namearr=name.split("###");
		var i,upload="";
		for(i=0;i<namearr.length;i++){
			var num=i+1;
			upload+='<dd style="height:auto;" id="list'+i+'"><div style="float:left;"><img src="..'+namearr[i]+'" width="100" height="100"/></div><div style="float:left; margin-left:10px; line-height:30px;"><div><input class="imgshow" type="hidden" value="'+namearr[i]+'" />名称：<input class="titleshow" type="text" size="28" maxlength="10" value="环境展示'+num+'" /></div><div style="text-align:left;"><a href="javascript:del_upload(\''+namearr[i]+'\',\''+i+'\');">取消删除</a></div></div><div style="clear:both; height:5px;"></div></dd>';
		}
		$("#trlistone dl").html(upload);
		$("#trlistone").show();
		$("#trlisttwo").hide();
		$("#close").click();
	})
	$("#close").click(function(){
		$("#upload_img").hide();
		$("#bg").hide();
	})
})
function del_upload(dir,list){
	$.post(weburl+"/member/index.php?m=ajax&c=delupload&"+timestamp, {"str[]":[dir]},function(data) {
		if(data){
			$("#list"+list).remove();
			var upload=$("#trlistone dl").html();
			if(upload==""){
				$("#trlistone").hide();
				$("#trlisttwo").show();
			}
		}
	})
}

function checkshare(){
	var re = /^-?[0-9]*(\.\d*)?$|^-?d^(\.\d*)?$/;
	var smallday = $.trim($("#smallday").val());
	if(smallday!=""){
		if (!re.test(smallday)){
			layer.msg('购买天数填写不正确！', 2, 8);return false;  
		}
	}else{
		layer.msg('购买天数不能为空！', 2, 8);return false;   
	}
	return true;
}
 
$(function(){
	$(".zphstatus").click(function(){
		var loadi = layer.load('执行中，请稍候...',0);
		var zid=$(this).attr("zid");
		var pid=$(this).attr("pid");
		$.get(weburl+"/member/index.php?m=ajax&c=getzphcom&jobid="+pid+"&zid="+zid, function(data){
			layer.close(loadi);
		    var data=eval('('+data+')'); 
			$("#title").html(data.title); 
			$("#stime").html(data.starttime); 
			$("#etime").html(data.endtime); 
			$("#address").html(data.address); 
			$("#cname").html(data.content); 
			$("#sid").html(data.sid); 
			$("#bid").html(data.bid); 
			$("#cid").html(data.cid); 
			$.layer({
				type : 1,
				title :'我的职位',  
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['380px','auto'],
				page : {dom :"#infobox"}
			}); 
		});
	}); 
	
});
function left_banner(id){
	var style=document.getElementById('left'+id).style.display;
	if(style=="none"){
		$("#left"+id).show();
	}else{
		$("#left"+id).hide();
	}
}
function m_checkAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.Name != 'checkAll'&&e.disabled==false)
		e.checked = form.checkAll.checked; 
	}
} 
function really(name){
	var chk_value =[];    
	$('input[name="'+name+'"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});   
	if(chk_value.length==0){
		layer.msg("请选择要删除的数据！",2,8);return false;
	}else{
		layer.confirm("确定删除吗？",function(){
			setTimeout(function(){$('#myform').submit()},0); 
		});
	} 
} 
function search_show(id){
    $(".cus-sel-opt-panel").hide();
	var obj=document.getElementById(id);
	if(obj.style.display=='none'){
		$("#"+id).show();
	}else{
		$("#"+id).hide();
	}
}
function CheckForm(){
	var chk_value =[];    
	$('input[name="usertype"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});
	if(chk_value.length==0){
		layer.msg("请选择购买类型！",2,8);return false;
	}
}
function pay_form(name){
	if($("#comvip").length!=0&&$("#comvip").val()==''){ 
		layer.msg("请选择购买类型！",2,8);return false;
	}
	if($("#price_int").length!=0&&$("#price_int").val()<1){ 
		layer.msg(name,2,8);return false; 
	} 
}
function Showsub1(){
	var oldpass = $("#oldpassword").val();
	var pass = $("#password").val();
	var repass = $("#repassword").val();
	oldpass=$.trim(oldpass);
	pass=$.trim(pass);
	repass=$.trim(repass);
	var flag = true;
	if(oldpass==""){
		$("#msg_oldpassword").html("<font color='red'>原始密码不能为空!</font>");
		flag = false;
	} else if(oldpass.length<6 || oldpass.length>20){
		$("#msg_oldpassword").html("<font color='red'>密码需在 6-20个字符之内!</font>");
		flag = false;
	} else{
		$("#msg_oldpassword").html("<font color='#008000'>输入成功!</font>");
	}
	if(pass==""){
		$("#msg_password").html("<font color='red'>新密码不能为空!</font>");
		flag = false;
	}else if(pass.length<6 || pass.length>20){
		$("#msg_password").html("<font color='red'>新密码需在 6-20个字符之内!</font>");
		flag = false;
	}else{
		$("#msg_password").html("<font color='#008000'>输入成功!</font>");
	}
	if(repass==""){
		$("#msg_repassword").html("<font color='red'>请再次确认新密码!</font>");
		flag = false;
	}else if(repass.length<6 || repass.length>20){
		$("#msg_repassword").html("<font color='red'>新密码需在 6-20个字符之内!</font>");
		flag = false;
	} if(repass!=pass){
		$("#msg_repassword").html("<font color='red'>两次密码输入不一致，请重新输入!</font>");
		flag = false;
	}else if(repass==pass && repass!=""){
		$("#msg_repassword").html("<font color='#008000'>输入成功!</font>");
	}
	if(oldpass!=""&&oldpass==pass){
		layer.msg("原始密码和新密码一致，不需要修改！",2,8);return false;
	}
	return flag;
}


function reply_xin(id,uid,name,content){
	$("#pid").val(id);
	$("#fid").val(uid);
	$("#wnc").html("<div class='Reply_cont_name'><font color='#0066FF'>"+name+"</font> 给您留言：</div>"+content); 
	$.layer({
		type : 1,
		title : '回复',
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['450px','auto'],
		page : {dom : '#reply'}
	});
} 
function check_xin(){
	if($("#content").val()==""){
		layer.msg('回复内容不能为空！', 2, 8);return false; 
	}	
}
function Showsub(){ 
	 var con = $("#content").val();
 	 con=$.trim(con);
	 if(con==""){layer.msg('请提出您的问题和建议！', 2, 8);return false;}			
}
function zhankaiShouqi(control){
	$(control).parent().find('.job_add_y_list:gt(4)').slideToggle(1000);
	if($(control).html()=='更多'){
		$(control).html('收起');
	}else{
		$(control).html('更多');
	}
}

$(function () {
    $('.admincont_box').delegate('#keyword', 'focus', function () {
        if ($(this).val() == $(this).attr('placeholder')) {
            $(this).val('');
        }
    });
    $('body').click(function (evt) {
        if (evt.target.id != "status") {
            $('#status').next().next().hide();
        }
        if (evt.target.id != "province") {
            $('#province').next().next().hide();
        }           
        if (evt.target.id != "pr_button") {
            $('#pr_button').next().next().hide();
        }
        if (evt.target.id != "hy_button") {
            $('#hy_button').next().next().hide();
        }
        if (evt.target.id != "mun_button") {
            $('#mun_button').next().next().hide();
        }
        if (evt.target.id != "jobone_button") {
            $('#jobone_button').next().next().hide();
        }
        if (evt.target.id != "jobtwo_button") {
            $('#jobtwo_button').next().next().hide();
        }
        if (evt.target.id != "salary_button") {
            $('#salary_button').next().next().hide();
        }
        if (evt.target.id != "age_button") {
            $('#age_button').next().next().hide();
        }
        if (evt.target.id != "sex_button") {
            $('#sex_button').next().next().hide();
        }
        if (evt.target.id != "exp_button") {
            $('#exp_button').next().next().hide();
        }
        if (evt.target.id != "full_button") {
            $('#full_button').next().next().hide();
        }
        if (evt.target.id != "edu_button") {
            $('#edu_button').next().next().hide();
        }
        if (evt.target.id != "citys") {
            $('#citys').next().next().hide();
        }
        if (evt.target.id != "exp_button") {
            $('#exp_button').next().next().hide();
        }
        if (evt.target.id != "title_button") {
            $('#title_button').next().next().hide();
        }
        if (evt.target.id != "sid_button") {
            $('#sid_button').next().next().hide();
        }
        if (evt.target.id != "nid_button") {
            $('#nid_button').next().next().hide();
        }
        if (evt.target.id != "tnid") {
            $('#tnid').next().next().hide();
        }
        if (evt.target.id != "sid") {
            $('#sid').next().next().hide();
        }
        if (evt.target.id != "jobstatus") {
            $('#jobstatus').next().next().hide();
        }
        if (evt.target.id != "teachid_button") {
            $('#teachid_button').next().next().hide();
        }
	if($(evt.target).parents("#job_hy").length==0 && evt.target.id != "hy") {
	   $('#job_hy').hide();
	}
	if($(evt.target).parents("#job_qyhy").length==0 && evt.target.id != "qyhy") {
	   $('#job_qyhy').hide();
	}
	if($(evt.target).parents("#job_pr").length==0 && evt.target.id != "pr") {
	   $('#job_pr').hide();
	}
	if($(evt.target).parents("#job_lt_salary").length==0 && evt.target.id !="lt_salary"){
	    $('#job_lt_salary').hide();
	}
	if($(evt.target).parents("#job_lt_full").length==0 && evt.target.id !="lt_full"){
	    $('#job_lt_full').hide();
	}	
	if($(evt.target).parents("#job_salary").length==0 && evt.target.id != "salary") {
	   $('#job_salary').hide();
	}
	if($(evt.target).parents("#job_report").length==0 && evt.target.id != "report") {
	   $('#job_report').hide();
	}	
	if($(evt.target).parents("#job_uptime").length==0 && evt.target.id != "uptime") {
	   $('#job_uptime').hide();
	}	
	
    if($(evt.target).parents("#infostatusid").length==0 && evt.target.id != "infostatus") {
	   $('#job_infostatus').hide();
	}

    if($(evt.target).parents("#moneytypeid").length==0 && evt.target.id != "moneytype") {
	   $('#job_moneytype').hide();
	}

	if($(evt.target).parents("#job_province").length==0 && evt.target.id != "province") {
	   $('#job_province').hide();
	}	
	if($(evt.target).parents("#job_twocity").length==0 && evt.target.id != "twocity") {
	   $('#job_twocity').hide();
	}
	if($(evt.target).parents("#job_cityid").length==0 && evt.target.id != "cityid") {
	   $('#job_cityid').hide();
	}	
	if($(evt.target).parents("#job_threecity").length==0 && evt.target.id != "threecity") {
	   $('#job_threecity').hide();
	}
	if($(evt.target).parents("#job_three_cityid").length==0 && evt.target.id != "three_cityid") {
	   $('#job_three_cityid').hide();
	}	
	if($(evt.target).parents("#job_skillc").length==0 && evt.target.id != "skillc") {
	   $('#job_skillc').hide();
	}
	if($(evt.target).parents("#job_level").length==0 && evt.target.id != "level") {
	   $('#job_level').hide();
	}	
	if($(evt.target).parents("#job_marriage").length==0 && evt.target.id != "marriage") {
	   $('#job_marriage').hide();
	}
	if($(evt.target).parents("#job_educ").length==0 && evt.target.id != "educ") {
	   $('#job_educ').hide();
	}
	if($(evt.target).parents("#job_edu").length==0 && evt.target.id != "edu") {
	   $('#job_edu').hide();
	}	
	if($(evt.target).parents("#job_type").length==0 && evt.target.id != "type") {
	   $("#job_type").hide();
	}
	if($(evt.target).parents("#job_salary_type").length==0 && evt.target.id != "salary_type") {
	   $("#job_salary_type").hide();
	}
	if($(evt.target).parents("#job_billing_cycle").length==0 && evt.target.id != "billing_cycle") {
	   $("#job_billing_cycle").hide();
	}
	if($(evt.target).parents("#job_edu").length==0 && evt.target.id != "edu") {
	   $('#job_edu').hide();
	}
	if($(evt.target).parents("#job_mun").length==0 && evt.target.id != "mun") {
	   $("#job_mun").hide();
	}
	if($(evt.target).parents("#job_exp").length==0 && evt.target.id != "exp") {
	   $("#job_exp").hide();
	}
	if($(evt.target).parents("#job_qypr").length==0 && evt.target.id != "qypr") {
	   $("#job_qypr").hide();
	}	
	if($(evt.target).parents("#job_mun").length==0 && evt.target.id != "mun") {
	   $("#job_mun").hide();
	}	
	if($(evt.target).parents("#job_qyprovince").length==0 && evt.target.id != "qyprovince") {
	   $("#job_qyprovince").hide();
	}
	if($(evt.target).parents("#job_ltage").length==0 && evt.target.id != "ltage") {
	   $("#job_ltage").hide();
	}
	if($(evt.target).parents("#job_ltsex").length==0 && evt.target.id != "ltsex") {
	   $("#job_ltsex").hide();
	}
	if($(evt.target).parents("#job_type1").length==0 && evt.target.id != "jobone_name") {
	   $("#job_type1").hide();
	}

	if($(evt.target).parents("#job_ltexp").length==0 && evt.target.id != "ltexp") {
	   $("#job_ltexp").hide();
	}
	if($(evt.target).parents("#job_citys").length==0 && evt.target.id != "citys") {
	   $("#job_citys").hide();
	}	
	if($(evt.target).parents("#job_three_city").length==0 && evt.target.id != "three_city") {
	   $("#job_three_city").hide();
	}	
	if($(evt.target).parents("#job_ltedu").length==0 && evt.target.id != "ltedu") {
	   $("#job_ltedu").hide();
	} 
	if($(evt.target).parents("#job_basic_info").length==0 && evt.target.id != "basic_info") {
	   $("#job_basic_info").hide();
	} 
	if($(evt.target).parents("#job_job1").length==0 && evt.target.id != "job1") {
	   $("#job_job1").hide();
	}
	if($(evt.target).parents("#job_job1_son").length==0 && evt.target.id != "job1_son") {
	   $("#job_job1_son").hide();
	}
	if($(evt.target).parents("#job_job_post").length==0 && evt.target.id != "job_post") {
	   $("#job_job_post").hide();
	} 
	if($(evt.target).parents("#job_number").length==0 && evt.target.id !="number"){
	    $('#job_number').hide();
	}
    if($(evt.target).parents("#job_age").length==0 && evt.target.id !="age"){
	    $('#job_age').hide();
	}	
	if($(evt.target).parents("#job_sex").length==0 && evt.target.id !="sex"){
	    $("#job_sex").hide();
	}
	if($(evt.target).parents("#banklist").length==0 && evt.target.id !="bankname"){
	    $("#banklist").hide();
	}
	if($(evt.target).parents("#job_ltfull").length==0 && evt.target.id !="ltfull"){
	    $("#job_ltfull").hide();
	}
	if($(evt.target).parents("#job_ltsalary").length==0 && evt.target.id !="ltsalary"){
	    $("#job_ltsalary").hide();
	}
	if($(evt.target).parents("#job_jobid").length==0 && evt.target.id !="jobid"){
	    $("#job_jobid").hide();
	}if($(evt.target).parents("#job_circle").length==0 && evt.target.id !="circle"){
	    $("#job_circle").hide();
	}
	if($(evt.target).parents("#job_browse").length==0 && evt.target.id !="browse"){
	    $("#job_browse").hide();
	}
	if($(evt.target).parents("#job_datetime").length==0 && evt.target.id !="datetime"){
	    $("#job_datetime").hide();
	}
	if($(evt.target).parents("#name").length==0 && evt.target.id != "name") {
	   $('#job_name').hide();
	}
	if ($(evt.target).parents(".index_resume_my_n_list").length == 0 && evt.target.id != "show_resume" && !$(evt.target).hasClass('index_resume_my_n_sh') && !$(evt.target).parent().hasClass('index_resume_my_n_sh')) {
	    $(".index_resume_my_n_list").hide();
	}
	if($(evt.target).parents("#job_nametypec").length==0 && evt.target.id !="nametypec"){
	    $("#job_nametypec").hide();
	}
   });
})
function selects(id,type,name){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#"+type+"id").val(id);
	var addtype=$("#addtype").val();
	if(addtype=='addexpect'){
		$("#hid"+type+"id").attr("class","resume_tipok");
		$("#hid"+type+"id").html('');
	}
}
function selectsmoney(id,moneyname,name){
	$("#job_moneytype").hide();
	$("#moneytype").val(name);
	$("#moneytypeid").val(id);
	$(".moneyname").html(moneyname);
}
function select_resume(id,type,name){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#"+type+"id").val(id);
	$("#"+type+"name").val(name);
}
function select_city(id,type,name,gettype,ptype){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#" + type + "id").val(id);
	$('#by_citysid').html('');
	if(type=='qyprovince'){
		$("#citysid").val('');
	} 
	if(type=='province'){
		$("#citys").val('请选择城市');
		$("#cityshowth").hide();
		$("#three_city").val('请选择区域');
		$("#citysid").val('');
		$("#three_cityid").val('');
	} 
	if(type=='job1'){
		$("#job1_son").val('请选择职位');
		$("#job1_sonid").val('');
		$("#job_post").val('请选择职位'); 
		$("#job_postid").val('');
	}
	var addtype=$("#addtype").val();
	if(addtype=='addexpect'){
		$("#hid"+type+"id").attr("class","resume_tipok");
		$("#hid"+type+"id").html('');
	}
	var sqjobresume=$("#sqjobresume").val();
	if(sqjobresume==1){
		var url=weburl+"/index.php?m=ajax&c=ajax_city";
	}else{
		var url=weburl+"/member/index.php?m=ajax&c=ajax_city";
	}
	$.post(url,{id:id,gettype:gettype,ptype:ptype},function(data){
		var jobaddtype=$("#jobaddtype").val();
		var ndata = data;
		if(jobaddtype=="lietou"){
			data='<div class="m_post_job01">'+data+'</div>';
		}else if(jobaddtype=="ltinfo"){
			data='<div class="m_name_area">'+data+'</div>';
		}
		if(ptype=='job'){ 
			$("#job_"+gettype).html(data);
			if(gettype=="job1_son"){
				if(data==""){
					$("#job_"+gettype).hide();
				}else{
					$("#job_"+gettype).show();
				}
			}else if(gettype=="job_post"){
				$("#job_post").parents().show();
				$("#job_"+gettype).show();
			}
			
		}else{
			if(gettype=="citys"){
				$("#"+gettype).val("请选择城市");$("#cityshowth").hide();
			} 
			if(gettype=="three_city"){$("#"+gettype).val("请选择区域");} 
			$("#job_"+gettype).html(data);
			if(type=='citys'){
				$("#three_cityid").val('');
				if(ndata!=''){
					$("#cityshowth").show();
				}
				
				if(jobaddtype=="ltinfo"){
					$("#by_citysid").attr("class","m_name_gh");
				}
			}else{
				$("#by_citysid").attr("class","");
			}

		} 
	})
}  

function three_city_show(id){
    var citysid=$("#citysid").val();
	if(citysid!=""){
		$(".cus-sel-opt-panel").hide();
	    $("#"+id).show();
	}
}
function selectjobone(id,type,name,gettype){
	$("#"+type).val(id);
	$("#"+type+"_name").val(name);
	$("#jobtwo").val("");
	$("#jobtwo_name").val("请选择");
	$.post(weburl+"/member/index.php?m=ajax&c=ajax_ltjobone&"+timestamp, {"str":id},function(data) {
		if(data!=""){
			$('#job_type2').find("ul").html(data); 
		}
	});
	$("#job_type1").hide();
}
function selectjobtwo(id,type,name,gettype){
	$("#"+type).val(id);
	$("#"+type+"_name").val(name);
	$("#job_type2").hide();
}
function checktpl(id,price){

	var	buytpl=$("#buytpl_"+id).val();
	var name=$("input[name=tplname"+id+"]").val();
	var msg;
	var p=$("#list_tpl_"+id).html().replace("模板价格：","");
	$('#tplid').val(id);
	var bannernum=$("input[name=bannernum]").val();
	if(buytpl==1){
		msg="确定使用该模板？";
	}else{
		if(parseInt(price)=="0"){
			msg="确定使用该模板？";
		}else{
			msg="确定使用"+name+",扣除"+p+"？";
		}
	}
	layer.confirm(msg,function(){ 
		setTimeout(function(){$('#myform').submit()},0);
		if(bannernum==0){
			layer.msg("设置成功！",2,9,function(){
				window.location.href=weburl+"/member/index.php?c=comtpl";return false;
			});
		}else{
			var i =$.layer({ 
				area : ['320px','140px'],
				dialog:{
					msg:'设置成功,请前往上传企业横幅广告！',					
					btns:2,
					type:4,
					btn:['前去上传','取消'],
					yes:function(){window.location.href=weburl+"/member/index.php?c=banner";window.event.returnValue = false;return false;},
					no:function(){layer.close(i);window.location.href=window.location.href;}
				}
			});
		}
	}); 
}
function job_refresh(){
	layer.confirm("刷新次数已用完，是否先购买特权？",function(){
		window.location.href =weburl+"/member/index.php?c=right";window.event.returnValue = false;return false; 
	});
}
function job_edit(){
	layer.confirm("修改次数已用完，是否先购买特权？",function(){
		window.location.href =weburl+"/member/index.php?c=right";window.event.returnValue = false;return false; 
	});
}
function really_read(name){ 
	var chk_value =[];    
	$('input[name="'+name+'"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});   
	if(chk_value.length==0){
		layer.msg("请选择要阅读的数据！",2,8);return false;
	}else{
		layer.confirm("确定阅读吗？",function(){
			$.post("index.php?c=hr&act=hrset",{ids:chk_value,ajax:1},function(data){
				var data=eval('('+data+')');
				if(data.url=='1'){
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.reload();window.event.returnValue = false;return false;});return false;
				}else{
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;
				}
			})
		});
	} 
}

function really_rebates(name){ 
	var chk_value =[];    
	$('input[name="'+name+'"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});   
	if(chk_value.length==0){
		layer.msg("请选择要阅读的数据！",2,8);return false;
	}else{
		layer.confirm("确定阅读吗？",function(){
			$.post("index.php?c=rebates&act=hrset",{ids:chk_value,ajax:1},function(data){ 
				var data=eval('('+data+')');
				if(data.url=='1'){
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.reload();window.event.returnValue = false;return false;});return false;
				}else{
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;
				}
			})
		});
	} 
}
function really_quxiao(name){ 
	var chk_value =[];    
	$('input[name="'+name+'"]:checked').each(function(){    
		chk_value.push($(this).val());   
	});   
	if(chk_value.length==0){
		layer.msg("请选择要取消的数据！",2,8);return false;
	}else{
		layer.confirm("确定取消吗？",function(){
			$.post("index.php?c=job&act=is_browse",{ids:chk_value,ajax:1},function(data){ 
				var data=eval('('+data+')');
				if(data.url=='1'){
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.reload();window.event.returnValue = false;return false;});return false;
				}else{
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){window.location.href=data.url;window.event.returnValue = false;return false;});return false;
				}
			})
		});
	} 
}

function del_pay(oid){ 
	layer.confirm('是否取消该订单？', function(){
		$.get("index.php?c=paylog&act=del&id="+oid,function(msg){
			if(msg=='0'){
				layer.msg('非法操作！', 2, 8);return false;  
			}else{
				layer.msg('取消成功！', 2, 9,function(){window.location.reload();window.event.returnValue = false;return false;});return false;  
			}
		});
	});  
} 
function paylog_remark(){ 
	var id=$("#paylog_id").val();
	var content=$.trim($("#alertcontent").val());
	if(id<1){
		layer.msg('非法操作！', 2, 8);return false; 
	}
	if(content==''){
		layer.msg('备注内容不能为空！', 2, 8);return false; 
	} 
}
function check_rating_coupon(id){
	var value=$("#comvip option:selected").attr("price");
	if(value!=""){
		$("#com_vip_price").val(value);
		$("#span_com_vip_price").html(value);
	}else{
		$("#com_vip_price").val('0');
		$("#span_com_vip_price").html('0');
	}
	
}

function switchJob(num,element,classname,itemCommonclassname,itemclassname){
	$("."+classname).removeClass(classname+"_on");
	$(element).addClass(classname+"_on");
	$("."+itemCommonclassname).hide();
	$("."+itemclassname).show();
}
function resumetop(eid,date,name){
	$("input[name='eid']").val(eid);
	$("#topdate").html(date);
	$("#resumename").html(name);
	$.layer({
		type : 1,
		title :'简历置顶', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['550px','350px'],
		page : {dom :"#resumetop"}
	});
}
function returnmessage(frame_id){ 
	if(frame_id==''||frame_id==undefined){
		frame_id='supportiframe';
	}
	var message = $(window.frames[frame_id].document).find("#layer_msg").val(); 
	if(message != null){
		if(message=='验证码错误！'){$("#vcode_img").trigger("click");}
		if(message=='请点击按钮进行验证！'){
			$("#popup-submit").trigger("click");
		}
		var url=$(window.frames[frame_id].document).find("#layer_url").val();
		var layer_time=$(window.frames[frame_id].document).find("#layer_time").val();
		var layer_st=$(window.frames[frame_id].document).find("#layer_st").val();
		if(url=='1'){
			layer.msg(message, layer_time, Number(layer_st),function(){window.location.reload();window.event.returnValue = false;return false;});
		}else if(url==''){
			layer.msg(message, layer_time, Number(layer_st));
		}else{
			layer.msg(message, layer_time, Number(layer_st),function(){window.location.href = url;window.event.returnValue = false;return false;});
		}
	}
}

function jobadd_url(num,integral_job,integral_pricename,type){
	if(type=="part"){
		var gourl='index.php?c=partadd';
	}else if(Number(type)>0){
		var gourl='index.php?c=jobadd&act=edit&jobcopy='+type;
	}else{
		var gourl='index.php?c=jobadd';
	} 
	if(num==0){
		var msg='套餐已用完，请先购买会员，<br>您还可以<a href="index.php?c=right&act=added" style="color:red;">购买增值包</a>！';
		layer.confirm(msg, function(){window.location.href='index.php?c=right';window.event.returnValue = false;return false;})
	}else if(num==1){
		window.location.href=gourl;window.event.returnValue = false;return false;
	}else if(num==2){
		var msg='套餐已用完，继续操作将会扣除'+integral_job+' '+integral_pricename+'，您还可以<a href="index.php?c=right&act=added" style="color:red">购买增值包</a>，是否继续？';
		layer.confirm(msg, function(){window.location.href=gourl;window.event.returnValue = false;return false;});
	}
}

function Savenamepost(){
	var username = $.trim($("#username").val());
	var pass = $.trim($("#password").val());
	var repass = $.trim($("#repassword").val());
	if(username.length<2 || username.length>16){
		layer.msg("用户名长度应该为2-16位！",2,8);return false;
	}
	if(pass.length<6 || pass.length>20){
		layer.msg("密码长度应该为6-20位！",2,8);return false;
	}
	if(pass!=repass){
		layer.msg("两次密码不一致！",2,8);return false;
	}
	$.post("index.php?c=setname",{username:username,password:pass},function(data){
		if(data==1){
			layer.msg("修改成功，请重新登录！", 2, 9,function(){window.location.href=weburl+"/index.php?m=login";window.event.returnValue = false;return false;});return false;
		}else{
			layer.msg(data,2,8);return false;
		}
	})
}
function check_show(id){
	$('#'+id).toggle();
	if(id=='job_year'){
		$("#job_month").hide();
		$("#job_day").hide();
	}else if(id=='job_month'){
		$("#job_year").hide();
		$("#job_day").hide();
	}else{
		$("#job_year").hide();
		$("#job_month").hide();
	}
}
function check_out(){
	var resume=$.trim($("#resumeid").val());
	var email=$.trim($("#email").val());
	var comname=$.trim($("#comname").val());
	var jobname=$.trim($("#jobname").val());
	if(resume==""){
		layer.msg("请选择简历！",2,8);return false;
	}
	if(email==""){
		layer.msg("请输入邮箱！",2,8);return false;
	}else if(check_email(email)==false){
		layer.msg("邮箱格式错误！",2,8);return false;
	}
	if(comname==""){
		layer.msg("请输入企业名称！",2,8);return false;
	}
	if(jobname==""){
		layer.msg("请输入职位名称！",2,8);return false;
	}
	layer.load('执行中，请稍候...',0);
}
function cktop(day,price){
	var needs=day*price;
	$("#price").html(needs);
}
function checksex(id){
	$(".yun_info_sex").removeClass('yun_info_sex_cur');
	$("#sex"+id).addClass('yun_info_sex_cur');
	$("#sex").val(id); 
	var addtype=$("#addtype").val();
	if(addtype=='addexpect'){
		$("#hidsex").attr("class","resume_tipok");
		$("#hidsex").html('');
	}
}
function phototype(){
	var phototype=1;
	if($("#phototype").attr("checked")!='checked'){
		phototype=0;
	}
	$.post("index.php?c=info&act=phototype",{phototype:phototype},function(data){
		if(data==1){
			$("#phototype").attr("checked","checked");
			layer.msg("头像不公开操作成功！",2,9);return false;
		}else{
			$("#phototype").remove("checked");
			layer.msg("头像公开操作成功！",2,9);return false;
		}
	})
}


function jobrefresh(id){
	$.post("index.php?c=job&act=refresh",{id:id},function(data){			
	if(data=="1"){
		layer.msg("刷新成功！",2,9,function(){window.location.reload();});return false;
	}	
	})
}
function resumerefresh(id){
	var jobstatus = $.trim($("#jobstatusid").val());
	$.post("index.php?c=resume&act=resumerefresh",{jobstatus:jobstatus,id:id},function(data){			
	if(data=="1"){
		layer.msg("刷新成功！",2,9,function(){window.location.reload();});return false;
	}	
	})
}
function showsys(sys,id,time){
    $("#sysshow").html(sys);
	$("#systime").html(time);
	$("#delsys").attr("onclick","layer_del('确定要删除？', 'index.php?c=sysnews&act=del&id="+id+"');")
    $.layer({
		type : 1,
		title :'消息详情', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['450px','200px'],
		page : {dom :"#show"}
	});
}
function ck_box(id,name){
	$("."+name).removeClass('m_name_tag01');
	$("#"+name+id).addClass('m_name_tag01');
	$("#"+name+"id").val(id); 
	var addtype=$("#addtype").val();
	if(addtype=='addexpect'){
		$("#hid"+name+"id").attr("class","resume_tipok");
		$("#hid"+name+"id").html('');
	}
}