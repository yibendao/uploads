(function ($) {
    $.fn.ryDate = function (options) {
        var $id = this;
        var defaults = {
            valueid: "value",
            start: 1997,
            end: 2016,
			nextid:'',
			newid:'',
            number: 5,
            titleColor: "#c1c1c1",
            fontColor: "white"
        }
        var options = $.extend(defaults, options);
        this.children().remove();
        this.append("<div class=\"title\"><img class=\"img_ft\" src=\""+userstyle+"/images/tit_ft.png\" title=\"更早时间\" id=\""+options.type+"up\"/>" + options.start + "年-" + options.end + "年<img id=\""+options.type+"next\" class=\"img_rt\" src=\""+userstyle+"/images/tit_rt.png\" title=\"更晚时间\"></div>");
        var years = parseInt(options.end) - parseInt(options.start);
        var num = (100 / parseInt(options.number)) + "%";
		var text='<div class="list_ct"><ul>';
        for (var i = 0; i < years + 1; i++) {
            text += "<li class=\""+options.type+"Date-year\"><a href=\"javascript:void(0);\">" + (parseInt(options.start) + i) + "年</a></li>";
        }
		text+='</ul></div>';
		this.append(text);
        Bind(options);
        up(options, $id, years);
        next(options, $id, years);
    };
    function up(options, $id, years) {
        $("#"+options.type+"up").unbind();
        $("#"+options.type+"up").click(function () {
            options.start = options.start - years;
            options.end = options.end - years;
            $id.children().remove();
            $id.append("<div class=\"title\"><img class=\"img_ft\" src=\""+userstyle+"/images/tit_ft.png\" title=\"更早时间\" id=\""+options.type+"up\"/>" + options.start + "年-" + options.end + "年<img id=\""+options.type+"next\" class=\"img_rt\" src=\""+userstyle+"/images/tit_rt.png\" title=\"更晚时间\"></div>");
            years = parseInt(options.end) - parseInt(options.start);
            num = (100 / parseInt(options.number)) + "%";
            var text='<div class="list_ct"><ul>';
			for (var i = 0; i < years + 1; i++) {
                text+= "<li class=\""+options.type+"Date-year\"><a href=\"javascript:void(0);\">" + (parseInt(options.start) + i) + "年</a></li>";               
            }
			text+='</ul></div>';
			$id.append(text);
            up(options, $id, years);
            next(options, $id, years);
            Bind(options);
        });
    }
    function next(options, $id, years) {
        $("#"+options.type+"next").unbind();
        $("#"+options.type+"next").click(function () {
            options.start = options.start + years;
            options.end = options.end + years;
            $id.children().remove();
            $id.append("<div class=\"title\"><img class=\"img_ft\" src=\""+userstyle+"/images/tit_ft.png\" title=\"更早时间\" id=\""+options.type+"up\"/>" + options.start + "年-" + options.end + "年<img id=\""+options.type+"next\" class=\"img_rt\" src=\""+userstyle+"/images/tit_rt.png\" title=\"更晚时间\"></div>");
            years = parseInt(options.end) - parseInt(options.start);
            num = (100 / parseInt(options.number)) + "%";
            var text='<div class="list_ct"><ul>';
			for (var i = 0; i < years + 1; i++) {
                text+= "<li class=\""+options.type+"Date-year\"><a href=\"javascript:void(0);\">" + (parseInt(options.start) + i) + "年</a></li>";
            }
			text+='</ul></div>';
			$id.append(text);
            up(options, $id, years);
            next(options, $id, years);
            Bind(options);
        });
    }
    function Bind(options) {
        $("."+options.type+"Date-year").unbind();
        callback = $("."+options.type+"Date-year").bind("click", function () {
            var index = $("."+options.type+"Date-year").index(this);
            result = $("."+options.type+"Date-year").eq(index).text().substr(0,4);
            $("#" + options.valueid + "").val(result);
            $("#" + options.valueid + "id").val(result);
			$("#"+options.nextid).attr('style','display:block;');
			$("#"+options.newid).attr('style','display:none;');
        });
    }
})(jQuery);

