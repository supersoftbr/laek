<?php

// *********
// BASE SITE
// *********
define("PATH_SITE", "/home/super/public_html/site/");
define("URL_SITE", "https://www.supersoft.com.br/");

// *********
// DONWLOADS
// *********
define("CAMINHO_INSTALACOES", PATH_SITE."downloads/instalacoes/");
define("CAMINHO_ATUALIZACOES", PATH_SITE."downloads/atualizacoes/");
define("CAMINHO_TESTE_SISTEMA", PATH_SITE."downloads/testar/");
define("CAMINHO_EMISSOR", PATH_SITE."downloads/emissor/");
define("LINK_EMISSOR", URL_SITE."downloads/emissor/");

// ********
// SuperPay
// ********
define("MODO_PAGAMENTO", "production"); // sandbox = homogação e testes.
									    // production = produção.
define("TOKEN_HOMOLOGACAO", "1397197106422");
define("TOKEN_PRODUCAO", "1442229217860");
define("SUPERPAY_LOGIN", "supersoft");
define("SUPERPAY_SENHA", "sp2016ab120*xd");

// *********
// PagSeguro
// *********
define("TOKEN_PAGSEGURO", "999F026CBFB345BB8F2AEFDEEB4EBD63");
define("PAIS", "Brasil");


// *********
// Depuração
// *********
// OBS: Alterando o MODO_DESENVOLVIMENTO para TRUE faz com que as outras definições de depuração fiquem ativas.
define("MODO_DESENVOLVIMENTO", FALSE); // Mudar para FALSE para modo de produção.
define("EMAIL_TESTE", "daniel.tecnologia@supersoft.com.br");
define("EMAIL_DESENVOLVEDOR", "daniel.tecnologia@supersoft.com.br");
define("LOG_MYSQL", PATH_SITE."_logs/mysql.log"); // Arquivo de log para transações com o MySQL.
define("LOG_SITE", PATH_SITE."_logs/site.log"); // Arquivo de log do Site.

// ********************************
// Configurações das bases de dados
// ********************************
define("SITE_HOST", "localhost"); // Hostgator
define("SITE_DATABASE", "super_site");
define("SITE_LOGIN", "super_super");
define("SITE_SENHA", "gK7vfuf1V");

// ****************************************
// Configurações das bases de dados interno
// ****************************************
define("INTERNO_HOST", "localhost"); // Hostgator
define("INTERNO_DATABASE", "super_interno");
define("INTERNO_LOGIN", "super_super");
define("INTERNO_SENHA", "gK7vfuf1V");

// *********************************
// Configurações do Mantis Comercial
// ********************************* 
define("HOST_MANTIS_COMERCIAL", "db.supersoft.com.br");
define("USER_MANTIS_COMERCIAL", "mantis_comercial"); 
define("PASSWORD_MANTIS_COMERCIAL", "Fhd9jio7N");
define("DATABASE_MANTIS_COMERCIAL", "mantis_comercial");

// ***********************
// Configurações de e-mail
// ***********************
define("REMETENTE_COMERCIAL_NOME", "Comercial SuperSoft");
define("REMETENTE_COMERCIAL", "comercial@supersoft.com.br");
define("DESTINATARIOS_COMERCIAL", "comercial@supersoft.com.br");
define("ENVIADOR_EMAILS", "supersoft@supersoft.com.br");
define("ASSUNTO_NOVO_CADASTRO", "Novo cadastro: ");

// *******************************************************************************
// Configurações de e-mail de boas vindas (Orçamento, Teste Grátis ou Interessado)
// *******************************************************************************
define("REMETENTE_BOAS_VINDAS_NOME", "SuperSoft Sistemas");
define("REMETENTE_BOAS_VINDAS", "atendimento@supersoft.com.br");
define("ASSUNTO_BOAS_VINDAS_ORCAMENTO", "Orçamento - SuperSoft Sistemas");
define("ASSUNTO_BOAS_VINDAS_TESTE_GRATIS", "Teste já os sistemas da SuperSoft Sistemas");
define("ASSUNTO_BOAS_VINDAS_INTERESSADO", "A SuperSoft Sistemas agradece por seu interesse");

// ************************************
// Configurações de e-mail de Orçamento
// ************************************
define("REMETENTE_ORCAMENTO_NOME", "SuperSoft Sistemas");
define("REMETENTE_ORCAMENTO", "noreply@supersoft.com.br");
define("DESTINATARIOS_ORCAMENTO", "daniel@nooven.com.br,comercial.erp@supersoft.com.br,daniel.tecnologia@supersoft.com.br,ariana@supersoft.com.br,danieli.marketing@supersoft.com.br");
define("ASSUNTO_ORCAMENTO", "Novo orçamento: ");

