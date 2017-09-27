//认领简历、企业
function claim(url){
	var loadi = layer.load('执行中，请稍候...',0);
	$.get(url,function(data){
		var data=eval('('+data+')');
		layer.close(loadi); 
		$("#claimmsg").html(data.msg);
		$.layer({
			type : 1,
			title :'认领信息', 
			border : [10 , 0.3 , '#000', true],
			area : ['380px','auto'],
			page : {dom :"#status_div"}
		});
	})
}

$(function() {
   $.get(weburl+'/index.php?m=cron');
});

$(function() {
	var offset = 150;
    $(window).scroll(function(){
	( $(this).scrollTop() > offset ) ? $("#header_fix").show() : $("#header_fix").hide();
    });
	$(".header_fixed_login_dl").hover(function(){
	    var t=$(this).attr("did");
		$("#"+t+"_t").show();
	},function(){
	    var t=$(this).attr("did");
	   $("#"+t+"_t").hide();    
	});
});

$(document).ready(function() {
    $(".hp_top_rt_regist").hover(function() {
        $(".hp_top_regist_list").show();
    },function(){
        $(".hp_top_regist_list").hide();
	});
	$('.hp_nav li').hover(function() {
		var aid=$(this).attr('aid');
		$("#nav"+aid).addClass('hp_nav_cur');        
    },function(){
		var aid=$(this).attr('aid');
		$("#nav"+aid).removeClass('hp_nav_cur');
	});
	$('.hp_head_search_job').hover(function() {
        $('.yunHeaderSearch_list_box').show();
    },function(){
        $('.yunHeaderSearch_list_box').hide();
	});
});

