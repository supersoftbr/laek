if(window.sessionStorage.getItem("scan") == "1") {
	var r = window.sessionStorage.getItem("r");
	var m = window.sessionStorage.getItem("m");
	window.location.href = "restaurante.html?r="+r+"&m="+m;
}