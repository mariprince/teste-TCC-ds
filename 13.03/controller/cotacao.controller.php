<?php 
if (session_status() === PHP_SESSION_NONE) {
   session_start();
 }
 
require_once(__DIR__ . '/../model/cotacao.model.php');
require_once(__DIR__ . '/../service/cotacao.service.php');
require_once(__DIR__ . '/../conexao/conexao.php');

 @$acaoc = isset($_GET['acaoc']) ? $_GET['acaoc'] : $acaoc;
 @$idc   = isset($_GET['idc']) ? $_GET['idc'] : $idc;

 // Inserir cotacao
 if($acaoc == 'inserir') {
    $cotacao = new Cotacao();
    $cotacao->__set('id_cotacao', $_POST['id_cotacao']);
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
    $cotacao->__set('id_empresa', $_POST['id_empresa']);

    $conexao = new Conexao();
    $cotacaoService = new CotacaoService($cotacao, $conexao);
    $cotacaoService->inserir();
 }

 // Recuperar todas as cotacaos
 if($acaoc == 'recuperar') {
    $cotacao = new Cotacao();
    $conexao = new Conexao();

    $cotacaoService = new CotacaoService($cotacao, $conexao);
    $cotacao = $cotacaoService->recuperar();
 }

 // Recuperar uma cotacao específica
 if($acaoc == 'recuperarCotacao') {
    $cotacao = new Cotacao();
    $conexao = new Conexao();
   
    $cotacaoService = new CotacaoService($cotacao, $conexao);
    $cotacao = $cotacaoService->recuperarCotacao($idc);

  
 }

 // Excluir cotacao
 if($acaoc == 'excluir') {
    $cotacao = new Cotacao();
    $conexao = new Conexao();

    $cotacao->__set('id_cotacao', $_POST['id_cotacao']);

    $cotacaoService = new CotacaoService($cotacao, $conexao);
    $cotacaoService->excluir();
    header('location:../paginas/areaRestritaCota.php?link=cotacao&msg=delete');
 }

 // Alterar cotacao
 if($acaoc == 'alterar') {
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
    $cotacaoService = new CotacaoService($cotacao, $conexao);
    $cotacaoService->alterar();
     header('location:../paginas/areaRestritaCota.php?link=cotacao&msg=updated');
 }

?>