function checkCode(id){
	document.getElementById(id).src=weburl+"/app/include/authcode.inc.php?"+Math.random();
}
function get_comindes_jobid(){
	var codewebarr="";
	$("input[name=checkbox_job]:checked").each(function(){ 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	return codewebarr;
}
function search_keyword(myform,defkeyword){
    var keyword = myform.keyword.value;
	if(defkeyword==keyword&&keyword){
		myform.keyword.value='';
	}
}
function check_keyword(name){
	var keyword=$("#keyword").val();
	if(keyword&&keyword==name){$("#keyword").val('');}
}

function search_hide(id){$("#"+id).hide();}
function logout(url,redirecturl){
	$.get(url,function(msg){
		if(msg==1 || msg.indexOf('script')){
			if(msg.indexOf('script')){
				$('#uclogin').html(msg);
			}
			layer.msg('您已成功退出！', 2, 9,function(){window.location.href =redirecturl?redirecturl:weburl;});
		}else{
			layer.msg('退出失败！', 2, 8);
		}
	});
}

$(document).ready(function(){	
	$("#sq_job").click(function(){
		var jobid=$("#jobid").val();
		$.post(weburl+"/index.php?m=ajax&c=index_ajaxjob",{jobid:jobid},function(data){
			if(data==4){
				layer.msg('该职位已邀请您面试，无需再投简历！', 2, 8);
			}else if(!data || data==0){
				showcomlogin();
			}else if(data==2){
				layer.alert('您还没有简历，是否先添加简历？', 0, '提示',function(){window.location.href =weburl+"/member/index.php?c=expect";window.event.returnValue = false;return false; });
			}else if(data==3){
				layer.msg('您已申请过该职位！', 2, 8);
			}else{
				$(".POp_up_r").html('');
				$(".POp_up_r").append(data);
				$.layer({
					type : 1,
					title :'申请职位', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['380px','auto'],
					page : {dom :"#sqjob_show"}
				});
			}
		});
		
	});
	$(".yun_topLogin").hover(function(){
		$(this).find(".yun_More").attr("class","yun_More yun_Morecurrent");
		$(this).find("ul").show();
	},function(){
		$(this).find(".yun_More").attr("class","yun_More");
		$(this).find("ul").hide();
	});
	$(".yun_topNav").hover(function(){
		$(this).find(".yun_navMore").attr("class","yun_navMore yun_webMorecurrent");
		$(this).find(".yun_webMoredown").show();
	},function(){
		$(this).find(".yun_navMore").attr("class","yun_navMore");
		$(this).find(".yun_webMoredown").hide();
	});

	$("#click_sq").click(function(){
		var companyname=$("#companyname").val();
		var jobname=$("#jobname").val();
		var companyuid=$("#companyuid").val();
		var jobid=$("#jobid").val();
		var eid=$("input[name=resume]:checked").val();
		$('#sqjob_show').hide();
		$('#bg').hide();
		layer.closeAll();
		var loadi = layer.load('执行中，请稍候...',0);
		$.post(weburl+"/index.php?m=ajax&c=sq_job",{companyname:companyname,jobname:jobname,companyuid:companyuid,jobid:jobid,eid:eid},function(data){
			layer.close(loadi);
			if(data==4){
				layer.msg('该职位已邀请您面试，无需再投简历！', 2, 8);
			}else if(data==1){  
				var i = $.layer({ 
					area:['auto','auto'],
					dialog:{
						msg:'申请成功，是否继续浏览？',
						btns:2,
						type:1,
						btn:['查看更多','继续浏览'],
						yes:function(){window.location.href=weburl+"/job";window.event.returnValue = false;return false;},
						no:function(){layer.close(i);window.location.href=window.location.href;}
					}
				});
			}else if(data==2){
				layer.msg('系统出错，请稍后再试！', 2,8);return false;
			}else if(data==3){
				layer.msg('您已申请过该职位！', 2,8);return false;
			}else if(data==5){
				layer.msg('该职位已过期，不能申请该职位！', 2, 8);return false;
			}else if(data==6){
				layer.msg('该职位不存在！', 2, 8);return false;
			}else{
				layer.alert('请先登录！',0,'提示',function(){window.location.href="index.php?m=login&usertype=1";window.event.returnValue=false;return false;});
			}
		});
	})

	$(".sq_resume").click(function(){
		var jobtype='';
		var loadi = layer.load('执行中，请稍候...',0);	
		if($(this).attr("uid")){$("#uid").val($(this).attr("uid"));}
		if($(this).attr("username")){$("#username").val($(this).attr("username"));}
		if($(this).attr("jobtype")){jobtype=$(this).attr("jobtype");}
		var jobid;
		jobid = $(this).attr("jobid");
		$("#nameid").val(jobid);
		$.post(weburl+"/index.php?m=ajax&c=indexajaxresume",{show_job:1,jobid:jobid,jobtype:jobtype},function(data){
			layer.close(loadi);
			var buypack=$("#buypack").val();
			var data=eval('('+data+')');
			var status=data.status;
			var integral=data.integral;			
			if(data.jobname){
				$("#name").val(data.jobname);
			}
			if(data.linkman){
				$("#linkman").val(data.linkman);
			}
			if(data.linktel){
				$("#linktel").val(data.linktel);
			}
			if(data.address){
				$("#address").val(data.address);
			}
			if(data.intertime){
				$("#intertime").val(data.intertime);
			}
			if(data.content){
				$("#content").text(data.content);
				$("#update_yq").attr("checked",true);
			}
			if(status == 6){
			    layer.msg('请先登录！', 2,8);return false;
			}
			if(!status || status == 0){
				layer.alert('您不是企业用户，请先登录！', 0, '提示',function(){
					window.location.href =weburl+"/index.php?m=login&usertype=2&type=out"; window.event.returnValue = false;return false;
				});

			}else if(status==1){
				if(buypack==1){
					var msg="邀请面试将扣除"+integral+integral_pricename+"，是否继续？您还可以<a href='"+weburl+"/member/index.php?c=right&act=added' style='color:red;cursor:pointer;'>购买增值包</a>";
				}else{
					var msg="邀请面试将扣除"+integral+integral_pricename+"，是否继续？";
				}
				layer.confirm(msg,function(){
					layer.closeAll();
					$.layer({
						type : 1,
						offset: ['100px', ''],
						title :'邀请面试', 
						closeBtn : [0 , true],
						border : [10 , 0.3 , '#000', true],
						area : ['380px','auto'],
						page : {dom :"#job_box"} 
					});
				});
			}else if(status==2){
				if(buypack==1){
					var msg="你的等级特权已经用完,将扣除"+integral+integral_pricename+"，是否继续？您还可以<a href='"+weburl+"/member/index.php?c=right&act=added' style='color:red;cursor:pointer;'>购买增值包</a>";
				}else{
					var msg="你的等级特权已经用完,将扣除"+integral+integral_pricename+"，是否继续？";
				}
				layer.confirm(msg,function(){
					layer.closeAll();
					$.layer({
						type : 1,
						offset: ['100px', ''],
						title :'邀请面试', 
						closeBtn : [0 , true],
						border : [10 , 0.3 , '#000', true],
						area : ['380px','auto'],
						page : {dom :"#job_box"}
					});
				});
			}else if(status==3){ 
				$.layer({
					type : 1,
					offset: ['100px', ''],
					title :'邀请面试', 
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['380px','auto'],
					page : {dom :"#job_box"}
				});
			}else if(status==4){
				if(buypack==1){
					layer.confirm('会员邀请简历已用完,您还可以购买增值包！', function(){showpacklist();});
				}else{
					layer.msg('会员邀请简历已用完！', 2, 8);return false;
				}
			}else if(status==5){
				layer.msg('您暂无发布中的职位！', 2, 8);return false;
			}
		});
	});
	$("#click_invite").click(function(){
		
		layer.closeAll();
		if($("#jobtype").length>0){
			var jobtype=$("#jobtype").val();
		}else{
			var jobtype=0;
		}
		var uid=$("#uid").val();
		var content=$("#content").val();
		var username=$("#username").val();
		var jobname=$("#name").val();
		var jobid=$("#nameid").val();
		var intertime=$("#intertime").val();
		var linkman=$("#linkman").val();
		var linktel=$("#linktel").val();
		var address=$("#address").val();
		if($("#update_yq").attr("checked")=='checked'){
			var update_yq=1;
		}else{
			var update_yq=0;
		}
		if($.trim(intertime)==""){
			layer.msg('面试时间不能为空！', 2, 8);return false;
		}
		if ((isjsTell(linktel) != true) && (isjsMobile(linktel) != true) && ($.trim(linktel) != '')) {
		    layer.msg('电话格式错误！', 2,8); return false;
		}
		layer.load('执行中，请稍候...',0);
		$.post(weburl+"/index.php?m=ajax&c=sava_ajaxresume",{uid:uid,content:content,username:username,jobname:jobname,update_yq:update_yq,address:address,linkman:linkman,linktel:linktel,intertime:intertime,jobid:jobid,jobtype:jobtype},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			var status=data.status;
			var integral=data.integral;
			if(status==8){
				layer.msg(data.msg, 2, 8);return false;
			}else if(status==9){
				layer.msg('该用户暂无求职需求！', 2, 8);return false;
			}else if(!status || status==0){
				layer.alert('请先登录！', 0, '提示',function(){window.location.href ="index.php?m=login&usertype=2&type=out";window.event.returnValue = false;return false;  });
			}else if(status==5){
				layer.confirm('您还有'+integral+integral_pricename+'！不够邀请面试，是否充值？', function(){window.location.href =weburl+"/member/index.php?c=pay";window.event.returnValue = false;return false;  });
			}else if(status==3){
				layer.msg('您已成功邀请！', 2, 9,function(){location.reload();}); 
			}else if(status==4){
				layer.msg(data.msg, 2, 8,function(){
					$.layer({
						type : 1,
						offset: ['100px', ''],
						title :'邀请面试', 
						closeBtn : [0 , true],
						border : [10 , 0.3 , '#000', true],
						area : ['380px','auto'],
						page : {dom :"#job_box"}
					});
				}); 
			}
		});
	})

	$("input[name=city]").click(function(){
		$('.city_box').show();
	})
	$(".p_t_right").click(function(){
		$("#bg").hide(1000);
		$('.city_box').hide(1000);
	})
	$("#colse_box").click(function(){
		$('.job_box').hide();
	})
	$("#close_job").click(function(){
		var check_val="0";
		var name_val = "不限";
		$("input[type='checkbox'][name='job_box']:checked").each(function(){
		  var info = $(this).val().split("+");
			  check_val+=","+info[0];
			  name_val+="+"+info[1];
		  });
		  check_val = check_val.replace("0,","");
		  $("#qw_job").val(check_val);
		  name_val = name_val.replace("不限+","");
		  $("#qw_show_job").html(name_val);
		  $("#bg").hide(1000);
		  $('#pannel_job').hide(1000);
	})
	$("#click").click(function(){
		var info = $("input[@type=radio][name=cityid][checked]").val();
		var info_arr = info.split("+");
		var name = info_arr[0];
		var id = info_arr[1];
		$("#sea_place").val(name);
		$("#cityid").val(id);
		$("#bg").attr("style","display:none");
		$('.city_box').hide(1000);
	});
	$("#click_head").click(function(){
		var info = $("input[@type=radio][name=cityid][checked]").val();
		var info_arr = info.split("+");
		var name = info_arr[0];
		var id = info_arr[1];
		$("#sea_place_head").val(name);
		$("#cityid_head").val(id);
		$("#bg").hide(1000);
		$('#city_box_head').hide(1000);
	});
	$(".header_seach_find").mouseover(function(){
	    $(".index_header_seach_find_list").show();
	}).mouseout(function(){
	    $(".index_header_seach_find_list").hide();
	});
	$(".header_seach_find_list").mouseover(function(){
	    $(".index_header_seach_find_list").show();
	});
	
	$(".index_search_place").mouseover(function(){
		$(".index_place_position").show();
	}).mouseout(function(){
		$(".index_place_position").hide();
	});
	$(".index_place_position").mouseover(function(){
		$(".index_place_position").show();
	});
	$(".Company_post_ms span").click(function(){
		$(".Company_post_ms span").attr("class","");
		$(this).attr("class","Company_post_cur");
		$(".Company_toggle").hide();
		var name=$(this).attr("name");
		$("#Company_job_"+name).show();
	});

	$(".header_Remind_hover").hover(function(){
		$(".header_Remind_list").show();
		$(".header_Remind_em").addClass("header_Remind_em_hover");
	},function(){
		$(".header_Remind_list").hide();
		$(".header_Remind_em_hover").removeClass("header_Remind_em_hover");
	}); 

	$(".header_fixed_login_after").hover(function(){
		$(".header_fixed_reg_box").show();
	},function(){
		$(".header_fixed_reg_box").hide();
	});
	
	
	if(!isPlaceholder()){
		$("input").not("input[type='password']").each(
		function(){
			if($(this).val()=="" && $(this).attr("placeholder")!=""){
				$(this).val($(this).attr("placeholder"));
				$(this).focus(function(){
					if($(this).val()==$(this).attr("placeholder")) $(this).val("");
				});
				$(this).blur(function(){
					if($(this).val()=="") $(this).val($(this).attr("placeholder"));
				});
			}
		});
		$("textarea").each(
		function(){
			if($(this).val()=="" && $(this).attr("placeholder")!=""){
				$(this).val($(this).attr("placeholder"));
				$(this).focus(function(){
					if($(this).val()==$(this).attr("placeholder")) $(this).val("");
				});
				$(this).blur(function(){
					if($(this).val()=="") $(this).val($(this).attr("placeholder"));
				});
			}
		});
	};
	
})
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
function isPlaceholder(){
    var input = document.createElement('input');
    return 'placeholder' in input;
	var textarea = document.createElement('textarea');
    return 'placeholder' in textarea;
}
function fav_job(id,type){
	$.post(weburl+"/index.php?m=ajax&c=favjobuser",{id:id},function(data){
		if(data==1){
			if(type==1){ 
				$(".scjobid"+id).html("已收藏");
				$(".scjobid"+id).attr('class','yun_job_operation_ysc');
			}else{
				$("#favjobid"+id).html("已收藏");
				$("#favjobid"+id).addClass("comapply_sq_sc_have");
			}
			var i = $.layer({ 
				area : ['auto','auto'],
				dialog : {
					msg:'收藏成功，是否返回个人中心？',
					btns : 2,
					type : 1,
					btn : ['确定','继续浏览'],
					yes : function(){
						window.location.href =weburl+"/member/index.php?c=favorite";window.event.returnValue = false;return false;
					},
					no : function(){
						layer.close(i);
						window.location.href=window.location.href;
					}
				}
			});
		}else if(data==2){
			layer.msg('系统出错，请稍后再试！', 2, 8);return false;
		}else if(data==3){
			layer.msg('您已收藏过该职位！', 2,8);return false;
		}else if(data==0){
			if(type==2){
				$("#touch_lo").hide();
				$("#tologoin").show("1000");
			}else{
				layer.msg('请先登录！', 2, 8);return false;
			}
		}else if(data==4){
			if(type==2){
				$("#touch_lo").hide();
				$("#tologoin").show("1000");
			}else{
				layer.msg('对不起，您不是个人用户，无法收藏职位！', 2, 8);return false;
			}
		}
	});
}
function addwebfav(url,title){
	var title,url;
	if(document.all){
		window.external.addFavorite(url,title);
	}else if(window.sidebar){
		window.sidebar.addPanel(title,url,"");
	}
}
function setHomepage(url){
   var url;
   if(document.all){
	  document.body.style.behavior='url(#default#homepage)';
	  document.body.setHomePage(url);
   }else if(window.sidebar){
		if(window.netscape){
			 try{
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			 }
			 catch(e){
				layer.alert('您的浏览器未启用[设为首页]功能，开启方法：先在地址栏内输入about:config,然后将项 signed.applets.codebase_principal_support 值该为true即可！', 2,8);return false; 
			 }
		}
		var prefs=Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
		prefs.setCharPref('browser.startup.homepage',url);
   }
}
function marquee(time,id){
	$(function(){
		var _wrap=$(id);
		var _interval=time;
		var _moving;
		_wrap.hover(function(){
			clearInterval(_moving);
		},function(){
			_moving=setInterval(function(){
			var _field=_wrap.find('li:first');
			var _h=_field.height();
			_field.animate({marginTop:-_h+'px'},800,function(){
			_field.css('marginTop',0).appendTo(_wrap);
			})
		},_interval)
		}).trigger('mouseleave');
	});
}
function forget(){
	var aucode = $("#txt_CheckCode").val();
	var username =  $("#username").val();
	if(username==""){
		$("#msg_error").html("<font color='red'>请填写你注册时的用户名！</font>");
		return false;
	}
	if(aucode==""){
		$("#msg_error").html("<font color='red'>验证码不能为空！</font>");
		return false;
	}
	return true;
}
function unselectall(){
	if(document.getElementById('chkAll').checked){
		document.getElementById('chkAll').checked = document.getElementById('chkAll').checked&0;
	}
}
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.Name != 'chkAll'&&e.disabled==false)
		e.checked = form.chkAll.checked;
	}
}

