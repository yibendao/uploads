$(document).ready(function() {
    $(".pj_resume").click(function(){
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
						page : {dom :"#evaluation_box"} 
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
						page : {dom :"#evaluation_box"}
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
					page : {dom :"#evaluation_box"}
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
});