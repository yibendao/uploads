function checkmore(type){
	var html=$("#"+type).html();
	$("."+type).toggle();
	if(html=="更多"){
		$("#"+type).attr('class','showcheck');
		$("#"+type).html('收起');
	}else{
		$("#"+type).attr('class','hidecheck');
		$("#"+type).html('更多');
	}
}
function checkmore_search(){
	var searchlist=$("#searchlist").html();
	if(searchlist=="更多选项"){
		$(".search_more").show();
		$("#searchlist").html('收起选项');
	}else{
		$(".search_more").hide();
		$("#searchlist").html('更多选项');
	}
}
$(document).ready(function(){
	$('.Search_jobs_more_chlose').hover(function(){
		$(this).find('.none').show();  
	},function(){
		$(this).find('.none').hide(); 
	});
	
	$('.delete').live('click',function(){
		var id = $(this).attr('data-id');
		var pid = $(this).attr('data-pid');
		if(parseInt(pid)>0){
			unsel(id,pid);
		}else{
			unsel(id)	
		}
	});	
	$('.search_job_list').hover(function(){
		$(".search_job_list").removeClass("search_job_list_cur_line");
		$(this).addClass('search_job_list_cur_line');  
		$(".search_job_list_cur_line>.search_job_list_box").show();
	},function(){
		var ltype=$('#ltype').val();
		if(ltype==''){
			$(".search_job_list_cur_line>.search_job_list_box").hide();
			$(".search_job_list").removeClass("search_job_list_cur_line");}
		} 
	);

	$(".com_admin_ask").hover(function(){  
		layer.tips("加入搜索器，方便下次直接搜索，无需点击众多条件！", this, {
			guide: 1,
			style: ['background-color:#F26C4F; color:#fff;top:-7px', '#F26C4F']
		});
	},function(){layer.closeTips();}); 
	
	$('.Search_jobs_sub_a').bind('mouseenter',function(){
		var dataid = $(this).attr('data-id');
		if(dataid){
			$('.Search_jobs_select').hide();
			$('#citytype'+dataid).show();
			var leftPx = $(this).position().left; 
			$('#icon_'+dataid).css('left',leftPx-60);
		}
		
	});
	$('.Search_jobs_form_list').bind('mouseleave',function(){
		$('.Search_jobs_select').hide();
		$('.oldshow').show();
	});
	$('#acity').hover(function(){
		$('.Search_cityall').removeClass('none');  
	},function(){
		$('.Search_cityall').addClass('none');
	});
	$('.Search_cityall').hover(function(){
		$('.Search_cityall').removeClass('none');  
	},function(){
		$('.Search_cityall').addClass('none'); 
	});
});
function check_select_show(id){
	$("#list"+id).show();
}
function check_onselect(id,val,name){
	$("#"+id).val(val);
	$("#list"+id).hide();
	$("#button"+id).val(name);
}
function addfinder(para,usertype,type){
	$.post(weburl+"/job/index.php?c=addfinder",{para:para,usertype:usertype},function(data){
		var data=eval('('+data+')');
		if(type=='1'){
			layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;		
		}else{
			layer.msg(data.msg, Number(data.tm), Number(data.st));return false;		
		} 
	});
}
function index_job(job_class){
	var html = $("#jobdiv").html();
	if(html.replace(" ","")==''){
		var jobids=(job_class)?job_class.split(','):(new Array());
		var job_class_append=','+(job_class?job_class:'')+',';
		var selhtml="";
		html='<div class="student_tips" style="left: 120px;"></div><div class="sPopupTitle290"><h1 class="student_tips_h1"><span>已选择</span></h1><div class="dialog-content"><ul class="selected clearfix">{selall}</ul></div><div class="tips_ture"><a href="javascript:determine();"  class="tips_sub1">确认</a><a href="javascript:closelayer();" class="tips_sub2">取消</a></div></div><div class="clear"></div><div class="sPopupBlock"><table id="jobTab" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>';

			for(var i=0;i<ji.length;i++){
				var jobclassid1=ji[i];
				if((i+1)%2==0){
					html+='<tr class="zebraCol0">';
				}else{
					html+=' <tr class="zebraCol1">';
				}
				html+='<td class="leftClass jobtypeLCla" valign="middle" nowrap="nowrap">'+jn[jobclassid1]+'</td><td class="jobtypeItems"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr>';
				if(typeof(jt[jobclassid1])=='object'){
					 for(var j=0;j<jt[jobclassid1].length;j++){
						var disabled = "";
						var allchecked = "";
						var jobclassid2=jt[jobclassid1][j];

						if(job_class_append.indexOf(','+jobclassid2+',')>=0){
							selhtml +='<li class="all'+jobclassid2+'"><a class="clean g3 selall" href="javascript:void(0);" data-val="'+jobclassid2+'+'+jn[jobclassid2]+'"><span class="text">'+jn[jobclassid2]+'</span><span class="delete" data-id="'+jobclassid2+'">移除</span></a></li>';
							disabled = "disabled";
							allchecked = "checked";
						}
						if(typeof(jt[jobclassid2])=='object'){
							html+=' <td class="blurItem " width="25%" id="td'+jobclassid2+'"><span class="availItem" title="'+jn[jobclassid2]+'" id="span'+jobclassid2+'" style="display:block" onclick="showjob(\''+jobclassid2+'\');">'+jn[jobclassid2]+'</span>  ';

							html+='<div style="display:none;" class="seach_tck_box_hy" id="div'+jobclassid2+'" onmouseout="guanbiselect(\''+jobclassid2+'\');"><label style="color:#ff9900" ><input class="availCbox" type="checkbox" onclick="check_all(\''+jobclassid2+'\');" id="all'+jobclassid2+'" '+allchecked+' data-name="'+jn[jobclassid2]+'" value="'+jobclassid2+'" style="margin:0 2px 0 0;">'+jn[jobclassid2].substring(0,11)+'</label>';
							if ((j+1)%3=="0"){
								html+=' <div id="son_div_'+jobclassid2+'" class="sPopupDivSubJobname sPopupDivLeftTop" style="width: 360px; background-position: -81px -1px; z-index: 1001; left:-165px; top: 17px; ;">';
							}else{
								html+='<div id="son_div_'+jobclassid2+'" class="sPopupDivSubJobname sPopupDivLeftTop" style="width: 360px; background-position: 197px -1px; z-index: 1001; left:-3px; top: 17px; ;">';
							}
							html+='<div class="paddingBlock"><table class="chebox" width="100" cellspacing="0" cellpadding="0" border="0"><tbody><tr>';
							
							for(var k=0;k<jt[jobclassid2].length;k++){
								var checked = "";
								var jobclassid3=jt[jobclassid2][k];
								if(job_class_append.indexOf(','+jobclassid3+',')>=0){
									selhtml +='<li class="job_class_'+jobclassid3+' parent_'+jobclassid2+'"><a class="clean g3 selall" href="javascript:void(0);" data-val="'+jobclassid3+'+'+jn[jobclassid3]+'"><span class="text">'+jn[jobclassid3]+'</span><span class="delete" data-id="'+jobclassid3+'" data-pid ="'+jobclassid2+'">移除</span></a></li>';
									if(allchecked==''){
										checked = "checked";
									}
								}

								html+='<td class="mOutItem" width="50%" id="label'+jobclassid2+'" ><label class="noselItem" onclick="check_this(\''+jobclassid3+'\');"><input id="job_class_'+jobclassid3+'" class="seach_box_cheack label'+jobclassid2+'" '+disabled+' '+allchecked+' '+checked+' onclick="check_this(\''+jobclassid3+'\');" type="checkbox" data-pid = "'+jobclassid2+'" data-name="'+jn[jobclassid3]+'" value="'+jobclassid3+'+'+jn[jobclassid3]+'" >'+jn[jobclassid3]+' </label></td>';
								if((k+1)%2=="0"){
									html+=' </tr> <tr>';
								}
							}
							html+=' </tr></tbody> </table></div></div></div></td>';
						}else{
							html+="<td  class=\"mOutItem\" width=\"25%\"><label class=\"noselItem\" onclick=\"check_this('"+jobclassid2+"');\"><input id=\"job_class_"+jobclassid2+"\" class=\"seach_box_cheack label50\" type=\"checkbox\" value=\""+jobclassid2+"+"+jn[jobclassid2]+"\" data-name=\""+jn[jobclassid3]+"\" data-pid=\"50\" onclick=\"check_this('"+jobclassid2+"');\">"+jn[jobclassid2]+"</label></td>";
						}
						if( (j+1)%4==0){
							html+=' </tr><tr> ';
						}
					}
					if(jt[jobclassid1].length<3){
						html+=' <td width="25%"></td><td width="25%"></td>  ';
					}else if(jt[jobclassid1].length<4){
						html+=' <td width="25%"></td>';
					}
				}
				html+='</tr></tbody></table></td></tr>';
			}
		html+=' </tbody></table></div>';
		html = html.replace('{selall}',selhtml);
		$("#jobdiv").html(html);
			$.layer({
				type : 1,
				title : '职位类别',
				offset : ['20px' , '50%'],
				closeBtn : [0 , true],
				fix : false,
				border : [10 , 0.3 , '#000', true],
				move : false,
				area : ['960px','auto'],
				page : {dom :'#jobdiv'}
			});
	}else{
		$("#jobdiv").html(html);
		$.layer({
			type : 1,
			title : '职位类别',
			offset : ['100px' , '50%'],
			closeBtn : [0 , true],
			fix : false,
			border : [10 , 0.3 , '#000', true],
			move : false,
			area : ['960px','auto'],
			page : {dom :'#jobdiv'}
		}); 
	}
}
function index_city(cityin_name_selector,cityin_selector){
	window.cityin_name_selector=cityin_name_selector;
	window.cityin_selector=cityin_selector;
	var html = $("#citydiv").html();
	if(html.replace(" ","")==''){		
		html=' <div class="student_tips" style="left: 550px;"></div><div class="clear"></div><div class="sPopupBlock sPopupBlock_city"><div class="clear" style="height: 5px;"></div><div class="pCityItemB" style="display: block;"><div class="sPopupTabCB"><table class="sPopupTabC" cellspacing="0" cellpadding="0" border="0"><tbody><tr>';
		for(var i=0;i<ci.length;i++){
			html+='<td class="blurItem" width="15%" id="td_city'+ci[i]+'" onclick="showcity(\''+ci[i]+'\')" onmouseout="guanbicity(\''+ci[i]+'\');"><span class="availItem" style="display: ;" id="span_city'+ci[i]+'" >'+cn[ci[i]]+'</span><div class="seach_tck_box_hy" style="display:none;" id="div_city'+ci[i]+'" ><div class="s_b_city_icon"></div><span>'+cn[ci[i]]+'</span>';
			if ((i+1)%6==0 || (i+1)%6==4 || (i+1)%6==5){
				html+='<div class="sPopupDivSubJobname sPopupDivSubCity" style="background-position:-2px -1px;z-index:1001;left:-246px; top: 19px; ">';
			}else{
				html+=' <div class="sPopupDivSubJobname sPopupDivSubCity" style="background-position: 105px -1px; z-index: 1001; left: -5px; top:19px; ">';
			}
			var cityid1=ci[i];
			if(typeof(ct[cityid1])=='object'){
				for(var j=0;j<ct[cityid1].length;j++){
					if(cn[ct[cityid1][j]]){
						html+='<span class="subCboxItem mOutItem" style="width:107px;" onclick="checkcity(\''+ct[cityid1][j]+'\',\''+cn[ct[cityid1][j]]+'\');"> <span class="availItem" >'+cn[ct[cityid1][j]]+'</span> </span>';
					}
				}
			}
			html+=' <div class="clear"></div></div></div></td>';
			if((i+1)%6==0){
				html+='</tr><tr>';
			}
		}
		html+=' <tr></tbody></table><div class="clear" style="height: 5px;"></div></div></div></div>';
		$("#citydiv").html(html);
			$.layer({
				type : 1,
				title : '选择工作地区',
				offset : ['100px' , '50%'],
				closeBtn : [0 , true],
				fix : false,
				border : [10 , 0.3 , '#000', true],
				move : false,
				area : ['650px','auto'],
				page : {dom :'#citydiv'}
			}); 
	}else{
		$("#citydiv").html(html);
		$.layer({
			type : 1,
			title : '选择工作地区',
			offset : ['100px' , '50%'],
			closeBtn : [0 , true],
			fix : false,
			border : [10 , 0.3 , '#000', true],
			move :false,
			area : ['650px','auto'],
			page : {dom :'#citydiv'}
		}); 
	}
}
function showcity(id){
	$("#td_city"+id).attr("class","focusItemTop mOutItem");
	$("#span_city"+id).hide();
	$("#div_city"+id).show();
}
function guanbicity(id){
   $("#td_city"+id).bind("mouseleave", function(){
	$("#td_city"+id).attr("class","blurItem");
	$("#span_city"+id).show();
	$("#div_city"+id).hide();
   });
}
function checkcity(id,name){
	$("#city").val(name);
	$("#cityid").val(id);
	$(window.cityin_name_selector).val(name);
	$(window.cityin_selector).val(id);
	 layer.closeAll();
}
function showjob(id){
	$("#td"+id).attr("class","focusItemTop mOutItem");
	$("#span"+id).hide();
	$("#div"+id).show();
}
function determine(id){
	var check_val,name_val;
	$(".selall").each(function(){
		var info =$(this).attr("data-val").split("+");
		check_val+=","+info[0];
		name_val+="+"+info[1];
	}); 
	
	if(check_val){ 
		  check_val = check_val.replace("undefined,","");
		  $("#job_class").val(check_val); 
	}  
	if(name_val==''||name_val==undefined){
		name_val=$("#index_job_class_val").attr('placeholder'); 
		 $("#job_class").val(''); 
	}
 	if(name_val){
		name_val = name_val.replace("undefined+","");  
  		$("#index_job_class_val").val(name_val);
	}
	layer.closeAll();
}
function check_all(id){
	if($("#all"+id).attr("checked")!="checked"){
		$(".label"+id).removeAttr("disabled");
		$(".label"+id).removeAttr("checked");
		unsel(id);
	}else{
		$("#all"+id).attr("checked","true");
		$(".label"+id).attr("disabled","disabled");
		$(".label"+id).attr("checked","true");
		addsel(id);
	}
}
function addsel(id,pid){
	var i=0;
	$(".selall").each(function(){
		i++;
	});
	if(parseInt(pid)>0){		
		if(i>5){
			unsel(id,pid);
			layer.msg('您最多只能选择五项！', 2,8);
			return false;
		}else{
			var name = $('#job_class_'+id).attr('data-name');
			html = '<li class="job_class_'+id+' parent_'+pid+'"><a class="clean g3 selall" href="javascript:void(0);" data-val="'+id+'+'+name+'"><span class="text">'+name+'</span><span class="delete" data-id="'+id+'" data-pid ="'+pid+'">移除</span></a></li>';
			$('.job_class_'+id).remove();
			$('.selected').first().append(html);
		}
	}else{
		if(i>4){
			unsel(id);
			layer.msg('您最多只能选择五项！', 2,8);
			return false;
		}else{
			var name = $('#all'+id).attr('data-name');
			html = '<li class="all'+id+'"><a class="clean g3 selall" href="javascript:void(0);"  data-val="'+id+'+'+name+'"><span class="text">'+name+'</span><span class="delete" data-id="'+id+'">移除</span></a></li>';
			$('.parent_'+id).remove();
			$('.all'+id).remove();
			$('.selected').first().append(html);
		}
	}
}
function unsel(id,pid){
	if(parseInt(pid)>0){
		$('.job_class_'+id).remove();
		$('#job_class_'+id).removeAttr("checked","");
	}else{
		$('.all'+id).remove();
		$('#all'+id).removeAttr("checked","");
		$('.label'+id).removeAttr("disabled");
		$('.label'+id).removeAttr("checked");
	}
}
function closelayer(){
	layer.closeAll();
}
function guanbiselect(id){
   $("#td"+id).bind("mouseleave", function(){
		$("#td"+id).attr("class","blurItem");
		$("#span"+id).show();
		$("#div"+id).hide();
   });
}
function check_this(id){
	if($("#job_class_"+id).attr("disabled") != 'disabled'){
		if($("#job_class_"+id).attr("checked")!="checked"){
		 	var pid = $("#job_class_"+id).attr('data-pid');
			 $("#job_class_"+id).removeAttr("checked");
			 unsel(id,pid);
		}else{
			 var pid = $("#job_class_"+id).attr('data-pid');
			 $("#job_class_"+id).attr("checked","true");
			 addsel(id,pid);
		}
	}
}
function showurl(url){
	window.location.href=url;
}
function acityshow(id){
	if(id==1){
		$(".acity_two").addClass('search_city_active');
		$(".acity_three").removeClass('search_city_active');
		$("#acity_two").removeClass('none');
		$("#acity_three").addClass('none');
	}else if(id==2){
		$(".acity_three").addClass('search_city_active');
		$(".acity_two").removeClass('search_city_active');
		$("#acity_two").addClass('none');
		$("#acity_three").removeClass('none');
	}
}