function report_com(){
	$.layer({
		type : 1,
		title :'举报该职位', 
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['380px','250px'],
		page : {dom :"#jobreport"}
	});
}

function check_skill(id){
	$(".pop-ul-ul").hide();
	$(".user_tck_box1").removeClass("tanchu");
	$("#showskill"+id).addClass("tanchu");
	$("#skill"+id).show();
}
function box_delete(id){
	$("#sk"+id).remove();
	$("#td_"+id).remove();
	 $("#zn"+id).removeAttr("checked");
}
function checked_input2(id,name,divid,fid){
	var check_length = $("input[type='checkbox'][name='"+name+"'][checked]").length;
	if(name=="job_classid"){
		if($("#zn"+id).attr("checked")=="checked"){
			if(check_length>=5){
				layer.msg('您最多只能选择五个', 2,8);
				$("#zn"+id).attr("checked",false);
			}else{
				var info = $("#zn"+id).val();
				var info_arr = info.split("+");
				if(id==fid){
					$("."+fid).remove();
				}else{
					$("#td_"+fid).remove();
				}
				$("#"+divid).append("<li id='td_"+id+"' class='show_type"+id+" "+fid+"' ><input id='chk_"+id+"' onclick='box_delete("+id+");' type='checkbox' checked value='"+info+"' name='"+name+"'>"+info_arr[1]+"</li>");
			}
		}else{
			$("#td_"+id).remove();
		}
	}
}
$(document).ready(function () {
    $('body').click(function (evt) {
        if (!$(evt.target).parent().hasClass('yunHeaderSearch_s') && !$(evt.target).hasClass('yunHeaderSearch_s') && evt.target.id != 'search_name') {
            $('.yunHeaderSearch_list_box').hide();
        }
    });
	var jobarr=new Array();
	$("#close_skill").click(function(){
		$("#bg").hide();
		$('#skill_box').hide();
		var skill_val = "";
		var i=0;
		$("input[type='checkbox'][name='job_classid']:checked").each(function(){
		  var info = $(this).val().split("+");
			jobarr[i]=info[0];
			i++;
		  skill_val+="<li id=\"sk"+info[0]+"\" class=\"show_type"+info[0]+"\" onclick=\"box_delete('"+info[0]+"');\"><input type=\"checkbox\" name=\"job_classid[]\" checked=\"\" value="+info[0]+"><span>"+info[1]+"</span></li>";
		  });
		$("#job_classid").html(skill_val);
	})
})
function checkmore(type,div,size,msg){
	if(msg=="展开"){
		var msg="收起";
		$("#"+type+" a:gt("+size+")").show();
		$("#"+div).html("<a class=\"yun_close  icon\" href=\"javascript:;\" onclick=\"checkmore('"+type+"','"+div+"','"+size+"','"+msg+"');\">"+msg+"</a>");
	}else{
		var msg="展开";
		$("#"+type+" a:gt("+size+")").hide();
		$("#"+div).show();
		$("#"+div).html("<a class=\"yun_open  icon\" href=\"javascript:;\" onclick=\"checkmore('"+type+"','"+div+"','"+size+"','"+msg+"');\">"+msg+"</a>");
	}
}
function checkrest(url){window.location.href="index.php?m="+url;}
function Close(id){
	$("#"+id).hide();
	$("#bg").hide();
}
function check_pl(){
	if($.trim($("#content").val())==""){
		layer.msg('评论留言内容不能为空！', 2,8);return false;
	}
	var authcode=$("#msg_CheckCode").val();
	if(authcode==''){
		layer.msg('验证码不能为空！', 2, 8);return false;
	} 
}
function huifu(id){
	$("#huifu"+id).show();
}
function check_huifu(id){
	if($("#reply"+id).val()==""){
		layer.msg('回复内容不能为空！', 2,8);return false;
	}
}

