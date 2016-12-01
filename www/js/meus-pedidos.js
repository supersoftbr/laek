$(document).ready(function() {
	var URL = ParametrosURL();

	$.ajax({
		url: 'https://www.supersoft.com.br/site/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'listarPedidos', cpfcnpj: URL['r'], mesa: URL['m'], email: window.localStorage.getItem("email")},
		beforeSend: function() {
			$(".loader").fadeToggle();

			$(".app-body").fadeTo('fast', 0, 'linear', function() {
				$(".app-body").fadeToggle();
				$(".app-body").fadeTo('fast', 1, 'linear');
			});

			$('#meus-pedidos-restaurante').html('');
		},
		success: function(data) {
			if(data.length == 0) {
    			$("#meus-pedidos-restaurante").html('Você ainda não fez nenhum pedido.');
    		} else {
    			var total = 0;
    			for (var i=0; data.length>i; i++) {
					$('#meus-pedidos-restaurante').append('<div class="box-meu-pedido" id="pedido-'+data[i].id+'">'+
																'<div class="info-meu-pedido">'+
																	'<div class="qtde-meu-pedido">'+data[i].quantidade+'x</div>'+
																	'<div class="produto-meu-pedido">'+data[i].produto+'</div>'+
																	'<div class="valor-meu-pedido">R$ '+$.number((data[i].quantidade * data[i].valor), 2, ',', '.')+'</div>'+
																'</div>'+
																(data[i].status == "Pendente" ?
																'<div class="btns-meu-pedido">'+
																	'<div class="btn-cancelar-meu-pedido" onclick="CancelarPedido(\''+data[i].id+'\')">'+
																		'<img src="images/forbidden-mark.png" height="10">'+
																		'<span>CANCELAR</span>'+
																	'</div>'+
																	'<div class="btn-pendente-meu-pedido">'+
																		'<img src="images/pendente.png" height="13">'+
																		'<span>PENDENTE</span>'+
																	'</div>'+
																'</div>'
																:
																''
																)+
														  '</div>');

					total = total + (data[i].quantidade * data[i].valor);
				}

				$('#meus-pedidos-restaurante').append('<div class="box-total-meu-pedido">'+
															'<div class="txt-total-meu-pedido">SUBTOTAL</div>'+
															'<div class="total-meu-pedido">R$ '+$.number(total, 2, ',', '.')+'</div>'+
													  '</div>');
    		}
		},
		error: function() {
			$("#meus-pedidos-restaurante").html('Erro interno ao carregar os pedidos.');
		},
		complete: function() {
			$(".loader").fadeOut();
			$(".app-body").fadeToggle();
			$(window).scrollTop(0);
		}
	});
});
//---------------------------------------------------------------------------------//
function FormularioCancelarPedido() {
	$('#formulario-cancelar-pedido').remove();
	$('#cancelar-pedido-background').remove();

	$('body').append('<div id="formulario-cancelar-pedido">'+
						'<span class="ui-helper-hidden-accessible"><button></button></span>'+
						'<div id="txt-cancelar-pedido">Seu pedido será cancelado.<br>Deseja continuar?</div>'+
					 '</div>'+
					 '<div id="cancelar-pedido-background"></div>');
}
//---------------------------------------------------------------------------------//
function CancelarPedido(id) {
	var id = id;

	var wWidth = $(window).width();
    var dWidth = wWidth * 0.85;

    FormularioCancelarPedido();

	$('#formulario-cancelar-pedido').dialog({
		buttons: [
			{
				text: "Sim, cancelar",
				class: "btn-confirmar-cancelar-pedido",
				click: function() {
					$.ajax({
						url: 'https://www.supersoft.com.br/site/laek/ws.php',
						type: 'GET',
						dataType: 'json',
						data: {id: 'cancelarPedido', pedido: id},
						beforeSend: function() {
							$(".loader").fadeToggle();

							$(".app-body").fadeTo('fast', 0, 'linear', function() {
								$(".app-body").fadeToggle();
								$(".app-body").fadeTo('fast', 1, 'linear');
							});
						},
						success: function(data) {
							location.reload();
						},
						complete: function() {
							$(".loader").fadeOut();
							$(".app-body").fadeToggle();
							$(window).scrollTop(0);

							$('#formulario-cancelar-pedido').dialog("close");
							$('#cancelar-pedido-background').fadeOut('slow');
							$('#cancelar-pedido-background').remove();
						}
					});
				}
			},
			{
				text: "Fechar",
				class: "btn-fechar-cancelar-pedido",
				click: function() {
					$(this).dialog("close");
					$('#cancelar-pedido-background').fadeOut('slow');
					$('#cancelar-pedido-background').remove();
				}
			}
		],
		dialogClass: "dialog-cancelar-pedido",
		draggable: false,		
		modal: true,
		position: {
			my: "center",
			at: "center",
			of: window
		},
		resizable: false,
		show: {effect: "fade", duration: 1000},
		hide: {effect: "fade", duration: 1000},
		height: "auto",
		width: dWidth
	});
}
//---------------------------------------------------------------------------------//