$(document).ready(function() {
	var URL = ParametrosURL();

	//window.sessionStorage.setItem("scan", "1");
	//window.sessionStorage.setItem("r", URL['r']);
	//window.sessionStorage.setItem("m", URL['m']);

	if((window.localStorage.getItem("logoRestaurante") === null) || (window.localStorage.getItem("nomeRestaurante") === null)) {
		$.ajax({
			url: 'https://www.supersoft.com.br/laek/ws.php',
			type: 'GET',
			dataType: 'json',
			data: {id: 'exibeRestaurante', cpfcnpj: URL['r']},
			success: function(data) {
				if(data.length == 0) {
	    			$("#info-restaurante").html('Nenhum registro foi encontrado.');
	    		} else {
	    			for (var i=0; data.length>i; i++) {
						$('#info-restaurante').append('<img id="logo-restaurante" class="img-responsive" src="images/image-loader.gif" data-src="https://www.supersoft.com.br/laek/images/restaurantes/logos/'+data[i].logo+'">'+
													  '<div id="saudacao-restaurante">'+
													  		'<div id="txt-saudacao-restaurante">Seja bem vindo(a) ao</div>'+
													  		'<div id="nome-restaurante">'+data[i].fantasia+'</div>'+
													  '</div>');

						window.localStorage.setItem("logoRestaurante", data[i].logo);
						window.localStorage.setItem("nomeRestaurante", data[i].fantasia);
					}
	    		}
			},
			error: function() {
				$("#info-restaurante").html('Erro interno ao carregar o restaurante.');
			},
			complete: function() {
				$("img#logo-restaurante").unveil();
			}
		});
	} else {
		$('#info-restaurante').append('<img id="logo-restaurante" class="img-responsive" src="https://www.supersoft.com.br/laek/images/restaurantes/logos/'+window.localStorage.getItem("logoRestaurante")+'">'+
									  '<div id="saudacao-restaurante">'+
									  		'<div id="txt-saudacao-restaurante">Seja bem vindo(a) ao</div>'+
									  		'<div id="nome-restaurante">'+window.localStorage.getItem("nomeRestaurante")+'</div>'+
									  '</div>');
	}
});
//---------------------------------------------------------------------------------//