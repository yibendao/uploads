
function saveuserform(){
	  var name=$.trim($("#name").val());
	  var savetype=1;
	  var birthday=$("#birthday").val();
	  var expid=$("#expid").val();
	  var sex=$("input[name='sex']:checked").val();
	  var eduid=$("#educid").val();
	  var ageid=$("#ageid").val();
	  var marriageid=$("#marriageid").val();
	  var telphone=$("#telphone").val();
	  var email=$("#email").val();
	  var living=$("#living").val();
	  var address=$("#address").val();
	  var homepage=$("#homepage").val();
	  var height=$("#height").val();
	  var nationality=$("#nationality").val();
	  var weight=$("#weight").val();
	  var domicile=$("#domicile").val();
	  var telhome=$("#telhome").val();
	  var basic_infoid=$("#basic_infoid").val();

	if(name||birthday||expid||eduid||marriageid||telphone||email||living||address||homepage||height||nationality||weight||domicile||telhome){
		  $.post(weburl+"/member/index.php?m=ajax&c=saveform",{savetype:savetype,name:name,birthday:birthday,expid:expid,sex:sex,eduid:eduid,ageid:ageid,marriageid:marriageid,telphone:telphone
		  ,email:email,living:living,address:address,homepage:homepage,height:height,nationality:nationality,weight:weight,domicile:domicile,telhome:telhome,basic_infoid:basic_infoid},function(data){
			  if(data=="1"){
          return false;
        }else{
         return false;
        }
		  }); 
	}
}

function saveexpform(){
	  var name=$("#name").val();
	  var savetype=2;
	  var job_classid=$("input[name=job_class ]").val();
	  var provinceid=$("#provinceid").val();
	  var citysid=$("#citysid").val();
	  var three_cityid=$("#three_cityid").val();
	  var hyid=$("#hyid").val();
	  var salaryid=$("#salaryid").val();
	  var typeid=$("#typeid").val();
	  var expid=$("#expid").val();
	  var sex=$("input[name='sex']:checked").val();
	  var eduid=$("#educid").val();
	  var reportid=$("#reportid").val();
	  var ageid=$("#ageid").val();
	  var uname=$("#uname").val();
	  var statusid=$("#statusid").val();
	  var living=$("#living").val();
	  var telphone=$("#telphone").val();
	  var email=$("#email").val();
	  if(job_classid||statusid||provinceid||hyid||salaryid||typeid||reportid){
		  $.post(weburl+"/member/index.php?m=ajax&c=saveform",{name:name,savetype:savetype,job_classid:job_classid,provinceid:provinceid,citysid:citysid,three_cityid:three_cityid,hyid:hyid
		 ,salaryid:salaryid,typeid:typeid,expid:expid,reportid:reportid,uname:uname,sex:sex,eduid:eduid,statusid:statusid,living:living,telphone:telphone,email:email},function(data){
			 
			 return false;
        
		  });
	  }

}

	function savecomform(){
	 var savetype=3;
	  var name=$("#name").val();
	  var provinceid=$("#qyprovinceid").val();
	  var citysid=$("#citysid").val();
	  var address=$("#address").val();
	  var linkman=$("#linkman").val();
	  var content=editor.text(); 
	  var busstops=$("#busstops").val(); 
	  var hyid=$("#qyhyid").val();
	  var munid=$("#munid").val();
	  var website=$("#website").val()
	  var qyprid=$("#qyprid").val();
	  var sdate=$("#sdate").val();
	  var money=$("#money").val();
	  var zip=$("#zip").val();
	  var linkqq=$("#linkqq").val();
	  var linktel=$("#linktel").val();
	  var linkphone=$("#linkphone").val();
	  var linkjob=$("#linkjob").val();
	  var linkmail=$("#linkmail").val();

	 if(hyid||munid||qyprid||address||provinceid||linkman||linkphone||content||busstops||sdate||zip||linkqq||linkjob||website){
		 $.post(weburl+"/member/index.php?m=ajax&c=saveform",{savetype:savetype,name:name,provinceid:provinceid,citysid:citysid,address:address,linkman:linkman,content:content,hyid:hyid
	  ,munid:munid,website:website,linkqq:linkqq,qyprid:qyprid,busstops:busstops,sdate:sdate,money:money,zip:zip,linkqq:linkqq,linktel:linktel,linkphone:linkphone,linkjob:linkjob,linkmail:linkmail},function(data){
        
          return false;
        
	  });
	}
}

