<?php
require_once "core.php";
$act = $_GET['act'];

switch ($act) {
	case "logout":
		LogOut();
		break;
	case "download":
		Download();
		break;
	case "downloadop":
		DownloadOP();
		break;
	case "teste_sistema":
		TesteSistema();
		break;
	case "emissorNE":
		EmissorNE();
		break;
}
/* ------------------------------------------------------------------------------------- */
function LogOut() {	
	unset($_SESSION['usuario']); // Efetua o logout.
	GotoPage("home"); // Redireciona para a página inicial.
}
/* ------------------------------------------------------------------------------------- */
function Download() {	
	$numarq = $_GET['n'];
	$arquivo = $_SESSION['arquivo_download'][$numarq];	
	BaixarArquivo($arquivo, $_SESSION['usuario']['NUMERO']);
}
/* ------------------------------------------------------------------------------------- */
function DownloadOP() {
	$arq = CAMINHO_INSTALACOES."sscentralop/SSCentralOP".$_GET['versao'].".exe";	
	BaixarArquivo($arq, "");
}
/* ------------------------------------------------------------------------------------- */
function TesteSistema() {
	$cliente = $_GET['c'];
	$arq = CAMINHO_TESTE_SISTEMA."TestadorSS.exe";	
	$cliente = strtolower($cliente);
	BaixarArquivo($arq, $cliente);
}
/* ------------------------------------------------------------------------------------- */
function EmissorNE() {
	$arq = CAMINHO_EMISSOR."SSNFE.exe";
	BaixarArquivo($arq, "");
}
/* ------------------------------------------------------------------------------------- */
?>