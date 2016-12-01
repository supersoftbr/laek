<?php

require_once "coregeral.php";

class Transfer {
	static function DownloadArquivoSuperSoft($remoto, $local) {
		// Cria o diret�rio se n�o existir:
		$dir = dirname($local);
		if (!file_exists($dir))
			mkdir($dir, 0777, TRUE);

		// Conecta no servi�o de transfer�ncia de arquivos e baixa.
		$ws = ConectaWSSupersoft();
		$arquivo_baixado_base64 = $ws->DownloadArquivo($remoto);	
		DesconectaWSSupersoft($ws);		
		if ($arquivo_baixado_base64 !== FALSE) {
			$baixado = file_put_contents($local, base64_decode($arquivo_baixado_base64));
			if ($baixado !== FALSE)
				return TRUE;
			else
				return FALSE;
		}
		 else
			return FALSE;
	}
}
?>