function savejobform(){
	 var savetype=4;
	  var name=$("#name").val();
	  var job_postid=$("#job_post").val();
	  var provinceid=$("#provinceid").val();
	  var citysid=$("#citysid").val();
	  var three_cityid=$("#three_cityid").val();
	  var days=$("#days").val();
	  var description=editor.html();
	  var hyid=$("#hyid").val();
	  var edate=$("#edate").val();
	  var munid=$("#numberid").val();
	  var salarysid=$("#salaryid").val();
	  var minsalary=$("#minsalary").val();
	  var maxsalary=$("#maxsalary").val();
	  var typesid=$("#typeid").val();
	  var expsid=$("#expid").val();
	  var sexsid=$("#sexid").val();
	  var edusid=$("#eduid").val();
	  var reportsid=$("#reportid").val();
	  var ageid=$("#ageid").val();
	  var marriagesid=$("#marriageid").val();
	  var lang = $("input[name='lang[]']:checked").serialize();
	  var welfare = $("input[name='welfare[]']:checked").serialize();
	  var is_link= $("input[name='is_link']:checked").val();
	  var days_type= $("input[name='days_type']:checked").val();
	  var link_man=$("link_man").val();
	  var link_moblie=$("link_moblie").val();
	  var link_type=$("input[name='link_type']:checked").val();
	  var is_email=$("input[name='is_email']:checked").val();
	  var email_type=$("input[name='email_type']:checked").val();
	  var email=$("#email").val();
	  if(name||job_postid||description||provinceid||lang||welfare||minsalary||maxsalary){
		  $.post(weburl+"/member/index.php?m=ajax&c=saveform",{name:name,savetype:savetype,job_postid:job_postid,description:description,provinceid:provinceid,citysid:citysid,three_cityid:three_cityid,days:days,reportsid:reportsid,hyid:hyid
		  ,munid:munid,salarysid:salarysid,minsalary:minsalary,maxsalary:maxsalary,typesid:typesid,days_type:days_type,edate:edate,expsid:expsid,ageid:ageid,sexsid:sexsid,edusid:edusid,marriagesid:marriagesid,lang:lang,welfare:welfare,is_link:is_link,link_type:link_type,link_man:link_man,link_moblie:link_moblie,is_email:is_email,email_type:email_type,email:email},function(data){
			 
          return false;
        
		  });
		}
	}

function savepartform(){
	 var savetype=5;
	  var name=$("#name").val();
	  var number=$("#number").val();
	  var provinceid=$("#provinceid").val();
	  var citysid=$("#citysid").val();
	  var three_cityid=$("#three_cityid").val();
	  var address=$("#address").val();
	  var content=editor.text(); 
	  var billingid=$("#billing_cycleid").val();
	  var edate=$("#edate").val();
	  var sdate=$("#sdate").val();
	  var sexid=$("#sexid").val();
	  var worktime =$("input[name='worktime[]']").serialize();
	  var salary_typeid=$("#salary_typeid").val();
	  var salarys=$("#salary").val();
	  var typesid=$("#typeid").val();
	  var deadline=$("#deadline").val();
	  var linkman=$("#linkman").val();
	  var linktel=$("#linktel").val();
	  var shour=$("#shour").val();
	  var sminute=$("#sminute").val();
	  var ehour=$("#ehour").val();
	  var eminute=$("#eminute").val();
	  if(name||number||provinceid||address||content||billingid||edate||sdate||sexid||worktime||salarys||typesid||deadline||linkman||linktel){
		  $.post(weburl+"/member/index.php?m=ajax&c=saveform",{savetype:savetype,name:name,number:number,provinceid:provinceid,citysid:citysid,three_cityid:three_cityid,address:address,content:content,billingid:billingid,edate:edate,
		  sdate:sdate,salary_typeid:salary_typeid,salarys:salarys,sexid:sexid,typesid:typesid,deadline:deadline,linkman:linkman,linktel:linktel},function(data){
		return false;
      
		  });
	   }
	}

