function FBLogin() {
	var fbLoginSuccess = function (userData) {
	    alert("UserInfo: " + JSON.stringify(userData));
	}

	facebookConnectPlugin.login(
		["public_profile"],
        fbLoginSuccess,
        function (error) { alert("" + error) }
    );
}
//---------------------------------------------------------------------------------//
function Login() {
	var emailCliente = $("#email").val();
	var senhaCliente = $("#senha").val();

	if(($.trim(email).length > 0) & ($.trim(senha).length > 0)) {
		$.ajax({
			url: 'https://www.supersoft.com.br/site/laek/ws.php',
			type: 'GET',
			dataType: 'json',
			data: {id: 'loginCliente', email: emailCliente, senha: senhaCliente},
			beforeSend: function() {
				$("#erro-login").fadeOut('slow/500/fast');
				$("#btn-login").attr("disabled", "disabled");
			},
			success: function(data) {
				window.localStorage.setItem("login", "1");
				window.localStorage.setItem("email", emailCliente);
				window.location.replace("index.html");
			},
			error: function() {
				$("#erro-login").fadeIn('slow/500/fast');
				$("#btn-login").removeAttr("disabled", "disabled");
			}
		});
	}	

	return false;
}
//---------------------------------------------------------------------------------//