function show_im(id){
	$('#WB_webim').find('#im_'+id).click();
}
function add_im(id,type,status,username){
	$('#WB_webim').find('#im_'+id).click();
	var lis=$("#list_content4").find("ul").find("li");
	var ul=$("#list_content4").find("ul");
	var statusHtml='';
	if(status=="1"){
		statusHtml='<span class="W_chat_stat W_chat_stat_online"></span>';
	}else{
		statusHtml='<span class="W_chat_stat W_chat_stat_offline"></span>';
	}
	var typeName='';
	if(type=="2"){
		typeName='企业';
	}else if(type=="1"){
		typeName='个人';
	}
	var lihtml='<li class="clearfix" style="height:20px;line-height:20px;"><div class="webim_list_name" id="right_im_'+type+'"><div class="list_head_state" style="float:left;margin-top:5px; margin-right:5px;">'+statusHtml+'</div><span class="user_name" id="im_'+id+'" uid="'+id+'" usertype="'+type+'" style="float:left;">['+typeName+'] '+username+'</span></div></li>';

	if(lis.length==1){
		if(lis.text()=="暂无好友"){
			ul.html(lihtml);
		}else if(lis.attr("uid")!=id){
			ul.append(lihtml);
		}
	}else{
		var flag=false;
		for(var i in lis){
			if(lis[i].attr("uid")==id){
				flag=true;break;
			}
		}
		if(!flag){
			ul.append(lihtml);
		}
	}
}
function layer_del(msg,url){ 
	if(msg==''){
		var i=layer.load('执行中，请稍候...',0);
		$.ajaxSetup({cache:false});
		$.get(url,function(data){
			layer.close(i);
			var data=eval('('+data+')');
			if(data.url=='1'){
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
			}else{
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
			}
		});
	}else{
		layer.confirm(msg, function(){
			var i=layer.load('执行中，请稍候...',0);
			$.ajaxSetup({cache:false});
			$.get(url,function(data){
				layer.close(i);
				var data=eval('('+data+')');
				if(data.url=='1'){
					layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
				}else{
					layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
				}
			});
		});
	}
}
function top_search(M, name, url, is_module_open, module_dir) {
    if ((is_module_open == '1') && (module_dir != '')) {
        $('#index_search_form #m').attr('name', '');
    } else {
        $('#index_search_form #m').attr('name', 'm');
    }
    $('#index_search_form').attr('action', url);
    $('#index_search_form #m').val(M);
	$(".yunHeaderSearch_list_box").hide();
	$('#search_name').html(name)
}
function top_searchs(M,name){
	$("input[name='m']").val(M);
	$(".index_place_position").hide();
	$('#search_name').html(name)
}
function returnmessage(frame_id){ 
	if(frame_id==''||frame_id==undefined){
		frame_id='supportiframe';
	}
	var message = $(window.frames[frame_id].document).find("#layer_msg").val(); 
	if(message != null){
		var url=$(window.frames[frame_id].document).find("#layer_url").val();
		var layer_time=$(window.frames[frame_id].document).find("#layer_time").val();
		var layer_st=$(window.frames[frame_id].document).find("#layer_st").val();
		if(message=='验证码错误！'){$("#vcode_img").trigger("click");$("#vcodeimgs").trigger("click");}
		if(message=='验证码错误！'){$("#vcode_imgs").trigger("click");}
		if(message=='验证码错误！'){$("#vcodeimgs").trigger("click");}
		if(message=='请点击按钮进行验证！'){
			$("#popup-submit").trigger("click");
		}

		if(url=='1'){
			layer.msg(message, layer_time, Number(layer_st),function(){window.location.reload();window.event.returnValue = false;return false;});
		}else if(url==''){
			layer.msg(message, layer_time, Number(layer_st));
		}else{
			layer.msg(message, layer_time, Number(layer_st),function(){location.replace(url);return false;});
		}
	}
}