function saveuser(){
	var savetype=1;
	 parent.layer.confirm("此操作将会覆盖所填写的内容？",function(){$.post(weburl+"/member/index.php?m=ajax&c=readform",
	 {savetype:savetype},function(data){ 
	 var data=eval('('+data+')');
	 $("#name").val(data.name);
	 $("#birthday").val(data.birthday);
	 if(data.sexs){
		 $("#sexs").val(data.sexs);
		 $("#expid").val(data.expid);
		 }
	 $("#sex"+data.sex).attr("checked","checked");
	  if(data.edu){
		$("#educ").val(data.edu);
	 	$("#educid").val(data.eduid);
		}
	 $("#age").val(data.age);
	  if(data.marriage){
		 $("#marriage").val(data.marriage);
		 $("#marriageid").val(data.marriageid);
		 }
	 $("#telphone").val(data.telphone);
	 $("#email").val(data.email);
	 $("#living").val(data.living);
	 $("#address").val(data.address);
	 $("#homepage").val(data.homepage);
	 $("#height").val(data.height);
	 $("#nationality").val(data.nationality);
	 $("#weight").val(data.weight);
	 $("#domicile").val(data.domicile);
	 $("#telhome").val(data.telhome);
	  if(data.basic_info){
		$("#basic_info").val(data.basic_info);
	 	$("#basic_infoid").val(data.basic_infoid);
		 }
		});parent.layer.closeAll();});
	}

function saveexp(){
	var savetype=2;
	 parent.layer.confirm("此操作将会覆盖所填写的内容？",function(){$.post(weburl+"/member/index.php?m=ajax&c=readform",
	 {savetype:savetype},function(data){ 
	 var data=eval('('+data+')');
	 $("#name").val(data.name);
	 if(data.hy){
		$("#hy").val(data.hy);
	 	$("#hyid").val(data.hyid);
		}
	  if(data.exp){
	 	$("#exp").val(data.exp);
		$("#expid").val(data.expid);
		}
	 $("#sex"+data.sex).attr("checked","checked");
	 if(data.edu){
		$("#educ").val(data.edu);
	 	$("#educid").val(data.eduid);
		}
	 if(data.job_classid){
		$("#job_class").val(data.job_classid);
	 	$("#workadds_job").val(data.job_class);
		}
	 if(data.provinceid){
		$("#provinceid").val(data.provinceid);
	 	$("#province").val(data.province);
		}
	 if(data.citysid){
		$("#citysid").val(data.citysid);
	 	$("#citys").val(data.citys);
		}
	 if(data.three_cityid){
		$("#three_cityid").val(data.three_cityid);
		$("#three_city").val(data.three_city);
		}
	 if(data.salaryid){
		$("#salaryid").val(data.salaryid);
	 	$("#salary").val(data.salary);
		}
	 if(data.typeid){
		$("#typeid").val(data.typeid);
	 	$("#type").val(data.type);
		}
	 if(data.reportid){
		$("#reportid").val(data.reportid);
	 	$("#report").val(data.report);
		 }
	 if(data.statusid){
		$("#statusid").val(data.statusid);
	 	$("#status").val(data.status);
		}
	  $("#uname").val(data.uname);
	 $("#telphone").val(data.telphone);
	  $("#email").val(data.email);
	 $("#living").val(data.living);
		});parent.layer.closeAll();});
	}

function savecom(){
		var savetype=3;
	 parent.layer.confirm("此操作将会覆盖所填写的内容？",function(){$.post(weburl+"/member/index.php?m=ajax&c=readform",
	 {savetype:savetype},function(data){ 
	 var data=eval('('+data+')');
	  $("#name").val(data.name);
	  if(data.provinceid){
		$("#qyprovinceid").val(data.provinceid);
	 	$("#qyprovince").val(data.province);
		}
	 if(data.citysid){
		$("#citysid").val(data.citysid);
	 	$("#citys").val(data.citys);
		}
	 if(data.hyid){
		 $("#qyhyid").val(data.hyid);
		 $("#qyhy").val(data.hy);
		 }
	 $("#address").val(data.address);
	 $("#linkman").val(data.linkman);
	 if(data.munid){
		 $("#munid").val(data.munid);
		 $("#mun").val(data.mun);
		 }
	 $("#website").val(data.website);
	 $("#linkqq").val(data.linkqq);
	 if(data.qyprid){
		$("#qyprid").val(data.qyprid);
	 	$("#qypr").val(data.qypr);
		}
	 $("#sdate").val(data.sdate);
	 $("#money").val(data.money);
	 $("#zip").val(data.zip);
	 $("#linkqq").val(data.linkqq);
	 $("#linktel").val(data.linktel);
	 $("#linkphone").val(data.linkphone);
	 $("#linkjob").val(data.linkjob);
	 $("#linkmail").val(data.linkmail);
	 editor.text(data.content);
	 editors.text(data.busstops);

		});parent.layer.closeAll();});
	}