// ***************************************
// Configurações de e-mail de Teste Grátis
// ***************************************
define("REMETENTE_TESTE_GRATIS_NOME", "SuperSoft Sistemas");
define("REMETENTE_TESTE_GRATIS", "noreply@supersoft.com.br");
define("DESTINATARIOS_TESTE_GRATIS", "daniel@nooven.com.br,comercial.erp@supersoft.com.br,daniel.tecnologia@supersoft.com.br,ariana@supersoft.com.br,danieli.marketing@supersoft.com.br");
define("ASSUNTO_TESTE_GRATIS", "Novo teste grátis: ");

// **************************************
// Configurações de e-mail de Interessado
// **************************************
define("REMETENTE_INTERESSADO_NOME", "SuperSoft Sistemas");
define("REMETENTE_INTERESSADO", "noreply@supersoft.com.br");
define("DESTINATARIOS_INTERESSADO", "daniel@nooven.com.br,comercial.erp@supersoft.com.br,daniel.tecnologia@supersoft.com.br,ariana@supersoft.com.br,danieli.marketing@supersoft.com.br");
define("ASSUNTO_INTERESSADO", "Novo interessado: ");

// *******************************************
// Configurações de e-mail de download da NF-e
// *******************************************
define("REMETENTE_DOWNLOAD_NFE_NOME", "SuperSoft Sistemas");
define("REMETENTE_DOWNLOAD_NFE", "noreply@supersoft.com.br");
define("DESTINATARIOS_DOWNLOAD_NFE", "daniel@nooven.com.br,comercial.erp@supersoft.com.br,daniel.tecnologia@supersoft.com.br,ariana@supersoft.com.br,danieli.marketing@supersoft.com.br");
define("ASSUNTO_DOWNLOAD_NFE", "Novo download da NF-e: ");

// *******************************************
// Configurações de e-mail de Interessado NF-e
// *******************************************
define("REMETENTE_INTERESSADO_NFE_NOME", "SuperSoft Sistemas");
define("REMETENTE_INTERESSADO_NFE", "noreply@supersoft.com.br");
define("DESTINATARIOS_INTERESSADO_NFE", "daniel@nooven.com.br,comercial.erp@supersoft.com.br,daniel.tecnologia@supersoft.com.br,ariana@supersoft.com.br,danieli.marketing@supersoft.com.br");
define("ASSUNTO_INTERESSADO_NFE", "Novo interessado na NF-e: ");

// *********************************************
// Configurações de e-mail de "Ligamos pra você"
// *********************************************
define("REMETENTE_LIGAMOS_NOME", "SuperSoft Sistemas");
define("REMETENTE_LIGAMOS", "noreply@supersoft.com.br");
define("DESTINATARIOS_LIGAMOS", "daniel@nooven.com.br,daniel.tecnologia@supersoft.com.br,ariana@supersoft.com.br,danieli.marketing@supersoft.com.br");
define("ASSUNTO_LIGAMOS", "Ligue pra mim: ");

// **************************************************************
// Configurações de e-mail de avaliação de Pós-vendas/Homologação
// **************************************************************
define("REMETENTE_AVALIACAO_NOME", "SuperSoft Sistemas");
define("REMETENTE_AVALIACAO", "atendimento@supersoft.com.br");

define("DESTINATARIOS_AVALIACAO_NEGATIVA_POSVENDAS", "anamattos.marketing@supersoft.com.br,adriano.suporte@supersoft.com.br");
define("ASSUNTO_AVALIACAO_NEGATIVA_POSVENDAS", "Avaliação de pós-vendas negativa: ");

define("DESTINATARIOS_AVALIACAO_POSVENDAS", "anamattos.marketing@supersoft.com.br,adriano.suporte@supersoft.com.br,lucimara.marketing@supersoft.com.br");
define("ASSUNTO_AVALIACAO_POSVENDAS", "Avaliação de pós-vendas: ");

define("DESTINATARIOS_AVALIACAO_HOMOLOGACAO", "anamattos.marketing@supersoft.com.br,adriano.suporte@supersoft.com.br");
define("ASSUNTO_AVALIACAO_HOMOLOGACAO", "Avaliação de homologação do treinamento: ");