function com_msg(){
	noplaceholder('msg_content');
	var msg_content=$.trim($("#msg_content").val());
	if(msg_content==''){
		layer.msg('咨询内容不能为空！', 2,8);return false;
	}
	noplaceholder('msg_CheckCode');
	var authcode=$("#msg_CheckCode").val();
	if(authcode==''){
		layer.msg('验证码不能为空！', 2, 8);return false;
	} 
}

function job_class(id,type,grade){
	if(type=='f'){
		var height=$("#dt_job_"+id).offset().top;
		$("#layout_job .dt_job_"+grade).removeClass('cur');
		$("#layout_job .dd_job_"+grade).hide();
		if(grade=='1'){
			var top=parseInt(height)-parseInt(615);
			$("#layout_job .dd_job_2").hide();
			$("#layout_job .dt_job_2").removeClass('cur');
		}else{ 
			var top=34;
		}
		$("#dt_job_"+id).addClass('cur');
		$("#dd_job_"+id).css("top",top);
		$("#dd_job_"+id).fadeIn("slow");
	}else{
		var check_length = $("input[type='checkbox'][name='job_class'][checked]").length;
		if($("#job_"+id).attr("checked")=="checked"){
			if(check_length>=5){
				layer.msg('您最多只能选择五项！', 2,8,function(){$("#job_"+id).attr("checked",false);}); 
			}else{
				var value=$("#job_"+id).val();
				$("#job_choosed").append("<span id='span_job_"+id+"'><input id='ck_job_"+id+"'  value='"+id+"' onclick=\"del_ck('job_"+id+"')\" name='job_class' checked='checked' type='checkbox' target='"+value+"'>"+value+"</span>");
			}
		}else{
			$("#span_job_"+id).remove();
		}
	}
}
function job_city(id,type,grade){
	if(type=='province'){
		var height=$("#dt_"+id).offset().top;
		if(grade=='1'){
			var top=parseInt(height)-parseInt(570);
		}else{
			var top=34;
		}
		$("#layout_inner .dt_"+grade).removeClass('cur');
		$("#dt_"+id).addClass('cur');
		$("#layout_inner .dd_"+grade).hide();
		$("#dd_"+id).css("top",top);
		$("#dd_"+id).show();
	}else{
		var check_length = $("input[type='checkbox'][name='select_city'][checked]").length;
		if($("#"+id).attr("checked")=="checked"){
			if(check_length>=5){
				layer.msg('您最多只能选择五个城市！', 2,8,function(){$("#"+id).attr("checked",false);}); 
			}else{
				var value=$("#"+id).val();
				$("#choosed").append("<span id='span_"+id+"'><input id='ck_"+id+"'  value='"+id+"' onclick=\"del_ck('"+id+"')\" name='select_city' checked='checked' type='checkbox' target='"+value+"'>"+value+"</span>");
			}
		}else{
			$("#span_"+id).remove();
		}
	}
}
function select_prop(name,id,div){
	var chk_value =[];
	var chk_ids =[];
	$('input[name="'+name+'"]:checked').each(function(){
		chk_value.push($(this).attr('target'));
		chk_ids.push($(this).val());
	});
	if(chk_value.length==0){
		layer.msg('请选择职位类别！', 2,8);return false;
	}else{
		$("#"+id+" dt").removeClass("cur");
		$("#"+id+" dd").hide();
		$("#"+id).val(chk_value);
		$("#"+name).val(chk_ids);
		$("#"+id).removeClass("city_cur");
		$("#"+div).hide();
	}
}
function close_prop(div,id){
	$("#"+div).hide();
	$("#"+id).removeClass("city_cur");
}
function del_ck(id){
	$("#span_"+id).remove();
	$("#"+id).removeAttr("checked");
}

