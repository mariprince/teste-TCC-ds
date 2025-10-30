<?php
 if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if(!isset($_SESSION['idEmpresaLogado'])){
  header('location:paginas/login.php?tipo=empresa');
    exit;
}

  $id_Empresa = $_SESSION['idEmpresaLogado'];
  $dataSaida = $estimativaEntrega = $cepOrigem = $enderecoOrigem = $cepDestino = $enderecoDestino = $valor = $tipoCargo = $peso = $altura = $largura = $comprimento = $idCotacao = $status = '';
  $acaoFormCotacao = 'inserir';
  $labelBotaoCotacao = 'CRIAR FRETE';
  if (isset($_GET['metodo']) && in_array($_GET['metodo'], ['alterar', 'excluir']) && $_GET['tipo'] === 'cotacao') {
    $metodo = $_GET['metodo'];
    $idCotacao = $_GET['id'] ?? '';
  }

  require_once 'controller/cotacao.controller.php';
  if (isset($_GET['metodo']) && in_array($_GET['metodo'], ['alterar', 'excluir'])) {
    $metodo = $_GET['metodo'];
    $idc = $_GET['id'] ?? '';
    $acaoc = 'recuperarCotacao';
    require 'controller/cotacao.controller.php';

   

      if(!empty($cotacao)) {
        $dataSaida = $cotacao->data_saida ?? '';
        $estimativaEntrega = $cotacao -> estimativa_entrega ?? '';
        $cepOrigem = $cotacao -> cep_origem ?? '';
        $enderecoOrigem = $cotacao -> endereco_origem ?? '';
        $cepDestino = $cotacao -> cep_destino ?? '';
        $enderecoDestino = $cotacao -> endereco_destino ?? '';
        $valor = $cotacao -> valor ?? '';
        $tipoCargo = $cotacao -> tipo_carga ?? '';
        $peso = $cotacao -> peso ?? '';
        $altura = $cotacao -> altura ?? '';
        $largura = $cotacao -> largura ?? '';
        $comprimento = $cotacao -> comprimento ?? '';
        $status = $cotacao->status ?? '';
        $id = $cotacao->id_cotacao ?? '';
        $acaoFormCotacao = $metodo;
        $labelBotaoCotacao = ucfirst($metodo);
       // print_r($cotacao);

      }
     
  }
  
