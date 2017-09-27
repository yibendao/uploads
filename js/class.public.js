$(document).ready(function () {
    $('.delete').live('click', function () {
        var id = $(this).attr('data-id');
        var pid = $(this).attr('data-pid');
        if (parseInt(pid) > 0) {
            unsel(id, pid);
        } else {
            unsel(id)
        }
    });
    $('.search_job_list').hover(function () {
        $(".search_job_list").removeClass("search_job_list_cur_line");
        $(this).addClass('search_job_list_cur_line');
        $(".search_job_list_cur_line>.search_job_list_box").show();
    }, function () {
        var ltype = $('#ltype').val();
        if (ltype == '') {
            $(".search_job_list_cur_line>.search_job_list_box").hide();
            $(".search_job_list").removeClass("search_job_list_cur_line");
        }
    }
	);

    $(".com_admin_ask").hover(function () {
        layer.tips("加入搜索器，方便下次直接搜索，无需点击众多条件！", this, {
            guide: 1,
            style: ['background-color:#F26C4F; color:#fff;top:-7px', '#F26C4F']
        });
    }, function () { layer.closeTips(); });
});

$(document).ready(function () {
    $('#jobdiv').delegate('.yun_tck_con_list_jobclass1 ul .jobclassid1', 'click', function () {
        if (window.jobclass1_checkbox_type == 'hidden') {
            $(this).addClass('selected').siblings().removeClass('selected');
        }
        var jobclassid1 = $(this).attr('codeid');
        var jobclassid2_html = '';
        if (typeof (jt[jobclassid1]) == 'object') {
            if (jt[jobclassid1].length <= 0) {
                jobclass_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            } else {
                if (window.jobclass2_checkbox_type != 'hidden') {
                    jobclassid2_html += '<li class="jobclassid2_all jobclassid2" codeid="' + jobclassid1 + '" codename="' + jn[jobclassid1] + '">' +
											'<labelabc for="jobclassid2_all_' + jn[jobclassid1] + '"><input type="' + window.jobclass2_checkbox_type + '" name="jobclassid2_all" class="jobclassid2_all_checkbox" id="jobclassid2_all_' + jn[jobclassid1] + '"/>全部(' +
												jn[jobclassid1] +
											')</labelabc>' +
										'</li>';
                }
                for (var j = 0; j < jt[jobclassid1].length; j++) {
                    var jobclassid2 = jt[jobclassid1][j];
                    jobclassid2_html += '<li class="jobclassid2" codeid="' + jobclassid2 + '" codename="' + jn[jobclassid2] + '">' +
										'<labelabc for="jobclassid2_' + jn[jobclassid2] + '"><input type="' + window.jobclass2_checkbox_type + '" name="jobclassid2" class="jobclassid2_checkbox" id="jobclassid2_' + jn[jobclassid2] + '"/>' +
                                        	jn[jobclassid2] +
										'</labelabc>' +
									'</li>';
                }
            }
        } else {
            jobclass_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
        }
        if (jobclassid2_html != '') {
            $('.yun_tck_con_list_jobclass3 li').remove();
            $('.yun_tck_con_list_jobclass2').show();
            $('.yun_tck_con_list_jobclass2 ul').html(jobclassid2_html);
        }
    });
    $('#jobdiv').delegate('.yun_tck_con_list_jobclass2 ul .jobclassid2', 'click', function () {
        if (window.jobclass2_checkbox_type == 'hidden') {
            $(this).addClass('selected').siblings().removeClass('selected');
        }
        var jobclassid2 = $(this).attr('codeid');
        var jobclassid3_html = '';
        if ((typeof (jt[jobclassid2]) == 'object') && (!$(this).hasClass('jobclassid2_all'))) {
            if (jt[jobclassid2].length <= 0) {
                var checked_all = jobclass_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
                if ($(this).hasClass('jobclassid2_all')) {
                    if (checked_all) {
                        $(this).addClass('selected').siblings().removeClass('selected');
                    } else {
                        $(this).removeClass('selected').siblings().removeClass('selected');
                    }
                    $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
                }
            } else {
                if (window.jobclass3_checkbox_type != 'hidden') {
                    jobclassid3_html += '<li class="jobclassid3_all jobclassid3" codeid="' + jobclassid2 + '" codename="' + jn[jobclassid2] + '">' +
											'<labelabc for="jobclassid3_all_' + jn[jobclassid2] + '"><input type="' + window.jobclass3_checkbox_type + '" name="jobclassid3_all" class="jobclassid3_all_checkbox" id="jobclassid3_all_' + jn[jobclassid2] + '"/>全部(' +
												jn[jobclassid2] +
											')</labelabc>' +
										'</li>';
                }
                for (var j = 0; j < jt[jobclassid2].length; j++) {
                    var jobclassid3 = jt[jobclassid2][j];
                    jobclassid3_html += '<li class="jobclassid3" codeid="' + jobclassid3 + '" codename="' + jn[jobclassid3] + '">' +
										'<labelabc for="jobclassid3_' + jn[jobclassid3] + '"><input type="' + window.jobclass3_checkbox_type + '" name="jobclassid3" class="jobclassid3_checkbox" id="jobclassid3_' + jn[jobclassid3] + '"/>' +
                                        	jn[jobclassid3] +
										'</labelabc>' +
									'</li>';
                }
            }
        } else {
            var checked_all = jobclass_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            if ($(this).hasClass('jobclassid2_all')) {
                if (checked_all) {
                    $(this).addClass('selected').siblings().removeClass('selected');
                } else {
                    $(this).removeClass('selected').siblings().removeClass('selected');
                }
                $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
            }
        }
        if (jobclassid3_html != '') {
            $('.yun_tck_con_list_jobclass3').show();
            $('.yun_tck_con_list_jobclass3 ul').html(jobclassid3_html);
        }
    });
    $('#jobdiv').delegate('.yun_tck_con_list_jobclass3 ul .jobclassid3', 'click', function () {

        if ($(this).siblings('.jobclassid3_all').length > 0) {
            if ($(this).siblings('.jobclassid3_all').hasClass('selected')) {
                return;
            }
        }
        var checked_all = jobclass_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
        if ($(this).hasClass('jobclassid3_all')) {

            if (checked_all) {
                $(this).addClass('selected').siblings().removeClass('selected');
            } else {
                $(this).removeClass('selected').siblings().removeClass('selected');
            }
            $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
        }
    });
    $('#jobdiv').delegate('.yun_tit_selected .selected .delete', 'click', function () {
        var codeid = $(this).parent().parent().attr('codeid');
        $('#jobdiv li[codeid=' + codeid + ']').removeClass('selected');

        $(this).parent().parent().remove();
    });
    $('#jobdiv').delegate('.yun_tck_tit_close,#cancel_btn', 'click', function () {
        layer.close(window.jobclass_layer);
    });
    $('#jobdiv').delegate('#btnSubmitJobsort', 'click', function () {
        confirm_selected_jobclass_items();
    });
});
function get_jobclass_deep() {

    var jt_length = 0, ji_length = 0;
    for (var j = 0; j <= jt.length; j++) {
        if (jt[j]) {
            jt_length++;
        }
    }
    for (var j = 0; j <= ji.length; j++) {
        if (ji[j]) {
            ji_length++;
        }
    }
    if ((jt_length > 0) && (ji_length < jt_length)) {
        window.jobclass_deep = 3;
    } else if ((jt_length > 0) && (ji_length == jt_length)) {
        window.jobclass_deep = 2;
    } else {
        window.jobclass_deep = 1;
    }
    return window.jobclass_deep;
}