function atn(id,url){
	if(id){
		$.post(url,{id:id},function(data){
			if(data==1){
				$("#atn_"+id).removeClass('zg-btn-unfollow');
				$("#atn_"+id).addClass('zg-btn-green'); 
				if($("#atn_"+id).attr('tagName')=='input'){
					$("#atn_"+id).val("取消关注"); 
				}else{
					$("#atn_"+id).html("取消关注");
				}
				$("#guanzhu"+id).val('取消关注');
				var antnum=$("#antnum"+id).html();
				$("#antnum" + id).html(parseInt(antnum) + 1);//关注数加1
				$("#atn_" + id).addClass('company_att');
			}else if(data==2){
				$("#atn_"+id).removeClass('zg-btn-green');
				$("#atn_"+id).addClass('zg-btn-unfollow attentioned'); 
				if($("#atn_"+id).attr('tagName')=='input'){
					$("#atn_"+id).val("关注"); 
				}else{
					$("#atn_"+id).html("关注");
				}
				$("#guanzhu"+id).val('+关注');
				var antnum=$("#antnum"+id).html();
				$("#antnum" + id).html(parseInt(antnum) - 1);//关注数减1
				$("#atn_" + id).removeClass('company_att');
			}else if(data==3){
				layer.msg('请先登录！只有个人用户才能关注', 2,8);return false;
			}else if(data==4){
				layer.msg('只有个人用户才能关注', 2,8);return false;
			}
		});
	}
}




