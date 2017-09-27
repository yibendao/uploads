/**
* Author: Arron.y
* Email: yangyun4814@gmail.com
* Github: https://github.com/ArronYR
* CreateTime: 2016-03-11
*/

'use strict'

// 滑动条对象
function SliderUnlock(elm, options, success, always) {
    var _self = this;

    var $elm = _self.checkElm(elm) ? $(elm) : $;
    var options = _self.checkObj(options) ? options : new Object();
    var success = _self.checkFn(success) ? success : function(){};
    var always = _self.checkFn(always) ? always : function(){};

    var opts = {
        labelTip: typeof(options.labelTip)!=="undefined" ? options.labelTip : "Slide to Unlock",
        successLabelTip: typeof(options.successLabelTip)!=='undefined' ? options.successLabelTip : "Success",
        duration: typeof(options.duration)!=='undefined'||!isNaN(options.duration) ? options.duration : 500,
        swipestart: typeof(options.swipestart)!=='undefined' ? options.swipestart : false,
        min: typeof(options.min)!=='undefined'||!isNaN(options.min) ? options.min : 0,
        max: typeof(options.max)!=='undefined'||!isNaN(options.max) ? options.max : $elm.width(),
        index: typeof(options.index)!=='undefined'||!isNaN(options.index) ? options.index : 0,
        IsOk: typeof(options.isOk)!=='undefined' ? options.isOk : false,
        lableIndex: typeof(options.lableIndex)!=='undefined'||!isNaN(options.lableIndex) ? options.lableIndex : 0
    }

    //$elm
    _self.elm = $elm;
    //opts
    _self.opts = opts;
    //是否开始滑动
    _self.swipestart = opts.swipestart;
    //最小值
    _self.min = opts.min;
    //最大值
    _self.max = opts.max;
    //当前滑动条所处的位置
    _self.index = opts.index;
    //是否滑动成功
    _self.isOk = opts.isOk;
    //鼠标在滑动按钮的位置
    _self.lableIndex = opts.lableIndex;
    //success
    _self.success = success;
    //always
    _self.always = always;
}

// 检测元素是否存在
SliderUnlock.prototype.checkElm = function (elm) {
    if($(elm).length > 0){
        return true;
    }else{
        throw "this element does not exist.";
    }
};

// 检测传入参数是否是对象
SliderUnlock.prototype.checkObj = function (obj) {
    if(typeof obj === "object"){
        return true;
    }else{
        throw "the params is not a object.";
    }
};

// 检测传入参数是否是function
SliderUnlock.prototype.checkFn = function (fn) {
    if(typeof fn === "function"){
        return true;
    }else{
        throw "the param is not a function.";
    }
};

//初始化
SliderUnlock.prototype.init = function () {
    var _self = this;

    _self.updateView();
    _self.elm.find(".slideunlock-label").on("mousedown", function (event) {
        var e = event || window.event;
        _self.lableIndex = e.clientX - this.offsetLeft;
        _self.handerIn();
    }).on("mousemove", function (event) {
        _self.handerMove(event);
    }).on("touchstart", function (event) {
        var e = event || window.event;
        _self.lableIndex = e.originalEvent.touches[0].pageX - this.offsetLeft;
        _self.handerIn();
    }).on("touchmove", function (event) {
        _self.handerMove(event, "mobile");
    }).on("touchend", function (event) {
        _self.handerOut();
    });
}

// 鼠标/手指接触滑动按钮
SliderUnlock.prototype.handerIn = function () {
    var _self = this;
    _self.swipestart = true;
    _self.min = 0;
    _self.max = _self.elm.width();
}

// 鼠标/手指移出
SliderUnlock.prototype.handerOut = function () {
    var _self = this;
    //停止
    _self.swipestart = false;
    if (_self.index < _self.max) {
        _self.reset();
    }
}

//鼠标/手指移动
SliderUnlock.prototype.handerMove = function (event, type) {
    var _self = this;
    if (_self.swipestart) {
        event.preventDefault();
        var event = event || window.event;
        if (type == "mobile") {
            _self.index = event.originalEvent.touches[0].pageX - _self.lableIndex;
        } else {
            _self.index = event.clientX - _self.lableIndex;
        }
        _self.move();
    }
}

//鼠标/手指移动过程
SliderUnlock.prototype.move = function () {
    var _self = this;
    if ((_self.index + 0) >= _self.max) {
        _self.index = _self.max - 0;
        //停止
        _self.swipestart = false;
        //解锁
        _self.isOk = true;
    }
    if (_self.index < 0) {
        _self.index = _self.min;
        //未解锁
        _self.isOk = false;
    }
    if (_self.index == _self.max && _self.max > 0 && _self.isOk) {
        _self.success();
    }
    _self.backgroundTranslate();
    _self.updateView();
}

// 重置slide的起点
SliderUnlock.prototype.reset = function () {
    var _self = this;

    _self.index = 0;
	_self.elm.find(".slideunlock-label").removeAttr('disabled');
    _self.elm.find(".slideunlock-label").animate({left: _self.index}, _self.opts.duration)
        .next(".slideunlock-lable-tip").animate({opacity: 1}, _self.opts.duration);
    _self.updateView();
};

// 颜色渐变
SliderUnlock.prototype.backgroundTranslate = function () {
    var _self = this;
    _self.elm.find(".slideunlock-label").css("left", _self.index + "px")
        .next('.slideunlock-lable-tip').css("opacity", 1-(parseInt($(".slideunlock-label").css("left"))/_self.max));
}

// 更新视图
SliderUnlock.prototype.updateView = function () {
   var _self = this;
    if (_self.index == (_self.max - 0)) {
		var random = _self.elm.find("#random").val();
        $("#unlock").val(random);
		_self.elm.find(".slideunlock-label").attr('disabled','disabled');
        var style = {
            "filter": "alpha(opacity=1)",
            "-moz-opacity": "1",
            "opacity": "1"
        };
        _self.elm.addClass("success").find(".slideunlock-lable-tip").html(_self.opts.successLabelTip).css(style);
    } else {
        $("#unlock").val(0);
        _self.elm.removeClass("success").find(".slideunlock-lable-tip").html(_self.opts.labelTip);
    }
    _self.always();
}

// TODO