// ****************************************
// Configurações de e-mail CTS Fale Conosco
// ****************************************
define("REMETENTE_CTS_FALE_CONOSCO_NOME", "CTS Fale Conosco");
define("REMETENTE_CTS_FALE_CONOSCO", "faleconosco@supersoft.com.br");
define("NOME_REMETENTE_CTS_INSCRICOES", "Centro de Treinamentos SuperSoft");
define("REMETENTE_CTS_INSCRICOES", "contato@supersoft.com.br");
define("DESTINATARIO_CTS_INSCRICOES", "anasanchez.cts@supersoft.com.br");

// **********************************
// Configurações de modelos de e-mail
// **********************************

$MODELOS = array(
	'ORCAMENTO'=>array('NOME_REMETENTE'=>'Atendimento Supersoft', 'EMAIL_REMETENTE'=>'atendimento@supersoft.com.br', 'ASSUNTO'=>'Orçamento: [#INTERESSADO]', 'MODELO'=>'modelos/e-mail/demonstracao.html'),
	'TESTAR_SISTEMA'=>array('NOME_REMETENTE'=>'Atendimento Supersoft', 'EMAIL_REMETENTE'=>'atendimento@supersoft.com.br', 'ASSUNTO'=>'Teste de sistema: [#INTERESSADO]', 'MODELO'=>'modelos/e-mail/teste_sistema.html'),
	'FALECONOSCO'=>array('NOME_REMETENTE'=>'Fale Conosco', 'EMAIL_REMETENTE'=>'atendimento@supersoft.com.br', 'ASSUNTO'=>'Fale conosco: [#NOME]', 'MODELO'=>'modelos/e-mail/faleconosco.html'),
	'COPA_BOLAO'=>array('NOME_REMETENTE'=>'Bolão da Copa', 'EMAIL_REMETENTE'=>'supersoft@supersoft.com.br', 'ASSUNTO'=>'Bolão da Copa: [#JOGO] - [#PLACAR]: [#NOME]', 'MODELO'=>'modelos/e-mail/copa_bolao.html'),
	'RECSENHA'=>array('NOME_REMETENTE'=>'SuperSoft Sistemas', 'EMAIL_REMETENTE'=>'supersoft@supersoft.com.br', 'ASSUNTO'=>'SupersSoft Sistemas: Recuperação de senha', 'MODELO'=>'modelos/e-mail/recsenha.html'),
	'SOLICITACOES'=>array('NOME_REMETENTE'=>'SuperSoft Sistemas', 'EMAIL_REMETENTE'=>'supersoft@supersoft.com.br', 'ASSUNTO'=>'Solicitação: [#CLIENTE]', 'MODELO'=>'modelos/e-mail/solicitacao.html'),
	'SUGESTOES'=>array('NOME_REMETENTE'=>'SuperSoft Sistemas', 'EMAIL_REMETENTE'=>'supersoft@supersoft.com.br', 'ASSUNTO'=>'Sugestão: [#CLIENTE]', 'MODELO'=>'modelos/e-mail/sugestao.html'),
	'SAC'=>array('NOME_REMETENTE'=>'SuperSoft Sistemas', 'EMAIL_REMETENTE'=>'supersoft@supersoft.com.br', 'ASSUNTO'=>'SAC: [#CLIENTE]', 'MODELO'=>'modelos/e-mail/sac.html'),
	'BOASVINDAS'=>array('NOME_REMETENTE'=>'SuperSoft Sistemas', 'EMAIL_REMETENTE'=>'supersoft@supersoft.com.br', 'ASSUNTO'=>'Bem vindo [#INTERESSADO]', 'MODELO'=>'modelos/e-mail/boasvindas.html'));

define("MODELO_MATIS_SOLICITACAO", "modelos/mantis/mantis_solicitacao.txt");
define("MODELO_MATIS_SUGESTAO", "modelos/mantis/mantis_sugestao.txt");
define("MODELO_MATIS_SAC", "modelos/mantis/mantis_sac.txt");

// **************************
// Configurações da RDStation
// **************************
define("TOKEN_PUBLICO", "5dccf587060455bc6430733fee4b5ed0");

// *****************************
// Configurações dos Webservices
// *****************************

