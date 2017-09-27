
var X1 = X2 = 0;
function photo_show(obj) {
	if(obj != cur) {
		Dd('photo').src = Dd('image_'+(obj-1)).innerHTML;
		Dd('photo_page').innerHTML = obj;
		Dd('photo_intro').innerHTML = Dd('intro_'+(obj-1)).innerHTML;
		cur = obj;
	}
}
function photo_next() {
	if(cur >= max) {
		photo_show(1);
	} else {
		photo_show(cur + 1);
	}
}
function photo_prev() {
	if(cur <= 1) {
		photo_show(max);
	} else {
		photo_show(cur - 1);
	}
}
Dd('album').ontouchstart = function(event) {
	event.preventDefault();
	var touch = event.targetTouches[0];
	X1 = touch.pageX;
}
Dd('album').ontouchmove = function(event) {
	if(event.targetTouches.length == 1) {
		event.preventDefault();
		var touch = event.targetTouches[0];
		X2 = touch.pageX;
	}
}
Dd('album').ontouchend = function(event) {
	if(X1 < X2) {
		photo_prev();
	} else {
		photo_next();
	}
	X1 = X2 = 0;
}