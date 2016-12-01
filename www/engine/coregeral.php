<?php
define("HOME", $_SERVER['DOCUMENT_ROOT']."/");

require_once "configs.php";
require_once "encoding.php";
require_once "mysqlsite.class.php";
require_once "mysqlinterno.class.php";
require_once "email.class.php";

session_start();

function ToISO8859($texto) {
	return Encoding::toISO8859($texto);
}

function ToUTF8($texto) {
	return Encoding::toUTF8($texto);
}

function FixUTF8($texto) {
	return Encoding::fixUTF8($texto);
}

function ArrayToUTF8(&$array) {
	foreach ($array as $key=>$value)
		$array[Encoding::toUTF8($key)] = Encoding::toUTF8($value); // Converte a chave e o valor.
}

function ArrayToISO8859(&$array) {
	foreach ($array as $key=>$value)
		$array[Encoding::toISO8859($key)] = Encoding::toISO8859($value); // Converte a chave e o valor.
}

function DisparaEmailModelo($tipomodelo, $destinatario, $campos) {
	global $MODELOS;
		
	if (MODO_DESENVOLVIMENTO)
		$destinatario = EMAIL_TESTE;

	if (array_key_exists($tipomodelo, $MODELOS)) {
		if (($tipomodelo == 'ORCAMENTO') || ($tipomodelo == 'TESTAR_SISTEMA'))
			$assunto = str_replace("[#INTERESSADO]", $campos['INTERESSADO'], $MODELOS[$tipomodelo]['ASSUNTO']);
		else if ($tipomodelo == 'BOASVINDAS')
			$assunto = str_replace("[#INTERESSADO]", $campos['INTERESSADO'], $MODELOS[$tipomodelo]['ASSUNTO']);
		else if ($tipomodelo == 'FALECONOSCO')
			$assunto = str_replace("[#NOME]", $campos['NOME'], $MODELOS[$tipomodelo]['ASSUNTO']);
		else if ($tipomodelo == 'COPA_BOLAO') {
			$assunto = str_replace("[#JOGO]", $campos['JOGO'], $MODELOS[$tipomodelo]['ASSUNTO']);			
			$assunto = str_replace("[#PLACAR]", $campos['PLACAR'], $assunto);
			$assunto = str_replace("[#NOME]", $campos['NOME'], $assunto);			
		}
		else if (in_array($tipomodelo, array('SOLICITACOES','SUGESTOES','SAC')))
			$assunto = str_replace("[#CLIENTE]", $campos['CLIENTE'], $MODELOS[$tipomodelo]['ASSUNTO']);			
		else 
			$assunto = $MODELOS[$tipomodelo]['ASSUNTO'];
			
		$corpo = file_get_contents(PATH_SITE.$MODELOS[$tipomodelo]['MODELO']);		
		if (is_array($campos)) {		
			foreach ($campos as $chave=>$valor)
				$corpo = str_replace("[#".$chave."]", $valor, $corpo);
		}
		$corpo = str_replace("[#DATAHORA]", date('d/m/Y H:i:s'), $corpo);
		$corpo = ToISO8859($corpo);
				
		return Email::Enviar($MODELOS[$tipomodelo]['NOME_REMETENTE'],
							 $MODELOS[$tipomodelo]['EMAIL_REMETENTE'],
							 $destinatario,
							 $assunto,
							 $corpo);
	}
	else 
		return -1;
}


// ********************
// Acesso ao WebService
// ********************
function ConectaWSSupersoft() { 
	// Cria uma instance com o WebService
	$client = new SoapClient(null, array(
							'location' => ENDERECO_WEB_SERVICE_SS,
							'uri' => URI_WEB_SERVICE_SS,
							'trace' => 0));
	return $client;
}

function DesconectaWSSupersoft($client) {
	unset($client);	
}
//--------------
function ConectaWSCentralOP() { 
	// Cria uma instance com o WebService
	$client = new SoapClient(null, array(
							'location' => ENDERECO_WEB_SERVICE_COP,
							'uri' => URI_WEB_SERVICE_COP,
							'trace' => 0));
	return $client;
}

function DesconectaWSCentralOP($client) {
	unset($client);	
}
//--------------
function ConectaWSSenhas() { 
	// Cria uma instance com o WebService
	$client = new SoapClient(null, array(
							'location' => ENDERECO_WEB_SERVICE_SENHAS,
							'uri' => URI_WEB_SERVICE_SENHAS,
							'trace' => 0));
	return $client;
}

