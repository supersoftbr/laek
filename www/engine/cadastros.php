<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
header('Content-type: text/html; charset=utf-8');
require_once "core.php";
require_once "cep.class.php";
require_once "mantis.class.php";
require_once "servicossite.class.php";
require_once "pagamentos.class.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = $_POST['id'];
}   

switch ($id) {
    case "experimentar":
        Experimentar();
        break;
    case "testar_sistema":
        Cadastro("testar_sistema");
        break;
    case "orcamento":
        Cadastro("orcamento");
        break;
    case "interessado":
        Cadastro("interessado");
        break;

    // Site
    case "interessado-testesistema":
        CadastroInteressado("testesistema");
        break;
    case "interessado-orcamento":
        CadastroInteressado("orcamento");
        break;
    case "orcamento-teste":
        OrcamentoTeste();
        break;
    case "faleconosco":
        FaleConosco();
        break;
    case "agente_negocios":
        AgenteNegocios();
        break;
    case "cadastro_videos":
        CadastroVideos();
        break;
    case "autentica_satisfacao":
        Login('http://painel.mail2easy.com/p/18294/20/37189/b4c6a');
        break;

    /* Ligamos para você */
    case "ligamos":
        Ligamos();
        break;

    /* HotSite - Nota Fiscal Eletrônica */
    case "baixarNFE":
        BaixarNFE();
        break;
    case "assinarNFE":
        AssinarNFE();
        break;

    /* Contrato - Pagamento com cartão */
    case "pagamento":
        PagamentoCartao();
        break;

    /* Pesquisa Avaliação de Suporte */
    case "avaliacao_suporte":
        AvaliacaoSuporte();
        break;

    /* Pesquisa Remarketing */
    case "formulario_remarketing":
        FormularioRemarketing();
        break;

    /* Pesquisa Homologação do Treinamento */
    case "formulario_homologacao":
        FormularioHomologacao();
        break;

    /* Pesquisa SAC */
    case "formulario_sac":
        FormularioSAC();
        break;

    /* Pesquisa Pós-vendas */
    case "login_posvendas":
        LoginPosVendas();
        break;
    case "formulario_posvendas":
        FormularioPosVendas();
        break;

    // Pesquisa de Satisfação
    case "pesquisa_satisfacao":
        PesquisaSatisfacao();
        break;
}

