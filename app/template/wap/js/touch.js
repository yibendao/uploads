
function Dd(i) {return document.getElementById(i);}
function Ds(i) {Dd(i).style.display = '';}
function Dh(i) {Dd(i).style.display = 'none';}
function Dback(url) {
	if(document.referrer) {
		window.history.back();

	} else {
		window.location.href = url ? url : 'index.php';
	}
}