function DesconectaWSSenhas($client) {
	unset($client);	
}
// ********************

function VoltaMensagem($msg, $tipo) {
	SetaMensagem($msg, $tipo);
	VoltarPaginaAnterior();
}

function SetaMensagem($msg, $tipo) {
	// $tipo pode ser:
	// informacao, sucesso, aviso, erro ou validacao.

	// session_start();	
	if (!isset($_SESSION['mensagens']))	
		$_SESSION['mensagens'] = array();	
	$_SESSION['mensagens'][$msg] = $tipo;
}

function Mensagens() {
	//session_start();	
	$msgs = array();
	if (isset($_SESSION['mensagens']))
		$msgs = $_SESSION['mensagens'];	
	LimpaMensagens();
	return $msgs;		
}

function ExisteMensagem($msg) {
	//session_start();
	$msgs = array();
	if (isset($_SESSION['mensagens']))
		$msgs = $_SESSION['mensagens'];
	return array_key_exists($msg, $msgs);
}

function LimpaMensagens() {
	//session_start();
	if (isset($_SESSION['mensagens']))	
		unset($_SESSION['mensagens']);
}

function MostraMensagens($style_css="") {
	$mensagens = "";
	if ($style_css != "")
		$style_css = 'style="'.$style_css.'"';		
	$mens = array();
	$msgs = Mensagens();	
	if (!empty($msgs)) {
		foreach($msgs as $_mensagem=>$_tipo)
			$mens[] = $_mensagem;
		$mensagens = '<div class="'.$_tipo.'" '.$style_css.'>'.implode("<br>\n", $mens).'</div>';
	}
	return $mensagens;
}

function SingleQuery($query) {
	$mysql = new BaseSite();
	$res = $mysql->Query($query);
	unset($mysql);
	return $res;
}

function SalvaConfig($chave, $valor) {
	if ($chave == "")
		return FALSE;

	$valor_serialized = serialize($valor);
	$query = "REPLACE INTO configs (alias, valor) VALUES ('".$chave."', '".$valor_serialized."')";
	return SingleQuery($query);
}

function LeConfig($chave) {
	$query = "SELECT valor FROM configs WHERE alias = '".$chave."'";
	$val = SingleQuery($query);
	
	if (isset($val[0]->valor)) {
		$unserialized = @unserialize($val[0]->valor);
		if (($val[0]->valor === 'b:0;') || ($unserialized !== FALSE)) {
			return $unserialized;
		}
		else
			return $val[0]->valor;	
	}
	else
		return NULL;
}

function BaixarArquivo($arquivo, $cliente="") {
	// Baixa um arquivo via streaming.
	// Chamar esta função sem escrever na saída antes e nem depois.
	$path_parts = pathinfo($arquivo);
	$ext = $path_parts['extension'];
	$nome_arquivo = $path_parts['basename'];

	// No IE é necessário enviar os pontos do nome do arquivo como "%2e". Com exceção do ponto da extensão do arquivo.
	if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) {		
		$nome_arquivo = str_replace(".".$ext, "", $nome_arquivo);
		$nome_arquivo = str_replace(".", "%2e", $nome_arquivo);
		$nome_arquivo .= ".".$ext;	
	}
	
	// Grava log de download.
	$query  = "INSERT INTO log_downloads (ip, cliente, arquivo, datahora) ";
	$query .= "VALUES ('".IPCliente()."', '".addslashes($cliente)."', '".addslashes($nome_arquivo)."', NOW())";	
	@SingleQuery($query);	

	header("Content-type: application/octet-stream");
	header("Content-Length:".@filesize($arquivo)); 
	header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"'); 
	header('Expires: 0'); 
	header('Pragma: no-cache'); 

	readfile(Encoding::toUTF8($arquivo));
}

function ResultSetUTF8($resultset) {
	foreach ($resultset as $key_registro => $value_registro) {
		$array = (array)$value_registro;		
		$convertido = new stdClass();
		foreach ($array AS $key => $value) {
			$key_utf8 = Encoding::toUTF8($key);
			$convertido->$key_utf8 = Encoding::toUTF8($value);
		}
		$resultset[$key_registro] = $convertido;	
		unset($convertido);
	}	
	return $resultset;
}

// ***************************
// Redirecionamento de páginas
// ***************************

function GotoPage($page) {
	GotoURL(URL_SITE.$page);
}

function GotoURL($url) {
	header("Location: ".$url);
	exit(0);
}

function VoltarPaginaAnterior() {
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit(0);
}
?>