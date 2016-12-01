<?php
require_once "coregeral.php";

class Logs {
	static function MySQL($log) {
		$log = "[".date("d/m/Y H:i:s")."] ".$log."\n";
		file_put_contents(LOG_MYSQL, $log, FILE_APPEND);
	}

	static function Site($tipo, $modulo, $funcao, $mensagem) {
		$log = "[".date("d/m/Y H:i:s")."] ".$tipo."|".$modulo."|".$funcao."|".$mensagem."\n";
		file_put_contents(LOG_SITE, $log, FILE_APPEND);
	}
	
	static function Atividade($tipo, $conteudo) {
		require_once "funcs.php";
		$query = "INSERT INTO log_atividades (tipo, conteudo, datahora, ip) VALUES ('".$tipo."', '".addslashes($conteudo)."', NOW(), '".IPCliente()."')";
		SingleQuery($query);
	}
}
?>