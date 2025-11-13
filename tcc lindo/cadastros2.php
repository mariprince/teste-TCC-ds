<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

  // Inicializar variáveis para o formulário de motorista
  $nomeMotorista = $cpf = $numCtt = $cnh = $renavan = $emailMotorista = $curriculo = $idMotorista = '';
  $acaoFormMotorista = 'inserir';
  $labelBotaoMotorista = 'Cadastrar';
  if (isset($_GET['metodo']) && in_array($_GET['metodo'], ['alterar', 'excluir']) && $_GET['tipo'] === 'motorista') {
    $metodo = $_GET['metodo'];
    $idMotorista = $_GET['id'] ?? '';
  }
  // Verificar se vai alterar/excluir motorista
  if (isset($_GET['metodo']) && in_array($_GET['metodo'], ['alterar', 'excluir'])) {
    $metodo = $_GET['metodo'];
    $acao = 'recuperarMotorista';
    $id = $_GET['id'] ?? '';
    require 'controller/motorista.controller.php'; // $empresa carregado
if (!empty($motorista) && is_object($motorista)) {
  $nome = $motorista->nome_completo ?? '';
  $senha = $motorista->senha ?? '';
  $cpf = $motorista->cpf ?? '';
  $numCtt = $motorista->numCtt ?? '';
  $cnh = $motorista->cnh ?? '';
  $renavan = $motorista->renavan ?? '';
  $email = $motorista->email_motorista ?? '';
  $curriculo = $motorista->curriculo ?? '';
  $id = $motorista->id_motorista ?? '';
  $acaoFormMotorista = $metodo;
  $labelBotaoMotorista = ucfirst($metodo);
}
    // aqui você buscaria o motorista no banco e popularia as variáveis
  }

  // Inicializar variáveis para o formulário de empresa
  $nomeEmpresa = $emailEmpresa = $cnpjEmpresa = $idEmpresa = '';
  $acaoFormEmpresa = 'inserir';
  $labelBotaoEmpresa = 'Cadastrar';

  // Verificar se vai alterar/excluir empresa
  if (isset($_GET['metodo']) && in_array($_GET['metodo'], ['alterar', 'excluir']) && $_GET['tipo'] === 'empresa') {
    $metodo = $_GET['metodo'];
    $idEmpresa = $_GET['id'] ?? '';
    // aqui você buscaria a empresa no banco e popularia as variáveis
  }
$cardAtivo = 'loginActive'; // padrão = motorista

if (isset($_GET['tipo']) && $_GET['tipo'] === 'empresa') {
    $cardAtivo = 'cadastroActive'; // empresa
}
  require_once 'controller/motorista.controller.php';
  require_once 'controller/empresa.controller.php';

$nome = $email = $senha = $cnpj = $id = '';
$acaoForm = 'inserir';
$labelBotao = 'Inserir';


