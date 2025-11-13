

<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    header('location:../paginas/login.php?tipo=empresa');
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
    header('location:../paginas/areaRestritaE.php?link=cotacao&msg=delete');
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
    header('location:../paginas/areaRestritaE.php?link=cotacao&msg=updated');
 }
 if($acaoe ==='recuperarLoginE'){
  
  $empresa = new Empresa();
  $conexao = new Conexao();
  
  $email = $_POST['email_empresa'];
  $senha = $_POST['senha'];

  $empresaService = new EmpresaService($empresa,$conexao);
  $empresaObj = $empresaService->recuperarLoginC($email,$senha);

  if(!$empresaObj || !isset($empresaObj->email_empresa)){
      echo '<script>alert("Empresa com email desconhecido")</script>
      <meta http-equiv="refresh" content="0;url=../paginas/login.php?tipo=empresa">';
      exit;
  }

  $senhaValida = (function($senhaDigitada, $senhaBanco){
      if (password_verify($senhaDigitada, $senhaBanco)) return true;
      return $senhaDigitada === $senhaBanco; // compatibilidade com senhas antigas sem hash
  })($senha, $empresaObj->senha);

  if(!$senhaValida){
      echo '<script>alert("Senha inválida")</script>
      <meta http-equiv="refresh" content="0;url=../paginas/login.php?tipo=empresa">';
      exit;
  }

  $_SESSION['empresaLogado']=$empresaObj->nome_empresa;
  $_SESSION['emailEmpresaLogado']=$empresaObj->email_empresa;
  $_SESSION['idEmpresaLogado']=$empresaObj->id_empresa;
  unset($_SESSION['motoristaLogado']);
  unset($_SESSION['emailMotoristaLogado']);
  unset($_SESSION['id_motorista']);
  header('location:paginas/dashboard.php');
  exit;
  // echo $_SESSION['idEmpresaLogado'];
}

?>
