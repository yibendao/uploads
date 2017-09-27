$(document).ready(function(){
	$("input[name='cid']").val('');
	$("input[name='keyword']").focus(function(){
		$(".seek_menu").hide();
	},function(){ 
		searchli();
		$(".seek_menu").show(); 
	});
	$("input[name='keyword']").keyup(function(){
		searchli();
	});
	$(".menu_p1_nrtj span").click(function(){
		var aid=$(this).attr('aid');
		$(".review"+aid).hide();
	});
	$('body').click(function(evt) {
		if(evt.target.name!='keyword'){
			$(".seek_menu").hide();
		}
		if($(evt.target).parents(".quiz_chi").length==0) {
			$('.quiz_box').hide();
		}
	});
	$(".quiz_chi span").click(function(){ 
		$(".quiz_box").show();
	});
});
function logout(url){
	$.get(url,function(msg){
		if(msg==1 || msg.indexOf('script')){
			if(msg.indexOf('script')){
				$('#uclogin').html(msg);
			}
			layer.msg('您已成功退出！', 2, 9,function(){window.location.href =weburl;});
		}else{
			layer.msg('退出失败！', 2, 8);
		}
	});
}
function asksearch(){
	noplaceholder('askkeyword');
}
function searchli(){
	noplaceholder('askkeyword');
	var keyword=$.trim($("input[name='keyword']").val());
	var html='';
	$(".seek_menu .option>a").attr("href",keyurl+"&keyword="+keyword);
	$(".seek_menu .option>a").html(keyword);
	if(keyword){ 
		$.post(searchurl,{keyword:keyword},function(data){
			if(data){
				var datas = Array();			
				datas = eval("("+data+")"); 
				$.each(datas,function(key,val){
					html +="<li><p><a href=\""+val.url+"\" target=\"_blank\">"+val.title+"</a></p><span>"+val.answer_num+"个回复</span></li>"; 
				});
			}
			$(".searchli").html(html); 
			
		});
	}else{
		$(".searchli").html(''); 
		$(".seek_menu>span").html(''); 
	}
}
function clearForm(form) {
	$(':input', form).each(function() {
		var type = this.type;
		var tag = this.tagName.toLowerCase(); 
		if (type == 'text' || type == 'password' || tag == 'textarea'){
			this.value = "";
		}else if (type == 'checkbox' || type == 'radio'){
			this.checked = false;
		}else if (tag == 'select'){
			this.selectedIndex = -1;
		}
	});
};
function get_order(url){
	location=url;
}
function get_comment(aid,show,url){ 
	$(".pl_menu").hide();
	var style=$(".review"+aid).css("display");
	var info=$(".review"+aid+" ul").html();
	if(style=="none"||show>0){ 
		if((info==''||info==null)||show>0){
			$.post(url,{aid:aid},function(data){
				var html='';  
				var datas = Array();			
				datas = eval("("+data+")");
				$.each(datas,function(key,val){
					html+="<li>"+
							"<div class=\"menu_p1_tx\"><img src=\""+val.pic+"\" onerror=\"showImgDelay(this,'"+val.errorpic+"',2);\"/></div>"+
							"<div class=\"menu_right\">"+
								"<div class=\"menu_rig_h2\">"+
									"<span class=\"menu_user\">"+val.nickname+"：</span>"+
									"<span class=\"menu_mes\">"+val.content+"</span>"+
								"</div>"+ 
								"<div class=\"menu_date\">"+
									"<span>"+val.date+"</span>"+
								"</div>"+
							"</div>"+ 
						"</div>"+
						"<div class=\"clear\"></div>"+
					"</li>"; 
					$(".review"+aid+" ul").html(html); 
				});	 
			});
		}
		$(".review"+aid).show();
	}else{
		$(".review"+aid).hide();
	} 
} 
function for_comment(aid,qid,url,comurl){
	noplaceholder("comment_"+aid);
	var content=$.trim($("#comment_"+aid).val()); 
	if(content=="" || content=="undefined"){
		layer.msg('评论内容不能为空！', 2, 8);return false; 
	}else{
		$.post(url,{aid:aid,qid:qid,content:content},function(msg){
			if(msg=='1'){
				$("#comment_"+aid).val("");
				var com_num=$("#com_num_"+aid).html();  
				com_num=parseInt(com_num)+parseInt(1);
				$("#com_num_"+aid).html(com_num); 
				get_comment(aid,'1',comurl);
			}else if(msg=='0'){
				layer.msg('评论失败！', 2, 8);return false; 
			}else if(msg=='no_login'){ 
				layer.msg('请先登录！', 2, 8);return false; 
			}else{
				layer.msg(msg, 2, 8);return false; 
			}
		});
	}
}
function support(aid,url){
	$.post(url,{aid:aid},function(msg){
		if(msg=='0'){
			layer.msg('提交失败！', 2, 8);return false; 
		}else if(msg=='1'){
			var num=$("#support_num_"+aid).html(); 
			$("#support_num_"+aid).html(parseInt(num)+parseInt(1)); 
			layer.msg('投票成功！', 2, 9);return false; 
		}else if(msg=='2'){
			layer.msg('请勿重复投票！', 2,8);return false; 
		}
	});
}  
function attention(id,type,url){
	$.post(url,{id:id,type:type},function(data){
   		var data=eval('('+data+')');  
		if(type==1){var msg='关注问题';}else{var msg='+  关注';} 
		if(data.st==8){
			layer.msg(data.msg, 2,Number(data.st));return false;	
		}else{ 
			$(".num"+id).html(data.url+"人关注");
			$(".index_num"+id).html(data.url);
			if(data.tm==1){
				$(".q"+id+">a").attr("class","watch_qxgz");
				$(".q"+id+">a").html("取消关注");
			}else{
				$(".q"+id+">a").attr("class","watch_gz");
				$(".q"+id+">a").html(msg);
			}	
		} 
	});
}

