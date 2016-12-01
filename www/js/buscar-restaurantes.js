$(document).ready(function() {
	var horaAtual = HoraAtual();	

	$.ajax({
		url: 'https://www.supersoft.com.br/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'buscaRestaurantes'},
		beforeSend: function() {
			ExibirVoltarMenu();
		},
		success: function(data) {
			if(data.length == 0) {
    			$("#restaurantes").html('Nenhum registro foi encontrado.');
    		} else {
    			for (var i=0; data.length>i; i++) {
					$('#restaurantes').append('<div class="box-restaurante">'+
												'<div class="img-restaurante"><img src="https://www.supersoft.com.br/site/laek/images/restaurantes/logos/'+data[i].logo+'" class="img-responsive"></div>'+
												'<div class="info-restaurante">'+
													'<div class="nome-restaurante">'+data[i].fantasia+'</div>'+
													'<div class="horario-restaurante">'+
													((horaAtual > data[i].horarioI) && (horaAtual < data[i].horarioF) ?
														'<span class="aberto-restaurante"></span><span class="txt-aberto-restaurante">Aberto</span>'
													:
														'<span class="fechado-restaurante"></span><span class="txt-aberto-restaurante">Fechado</span>'
													)+
													'</div>'+										
													'<div class="endereco-restaurante"><span class="glyphicon glyphicon-map-marker"></span>'+data[i].endereco+'</div>'+
													'<div class="telefone-restaurante"><span class="glyphicon glyphicon-phone-alt"></span>'+data[i].telefone+'</div>'+
												'</div>'+
											   '</div>');
				}    			
    		}
		},
		error: function() {
			$("#restaurantes").html('Erro interno ao carregar o restaurante.');
		}
	});
});
//---------------------------------------------------------------------------------//
function ExibirVoltarMenu() {
	$("#voltar-menu").remove();
	$("#header").prepend('<div id="voltar-menu" onclick="history.go(-1);"><img src="images/back-arrow.png" height="20"></div>');
}
//---------------------------------------------------------------------------------//