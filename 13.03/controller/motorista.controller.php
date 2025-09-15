<?php
/*if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "model/motorista.model.php";
require_once "service/motorista.service.php";
require_once "conexao/conexao.php";

// Roteamento de ação
$acao = $_GET['acao'] ?? $acao ?? '';
$idm = $_GET['idm'] ?? $idm ?? '';*/

// Função para criar o service
if (!function_exists('criarMotoristaService')) {
    function criarMotoristaService($motorista = null) {
        $conexao = new Conexao();
        if (!$motorista) {
            $motorista = new Motorista();
        }
        return new MotoristaService($motorista, $conexao);
    }
}

// Inserção
if ($acao === 'inserir') {
    if (!empty($_POST['nome_completo']) && !empty($_POST['email']) && !empty($_POST['senha']) && 
        !empty($_POST['cpf']) && !empty($_POST['cnh'])) {
        
        $motorista = new Motorista();
        $motorista->__set('nome_completo', $_POST['nome_completo']);
        $motorista->__set('cpf', $_POST['cpf']);
        $motorista->__set('telefone', $_POST['telefone'] ?? '');
        $motorista->__set('cnh', $_POST['cnh']);
        $motorista->__set('renavan', $_POST['renavan'] ?? '');
        $motorista->__set('email', $_POST['email']);
        $motorista->__set('senha', password_hash($_POST['senha'], PASSWORD_DEFAULT));

        // Upload do currículo
        if (!empty($_FILES['curriculo']['name'])) {
            $curriculo = $_FILES['curriculo']['name'];
            $tmp = $_FILES['curriculo']['tmp_name'];

            // Cria diretório se não existir
            if (!is_dir('curriculos')) {
                mkdir('curriculos', 0777, true);
            }

            // Move o arquivo
            move_uploaded_file($tmp, "curriculos/$curriculo");
            $motorista->__set('curriculo', $curriculo);
        } else {
            $motorista->__set('curriculo', '');
        }

        $motoristaService = criarMotoristaService($motorista);
        if ($motoristaService->inserir()) {
            header('location:index.php?link=motoristas&msg=success');
            exit;
        } else {
            echo "Erro ao cadastrar motorista.";
        }
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
    }
}

// Recuperar todos os motoristas
if ($acao === 'recuperar') {
    $motoristaService = criarMotoristaService();
    $motoristas = $motoristaService->recuperar();
}

// Recuperar motorista único
if ($acao === 'recuperarMotorista') {
    $motoristaService = criarMotoristaService();
    $motorista = $motoristaService->recuperarMotorista($idm);
}

// Excluir
if ($acao === 'excluir') {
    if (!empty($idm)) {
        $motorista = new Motorista();
        $motorista->__set('id_motorista', $idm);
        $motoristaService = criarMotoristaService($motorista);
        
        if ($motoristaService->excluir()) {
            header('location:index.php?link=motoristas&msg=deleted');
            exit;
        } else {
            echo "Erro ao excluir motorista.";
        }
    }
}

// Alterar
if ($acao === 'alterar') {
    if (!empty($_POST['id_motorista'])) {
        $motorista = new Motorista();
        $motorista->__set('id_motorista', $_POST['id_motorista']);
        $motorista->__set('nome_completo', $_POST['nome_completo']);
        $motorista->__set('cpf', $_POST['cpf']);
        $motorista->__set('telefone', $_POST['telefone'] ?? '');
        $motorista->__set('cnh', $_POST['cnh']);
        $motorista->__set('renavan', $_POST['renavan'] ?? '');
        $motorista->__set('email', $_POST['email']);

        // Mantém a senha atual se não for informada uma nova
        if (!empty($_POST['senha'])) {
            $motorista->__set('senha', password_hash($_POST['senha'], PASSWORD_DEFAULT));
        } else {
            // Recupera a senha atual do banco
            $motoristaService = criarMotoristaService();
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
            $motoristaService = criarMotoristaService();
            $motoristaAtual = $motoristaService->recuperarMotorista($_POST['id_motorista']);
            $motorista->__set('curriculo', $motoristaAtual->curriculo);
        }

        $motoristaService = criarMotoristaService($motorista);
        if ($motoristaService->alterar()) {
            header('location:index.php?link=motoristas&msg=updated');
            exit;
        } else {
            echo "Erro ao atualizar motorista.";
        }
    }
}

// Login do motorista
if ($acao === 'loginMotorista') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        $motorista = new Motorista();
        $conexao = new Conexao();
        $motoristaService = new MotoristaService($motorista, $conexao);
        
        // Primeiro busca o motorista pelo email
        $motoristaData = $motoristaService->buscarPorEmail($email);
        
        if ($motoristaData && password_verify($senha, $motoristaData->senha)) {
            $_SESSION['motoristaLogado'] = $motoristaData->nome_completo;
            $_SESSION['emailMotorista'] = $motoristaData->email;
            $_SESSION['idMotorista'] = $motoristaData->id_motorista;
            $_SESSION['curriculo'] = $motoristaData->curriculo;
            $_SESSION['tipoUsuario'] = 'motorista';
            
            header('location: motorista/dashboard.php');
            exit;
        } else {
            echo '<script>alert("Email ou senha inválidos!")</script>';
            echo '<meta http-equiv="refresh" content="0;url=index.php?link=login_motorista">';
        }
    }
}

// Logout
if ($acao === 'sairMotorista') {
    unset($_SESSION['motoristaLogado']);
    unset($_SESSION['emailMotorista']);
    unset($_SESSION['idMotorista']);
    unset($_SESSION['curriculo']);
    unset($_SESSION['tipoUsuario']);
    
    header('location:index.php');
    exit;
}
?>