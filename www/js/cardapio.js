$(document).ready(function() {
	var URL = ParametrosURL();

	$.ajax({
		url: 'https://www.supersoft.com.br/site/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'categoriasCardapio', cpfcnpj: URL['r']},
		beforeSend: function() {
			$(".loader").fadeIn();

			$(".app-body").fadeTo('fast', 0, 'linear', function() {
				$(".app-body").fadeToggle();
				$(".app-body").fadeTo('fast', 1, 'linear');
			});

			$('#cardapio-restaurante').html('');
		},
		success: function(data) {
			if(data.length == 0) {
    			$("#cardapio-restaurante").html('Nenhum registro foi encontrado.');
    		} else {
    			for (var i=0; data.length>i; i++) {
					$('#cardapio-restaurante').append('<div class="panel-group" id="accordion-cardapio" role="tablist" aria-multiselectable="true">'+
															'<div class="panel panel-default">'+
																'<div class="panel-heading" role="tab" id="headingCardapio'+[i]+'">'+
																	'<h4 class="panel-title collapsed" role="button" data-toggle="collapse" data-parent="#accordion-cardapio" href="#collapseCardapio'+[i]+'" aria-expanded="true" aria-controls="collapseCardapio'+[i]+'" onclick="ProdutosCardapio(\''+URL['r']+'\', \''+data[i].categoria+'\', \'collapseCardapio'+[i]+'\', \'headingCardapio'+[i]+'\')">[ + ] '+data[i].categoria+'</h4>'+
																'</div>'+
																'<div id="collapseCardapio'+[i]+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingCardapio'+[i]+'"></div>'+
															'</div>'+
													  '</div>');
				}    			
    		}
		},
		error: function() {
			$("#cardapio-restaurante").html('Erro interno ao carregar o cardápio.');
		},
		complete: function() {
			$(".loader").fadeOut();
			$(".app-body").fadeToggle();
			$(window).scrollTop(0);
		}
	});
});
//---------------------------------------------------------------------------------//
function ProdutosCardapio(cpfcnpj, produto, origem, categoria) {
	var URL = ParametrosURL();
	var diaSemana = DiaSemanaPHP();
	var dataHoje = DataHoje();
	var cpfcnpj = cpfcnpj;
	var produto = produto;
	var destino = origem;
	var categoria = categoria;

	$.ajax({
		url: 'https://www.supersoft.com.br/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'cardapioRestaurante', cpfcnpj: cpfcnpj, produto: produto},
		beforeSend: function() {
			$(".loader").fadeToggle();
			$('#'+destino).html('');
		},
		success: function(data) {
			if(data.length == 0) {
    			$('#'+destino).html('<div class="panel-body">Nenhum registro foi encontrado.</div>');
    		} else {
    			for (var i=0; data.length>i; i++) {
					$('#'+destino).append('<div class="panel-body" id="produto-'+data[i].id+'">'+
												'<div class="img-cardapio-restaurante"><img src="images/image-loader.gif" data-src="https://www.supersoft.com.br/site/laek/images/cardapios/produtos/'+data[i].id+'.png" class="img-responsive"></div>'+
												'<div class="info-cardapio-restaurante">'+
													'<div class="item-cardapio-restaurante">'+data[i].produto+'</div>'+
													'<div class="desc-cardapio-restaurante">'+data[i].descricao+'</div>'+
												'</div>'+
												'<div class="box-pedido-cardapio-restaurante">'+
													'<div class="espaco-complementar-restaurante"></div>'+
													'<div class="preco-pedido-cardapio-restaurante">'+
														((data[i].prato_dia > 0) && (data[i].prato_dia == diaSemana) ?
															'<div class="preco-cardapio-restaurante">de <span class="preco-promocao">R$ '+$.number(data[i].valor, 2, ',', '.')+'</span><br>por R$ '+$.number(data[i].valor_pratodia, 2, ',', '.')+'</div>'
														:
															(dataHoje <= DataMySQL(data[i].fim_promocao) ?
																'<div class="preco-cardapio-restaurante">de <span class="preco-promocao">R$ '+$.number(data[i].valor, 2, ',', '.')+'</span><br>por R$ '+$.number(data[i].valor_promocao, 2, ',', '.')+'</div>'
															:
																'<div class="preco-cardapio-restaurante">R$ '+$.number(data[i].valor, 2, ',', '.')+'</div>'
															)
														)+										
														'<div class="btn-pedido-restaurante pedir-agora" onclick="PedirAgora(\''+window.localStorage.getItem("email")+'\', \''+URL['m']+'\', \''+data[i].id+'\', \''+data[i].produto+'\', \''+data[i].descricao+'\')">PEDIR AGORA</div>'+
													'</div>'+
												'</div>'+
										  	'</div>');
				} 			
    		}
		},
		error: function() {
			$('#'+destino).html('<div class="panel-body">Erro interno ao carregar o cardápio.</div>');
		},
		complete: function() {
			$('#'+categoria+" > h4.panel-title").attr("onclick", "");
			$('#'+destino).attr("aria-expanded", "true");
			$(".loader").fadeToggle();
			$(".img-cardapio-restaurante img").unveil();
		}
	});
}
//---------------------------------------------------------------------------------//