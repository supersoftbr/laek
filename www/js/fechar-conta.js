$(document).ready(function() {
	var URL = ParametrosURL();

	$.ajax({
		url: 'https://www.supersoft.com.br/site/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'meusPedidos', cpfcnpj: URL['r'], mesa: URL['m'], email: window.localStorage.getItem("email")},
		beforeSend: function() {
			$(".loader").fadeToggle();

			$(".app-body").fadeTo('fast', 0, 'linear', function() {
				$(".app-body").fadeToggle();
				$(".app-body").fadeTo('fast', 1, 'linear');
			});

			$('#fechar-conta-restaurante').html('');
		},
		success: function(data) {
			if(data.length == 0) {
    			$("#fechar-conta-restaurante").html('Você ainda não fez nenhum pedido.');
    		} else {
    			var total = 0;
    			for (var i=0; data.length>i; i++) {
    				if(i === 0) {
    					$('#fechar-conta-restaurante').append('<input type="hidden" id="id_conta" value="'+data[i].id_conta+'">');
    				}

					$('#fechar-conta-restaurante').append('<div class="box-meu-pedido" id="pedido-'+data[i].id+'">'+
																'<div class="info-meu-pedido">'+
																	'<div class="qtde-meu-pedido">'+data[i].quantidade+'x</div>'+
																	'<div class="produto-meu-pedido">'+data[i].produto+'</div>'+
																	'<div class="valor-meu-pedido">R$ '+$.number((data[i].quantidade * data[i].valor), 2, ',', '.')+'</div>'+
																'</div>'+
														  '</div>');

					total = total + (data[i].quantidade * data[i].valor);
				}

				$('#fechar-conta-restaurante').append('<div class="box-total-meu-pedido">'+
															'<div class="txt-total-meu-pedido">TOTAL</div>'+
															'<div class="total-meu-pedido">R$ '+$.number(total, 2, ',', '.')+'</div>'+
													  '</div>');

				$('#fechar-conta-restaurante').append('<div id="btn-fechar-conta" onclick="EncerrarConta()">FECHAR CONTA AGORA</div>');
    		}
		},
		error: function() {
			$("#fechar-conta-restaurante").html('Erro interno ao carregar os pedidos.');
		},
		complete: function() {
			$(".loader").fadeOut();
			$(".app-body").fadeToggle();
			$(window).scrollTop(0);
		}
	});
});
//---------------------------------------------------------------------------------//
function FormularioFecharConta() {
	$('#formulario-fechar-conta').remove();
	$('#fechar-conta-background').remove();

	$('body').append('<div id="formulario-fechar-conta">'+
						'<span class="ui-helper-hidden-accessible"><button></button></span>'+
						'<div id="txt-fechar-conta">Deseja encerrar a conta da mesa ou apenas seus pedidos individuais?</div>'+
					 '</div>'+
					 '<div id="fechar-conta-background"></div>');
}
//---------------------------------------------------------------------------------//
function EncerrarConta() {
	var URL = ParametrosURL();
	var idConta = $('#id_conta').val();

	var wWidth = $(window).width();
    var dWidth = wWidth * 0.95;

    FormularioFecharConta();

    $('#formulario-fechar-conta').dialog({
		buttons: [
			{
				text: "CANCELAR",
				class: "btn-fechar-conta btn-cancelar-fechar-conta",
				click: function() {
					$(this).dialog("close");
					$('#fechar-conta-background').fadeOut('slow');
					$('#fechar-conta-background').remove();
				}
			},
			{
				text: "MESA",
				class: "btn-fechar-conta btn-mesa-fechar-conta",
				click: function() {
					$(this).dialog("close");
					$('#fechar-conta-background').fadeOut('slow');
					$('#fechar-conta-background').remove();
				}
			},
			{
				text: "INDIVIDUAL",
				class: "btn-fechar-conta btn-individual-fechar-conta",
				click: function() {
					$(this).dialog("close");
					$('#fechar-conta-background').fadeOut('slow');
					$('#fechar-conta-background').remove();
				}
			}
			
		],
		dialogClass: "dialog-fechar-conta",
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

	/*$.ajax({
		url: 'https://www.supersoft.com.br/site/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'fecharConta', conta: idConta, cpfcnpj: URL['r'], mesa: URL['m']},
		beforeSend: function() {
			$(".loader").fadeToggle();

			$(".app-body").fadeTo('fast', 0, 'linear', function() {
				$(".app-body").fadeToggle();
				$(".app-body").fadeTo('fast', 1, 'linear');
			});
		},
		success: function(data) {
			if(data == false) {    			
				$('body').append('<div class="alert alert-danger alert-dismissable alert-centered fade in">'+
									'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
									'<b>Oops!</b> Algo deu errado.'+
								 '</div>');
				AlertaCentro();
    		} else {			    
				$('body').append('<div class="alert alert-success alert-dismissable alert-top fade in">'+
									'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
									'<b>Sucesso!</b> Aguarde por sua conta.'+
								 '</div>');
				AlertaTopo();
    		}
		},
		error: function() {
			
		},
		complete: function() {
			$(".loader").fadeOut();
			$(".app-body").fadeToggle();
			$(window).scrollTop(0);
			setTimeout(function(){$('.alert').fadeOut('slow');}, 2000);
			setTimeout(function(){$('.alert').remove();}, 3000);
		}
	});*/
}
//---------------------------------------------------------------------------------//