//---------------------------------------------------------------------------
function Experimentar() {
    session_start();

    $email = strtolower($_POST['email']);
    $_SESSION['email'] = $email;
    $ip = IPCliente();

    $query = "INSERT INTO experimentar (email, ip, datahora) VALUES ('%s', '%s', NOW())";
    $query = sprintf($query, addslashes($email), addslashes($ip));
    $inseriu = SingleQuery($query);

    GotoPage("testar-sistema");
}
//---------------------------------------------------------------------------
function Cadastro($tipo) {    
    session_start();

    $segmento = ToUTF8($_POST['segmento']);
    $comoconheceu = ToUTF8($_POST['comoconheceu']);
    $email = strtolower($_POST['email']);
    $nome = TitleCase(ToISO8859($_POST['nome']), "");
    $nome = ToUTF8($nome);
    $telefone = $_POST['telefone'];     

    if($tipo == "testar_sistema") { 
        $celular = $_POST['celular'];
        $interesse = "";        
        $cidade = "";
        $estado = "";  
    } else if($tipo == "orcamento") {
        $celular = $_POST['celular'];
        $interesse = ToUTF8($_POST['interesse']);
        $cidade = TitleCase(ToISO8859($_POST['cidade']), "");
        $cidade = ToUTF8($cidade);
        $estado = strtoupper($_POST['estado']);
    } else if($tipo == "interessado") {
        $celular = "";
        $interesse = ToUTF8($_POST['interesse']);
        $cidade = "";
        $estado = "";
    }

    $_SESSION['cadastro']['segmento'] = $segmento;
    $_SESSION['cadastro']['comoconheceu'] = $comoconheceu;
    $_SESSION['cadastro']['email'] = $email;
    $_SESSION['cadastro']['nome'] = $nome;
    $_SESSION['cadastro']['telefone'] = $telefone;
    $_SESSION['cadastro']['celular'] = $celular;
    $_SESSION['cadastro']['interesse'] = $interesse;    
    $_SESSION['cadastro']['cidade'] = $cidade;
    $_SESSION['cadastro']['estado'] = $estado;

    if($_POST['segmento'] == "" || $_POST['email'] == "" || $_POST['nome'] == "") {
        VoltaMensagem("Preencha todos os campos obrigatórios.", "alert alert-danger");
    }

    if($tipo == "orcamento") {
        if($interesse == "" || $comoconheceu == "") {
            VoltaMensagem("Preencha todos os campos obrigatórios.", "alert alert-danger");
        }
    }

    if($tipo == "orcamento" || $tipo == "testar_sistema") {
        // Valida o número de telefone/celular.
        if((empty(LimpaMascara($telefone)) || LimpaMascara($telefone) == "") && (empty(LimpaMascara($celular)) || LimpaMascara($celular) == "")) {
            VoltaMensagem("Informe um telefone ou celular.", "alert alert-danger");
        }
    }

    if($telefone == '(00) 0000-0000' || $telefone == '0000000000' || $telefone == '(00) 00000-0000' || $telefone == '00000000000') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(11) 1111-1111' || $telefone == '1111111111' || $telefone == '(11) 11111-1111' || $telefone == '11111111111') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(22) 2222-2222' || $telefone == '2222222222' || $telefone == '(22) 22222-2222' || $telefone == '22222222222') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(33) 3333-3333' || $telefone == '3333333333' || $telefone == '(33) 33333-3333' || $telefone == '33333333333') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(44) 4444-4444' || $telefone == '4444444444' || $telefone == '(44) 44444-4444' || $telefone == '44444444444') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(55) 5555-5555' || $telefone == '5555555555' || $telefone == '(55) 55555-5555' || $telefone == '55555555555') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(66) 6666-6666' || $telefone == '6666666666' || $telefone == '(66) 66666-6666' || $telefone == '66666666666') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(77) 7777-7777' || $telefone == '7777777777' || $telefone == '(77) 77777-7777' || $telefone == '77777777777') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(88) 8888-8888' || $telefone == '8888888888' || $telefone == '(88) 88888-8888' || $telefone == '88888888888') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(99) 9999-9999' || $telefone == '9999999999' || $telefone == '(99) 99999-9999' || $telefone == '99999999999') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    }

    if($segmento == 'Indústria de Plásticos') {
        $cod_segmento = "D8";
        $_SESSION['cadastro']['segmento'] = "D8";
    } 
    else if($segmento == 'Indústria Metalúrgica') {
        $cod_segmento = "14";
        $_SESSION['cadastro']['segmento'] = "14";
    } 
    else if($segmento == 'Indústria Alimentícia') {
        $cod_segmento = "4";
        $_SESSION['cadastro']['segmento'] = "4";
    } 
    else if($segmento == 'Indústria Química') {
        $cod_segmento = "15";
        $_SESSION['cadastro']['segmento'] = "15";
    } 
    else if($segmento == 'Indústria de Embalagens') {
        $cod_segmento = "7";
        $_SESSION['cadastro']['segmento'] = "7";
    } 
    else if($segmento == 'Indústria Textil') {
        $cod_segmento = "21";
        $_SESSION['cadastro']['segmento'] = "21";
    } 
    else if($segmento == 'Indústria (outras)') {
        $cod_segmento = "IN";
        $_SESSION['cadastro']['segmento'] = "IN";
    } 
    else if($segmento == 'Transportadora') {
        $cod_segmento = "77";
        $_SESSION['cadastro']['segmento'] = "77";
    } 
    else if($segmento == 'Empresa prestadora de serviço') {
        $cod_segmento = "SE";
        $_SESSION['cadastro']['segmento'] = "SE";
    } 
    else if($segmento == 'Comércio Varejista') {
        $cod_segmento = "A2";
        $_SESSION['cadastro']['segmento'] = "A2";
    } 
    else if($segmento == 'Comércio Atacadista') {
        $cod_segmento = "94";
        $_SESSION['cadastro']['segmento'] = "94";
    } 
    else if($segmento == 'Distribuidora') {
        $cod_segmento = "00";
        $_SESSION['cadastro']['segmento'] = "00";
    } 
    else if($segmento == 'Escritório de Contabilidade') {
        $cod_segmento = "82";
        $_SESSION['cadastro']['segmento'] = "82";
    }
    else if($segmento == 'Agronegócio') {
        $cod_segmento = "97";
        $_SESSION['cadastro']['segmento'] = "97";
    }
    else if($segmento == 'Construtora') {
        $cod_segmento = "19";
        $_SESSION['cadastro']['segmento'] = "19";
    }

    if($comoconheceu == 'Indicação (Agente de Negócios)') {
        $cod_comoconheceu = "52";
        $_SESSION['cadastro']['comoconheceu'] = "52";
    }
    else if($comoconheceu == 'Indicação (Clientes)') {
        $cod_comoconheceu = "02";
        $_SESSION['cadastro']['comoconheceu'] = "02";
    } 
    else if($comoconheceu == 'CRC SP') {
        $cod_comoconheceu = "01";
        $_SESSION['cadastro']['comoconheceu'] = "01";
    } 
    else if($comoconheceu == 'Google') {
        $cod_comoconheceu = "06";
        $_SESSION['cadastro']['comoconheceu'] = "06";
    } 
    else if($comoconheceu == 'Redes Sociais') {
        $cod_comoconheceu = "34";
        $_SESSION['cadastro']['comoconheceu'] = "34";
    }
    else if($comoconheceu == 'Blog da SuperSoft') {
        $cod_comoconheceu = "17";
        $_SESSION['cadastro']['comoconheceu'] = "17";
    } 
    else if($comoconheceu == 'Fórum Contábeis') {
        $cod_comoconheceu = "29";
        $_SESSION['cadastro']['comoconheceu'] = "29";
    }

    if($tipo == "testar_sistema") {
        $origem = "Teste Grátis";
    } else if($tipo == "orcamento") {
        $origem = "Orçamento";
    } else if($tipo == "interessado") {
        $origem = "Ficou interessado";
    }

    $mysql = new BaseSite();

    $ip = IPCliente();      
    $query  = "INSERT INTO orcamentos (origem, segmento, interesse, comoconheceu, email, nome, telefone, celular, cidade, estado, ip, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($origem),
                             addslashes($segmento), 
                             addslashes($interesse), 
                             addslashes($comoconheceu),
                             addslashes($email),
                             addslashes($nome),
                             addslashes($telefone),
                             addslashes($celular),
                             addslashes($cidade),
                             addslashes($estado),
                             $ip);
    $inseriu_bd = $mysql->Query($query);

    $_SESSION['cadastro']['id'] = $mysql->UltimoID();

    if($inseriu_bd) {
        $queryVerificacao = "DELETE FROM experimentar WHERE email='$email'";
        $mysql->Query($queryVerificacao);
    }
    
    unset($mysql);

    // Verifica se o interessado já possui cadastro no Vendas.
    $ws = ConectaWSSupersoft();
    $existe = $ws->ExisteCadastro(CHAVE_REQUISICAO, $email);

    // Se não tiver cadastro, grava na base.
    if(!$existe) {
        $cadastro = $_SESSION['cadastro'];
        ArrayToUTF8($cadastro);
        $inseriu_ws = $ws->CadastraInteressadoNovo(CHAVE_REQUISICAO, $cadastro);
    } else {
        $inseriu_ws = TRUE;
    }
    DesconectaWSSupersoft($ws);

    // Envia e-mail aos responsáveis. 
    if($tipo == "testar_sistema") {
        // E-mail de aviso ao Comercial/Marketing.
        $modelo = file_get_contents(PATH_SITE . "modelos/e-mail/aviso_teste_gratis.html");
        $modelo = str_replace("[#SEGMENTO]", $segmento, $modelo);
        $modelo = str_replace("[#NOME]", $nome, $modelo);
        $modelo = str_replace("[#EMAIL]", $email, $modelo);
        $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
        $modelo = str_replace("[#CELULAR]", $celular, $modelo);
        Email::Enviar(REMETENTE_TESTE_GRATIS_NOME, REMETENTE_TESTE_GRATIS, DESTINATARIOS_TESTE_GRATIS, ASSUNTO_TESTE_GRATIS.$nome, ToISO8859($modelo));

        // E-mail de boas-vindas.
        $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/boasvindas_teste.html");
        $modelo_bv = str_replace("[#NOME]", $nome, $modelo_bv);
        $modelo_bv = str_replace("[#EMAIL]", $email, $modelo_bv);
        Email::Enviar(REMETENTE_BOAS_VINDAS_NOME, REMETENTE_BOAS_VINDAS, $email, ASSUNTO_BOAS_VINDAS_TESTE_GRATIS, ToISO8859($modelo_bv));
    } else if($tipo == "orcamento") {
        // E-mail de aviso ao Comercial/Marketing.
        $modelo = file_get_contents(PATH_SITE . "modelos/e-mail/aviso_orcamento.html");
        $modelo = str_replace("[#SEGMENTO]", $segmento, $modelo);
        $modelo = str_replace("[#INTERESSE]", $interesse, $modelo);
        $modelo = str_replace("[#CONHECEU]", $comoconheceu, $modelo);
        $modelo = str_replace("[#NOME]", $nome, $modelo);
        $modelo = str_replace("[#EMAIL]", $email, $modelo);
        $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
        $modelo = str_replace("[#CELULAR]", $celular, $modelo);
        $modelo = str_replace("[#CIDADE]", $cidade, $modelo);        
        $modelo = str_replace("[#ESTADO]", $estado, $modelo);
        Email::Enviar(REMETENTE_ORCAMENTO_NOME, REMETENTE_ORCAMENTO, DESTINATARIOS_ORCAMENTO, ASSUNTO_ORCAMENTO.$nome, ToISO8859($modelo));

        // E-mail de boas-vindas.
        $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/boasvindas.html");
        $modelo_bv = str_replace("[#NOME]", $nome, $modelo_bv);     
        Email::Enviar(REMETENTE_BOAS_VINDAS_NOME, REMETENTE_BOAS_VINDAS, $email, ASSUNTO_BOAS_VINDAS_ORCAMENTO, ToISO8859($modelo_bv));
    } else if($tipo == "interessado") {
        // E-mail de aviso ao Comercial/Marketing.
        $modelo = file_get_contents(PATH_SITE . "modelos/e-mail/aviso_interessado.html");
        $modelo = str_replace("[#SEGMENTO]", $segmento, $modelo);
        $modelo = str_replace("[#INTERESSE]", $interesse, $modelo);
        $modelo = str_replace("[#NOME]", $nome, $modelo);
        $modelo = str_replace("[#EMAIL]", $email, $modelo);
        $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
        Email::Enviar(REMETENTE_INTERESSADO_NOME, REMETENTE_INTERESSADO, DESTINATARIOS_INTERESSADO, ASSUNTO_INTERESSADO.$nome, ToISO8859($modelo));

        // E-mail de boas-vindas.
        $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/boasvindas.html");
        $modelo_bv = str_replace("[#NOME]", $nome, $modelo_bv);     
        Email::Enviar(REMETENTE_BOAS_VINDAS_NOME, REMETENTE_BOAS_VINDAS, $email, ASSUNTO_BOAS_VINDAS_INTERESSADO, ToISO8859($modelo_bv));
    }

    if($inseriu_bd && $inseriu_ws) {
        unset($_SESSION['cadastro']);
        unset($_SESSION['email']);

        if($tipo == "testar_sistema") {
            $_SESSION['teste_finalizado'] = TRUE;
            $_SESSION['testesistema']['cliente'] = $email;
            GotoPage("teste-os-sistemas");
        } else if ($tipo == "orcamento") {
            $_SESSION['orcamento_finalizado'] = TRUE;
            SetaMensagem("Proposta recebida com sucesso! Em breve entraremos em contato.", "alert alert-success");
            GotoPage("orcamento");
        } else if($tipo == "interessado") {
            $_SESSION['interessado'] = TRUE;
            
            VoltaMensagem("Dados recebidos com sucesso! Em breve entraremos em contato.", "alert alert-success");
        }
    } else {
        VoltaMensagem("Algo deu errado! Tente novamente.", "alert alert-danger");
    }
}
//---------------------------------------------------------------------------
function CadastroInteressado($tipo) {
    global $Segmentos, $Midias;
    
    session_start();
    $_SESSION['orcamento']['sistema'] = $_POST['sistema'];
    $_SESSION['orcamento']['segmento'] = $_POST['segmento'];
    $_SESSION['orcamento']['nome'] = $_POST['nome'];
    $_SESSION['orcamento']['empresa'] = $_POST['empresa'];
    $_SESSION['orcamento']['email'] = $_POST['email'];
    $_SESSION['orcamento']['telefone'] = $_POST['telefone'];
    $_SESSION['orcamento']['celular'] = $_POST['celular'];
    $_SESSION['orcamento']['comoconheceu'] = $_POST['comoconheceu'];
    $_SESSION['orcamento']['reccontato'] = $_POST['reccontato'];
    $_SESSION['orcamento']['cpfcnpj'] = $_POST['cpfcnpj'];
    $_SESSION['orcamento']['cidade'] = $_POST['cidade'];
    $_SESSION['orcamento']['estado'] = $_POST['estado'];
    
    $cpfcnpj = $_POST['cpfcnpj'];
    if (($cpfcnpj == "") || (!ValidaCPFCNPJ(LimpaMascara($cpfcnpj))))
        VoltaMensagem("CPF/CNPJ inválido.", "alert alert-danger");

    if($_POST['segmento'] == "" || $_POST['nome'] == "" || $_POST['telefone'] == "" || $_POST['email'] == "" || $_POST['num_funcionarios'] == "" || $_POST['comoconheceu'] == "" || $_POST['utiliza_sistema'] == "" || $_POST['reccontato'] == "") {
        VoltaMensagem("Preencha todos os campos obrigatórios.", "alert alert-danger");
    }

    $cpfcnpj = SetaMascaraCPFCNPJ($cpfcnpj);

    $telefone = $_POST['telefone'];

    if($telefone == '(00)0000-0000' || $telefone == '0000000000' || $telefone == '(00)00000-0000' || $telefone == '00000000000') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(11)1111-1111' || $telefone == '1111111111' || $telefone == '(11)11111-1111' || $telefone == '11111111111') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(22)2222-2222' || $telefone == '2222222222' || $telefone == '(22)22222-2222' || $telefone == '22222222222') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(33)3333-3333' || $telefone == '3333333333' || $telefone == '(33)33333-3333' || $telefone == '33333333333') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(44)4444-4444' || $telefone == '4444444444' || $telefone == '(44)44444-4444' || $telefone == '44444444444') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(55)5555-5555' || $telefone == '5555555555' || $telefone == '(55)55555-5555' || $telefone == '55555555555') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(66)6666-6666' || $telefone == '6666666666' || $telefone == '(66)66666-6666' || $telefone == '66666666666') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(77)7777-7777' || $telefone == '7777777777' || $telefone == '(77)77777-7777' || $telefone == '77777777777') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(88)8888-8888' || $telefone == '8888888888' || $telefone == '(88)88888-8888' || $telefone == '88888888888') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    } else if($telefone == '(99)9999-9999' || $telefone == '9999999999' || $telefone == '(99)99999-9999' || $telefone == '99999999999') {
        VoltaMensagem("Número de telefone inválido.", "alert alert-danger");
    }

    if ($_POST['segmento'] == "")
        VoltaMensagem("Selecione o segmento da sua empresa.", "alert alert-danger");

    $segmento = ToUTF8($_POST['segmento']);
    if($segmento == 'Indústria de Plásticos') {
        $cod_segmento = "D8";
        $_SESSION['orcamento']['segmento'] = "D8";
    } 
    else if($segmento == 'Indústria Metalúrgica') {
        $cod_segmento = "14";
        $_SESSION['orcamento']['segmento'] = "14";
    } 
    else if($segmento == 'Indústria Alimentícia') {
        $cod_segmento = "4";
        $_SESSION['orcamento']['segmento'] = "4";
    } 
    else if($segmento == 'Indústria Química') {
        $cod_segmento = "15";
        $_SESSION['orcamento']['segmento'] = "15";
    } 
    else if($segmento == 'Indústria de Embalagens') {
        $cod_segmento = "7";
        $_SESSION['orcamento']['segmento'] = "7";
    } 
    else if($segmento == 'Indústria Textil') {
        $cod_segmento = "21";
        $_SESSION['orcamento']['segmento'] = "21";
    } 
    else if($segmento == 'Indústria (outras)') {
        $cod_segmento = "IN";
        $_SESSION['orcamento']['segmento'] = "IN";
    } 
    else if($segmento == 'Transportadora') {
        $cod_segmento = "77";
        $_SESSION['orcamento']['segmento'] = "77";
    } 
    else if($segmento == 'Empresa prestadora de serviço') {
        $cod_segmento = "SE";
        $_SESSION['orcamento']['segmento'] = "SE";
    } 
    else if($segmento == 'Comércio Varejista') {
        $cod_segmento = "A2";
        $_SESSION['orcamento']['segmento'] = "A2";
    } 
    else if($segmento == 'Comércio Atacadista') {
        $cod_segmento = "94";
        $_SESSION['orcamento']['segmento'] = "94";
    } 
    else if($segmento == 'Distribuidora') {
        $cod_segmento = "00";
        $_SESSION['orcamento']['segmento'] = "00";
    } 
    else if($segmento == 'Escritório de Contabilidade') {
        $cod_segmento = "82";
        $_SESSION['orcamento']['segmento'] = "82";
    }
    else if($segmento == 'Agronegócio') {
        $cod_segmento = "97";
        $_SESSION['orcamento']['segmento'] = "97";
    }
    else if($segmento == 'Construtora') {
        $cod_segmento = "19";
        $_SESSION['orcamento']['segmento'] = "19";
    }

    $comoconheceu = ToUTF8($_POST['comoconheceu']);
    if($comoconheceu == 'Indicação') {
        $cod_comoconheceu = "02";
        $_SESSION['orcamento']['comoconheceu'] = "02";
    } 
    else if($comoconheceu == 'CRC SP') {
        $cod_comoconheceu = "01";
        $_SESSION['orcamento']['comoconheceu'] = "01";
    } 
    else if($comoconheceu == 'Google') {
        $cod_comoconheceu = "06";
        $_SESSION['orcamento']['comoconheceu'] = "06";
    } 
    else if($comoconheceu == 'Facebook') {
        $cod_comoconheceu = "34";
        $_SESSION['orcamento']['comoconheceu'] = "34";
    } 
    else if($comoconheceu == 'Fórum Contábeis') {
        $cod_comoconheceu = "29";
        $_SESSION['orcamento']['comoconheceu'] = "29";
    }

    $ip = IPCliente();
    if(!empty($_POST['sistema'])) {
        $sistemas = implode(",", $_POST['sistema']);
    } else {
        $sistemas = "";
    }       
    $query = "INSERT INTO orcamentos (numero, nome, empresa, email, telefone, celular, conheceu, cidade, estado, reccontato, sistemas, segmento, ip, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($cpfcnpj), 
                             addslashes($_POST['nome']), 
                             addslashes($_POST['empresa']),
                             addslashes($_POST['email']),
                             addslashes($_POST['telefone']),
                             addslashes($_POST['celular']),
                             addslashes($cod_comoconheceu),
                             addslashes($_POST['cidade']),
                             addslashes($_POST['estado']),
                             addslashes($_POST['reccontato']),
                             addslashes($sistemas),
                             addslashes($cod_segmento),
                             $ip);
    $mysql = new BaseSite();
    $res = $mysql->Query($query);
    $_SESSION['orcamento']['_ID'] = $mysql->UltimoID();
    unset($mysql);

    // Envia e-mail para os deptos. responsáveis.
    $destinatario = LeConfig('email_orcamento');
    $destinatario_marketing = LeConfig('email_orcamento_marketing');
    if ($cod_segmento == '82') {
        if ($destinatario != "")
            $destinatario .= ",";
        $destinatario .= LeConfig('email_orcamento_contabil') . "," . LeConfig('email_comercial_gerente');
    }
    $destinatario_arr = explode(",", $destinatario);
    $destinatario_arr = array_unique($destinatario_arr);
    $destinatario = implode(",", $destinatario_arr);

    $campos = array(
        'SEGMENTO' => $cod_segmento,
        'NOME' => $_POST['nome'],
        'EMPRESA' => $_POST['empresa'],
        'EMAIL' => $_POST['email'],
        'TELEFONE' => $_POST['telefone'],
        'CELULAR' => $_POST['celular'],
        'CONHECEU' => $comoconheceu,
        'ATEDIMENTO' => $_POST['reccontato'],
        'SISTEMAS' => $sistemas,
        'INTERESSADO' => $_POST['nome'] // Será inserido no assunto do e-mail.
    );
    
    // Cadastra na base de dados.
    $ws = ConectaWSSupersoft();
    $cadastro = $_SESSION['orcamento'];
    ArrayToUTF8($cadastro);
    $cadastrou = $ws->CadastraInteressado(CHAVE_REQUISICAO, $cadastro);
    DesconectaWSSupersoft($ws);
    
    if ($tipo == "testesistema") {
        $mod = 'TESTAR_SISTEMA';
    } else if ($tipo == "orcamento") {
        $mod = 'ORCAMENTO';
    } else {
        $mod = 'ORCAMENTO';
    }       
    
    // E-mail para o comercial.
    DisparaEmailModelo($mod, $destinatario, $campos);
    
    // E-mail para o marketing.
    DisparaEmailModelo($mod, $destinatario_marketing, $campos);
    
    // E-mail de boas-vindas.  
    if($tipo == "testesistema") {
        $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/boasvindas_teste.html");
        $modelo_bv = str_replace("[#NOME]", TitleCase(ToUTF8($_POST['nome']), ""), $modelo_bv);
        $modelo_bv = str_replace("[#CPFCNPJ]", $cpfcnpj, $modelo_bv);
        Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", $_POST['email'], "Teste já os sistemas da SuperSoft Sistemas", ToISO8859($modelo_bv));
    } else if($tipo == "orcamento") {
        $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/boasvindas.html");
        $modelo_bv = str_replace("[#NOME]", TitleCase(ToUTF8($_POST['nome']), ""), $modelo_bv);     
        Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", $_POST['email'], "Orçamento - SuperSoft Sistemas", ToISO8859($modelo_bv));
    }    

    unset($_SESSION['orcamento']);

    if($tipo == "testesistema") {
        $_SESSION['teste_finalizado'] = TRUE;
        $_SESSION['testesistema']['cpfcnpj'] = $cpfcnpj;
        GotoPage("teste-os-sistemas");
    } else if ($tipo == "orcamento") {
        $_SESSION['orcamento_finalizado'] = TRUE;
        SetaMensagem("Seu pedido de orçamento foi enviado com sucesso! Em breve entraremos em contato.", "alert alert-success");
        GotoPage("orcamento");
    } else {
        VoltaMensagem("Algo deu errado! Tente novamente.", "alert alert-danger");
    }
}
//---------------------------------------------------------------------------
function OrcamentoTeste() {    
    session_start();

    $_SESSION['orcamento']['segmento'] = $_POST['segmento'];
    $_SESSION['orcamento']['nome'] = $_POST['nome'];
    $_SESSION['orcamento']['email'] = $_POST['email'];
    $_SESSION['orcamento']['telefone'] = $_POST['telefone'];
    $_SESSION['orcamento']['cidade'] = $_POST['cidade'];

    if ($_POST['segmento'] == "")
        VoltaMensagem("Selecione o segmento da sua empresa.", "alert alert-danger");

    $ip = IPCliente();       
    $query = "INSERT INTO orcamento_teste (nome, email, telefone, cidade, segmento, ip, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($_POST['nome']), 
                             addslashes($_POST['email']),
                             addslashes($_POST['telefone']),
                             addslashes($_POST['cidade']),
                             addslashes($_POST['segmento']),
                             $ip);
    $mysql = new BaseSite();
    $res = $mysql->Query($query);
    $_SESSION['orcamento']['_ID'] = $mysql->UltimoID();
    unset($mysql);

    // Envia e-mail para os deptos. responsáveis.
    $destinatario = LeConfig('email_orcamento');
    $destinatario_marketing = LeConfig('email_orcamento_marketing');
    if ($_POST['segmento'] == '82') {
        if ($destinatario != "")
            $destinatario .= ",";
        $destinatario .= LeConfig('email_orcamento_contabil') . "," . LeConfig('email_comercial_gerente');
    }
    $destinatario_arr = explode(",", $destinatario);
    $destinatario_arr = array_unique($destinatario_arr);
    $destinatario = implode(",", $destinatario_arr);

    $campos = array(
        'SEGMENTO' => $Segmentos[$_POST['segmento']],
        'NOME' => $_POST['nome'],
        'EMAIL' => $_POST['email'],
        'TELEFONE' => $_POST['telefone'],
        'SISTEMAS' => $sistemas,
        'INTERESSADO' => $_POST['nome'] // Será inserido no assunto do e-mail.
    );

    $mod = 'ORCAMENTO';    
    
    // E-mail para o comercial.
    DisparaEmailModelo($mod, $destinatario, $campos);
    
    // E-mail para o marketing.
    DisparaEmailModelo($mod, $destinatario_marketing, $campos);
    
    // E-mail de boas-vindas.  
    $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/boasvindas.html");
    $modelo_bv = str_replace("[#NOME]", TitleCase(ToUTF8($_POST['nome']), ""), $modelo_bv);     
    Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", $_POST['email'], "Orçamento - SuperSoft Sistemas", ToISO8859($modelo_bv));
 
    unset($_SESSION['orcamento']);

    SetaMensagem("Seu pedido de orçamento foi enviado com sucesso! Em breve entraremos em contato.", "alert alert-success");
    VoltarPaginaAnterior();
}
//---------------------------------------------------------------------------
function FaleConosco() {
    $nome = TitleCase(ToISO8859($_POST['nome']), "");
    $nome = ToUTF8($nome);
    $cpfcnpj = $_POST['cpfcnpj'];
    $email = strtolower($_POST['email']);
    $telefone = $_POST['telefone'];
    $cidade = TitleCase(ToISO8859($_POST['cidade']), "");
    $cidade = ToUTF8($cidade);
    $estado = strtoupper($_POST['estado']);
    $mensagem = ToUTF8($_POST['mensagem']);

    if($cpfcnpj == "") {
        $cpfcnpj_bd = "";
        $cpfcnpj_email = "Não informado";
    } else {
        $cpfcnpj_bd = SetaMascaraCPFCNPJ($_POST['cpfcnpj']);
        $cpfcnpj_email = SetaMascaraCPFCNPJ($_POST['cpfcnpj']);
    }

    $ip = IPCliente();
    $query = "INSERT INTO faleconosco (nome, cpfcnpj, email, telefone, cidade, estado, mensagem, ip, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($nome),
                             addslashes($cpfcnpj_bd),
                             addslashes($email),
                             addslashes($telefone),
                             addslashes($cidade),
                             addslashes($estado),
                             addslashes($mensagem),
                             $ip);
    SingleQuery($query);

    // Envia e-mail para os deptos. responsáveis.
    $destinatario = LeConfig('email_faleconosco');
    $campos = array(
        'NOME' => $_POST['nome'], // Será inserido no assunto do e-mail.
        'CPFCNPJ' => $cpfcnpj_email,
        'EMAIL' => $_POST['email'],
        'TELEFONE' => $_POST['telefone'],
        'CIDADE' => $_POST['cidade'],
        'ESTADO' => $_POST['estado'],
        'MENSAGEM' => nl2br($_POST['mensagem'])
    );
    $disparou = DisparaEmailModelo('FALECONOSCO', $destinatario, $campos);

    if($disparou) {
        VoltaMensagem("Mensagem recebida com sucesso! Em breve entraremos em contato.", "alert alert-success");
    } else {
        VoltaMensagem("Algo deu errado! Tente novamente.", "alert alert-danger");
    }    
}
//---------------------------------------------------------------------------
function PagamentoCartao() {
    // MD5 enviado com o formulário
    $param_md5 = $_POST['md5'];

    // Abre conexão com a base de dados
    $mysql = new BaseSite();

    // Busca as informações do cliente na base de dados a partir do contrato
    $query  = "SELECT id_contrato, cpf_rg, razaosoc_nome, endereco, bairro, cidade, estado, cep, email, telefone, valor_cartao";
    $query .= " FROM contratos";
    $query .= " WHERE param_md5='".$param_md5."'";
    $contrato = $mysql->Query($query);

    // Se não encontrar nada vai pra home do site
    if(empty($contrato)) {
        GotoPage("home");
    }

    // Seta as informações nas variáveis
    $num_contrato = $contrato[0]->id_contrato;
    $cpfcnpj = $contrato[0]->cpf_rg;
    $razsoc_nome = ToUTF8($contrato[0]->razaosoc_nome);
    $endereco = $contrato[0]->endereco;
    $bairro = $contrato[0]->bairro;
    $cidade = $contrato[0]->cidade;
    $estado = $contrato[0]->estado;
    $cep = $contrato[0]->cep;
    $telefone = $contrato[0]->telefone;
    $email = $contrato[0]->email;
    $valor = $contrato[0]->valor_cartao;
    
    // Reserva a sequencia de pagto.
    if(!isset($_SESSION['pagto']['sequencia'])) {
        $query = "SELECT MAX(sequencia) AS sequencia FROM superpay_sequencia_pagtos";
        $res = $mysql->Query($query);
        $sequencia_pagto = $res[0]->sequencia + 1;
        $_SESSION['pagto']['sequencia'] = $sequencia_pagto;
        
        $query  = "INSERT INTO superpay_sequencia_pagtos (sequencia, cliente, faturas, datahora) ";
        $query .= "VALUES (".$sequencia_pagto.", '".$cpfcnpj."', 'Contrato $num_contrato', NOW())";
        $mysql->Query($query);       
    }
    
    $numCompra = $_SESSION['pagto']['sequencia'];

    // Salva em sessão os dados digitados pelo cliente sobre o cartão.
    $_SESSION['pagto']['pagto'] = $_POST['pagto'];
    $_SESSION['pagto']['numero'] = LimpaMascara($_POST['numero']);
    $_SESSION['pagto']['mes'] = $_POST['mes'];
    $_SESSION['pagto']['ano'] = $_POST['ano'];
    $_SESSION['pagto']['nome'] = ToUTF8($_POST['nome']);
    $_SESSION['pagto']['codigo'] = $_POST['codigo'];

    $forma_pagto = $_SESSION['pagto']['pagto'];
    $numero_cartao = $_SESSION['pagto']['numero'];
    $venccartao_mes = $_SESSION['pagto']['mes'];
    $venccartao_ano = $_SESSION['pagto']['ano'];
    $nomecartao = $_SESSION['pagto']['nome'];
    $codseg_cartao = $_SESSION['pagto']['codigo'];
    $formapagto = $_SESSION['pagto']['pagto'];

    // Verifica se existe algum campo vazio.
    if((empty($numero_cartao) || $numero_cartao == "") || (empty($venccartao_mes) || $venccartao_mes == "") || (empty($venccartao_ano) || $venccartao_ano == "") || (empty($nomecartao) || $nomecartao == "") || (empty($codseg_cartao) || $codseg_cartao == "")) {
        unset($mysql);
        VoltaMensagem("Todos os campos são obrigatórios.","alert alert-danger");
    }

    if($forma_pagto == "mastercard") {
        $bandeira = "Master";
    } else if($forma_pagto == "visa") {
        $bandeira = "Visa";
    }

    // Valida o número do cartão de crédito.
    //if(!ValidaCartaoCredito($numero_cartao, $bandeira)) {
    //    unset($mysql);
    //    VoltaMensagem("Número de cartão inválido.","alert alert-danger");
    //}

    // Verifica se o código de segurança tem 3 digitos.
    if(strlen($codseg_cartao) < 3 || strlen($codseg_cartao) > 3) {
        unset($mysql);
        VoltaMensagem("Código de segurança inválido.","alert alert-danger");
    }    
    
    // Processa os pagamentos
    require_once "pagamentos.class.php";    
    if(($formapagto == "mastercard") || ($formapagto == "visa")) {
        $descricao_str = "Adesão do contrato: ".$num_contrato;
        $compra = array();
        $compra['bandeira'] = $formapagto;
        $compra['cliente'] = $cpfcnpj;
        $compra['numcartao'] = $numero_cartao;
        $compra['validade'] = $venccartao_mes.$venccartao_ano;
        $compra['nome'] = strtoupper($nomecartao);
        $compra['codseguranca'] = $codseg_cartao;
        $compra['parcelas'] = 1; // Sempre o valor à vista
        $compra['valor'] = number_format($valor, 2, ".", "");
        //$compra['valor'] = 0.01;
        $compra['compra'] = $numCompra;
        $compra['descricao'] = $descricao_str;

        $dadosusuario = new stdClass();
        $dadosusuario->RAZSOC = $razsoc_nome;
        $dadosusuario->ENDERECO = $endereco;
        $dadosusuario->CEP = $cep;
        $dadosusuario->BAIRRO = $bairro;
        $dadosusuario->CID = $cidade;
        $dadosusuario->EST = $estado;

        // Se foi setada a sessão "aprovado" é que algo deu errado
        // e o cliente teve que reenviar o formulário.
        if(!isset($_SESSION['aprovado']))
           $Aprovou = Pagamentos::PagamentoCartao($cpfcnpj, $compra, $dadosusuario);
 
		// Se não foi aprovado retorna mensagem de erro.
        if($Aprovou !== TRUE) {
            unset($mysql);
            VoltaMensagem("Pagamento não autorizado.", "alert alert-danger");
        } else {
            $_SESSION['aprovado'] = TRUE; // Se foi aprovado salva na sessão.
            $_SESSION['finalizado']['num_contrato'] = $num_contrato;
            $_SESSION['finalizado']['valor'] = $valor;
        }

        // Grava a compra na base de dados.
        $query_pgto  = "INSERT INTO contratos_pagamentos (contrato, cpfcnpj, valor, bandeira, datahora) ";
        $query_pgto .= "VALUES ('%s','%s','%s','%s',NOW())";
        $query_pgto  = sprintf($query_pgto, addslashes($num_contrato), addslashes($cpfcnpj), addslashes($valor), addslashes($formapagto));
        $gravou = $mysql->Query($query_pgto);
        
        // Registra o pagto no Sitema Financeiro no WS da SS.
        $ws = ConectaWSSupersoft();
        $registrou = $ws->PagtoContrato($cpfcnpj, $num_contrato, $valor, $formapagto);
        DesconectaWSSupersoft($ws);

        // Verifica se não ocorreu erro ao salvar na base de dados e WS.
        if(!$gravou || !$registrou) {
            unset($mysql);
            VoltaMensagem("Erro interno, tente novamente.", "alert-danger");
        }
        
        // Prepara os campos dos e-mails de notificação.
        $datahora = date("d/m/Y H:i:s");  
        $modelo = file_get_contents(PATH_SITE . "modelos/e-mail/pagto_cartao.html");
        $modelo = str_replace("[#NOME]", $razsoc_nome, $modelo);
        $modelo = str_replace("[#CPFCNPJ]", $cpfcnpj, $modelo);
        $modelo = str_replace("[#NUMCONTRATO]", $num_contrato, $modelo);
        $modelo = str_replace("[#VALOR]", "R$ ".number_format($valor, 2, ",", "."), $modelo);
        $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
        $modelo = str_replace("[#DATAHORA]", $datahora, $modelo);
        
        // Envia e-mail para o Depto. Comercial (Daniel M.)
        $enviou_COM = Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", "daniel@nooven.com.br", "Confirmação de pagamento de contrato", ToISO8859($modelo));

        // Prepara os campos para enviar o e-mail 
        $modelo_bv = file_get_contents(PATH_SITE."modelos/e-mail/confirma_pagto.html");
        $modelo_bv = str_replace("[#NOME]", $razsoc_nome, $modelo_bv);
        $modelo_bv = str_replace("[#NUMCONTRATO]", $num_contrato, $modelo_bv);
        $modelo_bv = str_replace("[#VALOR]", "R$ ".number_format($valor, 2, ",", "."), $modelo_bv);
        
        // Envia e-mail de comprovante de pagamento ao cliente.
        $enviou_CLI = Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", $email, "Pagamento confirmado", ToISO8859($modelo_bv));          

        // Vai para página de agradecimento.
        unset($mysql);
        unset($_SESSION['pagto']);
        unset($_SESSION['aprovado']);
		unset($dadosusuario);
        GotoPage("contrato/pagamento.php?id=".$param_md5."");
    }
}
//---------------------------------------------------------------------------
function AgenteNegocios() {
    session_start();

    // Recebe os dados postados pelo formulário de cadastro.
    // OBS.: para usar o TitleCase é necessário converter em ISO8859.
    $cliente = ToISO8859($_POST['cliente']);
    $pessoa = $_POST['pessoa'];
    $nome_razsoc = TitleCase(ToISO8859($_POST['nome_razsoc']), "");
    $cpf_cnpj = SetaMascaraCPFCNPJ($_POST['cpf_cnpj']);
    $endereco = ToISO8859($_POST['endereco']);
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];
    $bairro = TitleCase(ToISO8859($_POST['bairro']), "");
    $cidade = TitleCase(ToISO8859($_POST['cidade']), "");
    $estado = strtoupper($_POST['estado']);
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $conhecimento = ToISO8859($_POST['conhecimento']);
    $experiencia = ToISO8859($_POST['experiencia']);

    if($pessoa == 'F') {
        $nome_fantasia = "";
        $celular = $_POST['celular'];
        $skype = $_POST['skype'];
        $website = "";
        $num_funcionarios = "";
        $segmento = "";
    } else if($pessoa == 'J') {
        $nome_fantasia = ToISO8859($_POST['nome_fantasia']);
        $celular = "";
        $skype = "";
        $website = $_POST['website'];
        $num_funcionarios = ToISO8859($_POST['num_funcionarios']);
        $segmento = ToISO8859($_POST['segmento']);
    }

    // Salva em sessão os dados postados, caso dê algum erro o formulário volta preenchido.
    $_SESSION['cad_agente']['cliente'] = ToUTF8($cliente);
    $_SESSION['cad_agente']['pessoa'] = $pessoa;
    $_SESSION['cad_agente']['nome_razsoc'] = ToUTF8($nome_razsoc);
    $_SESSION['cad_agente']['nome_fantasia'] = ToUTF8($nome_fantasia);
    $_SESSION['cad_agente']['cpf_cnpj'] = $cpf_cnpj;
    $_SESSION['cad_agente']['endereco'] = ToUTF8($endereco);
    $_SESSION['cad_agente']['numero'] = $numero;
    $_SESSION['cad_agente']['cep'] = $cep;
    $_SESSION['cad_agente']['bairro'] = ToUTF8($bairro);
    $_SESSION['cad_agente']['cidade'] = ToUTF8($cidade);
    $_SESSION['cad_agente']['estado'] = $estado;
    $_SESSION['cad_agente']['telefone'] = $telefone;
    $_SESSION['cad_agente']['celular'] = $celular;
    $_SESSION['cad_agente']['email'] = $email;
    $_SESSION['cad_agente']['skype'] = $skype;
    $_SESSION['cad_agente']['website'] = $website;
    $_SESSION['cad_agente']['num_funcionarios'] = ToUTF8($num_funcionarios);
    $_SESSION['cad_agente']['segmento'] = ToUTF8($segmento);
    $_SESSION['cad_agente']['conhecimento'] = ToUTF8($conhecimento);
    $_SESSION['cad_agente']['experiencia'] = ToUTF8($experiencia);

    // Atualiza a variável inicial com os dados já convertidos em UTF8.
    $cliente = $_SESSION['cad_agente']['cliente'];
    $nome_razsoc = $_SESSION['cad_agente']['nome_razsoc'];
    $nome_fantasia = $_SESSION['cad_agente']['nome_fantasia'];
    $cpf_cnpj = $_SESSION['cad_agente']['cpf_cnpj'];
    $endereco = $_SESSION['cad_agente']['endereco'];
    $numero = $_SESSION['cad_agente']['numero'];
    $cep = $_SESSION['cad_agente']['cep'];
    $bairro = $_SESSION['cad_agente']['bairro'];
    $cidade = $_SESSION['cad_agente']['cidade'];
    $estado = $_SESSION['cad_agente']['estado'];
    $telefone = $_SESSION['cad_agente']['telefone'];
    $celular = $_SESSION['cad_agente']['celular'];
    $email = $_SESSION['cad_agente']['email'];
    $skype = $_SESSION['cad_agente']['skype'];
    $website = $_SESSION['cad_agente']['website'];
    $num_funcionarios = $_SESSION['cad_agente']['num_funcionarios'];
    $segmento = $_SESSION['cad_agente']['segmento'];
    $conhecimento = $_SESSION['cad_agente']['conhecimento'];
    $experiencia = $_SESSION['cad_agente']['experiencia'];

    // Abre conexão com a base de dados.
    $mysql = new BaseSite();

    // Verifica se o e-mail postado já não está cadastrado.
    $query_verificacao = "SELECT email FROM AN_cadastro WHERE email='$email'";
    $verificacao = $mysql->Query($query_verificacao);

    if(!empty($verificacao)) {
        unset($mysql);
        VoltaMensagem("Esse e-mail já está cadastrado.", "alert alert-danger");
    }

    // Grava na base de dados as informações postadas.
    $query = "INSERT INTO AN_cadastro (cliente, nome_razsoc, nome_fantasia, cpf_cnpj, endereco, numero, cep, bairro, cidade, estado, telefone, celular, email, skype, website, num_funcionarios, segmento, conhecimento, experiencia, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($cliente),
                             addslashes($nome_razsoc),
                             addslashes($nome_fantasia),
                             addslashes($cpf_cnpj),
                             addslashes($endereco),
                             addslashes($numero),
                             addslashes($cep),
                             addslashes($bairro),
                             addslashes($cidade),
                             addslashes($estado),
                             addslashes($telefone),
                             addslashes($celular),
                             addslashes($email),
                             addslashes($skype),
                             addslashes($website),
                             addslashes($num_funcionarios),
                             addslashes($segmento),
                             addslashes($conhecimento),
                             addslashes($experiencia));
    $cadastrou = $mysql->Query($query);

    if($cadastrou) {
        // Prepara os campos para enviar o e-mail
        $datahora = date("d/m/Y H:i:s");  
        $modelo = file_get_contents(PATH_SITE . "modelos/e-mail/agente_negocios.html");
        $modelo = str_replace("[#NOME]", $nome_razsoc, $modelo);
        $modelo = str_replace("[#CIDADE]", $cidade, $modelo);
        $modelo = str_replace("[#ESTADO]", $estado, $modelo);
        $modelo = str_replace("[#EMAIL]", $email, $modelo);
        $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
        $modelo = str_replace("[#DATAHORA]", $datahora, $modelo);
        
        // Envia e-mail para o Depto. Marketing (Cacau)
        $enviou_MKT = Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", "anamattos.marketing@supersoft.com.br,lucimara.marketing@supersoft.com.br", "Cadastro de Agente de Negócios", ToISO8859($modelo));

        // Prepara os campos para enviar o e-mail 
        $modelo_bv = file_get_contents(PATH_SITE . "modelos/e-mail/AN_boasvindas.html");
        $modelo_bv = str_replace("[#NOME]", $nome_razsoc, $modelo_bv);
        
        // Envia e-mail de boas vindas para o Agente de Negócio
        $enviou_int = Email::Enviar("SuperSoft Sistemas", "atendimento@supersoft.com.br", $email, "Cadastro confirmado - Agente de Negócios", ToISO8859($modelo_bv));

        if($enviou_MKT && $enviou_int) {
            unset($mysql);
            unset($_SESSION['cad_agente']);
            VoltaMensagem("Seus dados foram recebidos com sucesso. Entraremos em contato!", "alert alert-success");
        } else {
            unset($mysql);
            VoltaMensagem("Algo deu errado! Tente novamente.", "alert alert-danger");
        }       
    } else {
        unset($mysql);
        VoltaMensagem("Erro interno! Tente novamente.", "alert alert-danger");
    }    
}
//---------------------------------------------------------------------------
function CadastroVideos() {
    session_start();

    $nome = TitleCase($_POST['nome']);
    $nome = ToUTF8($nome);
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $segmento = ToUTF8($_POST['segmento']);
    $cargo = ToUTF8($_POST['cargo']);

    $_SESSION['cadastro_videos']['nome'] = $nome;
    $_SESSION['cadastro_videos']['email'] = $email;
    $_SESSION['cadastro_videos']['telefone'] = $telefone;
    $_SESSION['cadastro_videos']['segmento'] = $segmento;
    $_SESSION['cadastro_videos']['cargo'] = $cargo;

    if($nome == "" || $email == "" || $telefone == "" || $segmento == "" || $cargo == "") {
        VoltaMensagem("Você deve preencher os campos obrigatórios.", "alert alert-danger");
    }

    $query = "INSERT INTO cadastro_videos (nome, email, telefone, segmento, cargo, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($nome), addslashes($email), addslashes($telefone), addslashes($segmento), addslashes($cargo));
    $cadastrou = SingleQuery($query);

    if($cadastrou) {
        $_SESSION['cadastro_videos']['validacao'] = TRUE;
        VoltarPaginaAnterior();
    } else {
        VoltaMensagem("Algo deu errado! Tente novamente.", "alert alert-danger");
    }    
}
//---------------------------------------------------------------------------
function Ligamos() {
    // Seta os dados recebidos nas variáveis.
    $nome = TitleCase(ToISO8859($_POST['nome']), "");
    $nome = ToUTF8($nome);
    $email = strtolower($_POST['email']);
    $telefone = $_POST['telefone'];
    $segmento = ToUTF8($_POST['segmento']);

    // Seta os dados em sessão.
    $_SESSION['ligamos']['nome'] = $nome;
    $_SESSION['ligamos']['email'] = $email;
    $_SESSION['ligamos']['telefone'] = $telefone;
    $_SESSION['ligamos']['segmento'] = $segmento;

    // Verifica se os dados foram realmente enviados.
    if($nome == '' || empty($nome)) {
        VoltaMensagem("Você deve informar seu nome.", "alert alert-warning");
    } else if($email == '' || empty($email)) {
        VoltaMensagem("Você deve informar seu e-mail.", "alert alert-warning");
    } else if($telefone == '' || empty($telefone)) {
        VoltaMensagem("Você deve informar seu telefone.", "alert alert-warning");
    } else if($segmento == '' || empty($segmento)) {
        VoltaMensagem("Você deve informar seu segmento.", "alert alert-warning");
    }

    // Abre conexão com a base de dados.
    $mysql = new BaseSite();

    if($segmento == "Escritório de contabilidade") {
        // Busca pelo último vendedor escolhido.
        $query  = "SELECT l.vendedor ";
        $query .= "FROM ligamos l ";
        $query .= "INNER JOIN ligamos_vendedores v ON v.vendedor=l.vendedor ";
        $query .= "WHERE v.segmento LIKE '%$segmento%' ";
        $query .= "ORDER BY id DESC ";
        $query .= "LIMIT 1";
        $vendedor = $mysql->Query($query);
        $ultimoVendedor = $vendedor[0]->vendedor;

        // Busca por um vendedor aleatoriamente.
        // Obs.: exclui o último vendedor escolhido para o segmento escolhido.
        $query  = "SELECT vendedor, email ";
        $query .= "FROM ligamos_vendedores ";
        $query .= "WHERE vendedor <> '$ultimoVendedor' ";
        $query .= "ORDER BY RAND() ";
        $query .= "LIMIT 1";
        $dadosVendedor = $mysql->Query($query);

        // Seta os dados do vendedor sorteado nas variáveis.
        $nomeVendedor = $dadosVendedor[0]->vendedor;
        $emailVendedor = $dadosVendedor[0]->email;
    } else {
        // Seta os dados do vendedor sorteado nas variáveis.
        $nomeVendedor = "comercial_ERP";
        $emailVendedor = "comercial.erp@supersoft.com.br";
    }

    // Seta o IP do interessado.
    $ip = IPCliente();

    // Grava na base de dados.
    $query  = "INSERT INTO ligamos (vendedor, nome, email, telefone, segmento, ip, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s',NOW())";
    $query  = sprintf($query, addslashes($nomeVendedor), addslashes($nome), addslashes($email), addslashes($telefone), addslashes($segmento), addslashes($ip));
    $gravou = $mysql->Query($query);

    if($gravou) {
        // Destrói a sessão com os dados.
        unset($_SESSION['ligamos']);

        // Fecha conexão com a base de dados.
        unset($mysql);

        // Prepara e-mail de notificação ao vendedor.
        $modelo = file_get_contents(PATH_SITE."modelos/e-mail/aviso_ligamos.html");
        $modelo = str_replace("[#NOME]", $nome, $modelo);
        $modelo = str_replace("[#EMAIL]", $email, $modelo);
        $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
        $modelo = str_replace("[#SEGMENTO]", $segmento, $modelo);

        // Envia e-mail para o vendedor.
        Email::Enviar(REMETENTE_LIGAMOS_NOME, REMETENTE_LIGAMOS, DESTINATARIOS_LIGAMOS.",".$emailVendedor, ASSUNTO_LIGAMOS.$nome, ToISO8859($modelo));

        VoltaMensagem("Seus dados foram recebidos com sucesso. Nossos consultores entrarão em contato.", "alert alert-success");
    } else {
        // Fecha conexão com a base de dados.
        unset($mysql);

        VoltaMensagem("Erro interno. Tente novamente.", "alert alert-danger");
    }
}
//---------------------------------------------------------------------------
function BaixarNFE() {
    // Recebe os dados por JSON
    $post = json_decode(file_get_contents("php://input"));

    // Seta os dados nas variáveis
    $segmento = $post->segmento;
    $nome = TitleCase(ToISO8859($post->nome), "");
    $nome = ToUTF8($nome);
    $email = strtolower($post->email);
    $telefone = $post->telefone;
    $cidade = TitleCase(ToISO8859($post->cidade), "");
    $cidade = ToUTF8($cidade);
    $estado = $post->estado;   

    // Verifica se os campos obrigatórios não estão vazios
    if($segmento == '' || empty($segmento)) {
        $erro = TRUE;
    } else if($nome == '' || empty($nome)) {
        $erro = TRUE;
    } else if($email == '' || empty($email)) {
        $erro = TRUE;
    } else if($telefone == '' || empty($telefone)) {
        $erro = TRUE;
    } else if($cidade == '' || empty($cidade)) {
        $erro = TRUE;
    } else if($estado == '' || empty($estado)) {
        $erro = TRUE;
    }

    // Cria array para armazenar se houve sucesso ou não na tentativa de login e mensagem de erro, caso exista
    $data = array();

    if(!$erro) {
        // Grava na base de dados o contato enviado pelo cliente
        $query  = "INSERT INTO NE_download (segmento, nome, email, telefone, cidade, estado, datahora) ";
        $query .= "VALUES ('%s','%s','%s','%s','%s','%s',NOW())";
        $query  = sprintf($query, addslashes($segmento), 
                                  addslashes($nome), 
                                  addslashes($email), 
                                  addslashes($telefone), 
                                  addslashes($cidade), 
                                  addslashes($estado));
        $inseriu = SingleQuery($query);

        if($inseriu) {
            $data['sucesso'] = TRUE;
            $data['link'] = LINK_EMISSOR."SSNFE.exe";
            $nomeRetorno = explode(" ", $nome);
            $data['nome'] = $nomeRetorno[0];

            // Monta e-mail.
            $modelo = file_get_contents(PATH_SITE."modelos/e-mail/NE_download.html");
            $modelo = str_replace("[#SEGMENTO]", $segmento, $modelo);
            $modelo = str_replace("[#NOME]", $nome, $modelo);
            $modelo = str_replace("[#EMAIL]", $email, $modelo);
            $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
            $modelo = str_replace("[#CIDADE]", $cidade, $modelo);
            $modelo = str_replace("[#ESTADO]", $estado, $modelo);

            // Envia e-mail de aviso do download.
            Email::Enviar(REMETENTE_DOWNLOAD_NFE_NOME, REMETENTE_DOWNLOAD_NFE, DESTINATARIOS_DOWNLOAD_NFE, ASSUNTO_DOWNLOAD_NFE.$nome, ToISO8859($modelo));
        } else {
            // Caso não consiga salvar o contato no banco de dados
            // ou enviar algum dos e-mails com o contato recebido
            $data['sucesso'] = FALSE;
            $data['mensagem'] = "Ops, erro interno! Tente novamente em alguns minutos.";
        }
    } else {
        // Caso algum dos campos obrigatórios esteja em branco
        $data['sucesso'] = FALSE;
        $data['mensagem'] = "Por favor, preencha os campos obrigatórios.";
    }

    // Retorna os dados em JSON
    echo json_encode($data);
}
//---------------------------------------------------------------------------
function AssinarNFE() {
    // Recebe os dados por JSON.
    $post = json_decode(file_get_contents("php://input"));

    // Seta os dados nas variáveis.
    $segmento = $post->segmento;
    $comoconheceu = $post->comoconheceu;
    $nome = TitleCase(ToISO8859($post->nome), "");
    $nome = ToUTF8($nome);
    $email = strtolower($post->email);
    $telefone = $post->telefone;
    $cidade = TitleCase(ToISO8859($post->cidade), "");
    $cidade = ToUTF8($cidade);
    $estado = $post->estado;

    // Verifica se os campos obrigatórios não estão vazios.
    if($segmento == '' || empty($segmento)) {
        $erro = TRUE;
    } else if($comoconheceu == '' || empty($comoconheceu)) {
        $erro = TRUE;
    } else if($nome == '' || empty($nome)) {
        $erro = TRUE;
    } else if($email == '' || empty($email)) {
        $erro = TRUE;
    } else if($telefone == '' || empty($telefone)) {
        $erro = TRUE;
    } else if($cidade == '' || empty($cidade)) {
        $erro = TRUE;
    } else if($estado == '' || empty($estado)) {
        $erro = TRUE;
    }

    // Cria array para armazenar se houve sucesso ou não na tentativa de login e mensagem de erro, caso exista.
    $data = array();

    if(!$erro) {
        // Abre conexão com a base de dados.
        $mysql = new BaseSite();

        // Grava na base de dados o contato enviado pelo cliente.
        $query  = "INSERT INTO NE_assinatura (segmento, comoconheceu, nome, email, telefone, cidade, estado, datahora) ";
        $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s',NOW())";
        $query  = sprintf($query, addslashes($segmento),
                                  addslashes($comoconheceu),
                                  addslashes($nome),
                                  addslashes($email),
                                  addslashes($telefone),
                                  addslashes($cidade),
                                  addslashes($estado));
        $inseriu = $mysql->Query($query);

        // Cria um array para salvar os dados a serem enviados via WS.
        $dados = array();

        // Seta o ID na variável.
        $dados['id'] = "NE_".$mysql->UltimoID();

        // Seta o código do segmento.
        if($segmento == 'Indústria de Plásticos') {
            $dados['segmento'] = "D8";
        } 
        else if($segmento == 'Indústria Metalúrgica') {
            $dados['segmento'] = "14";
        } 
        else if($segmento == 'Indústria Alimentícia') {
            $dados['segmento'] = "4";
        } 
        else if($segmento == 'Indústria Química') {
            $dados['segmento'] = "15";
        } 
        else if($segmento == 'Indústria de Embalagens') {
            $dados['segmento'] = "7";
        } 
        else if($segmento == 'Indústria Textil') {
            $dados['segmento'] = "21";
        } 
        else if($segmento == 'Indústria (outras)') {
            $dados['segmento'] = "IN";
        } 
        else if($segmento == 'Transportadora') {
            $dados['segmento'] = "77";
        } 
        else if($segmento == 'Empresa prestadora de serviço') {
            $dados['segmento'] = "SE";
        } 
        else if($segmento == 'Comércio Varejista') {
            $dados['segmento'] = "A2";
        } 
        else if($segmento == 'Comércio Atacadista') {
            $dados['segmento'] = "94";
        } 
        else if($segmento == 'Distribuidora') {
            $dados['segmento'] = "00";
        } 
        else if($segmento == 'Escritório de Contabilidade') {
            $dados['segmento'] = "82";
        }
        else if($segmento == 'Agronegócio') {
            $dados['segmento'] = "97";
        }
        else if($segmento == 'Construtora') {
            $dados['segmento'] = "19";
        }

        // Seta o código de como conheceu.
        if($comoconheceu == 'Indicação (Agente de Negócios)') {
            $dados['comoconheceu'] = "52";
        }
        else if($comoconheceu == 'Indicação (Clientes)') {
            $dados['comoconheceu'] = "02";
        } 
        else if($comoconheceu == 'CRC SP') {
            $dados['comoconheceu'] = "01";
        } 
        else if($comoconheceu == 'Google') {
            $dados['comoconheceu'] = "06";
        }
        else if($comoconheceu == 'Redes Sociais') {
            $dados['comoconheceu'] = "34";
        } 
        else if($comoconheceu == 'Fórum Contábeis') {
            $dados['comoconheceu'] = "29";
        }

        // Seta as demais variáveis no array.
        $dados['interesse'] = "";
        $dados['nome'] = $nome;
        $dados['email'] = $email;
        $dados['telefone'] = $telefone;        
        $dados['cidade'] = $cidade;
        $dados['estado'] = $estado;
        
        // Abre conexão com o WS.
        $ws = ConectaWSSupersoft();

        // Cadastra na base de dados Firebird.
        $cadastrou = $ws->CadastraInteressadoNovo(CHAVE_REQUISICAO, $dados);

        // Fecha conexão com o WS.
        DesconectaWSSupersoft($ws);

        if($inseriu && $cadastrou) {
            $data['sucesso'] = TRUE;

            // Monta e-mail.
            $modelo = file_get_contents(PATH_SITE."modelos/e-mail/NE_assinar.html");
            $modelo = str_replace("[#SEGMENTO]", $segmento, $modelo);
            $modelo = str_replace("[#CONHECEU]", $comoconheceu, $modelo);
            $modelo = str_replace("[#NOME]", $nome, $modelo);
            $modelo = str_replace("[#EMAIL]", $email, $modelo);
            $modelo = str_replace("[#TELEFONE]", $telefone, $modelo);
            $modelo = str_replace("[#CIDADE]", $cidade, $modelo);
            $modelo = str_replace("[#ESTADO]", $estado, $modelo);

            // Envia e-mail de aviso do interessado.
            Email::Enviar(REMETENTE_INTERESSADO_NFE_NOME, REMETENTE_INTERESSADO_NFE, DESTINATARIOS_INTERESSADO_NFE, ASSUNTO_INTERESSADO_NFE.$nome, ToISO8859($modelo));
        } else {
            // Caso não consiga salvar o contato no banco de dados
            // ou enviar algum dos e-mails com o contato recebido.
            $data['sucesso'] = FALSE;
            $data['mensagem'] = "Ops, erro interno! Tente novamente em alguns minutos.";
        }
    } else {
        // Caso algum dos campos obrigatórios esteja em branco.
        $data['sucesso'] = FALSE;
        $data['mensagem'] = "Por favor, preencha os campos obrigatórios.";          
    }

    // Fecha conexão com a base de dados.
    unset($mysql);

    // Retorna os dados em JSON.
    echo json_encode($data);
}
//---------------------------------------------------------------------------
function AvaliacaoSuporte() {
    session_start();

    $_SESSION['avaliacao']['protocolo'] = $_POST['protocolo'];
    $_SESSION['avaliacao']['nota'] = $_POST['nota'];
    $_SESSION['avaliacao']['problema_resolvido'] = $_POST['problema_resolvido'];
    $_SESSION['avaliacao']['quanto_esforco'] = $_POST['quanto_esforco'];
    $_SESSION['avaliacao']['melhorar_suporte'] = $_POST['melhorar_suporte'];
    $_SESSION['avaliacao']['entrar_contato'] = $_POST['entrar_contato'];

    if ($_POST['protocolo'] == "") {
        VoltaMensagem("É necessário informar o número do protocolo.", "validacao");
    }
    if ($_POST['nota'] == "") {
        VoltaMensagem("É necessário escolher uma nota de avaliação.", "validacao");
    }
    if ($_POST['quanto_esforco'] == "") {
        VoltaMensagem("É necessário informar se o problema foi resolvido.", "validacao");
    }
    if ($_POST['entrar_contato'] == "") {
        VoltaMensagem("É necessário informar se você deseja que entremos em contato com você.", "validacao");
    }

    $ws = ConectaWSSuperSoft();
    $existe_protocolo = $ws->ExisteAtendimento('SS', $_POST['protocolo']);
    DesconectaWSSuperSoft($ws);

    if ($existe_protocolo) {        
        $query_verificacao = "SELECT COUNT(*) as num FROM pesq_suporte WHERE protocolo='" . $_POST['protocolo'] . "'";
        $verificou = SingleQuery($query_verificacao);

        if ($verificou[0]->num > 0) {
            VoltaMensagem("O protocolo já foi utilizado para avaliação.", "validacao");
        } else {
            $ip = IPCliente();
            $query = "INSERT INTO pesq_suporte (protocolo, nota, problema_resolvido, quanto_esforco, melhorar_suporte, entrar_contato, ip, datahora) ";
            $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s',NOW())";
            $query = sprintf($query, addslashes($_POST['protocolo']), addslashes($_POST['nota']), addslashes($_POST['problema_resolvido']), addslashes($_POST['quanto_esforco']), addslashes($_POST['melhorar_suporte']), addslashes($_POST['entrar_contato']), $ip);

            $avaliou = SingleQuery($query);

            if ($avaliou) {
                if ($_POST['nota'] < 6) {
                    $mensagem = "<br><div style=\"font-size: 18px; font-weight: bold;\">AVALIAÇÃO NEGATIVA SUPERSOFT</div><br><br>";
                    $mensagem .= "<div style=\"float: left; width: 210px; line-height: 5px\"><b>Protocolo:</b></div><div style=\"line-height: 5px\">" . $_POST['protocolo'] . "</div><br>";
                    $mensagem .= "<div style=\"float: left; width: 210px; line-height: 5px\"><b>Nota do atendimento:</b></div><div style=\"color:red;font-weight:bold;line-height:5px;\">" . $_POST['nota'] . "</div><br>";
                    $mensagem .= "<div style=\"float: left; width: 210px; line-height: 5px\"><b>O problema foi resolvido?</b></div><div style=\"line-height: 5px\">" . $_POST['problema_resolvido'] . "</div><br>";
                    $mensagem .= "<div style=\"float: left; width: 210px; line-height: 5px\"><b>Esforço necessário:</b></div><div style=\"line-height: 5px\">" . $_POST['quanto_esforco'] . "</div><br>";
                    $mensagem .= "<div style=\"float: left; width: 210px; line-height: 5px\"><b>Entrar em contato?</b></div><div style=\"line-height: 5px\">" . $_POST['entrar_contato'] . "</div><br>";
                    $mensagem .= "<div style=\"float: left; width: 210px; line-height: 5px\"><b>Mensagem do cliente:</b></div><div><br/>" . $_POST['melhorar_suporte'] . "</div><br>";
                    $rodape = "Enviado em " . date("d/m/Y H:i:s");
                    $modelo = file_get_contents(PATH_SITE . "modelos/e-mail/avisos.html");
                    $modelo = str_replace("[#TITULO]", "Avaliação negativa SuperSoft", $modelo);
                    $modelo = str_replace("[#MENSAGEM]", $mensagem, $modelo);
                    $modelo = str_replace("[#RODAPE]", $rodape, $modelo);

                    // Envia e-mail para o Adriano.
                    Email::Enviar("Avaliação de Atendimento", REMETENTE_CONTATO, "adriano.suporte@supersoft.com.br", "Avaliação de atendimento negativa SuperSoft", ToISO8859($modelo));
                }
                unset($_SESSION['avaliacao']);
                GotoPage("pesquisa/suporte/final");
            } else {
                VoltaMensagem("Ocorreu um erro durante a avaliação.", "validacao");
            }
        }
    } else {
        VoltaMensagem("O protocolo informado não é válido.", "validacao");
    }
}
//---------------------------------------------------------------------------
function FormularioRemarketing() {
    session_start();

    $pergunta_01 = $_POST['pergunta_01'];
    $pergunta_02 = $_POST['pergunta_02'];
    $pergunta_03 = $_POST['pergunta_03'];
    $pergunta_04 = $_POST['pergunta_04'];
    $pergunta_05 = $_POST['pergunta_05'];
    $pergunta_06 = $_POST['pergunta_06'];
    
    if(!empty($_POST['pergunta_07'])) {
        $pergunta_07 = ToUTF8($_POST['pergunta_07']);
    } else {
        $pergunta_07 = "";
    }

    if($_POST['aceito'] == TRUE) {
        $aceito = "Aceito";
    } else {
        $aceito = "Não aceito";
    }

    $query = "INSERT INTO remarketing (pergunta_01, pergunta_02, pergunta_03, pergunta_04, pergunta_05, pergunta_06, pergunta_07, aceito, datahora) ";
    $query .= "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())";
    $query = sprintf($query, addslashes($pergunta_01), addslashes($pergunta_02), addslashes($pergunta_03), addslashes($pergunta_04), addslashes($pergunta_05), addslashes($pergunta_06), addslashes($pergunta_07), addslashes($aceito));
    //die($query);
    $mysql = new BaseSite();    
    $cadastrou = $mysql->Query($query);

    $_SESSION['ultimo_id'] = $mysql->UltimoID();
    $ultimo_id = $_SESSION['ultimo_id'];

    if($cadastrou) {
        unset($mysql);
        GotoPage("pesquisa/remarketing/formulario-enviado");
    } else {
        VoltaMensagem("Algo deu errado.", "validacao");
    }
}
//---------------------------------------------------------------------------
function FormularioHomologacao() {
    session_start();

    $cpfcnpj = SetaMascaraCPFCNPJ($_SESSION['login_homologacao']['NUMERO']);
    $nome_razsoc = ToUTF8($_SESSION['login_homologacao']['RAZSOC']);
    $qualidade = $_POST['qualidade'];
    $duracao = $_POST['duracao'];
    $conhecimento = $_POST['conhecimento'];
    $satisfacao = $_POST['satisfacao'];
    $instrutor = ToUTF8($_POST['instrutor']);
    if($instrutor == "Outro") {
        $instrutor = TitleCase(ToISO8859($_POST['outro']), "");
        $instrutor = ToUTF8($instrutor);
    }
    $sugestoes = $_POST['sugestoes'];

    if($_POST['aceito'] == TRUE) {
        $aceito = "Aceito";
    } else {
        $aceito = "Não aceito";
    }

    $ip = IPCliente();
    $query = "INSERT INTO homologacao (cpfcnpj, nome_razsoc, qualidade, duracao, conhecimento, satisfacao, instrutor, sugestoes, aceito, ip, datahora) ";
    $query .= "VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW())";
    $query = sprintf($query, addslashes($cpfcnpj),
                             addslashes($nome_razsoc),
                             addslashes($qualidade),
                             addslashes($duracao),
                             addslashes($conhecimento),
                             addslashes($satisfacao),
                             addslashes($instrutor),
                             addslashes($sugestoes),
                             addslashes($aceito),
                             $ip);
    $cadastrou = SingleQuery($query);

    $modelo = file_get_contents(PATH_SITE."modelos/e-mail/aviso_pesq_homologacao.html");
    $modelo = str_replace("[#CPFCNPJ]", $cpfcnpj, $modelo);
    $modelo = str_replace("[#RAZSOC]", $nome_razsoc, $modelo);
    $modelo = str_replace("[#QUALIDADE]", $qualidade, $modelo);
    $modelo = str_replace("[#DURACAO]", $duracao, $modelo);
    $modelo = str_replace("[#CONHECIMENTO]", $conhecimento, $modelo);
    $modelo = str_replace("[#SATISFACAO]", $satisfacao, $modelo);
    $modelo = str_replace("[#INSTRUTOR]", $instrutor, $modelo);            
    $modelo = str_replace("[#SUGESTOES]", $sugestoes, $modelo);
    
    $enviou = Email::Enviar(REMETENTE_AVALIACAO_NOME, REMETENTE_AVALIACAO, DESTINATARIOS_AVALIACAO_HOMOLOGACAO, ASSUNTO_AVALIACAO_HOMOLOGACAO.$_SESSION['login']['RAZSOC'], ToISO8859($modelo));

    if($cadastrou) {
        GotoPage("pesquisa/homologacao/formulario-enviado");
    } else {
        VoltaMensagem("Algo deu errado.", "validacao");
    }
}
//---------------------------------------------------------------------------
function FormularioSAC() {
    session_start();

    $cpfcnpj = SetaMascaraCPFCNPJ($_POST['cpfcnpj']);
    $chat = ToUTF8($_POST['chat']);
    $email = $_POST['email'];
    $duvidas = ToUTF8($_POST['duvidas']);
    $atendimento = $_POST['atendimento'];
    $sugestoes = ToUTF8($_POST['sugestoes']);

    $query = "INSERT INTO pesq_sac (cpfcnpj, chat, email, duvidas, atendimento, sugestoes, datahora) ";
    $query .= "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', NOW())";
    $query = sprintf($query, addslashes($cpfcnpj), addslashes($chat), addslashes($email), addslashes($duvidas), addslashes($atendimento), addslashes($sugestoes)); 
    $cadastrou = SingleQuery($query);

    if($cadastrou) {
        GotoPage("pesquisa/sac/formulario-enviado");
    } else {
        VoltaMensagem("Algo deu errado.", "validacao");
    }
}
//---------------------------------------------------------------------------
function PesquisaSatisfacao() {
    session_start();

    // Verifica se sessão de satisfação foi/está iniciada.
    // Caso tenha perdido a sessão, a identificação do cliente será enviada por POST.
    // Se estiver em sessão usará a identificação gravada na própria sessão.
    // Obs.: esse recurso foi implementado caso o cliente demore demais para avançar para próxima etapa da pesquisa.
    if(!isset($_SESSION['satisfacao'])) {
        $identificacao = $_POST['identificacao'];       
    } else {
        $identificacao = $_SESSION['satisfacao']['identificacao'];
    }

    // Seta a etapa atual da pesquisa na variável.
    $etapa = $_POST['etapa'];

    // Verifica em qual etapa o cliente está.
    if($etapa == "implementacao") {
        // Seta as informações enviadas pelo formulário nas variáveis.
        $notaImplementacao = $_POST['notaImplementacao'];
        $dificuldadeImplementacao = ToUTF8($_POST['dificuldadeImplementacao']);
        $comentarioImplementacao = ToUTF8($_POST['comentarioImplementacao']);
        $ip = IPCliente();

        // Grava as variáveis em sessão.
        // Obs: caso aconteça algum erro o formulário volta preenchido.
        $_SESSION['satisfacao']['notaImplementacao'] = $notaImplementacao;
        $_SESSION['satisfacao']['dificuldadeImplementacao'] = $dificuldadeImplementacao;
        $_SESSION['satisfacao']['comentarioImplementacao'] = $comentarioImplementacao;

        // Grava na base de dados as respostas.
        $query  = "INSERT INTO pesquisa_satisfacao (identificacao, notaImplementacao, dificuldadeImplementacao, comentarioImplementacao, ip, datahora) ";
        $query .= "VALUES ('%s','%s','%s','%s','%s',NOW())";
        $query  = sprintf($query, addslashes($identificacao), addslashes($notaImplementacao), addslashes($dificuldadeImplementacao), addslashes($comentarioImplementacao), addslashes($ip)); 
        $gravou = SingleQuery($query);

        if($gravou) {
            $_SESSION['satisfacao']['etapa'] = "suporte";
            GotoPage("pesquisa/satisfacao/");
        } else {
            $_SESSION['satisfacao']['etapa'] = "implementacao";
            VoltaMensagem("Algo deu errado. Tente novamente, por favor.", "alert alert-danger");
        }
    } else if($etapa == "suporte") {
        // Seta as informações enviadas pelo formulário nas variáveis.
        $notaSuporte = $_POST['notaSuporte'];
        $tempoSuporte = ToUTF8($_POST['tempoSuporte']);
        $comentarioSuporte = ToUTF8($_POST['comentarioSuporte']);

        // Grava as variáveis em sessão.
        // Obs: caso aconteça algum erro o formulário volta preenchido.
        $_SESSION['satisfacao']['notaSuporte'] = $notaSuporte;
        $_SESSION['satisfacao']['tempoSuporte'] = $tempoSuporte;
        $_SESSION['satisfacao']['comentarioSuporte'] = $comentarioSuporte;

        // Grava na base de dados as respostas.
        $query = "UPDATE pesquisa_satisfacao SET notaSuporte='%s', tempoSuporte='%s', comentarioSuporte='%s' WHERE identificacao='$identificacao'";
        $query = sprintf($query, addslashes($notaSuporte), addslashes($tempoSuporte), addslashes($comentarioSuporte));
        $gravou = SingleQuery($query);

        if($gravou) {
            $_SESSION['satisfacao']['etapa'] = "atualizacoes";
            GotoPage("pesquisa/satisfacao/");
        } else {
            $_SESSION['satisfacao']['etapa'] = "suporte";
            VoltaMensagem("Algo deu errado. Tente novamente, por favor.", "alert alert-danger");
        }
    } else if($etapa == "atualizacoes") {
        // Seta as informações enviadas pelo formulário nas variáveis.
        $notaAtualizacoes = $_POST['notaAtualizacoes'];
        $falhaSistema = ToUTF8($_POST['falhaSistema']);
        $comentarioAtualizacoes = ToUTF8($_POST['comentarioAtualizacoes']);

        // Grava as variáveis em sessão.
        // Obs: caso aconteça algum erro o formulário volta preenchido.
        $_SESSION['satisfacao']['notaAtualizacoes'] = $notaAtualizacoes;
        $_SESSION['satisfacao']['falhaSistema'] = $falhaSistema;
        $_SESSION['satisfacao']['comentarioAtualizacoes'] = $comentarioAtualizacoes;

        // Grava na base de dados as respostas.
        $query = "UPDATE pesquisa_satisfacao SET notaAtualizacoes='%s', falhaSistema='%s', comentarioAtualizacoes='%s' WHERE identificacao='$identificacao'";
        $query = sprintf($query, addslashes($notaAtualizacoes), addslashes($falhaSistema), addslashes($comentarioAtualizacoes));
        $gravou = SingleQuery($query);

        if($gravou) {
            $_SESSION['satisfacao']['etapa'] = "modulos";
            GotoPage("pesquisa/satisfacao/");
        } else {
            $_SESSION['satisfacao']['etapa'] = "atualizacoes";
            VoltaMensagem("Algo deu errado. Tente novamente, por favor.", "alert alert-danger");
        }
    } else if($etapa == "modulos") {
        // Seta as informações enviadas pelo formulário nas variáveis.
        $notaAE = $_POST['notaAE'];
        $notaCC = $_POST['notaCC'];
        $notaCE = $_POST['notaCE'];
        $notaAP = $_POST['notaAP'];
        $notaCP = $_POST['notaCP'];
        $notaQL = $_POST['notaQL'];
        $notaVD = $_POST['notaVD'];
        $notaFN = $_POST['notaFN'];
        $notaAT = $_POST['notaAT'];
        $notaCB = $_POST['notaCB'];
        $notaLF = $_POST['notaLF'];       
        $notaFP = $_POST['notaFP'];
        $notaPV = $_POST['notaPV'];        
        $notaNE = $_POST['notaNE'];
        $notaPP = $_POST['notaPP'];
        $notaAC = $_POST['notaAC'];
        $comentarioModulos = ToUTF8($_POST['comentarioModulos']);

        // Grava as variáveis em sessão.
        // Obs: caso aconteça algum erro o formulário volta preenchido.
        $_SESSION['satisfacao']['notaAE'] = $notaAE;
        $_SESSION['satisfacao']['notaCC'] = $notaCC;
        $_SESSION['satisfacao']['notaCE'] = $notaCE;
        $_SESSION['satisfacao']['notaAP'] = $notaAP;
        $_SESSION['satisfacao']['notaCP'] = $notaCP;
        $_SESSION['satisfacao']['notaQL'] = $notaQL;
        $_SESSION['satisfacao']['notaVD'] = $notaVD;
        $_SESSION['satisfacao']['notaFN'] = $notaFN;
        $_SESSION['satisfacao']['notaAT'] = $notaAT;        
        $_SESSION['satisfacao']['notaCB'] = $notaCB;
        $_SESSION['satisfacao']['notaLF'] = $notaLF;       
        $_SESSION['satisfacao']['notaFP'] = $notaFP;
        $_SESSION['satisfacao']['notaPV'] = $notaPV;        
        $_SESSION['satisfacao']['notaNE'] = $notaNE;
        $_SESSION['satisfacao']['notaPP'] = $notaPP;
        $_SESSION['satisfacao']['notaAC'] = $notaAC;
        $_SESSION['satisfacao']['comentarioModulos'] = $comentarioModulos;

        // Grava na base de dados as respostas.
        $query  = "UPDATE pesquisa_satisfacao SET notaAE='%s',notaCC='%s',notaCE='%s',notaAP='%s',notaCP='%s',notaQL='%s',notaVD='%s',notaFN='%s',notaAT='%s',";
        $query .= "notaCB='%s',notaLF='%s',notaFP='%s',notaPV='%s',notaNE='%s',notaPP='%s',notaAC='%s',comentarioModulos='%s' WHERE identificacao='$identificacao'";
        $query  = sprintf($query, addslashes($notaAE), addslashes($notaCC), addslashes($notaCE), addslashes($notaAP), addslashes($notaCP), addslashes($notaQL), addslashes($notaVD), addslashes($notaFN), addslashes($notaAT),
                                  addslashes($notaCB), addslashes($notaLF), addslashes($notaFP), addslashes($notaPV), addslashes($notaNE), addslashes($notaPP), addslashes($notaAC), addslashes($comentarioModulos));
        $gravou = SingleQuery($query);

        if($gravou) {
            $_SESSION['satisfacao']['etapa'] = "recomendacao";
            GotoPage("pesquisa/satisfacao/");
        } else {
            $_SESSION['satisfacao']['etapa'] = "modulos";
            VoltaMensagem("Algo deu errado. Tente novamente, por favor.", "alert alert-danger");
        }
    } else if($etapa == "recomendacao") {
        // Seta as informações enviadas pelo formulário nas variáveis.
        $chanceAmigo = $_POST['chanceAmigo'];   
        $comentarioRecomendacao = ToUTF8($_POST['comentarioRecomendacao']);

        // Grava as variáveis em sessão.
        // Obs: caso aconteça algum erro o formulário volta preenchido.
        $_SESSION['satisfacao']['chanceAmigo'] = $chanceAmigo;
        $_SESSION['satisfacao']['comentarioRecomendacao'] = $comentarioRecomendacao;

        // Grava na base de dados as respostas.
        $query = "UPDATE pesquisa_satisfacao SET chanceAmigo='%s', comentarioRecomendacao='%s' WHERE identificacao='$identificacao'";
        $query = sprintf($query, addslashes($chanceAmigo), addslashes($comentarioRecomendacao));
        $gravou = SingleQuery($query);

        if($gravou) {
            $_SESSION['satisfacao']['etapa'] = "gerais";
            GotoPage("pesquisa/satisfacao/");
        } else {
            $_SESSION['satisfacao']['etapa'] = "recomendacao";
            VoltaMensagem("Algo deu errado. Tente novamente, por favor.", "alert alert-danger");
        }
    } else if($etapa == "gerais") {
        // Seta as informações enviadas pelo formulário nas variáveis.
        $descricao = array();
        $descricao = $_POST['descricao'];
        ArrayToUTF8($descricao);
        $descricao = implode(", ", $descricao);     
        $comentarioGerais = ToUTF8($_POST['comentarioGerais']);

        // Grava as variáveis em sessão.
        // Obs: caso aconteça algum erro o formulário volta preenchido.
        $_SESSION['satisfacao']['comentarioGerais'] = $comentarioGerais;

        // Grava na base de dados as respostas.
        $query = "UPDATE pesquisa_satisfacao SET descricao='%s', comentarioGerais='%s' WHERE identificacao='$identificacao'";
        $query = sprintf($query, addslashes($descricao), addslashes($comentarioGerais));
        $gravou = SingleQuery($query);

        if($gravou) {
            $_SESSION['satisfacao']['etapa'] = "final";
            GotoPage("pesquisa/satisfacao/final");
        } else {
            $_SESSION['satisfacao']['etapa'] = "gerais";
            VoltaMensagem("Algo deu errado. Tente novamente, por favor.", "alert alert-danger");
        }
    }
}
//---------------------------------------------------------------------------
function RegistraLogin($numero) {
    Logs::Atividade('Login', $numero);
}
//---------------------------------------------------------------------------
function UltimoLogin($numero) {
    $query = "SELECT datahora FROM log_atividades ";
    $query .= "WHERE tipo = 'Login' AND conteudo = '" . $numero . "' ";
    $query .= "ORDER BY datahora DESC LIMIT 0,1";
    $Login = SingleQuery($query);
    if ((isset($Login[0]->datahora)) && ($Login[0]->datahora != ""))
        return DataMySQL_Brasil($Login[0]->datahora);
    else
        return date('d/m/Y');
}
//---------------------------------------------------------------------------
?>