// WS da SuperSoft.
define("CHAVE_REQUISICAO", "8900-ATGY-00IO-FTYH-NJHG");
define("URI_WEB_SERVICE_SS", "http://ws.supersoft.com.br/site/");
define("URI_WEB_SERVICE_COP", "http://centralop.supersoft.com.br/ws/");
define("URI_WEB_SERVICE_SENHAS", "http://www.supersoft.com.br/ws/libsenha/");
define("ENDERECO_WEB_SERVICE_SS", URI_WEB_SERVICE_SS."supersoft.php");
define("ENDERECO_WEB_SERVICE_COP", URI_WEB_SERVICE_COP."centralop.php");
define("ENDERECO_WEB_SERVICE_SENHAS", URI_WEB_SERVICE_SENHAS."supersoft.php");
define("ENDERECO_WEB_SERVICE_CONTROLE", URI_WEB_SERVICE_COP."centralop.php");
define("DOWNLOAD_CENTRALOP", "/downloads/instalacoes/sscentralop/SSCentralOP1.17.exe");

// *********************************************
// Definições do modo Desenvolvimento e Produção
// *********************************************
if (MODO_DESENVOLVIMENTO)
	define("DESTINATARIO_COMERCIAL", EMAIL_TESTE);
else
	define("DESTINATARIO_COMERCIAL", DESTINATARIOS_COMERCIAL);
	
	
// **********************	
// Definições de conteúdo
// **********************
$Segmentos = array('IN'=>'Indústria',
				   'SE'=>'Serviços',
				   'CO'=>'Comércio',
				   '82'=>'Escritório de Contabilidade');
				   
$Midias = array('PA' => 'Não selecionado', 
				'02' => 'Indicação', 
				'06' => 'Google', 
				'29' => 'Fórum Contábeis', 
				'01' => 'Boletim CRC - SP',
				'34' => 'Facebook',
				'33' => 'Administradores.com');
				
				
// ***************				
// Dados bancários
// ***************
// Ver tabelas BANCONTA e CODCOBRANCA.
// A array está no formato 'CONTAREC.CODCOBRANCA' => 'BANCONTA.CONTACOR', não há relação entre estas tabelas, foi relacionado pela Mariana.
// Data: 04/10/2011.
$BOLETO_ITAU_CODCEDENTE = array('3'=>'192269',  // Ag. 8046, BOLETO UNIBANCO/ITAU - SUPERSOFT SISTEMAS LTDA EPP
								'5'=>'291145',  // Ag. 8046, BOLETO ITAU KMAC - KMAC SISTEMAS
								'6'=>'307370',  // Ag. 8046, BOLETO ITAU OPCAO 2 - OPÇÃO 2  ITAU SS
								'4'=>'371343'); // Ag. 0050, BOLETO ITAU - SUPERSOFT 				
$BOLETO_ITAU_CARTEIRA = '112';

// ***************************				
// Códigos do Google Analytics
// ***************************			
$CODIGO_CONVERSAO_GOOGLE_ORCAMENTO = '<!-- Google Code for or&ccedil;amento Conversion Page -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 969529669;
	var google_conversion_language = "en";
	var google_conversion_format = "2";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "EaqzCIOkigoQxbKnzgM";
	var google_remarketing_only = false;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/969529669/?label=EaqzCIOkigoQxbKnzgM&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>';
	

$GOOGLE_CODE_CTS_INSCRICOES = '<!-- Google Code for Contato Curso Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 945317460;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "uB1hCOTLsgUQ1MzhwgM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/945317460/?value=0&amp;label=uB1hCOTLsgUQ1MzhwgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>';

$GOOGLE_CODE_CTS_INSCRICOES = '';	
	
			
$CHAT_SUPORTE = "<!-- LiveZilla Chat Button Link Code (ALWAYS PLACE IN BODY ELEMENT) -->
<a href=\"javascript:void(window.open('http://www.supersoft.com.br/livezilla/chat.php?hg=P0NvbWVyY2lhbD9Db21lcmNpYWxGaXNjb0NvbnRhYmlsP1NTY2hvb2w_','','width=580,height=625,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))\">
<img src=\"http://www.supersoft.com.br/livezilla/image.php?id=12&amp;type=inlay&amp;hg=P0NvbWVyY2lhbD9Db21lcmNpYWxGaXNjb0NvbnRhYmlsP1NTY2hvb2w_\" width=\"250\" height=\"50\" border=\"0\" alt=\"LiveZilla Live Help\"></a>
<!-- http://www.LiveZilla.net Chat Button Link Code -->";

define("PREFIXO_TABELAS_SINCRONISMO", "rep_");

// **********************				
// E-Commerce - SuperSoft
// **********************
define("CHAVE_NUMCARTAO", "5WU0W75ZO");