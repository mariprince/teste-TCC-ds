<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../model/motorista.model.php');
require_once(__DIR__ . '/../service/motorista.service.php');
require_once(__DIR__ . '/../conexao/conexao.php');

// Roteamento de ação
@$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
@$id   = isset($_GET['id']) ? $_GET['id'] : $id;

// Inserção
if ($acao === 'inserir') {
        $conexao = new Conexao();
        $motorista = new Motorista();
        $motorista->__set('nome_completo', $_POST['nome_completo']);
        $motorista->__set('cpf', $_POST['cpf']);
        $motorista->__set('numCtt', $_POST['numCtt']);
        $motorista->__set('cnh', $_POST['cnh']);
        $motorista->__set('renavan', $_POST['renavan']);
        $motorista->__set('email_motorista', $_POST['email_motorista']);
        $motorista->__set('senha', password_hash($_POST['senha'], PASSWORD_DEFAULT));

        // Upload do currículo
        if (!empty($_FILES['curriculo']['name'])) {
            $curriculo = $_FILES['curriculo']['name'];
            $tmp = $_FILES['curriculo']['tmp_name'];

            // Move o arquivo
            move_uploaded_file($tmp, "curriculos/$curriculo");
            $motorista->__set('curriculo', $curriculo);
        } else {
            $motorista->__set('curriculo', '');
        }

    $conexao = new Conexao();
    $motoristaService = new MotoristaService($motorista, $conexao);
    $motoristaService->inserir();
}

// Recuperar todos os motoristas
if($acao == 'recuperar') {
    $motorista = new Motorista();
    $conexao = new Conexao();

    $motoristaService = new MotoristaService($motorista, $conexao);
    $motorista = $motoristaService->recuperar();
 }

// Recuperar motorista único
if($acao == 'recuperarMotorista') {
    $motorista = new Motorista();
    $conexao = new Conexao();
   
    $motoristaService = new MotoristaService($motorista, $conexao);
    $motorista = $motoristaService->recuperarMotorista($id);
 }

// Excluir
if($acao == 'excluir') {
    $motorista = new Motorista();
    $conexao = new Conexao();

    $motorista->__set('id_motorista', $_POST['id_motorista']);

    $motoristaService = new MotoristaService($motorista, $conexao);
    $motoristaService->excluir();
    header('location:../paginas/areaRestritaMoto.php?link=cotacao&msg=delete');
 }

// Alterar
if ($acao === 'alterar') {
   // if (!empty($_POST['id_motorista'])) {
        $motorista = new Motorista();
        $motorista->__set('id_motorista', $_POST['id_motorista']);
        $motorista->__set('nome_completo', $_POST['nome_completo']);
        $motorista->__set('cpf', $_POST['cpf']);
        $motorista->__set('numCtt', $_POST['numCtt'] ?? '');
        $motorista->__set('cnh', $_POST['cnh']);
        $motorista->__set('renavan', $_POST['renavan'] ?? '');
        $motorista->__set('email_motorista', $_POST['email_motorista']);

        // Mantém a senha atual se não for informada uma nova
        if (!empty($_POST['senha'])) {
            $motorista->__set('senha', password_hash($_POST['senha'], PASSWORD_DEFAULT));
        } else {
            // Recupera a senha atual do banco
            $conexao = new Conexao();
            $motoristaService = new MotoristaService($motorista, $conexao);
            $motoristaAtual = $motoristaService->recuperarMotorista($_POST['id_motorista']);
            $motorista->__set('senha', $motoristaAtual->senha);
        }

        // Upload do novo currículo, se houver
        if (!empty($_FILES['curriculo']['name'])) {
            $curriculo = $_FILES['curriculo']['name'];
            move_uploaded_file($_FILES['curriculo']['tmp_name'], "curriculos/$curriculo");
            $motorista->__set('curriculo', $curriculo);
        } else {
            // Mantém o currículo atual
            $conexao = new Conexao();
            $motoristaService = new MotoristaService($motorista, $conexao);
            $motoristaAtual = $motoristaService->recuperarMotorista($_POST['id_motorista']);
            $motorista->__set('curriculo', $motoristaAtual->curriculo);
        }

        $conexao = new Conexao();
        $motoristaService = new MotoristaService($motorista, $conexao);
        if ($motoristaService->alterar()) {
            header('location:../paginas/areaRestritaMoto.php?link=motoristas&msg=updated');
            exit;
        } else {
            echo "Erro ao atualizar motorista.";
        }
   
    $conexao = new Conexao();
    $motoristaService = new MotoristaService($motorista, $conexao);
    $motoristaService->alterar();
}
// Login do motorista
if($acao ==='recuperarLoginM'){
   
    $motorista = new Motorista();
    $conexao = new Conexao();
    
    $email = $_POST['email_motorista'];
    $senha = $_POST['senha'];
 
    $motoristaService = new MotoristaService($motorista,$conexao);
    $motorista = $motoristaService->recuperarLoginM($email,$senha);
 
    foreach($motorista as $indice => $motorista){
    }
  
    if(!isset($motorista->email_motorista)){
        echo '<script>alert("motorista com email desconhecido")</script>
        <meta http-equiv="refresh" content="0;url=index.php?link=9">';
    }else{
        $_SESSION['motoristaLogado']=$motorista->nome_completo;
        $_SESSION['emailMotoristaLogado']=$motorista->email_motorista;
        $_SESSION['idmotoristaLogado']=$motorista->id_motorista;
     header('location:paginas/dashboard.php');
     exit;
   
    }
   // echo $_SESSION['idmotoristaLogado'];
 }
 

// Logout
if ($acao === 'sairMotorista') {
    unset($_SESSION['motoristaLogado']);
    unset($_SESSION['emailMotoristaLogado']);
    unset($_SESSION['idMotorista']);
    unset($_SESSION['curriculo']);
    unset($_SESSION['tipoUsuario']);
    
    header('location:paginas/login.php');
    exit;
}


?>