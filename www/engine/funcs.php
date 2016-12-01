<?php

// ************************************
// BIBLIOTECA DE FUNÇÕES
// Criado por Daniel Franco Candioti
// Abril de 2007
// ************************************

//---------------------------------------------------------------------
function MySQL_Date($data_brasil)
{
// Recebe uma data no formato d/m/a (formato barsileiro) e converte para uma data a-m-d (MySql)	
	
$data = explode("/", $data_brasil);	

return $data[2]."-".$data[1]."-".$data[0];	
}
//---------------------------------------------------------------------
function DataMySQL_Brasil($data_mysql, $casas_ano=4)
{
// Recebe uma data e hora No formato MySQl (aaaa-mm-dd hh:mm:ss) e transforma em SOMENTE DATA brasileira (dd/mm/aaaa)

$timestamp = explode(" ", $data_mysql);
$data = $timestamp[0];
if (isset($timestamp[1]))
	$hora = $timestamp[1];
else
	$hora = "";

$data_separada = explode("-", $data);
$hora_separada = explode(":", $hora);

if ($casas_ano == 2)
	return $data_separada[2]."/".$data_separada[1]."/".substr($data_separada[0], -2, 2);
else
	return $data_separada[2]."/".$data_separada[1]."/".$data_separada[0];	
}
//---------------------------------------------------------------------
function DataHojeCompleta($horario=FALSE)
{
	$dias_semana_completo = Array("Domingo",
								  "Segunda-feira",
								  "Terça-feira",
								  "Quarta-feira",
								  "Quinta-feira",
								  "Sexta-feira",
								  "Sábado");
							  
	$meses = Array("janeiro",
				   "fevereiro",
				   "março",
				   "abril",
				   "maio",
				   "junho",
				   "julho",
				   "agosto",
				   "setembro",
				   "outubro",
				   "novembro",
				   "dezembro");

	if ($horario)
  	  return $dias_semana_completo[date("w")].", ".date("d")." de ".$meses[date("n")-1]." de ".date("Y")." às ".date("H").":".date("i").":".date("s");
	else
	  return $dias_semana_completo[date("w")].", ".date("d")." de ".$meses[date("n")-1]." de ".date("Y");
}
//---------------------------------------------------------------------
function FormataData_Brasil($timestamp, $formato="dl")
{
	// Recebe uma data e hora no formato MySQl (aaaa-mm-dd hh:mm:ss) e retorna o que foi solicitado no $formato:
	// $formato:
	// "dc" - retorna dd/mm/aa
	// "dl" - retorna dd/mm/aaaa
	// "hc" - retorna hh:mm
	// "hl" - retorna hh:mm:ss
	// "ts" - retorna dd/mm/aaaa hh:mm:ss
	// "tsp" - retorna dd/mm/aaaa às hh:mm
	
	$timestamp = explode(" ", $timestamp);
	$data = $timestamp[0];
	$hora = $timestamp[1];

	$data_separada = explode("-", $data);
	$hora_separada = explode(":", $hora);
	
	switch($formato)
	{
		case "dc":
			return $data_separada[2]."/".$data_separada[1]."/".substr($data_separada[0], -2, 2);
			break;
			
		case "dl":
			return $data_separada[2]."/".$data_separada[1]."/".$data_separada[0];
			break;

		case "hc":
			return $hora_separada[0].":".$hora_separada[1];
			break;
		
		case "hl":
			return $hora_separada[0].":".$hora_separada[1].":".$hora_separada[2];
			break;

		case "ts":
			return $data_separada[2]."/".$data_separada[1]."/".$data_separada[0]." ".$hora_separada[0].$hora_separada[1].$hora_separada[2];
			break;
		
		case "tsp":
			return $data_separada[2]."/".$data_separada[1]."/".$data_separada[0]." às ".$hora_separada[0].":".$hora_separada[1];
			break;			
					
			
		default:
			return $timestamp;			
	}
}
//---------------------------------------------------------------------
function BrasilParaUSData($data)
{
	$date = explode("/", $data);
		
	return $date[1]."/".$date[0]."/".$date[2];
}
//---------------------------------------------------------------------
function Subtrai_Tempo($tempoi, $tempof)
{
	// $tempo1 e $tempo2 devem ser no formato hh:mm:ss ou hh:mm
	
	$tempoi_separado = explode(":", $tempoi);
	$tempof_separado = explode(":", $tempof);
		
	$segundosi = $tempoi_separado[2] + $tempoi_separado[1] * 60 + $tempoi_separado[0] * 3600;
	$segundosf = $tempof_separado[2] + $tempof_separado[1] * 60 + $tempof_separado[0] * 3600;
		
	$diferenca_segundos = $segundosf - $segundosi;
		
	
	if ($diferenca_segundos < 0)
	{
		$diferenca_segundos *= -1;	
		$sinal = "-";	
	}
	else
		$sinal = "";
		
	
	$dif_h = (int)($diferenca_segundos / 3600);	
	$resto = $diferenca_segundos - ($dif_h * 3600);	
	$dif_m = (int)($resto / 60);
	$resto = $diferenca_segundos - ($dif_m * 60);	
	$dif_s = $resto;
	
	if ($dif_h < 10)
		$dif_h = "0".$dif_h;
	if ($dif_m < 10)
		$dif_m = "0".$dif_m;
	if ($dif_s < 10)
		$dif_s = "0".$dif_s;
		
	return $sinal.$dif_h.":".$dif_m.":".$dif_s;
}
//---------------------------------------------------------------------
function Integer_Divide($x, $y)
{
//Returns the integer division of $x/$y.
$t = 1;
if($y == 0 || $x == 0)
	return 0;
if($x < 0 XOR $y < 0) //Mistaken the XOR in the last instance...
	$t = -1;
$x = abs($x);
$y = abs($y);
$ret = 0;
while(($ret+1)*$y <= $x)
	$ret++;
	
return $t*$ret;
}
//---------------------------------------------------------------------
function SomaTempo($data1, $data2)
{	
$dt1 = explode(":", $data1);	
$dt2 = explode(":", $data2);	

$h1 = $dt1[0];
$m1 = $dt1[1];
$s1 = $dt1[2];

$h2 = $dt2[0];
$m2 = $dt2[1];
$s2 = $dt2[2];

$th = $h1 + $h2;
$tm = $m1 + $m2;
$ts = $s1 + $s2;

$divS = integer_divide($ts, 60);
$divM = integer_divide($tm, 60);

$ts = $ts - ($divS * 60);
$tm += $divS;

$tm = $tm - ($divM * 60);
$th += $divM;

if ($th < 10)
  $th = "0".$th;
  
if ($tm < 10)
  $tm = "0".$tm;
  
if ($ts < 10)
  $ts = "0".$ts;

  
return $th.":".$tm.":".$ts;
}
//---------------------------------------------------------------------
function CompletaZeroEsquerda($valor, $tamanho)
{
if (strlen($valor) < $tamanho)	
{
	for ($i = strlen($valor); $i < $tamanho; $i++)
	  $valor = "0".$valor;
		
}
return $valor;	
}
//---------------------------------------------------------------------
function PreencheEsquerda($caractere, $valor, $tamanho)
{
	if (strlen($caractere) != 1)
		return $valor;
	
	if (strlen($valor) < $tamanho)	
	{
		for ($i = strlen($valor); $i < $tamanho; $i++)
	  		$valor = $caractere.$valor;		
	}
	
	return $valor;	
}
//---------------------------------------------------------------------
function SetaMascaraCPFCNPJ($numero) {
	$numero = LimpaMascara($numero);
	$tam = strlen($numero);	
	if ($tam <= 11)	{	// CPF
		// Máscara: ###.###.###-##	
		
		if ($tam < 11)
			$numero = CompletaZeroEsquerda($numero, 11);
			
		$mascaracpf = "###.###.###-##";
		$com_mascara = "";		
		$cont = 0;		
		for ($i = 0; $i < strlen($mascaracpf); $i++) {
			if ($mascaracpf[$i] == "#")	{
				$com_mascara .= $numero[$cont];
				$cont++;
			}
			else
				$com_mascara .= $mascaracpf[$i];		
		}
	}
	else { // CNPJ		
		// Máscara: ##.###.###/####-##	
		
		if ($tam < 14) 
			CompletaZeroEsquerda($numero, 14);						
			
		$mascaracpf = "##.###.###/####-##";
		$com_mascara = "";		
		$cont = 0;		
		for ($i = 0; $i < strlen($mascaracpf); $i++) {
			if ($mascaracpf[$i] == "#")	{
				$com_mascara .= $numero[$cont];
				$cont++;
			}
			else
				$com_mascara .= $mascaracpf[$i];		
		}
	}
	
	return $com_mascara;			
}
//---------------------------------------------------------------------
function LimpaMascara($numero) {	
	$caracteres = array(".", ",", " ", "/", "-", "(", ")", "=", "#", "*", "\"", "'", "?", "[", "]", "{", "}", "|");	
	$numero = str_replace($caracteres, "", $numero);	
	return $numero;
}
//---------------------------------------------------------------------
function MantemSomenteNumeros($texto)
{	
	$numeros_telefonicos = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "/");
	$novo_texto = "";
	
	for ($i = 0; $i < strlen($texto); $i++)
	{
		if (in_array($texto[$i], $numeros_telefonicos))
			$novo_texto .= $texto[$i];
	}

	return $novo_texto;
}
//---------------------------------------------------------------------
function ValidaCPFCNPJ($cpfcnpj)
{
  $cpfcnpj = LimpaMascara($cpfcnpj);
	
  if(!is_numeric($cpfcnpj))
    return FALSE;
    
  if (strlen($cpfcnpj) == 14)
    return ValidaCNPJ($cpfcnpj);
  if (strlen($cpfcnpj) == 11)
    return ValidaCPF($cpfcnpj);
  else
    return FALSE;
}
//---------------------------------------------------------------------
// fonte: https://github.com/Respect/Validation#vcreditcard
function ValidaCartaoCredito($cc_num, $type) {
	if($type == "American") {
		$denum = "American Express";
	} elseif($type == "Dinners") {
		$denum = "Diner's Club";
	} elseif($type == "Discover") {
		$denum = "Discover";
	} elseif($type == "Master") {
		$denum = "Master Card";
	} elseif($type == "Visa") {
		$denum = "Visa";
	}

	if($type == "American") {
		$pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
		if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}


	} elseif($type == "Dinners") {
		$pattern = "/^([30|36|38]{2})([0-9]{12})$/";//Diner's Club
		if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}


	} elseif($type == "Discover") {
		$pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
		if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}


	} elseif($type == "Master") {
		$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
		if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}


	} elseif($type == "Visa") {
		$pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
		if (preg_match($pattern,$cc_num)) {
		$verified = true;
	} else {
		$verified = false;
	}

	}

	return $verified;
}
//---------------------------------------------------------------------
function ValidaCPF($cpf)
{ 	
	// Script de Júlio César Martini (baphp@imasters.com.br)
	// http://www.imasters.com.br/artigo/1403 (acessado em 15/05/2007)
	// (com alterações)
	
	// verifica se o valor passado é numérico	
	if(!is_numeric($cpf)) 
 		return FALSE;
 		
 	// verifica se foi passado com todos os caracteres repetidos	
	if(($cpf == '11111111111') || ($cpf == '22222222222') ||
 	   ($cpf == '33333333333') || ($cpf == '44444444444') ||
       ($cpf == '55555555555') || ($cpf == '66666666666') ||
       ($cpf == '77777777777') || ($cpf == '88888888888') ||
       ($cpf == '99999999999') || ($cpf == '00000000000')) 
 		return FALSE;    	  
 	
 	// lê o dígito verificador (DV)
	$dv_informado = substr($cpf, 9,2);

 	for($i=0; $i<=8; $i++) 
 		$digito[$i] = substr($cpf, $i,1); 
	
	// calcula o valor do 10° dígito de verificação
	$posicao = 10;
	$soma = 0;

	for($i=0; $i<=8; $i++) 
	{
		$soma = $soma + $digito[$i] * $posicao;
		$posicao = $posicao - 1;
	}

	$digito[9] = $soma % 11;

	if($digito[9] < 2)    
		$digito[9] = 0;   
	else
		$digito[9] = 11 - $digito[9];   
   
	// calcula o valor do 11° dígito de verificação
	$posicao = 11;
	$soma = 0;

	for ($i=0; $i<=9; $i++)
	{
		$soma = $soma + $digito[$i] * $posicao;
		$posicao = $posicao - 1;
	}

	$digito[10] = $soma % 11;

	if ($digito[10] < 2)
		$digito[10] = 0;   
	else
		$digito[10] = 11 - $digito[10];   
	
	// verifica se o DV calculado é igual ao informado
	$dv = $digito[9] * 10 + $digito[10];
	if ($dv != $dv_informado)
		return FALSE;  
	else
		return TRUE;  
}
//---------------------------------------------------------------------
function ValidaCNPJ($cnpj)
{
	// Script de Júlio César Martini (baphp@imasters.com.br)
	// (com alterações)
	
	$s = "";
	for ($x=1; $x<=strlen($cnpj); $x=$x+1)
	{
		$ch=substr($cnpj,$x-1,1);
		if (ord($ch)>=48 && ord($ch)<=57)    
			$s=$s.$ch;    
	}

	$cnpj=$s;
	if (strlen($cnpj)!=14)
		return FALSE;
	else
	if ($cnpj=="00000000000000")	
		return FALSE;		
	
	$Numero[1]=intval(substr($cnpj,1-1,1));
	$Numero[2]=intval(substr($cnpj,2-1,1));
	$Numero[3]=intval(substr($cnpj,3-1,1));
	$Numero[4]=intval(substr($cnpj,4-1,1));
	$Numero[5]=intval(substr($cnpj,5-1,1));
	$Numero[6]=intval(substr($cnpj,6-1,1));
	$Numero[7]=intval(substr($cnpj,7-1,1));
	$Numero[8]=intval(substr($cnpj,8-1,1));
	$Numero[9]=intval(substr($cnpj,9-1,1));
	$Numero[10]=intval(substr($cnpj,10-1,1));
	$Numero[11]=intval(substr($cnpj,11-1,1));
	$Numero[12]=intval(substr($cnpj,12-1,1));
	$Numero[13]=intval(substr($cnpj,13-1,1));
	$Numero[14]=intval(substr($cnpj,14-1,1));
	
	$soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+
	$Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;

	$soma=$soma-(11*(intval($soma/11)));
	
	if ($soma==0 || $soma==1)	
		$resultado1=0;		
	else
		$resultado1=11-$soma;
   
	if ($resultado1==$Numero[13])
	{
		$soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+
		$Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;
		$soma=$soma-(11*(intval($soma/11)));
		
		if ($soma==0 || $soma==1)
			$resultado2=0;
		else
			$resultado2=11-$soma;
		
		if ($resultado2==$Numero[14])
			return TRUE;   
   		else
			return FALSE;  
	}
	else
		return FALSE;
}
//---------------------------------------------------------------------
function ValidaRepeticao($texto, $num = 3)
{
	// Ignora algarismos de números romanos e espaços em branco
	// Para não bloquear por exemplo "Rua Papa Pio III"
	$ignorar_caracteres = Array(" ", "X", "x", "I", "i", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	
	for ($i = 0; $i <= strlen($texto) - $num; $i++)
	{		
		$igualdade = 0;		
		
		if  (!in_array($texto[$i],  $ignorar_caracteres))
		{
			for ($count = 1; $count < $num; $count++)
				if ($texto[$i] == $texto[$i + $count]) 
					$igualdade++;						
			
			if ($igualdade == $num - 1)
				return FALSE;		
		}
	}
	return TRUE;
}
//---------------------------------------------------------------------
function ValidaEmail($email)
{
	if (strlen($email) < 5)
		return FALSE;
	
	if (!strpos($email, "@"))
		return FALSE;
	
	if (!strpos($email, "."))
		return FALSE;
		
	return TRUE;
}
//---------------------------------------------------------------------
function TratamentoQueryFirebird($valor)
{
	//$valor_corrigido = str_replace("'", "''", $valor);	
	$valor_corrigido = str_replace("\'", "''", $valor);	
	
	return $valor_corrigido;
}
//---------------------------------------------------------------------
function TratamentoQueryMySQL($valor)
{
	//$valor_corrigido = str_replace("'", "''", $valor);	
	$valor_corrigido = str_replace("\"", "\\\"", $valor);	
	
	return $valor_corrigido;
}
//---------------------------------------------------------------------
function CodificaEmail($mensagem)
{
  // Traduz alguns caracteres para o código de e-mail
  // Baseado no código da fonte: http://www.bbsinc.com/iso8859.html

  $msg_codificada = str_replace("=", "=3D", $mensagem);	  
    
  $msg_codificada = str_replace("À", "=C0", $msg_codificada);	
  $msg_codificada = str_replace("Á", "=C1", $msg_codificada);	
  $msg_codificada = str_replace("Â", "=C2", $msg_codificada);	
  $msg_codificada = str_replace("Ã", "=C3", $msg_codificada);	
  $msg_codificada = str_replace("Ä", "=C4", $msg_codificada);	
  $msg_codificada = str_replace("Å", "=C5", $msg_codificada);	
  $msg_codificada = str_replace("Æ", "=C6", $msg_codificada);	
  $msg_codificada = str_replace("Ç", "=C7", $msg_codificada);	
  $msg_codificada = str_replace("È", "=C8", $msg_codificada);	
  $msg_codificada = str_replace("É", "=C9", $msg_codificada);	
  $msg_codificada = str_replace("Ê", "=CA", $msg_codificada);	
  $msg_codificada = str_replace("Ë", "=CB", $msg_codificada);	
  $msg_codificada = str_replace("Ì", "=CC", $msg_codificada);	
  $msg_codificada = str_replace("Í", "=CD", $msg_codificada);	
  $msg_codificada = str_replace("Î", "=CE", $msg_codificada);	
  $msg_codificada = str_replace("Ï", "=CF", $msg_codificada);	
  $msg_codificada = str_replace("Ð", "=D0", $msg_codificada);	
  $msg_codificada = str_replace("Ñ", "=D1", $msg_codificada);	
  $msg_codificada = str_replace("Ò", "=D2", $msg_codificada);	
  $msg_codificada = str_replace("Ó", "=D3", $msg_codificada);	
  $msg_codificada = str_replace("Ô", "=D4", $msg_codificada);	
  $msg_codificada = str_replace("Õ", "=D5", $msg_codificada);	
  $msg_codificada = str_replace("Ö", "=D6", $msg_codificada);	
  $msg_codificada = str_replace("×", "=D7", $msg_codificada);	
  $msg_codificada = str_replace("Ø", "=D8", $msg_codificada);	
  $msg_codificada = str_replace("Ù", "=D9", $msg_codificada);	
  $msg_codificada = str_replace("Ú", "=DA", $msg_codificada);	
  $msg_codificada = str_replace("Û", "=DB", $msg_codificada);	
  $msg_codificada = str_replace("Ü", "=DC", $msg_codificada);	
  $msg_codificada = str_replace("Ý", "=DD", $msg_codificada);	
  $msg_codificada = str_replace("Þ", "=DE", $msg_codificada);	
  $msg_codificada = str_replace("ß", "=DF", $msg_codificada);	
 
  $msg_codificada = str_replace("à", "=E0", $msg_codificada);	
  $msg_codificada = str_replace("á", "=E1", $msg_codificada);	
  $msg_codificada = str_replace("â", "=E2", $msg_codificada);	
  $msg_codificada = str_replace("ã", "=E3", $msg_codificada);	
  $msg_codificada = str_replace("ä", "=E4", $msg_codificada);	
  $msg_codificada = str_replace("å", "=E5", $msg_codificada);	
  $msg_codificada = str_replace("æ", "=E6", $msg_codificada);	
  $msg_codificada = str_replace("ç", "=E7", $msg_codificada);	
  $msg_codificada = str_replace("è", "=E8", $msg_codificada);	
  $msg_codificada = str_replace("é", "=E9", $msg_codificada);	
  $msg_codificada = str_replace("ê", "=EA", $msg_codificada);	
  $msg_codificada = str_replace("ë", "=EB", $msg_codificada);	
  $msg_codificada = str_replace("ì", "=EC", $msg_codificada);	
  $msg_codificada = str_replace("í", "=ED", $msg_codificada);	
  $msg_codificada = str_replace("î", "=EE", $msg_codificada);	
  $msg_codificada = str_replace("ï", "=EF", $msg_codificada);	
  $msg_codificada = str_replace("ð", "=F0", $msg_codificada);	
  $msg_codificada = str_replace("ñ", "=F1", $msg_codificada);	
  $msg_codificada = str_replace("ò", "=F2", $msg_codificada);	
  $msg_codificada = str_replace("ó", "=F3", $msg_codificada);	
  $msg_codificada = str_replace("ô", "=F4", $msg_codificada);	
  $msg_codificada = str_replace("õ", "=F5", $msg_codificada);	
  $msg_codificada = str_replace("ö", "=F6", $msg_codificada);	
  $msg_codificada = str_replace("÷", "=F7", $msg_codificada);	
  $msg_codificada = str_replace("ø", "=F8", $msg_codificada);	
  $msg_codificada = str_replace("ù", "=F9", $msg_codificada);	
  $msg_codificada = str_replace("ú", "=FA", $msg_codificada);	
  $msg_codificada = str_replace("û", "=FB", $msg_codificada);	
  $msg_codificada = str_replace("ü", "=FC", $msg_codificada);	
  $msg_codificada = str_replace("ý", "=FD", $msg_codificada);	
  $msg_codificada = str_replace("þ", "=FE", $msg_codificada);	
  $msg_codificada = str_replace("ÿ", "=FF", $msg_codificada);	

  return $msg_codificada; 
}
//---------------------------------------------------------------------
function StringAteChr($str, $chr)
{
	return substr($str, 0, strpos($str, "/"));
}
//---------------------------------------------------------------------
function Div($n1, $n2)
{
// Simula o operador div do Delphi (retorna o valor inteiro de uma divisão)

$divisao = $n1/$n2;

return (int)$divisao;
}
//---------------------------------------------------------------------
function Mod($n1, $n2)
{
// Simula o operador mod do Delphi (retorna o resto de uma divisão)	

$divisao = Div($n1, $n2);
$resto = $n1 - ($divisao * $n2);

return $resto;	
}
//---------------------------------------------------------------------
function Trunc($valor)
{
	// Simula a função Trunc() do Delphi
	
	return (int)$valor;
}
//---------------------------------------------------------------------
function StringContemTexto($str, $texto)
{
$pos = strpos($str, $texto);
if ($pos === FALSE)	
	return FALSE;
else
	return TRUE;
}	
//---------------------------------------------------------------------
function TitleCase($str, $preposicoes=FALSE)
{
	// $preposicoes - se deve manipular ou não processar as preposicoes em meio às palavras
	
	$prep = Array("da", "de", "do", "dos", "das");
	$palavras = explode(" ", mb_strtolower($str));	
	
	foreach($palavras as $key => $value) {				
		// $a -> palavra com tamanho maior que zero
		// $b -> manipular preposição
		// $c -> palavra é uma preposição
		
		$a = strlen($palavras[$key]) > 0;
		$b = $preposicoes;
		$c = in_array($palavras[$key], $prep);
				
		if ($a && (!$c || ($b && $c)))
			$palavras[$key][0] = mb_strtoupper($palavras[$key][0]);
	}
		
	return implode(" ", $palavras);
}
//---------------------------------------------------------------------	
function Only_Numbers($str)
{
	$contem_nao_numerico = FALSE;
	
	for ($i=0; $i<strlen($str); $i++)
		if (!is_numeric($str[$i]))
		{
			$contem_nao_numerico = TRUE;
			break;	
		}
		
	return !$contem_nao_numerico;
}
//---------------------------------------------------------------------	
function Insere_Texto_Posicao($original, $texto, $posicao)
{		
	if ($posicao > strlen($original))
		return $original.$texto;
	else if ($posicao <= 0)
		return $texto.$original;
	
	$anterior = substr($original, 0, $posicao-1);
	$posterior = substr($original, (strlen($original)-$posicao+1)*-1);
	
		
	return $anterior.$texto.$posterior;
}
//---------------------------------------------------------------------	
function Coloca_Separador_Cep($cep, $ponto_milhar=FALSE)
{
	$copia_cep = $cep;
	
	// O CEP deve ser passado somente com os números	
	$remover = Array(".", "/", "-", " ");
	$cep = str_replace($remover, "", $cep);
	
	if (strlen($cep) == 8)
	{
		$cep = Insere_Texto_Posicao($cep, "-", 6);
		
		if ($ponto_milhar)
			$cep = Insere_Texto_Posicao($cep, ".", 3);
			
		return $cep;		
	}		
	else
		return $copia_cep;		
}
//---------------------------------------------------------------------	
function SameText($str1, $str2)
{
	// Simulação da função SameText do Delphi
	
	$str1 = strtoupper($str1);
	$str2 = strtoupper($str2);
	
	return ($str1 == $str2);
}
//---------------------------------------------------------------------	
function DataHoraAtual()
{
	return date("d/m/Y")." às ".date("H:i:s");
}
//---------------------------------------------------------------------	
function TrocaVirgulaPonto($texto)
{
  return str_replace(",", ".", $texto);
}
//---------------------------------------------------------------------
function Debug($debug_text)
{
  global $_DEBUG_DIR;
  
  file_put_contents($_DEBUG_DIR."debug_".$_SERVER['REMOTE_ADDR'].".txt", $debug_text);
}
//---------------------------------------------------------------------
function ArrayValoresParaString($array)
{
	// Quando a array NÃO tem outras arrays como elemento
	
	$string = "";
	
	if (count($array) > 0)
	{
	
	  foreach ($array AS $key=>$value)
  	  {
	    if ($string != "")
	      $string .= "<#sep>";
	    $string .= $key."<#atr>".$value;
	  }
    }
    	
	return $string;
}
//---------------------------------------------------------------------
function StringParaArrayValores($string)
{
	// Quando a array NÃO tem outras arrays como elemento
	
	$array = explode("<#sep>", $string);
	
	foreach($array AS $value)
	{
	  $array_temp = explode("<#atr>", $value);
	  $array_final[$array_temp[0]] = $array_temp[1];
	}
	
	return $array_final;
}
//---------------------------------------------------------------------
function ArrayParaString($array)
{
  $StringDoArray = "";  									   								   								
  
  if (count($array) > 0)
  {
    foreach($array AS $key=>$value)
    {
  	  if ($StringDoArray <> "")
	    $StringDoArray .= "<#sep1>";
	  
      $StringDoArray .= $key."<#atr1>";
      $StringDoArray .= ArrayValoresParaString($value);
    }
  }
    
  return $StringDoArray;
}
//---------------------------------------------------------------------
function StringParaArray($string)
{
  if ($string == "")
    return Array();	
	
  $array = explode("<#sep1>", $string);
  
  foreach($array AS $value)
  {
    $attr_interna = explode("<#atr1>", $value);
    $array_final[$attr_interna[0]] = StringParaArrayValores($attr_interna[1]);
  }
  
  return $array_final;
}
//---------------------------------------------------------------------
function DigitoVerificador($cpf_cnpj_puro)
{
  // $cpf_cnpj_puro = sem o dígito verificador	
  // Limpa máscara	
  $caracteres = array(".", ",", " ", "/", "-", "(", ")", "=", "#", "*", "\"", "'", "?", "[", "]", "{", "}", "|");
  $cpf_cnpj_puro = str_replace($caracteres, "", $cpf_cnpj_puro);				
  
  $tamanho_numero = strlen($cpf_cnpj_puro);
  if (($tamanho_numero != 9) && ($tamanho_numero != 12))
    return FALSE;
  
  // Calcula o primeiro dígito
  if ($tamanho_numero == 12)
    $base = array(5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2); // CNPJ
  else
    $base = array(10, 9, 8, 7, 6, 5, 4, 3, 2); // CPF
  
  for ($i = 0; $i <= $tamanho_numero-1; $i++)
    $multiplicacao[] = $cpf_cnpj_puro[$i] * $base[$i];
    
  $soma = 0;  
  foreach($multiplicacao AS $value)
    $soma += $value;  
    
  $resto = $soma % 11;
  if ($resto < 2)
    $primeiro_digito = 0;
  else
    $primeiro_digito = 11 - $resto;    
    
            
  // Calcula o segundo dígito  
  $cpf_cnpj_puro .= $primeiro_digito;  
 
  $multiplicacao = array(); // Limpa a matriz
  
  if ($tamanho_numero == 12)
    $base = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2); // CNPJ
  else
    $base = array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2); // CPF
  for ($i = 0; $i <= $tamanho_numero; $i++)
    $multiplicacao[] = $cpf_cnpj_puro[$i] * $base[$i];
    
  $soma = 0;  
  foreach($multiplicacao AS $value)
    $soma += $value;    
    
  $resto = $soma % 11;
  if ($resto < 2)
    $segundo_digito = 0;
  else
    $segundo_digito = 11 - $resto;
    
    
  return $primeiro_digito.$segundo_digito;   
}
//---------------------------------------------------------------------
function DataEstaEntre($data, $inicial, $final) {
  // $data: A-m-d (ex: 2010-09-21)
  // $inicial: A-m-d
  // $final: A-m-d

 return (strtotime($data) >= strtotime($inicial)) && (strtotime($data) <= strtotime($final));
} 
//---------------------------------------------------------------------
function GeraSenha($tamanho)
{
  $chars = "abcdefghijklmnopqrstuvwxyz0123456789"; // 36 caracteres

  srand((double)microtime()*1000000);
  $pass = "";

  for ($i = 0; $i < $tamanho; $i++)
  {
    $num = rand() % 36; // Corrigir este número caso altere o número de caracteres
    $tmp = substr($chars, $num, 1);
    $pass .= $tmp;
  }
  
  return $pass;
}
//---------------------------------------------------------------------
// Função baseada no manual do PHP:
// http://br2.php.net/manual/en/function.exec.php
// Excecuta em background um script no servidor, tanto em Linux quanto em Windows.
function execInBackground($cmd) {
    exec($cmd . " &");
}
//---------------------------------------------------------------------
function ForceDirectories($dir) {	
	if (!file_exists($dir))
		return mkdir($dir, 0777, TRUE);
	else
		return TRUE;
}
//---------------------------------------------------------------------
function IPCliente() {
    if (isset($_SERVER)) {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');

    return getenv('REMOTE_ADDR');
}
//---------------------------------------------------------------------
// Adaptado de: http://stackoverflow.com/questions/2029409/get-version-of-exe-via-php
function PropriedadeArquivo($arquivo, $propriedade) {
	$key = "";
	for($i=0; $i<strlen($propriedade); $i++)
		$key .= $propriedade[$i]."\x00";
	$key .= "\x00\x00";
	$fptr = fopen($arquivo, "rb");
	$data = "";
	while (!feof($fptr)) {
	  $data .= fread($fptr, 65536);
	  if (strpos($data, $key)!==FALSE)
		 break;
	  $data = substr($data, strlen($data)-strlen($key));
	}
	fclose($fptr);
	if (strpos($data, $key)===FALSE)
	  return "";
	$pos = strpos($data, $key)+strlen($key);
	$prop = "";
	for ($i=$pos; $data[$i]!="\x00"; $i+=2)
	  $prop .= $data[$i];
	return $prop;
}
//---------------------------------------------------------------------
// Fonte: http://stackoverflow.com/questions/7497733/how-can-use-php-to-check-if-a-directory-is-empty em 25/04/2014.
function DiretorioVazio($dir) {
  if (!is_readable($dir)) return NULL; 
  $handle = opendir($dir);
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..")
      return FALSE;
  }
  return TRUE;
}
//---------------------------------------------------------------------
// Baseado em: http://stackoverflow.com/questions/4594180/deleting-all-files-from-a-folder-using-php em 03/09/2014.
function LimpaDiretorio($dir) {
	if (substr($dir, -1) == '/') {
		$dir = substr($dir, 0, -1);
	}
	$files = glob($dir.'/{,.}*', GLOB_BRACE); // Apaga também arquivos ocultos.
	foreach ($files as $file){
	  if(is_file($file))
		unlink($file);
	}
}
//---------------------------------------------------------------------
function StuffString($AText, $AStart, $ALength, $ASubText) {
	$str = substr($AText, 0, $AStart - 1);
	$str .= $ASubText;
	$str .= substr($AText, $AStart + $ALength -1 , $MaxInt);		
	return $str;
}
//---------------------------------------------------------------------
function StringOfChar($chr, $quant) {
	// Simula o StringOfChar() do Delphi
	
	if (strlen($chr) != 1 || $quant < 0)
		return FALSE;
		
	$str = "";	
		
	for ($i = 0; $i < $quant; $i++)
		$str .= $chr;
		
	return $str;
}
//---------------------------------------------------------------------
function LimparString($str) {
	$especiais = array("á", "à", "ã", "â", "Á", "À", "Ã", "Â",
					   "é", "ê", "É", "Ê",
					   "í", "Í",
					   "ó", "ô", "õ", "Ó", "Ô", "Õ",
					   "ú", "ü", "Ú", "Ü",
					   "ç", "Ç");
	$normais = array("a", "a", "a", "a", "A", "A", "A", "A",
					 "e", "e", "E", "E",
					 "i", "I",
					 "o", "o", "o", "O", "O", "O",
					 "u", "u", "U", "U",
					 "c", "C");

	$str = str_replace($especiais, $normais, $str);	

	return $str;
}
//---------------------------------------------------------------------
function GerarCodigo($tamanho){
    $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $return= "";

    for($count= 0; $tamanho > $count; $count++){
        $return.= $basic[rand(0, strlen($basic) - 1)];
    }

    return $return;
}
//---------------------------------------------------------------------
?>
