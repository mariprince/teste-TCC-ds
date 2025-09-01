<?php 
 require_once "model/motorista.model.php";
 require_once "service/motorista.service.php";
 require_once "conexao/conexao.php";
 
 @$acaoe = isset($_GET['acaoe']) ? $_GET['acaoe'] : $acaoe;
 @$ide   = isset($_GET['ide']) ? $_GET['ide'] : $ide;

 // Inserir Empresa
 if($acaoe == 'inserir') {
    $motorista = new Motorista();
    $motorista->__set('nome_motorista', $_POST['nome_motorista']);
    $motorista->__set('cpf', $_POST['cpf']);
    $motorista->__set('telefone', $_POST['telefone']);
    $motorista->__set('cnh', $_POST['cnh']);
    $motorista->__set('renavan', $_POST['renavan']);
    $motorista->__set('curriculo', $_POST['curriculo']);
    $motorista->__set('email_motorista', $_POST['email_motorista']);
    $motorista->__set('senha', $_POST['senha']);

    $conexao = new Conexao();
    $empresaService = new EmpresaService($empresa, $conexao);
    $empresaService->inserir();
 }

 // Recuperar todas as empresas
 if($acaoe == 'recuperar') {
    $empresa = new Motorista();
    $conexao = new Conexao();

    $motoristaService = new EmpresaService($motorista, $conexao);
    $motorista = $motoristaService->recuperar();
 }

 // Recuperar uma empresa específica
 if($acaoe == 'recuperarMotorista') {
    $motorista = new Motorista();
    $conexao = new Conexao();
   
    $motoristaService = new MotoristaService($motorista, $conexao);
    $motorista = $motoristaService->recuperarMotorista($ide);
 }

 // Excluir empresa
 if($acaoe == 'excluir') {
    $motorista = new Motorista();
    $conexao = new Conexao();

    $motorista->__set('id_motorista', $_POST['id_motorista']);

    $motoristaService = new MotoristaService($motorista, $conexao);
    $motoristaService->excluir();
 }

 // Alterar empresa
 if($acaoe == 'alterar') {
    $motorista = new Motorista();
    $motorista->__set('nome_motorista', $_POST['nome_motorista']);
    $motorista->__set('cpf', $_POST['cpf']);
    $motorista->__set('telefone', $_POST['telefone']);
    $motorista->__set('cnh', $_POST['cnh']);
    $motorista->__set('renavan', $_POST['renavan']);
    $motorista->__set('curriculo', $_POST['curriculo']);
    $motorista->__set('email_motorista', $_POST['email_motorista']);
    $motorista->__set('senha', $_POST['senha']);
    $motorista->__set('id_motorista', $_POST['id_motorista']);
    
    $conexao = new Conexao();
    $motoristaService = new MotoristaService($motorista, $conexao);
    $motoristaService->alterar();
    header('location:index.php?link=motoristas');
 }
?>
