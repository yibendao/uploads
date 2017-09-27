function loadlayer(){
	parent.layer.load('执行中，请稍候...',0);
} 
function toDate(str){
    var sd=str.split("-"); 
    return new Date(parseInt(sd[0]),parseInt(sd[1]),parseInt(sd[2]));
}
function check_username(){
	var username=$.trim($("#username").val());
	var pytoken=$.trim($("#pytoken").val());
	if(username){
		$.post("index.php?m=admin_resume&c=check_username",{username:username,pytoken:pytoken},function(msg){
			if(msg){
				layer.tips('已存在该用户！',"#username" , {guide: 1,style: ['background-color:#F26C4F; color:#fff;top:-7px', '#F26C4F']});
				$("#username").attr("vtype",'1');
			}else if($("#username").attr('vtype')=='1'){layer.closeTips();$("#username").attr("vtype",'0');}
		});
	}
}
function check_comusername(){
	var username=$.trim($("#username").val());
	var pytoken=$.trim($("#pytoken").val());
	if(username){
		$.post("index.php?m=admin_company&c=check_username",{username:username,pytoken:pytoken},function(msg){
			if(msg){
				layer.tips('已存在该用户！',"#username" , {guide: 1,style: ['background-color:#F26C4F; color:#fff;top:-7px', '#F26C4F']});
				$("#username").attr("vtype",'1');
			}else if($("#username").attr('vtype')=='1'){layer.closeTips();$("#username").attr("vtype",'0');}
		});
	}
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
		if(url=='1'){
			parent.layer.msg(message, layer_time, Number(layer_st),function(){ location.reload();});
		}else if(url==''){
			parent.layer.msg(message, layer_time, Number(layer_st));
		}else{
			parent.layer.msg(message, layer_time, Number(layer_st),function(){location.href = url;});
		}
	}
}
function config_msg(data){
	$("body").append(data);
	var message = $("#layer_msg").val();
	var url=$("#layer_url").val();
	var layer_time=$("#layer_time").val();
	var layer_st=$("#layer_st").val();
	if(url=='1'){
		parent.layer.msg(message, layer_time, Number(layer_st),function(){
			location.reload();
		});
	}else if(url==''){
		parent.layer.msg(message, layer_time, Number(layer_st));
	}else{
		parent.layer.msg(message, layer_time, Number(layer_st),function(){
			top.location.href =url;
		});
	}return false;
}
function resetpw(uname,uid){
	var pytoken = $('#pytoken').val();
	parent.layer.confirm("确定要重置密码吗？",function(){
		$.get("index.php?m=user_member&c=reset_pw&uid="+uid+"&pytoken="+pytoken,function(data){
			parent.layer.closeAll();
			parent.layer.alert("用户："+uname+" 密码已经重置为123456！", 9);return false;
		});
	});
}
function really(name){
	var chk_value =[];
	$('input[name="'+name+'"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	if(chk_value.length==0){
		parent.layer.msg("请选择要删除的数据！",2,8);return false;
	}else{
		parent.layer.confirm("确定删除吗？",function(){
 			setTimeout(function(){$('#myform').submit()},0);
		});
	}
}
function layer_logout(url){
	$.get(url,function(data){
		var data=eval('('+data+')');
		if(data.url=='1'){
			parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){top.location.reload();});return false;
		}else{
			parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){top.location.href=data.url;});return false;
		}
	});
}
function layer_del(msg,url){
	if(msg==''){
		parent.layer.load('执行中，请稍候...',0);
		$.get(url,function(data){
			var data=eval('('+data+')');
			if(data.url=='1'){
				parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
			}else{
				parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
			}
		});
	}else{
		var pytoken = $('#pytoken').val();
		parent.layer.confirm(msg, function(){
			parent.layer.load('执行中，请稍候...',0);
			$.get(url+'&pytoken='+pytoken,function(data){
				var data=eval('('+data+')');
				if(data.url=='1'){
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
				}else{
					parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
				}
			});
		});
	}
}
function unselectall(){
	if(document.getElementById('chkAll').checked){
		document.getElementById('chkAll').checked = document.getElementById('chkAll').checked&0;
	}
	if(document.getElementById('chkAll2').checked){
		document.getElementById('chkAll2').checked = document.getElementById('chkAll2').checked&0;
	}
	getbg();
}
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.Name != 'chkAll'&&e.disabled==false){
			e.checked = form.chkAll.checked;
		}
	}
	getbg();
}
function CheckAll2(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.Name != 'chkAll2'&&e.disabled==false){
			e.checked = form.chkAll2.checked;
		}
	}
	getbg();
}
function getbg(){
	$("tr").attr("style","");
	var id;
	$("input[type=checkbox]:checked").each(function(){
		id=$(this).val();
		$("#list"+id).attr("style","background:#d0e3ef;");
	});
} 
function Close(id){
	$("#"+id).hide();
}
$(document).ready(function(){
	$("#domain_name").click(function(){
		$("#domain_list").show();
	})
	$(".admin_Operating_c").hover(function(){
		var aid=$(this).attr("aid");
		$("#list"+aid).show();
		$("#list_"+aid).attr("class","admin_Operating_c admin_Operating_hover");
		goTopEx("list"+aid);
	},function(){
		var aid=$(this).attr("aid");
		$("#list"+aid).hide();
		$("#list_"+aid).attr("class","admin_Operating_c");
		goTopEx("list"+aid);
	}); 
	$(".formselect").hover(function(){
		var did=$(this).attr("did");
		$("#"+did).show();
	},function(){
		var did=$(this).attr("did");
		$("#"+did).hide();
	}); 
	$(".admin_Prompt_close").click(function(){
		$(".admin_Prompt").hide();
	});

	if($(".admin_Filter").length > 0){ 
		
		var height=$(".admin_adv_search_box").height();  
		var admin_Filter=$(".admin_Filter").offset().top; 
		height=Math.abs(parseInt(height)-parseInt(admin_Filter));	 
		$(".admin_adv_search_box").css('top','-'+height+'px');
		$(".admin_search_div,.admin_adv_search_box").hover(function(){
			var top=parseInt(35)+parseInt(admin_Filter);
			$(".admin_search_div .admin_adv_search_bth").addClass('admin_adv_search_bth_hover'); 
			$(".admin_adv_search_box").stop().animate({top:top+'px'});
		},function(){     
			$(".admin_adv_search_box").stop().animate({top:'-'+height+'px'});
			$(".admin_search_div .admin_adv_search_bth").removeClass('admin_adv_search_bth_hover');		
		});
	};

}) 
function formselect(val,id,name){ 
	$("#b"+id).val(name);
	$("#"+id).val(val);
	$("#d"+id).hide();
}
function goTopEx(id){
	var top=document.getElementById(id).getBoundingClientRect().top;
	var height=$(window).height();
	var height=height-5;
	$(".infoboxp").attr("style","min-height:"+height+"px;");
	var ttop=height-top;
	if(ttop<80){
		$("#"+id).attr("class","admin_Operating_list admin_Operating_up");
	}else{
		$("#"+id).attr("class","admin_Operating_list admin_Operating_down");
	}
}
function add_class(name,width,height,divid,url){
	if(url){$(divid).append("<input id='surl' value='"+url+"' type='hidden'/>");}
	$.layer({
		type : 1,
		title : name,
		offset: [($(window).height() - height)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : [width+'px',height+'px'],
		page : {dom :divid}
	});
}
function status_div(name,width,height){
	$.layer({
		type : 1,
		title :name,
		offset: [($(window).height() - height)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : [width+'px',height+'px'],
		page : {dom :"#status_div"}
	});
}
function copy_url(name,url){
	$("#copy_url").val(url);
	$.layer({
		type : 1,
		title : name,
		offset: [($(window).height() - 110)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['350px','150px'],
		page : {dom :'#wname'}
	});
}
function copy_adclass(name,url){
	$("#copy_url").val(url);
	$.layer({
		type : 1,
		title : name,
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['400px','280px'],
		page : {dom :'#wname'}
	});
}
function adminmap(){
	$.layer({
		type : 2,
		title : '后台地图',
		offset: [($(window).height() - 500)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['700px','500px'],
		iframe: {src: 'index.php?c=map'}
	});
}
function rec_up(url,id,rec,type){
		var pytoken=$("#pytoken").val();
		$.get(url+"&id="+id+"&rec="+rec+"&type="+type+"&pytoken="+pytoken,function(data){
			if(data==1){
				if(rec=="1"){
					$("#"+type+id).html("<a href=\"javascript:void(0);\" onClick=\"rec_up('"+url+"','"+id+"','0','"+type+"');\"><img src=\"../config/ajax_img/doneico.gif\"></a>");
				}else{
					$("#"+type+id).html("<a href=\"javascript:void(0);\" onClick=\"rec_up('"+url+"','"+id+"','1','"+type+"');\"><img src=\"../config/ajax_img/errorico.gif\"></a>");
				}
			}
		});
}
function rec_news (url,id,rec,type){
		var pytoken=$("#pytoken").val();
		$.get(url+"&id="+id+"&rec_news="+rec+"&type="+type+"&pytoken="+pytoken,function(data){
			if(data==1){
				if(rec=="1"){
					$("#"+type+id).html("<a href=\"javascript:void(0);\" onClick=\"rec_news('"+url+"','"+id+"','0','"+type+"');\"><img src=\"../config/ajax_img/doneico.gif\"></a>");
				}else{
					$("#"+type+id).html("<a href=\"javascript:void(0);\" onClick=\"rec_news('"+url+"','"+id+"','1','"+type+"');\"><img src=\"../config/ajax_img/errorico.gif\"></a>");
				}
			}
		});
}
function appendData(frame_id){
	var message = $(window.frames[frame_id].document).find("#layer_msg").html();
	$("#jobsynch").before(message);
	$("#viewMore").parent().parent().parent().find("tr:gt(10)").hide();
	$("#viewMore").parent().parent().show();
	$("#viewMore").click(function(){
		if($(this).html()=="查看详细"){
			$("#viewMore").parent().parent().parent().find("tr:gt(10)").show();
			$(this).html("收起详细");
		}
		else{
			$("#viewMore").parent().parent().parent().find("tr:gt(10)").hide();
			$(this).html("查看详细");
		}
	});
	$("#jobsynchFrom").show();
}
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
 }
function isjsMobile(obj) {
	var reg= /^[1][34578]\d{9}$/;   
	
    if (obj.length != 11) return false;
    else if (!reg.test(obj)) return false;
    else if (isNaN(obj)) return false;
    else return true;
}
function isjsTell(str) {
    var result = str.match(/\d{3}-\d{8}|\d{4}-\d{7}/);
    if (result == null) return false;
    return true;
}
function domain_show(num){
	if(num<=1){
		var height='100';
	}else{
		var height=parseInt(num)*38+60;
	} 
 	$.layer({
		type:1,
		title:'选择分站',
		closeBtn:[0,true],
		offset:['20%','30%'],
		border:[10 , 0.3 , '#000', true],
		area:['550px',height+'px'],
		page:{dom : '#domainlist'}
	});
}


function editname(oldname){
	var username=$("#username").val();
	var uid=$("#uid").val();
	var pytoken=$("#pytoken").val();
	if(username.length<2||username.length>16){
		layer.msg("请输入2至16位字符的用户名！",2,8);return false;
	}
	if(username==oldname){
		layer.msg("用户名没有改变！",2,8);return false;
	}else{
		$.post("index.php?m=admin_company&c=saveusername",{username:username,uid:uid,pytoken:pytoken},function(data){
			if(data==1){
				layer.msg("用户名已存在！",2,8);
			}else{
				layer.msg("修改成功！",2,9);
			}
		});
	}
}

function save_dclass(url){
	var pytoken=$("#pytoken").val(); 
	var position = $("#position").val().split("\n");
	var name=position.join("-");
	if(position==''){
		parent.layer.msg('类别名称不能为空！', 2, 8);return false;
	}
	$.post(url,{name:name,pytoken:pytoken},function(msg){
		if(msg==2){
			parent.layer.msg('已有此类别，请重新输入！', 2, 8);return false;
		}else if(msg==3){
			parent.layer.msg('添加成功！', 2,9,function(){location=location ;});return false;
		}else if(msg==4){
			parent.layer.msg('添加失败！', 2,8,function(){location=location ;});return false;
		}
	}); 
}

function save_bclass(){
	var ctype=$('input[name="btype"]:checked').val(); 
	var nid=$("#keyid_val").val(); 
	var url=$('#surl').val();
	var position = $("#classname").val().split("\n");
	var name=position.join("-");
	if(position==''){
		parent.layer.msg('类别名称不能为空！', 2, 8);return false;
	}
	var pytoken=$("#pytoken").val();
	$.post(url,{ctype:ctype,nid:nid,name:name,pytoken:pytoken},function(msg){ 
		if(msg==1){ 
			parent.layer.msg('已有此类别，请重新输入！', 2, 8);return false;
		}else if(msg==2){
			parent.layer.msg('添加成功！', 2,9,function(){location=location ;});return false;
		}else if(msg==3){
			parent.layer.msg('添加失败！', 2,8,function(){location=location ;});return false;
		} 
	}); 
}

function save_class(){
	var ctype=$('input[name="ctype"]:checked').val();
	var nid=$('#nid_val').val();
	var url=$('#surl').val();
	var position = $("#position").val().split("\n");
	var name=position.join("-");
	var variable= $("#variable").val().split("\n");
	var str=variable.join("-");
	if(ctype==''||ctype==null){
		parent.layer.msg('请选择类型！', 2, 8);return false;
	}
	if(position==''){
		parent.layer.msg('类别名称不能为空！', 2, 8);return false;
	}
	if(ctype=='1'&&$.trim(variable)==''){
		parent.layer.msg('调用变量名不能为空！', 2, 8);return false;
	}
	$.post(url,{ctype:ctype,nid:nid,name:name,str:str,pytoken:$('#pytoken').val()},function(msg){
		if(msg==1){
			parent.layer.msg('已有此类别，请重新输入！', 2, 8);return false;
		}else if(msg==2){
			parent.layer.msg('添加成功！', 2,9,function(){location=location ;});return false;
		}else{
			parent.layer.msg('添加失败！', 2,8,function(){location=location ;});return false;
		}
	}); 
}

function saveNclass(url){
	var pytoken=$("#pytoken").val(); 
	var position = $("#classname").val().split("\n");
	var name=position.join("-");
    var fid=$("#f_id_val").val();
	var rec=$("#rec_val").val();
	if(position==''){
		parent.layer.msg('类别名称不能为空！', 2, 8);return false;
	}
	$.post(url,{name:name,fid:fid,rec:rec,pytoken:pytoken},function(msg){
		if(msg==1){
			parent.layer.msg('已有此类别，请重新输入！', 2, 8);return false;
		}else if(msg==2){
			parent.layer.msg('添加成功！', 2,9,function(){location=location ;});return false;
		}else if(msg==3){
			parent.layer.msg('添加失败！', 2,8,function(){location=location ;});return false;
		}
	}); 
} 
function checksort(id){
	$("#sort"+id).hide();
	$("#input"+id).show();
	$("#input"+id).focus();
} 
function checkname(id){
	$("#name"+id).hide();
	$("#inputname"+id).show();
	$("#inputname"+id).focus();
}
function subsort(id,url){
	var sort=$("#input"+id).val();
	var pytoken=$("#pytoken").val();
	$.post(url,{id:id,sort:sort,pytoken:pytoken},function(data){
		$("#sort"+id).html(sort);
		$("#sort"+id).show();
		$("#input"+id).hide(); 
	})
}
function subname(id,url){
	var name=$("#inputname"+id).val();
	if($.trim(name)==""){
		parent.layer.msg("类别名称不能为空！",2,8,function(){location.reload();});return false;
	}
	var pytoken=$("#pytoken").val();
	$.post(url,{id:id,name:name,pytoken:pytoken},function(data){
		$("#name"+id).html(name);
		$("#name"+id).show();
		$("#inputname"+id).hide(); 
	})
}


function select_click(name){
	$("#"+name+"_select").show();
}
function select_wx(name,val,valname){
	var name,val,valname;
	if(val!='0'){		
		$(".xubox_close").trigger("click");
		$('.buttonson').show();
		add_class('新增微信菜单','420','365','#houtai_div','');	
	}else{
		$(".xubox_close").trigger("click");
		$('.buttonson').hide();
		add_class('新增微信菜单','420','365','#houtai_div','');		
	}
	$("#"+name+"_name").val(valname);
	$("#"+name+"_val").val(val);
	$("#"+name+"_select").hide();
}	
function select_zph(name,val,valname,type){
	var name,val,valname;

	if(val>0&&type=='job_keyid'){
		$("#content").hide();
		$("#pricelist").show();
		$.get("index.php?m=zph_space&c=ajaxspace&ajax=1&id="+val,function(data){	
			$("#job_keyid_select").html(data);
		});	
	}	
	$("#"+name+"_name").val(valname);
	$("#"+name+"_val").val(val);
	$("#"+name+"_select").hide();
}
function select_ask(name,val,valname){
	var name,val,valname;	

	if(name=='pid'){		
		$("#cid_name").val('请选择');				
	}
	var pytoken=$("#pytoken").val(); 
	$.post("index.php?m=admin_question&c=get_class",{pid:val,pytoken:pytoken},function(data){		   
		$("#cid_select").html(data); 
	});
	$("#"+name+"_name").val(valname);
	$("#"+name+"_val").val(val);
	$("#"+name+"_select").hide();
}
function select_subject(name,val,valname){
	var name,val,valname;	

	if(name=='nid'){		
		$("#tnid_name").val('请选择');				
	} 	
	$.post(weburl+"/index.php?m=ajax&c=ajax_subject", {"str":val},function(data) {
		$("#tnid_select").html(data);
	})	
	$("#"+name+"_name").val(valname);
	$("#"+name+"_val").val(val);
	$("#"+name+"_select").hide();
}

function select_rating(name,val,valname){
	var name,val,valname;	
	var pytoken=$("#pytoken").val();
	if(val){
		$.post("index.php?m=admin_company&c=getrating",{id:val,pytoken:pytoken},function(data){
			if(data){
				var dataJson = eval("(" + data + ")"); 
				$('#job_num').val(dataJson.job_num);
				$('#down_resume').val(dataJson.resume);
				$('#editjob_num').val(dataJson.editjob_num);
				$('#invite_resume').val(dataJson.interview);
				$('#breakjob_num').val(dataJson.breakjob_num);
				$('#part_num').val(dataJson.part_num);
				$('#editpart_num').val(dataJson.editpart_num);
				$('#breakpart_num').val(dataJson.breakpart_num);
				$('#zph_num').val(dataJson.zph_num);
				$('#vipetime').text(dataJson.vipetime);
				$('#oldetime').val(dataJson.oldetime);				
				$('#rating_name').val(dataJson.name);
				$('#com_rating_val').val(dataJson.id);
			}
		});
	}
	$("#"+name+"_name").val(valname);
	$("#"+name+"_val").val(val);
	$("#"+name+"_select").hide();
}

function select_new(name,val,valname){
	if(name=='type'){
		if(val==2){ 
			$("#photo").show();
			$(".pic").show();
		}
		if(val==1){ 
			$("#photo").hide();
			$(".pic").hide();
		}
	}	
	if(name=='fz_type'){
		if(val==1){
			$("#fz_type_1").show();
			$("#fz_type_2").hide();
		}else{
			$("#fz_type_1").hide();
			$("#fz_type_2").show();
		} 
	}
	if(name=='datetype'){
		$("#xfilename").attr('value',val);
	}
	val=='0'?$("#is_rec").show():$("#is_rec").hide();	
	$("#"+name+"_name").val(valname);
	$("#"+name+"_val").val(val);
	$("#"+name+"_select").hide();	 	
}


function dchange(){
	var datetype=$("#datetype").val();
	$("#filename").val(datetype);
} 


function search_show(id){
	$("#"+id).show();
}
function three_city_show(id){
    var cityidid=$("#cityidid").val();
	if(cityidid!=""){		
	    $("#"+id).show();
	}
}
function selects(id,type,name){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#"+type+"id").val(id);
	
}
function select_city(id,type,name,gettype,ptype){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#" + type + "id").val(id);
	$("#cityshowth").addClass('dn');
	$('#by_cityidid').html('');
	if(type=='locoy_job_job1'){
		$("#locoy_job1_son").val('请选择职位');
		$("#locoy_job1_sonid").val('');
		$("#job_post").val('请选择职位'); 
		$("#job_postid").val('');
	}
	if(type=='locoy_job1_son'){
		$("#job_post").val('请选择职位'); 
		$("#job_postid").val('');
	}
	if(type=='locoy_job_province'){
		$("#locoy_job_city").val('请选择城市');
		$("#three_city").val('请选择区县');
		$("#locoy_job_cityid").val('');
		$("#three_cityid").val('');
	} 
	if(type=='locoy_job_city'){
		$("#three_city").val('请选择区县');
		$("#three_cityid").val('');
	}  
    if(type=='locoy_com_province'){
		$("#locoy_com_city").val('请选择城市');
		$("#locoy_com_cityid").val('');
	} 	
	var url=weburl+"/index.php?m=ajax&c=ajax_admincity";	
	$.post(url,{id:id,gettype:gettype,ptype:ptype},function(data){
		
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
			if(gettype=="cityid"){
				$("#"+gettype).val("请选择城市");
				$("#cityidid").val('');
				$("#three_city").val("请选择区县");
				$("#three_cityid").val('');
			} 
			if(gettype=="three_city"){
				if(data!=""){
					$("#cityshowth").removeClass('dn');
				}
				$("#"+gettype).val("请选择区县");
				$("#three_cityid").val('');
			} 
			if(type=='locoy_job_city'){
				if(data!=""){
					$("#cityshowth").removeClass('dn');
				}
				$("#three_city").val('请选择区县');
				$("#three_cityid").val('');
			}
			$("#job_"+gettype).html(data);
							
		} 
	})
}  
function select_citys(id,type,name,gettype,ptype){
	$("#job_"+type).hide();
	$("#"+type).val(name);
	$("#" + type + "id").val(id);
	$("#rcityshowth").addClass('dn');
	$('#by_cityidid').html('');
	if(type=='locoy_resume_job1'){
		$("#locoy_resume_son").val('请选择职位');
		$("#locoy_resume_sonid").val('');
		$("#job_posts").val('请选择职位'); 
		$("#job_postsid").val('');
	}
	if(type=='locoy_resume_son'){
		$("#job_posts").val('请选择职位'); 
		$("#job_postsid").val('');
	}
	if(type=='locoy_resume_province'){
		$("#locoy_resume_city").val('请选择城市');
		$("#three_citys").val('请选择区县');
		$("#locoy_resume_cityid").val('');
		$("#three_citysid").val('');
	} 	
    if(type=='locoy_resume_city'){
		$("#three_citys").val('请选择区县');
		$("#three_citysid").val('');
	} 	
	var url=weburl+"/index.php?m=ajax&c=ajax_adminresumecity";	
	$.post(url,{id:id,gettype:gettype,ptype:ptype},function(data){
		
		if(ptype=='job'){ 
			$("#job_"+gettype).html(data);
			if(gettype=="job1_son"){
				if(data==""){
					$("#job_"+gettype).hide();
				}else{
					$("#job_"+gettype).show();
				}
			}else if(gettype=="job_posts"){
				$("#job_posts").parents().show();
				$("#job_"+gettype).show();
			}						
		}else{
			if(type=='locoy_resume_city'){
				if(data!=""){
					$("#rcityshowth").removeClass('dn');
				}
				$("#three_citys").val('请选择区县');
				$("#three_citysid").val('');
			}
			if(gettype=="cityid"){$("#"+gettype).val("请选择城市");} 
			if(gettype=="three_city"){$("#"+gettype).val("请选择区县");} 
			$("#job_"+gettype).html(data);
							
		} 
	})
}  
function showbox(title,url,width,height){
	var pytoken=$("input[name='pytoken']").val();
	$.get(url+'&pytoken='+pytoken,function(data){
		var data=eval("(" + data + ")");
		if(data.name){
			$('#showname').html(data.name);
		}
		if(data.type){
			$('#showtype').html(data.type);
		}
		if(data.mobile){
			$('#showmoblie').html(data.mobile);
		}
		if(data.ctime){
			$('#showdate').html(data.ctime);
		}
		if(data.content){
			$('#showcontent').html(data.content);
		}
		$('#showdelet').attr('onclick',"showdelet('index.php?m=admin_message&c=del&del="+data.id+"')");
		$.layer({
			type:1,
			title:title,
			closeBtn:[0,true],
			border:[10 , 0.3 , '#000', true],
			area:[width,height],
			page:{dom : '#showbox'}
		});
	})
}
function showdelet(url){
	var pytoken=$("input[name='pytoken']").val();
	$.post(url+'&pytoken='+pytoken,function(data){
		var data=eval('('+data+')');
		if(data.url=='1'){
			parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
		}else{
			parent.layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
		}
	});
}

$(document).ready(function () {
    $('body').click(function (evt) {
	    if($(evt.target).parents("#subject_sid_name").length==0 && evt.target.id != "subject_sid_name") {
	       $('#subject_sid_select').hide();
	    }	
		 if($(evt.target).parents("#hy_name").length==0 && evt.target.id != "hy_name") {
	       $('#hy_select').hide();
	    }	
		if($(evt.target).parents("#lt_rating_name").length==0 && evt.target.id != "lt_rating_name") {
	       $('#lt_rating_select').hide();
	    }
		 if($(evt.target).parents("#provinceid").length==0 && evt.target.id != "province") {
	       $('#job_province').hide();
	    }	
		 if($(evt.target).parents("#cityid").length==0 && evt.target.id != "cityid") {
	       $('#job_cityid').hide();
	    }
		 if($(evt.target).parents("#three_cityid").length==0 && evt.target.id != "three_city") {
	       $('#job_three_city').hide();
	    }
		 if($(evt.target).parents("#job_pr_name").length==0 && evt.target.id != "job_pr_name") {
	       $('#job_pr_select').hide();
	    }
		 if($(evt.target).parents("#job_mun_name").length==0 && evt.target.id != "job_mun_name") {
	       $('#job_mun_select').hide();
	    }
		 if($(evt.target).parents("#nid_name").length==0 && evt.target.id != "nid_name") {
	       $('#nid_select').hide();
	    }
		if($(evt.target).parents("#tnid_name").length==0 && evt.target.id != "tnid_name") {
	       $('#tnid_select').hide();
	    }	
		if($(evt.target).parents("#user_sex_name").length==0 && evt.target.id != "user_sex_name") {
	       $('#user_sex_select').hide();
	    }
		if($(evt.target).parents("#user_exp_name").length==0 && evt.target.id != "user_exp_name") {
	       $('#user_exp_select').hide();
	    }
		if($(evt.target).parents("#user_edu_name").length==0 && evt.target.id != "user_edu_name") {
	       $('#user_edu_select').hide();
	    }
		if($(evt.target).parents("#user_marriage_name").length==0 && evt.target.id != "user_marriage_name") {
	       $('#user_marriage_select').hide();
	    }
		if($(evt.target).parents("#user_salary_name").length==0 && evt.target.id != "user_salary_name") {
	       $('#user_salary_select').hide();
	    }
		if($(evt.target).parents("#user_type_name").length==0 && evt.target.id != "user_type_name") {
	       $('#user_type_select').hide();
	    }
		if($(evt.target).parents("#user_report_name").length==0 && evt.target.id != "user_report_name") {
	       $('#user_report_select').hide();
	    }
		if($(evt.target).parents("#user_jobstatus_name").length==0 && evt.target.id != "user_jobstatus_name") {
	       $('#user_jobstatus_select').hide();
	    }
		if($(evt.target).parents("#user_education_name").length==0 && evt.target.id != "user_education_name") {
	       $('#user_education_select').hide();
	    }	
		if($(evt.target).parents("#com_rating_name").length==0 && evt.target.id != "com_rating_name") {
	       $('#com_rating_select').hide();
	    }
		if($(evt.target).parents("#job_hy_name").length==0 && evt.target.id != "job_hy_name") {
	       $('#job_hy_select').hide();
	    }
		if($(evt.target).parents("#job1").length==0 && evt.target.id != "job1") {
	       $('#job_job1').hide();
	    }
		if($(evt.target).parents("#job1_son").length==0 && evt.target.id != "job1_son") {
	       $('#job_job1_son').hide();
	    }
		if($(evt.target).parents("#job_post").length==0 && evt.target.id != "job_post") {
	       $('#job_job_post').hide();
	    }
		if($(evt.target).parents("#job_salary_name").length==0 && evt.target.id != "job_salary_name") {
	       $('#job_salary_select').hide();
	    }
		if($(evt.target).parents("#job_type_name").length==0 && evt.target.id != "job_type_name") {
	       $('#job_type_select').hide();
	    }
		if($(evt.target).parents("#job_number_name").length==0 && evt.target.id != "job_number_name") {
	       $('#job_number_select').hide();
	    }
		if($(evt.target).parents("#job_exp_name").length==0 && evt.target.id != "job_exp_name") {
	       $('#job_exp_select').hide();
	    }
		if($(evt.target).parents("#job_report_name").length==0 && evt.target.id != "job_report_name") {
	       $('#job_report_select').hide();
	    }
		if($(evt.target).parents("#job_sex_name").length==0 && evt.target.id != "job_sex_name") {
	       $('#job_sex_select').hide();
	    }
		if($(evt.target).parents("#job_age_name").length==0 && evt.target.id != "job_age_name") {
	       $('#job_age_select').hide();
	    }
		if($(evt.target).parents("#job_edu_name").length==0 && evt.target.id != "job_edu_name") {
	       $('#job_edu_select').hide();
	    }
		if($(evt.target).parents("#job_marriage_name").length==0 && evt.target.id != "job_marriage_name") {
	       $('#job_marriage_select').hide();
	    }	
		if($(evt.target).parents("#part_type_name").length==0 && evt.target.id != "part_type_name") {
	       $('#part_type_select').hide();
	    }	
		if($(evt.target).parents("#user_billing_name").length==0 && evt.target.id != "user_billing_name") {
	       $('#user_billing_select').hide();
	    }	
		if($(evt.target).parents("#tpl_name").length==0 && evt.target.id != "tpl_name") {
	       $('#tpl_select').hide();
	    }
		if($(evt.target).parents("#newsclass_name").length==0 && evt.target.id != "newsclass_name") {
	       $('#newsclass_select').hide();
	    }
		if($(evt.target).parents("#cid_name").length==0 && evt.target.id != "cid_name") {
	       $('#cid_select').hide();
	    }
		if($(evt.target).parents("#is_show_name").length==0 && evt.target.id != "is_show_name") {
	       $('#is_show_select').hide();
	    }
		if($(evt.target).parents("#fz_type_name").length==0 && evt.target.id != "fz_type_name") {
	       $('#fz_type_select').hide();
	    }
		if($(evt.target).parents("#domain_name").length==0 && evt.target.id != "domain_name") {
	       $('#domain_select').hide();
	    }
		if($(evt.target).parents("#descnid_name").length==0 && evt.target.id != "descnid_name") {
	       $('#descnid_select').hide();
	    }
		if($(evt.target).parents("#sid_name").length==0 && evt.target.id != "sid_name") {
	       $('#sid_select').hide();
	    }
		if($(evt.target).parents("#pid_name").length==0 && evt.target.id != "pid_name") {
	       $('#pid_select').hide();
	    }
		if($(evt.target).parents("#cid_name").length==0 && evt.target.id != "cid_name") {
	       $('#cid_select').hide();
	    }
		if($(evt.target).parents("#type_name").length==0 && evt.target.id != "type_name") {
	       $('#type_select').hide();
	    }
		if($(evt.target).parents("#coupon_name").length==0 && evt.target.id != "coupon_name") {
	       $('#coupon_select').hide();
	    }
		if($(evt.target).parents("#adclass_name").length==0 && evt.target.id != "adclass_name") {
	       $('#adclass_select').hide();
	    }
		if($(evt.target).parents("#once_name").length==0 && evt.target.id != "once_name") {
	       $('#once_select').hide();
	    }
		if($(evt.target).parents("#group_name").length==0 && evt.target.id != "group_name") {
	       $('#group_select').hide();
	    }
		if($(evt.target).parents("#groupcont_name").length==0 && evt.target.id != "groupcont_name") {
	       $('#groupcont_select').hide();
	    }
		if($(evt.target).parents("#order_name").length==0 && evt.target.id != "order_name") {
	       $('#order_select').hide();
	    }
		if($(evt.target).parents("#datetype_name").length==0 && evt.target.id != "datetype_name") {
	       $('#datetype_select').hide();
	    }
		if($(evt.target).parents("#frequency_name").length==0 && evt.target.id != "frequency_name") {
	       $('#frequency_select').hide();
	    }
		if($(evt.target).parents("#addclass_name").length==0 && evt.target.id != "addclass_name") {
	       $('#addclass_select').hide();
	    }
		if($(evt.target).parents("#addclass2_name").length==0 && evt.target.id != "addclass2_name") {
	       $('#addclass2_select').hide();
	    }
		if($(evt.target).parents("#tem_type_name").length==0 && evt.target.id != "tem_type_name") {
	       $('#tem_type_select').hide();
	    }
		if($(evt.target).parents("#tem_type_name").length==0 && evt.target.id != "tem_type_name") {
	       $('#tem_type_select').hide();
	    }
		if($(evt.target).parents("#locoy_job_job1").length==0 && evt.target.id != "locoy_job_job1") {
	       $('#job_locoy_job_job1').hide();
	    }
		if($(evt.target).parents("#locoy_job1_son").length==0 && evt.target.id != "locoy_job1_son") {
	       $('#job_locoy_job1_son').hide();
	    }
		if($(evt.target).parents("#locoy_job_province").length==0 && evt.target.id != "locoy_job_province") {
	       $('#job_locoy_job_province').hide();
	    }
		if($(evt.target).parents("#locoy_com_province").length==0 && evt.target.id != "locoy_com_province") {
	       $('#job_locoy_com_province').hide();
	    }
		if($(evt.target).parents("#locoy_job_city").length==0 && evt.target.id != "locoy_job_city") {
	       $('#job_locoy_job_city').hide();
	    }
		if($(evt.target).parents("#locoy_com_city").length==0 && evt.target.id != "locoy_com_city") {
	       $('#job_locoy_com_city').hide();
	    }
		if($(evt.target).parents("#com_hy_name").length==0 && evt.target.id != "com_hy_name") {
	       $('#com_hy_select').hide();
	    }
		if($(evt.target).parents("#locoy_resume_job1").length==0 && evt.target.id != "locoy_resume_job1") {
	       $('#job_locoy_resume_job1').hide();
	    }
		if($(evt.target).parents("#locoy_resume_son").length==0 && evt.target.id != "locoy_resume_son") {
	       $('#job_locoy_resume_son').hide();
	    }
		if($(evt.target).parents("#job_posts").length==0 && evt.target.id != "job_posts") {
	       $('#job_job_posts').hide();
	    }
		if($(evt.target).parents("#locoy_resume_province").length==0 && evt.target.id != "locoy_resume_province") {
	       $('#job_locoy_resume_province').hide();
	    }
		if($(evt.target).parents("#locoy_resume_city").length==0 && evt.target.id != "locoy_resume_city") {
	       $('#job_locoy_resume_city').hide();
	    }
		if($(evt.target).parents("#three_citys").length==0 && evt.target.id != "three_citys") {
	       $('#job_three_citys').hide();
	    }
		if($(evt.target).parents("#part_billing_name").length==0 && evt.target.id != "part_billing_name") {
	       $('#part_billing_select').hide();
	    }
		if($(evt.target).parents("#style_name").length==0 && evt.target.id != "style_name") {
	       $('#style_select').hide();
	    }
		if($(evt.target).parents("#add_keyid_name").length==0 && evt.target.id != "add_keyid_name") {
	       $('#add_keyid_select').hide();
	    }
		if($(evt.target).parents("#m_id_name").length==0 && evt.target.id != "m_id_name") {
	       $('#m_id_select').hide();
	    }
		if($(evt.target).parents("#did_name").length==0 && evt.target.id != "did_name") {
	       $('#did_select').hide();
	    }
		if($(evt.target).parents("#selectgroup_name").length==0 && evt.target.id != "selectgroup_name") {
	       $('#selectgroup_select').hide();
	    }
		if($(evt.target).parents("#byorder_name").length==0 && evt.target.id != "byorder_name") {
	       $('#byorder_select').hide();
	    }
		if($(evt.target).parents("#urltype_name").length==0 && evt.target.id != "urltype_name") {
	       $('#urltype_select').hide();
	    }
		if($(evt.target).parents("#timetype_name").length==0 && evt.target.id != "timetype_name") {
	       $('#timetype_select').hide();
	    }
		if($(evt.target).parents("#seomodel_name").length==0 && evt.target.id != "seomodel_name") {
	       $('#seomodel_select').hide();
	    }
		if($(evt.target).parents("#reg_coupon_name").length==0 && evt.target.id != "reg_coupon_name") {
	       $('#reg_coupon_select').hide();
	    }
		if($(evt.target).parents("#resume_hy_name").length==0 && evt.target.id != "resume_hy_name") {
	       $('#resume_hy_select').hide();
	    }

		if($(evt.target).parents("#integral_reg_type_name").length==0 && evt.target.id != "integral_reg_type_name") {
	       $('#integral_reg_type_select').hide();
	    }
		if($(evt.target).parents("#integral_invite_reg_type_name").length==0 && evt.target.id != "integral_invite_reg_type_name") {
	       $('#integral_invite_reg_type_select').hide();
	    }
		if($(evt.target).parents("#integral_login_type_name").length==0 && evt.target.id != "integral_login_type_name") {
	       $('#integral_login_type_select').hide();
	    }
		if($(evt.target).parents("#integral_userinfo_type_name").length==0 && evt.target.id != "integral_userinfo_type_name") {
	       $('#integral_userinfo_type_select').hide();
	    }
		if($(evt.target).parents("#integral_emailcert_type_name").length==0 && evt.target.id != "integral_emailcert_type_name") {
	       $('#integral_emailcert_type_select').hide();
	    }
		if($(evt.target).parents("#integral_mobliecert_type_name").length==0 && evt.target.id != "integral_mobliecert_type_name") {
	       $('#integral_mobliecert_type_select').hide();
	    }
		if($(evt.target).parents("#integral_avatar_type_name").length==0 && evt.target.id != "integral_avatar_type_name") {
	       $('#integral_avatar_type_select').hide();
	    }
		if($(evt.target).parents("#integral_question_type_name").length==0 && evt.target.id != "integral_question_type_name") {
	       $('#integral_question_type_select').hide();
	    }
		if($(evt.target).parents("#integral_answer_type_name").length==0 && evt.target.id != "integral_answer_type_name") {
	       $('#integral_answer_type_select').hide();
	    }
		if($(evt.target).parents("#integral_answerpl_type_name").length==0 && evt.target.id != "integral_answerpl_type_name") {
	       $('#integral_answerpl_type_select').hide();
	    }
		if($(evt.target).parents("#integral_add_resume_type_name").length==0 && evt.target.id != "integral_add_resume_type_name") {
	       $('#integral_add_resume_type_select').hide();
	    }
		if($(evt.target).parents("#integral_identity_type_name").length==0 && evt.target.id != "integral_identity_type_name") {
	       $('#integral_identity_type_select').hide();
	    }
		if($(evt.target).parents("#integral_resume_top_type_name").length==0 && evt.target.id != "integral_resume_top_type_name") {
	       $('#integral_resume_top_type_select').hide();
	    }
		if($(evt.target).parents("#integral_job_type_name").length==0 && evt.target.id != "integral_job_type_name") {
	       $('#integral_job_type_select').hide();
	    }
		if($(evt.target).parents("#integral_jobefresh_type_name").length==0 && evt.target.id != "integral_jobefresh_type_name") {
	       $('#integral_jobefresh_type_select').hide();
	    }
		if($(evt.target).parents("#integral_partjob_type_name").length==0 && evt.target.id != "integral_partjob_type_name") {
	       $('#integral_partjob_type_select').hide();
	    }
		if($(evt.target).parents("#integral_partjobefresh_type_name").length==0 && evt.target.id != "integral_partjobefresh_type_name") {
	       $('#integral_partjobefresh_type_select').hide();
	    }
		if($(evt.target).parents("#integral_down_resume_type_name").length==0 && evt.target.id != "integral_down_resume_type_name") {
	       $('#integral_down_resume_type_select').hide();
	    }
		if($(evt.target).parents("#integral_interview_type_name").length==0 && evt.target.id != "integral_interview_type_name") {
	       $('#integral_interview_type_select').hide();
	    }
		if($(evt.target).parents("#com_urgent_type_name").length==0 && evt.target.id != "com_urgent_type_name") {
	       $('#com_urgent_type_select').hide();
	    }
		if($(evt.target).parents("#integral_jobtop_type_name").length==0 && evt.target.id != "integral_jobtop_type_name") {
	       $('#integral_jobtop_type_select').hide();
	    }
		if($(evt.target).parents("#com_recjob_type_name").length==0 && evt.target.id != "com_recjob_type_name") {
	       $('#com_recjob_type_select').hide();
	    }
		if($(evt.target).parents("#com_recpartjob_type_name").length==0 && evt.target.id != "com_recpartjob_type_name") {
	       $('#com_recpartjob_type_select').hide();
	    }
		if($(evt.target).parents("#job_auto_type_name").length==0 && evt.target.id != "job_auto_type_name") {
	       $('#job_auto_type_select').hide();
	    }
		if($(evt.target).parents("#integral_map_type_name").length==0 && evt.target.id != "integral_map_type_name") {
	       $('#integral_map_type_select').hide();
	    }
		if($(evt.target).parents("#integral_banner_type_name").length==0 && evt.target.id != "integral_banner_type_name") {
	       $('#integral_banner_type_select').hide();
	    }
		if($(evt.target).parents("#integral_comcert_type_name").length==0 && evt.target.id != "integral_comcert_type_name") {
	       $('#integral_comcert_type_select').hide();
	    }
		if($(evt.target).parents("#integral_lt_job_type_name").length==0 && evt.target.id != "integral_lt_job_type_name") {
	       $('#integral_lt_job_type_select').hide();
	    }
		if($(evt.target).parents("#integral_lt_jobefresh_type_name").length==0 && evt.target.id != "integral_lt_jobefresh_type_name") {
	       $('#integral_lt_jobefresh_type_select').hide();
	    }
		if($(evt.target).parents("#integral_lt_jobedit_type_name").length==0 && evt.target.id != "integral_lt_jobedit_type_name") {
	       $('#integral_lt_jobedit_type_select').hide();
	    }
		if($(evt.target).parents("#integral_lt_downresume_type_name").length==0 && evt.target.id != "integral_lt_downresume_type_name") {
	       $('#integral_lt_downresume_type_select').hide();
	    }
		if($(evt.target).parents("#integral_ltcert_type_name").length==0 && evt.target.id != "integral_ltcert_type_name") {
	       $('#integral_ltcert_type_select').hide();
	    }
		if($(evt.target).parents("#integral_px_banner_type_name").length==0 && evt.target.id != "integral_px_banner_type_name") {
	       $('#integral_px_banner_type_select').hide();
	    }
		
		if($(evt.target).parents("#rating_name_name").length==0 && evt.target.id != "rating_name_name") {
	       $('#rating_name_select').hide();
	    }

		if($(evt.target).parents("#job_nid_name").length==0 && evt.target.id != "job_nid_name") {
	       $('#job_nid_select').hide();
	    }
		if($(evt.target).parents("#job_keyid_name").length==0 && evt.target.id != "job_keyid_name") {
	       $('#job_keyid_select').hide();
	    }

		if($(evt.target).parents("#f_id_name").length==0 && evt.target.id != "f_id_name") {
	       $('#f_id_select').hide();
	    }
});
})