?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cotação Frete</title>
  <link rel="shortcut icon" type="imagex/png" href="/imagens/logo.ico">
  <link rel="stylesheet" href="..\css\cotacao.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col">
  <header style="width: 100vw;">
    <nav>
      <a class="logo">🚚 DevLog</a>
      <div class="mobile-menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
      <ul class="nav-list">
        <li><a href="../index.php" style="color: #fff;text-decoration: none ;">Início</a></li>
        <li><a href="../cadastros2.php" style="color: #fff;text-decoration: none ;">Cadastrar</a></li>
      </ul>
    </nav>
  </header>

  <!-- ✅ Conteúdo principal dentro de <main> -->
  <main class="flex-grow">
    <!-- Formulário -->
    <form class="cotar p-4" action="cotacao.controller.php?acaoc=<?=  $acaoFormCotacao ?>" method="POST" onsubmit="return true;">
      <!-- Datas -->
      <h2 <?= $acaoFormCotacao === 'inserir' ? 'Cadastrar Cotacao' : $labelBotaoCotacao . ' Cotacao' ?>class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Datas e Horários</h2>
      <input type="hidden" name="id_cotacao" value="<?= $idCotacao ?>">
      <input type="hidden" name="id_empresa" value="<?= $_SESSION['idEmpresaLogado']; ?>">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label for="data_hora_saida" class="font-medium" style="font-weight: 600;">Data e Hora de Saída</label>
          <input type="datetime-local" id="data_saida" name="data_saida"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm  mt-2 focus:outline-none" value="<?= htmlspecialchars($dataSaida) ?>">
        </div>
        <div class="">
          <label for="estimativa_entrega" class="font-medium" style="font-weight: 600;">Estimativa de
            Entrega</label>
          <input type="datetime-local" id="estimativa_entrega" name="estimativa_entrega"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm  mt-2 focus:outline-none" value="<?= htmlspecialchars($estimativaEntrega) ?>">
        </div>
      </div>

      <!-- Endereço -->
      <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Endereço</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="font-medium">CEP - Origem</label>
          <input type="text" name="cep_origem" id="cep_origem" value="<?= htmlspecialchars($cepOrigem) ?>" placeholder="Digite o CEP de origem"
            class="w-full border px-3 py-2 rounded-md mt-2">
          <label class="font-medium mt-2 block">Endereço de Origem</label>
          <input type="text" name="endereco_origem" placeholder="Rua, número, cidade, estado"
            class="w-full border px-3 py-2 rounded-md mt-2" value="<?= htmlspecialchars($enderecoOrigem ) ?>">
        </div>
        <div>
          <label class="font-medium">CEP - Destino</label>
          <input type="text" name="cep_destino" id="cep_destino" value="<?= htmlspecialchars($cepDestino) ?>" placeholder="Digite o CEP de destino"
            class="w-full border px-3 py-2 rounded-md mt-2">
          <label class="font-medium mt-2 block">Endereço de Destino</label>
          <input type="text" name="endereco_destino" id="endereco_destino" value="<?= htmlspecialchars($enderecoDestino) ?>" placeholder="Rua, número, cidade, estado"
            class="w-full border px-3 py-2 rounded-md mt-2">
        </div>
      </div>

      <!-- Sobre a carga -->
      <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Sobre a Carga</h2>
      <div class="">
        <div class="flex gap-4 items-center" style="justify-content: center;">
          <div>
            <label class="block font-medium mb-1">Formato</label>
            <select class="w-full border px-3 py-2 rounded-md" name="tipo_carga" id="tipo_carga">
              <option value="<?= htmlspecialchars($tipoCargo) ?>"><?= htmlspecialchars($tipoCargo) ?></option>
              <option value="A granel">A granel</option>
              <option value="Perecíveis">Perecíveis</option>
              <option value="Secas">Secas</option>
              <option value="Frágeis">Frágeis</option>
              <option value="perigosa" id="perigosa">Perigosas</option>
              <option value="Vivas">Vivas</option>
              <option value="Frigoríficas">Frigoríficas</option>
              <option value="Preciosa">Preciosa</option>
            </select>
          </div>
          <div>
            <label class="block font-medium mb-1">Peso</label>
            <select class="w-full border px-3 py-2 rounded-md" name="peso" id="peso" >
              <option value="<?= htmlspecialchars($peso) ?>"><?= htmlspecialchars($peso) ?></option>
              <option value="5">Até 5Kg</option>
              <option value="10">Até 10Kg</option>
              <option value="25">Até 25Kg</option>
              <option value="50">Até 50Kg</option>
              <option value="100">Até 100Kg</option>
             
            </select>
          </div>
        </div>

        <div class="flex  gap-4 items-center" style="justify-content: center; padding-top: 1rem;">
          <div style="justify-items: center;">
            <label class="block font-medium mb-1">Altura</label>
            <input type="text" class="w-24 border px-3 py-2 rounded-md" name="altura" id="altura" value="<?= htmlspecialchars($altura) ?>" placeholder="00">
          </div>
          <div style="justify-items: center;">
            <label class="block font-medium mb-1">Largura</label>
            <input type="text" class="w-24 border px-3 py-2 rounded-md" name="largura" id="endereco_destino" value="<?= htmlspecialchars($enderecoDestino) ?>" placeholder="00">
          </div>
          <div style="justify-items: center;">
            <label class="block font-medium mb-1">Comprimento</label>
            <input type="text" class="w-24 border px-3 py-2 rounded-md" name="comprimento" id="comprimento" value="<?= htmlspecialchars($comprimento) ?>" placeholder="00">
          </div>
        </div>
        <div class="valorFrete" style="justify-items: center;">
          <label class="block font-medium mb-1">Valor Do Frete</label>
          <input type="text" class="w-24 border px-3 py-2 rounded-md" name="valor" id="valor" value="<?= htmlspecialchars($valor) ?>" placeholder="00.00">
        </div>
        <div class="cargaPerigosa">
          <label for="">⚠️ Carga Perigosa ⚠️</label>
          <input type="checkbox" id="checkboxcargaPerigosa">
          <div id="popup">
            <div style="display: flex; justify-content: space-around;">
            <H2 style="color: rgb(236, 85, 39);">⚠️ CARGA PERIGOSA ⚠️</H2>
            <div class="content" style="justify-content: space-around;">
            <button onclick="closePopup()" style="cursor: pointer; right: 15rem; position: relative; color: red;">X</button>
          </div>
          </div>
            <form action="">
              <div class="divChecks">
                <input type="checkbox" id="cargas" class="cargas" placeholder="">
                <label for="" id="labelCargas" class="labelCargas">Pictograma</label>  
              </div>
              <div class="divChecks">
              <input type="checkbox" id="cargas" class="cargas" style="">
              <label for="" id="labelCargas" class="labelCargas">Ficha de Dados de Segurança</label>  
            </div>
            <div class="divChecks">
              <input type="checkbox" id="cargas" class="cargas" placeholder="">
              <label for="" id="labelCargas" class="labelCargas">Identificação - N° de risco e N° ONU</label>  
            </div>
            <input type="hidden" id="status" name="status" value="aberta">

            </form>
          </div>
        </div>
        <div class="text-center mb-8" style="padding-top: 1rem;">
          <button class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition"
            onclick="openPopup()"><?= $labelBotaoCotacao ?></button>
        </div>  
      </div>
    </form>
  </main>

  <!-- ✅ Footer -->
  <footer class="bg-orange-600 text-white py-4 text-center" style="position: relative;">
    <p>&copy; 2025 <span>DevLog</span> | Todos os direitos reservados</p>
  </footer>
  <?php  echo $_SESSION['idEmpresaLogado']; ?>
</body>

<script>
  /*function openPopup(
  ) {
    const checkboxcargaPerigosa = document.getElementById("checkboxcargaPerigosa");
    const selectcargaPerigosa = document.getElementById("tipos");

    if (checkboxcargaPerigosa.checked && selectcargaPerigosa.value === "perigosa") {
      document.getElementById("popup").classList.add("show");
    }

  }
  function closePopup() {
    document.getElementById("popup").classList.remove("show");
  }*/

</script>

</html>