function jsmsg(id){
	var myuid = $("#myuid").val();
	if(myuid==""){
		layer.msg('你还没有登录！', 2, 8);
	}
	$("#msg"+id).show();
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
function reportSub(img){
	var authcode=$("#report_authcode").val();
	var r_reason=$("#r_reason").val();
	var r_uid=$("#r_uid").val();
	var id=$("#id").val();
	var r_name=$("#r_name").val();
	if($.trim(r_reason)==""){
		layer.msg('举报内容不能为空！', 2, 8);
		return false;
	}
	layer.load('执行中，请稍候...',0);
	$.post(weburl+"/job/index.php?c=report",{authcode:authcode,r_reason:r_reason,id:id,r_name:r_name,r_uid:r_uid},function(data){
		if(data==1){
			layer.msg('验证码不正确！', 2, 8,function(){checkCode(img);});
		}else if(data==2){
			layer.msg('您已经举报过该用户！', 2, 8,function(){checkCode(img);});
		}else if(data==3){
			layer.closeAll();
			layer.msg('举报成功！', 2,9);
		}else if(data==4){
			layer.msg('举报失败！', 2, 8,function(){checkCode(img);});
		}else if(data==5){
			layer.msg('网站已关闭举报功能！', 2, 8,function(){checkCode(img);});
		}
	})
}

function forrecord(id,page){ 
	$.post(weburl+"/index.php?m=ajax&c=jobrecord",{id:id,page:page},function(data){
		$(".Company_job_record_div").html(data);
	});
} 
$(function(){
	$('body').click(function(evt) {
		if($(evt.target).parents("#listhy").length==0 && evt.target.id != "buttonhy") {
			$('#listhy').hide();
		}
	})
});

function checkform_redeem_show(){
	var num=$("#num").val();
	var stock=$("#stock").val();
	var uid=$("#uid").val();
	var restriction=$("#restriction").val();
	if(!uid){
		layer.msg('您还没有登录，请先登录！', 2, 8);
		return false;
	}
	if(num==0){
		layer.msg('请正确填写兑换数量！', 2, 8);
		return false;
	}
	if(Number(num)>Number(restriction) && restriction!="0"){
		layer.msg('超出限购数量,请正确填写！', 2, 8);
		return false;
	}
	if(Number(num)>Number(stock)){
		layer.msg('超出库存数量,请正确填写！', 2, 8);
		return false;
	}
	return true;
}
function redeem_dh(){
	var linkman=$("input[name=linkman]").val();
	var linktel=$("input[name=linktel]").val();
	var password=$("input[name=password]").val();
	if(!linkman || !linktel){
		layer.msg('联系人或联系电话不能为空！', 2, 8);
		return false;
	}
	if(!password){
		layer.msg('请输入密码！', 2, 8);
		return false;
	}
	return true;
}

function noplaceholder(id){
	var value=$("#"+id).val();
	var placeholder=$("#"+id).attr('placeholder');
	if(value==placeholder){
		$("#"+id).val('');
	}
}