function jobclass_item_select(jobclass_id, jobclass_name, type, jobclass_element) {

    if (window.allow_select_jobclass_count == 1) {
        $('#jobdiv .yun_tit_selected .selected').html('');
        $('#jobdiv .yun_tit_selected .selected').append('<li codeid="' + jobclass_id + '" codename="' + jobclass_name + '">' +
							'<a class="clean g3 selall" href="javascript:;">' +
								'<span class="text">' +
									jobclass_name +
								'</span>' +
								'<span class="delete">' +
									'移除' +
								'</span>' +
							'</a>' +
						'</li>');
        $(jobclass_element).addClass('selected').siblings().removeClass('selected');

    } else {
        var jobclass_items = $('#jobdiv .yun_tit_selected .selected li');
        for (var i = 0; i < jobclass_items.length; i++) {
            if ($(jobclass_items[i]).attr('codeid') == jobclass_id) {
                if ($(jobclass_items[i]).find('input').is(":hidden")) {
                    $('#jobdiv li[codeid=' + $(jobclass_items[i]).attr('codeid') + ']').removeClass('selected');
                    $(jobclass_element).find('input')[0].checked = false;
                    return false;
                } else {
                    $(jobclass_items[i]).find('.delete').click();
                    $('#jobdiv li[codeid=' + $(jobclass_items[i]).attr('codeid') + ']').removeClass('selected');
                    $(jobclass_element).find('input')[0].checked = false;
                    return false;
                }
            }
            if (typeof (jt[jobclass_id]) == 'object') {
                if (jt[jobclass_id].length > 0) {
                    for (var j = 0; j < jt[jobclass_id].length; j++) {
                        if (jt[jobclass_id][j] == $(jobclass_items[i]).attr('codeid')) {
                            $(jobclass_items[i]).find('.delete').click();
                            $('#jobdiv li[codeid=' + $(jobclass_items[i]).attr('codeid') + ']').removeClass('selected');
                        }
                    }
                }
            }
        }
        if (jobclass_items.length >= parseInt(window.allow_select_jobclass_count)) {
			layer.msg('最多不能超过'+parseInt(window.allow_select_jobclass_count)+'个！', 2, 8);return false;
            $(jobclass_element).find('.delete').click();
            $('#jobdiv li[codeid=' + jobclass_id + ']').removeClass('selected');
            $('#jobdiv li[codeid=' + jobclass_id + ']').find('input')[0].checked = false;
            return false;
        }
        $(jobclass_element).find('input')[0].checked = true;
        $('#jobdiv li[codeid=' + jobclass_id + ']').addClass('selected');
        $('#jobdiv .yun_tit_selected .selected').append('<li codeid="' + jobclass_id + '" codename="' + jobclass_name + '">' +
                                '<a class="clean g3 selall" href="javascript:;">' +
                                    '<span class="text">' +
                                        jobclass_name +
                                    '</span>' +
                                    '<span class="delete">' +
                                        '移除' +
                                    '</span>' +
                                '</a>' +
                            '</li>');
    }
    return true;
}

