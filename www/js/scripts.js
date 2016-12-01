//---------------------------------------------------------------------------------//
function ParametrosURL() {
	var query = location.search.slice(1);
	var partes = query.split('&');
	var URL = {};
	partes.forEach(function (parte) {
	    var chaveValor = parte.split('=');
	    var chave = chaveValor[0];
	    var valor = chaveValor[1];
	    URL[chave] = valor;
	});

	return URL;
}
//---------------------------------------------------------------------------------//
function ParametrosString(str) {
	var string = str;
	var query = string.slice(17);
	var partes = query.split('&');
	var URL = {};
	partes.forEach(function (parte) {
	    var chaveValor = parte.split('=');
	    var chave = chaveValor[0];
	    var valor = chaveValor[1];
	    URL[chave] = valor;
	});

	return URL;
}
//---------------------------------------------------------------------------------//
function DiminuirTexto(str){
	var string = str;

	if(string.length >= 20) {
		string = string.substring(0,20)+'...';
	}

	return string; 	
}
//---------------------------------------------------------------------------------//
function DataMySQL(data) {
	var dataMySQL = data.split('-');
	return new Date(dataMySQL[0], (dataMySQL[1]-1), dataMySQL[2]);
}
//---------------------------------------------------------------------------------//
function DataHoje() {
	var d = new Date();
	return new Date(d.getFullYear(), d.getMonth(), d.getDate());
}
//---------------------------------------------------------------------------------//
function DiaSemanaPHP() {
	var data = new Date();
	var dia = data.getDay();

	if(dia == 0) {
		return 7;
	} else {
		return dia;
	}
}
//---------------------------------------------------------------------------------//
function AdicionaZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
//---------------------------------------------------------------------------------//
function HoraAtual() {
	var d = new Date();

	var h = AdicionaZero(d.getHours());
	var m = AdicionaZero(d.getMinutes());
	var s = AdicionaZero(d.getSeconds());

	var horario = h+":"+m+":"+s;

	return horario;
}
//---------------------------------------------------------------------------------//
function AlertaTopo() {
	var wWidth = $(window).width();
    var dWidth = wWidth * 0.9;

	$('.alert-top').css({
		'margin-left' : -dWidth / 2,
		'margin-top'  : -$('.alert-top').outerHeight()/2,
		'width'		  : dWidth
	});
}
//---------------------------------------------------------------------------------//
function AlertaCentro() {
	var wWidth = $(window).width();
    var dWidth = wWidth * 0.9;

	$('.alert-centered').css({
		'margin-left' : -dWidth / 2,
		'margin-top'  : -$('.alert-centered').outerHeight()/2,
		'width'		  : dWidth
	});
}
//---------------------------------------------------------------------------------//