$(document).ready(function() {
	var URL = ParametrosURL();

	$.ajax({
		url: 'https://www.supersoft.com.br/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'promocoesRestaurante', cpfcnpj: URL['r']},
		beforeSend: function() {
			$(".loader").fadeToggle();

			$(".app-body").fadeTo('fast', 0, 'linear', function() {
				$(".app-body").fadeToggle();
				$(".app-body").fadeTo('fast', 1, 'linear');
			});

			$('#promocoes-restaurante').html('');
		},
		success: function(data) {
			if(data.length == 0) {
    			$("#promocoes-restaurante").html('Nenhum registro foi encontrado.');
    		} else {
    			for (var i=0; data.length>i; i++) {
					$('#promocoes-restaurante').append('<div class="produto-cardapio-restaurante" id="produto-'+data[i].id+'">'+
															'<div class="img-cardapio-restaurante"><img src="images/image-loader.gif" data-src="https://www.supersoft.com.br/site/laek/images/cardapios/produtos/'+data[i].id+'.png" class="img-responsive"></div>'+
															'<div class="info-cardapio-restaurante">'+
																'<div class="item-cardapio-restaurante">'+data[i].produto+'</div>'+
																'<div class="desc-cardapio-restaurante">'+data[i].descricao+'</div>'+
															'</div>'+
															'<div class="box-pedido-cardapio-restaurante">'+
																'<div class="espaco-complementar-restaurante"></div>'+
																'<div class="preco-pedido-cardapio-restaurante">'+
																	'<div class="preco-cardapio-restaurante">de R$ '+$.number(data[i].valor, 2, ',', '.')+'<br>por R$ '+$.number(data[i].valor_promocao, 2, ',', '.')+'</div>'+
																	'<div class="btn-pedido-restaurante btn-pedido-promocao-restaurante" onclick="PedirAgora(\''+window.localStorage.getItem("email")+'\', \''+URL['m']+'\', \''+data[i].id+'\', \''+data[i].produto+'\', \''+data[i].descricao+'\')">PEDIR AGORA</div>'+
																'</div>'+
															'</div>'+
													    '</div>');
				} 			
    		}
		},
		error: function() {
			$("#promocoes-restaurante").html('Erro interno ao carregar as promoções.');
		},
		complete: function() {
			$(".loader").fadeOut();
			$(".app-body").fadeToggle();
			$(window).scrollTop(0);
			$(".img-cardapio-restaurante img").unveil();
		}
	});
});
//---------------------------------------------------------------------------------//