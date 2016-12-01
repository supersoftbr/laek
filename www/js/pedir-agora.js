function FormularioPedirAgora() {
	$('#pedir-agora-formulario').remove();
	$('#pedir-agora-background').remove();

	$('body').append('<div id="pedir-agora-formulario">'+
						'<div id="cancelar-pedir-agora" class="navbar-fixed-top">'+
							'<img id="btn-cancelar-pedir-agora" src="images/back-arrow.png" height="20" onclick="CancelarPedirAgora()">'+
							'<img id="logo-cancelar-pedido" src="images/logo/logo_branco.png" height="70">'+
						'</div>'+
						'<input type="hidden" id="id_produto" value="">'+
						'<input type="hidden" id="qtde_produto" value="1">'+
						'<div id="img-produto-pedir-agora"><img src="images/image-loader.gif" data-src="" class="img-responsive"></div>'+
						'<span class="ui-helper-hidden-accessible"><button></button></span>'+
						'<div id="info-produto-pedir-agora">'+
							'<div id="produto-pedir-agora"></div>'+
							'<div id="descricao-pedir-agora"></div>'+
						'</div>'+
						'<div id="qtde-pedir-agora">'+
							'<div id="txt-qtde-pedir-agora">Escolha a quantidade</div>'+
							'<div id="btn-qtde-pedir-agora">'+
								'<div id="btn-menos-qtde" onclick="SubtraiPedido()"><span class="glyphicon glyphicon-minus"></span></div>'+
								'<div id="total-qtde">1</div>'+
								'<div id="btn-mais-qtde" onclick="SomaPedido()"><span class="glyphicon glyphicon-plus"></span></div>'+
							'</div>'+
						'</div>'+
					 '</div>'+
					 '<div id="pedir-agora-background"></div>');
}
//---------------------------------------------------------------------------------//
function PedirAgora(email, mesa, id, produto, descricao) {	
	var email = email;
	var mesa = mesa;
	var id = id;
	var produto = produto;
	var descricao = descricao;

	var wWidth = $(window).width();
    var dWidth = wWidth * 1;

    FormularioPedirAgora();

	// Limpa possíveis rastros de pedidos anteriores
	$("#id_produto").val("");
	$("#qtde_produto").val("");
	$("#btn-cancelar-pedir-agora").removeAttr("onclick");
	$("#img-produto-pedir-agora img").removeAttr("data-src");
	$("#produto-pedir-agora").html("");
	$("#descricao-pedir-agora").html("");
	$("#total-qtde").html("");

	// Preenche com as informações do produto escolhido
	$("#id_produto").val(id);
	$("#qtde_produto").val("1");
	$("#btn-cancelar-pedir-agora").attr("onclick", "CancelarPedirAgora('"+id+"')");
	$("#img-produto-pedir-agora img").attr("data-src", "https://www.supersoft.com.br/site/laek/images/cardapios/produtos/"+id+".png");
	$("#produto-pedir-agora").html(produto);
	$("#descricao-pedir-agora").html(descricao);
	$("#total-qtde").html("1");

	$(".app-body").css({display: 'none'});

	$("#pedir-agora-background").fadeIn("slow");
	$('#pedir-agora-formulario').dialog({
		buttons: [{
			text: "FAZER MEU PEDIDO AGORA",
			class: "btn-pedir-agora",
			click: function() {
				$('.btn-pedir-agora').attr("disabled", "disabled");
				FazerPedido(email, mesa, id);
			}
		}],    
		dialogClass: "dialog-pedir-agora",
		draggable: false,		
		modal: true,
		position: {
			my: "center",
			at: "top",
			of: window
		},
		resizable: false,
		show: {effect: "fade", duration: 1000},
		hide: {effect: "fade", duration: 1000},
		height: "auto",
		width: dWidth
	});

	$("#img-produto-pedir-agora img").unveil();
}
//---------------------------------------------------------------------------------//
function CancelarPedirAgora(produto) {
	$(".app-body").css({display: 'block'});
	$('html, body').animate({scrollTop: $('#produto-'+produto).offset().top - 70});
	$("#pedir-agora-background").fadeOut("slow");
    $('#pedir-agora-formulario').dialog("close");
}
//---------------------------------------------------------------------------------//
function FazerPedido(email, mesa, produto) {
	var URL = ParametrosURL();
	var email = email;
	var mesa = mesa;
	var produto = produto;
	var qtde = $('#qtde_produto').val();

	$.ajax({
		url: 'https://www.supersoft.com.br/laek/ws.php',
		type: 'GET',
		dataType: 'json',
		data: {id: 'fazerPedido', cpfcnpj: URL['r'], email: email, mesa: mesa, produto: produto, qtde: qtde},
		beforeSend: function() {
			$(".loader").fadeToggle();
		},
		success: function(data) {
			if(data == false) {
    			$('.btn-pedir-agora').removeAttr("disabled", "disabled");
    			
				$('body').append('<div class="alert alert-danger alert-dismissable alert-centered fade in">'+
									'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
									'<b>Oops!</b> Algo deu errado.'+
								 '</div>');
				AlertaCentro();
    		} else {
    			$('.btn-pedir-agora').removeAttr("disabled", "disabled");
				$(".app-body").css({display: 'block'});
				$('html, body').animate({scrollTop: $('#produto-'+produto).offset().top - 70});
				$("#pedir-agora-background").fadeOut("slow");
			    $('#pedir-agora-formulario').dialog("close");
			    
				$('body').append('<div class="alert alert-success alert-dismissable alert-top fade in">'+
									'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
									'<b>Sucesso!</b> Seu pedido foi recebido.'+
								 '</div>');
				AlertaTopo();
    		}
		},
		error: function() {
			$('.btn-pedir-agora').removeAttr("disabled", "disabled");

			$('body').append('<div class="alert alert-danger alert-dismissable alert-centered fade in">'+
								'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
								'<b>Oops!</b> Tente novamente.'+
							 '</div>');
			AlertaCentro();
		},
		complete: function() {
			$(".loader").fadeToggle();
			setTimeout(function(){$('.alert').fadeOut('slow');}, 2000);
			setTimeout(function(){$('.alert').remove();}, 3000);
		}
	});
}
//---------------------------------------------------------------------------------//
function SubtraiPedido() {
	var qtde = parseInt($('#total-qtde').html());

	if(qtde > 1) {
		qtde = qtde - 1;
	}

	$('#qtde_produto').val(qtde);
	$('#total-qtde').html(qtde);
}
//---------------------------------------------------------------------------------//
function SomaPedido() {
	var qtde = parseInt($('#total-qtde').html());

	qtde = qtde + 1;

	$('#qtde_produto').val(qtde);
	$('#total-qtde').html(qtde);
}
//---------------------------------------------------------------------------------//