function confirm_selected_jobclass_items() {

    var jobclass_items = $('#jobdiv .yun_tit_selected .selected li');
    var jobclass_ids = '';
    var jobclass_names = '';
    for (var i = 0; i < jobclass_items.length; i++) {
        jobclass_ids += ',' + $(jobclass_items[i]).attr('codeid');
        jobclass_names += ',' + $(jobclass_items[i]).attr('codename');
    } 
    if(jobclass_names.length<=0){
        layer.msg('请选择具体类别！', 2, 8);return false;
    }else{
      if (window.target_jobclassin_names_tagname == 'INPUT') {
          $(window.target_jobclassin_names).val(jobclass_names.substring(1));
		  var addtype=$("#addtype").val();
		  if(addtype=='addexpect'){
			  $("#hidjob_class").attr("class","resume_tipok");
			  $("#hidjob_class").html('');
		  }
      } else {
          $(window.target_jobclassin_names).html(jobclass_names.substring(1));
      }
      if (window.target_jobclassin_ids_tagname == 'INPUT') {
          $(window.target_jobclassin_ids).val(jobclass_ids.substring(1));
      } else {
          $(window.target_jobclassin_ids).html(jobclass_ids.substring(1));
      }
      if (window.index_jobclass_callback) {
          window.index_jobclass_callback();
      }
      layer.close(window.jobclass_layer);
     
	  $.post(weburl+"/index.php?m=ajax&c=getcontent",{ids:jobclass_ids.substring(1)},function(data){
		  if(data){
			var datas=data.split('@@@@'); 
			for(var i=0;i<datas.length;i++){
				var ndata=datas[i].split('###'); 
				$("#JobRequInfoTemplate").append("<a href=\"javascript:void(0)\" onclick=\"setexample('"+ndata[0]+"')\">"+ndata[1]+"</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
			}
			$(".Description").show();  
		  }
	  });
	   return true;
    } 
}
function setexample(id){
	$.post(weburl+"/index.php?m=ajax&c=setexample",{id:id},function(data){
		if(data){
			editor.html(data);
		} 
	});
	
}

function index_job(allow_select_jobclass_count, target_jobclassin_names, target_jobclassin_ids, jobdiv_style, codeids, index_jobclass_callback) {
    if ($(target_jobclassin_names).length <= 0) {layer.msg('职位类别名称目标元素不存在！', 2, 8);return false;}
    if ($(target_jobclassin_ids).length <= 0) { layer.msg('职位类别编号目标元素不存在！', 2, 8);return false;}

    window.allow_select_jobclass_count = allow_select_jobclass_count;

    window.target_jobclassin_names = target_jobclassin_names;

    window.target_jobclassin_ids = target_jobclassin_ids;

    window.target_jobclassin_names_tagname = $(target_jobclassin_names)[0].nodeName;

    window.target_jobclassin_ids_tagname = $(target_jobclassin_ids)[0].nodeName;

    window.jobdiv_style = jobdiv_style;

    window.index_jobclass_callback = index_jobclass_callback;

    var jobclass_deep = get_jobclass_deep();
    switch (jobclass_deep) {
        case 1:
            window.jobclass1_checkbox_type = 'checkbox';
            window.jobclass2_checkbox_type = 'hidden';
            window.jobclass3_checkbox_type = 'hidden';
            $('.yun_tck_con_list').hide();
            $('.yun_tck_con_list_jobclass1').show();
            break;
        case 2:
            window.jobclass1_checkbox_type = 'hidden';
            window.jobclass2_checkbox_type = 'checkbox';
            window.jobclass3_checkbox_type = 'hidden';
            $('.yun_tck_con_list').hide();
            $('.yun_tck_con_list_jobclass1').show();
            $('.yun_tck_con_list_jobclass2').show();
            break;
        case 3:
            window.jobclass1_checkbox_type = 'hidden';
            window.jobclass2_checkbox_type = 'hidden';
            window.jobclass3_checkbox_type = 'checkbox';
            $('.yun_tck_con_list_jobclass1').show();
            $('.yun_tck_con_list_jobclass2').show();
            $('.yun_tck_con_list_jobclass3').show();
            break;
        default: break;
    }

    if (window.allow_select_jobclass_count == 1) {
        window.jobclass1_checkbox_type = 'hidden';
        window.jobclass2_checkbox_type = 'hidden';
        window.jobclass3_checkbox_type = 'hidden';
    }

    var html = $("#jobdiv").html();
    if (html.replace(" ", "") == '') {
        var codeids_list = (codeids) ? codeids.split(',') : (new Array());
        var codeids_html = '';
        for (var i = 0; i < codeids_list.length; i++) {
            var codeid = codeids_list[i];
            var codename = jn[codeid];
            codeids_html += '<li codeid="' + codeid + '" codename="' + codename + '">' +
							'<a class="clean g3 selall" href="javascript:;">' +
								'<span class="text">' +
									codename +
								'</span>' +
								'<span class="delete">' +
									'移除' +
								'</span>' +
							'</a>' +
						'</li>';
        }
        var jobclass1_html = '';
        for (var i = 0; i < ji.length; i++) {
            var jobclassid1 = ji[i];
            jobclass1_html += '<li class="jobclassid1" codeid="' + jobclassid1 + '" codename="' + jn[jobclassid1] + '">' +
                                    '<labelabc for="jobclassid1_' + jn[jobclassid1] + '"><input type="' + window.jobclass1_checkbox_type + '" name="jobclassid1" class="jobclassid1_checkbox" id="jobclassid1_' + jn[jobclassid1] + '"/>' +
                                        jn[jobclassid1] +
                                    '</labelabc>' +
                                '</li>';
        }
        html = '<div class="yun_tck">' +
            '<div class="yun_tck_box">' +
                '<div class="yun_tck_tit">' +
                    '<span class="yun_tck_tit_span">' +
                        '职位类别' +
                    '</span>' +
                    '<a href="javascript:;" class="yun_tck_tit_close">' +
                        '关闭' +
                    '</a>' +
                '</div>' +
				'<div class="yun_tck_title">' +
                    '<div class="yun_tck_title_box">' +
                        '<div class="yun_tck_tit_xz">' +
                            '<span class="yun_tck_tit_xz_l">' +
                                '已选择：' +
                            '</span>' +
                            '<span class="yun_tck_tit_xz_r">' +
                                '(最多可以选择 ' + allow_select_jobclass_count + ' 项)' +
                            '</span>' +
                        '</div>' +
						'<div class="yun_tit_selected">' +
                            '<ul class="selected clearfix">' +
								codeids_html +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="clear">' +
                '</div>' +
				'<div class="dropLst">' +
                    '<div class="yun_tck_con">' +
                        '<div class="yun_tck_con_list yun_tck_con_list_jobclass1">' +
                            '<ul>' +
                                jobclass1_html +
                            '</ul>' +
                        '</div>' +
						'<div class="yun_tck_con_list yun_tck_con_list_jobclass2">' +
                            '<ul>' +
                            '</ul>' +
                        '</div>' +
						'<div class="yun_tck_con_list yun_tck_con_list_jobclass3">' +
                            '<ul>' +
                            '</ul>' +
                        '</div>' +
                        '<div class="clear">' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '</span>' +
            '</div>' +
            '<div class="clear">' +
            '</div>' +
            '<div class="actions">' +
                '<button class="button_a button_a_red" id="btnSubmitJobsort">' +
                    '确定' +
                '</button>' +
                '<button class="button_a" id="cancel_btn">' +
                    '取消' +
                '</button>' +
            '</div>' +
        '</div>';
        html += ' </tbody></table></div>';
        $("#jobdiv").html(html);
    } else {
        $("#jobdiv").html(html);
    }
	
    window.jobclass_layer = $.layer({
        type: 1,
        title: false,
        offset: ['100px', ($(window).width() - 620) / 2 + 'px'],
        closeBtn: [0, false],
        fix: false,
        border: [0, 0.3, '#000', true],
        move: false,
        area: ['620px', '440px'],
        page: { dom: '#jobdiv' }
    });
}
function check_select_show(id) {
    $("#list" + id).show();
}
function check_onselect(id, val, name) {
    $("#" + id).val(val);
    $("#list" + id).hide();
    $("#button" + id).val(name);
}
function addfinder(para, usertype) {
    $.post(weburl + "/job/index.php?c=addfinder", { para: para, usertype: usertype }, function (data) {
        var data = eval('(' + data + ')');
        layer.msg(data.msg, Number(data.tm), Number(data.st)); return false;
    });
}
$(document).ready(function () {
    $('#citydiv').delegate('.yun_tck_con_list_city1 ul .cityid1', 'click', function () {
        if (window.city1_checkbox_type == 'hidden') {
            $(this).addClass('selected').siblings().removeClass('selected');
        }
        var cityid1 = $(this).attr('codeid');
        var cityid2_html = '';
        if (typeof (ct[cityid1]) == 'object') {
            if (ct[cityid1].length <= 0) {
                
                city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            } else {
                
                if (window.city2_checkbox_type != 'hidden') {
                    cityid2_html += '<li class="cityid2_all cityid2" codeid="' + cityid1 + '" parentid="' + 0 + '" codename="' + cn[cityid1] + '">' +
											'<labelabc for="cityid2_all_' + cn[cityid1] + '"><input type="' + window.city2_checkbox_type + '" name="cityid2_all" class="cityid2_all_checkbox" id="cityid2_all_' + cn[cityid1] + '"/>全部(' +
												cn[cityid1] +
											')</labelabc>' +
										'</li>';
                }
                for (var j = 0; j < ct[cityid1].length; j++) {
                    var cityid2 = ct[cityid1][j];
                    cityid2_html += '<li class="cityid2" codeid="' + cityid2 + '" parentid="' + cityid1 + '" codename="' + cn[cityid2] + '">' +
										'<labelabc for="cityid2_' + cn[cityid2] + '"><input type="' + window.city2_checkbox_type + '" name="cityid2" class="cityid2_checkbox" id="cityid2_' + cn[cityid2] + '"/>' +
                                        	cn[cityid2] +
										'</labelabc>' +
									'</li>';
                }
                city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            }
        } else {
            city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
        }
        if (cityid2_html != '') {
            $('.yun_tck_con_list_city3 li').remove();
            $('.yun_tck_con_list_city2 ul').html(cityid2_html);
        }else{
            $('.yun_tck_con_list_city3 li').remove();
            $('.yun_tck_con_list_city2 ul').html('');
		}
    });
    $('#citydiv').delegate('.yun_tck_con_list_city2 ul .cityid2', 'click', function () {
        if (window.city2_checkbox_type == 'hidden') {
            $(this).addClass('selected').siblings().removeClass('selected');
        }
        var cityid1 = $(this).attr('parentid');
        var cityid2 = $(this).attr('codeid');
        var cityid3_html = '';
        if ((typeof (ct[cityid2]) == 'object') && (!$(this).hasClass('cityid2_all'))) {
            if (ct[cityid2].length <= 0) {
               
                var checked_all = city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
                if ($(this).hasClass('cityid2_all')) {
                  
                    if (checked_all) {
                        $(this).addClass('selected').siblings().removeClass('selected');
                    } else {
                        $(this).removeClass('selected').siblings().removeClass('selected');
                    }
                    $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
                }
            } else {
              
                city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
                if (window.allow_select_city_level > 2) {
                    if (window.city3_checkbox_type != 'hidden') {
                        cityid3_html += '<li class="cityid3_all cityid3" codeid="' + cityid2 + '" parentid="' + cityid1 + '" codename="' + cn[cityid2] + '">' +
                                                '<labelabc for="cityid3_all_' + cn[cityid2] + '"><input type="' + window.city3_checkbox_type + '" name="cityid3_all" class="cityid3_all_checkbox" id="cityid3_all_' + cn[cityid2] + '"/>全部(' +
                                                    cn[cityid2] +
                                                ')</labelabc>' +
                                            '</li>';
                    }
                    for (var j = 0; j < ct[cityid2].length; j++) {
                        var cityid3 = ct[cityid2][j];
                        cityid3_html += '<li class="cityid3" codeid="' + cityid3 + '" parentid="' + cityid2 + '" codename="' + cn[cityid3] + '">' +
                                            '<labelabc for="cityid3_' + cn[cityid3] + '"><input type="' + window.city3_checkbox_type + '" name="cityid3" class="cityid3_checkbox" id="cityid3_' + cn[cityid3] + '"/>' +
                                                cn[cityid3] +
                                            '</labelabc>' +
                                        '</li>';
                    }
                }
            }
        } else {
          
            var checked_all = city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            if ($(this).hasClass('cityid2_all')) {
              
                if (checked_all) {
                    $(this).addClass('selected').siblings().removeClass('selected');
                } else {
                    $(this).removeClass('selected').siblings().removeClass('selected');
                }
                $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
            }
        }
        if (cityid3_html != '' && window.allow_select_city_level > 2) {
            $('.yun_tck_con_list_city3').show();
            $('.yun_tck_con_list_city3 ul').html(cityid3_html);
        }
    });
    $('#citydiv').delegate('.yun_tck_con_list_city3 ul .cityid3', 'click', function () {
       
        if ($(this).siblings('.cityid3_all').length > 0) {
            if ($(this).siblings('.cityid3_all').hasClass('selected')) {
                return;
            }
        }
        var checked_all = city_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
        if ($(this).hasClass('cityid3_all')) {
          
            if (checked_all) {
                $(this).addClass('selected').siblings().removeClass('selected');
            } else {
                $(this).removeClass('selected').siblings().removeClass('selected');
            }
            $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
        }
    });
    $('#citydiv').delegate('.yun_tit_selected .selected .delete', 'click', function () {
        var codeid = $(this).parent().parent().attr('codeid');
        $('#citydiv li[codeid=' + codeid + ']').removeClass('selected');
        $('#citydiv li[codeid=' + codeid + ']').find('input')[0].checked = false;
        $(this).parent().parent().remove();
    });
    $('#citydiv').delegate('.yun_tck_tit_close,#cancel_btn', 'click', function () {
        layer.closeAll();
    });
    $('#citydiv').delegate('#btnSubmitJobsort', 'click', function () {
        confirm_selected_city_items();
    });
});
function get_city_deep() {
    var ct_length = 0, ci_length = 0;
    for (var j = 0; j <= ct.length; j++) {
        if (ct[j]) {
            ct_length++;
        }
    }
    for (var j = 0; j <= ci.length; j++) {
        if (ci[j]) {
            ci_length++;
        }
    }
    if ((ct_length > 0) && (ci_length < ct_length)) {
        window.city_deep = 3;
    } else if ((ct_length > 0) && (ci_length == ct_length)) {
        window.city_deep = 2;
    } else {
        window.city_deep = 1;
    }
    return window.city_deep;
}

function city_item_select(city_id, city_name, type, city_element) {

    if (window.allow_select_city_count == 1) {
        $('#citydiv .yun_tit_selected .selected').html('');
        $('#citydiv .yun_tit_selected .selected').append('<li codeid="' + city_id + '" codename="' + city_name + '">' +
							'<a class="clean g3 selall" href="javascript:;">' +
								'<span class="text">' +
									city_name +
								'</span>' +
								'<span class="delete">' +
									'移除' +
								'</span>' +
							'</a>' +
						'</li>');
        $(city_element).addClass('selected').siblings().removeClass('selected');

    } else {
        var city_items = $('#citydiv .yun_tit_selected .selected li');

        $('#citydiv li[codeid=' + $(city_element).attr('parentid') + ']').find('.delete').click();

        if (!$(city_element).hasClass('cityid1_all') && !$(city_element).hasClass('cityid2_all') && !$(city_element).hasClass('cityid3_all')) {

            for (var i = 0; i < city_items.length; i++) {
                if ($(city_items[i]).attr('codeid') == city_id) {
                    if ($(city_items[i]).find('input').is(":hidden")) {
                        $('#citydiv li[codeid=' + $(city_items[i]).attr('codeid') + ']').removeClass('selected');
                        $(city_element).find('input')[0].checked = false;
                        return false;
                    } else {
                        $(city_items[i]).find('.delete').click();
                        $('#citydiv li[codeid=' + $(city_items[i]).attr('codeid') + ']').removeClass('selected');
                        $(city_element).find('input')[0].checked = false;
                        return false;
                    }
                }

                if (typeof (ct[city_id]) == 'object') {
                    if (ct[city_id].length > 0) {
                        for (var j = 0; j < ct[city_id].length; j++) {
                            if (ct[city_id][j] == $(city_items[i]).attr('codeid')) {
                                $(city_items[i]).find('.delete').click();
                                $('#citydiv li[codeid=' + $(city_items[i]).attr('codeid') + ']').removeClass('selected');
                            }
                        }
                    }
                }
            }
        } else {

            for (var i = 0; i < city_items.length; i++) {

                if (typeof (ct[city_id]) == 'object') {
                    if (ct[city_id].length > 0) {
                        for (var j = 0; j < ct[city_id].length; j++) {
                            if (ct[city_id][j] == $(city_items[i]).attr('codeid')) {
                                $(city_items[i]).find('.delete').click();
                                $('#citydiv li[codeid=' + $(city_items[i]).attr('codeid') + ']').removeClass('selected');
                            }
                        }
                    }
                }
            }
            for (var i = 0; i < city_items.length; i++) {
                if ($(city_items[i]).attr('codeid') == city_id) {
                    if ($(city_element).find('input')[0].checked == false) {
                        $('#citydiv li[codeid=' + city_id + ']').find('.delete').click();
                    }
                    return $('#citydiv li[codeid=' + city_id + ']').find('input')[0].checked;
                }
            }
        }

        if (city_items.length >= parseInt(window.allow_select_city_count)) {
            $(city_element).find('.delete').click();
            $('#citydiv li[codeid=' + city_id + ']').removeClass('selected');
            $('#citydiv li[codeid=' + city_id + ']').find('input')[0].checked = false;
            return false;
        }
        $(city_element).find('input')[0].checked = true;
        $('#citydiv li[codeid=' + city_id + ']').addClass('selected');
        $('#citydiv .yun_tit_selected .selected').append('<li codeid="' + city_id + '" codename="' + city_name + '">' +
                                '<a class="clean g3 selall" href="javascript:;">' +
                                    '<span class="text">' +
                                        city_name +
                                    '</span>' +
                                    '<span class="delete">' +
                                        '移除' +
                                    '</span>' +
                                '</a>' +
                            '</li>');
    }
    return true;
}

function confirm_selected_city_items() {

    var city_items = $('#citydiv .yun_tit_selected .selected li');
    var city_ids = '';
    var city_names = '';
    for (var i = 0; i < city_items.length; i++) {
        city_ids += ',' + $(city_items[i]).attr('codeid');
        city_names += ',' + $(city_items[i]).attr('codename');
    }
    if (window.target_cityin_names_tagname == 'INPUT') {
        $(window.target_cityin_names).val(city_names.substring(1));
    } else {
        $(window.target_cityin_names).html(city_names.substring(1));
    }
    if (window.target_cityin_ids_tagname == 'INPUT') {
        $(window.target_cityin_ids).val(city_ids.substring(1));
    } else {
        $(window.target_cityin_ids).html(city_ids.substring(1));
    }
    if (window.index_city_callback) {
        window.index_city_callback();
    }
    layer.closeAll();
    return true;
}
function index_city(allow_select_city_count, target_cityin_names, target_cityin_ids, citydiv_style, codeids, index_city_callback, allow_select_city_level) {
    if ($(target_cityin_names).length <= 0) {layer.msg('城市名称目标元素不存在！', 2, 8);return false; }
    if ($(target_cityin_ids).length <= 0) { layer.msg('城市编号目标元素不存在！', 2, 8);return false;}

    window.allow_select_city_count = allow_select_city_count;

    window.target_cityin_names = target_cityin_names;

    window.target_cityin_ids = target_cityin_ids;

    window.target_cityin_names_tagname = $(target_cityin_names)[0].nodeName;

    window.target_cityin_ids_tagname = $(target_cityin_ids)[0].nodeName;

    window.citydiv_style = citydiv_style;

    window.index_city_callback = index_city_callback;

    window.allow_select_city_level = allow_select_city_level ? allow_select_city_level : 99;

    var city_deep = get_city_deep();
    switch (city_deep) {
        case 1:
            window.city1_checkbox_type = 'checkbox';
            window.city2_checkbox_type = 'hidden';
            window.city3_checkbox_type = 'hidden';
            break;
        case 2:
            window.city1_checkbox_type = 'hidden';
            window.city2_checkbox_type = 'checkbox';
            window.city3_checkbox_type = 'hidden';
            break;
        case 3:
            window.city1_checkbox_type = 'hidden';
            window.city2_checkbox_type = 'hidden';
            window.city3_checkbox_type = 'checkbox';
            break;
        default: break;
    }

    if (window.allow_select_city_count == 1) {
        window.city1_checkbox_type = 'hidden';
        window.city2_checkbox_type = 'hidden';
        window.city3_checkbox_type = 'hidden';
    }

    var html = $("#citydiv").html();
    if (html.replace(" ", "") == '') {
        var codeids_list = (codeids) ? codeids.split(',') : (new Array());
        var codeids_html = '';
        for (var i = 0; i < codeids_list.length; i++) {
            var codeid = codeids_list[i];
            var codename = cn[codeid];
            codeids_html += '<li codeid="' + codeid + '" codename="' + codename + '">' +
							'<a class="clean g3 selall" href="javascript:;">' +
								'<span class="text">' +
									codename +
								'</span>' +
								'<span class="delete">' +
									'移除' +
								'</span>' +
							'</a>' +
						'</li>';
        }
        var city1_html = '';
        for (var i = 0; i < ci.length; i++) {
            var cityid1 = ci[i];
            city1_html += '<li class="cityid1" codeid="' + cityid1 + '" parentid="' + 0 + '" codename="' + cn[cityid1] + '">' +
                                    '<labelabc for="cityid1_' + cn[cityid1] + '"><input type="' + window.city1_checkbox_type + '" name="cityid1" class="cityid1_checkbox" id="cityid1_' + cn[cityid1] + '"/>' +
                                        cn[cityid1] +
                                    '</labelabc>' +
                                '</li>';
        }
        html = '<div class="yun_tck">' +
            '<div class="yun_tck_box">' +
                '<div class="yun_tck_tit">' +
                    '<span class="yun_tck_tit_span">' +
                        '城市选择' +
                    '</span>' +
                    '<a href="javascript:;" class="yun_tck_tit_close">' +
                        '关闭' +
                    '</a>' +
                '</div>' +
				'<div class="yun_tck_title">' +
                    '<div class="yun_tck_title_box">' +
                        '<div class="yun_tck_tit_xz">' +
                            '<span class="yun_tck_tit_xz_l">' +
                                '已选择：' +
                            '</span>' +
                            '<span class="yun_tck_tit_xz_r">' +
                                '(最多可以选择 ' + allow_select_city_count + ' 项)' +
                            '</span>' +
                        '</div>' +
						'<div class="yun_tit_selected">' +
                            '<ul class="selected clearfix">' +
								codeids_html +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="clear">' +
                '</div>' +
				'<div class="dropLst">' +
                    '<div class="yun_tck_con">' +
                        '<div class="yun_tck_con_list yun_tck_con_list_city1">' +
                            '<ul>' +
                                city1_html +
                            '</ul>' +
                        '</div>' +
						'<div class="yun_tck_con_list yun_tck_con_list_city2">' +
                            '<ul>' +
                            '</ul>' +
                        '</div>' +
						'<div class="yun_tck_con_list yun_tck_con_list_city3">' +
                            '<ul>' +
                            '</ul>' +
                        '</div>' +
                        '<div class="clear">' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '</span>' +
            '</div>' +
            '<div class="clear">' +
            '</div>' +
            '<div class="actions">' +
                '<button class="button_a button_a_red" id="btnSubmitJobsort">' +
                    '确定' +
                '</button>' +
                '<button class="button_a" id="cancel_btn">' +
                    '取消' +
                '</button>' +
            '</div>' +
        '</div>';
        html += ' </tbody></table></div>';
        $("#citydiv").html(html);
    } else {
        $("#citydiv").html(html);
    }
    switch (city_deep) {
        case 1:
            $('.yun_tck_con_list').hide();
            $('.yun_tck_con_list_city1').show();
            break;
        case 2:
            $('.yun_tck_con_list_city1').show();
            $('.yun_tck_con_list_city2').show();
            break;
        case 3:
            $('.yun_tck_con_list_city1').show();
            $('.yun_tck_con_list_city2').show();
            $('.yun_tck_con_list_city3').show();
            break;
        default: break;
    }
    if (window.allow_select_city_level <= 1) {
        $('.yun_tck_con_list_city1').show();
        $('.yun_tck_con_list_city2').hide();
        $('.yun_tck_con_list_city3').hide();
    } else if (window.allow_select_city_level <= 2) {
        $('.yun_tck_con_list_city1').show();
        $('.yun_tck_con_list_city2').show();
        $('.yun_tck_con_list_city3').hide();
    } else {
        $('.yun_tck_con_list_city1').show();
        $('.yun_tck_con_list_city2').show();
        $('.yun_tck_con_list_city3').show();
    }
    window.city_layer = $.layer({
        type: 1,
        title: false,
        offset: ['100px', ($(window).width() - 620) / 2 + 'px'],
        closeBtn: [0, false],
        fix: false,
        border: [0, 0.3, '#000', true],
        move: false,
        area: ['620px', '440px'],
        page: { dom: '#citydiv' }
    });
}
function showcity(id) {
    $("#td_city" + id).attr("class", "focusItemTop mOutItem");
    $("#span_city" + id).hide();
    $("#div_city" + id).show();
}
function guanbicity(id) {
    $("#td_city" + id).bind("mouseleave", function () {
        $("#td_city" + id).attr("class", "blurItem");
        $("#span_city" + id).show();
        $("#div_city" + id).hide();
    });
}
function checkcity(id, name) {
    $("#city").val(name);
    $("#cityid").val(id);
    $(window.cityin_name_selector).val(name);
    $(window.cityin_selector).val(id);
    layer.closeAll();
}
function showjob(id) {
    $("#td" + id).attr("class", "focusItemTop mOutItem");
    $("#span" + id).hide();
    $("#div" + id).show();
}
function determine(id) {
    var check_val, name_val;
    $(".selall").each(function () {
        var info = $(this).attr("data-val").split("+");
        check_val += "," + info[0];
        name_val += "+" + info[1];
    });

    if (check_val) {
        check_val = check_val.replace("undefined,", "");
        $("#job_class").val(check_val);
    }
    if (name_val == '' || name_val == undefined) {
        name_val = $("#index_job_class_val").attr('placeholder');
        $("#job_class").val('');
    }
    if (name_val) {
        name_val = name_val.replace("undefined+", "");
        $("#index_job_class_val").val(name_val);
    }
    layer.closeAll();
}
function check_all(id) {
    if ($("#all" + id).attr("checked") != "checked") {
        $(".labelabc" + id).removeAttr("disabled");
        $(".labelabc" + id).removeAttr("checked");
        unsel(id);
    } else {
        $("#all" + id).attr("checked", "true");
        $(".labelabc" + id).attr("disabled", "disabled");
        $(".labelabc" + id).attr("checked", "true");
        addsel(id);
    }
}
function addsel(id, pid) {
    
    var i = 0;
    $(".selall").each(function () {
        i++;
    });
    if (parseInt(pid) > 0) {
        if (i > 5) {
            unsel(id, pid);
            layer.msg('您最多只能选择五项！', 2, 8);
            return false;
        } else {
            var name = $('#job_class_' + id).attr('data-name');
            html = '<li class="job_class_' + id + ' parent_' + pid + '"><a class="clean g3 selall" href="javascript:void(0);" data-val="' + id + '+' + name + '"><span class="text">' + name + '</span><span class="delete" data-id="' + id + '" data-pid ="' + pid + '">移除</span></a></li>';
            $('.job_class_' + id).remove();
            $('.selected').first().append(html);
        }
    } else {
        if (i > 4) {
            unsel(id);
            layer.msg('您最多只能选择五项！', 2, 8);
            return false;
        } else {
            var name = $('#all' + id).attr('data-name');
            html = '<li class="all' + id + '"><a class="clean g3 selall" href="javascript:void(0);"  data-val="' + id + '+' + name + '"><span class="text">' + name + '</span><span class="delete" data-id="' + id + '">移除</span></a></li>';
            $('.parent_' + id).remove();
            $('.all' + id).remove();
            $('.selected').first().append(html);
        }
    }
}
function unsel(id, pid) {
    if (parseInt(pid) > 0) {
        $('.job_class_' + id).remove();
        $('#job_class_' + id).removeAttr("checked", "");
    } else {
        $('.all' + id).remove();
        $('#all' + id).removeAttr("checked", "");
        $('.labelabc' + id).removeAttr("disabled");
        $('.labelabc' + id).removeAttr("checked");
    }
}
function closelayer() {
    layer.closeAll();
}
function guanbiselect(id) {
    $("#td" + id).bind("mouseleave", function () {
        $("#td" + id).attr("class", "blurItem");
        $("#span" + id).show();
        $("#div" + id).hide();
    });
}
function check_this(id) {
    if ($("#job_class_" + id).attr("disabled") != 'disabled') {
        if ($("#job_class_" + id).attr("checked") != "checked") {
            var pid = $("#job_class_" + id).attr('data-pid');
            $("#job_class_" + id).removeAttr("checked");
            unsel(id, pid);
        } else {
            var pid = $("#job_class_" + id).attr('data-pid');
            $("#job_class_" + id).attr("checked", "true");
            addsel(id, pid);
        }
    }
}


$(document).ready(function () {
    $('#industrydiv').delegate('.yun_tck_con_list_industry1 ul .industryid1', 'click', function () {
        if (window.industry1_checkbox_type == 'hidden') {
            $(this).addClass('selected').siblings().removeClass('selected');
        }
        var industryid1 = $(this).attr('codeid');
        var industryid2_html = '';
        if (typeof (ht[industryid1]) == 'object') {
            if (ht[industryid1].length <= 0) {
               
                industry_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            } else {
               
                if (window.industry2_checkbox_type != 'hidden') {
                    industryid2_html += '<li class="industryid2_all industryid2" codeid="' + industryid1 + '" codename="' + hn[industryid1] + '">' +
											'<labelabc for="industryid2_all_' + hn[industryid1] + '"><input type="' + window.industry2_checkbox_type + '" name="industryid2_all" class="industryid2_all_checkbox" id="industryid2_all_' + hn[industryid1] + '"/>全部(' +
												hn[industryid1] +
											')</labelabc>' +
										'</li>';
                }
                for (var j = 0; j < ht[industryid1].length; j++) {
                    var industryid2 = ht[industryid1][j];
                    industryid2_html += '<li class="industryid2" codeid="' + industryid2 + '" codename="' + hn[industryid2] + '">' +
										'<labelabc for="industryid2_' + hn[industryid2] + '"><input type="' + window.industry2_checkbox_type + '" name="industryid2" class="industryid2_checkbox" id="industryid2_' + hn[industryid2] + '"/>' +
                                        	hn[industryid2] +
										'</labelabc>' +
									'</li>';
                }
            }
        } else {
           
            industry_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
        }
        if (industryid2_html != '') {
            $('.yun_tck_con_list_industry3 li').remove();
            $('.yun_tck_con_list_industry2 ul').html(industryid2_html);
        }
    });
    $('#industrydiv').delegate('.yun_tck_con_list_industry2 ul .industryid2', 'click', function () {
        if (window.industry2_checkbox_type == 'hidden') {
            $(this).addClass('selected').siblings().removeClass('selected');
        }
        var industryid2 = $(this).attr('codeid');
        var industryid3_html = '';
        if ((typeof (ht[industryid2]) == 'object') && (!$(this).hasClass('industryid2_all'))) {
            if (ht[industryid2].length <= 0) {
              
                var checked_all = industry_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
                if ($(this).hasClass('industryid2_all')) {
                  
                    if (checked_all) {
                        $(this).addClass('selected').siblings().removeClass('selected');
                    } else {
                        $(this).removeClass('selected').siblings().removeClass('selected');
                    }
                    $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
                }
            } else {
               
                if (window.industry3_checkbox_type != 'hidden') {
                    industryid3_html += '<li class="industryid3_all industryid3" codeid="' + industryid2 + '" codename="' + hn[industryid2] + '">' +
											'<labelabc for="industryid3_all_' + hn[industryid2] + '"><input type="' + window.industry3_checkbox_type + '" name="industryid3_all" class="industryid3_all_checkbox" id="industryid3_all_' + hn[industryid2] + '"/>全部(' +
												hn[industryid2] +
											')</labelabc>' +
										'</li>';
                }
                for (var j = 0; j < ht[industryid2].length; j++) {
                    var industryid3 = ht[industryid2][j];
                    industryid3_html += '<li class="industryid3" codeid="' + industryid3 + '" codename="' + hn[industryid3] + '">' +
										'<labelabc for="industryid3_' + hn[industryid3] + '"><input type="' + window.industry3_checkbox_type + '" name="industryid3" class="industryid3_checkbox" id="industryid3_' + hn[industryid3] + '"/>' +
                                        	hn[industryid3] +
										'</labelabc>' +
									'</li>';
                }
            }
        } else {
           
            var checked_all = industry_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
            if ($(this).hasClass('industryid2_all')) {
               
                if (checked_all) {
                    $(this).addClass('selected').siblings().removeClass('selected');
                } else {
                    $(this).removeClass('selected').siblings().removeClass('selected');
                }
                $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
            }
        }
        if (industryid3_html != '') {
            $('.yun_tck_con_list_industry3').show();
            $('.yun_tck_con_list_industry3 ul').html(industryid3_html);
        }
    });
    $('#industrydiv').delegate('.yun_tck_con_list_industry3 ul .industryid3', 'click', function () {
        if ($(this).siblings('.industryid3_all').length > 0) {
            if ($(this).siblings('.industryid3_all').hasClass('selected')) {
                return;
            }
        }
      
        var checked_all = industry_item_select($(this).attr('codeid'), $(this).attr('codename'), 1, $(this));
        if ($(this).hasClass('industryid3_all')) {
         
            if (checked_all) {
                $(this).addClass('selected').siblings().removeClass('selected');
            } else {
                $(this).removeClass('selected').siblings().removeClass('selected');
            }
            $(this).siblings().each(function () { $(this).find('input')[0].checked = checked_all; if (checked_all) { $(this).find('input').attr('disabled', 'disabled'); } else { $(this).find('input').removeAttr('disabled'); } });
        }
    });
    $('#industrydiv').delegate('.yun_tit_selected .selected .delete', 'click', function () {
        var codeid = $(this).parent().parent().attr('codeid');
        $('#industrydiv li[codeid=' + codeid + ']').removeClass('selected');
        $('#industrydiv li[codeid=' + codeid + ']').find('input')[0].checked = false;
        $(this).parent().parent().remove();
    });
    $('#industrydiv').delegate('.yun_tck_tit_close,#cancel_btn', 'click', function () {
        layer.closeAll();
    });
    $('#industrydiv').delegate('#btnSubmitJobsort', 'click', function () {
        confirm_selected_industry_items();
    });
});
function get_industry_deep() {
    var ht_length = 0, hi_length = 0;
    for (var j = 0; j <= ht.length; j++) {
        if (ht[j]) {
            ht_length++;
        }
    }
    for (var j = 0; j <= hi.length; j++) {
        if (hi[j]) {
            hi_length++;
        }
    }
    if ((ht_length > 0) && (hi_length < ht_length)) {
        window.industry_deep = 3;
    } else if ((ht_length > 0) && (hi_length == ht_length)) {
        window.industry_deep = 2;
    } else {
        window.industry_deep = 1;
    }
    return window.industry_deep;
}

function industry_item_select(industry_id, industry_name, type, industry_element) {
    if (window.allow_select_industry_count == 1) {
        $('#industrydiv .yun_tit_selected .selected').html('');
        $('#industrydiv .yun_tit_selected .selected').append('<li codeid="' + industry_id + '" codename="' + industry_name + '">' +
							'<a class="clean g3 selall" href="javascript:;">' +
								'<span class="text">' +
									industry_name +
								'</span>' +
								'<span class="delete">' +
									'移除' +
								'</span>' +
							'</a>' +
						'</li>');
        $(industry_element).addClass('selected').siblings().removeClass('selected');

    } else {
        var industry_items = $('#industrydiv .yun_tit_selected .selected li');

        for (var i = 0; i < industry_items.length; i++) {
            if ($(industry_items[i]).attr('codeid') == industry_id) {
                if ($(industry_items[i]).find('input').is(":hidden")) {
                    $('#industrydiv li[codeid=' + $(industry_items[i]).attr('codeid') + ']').removeClass('selected');
                    $(industry_element).find('input')[0].checked = false;
                    return false;
                } else {
                    $(industry_items[i]).find('.delete').click();
                    $('#industrydiv li[codeid=' + $(industry_items[i]).attr('codeid') + ']').removeClass('selected');
                    $(industry_element).find('input')[0].checked = false;
                    return false;
                }
            }

            if (typeof (ht[industry_id]) == 'object') {
                if (ht[industry_id].length > 0) {
                    for (var j = 0; j < ht[industry_id].length; j++) {
                        if (ht[industry_id][j] == $(industry_items[i]).attr('codeid')) {
                            $(industry_items[i]).find('.delete').click();
                            $('#industrydiv li[codeid=' + $(industry_items[i]).attr('codeid') + ']').removeClass('selected');
                        }
                    }
                }
            }
        }

        if (industry_items.length >= parseInt(window.allow_select_industry_count)) {
			layer.msg('最多不能超过'+parseInt(window.allow_select_industry_count)+'个！', 2, 8);return false;
            $(industry_element).find('.delete').click();
            $('#industrydiv li[codeid=' + industry_id + ']').removeClass('selected');
            $('#industrydiv li[codeid=' + industry_id + ']').find('input')[0].checked = false;
            return false;
        }
        $(industry_element).find('input')[0].checked = true;
        $('#industrydiv li[codeid=' + industry_id + ']').addClass('selected');
        $('#industrydiv .yun_tit_selected .selected').append('<li codeid="' + industry_id + '" codename="' + industry_name + '">' +
                                '<a class="clean g3 selall" href="javascript:;">' +
                                    '<span class="text">' +
                                        industry_name +
                                    '</span>' +
                                    '<span class="delete">' +
                                        '移除' +
                                    '</span>' +
                                '</a>' +
                            '</li>');
    }
    return true;
}

function confirm_selected_industry_items() {

    var industry_items = $('#industrydiv .yun_tit_selected .selected li');
    var industry_ids = '';
    var industry_names = '';
    for (var i = 0; i < industry_items.length; i++) {
        industry_ids += ',' + $(industry_items[i]).attr('codeid');
        industry_names += ',' + $(industry_items[i]).attr('codename');
    }
	 if(industry_names.length<=0){
        layer.msg('请选择具体类别！', 2, 8);return false;
    }else{

    if (window.target_industryin_names_tagname == 'INPUT') {
        $(window.target_industryin_names).val(industry_names.substring(1));
    } else {
        $(window.target_industryin_names).html(industry_names.substring(1));
    }
    if (window.target_industryin_ids_tagname == 'INPUT') {
        $(window.target_industryin_ids).val(industry_ids.substring(1));
    } else {
        $(window.target_industryin_ids).html(industry_ids.substring(1));
    }
    if (window.index_industry_callback) {
        window.index_industry_callback();
    }
    layer.closeAll();
    return true;
	} 
}

function index_industry(allow_select_industry_count, target_industryin_names, target_industryin_ids, industrydiv_style, codeids, index_industry_callback) {

    if ($(target_industryin_names).length <= 0) { layer.msg('行业类别名称目标元素不存在！', 2, 8);return false;}
    if ($(target_industryin_ids).length <= 0) { layer.msg('行业类别编号目标元素不存在！', 2, 8);return false;}

    window.allow_select_industry_count = allow_select_industry_count;

    window.target_industryin_names = target_industryin_names;

    window.target_industryin_ids = target_industryin_ids;

    window.target_industryin_names_tagname = $(target_industryin_names)[0].nodeName;

    window.target_industryin_ids_tagname = $(target_industryin_ids)[0].nodeName;

    window.industrydiv_style = industrydiv_style;

    window.index_industry_callback = index_industry_callback;

    var industry_deep = get_industry_deep();
    switch (industry_deep) {
        case 1:
            window.industry1_checkbox_type = 'checkbox';
            window.industry2_checkbox_type = 'hidden';
            window.industry3_checkbox_type = 'hidden';
            $('.yun_tck_con_list').hide();
            $('.yun_tck_con_list_industry1').show();
            break;
        case 2:
            window.industry1_checkbox_type = 'hidden';
            window.industry2_checkbox_type = 'checkbox';
            window.industry3_checkbox_type = 'hidden';
            $('.yun_tck_con_list_industry1').show();
            $('.yun_tck_con_list_industry2').show();
            break;
        case 3:
            window.industry1_checkbox_type = 'hidden';
            window.industry2_checkbox_type = 'hidden';
            window.industry3_checkbox_type = 'checkbox';
            $('.yun_tck_con_list_industry1').show();
            $('.yun_tck_con_list_industry2').show();
            $('.yun_tck_con_list_industry3').show();
            break;
        default: break;
    }

    if (window.allow_select_industry_count == 1) {
        window.industry1_checkbox_type = 'hidden';
        window.industry2_checkbox_type = 'hidden';
        window.industry3_checkbox_type = 'hidden';
    }

    var html = $("#industrydiv").html();
    if (html.replace(" ", "") == '') {
        var codeids_list = (codeids) ? codeids.split(',') : (new Array());
        var codeids_html = '';
        for (var i = 0; i < codeids_list.length; i++) {
            var codeid = codeids_list[i];
            var codename = hn[codeid];
            codeids_html += '<li codeid="' + codeid + '" codename="' + codename + '">' +
							'<a class="clean g3 selall" href="javascript:;">' +
								'<span class="text">' +
									codename +
								'</span>' +
								'<span class="delete">' +
									'移除' +
								'</span>' +
							'</a>' +
						'</li>';
        }
        var industry1_html = '';
        for (var i = 0; i < hi.length; i++) {
            var industryid1 = hi[i];
            industry1_html += '<li class="industryid1" codeid="' + industryid1 + '" codename="' + hn[industryid1] + '">' +
                                    '<labelabc for="industryid1_' + hn[industryid1] + '"><input type="' + window.industry1_checkbox_type + '" name="industryid1" class="industryid1_checkbox" id="industryid1_' + hn[industryid1] + '"/>' +
                                        hn[industryid1] +
                                    '</labelabc>' +
                                '</li>';
        }
        html = '<div class="yun_tck">' +
            '<div class="yun_tck_box">' +
                '<div class="yun_tck_tit">' +
                    '<span class="yun_tck_tit_span">' +
                        '行业类别' +
                    '</span>' +
                    '<a href="javascript:;" class="yun_tck_tit_close">' +
                        '关闭' +
                    '</a>' +
                '</div>' +
				'<div class="yun_tck_title">' +
                    '<div class="yun_tck_title_box">' +
                        '<div class="yun_tck_tit_xz">' +
                            '<span class="yun_tck_tit_xz_l">' +
                                '已选择：' +
                            '</span>' +
                            '<span class="yun_tck_tit_xz_r">' +
                                '(最多可以选择 ' + allow_select_industry_count + ' 项)' +
                            '</span>' +
                        '</div>' +
						'<div class="yun_tit_selected">' +
                            '<ul class="selected clearfix">' +
								codeids_html +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="clear">' +
                '</div>' +
				'<div class="dropLst">' +
                    '<div class="yun_tck_con">' +
                        '<div class="yun_tck_con_list yun_tck_con_list_industry1">' +
                            '<ul>' +
                                industry1_html +
                            '</ul>' +
                        '</div>' +
						'<div class="yun_tck_con_list yun_tck_con_list_industry2">' +
                            '<ul>' +
                            '</ul>' +
                        '</div>' +
						'<div class="yun_tck_con_list yun_tck_con_list_industry3">' +
                            '<ul>' +
                            '</ul>' +
                        '</div>' +
                        '<div class="clear">' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '</span>' +
            '</div>' +
            '<div class="clear">' +
            '</div>' +
            '<div class="actions">' +
                '<button class="button_a button_a_red" id="btnSubmitJobsort">' +
                    '确定' +
                '</button>' +
                '<button class="button_a" id="cancel_btn">' +
                    '取消' +
                '</button>' +
            '</div>' +
        '</div>';
        html += ' </tbody></table></div>';
        $("#industrydiv").html(html);
    } else {
        $("#industrydiv").html(html);
    }
    window.industry_layer = $.layer({
        type: 1,
        title: false,
        offset: ['100px', ($(window).width() - 620) / 2 + 'px'],
        closeBtn: [0, false],
        fix: false,
        border: [0, 0.3, '#000', true],
        move: false,
        area: ['620px', '440px'],
        page: { dom: '#industrydiv' }
    });
}