if (isset($_GET['metodo']) && in_array($_GET['metodo'], ['alterar', 'excluir'])) {
    $metodo = $_GET['metodo'];
    $ide = $_GET['id'] ?? '';
    // Seta a ação para buscar usuário específico
    $acaoe = 'recuperarEmpresa';
    require 'controller/empresa.controller.php'; // $empresa carregado
if (!empty($empresa) && is_object($empresa[0])) {
    //if (isset($empresa) && is_object($empresa)) {
        $empresa = $empresa[0];
        $nome = $empresa->nome_empresa ?? '';
        $email = $empresa->email_empresa ?? '';
        $senha = $empresa->senha ??'';
        $cnpj = $empresa->cnpj ??'';
        $id = $empresa->id_empresa ??'' ;
        $acaoFormEmpresa = $metodo;
        $labelBotaoEmpresa = ucfirst($metodo);
        
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastros</title>
  <link rel="stylesheet" href="css/cadastro.css" />
 <script src="scripts/script.js" defer></script>
</head>

<body>
  <?php
 

  ?>

  <section class="containerPai">
    <div class="cardBI <?= $cardAtivo ?>">
      <!-- FORM MOTORISTA -->
      <div class="esquerda">
        <div class="formMotorista">
          <h2><?= $acaoFormMotorista === 'inserir' ? 'Cadastrar Motorista' : $labelBotaoMotorista . ' Motorista' ?></h2>
          <!-- Corrigido o caminho para a pasta controller -->
          <form id="formCadastroMotorista" action="motorista.controller.php?acao=<?=  $acaoFormMotorista ?>" method="POST" onsubmit="return true;" enctype="multipart/form-data">
            <input type="hidden" name="id_motorista" value="<?= $idMotorista ?>">

            <!-- Corrigido para não submeter o form -->
            <button type="button" class="voltar" onclick="javascript:history.back()">🠔</button>

            <input type="text" id="nome_completo" name="nome_completo" value="<?= htmlspecialchars($nome) ?>" placeholder="Nome Completo" required />
            <input type="text" id="cpf" maxlength="14" name="cpf" value="<?= htmlspecialchars($cpf) ?>" placeholder="CPF" oninput="mascaraCPF(this)" required />
            <input type="text" maxlength="15" id="numCtt" name="numCtt" value="<?= htmlspecialchars($numCtt) ?>" placeholder="Número Contato" oninput="mascaraTelefone(this)" />
            <input type="text" maxlength="11" id="CNH" name="cnh" value="<?= htmlspecialchars($cnh) ?>" placeholder="CNH-E" oninput="mascaraNumerica(this, 11)" required />
            <input type="text" maxlength="11" id="renavan" name="renavan" value="<?= htmlspecialchars($renavan) ?>" placeholder="RENAVAN" oninput="mascaraNumerica(this, 11)" />
            <input type="email" id="email_motorista" name="email_motorista" value="<?= htmlspecialchars($email) ?>" placeholder="Seu E-mail" required />

            <div class="senha-container">
              <input type="password" id="senha" name="senha" placeholder="Digite sua senha" <?= $acaoFormMotorista === 'inserir' ? 'required' : '' ?>>
              <button type="button" class="toggle-senha" onclick="toggleSenha(this)">👁️</button>
            </div>

            <label for="curriculo" class="form-label">
              <h3>Currículo</h3>
            </label>

            <?php if ($curriculo): ?>
              <div class="mb-2">
                <a href="curriculos/<?= htmlspecialchars($curriculo) ?>" target="_blank">Ver currículo atual</a>
              </div>
            <?php endif; ?>

            <input class="formcontrol" type="file" id="curriculo" name="curriculo" />
            <button type="submit" class="btn btn-outline-warning custom-btn"><?= $labelBotaoMotorista ?></button>
          </form>

          <a href="../paginas/login.php">Já tem conta? Login aqui</a>
        </div>

        <div class="cadastroMotorista">
          <h2>Quer ser <br />um motorista?</h2>
          <p>Nossos motoristas encontram caminhos para maior eficiência de realização de frete, venha você também!</p>
          <button class="motoristaButton">Quero Ser Motorista</button>
        </div>
      </div>

      <!-- FORM EMPRESA -->
      <div class="direita">
        <div class="empresaForm">
          <h2><?= $acaoFormEmpresa === 'inserir' ? 'Cadastrar Empresa' : $labelBotaoEmpresa . ' Empresa' ?></h2>
          <!-- Corrigido o caminho para a pasta controller -->
          <form class="formEmpresa" action="empresa.controller.php?acaoe=<?=  $acaoFormEmpresa ?>" method="POST" onsubmit="return true;">
            <input type="hidden" name="id_empresa" value="<?= $idEmpresa ?>">

            <!-- Corrigido para não submeter o form -->
            <button type="button" class="voltar" onclick="javascript:history.back()">🠔</button>

            <input type="text" name="nome_empresa" value="<?= htmlspecialchars($nome) ?>" placeholder="Nome Empresa" required>
            <input type="email" name="email_empresa" value="<?= htmlspecialchars($email) ?>" placeholder="Email Empresa" required>
            <input type="password" name="senha" placeholder="Crie sua Senha" <?= $acaoFormEmpresa === 'inserir' ? 'required' : '' ?>>
            <input type="text" id="cnpj" name="cnpj" value="<?= htmlspecialchars(trim($cnpj)); ?>" placeholder="CNPJ" oninput="formatarCNPJ(this)" maxlength="18" required />

            <br />
            <button type="submit" class=""><?= $labelBotaoEmpresa; ?></button>
          </form>
        </div>

        <div class="cadastroEmpresa">
          <h2 style="margin-bottom: 20px;">Quer adicionar sua<br />empresa e ser nosso parceiro?</h2>
          <button class="empresaButton">Quero ser parceiro!</button>
        </div>

        <a href="../paginas/login.php">Já cadastrou sua Empresa? Login aqui</a>
      </div>
    </div>
  </section>
</body>
</html>