function savejob(){
	 var savetype=4;
	 parent.layer.confirm("此操作将会覆盖所填写的内容？",function(){
		$.post(weburl+"/member/index.php?m=ajax&c=readform",{savetype:savetype},function(data){ 
			var data=eval('('+data+')');
			$("#name").val(data.name);
			$("#minsalary").val(data.minsalary);
			$("#maxsalary").val(data.maxsalary);
			if(data.provinceid){ 
				$("#provinceid").val(data.provinceid);
				$("#province").val(data.province);
				
			}
			if(data.citysid){
				$("#citysid").val(data.citysid);
				$("#citys").val(data.citys);

			 } 
			 if(data.three_cityid){

				selects(data.three_cityid,'three_city',data.three_city);
			 }
			if(data.hyid){
				 $("#hyid").val(data.hyid);
				 $("#hy").val(data.hy);
			 }
			if(data.job_post){
				 $("#workadds_job").val(data.job_post);
				 $("#job_post").val(data.job_postid);
			 }
			editor.html(data.description);
			$("#days").val(data.days);
			if(data.munid){
				$("#numberid").val(data.munid);
				$("#number").val(data.mun);
			} 
			if(data.salarysid){
				$("#salaryid").val(data.salarysid);
				$("#salary").val(data.salarys);
			}
			if(data.typesid){
				$("#typeid").val(data.typesid);
				$("#type").val(data.types);
			}
			if(data.exps){
				$("#exp").val(data.exps);
				$("#expid").val(data.expsid);
			}
			$("#edate").val(data.edate);
			if(data.edusid){
				 $("#edu").val(data.edus);
				 $("#eduid").val(data.edusid);
			}
			$("#is_link"+data.is_link).attr("checked","checked");
			$("#link_man").val(data.link_man);
			if(data.sexsid){
				$("#sexid").val(data.sexsid);
				$("#sex").val(data.sexs);
			}
			data.lang.forEach(function(lang){  $("#lang"+lang).attr("checked","checked"); });  
			data.welfare.forEach(function(welfare){  $("#welfare"+welfare).attr("checked","checked"); });
			if(data.reportsid){
				$("#reportid").val(data.reportsid);
				$("#report").val(data.reports);
			}
			if(data.ageid){
				$("#ageid").val(data.ageid);
				$("#age").val(data.age);
			}
			if(data.marriages){
				$("#marriage").val(data.marriages);
				$("#marriageid").val(data.marriagesid);
			}
			$("#link_moblie").val(data.link_moblie);
			$("#link_type"+data.link_type).attr("checked","checked");
			$("#is_email"+data.is_email).attr("checked","checked");

			$("#link_moblie").text(data.link_moblie);
			$("#email_type"+data.email_type).attr("checked","checked");
			$("#email").val(data.email); 
		});
		parent.layer.closeAll();
	});
}

function savepart(){
	 var savetype=5;
	 layer.confirm("此操作将会覆盖所填写的内容？",function(){$.post(weburl+"/member/index.php?m=ajax&c=readform",{savetype:savetype},function(data){ 
	 var data=eval('('+data+')');
	 $("#name").val(data.name);
	 if(data.provinceid){
		$("#provinceid").val(data.provinceid);
	 	$("#province").val(data.province);
		}
	 if(data.citysid){
		 $("#citysid").val(data.citysid);
		 $("#citys").val(data.citys);
		 }
	 if(data.three_cityid){
		$("#three_cityid").val(data.three_cityid);
		$("#three_city").val(data.three_city);
		}
	 if(data.salary_typeid){
		$("#salary_typeid").val(data.salary_typeid);
	 	$("#salary_type").val(data.salary_type);
		}
	if(data.billingid){
		$("#billing_cycleid").val(data.billingid);
	 	$("#billing_cycle").val(data.billing_cycle);
		}
	 if(data.typesid){
		$("#typeid").val(data.typesid);
	 	$("#type").val(data.types);
		}
	 if(data.sexid){
		$("#sexid").val(data.sexid);
	 	$("#sex").val(data.sex);
		}
	 $("#salary").val(data.salarys);
	 editor.text(data.content);
	 $("#address").val(data.address);
	 $("#number").val(data.number);
	 $("#edate").val(data.edate);
	 $("#sdate").val(data.sdate);
	 $("#deadline").val(data.deadline);
	 $("#linkman").val(data.linkman);
	 $("#linktel").val(data.linktel);
	 $("#time").val(data.linktel); 
	});parent.layer.closeAll();});
}

$(document).ready(function() {
   $("#close").click(function(){
	$("#forms").slideToggle("normal");
	}); 
});