function get_show(eid){
	$("#eid").val(eid); 
	$.layer({
		type : 1,
		title :'举报问答',
		offset: [($(window).height() - 220)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['420px','auto'],
		page : {dom :"#TB_window"}
	}); 
}  
function checkform(){
	noplaceholder('title');
	editor.sync();
	var title=$("#title").val();
	var cid=$("input[name='cid']").val(); 
	var content=$("#content").val();
	if(title==''){
		layer.msg('请填写标题！', 2, 8); return false;
	}else if(cid==''){
		layer.msg('请选择类别！', 2, 8); return false;
	}else if(content==''){
		layer.msg('请填写内容！', 2, 8); return false;
	}
	var codesear=new RegExp('职场提问');
	if(codesear.test(code_web)){
	if(code_kind==1){
		var authcode=$("#ask_CheckCode").val();
			if(!authcode){
				layer.msg('请输入验证码', 2, 8);return false; 
		}
	}else if(code_kind==3){
		var geetest_challenge = $('input[name="geetest_challenge"]').val();
		var geetest_validate = $('input[name="geetest_validate"]').val();
		var geetest_seccode = $('input[name="geetest_seccode"]').val();
		
		if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
			$("#popup-submit").trigger("click");
			layer.msg('请点击按钮进行验证！', 2, 8);return false; 
		}
	}}
	
	return true;
	
}
function checkanswer(uid){
	if(uid==""){
		showlogin('');return false;
	}
	noplaceholder('content');
	if($.trim($("#content").val())==""){
		layer.msg('内容不能为空！', 2, 8); return false;
	}
}
function getclass(id,name,url){
	$(".quiz_box_first li").removeClass('quiz_select_cur');
	$(".qc"+id).addClass('quiz_select_cur');
	$(this).parent().attr('class','quiz_select_cur');
 	$.post(url,{id:id},function(data){
 		var datas = Array();
		var html='';
		datas = eval("("+data+")"); 
		$.each(datas,function(key,val){
			html +="<li class=\"qc"+key+"\"><a href='javascript:void(0)' onclick=\"selectclass('"+key+"','"+val+"')\">"+val+"</a></li>"; 
		}); 
		$(".quiz_box_second .quiz_box_title").html(name+"分类：");
		$(".quiz_box_second .quiz_select").html(html);
		$(".quiz_box_second").show();
	});
}
function selectclass(id,name){
	$(".quiz_box_second li").removeClass('quiz_select_cur');
	$(".qc"+id).addClass('quiz_select_cur');
	$(".quiz_chi>span").html(name);
	$(".quiz_box").hide();
	$("input[name='cid']").val(id); 
}
function reason(url){
	var reason=$('input:radio[name="reason"]:checked').val();
	if(reason==null){
		layer.msg('请选择举报原因！', 2, 8);return false;
	}
	var eid=$("#eid").val(); 
	$.post(url,{reason:reason,eid:eid},function(data){ 
		layer.closeAll();
		if(data=='0'){
			layer.msg('举报失败！', 2, 8);
		}else if(data=='1'){
			layer.msg('举报成功！', 2, 9);
		}else if(data=='2'){
			layer.msg('您已举报过该问题！', 2,8);
		}else if(data=='3'){
			layer.msg('该问题已被他人举报！', 2,8);
		}else if(data=='no_login'){
			layer.msg('请先登录！', 2, 8);
		}
	});
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
function onblurtext(id){
	var content = $("#reply_"+id).val();
	content=$.trim(content);
	if(content==""){
		$("#reply_"+id).val("");
		$("#comment_"+id).hide();
		$("#comment"+id).show();
	}
}
function clicktext(id){ 
	$("#comment_"+id).show();
	$("#comment"+id).hide();
	$("#reply_"+id).focus(); 	
}
function checkLength(num,id) {
	var con = $("#reply_"+id).val();
	var content = con.length;
	
	if (con.length > num) { 
		con = con.substring(0, num);
		$("#reply_"+id).val(con); 
	} 
	if(con.length=="0"){
		$("#colornum_"+id).html("0");
	}else{
		$("#colornum_"+id).html(con.length);
	} 
}
function submitreply(id,fid,url){
	var content = $("#reply_"+id).val();
	content=$.trim(content);
	if($.trim(content)==""){
		$("#reply_"+id).val("");
		layer.msg('请输入回复内容！', 2, 8);return false; 
	}
	$.post(url,{nid:id,reply:content,fid:fid},function(data){
		if(data==1){ 
			layer.msg('请先登录！', 2,8);return false;
		}else{
			var data = eval("("+data+")");
			var content = "";
			content = '<div class="Personals_cont_dy_pl"><div class="Personals_cont_dy_pl_tx"><img src="'+data.pic+'" width="28" height="35" onerror=\"showImgDelay(this,\''+errorimg+'\',2);\"></div><div class="Personals_cont_dy_pl_user"><div class="Personals_cont_dy_pl_user_n"><a href="'+data.url+'" target="_blank">'+data.nickname+'</a>: '+data.reply+'</div><div class="Personals_cont_dy_pl_user_m">'+data.ctime+'</div></div></div>';
			$("#commentlist_"+id).append(content);
			$("#comment_"+id).hide();
			$("#reply_"+id).val("");
			$("#comment"+id).show();	
		}
	});
}
function get_allmsg(id){ 
	var display=$("div[name='hide_"+id+"']").css("display");
	if(display=='none'){
		$("div[name='hide_"+id+"']").show();
		$("#click_"+id).html("收起评论");
	}else{
		$("div[name='hide_"+id+"']").hide();
		$("#click_"+id).html("查看全部评论");
	} 
} 
