<?php
	//require_once "coregeral.php";

	class Email {		 
		 static function Enviar($nome_de, $de, $para, $assunto, $mensagem, $bcc="") {
			// Monta o cabeçalho	
			if ($nome_de != "")
			  $remetente = $nome_de." <".$de.">";
			else
			  $remetente = $de;
			$headers  = "MIME-Version: 1.1\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
			if (trim($bcc) != "")
			  $headers .= "Bcc: ".$bcc."\n";
			$headers .= "From: ".$remetente."\n";
			$headers .= "Return-Path: ".$de."\n";
			$headers .= "Reply-To: ".$de."\n";
			//return mail($para, $assunto, $mensagem, $headers, "-fsupersoft@supersoft.com.br");
			return mail($para, $assunto, $mensagem, $headers);
		}
		/*				
		static function Enviar($nome_de, $de, $para, $assunto, $mensagem, $bcc="") {
			$ws = new SoapClient(null, array(
                'location' => "http://ws.supersoft.com.br/email.php", // Servidor da SS (Kirk).
                'uri' => "http://ws.supersoft.com.br/",
                'trace' => 0));
			$enviou = $ws->Enviar(ToUTF8($nome_de), ToUTF8($de), ToUTF8($para), ToUTF8($assunto), ToUTF8($mensagem));
			unset($client);				
			return $enviou;
		}
		*/		
	}
?>