(function ($) {
    $.fn.rmDate = function (options) {
        var $id = this;
        var defaults = {
            valueid: "value",
            start: 1,
            end: 12,
			nextid:'',
			newid:'',
            number: 5
        }
        var options = $.extend(defaults, options);
        this.children().remove();
        this.append("<div class=\"title\">月份</div>");
        var num = (100 / parseInt(options.number)) + "%";
		var text='<div class="list_ct"><ul>';
        for (var i = 1; i <=12; i++) {
			if(i<10){
				i='0'+i;
			}
            text += "<li class=\""+options.type+"Date-month\"><a href=\"javascript:void(0);\">" +  i+ "月</a></li>";
        }
		text+='</ul></div>';
		this.append(text);
        Bind(options);
    };
    function Bind(options) {
        $("."+options.type+"Date-month").unbind();
        callback = $("."+options.type+"Date-month").bind("click", function () {
            var index = $("."+options.type+"Date-month").index(this);
            result = $("."+options.type+"Date-month").eq(index).text().substr(0,2);
            $("#" + options.valueid + "").val(result);
            $("#" + options.valueid + "id").val(result);
			$("#"+options.nextid).html('<script>var year=$("#year").val();var month=$("#month").val();$("#'+options.nextid+'").dDate({valueid: "cert_sday",start: 1,end: 10,year:year,month:month,newid:"'+options.nextid+'",number: 5});</script>');
			$("#"+options.nextid).show();
			$("#"+options.newid).attr('style','display:none;');
        });
    }
})(jQuery);

(function ($) {
    $.fn.rdDate = function (options) {
        var $id = this;
        var defaults = {
            valueid: "value",
			nextid:'',
			newid:'',
            number: 5
        }
        var options = $.extend(defaults, options);
        this.children().remove();
        this.append("<div class=\"title\">日期</div>");
		var yearval=parseInt(options.year);
		var monthval=parseInt(options.month);
        var num = (100 / parseInt(options.number)) + "%";
		var text='<div class="list_ct"><ul>';		
		if(monthval==1||monthval==3||monthval==5||monthval==7||monthval==8||monthval==10||monthval==12){
			for(var i = 1; i <=31; i++){
				if(i<10){
					i='0'+i;
				}
				text += "<li class=\"Date-day\"><a href=\"javascript:void(0);\">" +  i+ "日</a></li>";
			}
		}else if(monthval==4||monthval==6||monthval==9||monthval==11){
			for(var i = 1; i <=30; i++){
				if(i<10){
					i='0'+i;
				}
				text += "<li class=\"Date-day\"><a href=\"javascript:void(0);\">" +  i+ "日</a></li>";
			}
		}else if(monthval==2){
			if(yearval%4==0&&(yearval%100!=0||yearval%400==0)){
				for(var i = 1; i <=29; i++){
					if(i<10){
						i='0'+i;
					}
					text += "<li class=\"Date-day\"><a href=\"javascript:void(0);\">" +  i+ "日</a></li>";
				}
			}else{
				for(var i = 1; i <=28; i++){
					if(i<10){
						i='0'+i;
					}
					text += "<li class=\"Date-day\"><a href=\"javascript:void(0);\">" +  i+ "日</a></li>";
				}
			}
		}
		text+='</ul></div>';
		this.append(text);
        Bind(options);
    };
    function Bind(options) {
        $(".Date-day").unbind();
        callback = $(".Date-day").bind("click", function () {
            var index = $(".Date-day").index(this);
            result = $(".Date-day").eq(index).text().substr(0,2);
            $("#" + options.valueid + "").val(result);
            $("#" + options.valueid + "id").val(result);			
			$("#"+options.newid).attr('style','display:none;');
        });
    }
})(jQuery);