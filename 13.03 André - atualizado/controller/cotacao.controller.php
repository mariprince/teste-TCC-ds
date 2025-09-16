<?php 
 require_once "model/cotacao.model.php";
 require_once "service/cotacao.service.php";
 require_once "conexao/conexao.php";
 
 @$acaoe = isset($_GET['acaoe']) ? $_GET['acaoe'] : $acaoe;
 @$ide   = isset($_GET['ide']) ? $_GET['ide'] : $ide;

 // Inserir cotacao
 if($acaoe == 'inserir') {
    $cotacao = new Cotacao();
    $cotacao->__set('data_saida', $_POST['data_saida']);
    $cotacao->__set('cep_origem', $_POST['cep_origem']);
    $cotacao->__set('endereco_origem', $_POST['endereco_origem']);
    $cotacao->__set('estimativa_entrega', $_POST['estimativa_entrega']);
    $cotacao->__set('cep_destino', $_POST['cep_destino']);
    $cotacao->__set('valor', $_POST['valor']);
    $cotacao->__set('endereco_destino', $_POST['endereco_destino']);
    $cotacao->__set('tipo_carga', $_POST['tipo_carga']);
    $cotacao->__set('peso', $_POST['peso']);
    $cotacao->__set('altura', $_POST['altura']);
    $cotacao->__set('largura', $_POST['largura']);
    $cotacao->__set('comprimento', $_POST['comprimento']);

    $conexao = new Conexao();
    $cotacaoService = new cotacaoService($cotacao, $conexao);
    $cotacaoService->inserir();
 }

 // Recuperar todas as cotacaos
 if($acaoe == 'recuperar') {
    $cotacao = new Cotacao();
    $conexao = new Conexao();

    $cotacaoService = new cotacaoService($cotacao, $conexao);
    $cotacao = $cotacaoService->recuperar();
 }

 // Recuperar uma cotacao específica
 if($acaoe == 'recuperarcotacao') {
    $cotacao = new Cotacao();
    $conexao = new Conexao();
   
    $cotacaoService = new cotacaoService($cotacao, $conexao);
    $cotacao = $cotacaoService->recuperarcotacao($ide);
 }

 // Excluir cotacao
 if($acaoe == 'excluir') {
    $cotacao = new Cotacao();
    $conexao = new Conexao();

    $cotacao->__set('id_cotacao', $_POST['id_cotacao']);

    $cotacaoService = new cotacaoService($cotacao, $conexao);
    $cotacaoService->excluir();
 }

 // Alterar cotacao
 if($acaoe == 'alterar') {
    $cotacao = new Cotacao();
    $cotacao->__set('data_saida', $_POST['data_saida']);
    $cotacao->__set('cep_origem', $_POST['cep_origem']);
    $cotacao->__set('endereco_origem', $_POST['endereco_origem']);
    $cotacao->__set('estimativa_entrega', $_POST['estimativa_entrega']);
    $cotacao->__set('cep_destino', $_POST['cep_destino']);
    $cotacao->__set('valor', $_POST['valor']);
    $cotacao->__set('endereco_destino', $_POST['endereco_destino']);
    $cotacao->__set('tipo_carga', $_POST['tipo_carga']);
    $cotacao->__set('peso', $_POST['peso']);
    $cotacao->__set('altura', $_POST['altura']);
    $cotacao->__set('largura', $_POST['largura']);
    $cotacao->__set('comprimento', $_POST['comprimento']);
    $cotacao->__set('id_cotacao', $_POST['id_cotacao']);
    
    $conexao = new Conexao();
    $cotacaoService = new cotacaoService($cotacao, $conexao);
    $cotacaoService->alterar();
    header('location:index.php?link=cotacaos');
 }
?>
