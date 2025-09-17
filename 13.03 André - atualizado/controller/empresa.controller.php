<?php 
 require_once(__DIR__ . '/../model/empresa.model.php');
 require_once(__DIR__ . '/../service/empresa.service.php');
 require_once(__DIR__ . '/../conexao/conexao.php');

 
 @$acaoe = isset($_GET['acaoe']) ? $_GET['acaoe'] : $acaoe;
 @$ide   = isset($_GET['ide']) ? $_GET['ide'] : $ide;

 // Inserir Empresa
 if($acaoe == 'inserir') {
    $empresa = new Empresa();
    $empresa->__set('nome_empresa', $_POST['nome_empresa']);
    $empresa->__set('email_empresa', $_POST['email_empresa']);
    $empresa->__set('senha', $_POST['senha']);
    $empresa->__set('cnpj', $_POST['cnpj']);

    $conexao = new Conexao();
    $empresaService = new EmpresaService($empresa, $conexao);
    $empresaService->inserir();
 }

 // Recuperar todas as empresas
 if($acaoe == 'recuperar') {
    $empresa = new Empresa();
    $conexao = new Conexao();

    $empresaService = new EmpresaService($empresa, $conexao);
    $empresa = $empresaService->recuperar();
 }

 // Recuperar uma empresa específica
 if($acaoe == 'recuperarEmpresa') {
    $empresa = new Empresa();
    $conexao = new Conexao();
   
    $empresaService = new EmpresaService($empresa, $conexao);
    $empresa = $empresaService->recuperarEmpresa($ide);
 }

 // Excluir empresa
 if($acaoe == 'excluir') {
    $empresa = new Empresa();
    $conexao = new Conexao();

    $empresa->__set('id_empresa', $_POST['id_empresa']);

    $empresaService = new EmpresaService($empresa, $conexao);
    $empresaService->excluir();
 }

 // Alterar empresa
 if($acaoe == 'alterar') {
    $empresa = new Empresa();
    $empresa->__set('nome_empresa', $_POST['nome_empresa']);
    $empresa->__set('email_empresa', $_POST['email_empresa']);
    $empresa->__set('senha', $_POST['senha']);
    $empresa->__set('cnpj', $_POST['cnpj']);
    $empresa->__set('id_empresa', $_POST['id_empresa']);
    
    $conexao = new Conexao();
    $empresaService = new EmpresaService($empresa, $conexao);
    $empresaService->alterar();
   // header('location:index.php?link=empresas');
 }
?>
