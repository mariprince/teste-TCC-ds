<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$acaoc = 'recuperar';
require '../cotacao.controller.php';
// No login do motorista:
$_SESSION['motoristaLogado'];
// No login da empresa:
$_SESSION['empresaLogado'];


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Criar Frete</title>
  <link rel="shortcut icon" type="imagex/png" href="/imagens/logo.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="..\css\dashboard.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">

  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
  <header>
  <nav>
      <div class="logo-group">
        <a href="#" class="logo img"><img src="../imagens/logosite.png" alt="DevLog"></a>
        <span id="span">DevLog</span>
      </div>
      <ul class="nav-list">
    <li><a href="/paginas/motorista.html">Motorista</a></li>
    <li><a href="/paginas/empresa.html">Empresa</a></li>
    <li><a href="../index.php">Início</a></li>
    <a href="../cotacao2.php">Cotação</a>
    
    <!-- Ícone e nome do usuário logado -->
    <span class="user">👤
        <?php
        if (isset($_SESSION['empresaLogado'])) {
            echo $_SESSION['empresaLogado'];
        } elseif (isset($_SESSION['motoristaLogado'])) {
            echo $_SESSION['motoristaLogado'];
        }
        ?>
    </span>

    <a href="/paginas/login.php" class="logout">Sair</a>
</ul>
<div class="mobile-menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
    </nav>
  </header>

  <main class="container">
    <div class="dashboard-header">
      <h1>Dashboard</h1>
      <p>Bem-vindo 
<?php 
    if (isset($_SESSION['motoristaLogado'])) {
        echo $_SESSION['motoristaLogado'];
    } elseif (isset($_SESSION['empresaLogado'])) {
        echo $_SESSION['empresaLogado'];
    }
?>, gerencie seus fretes e acompanhe suas atividades.</p>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
          <div class="stat-number">0</div>
          <div class="stat-label">Total de Fretes</div>
        </div>
      </div>

      <div class="stat-card pending">
        <div class="stat-icon">⏰</div>
        <div class="stat-info">
          <div class="stat-number">0
          </div>
          <div class="stat-label">Pendentes</div>
        </div>
      </div>

      <div class="stat-card in-progress">
        <div class="stat-icon">🚛</div>
        <div class="stat-info">
          <div class="stat-number">0</div>
          <div class="stat-label">Em Andamento</div>
        </div>
      </div>

      <div class="stat-card completed">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
          <div class="stat-number">0</div>
          <div class="stat-label">Concluídos</div>
        </div>
      </div>
    </div>

    <div class="tabs">
  <button class="tab-btn active" onclick="openTab(event, 'disponiveis')">🚚 Fretes Disponíveis</button>
  <button class="tab-btn" onclick="openTab(event, 'aceitos')">📋 Fretes Aceitos</button>
</div>

    <div class="fretes-section" id="disponiveis">
      <h2>Fretes Disponíveis</h2>
      <div class="empty-state" style="display:grid; gap: 10px">
        <?php if(!empty($cotacao)):?>
        <table class="table table-bordered table-hover">
          <thead class="">
            <tr>
              <th>ID</th>
              <th>Data Saída</th>
              <th>Cep Origem</th>
              <th>Endereço Origem</th>
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($cotacao as $cota): ?>
          <?php if ($cota->status != 'ACEITO' && $cota->status != 'ATRIBUIDO'): ?>
          <tr>
            <td><?= $cota->id_cotacao ?></td>
            <td><?= htmlspecialchars($cota->data_saida) ?></td>
            <td><?= htmlspecialchars($cota->cep_origem) ?></td>
            <td><?= htmlspecialchars($cota->endereco_origem) ?></td>
            <td>R$ <?= number_format($cota->valor, 2, ',', '.') ?></td>
            <td>
              <a href="../paginas/areaRestritaCota.php" class="btn btn-sm btn-warning">Detalhes</a>
              <?php if (isset($_SESSION['motoristaLogado'])):?>
                <form action="aceitar_frete.php" method="POST" style="display:inline;">
                <input type="hidden" name="id_cotacao" value="<?= $cota->id_cotacao ?>">
                  <button type="submit" title="Aceitar frete" style="border:none;background:none;font-size:20px;">✅</button>
                </form>
                <?php endif;?>
            </td>
          </tr>
          <?php endif; ?>
        <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="warning-icon">⚠️</div>
        <p>Nenhum frete disponível</p>
        <?php endif;?>
        <div class="criarBtn">
        <?php if (isset($_SESSION['empresaLogado'])):?>
            <a class="tab-btn active" href="../cotacao2.php"> Criar Frete </a> 
            <?php endif;?>
        </div>
      </div>
    </div>
    <div id="aceitos" class="tabcontent" style="display:none;">
  <h2>Fretes Aceitos</h2>
  <?php
  require_once '../app/database/Conexao.php';
  $conexao = new Conexao();
  $conn = $conexao->conectar();

  $id_motorista = $_SESSION['id_motorista'] ?? 0;
  $query = "SELECT * FROM cotacao WHERE status IN ('ACEITO', 'ATRIBUIDO') AND id_motorista = :id_motorista";
  $stmt = $conn->prepare($query);
  $stmt->bindValue(':id_motorista', $id_motorista);
  $stmt->execute();
  $fretesAceitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?php if (!empty($fretesAceitos)): ?>
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Data Saída</th>
          <th>Cep Origem</th>
          <th>Endereço Origem</th>
          <th>Valor</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($fretesAceitos as $f): ?>
          <tr>
            <td><?= $f['id_cotacao'] ?></td>
            <td><?= htmlspecialchars($f['data_saida']) ?></td>
            <td><?= htmlspecialchars($f['cep_origem']) ?></td>
            <td><?= htmlspecialchars($f['endereco_origem']) ?></td>
            <td>R$ <?= number_format($f['valor'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($f['status']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="text-center" style="margin-top:15px;">
      <p>Você ainda não aceitou nenhum frete.</p>
    </div>
  <?php endif; ?>
</div>
  </main>

  <section class="footter">
    <div class="box-conteiner">
      <div class="box">
        <h3><i class="fa fa-truck"></i> DevLog</h3>
        <p>Conectar motoristas qualificados com empresas que precisam realizar frete é nossa maior especialidade!</p>
        <div class="share">
          <a href="#" class="fab fa-facebook"></a>
          <a href="#" class="fab fa-twitter"></a>
          <a href="#" class="fab fa-instagram"></a>
          <a href="#" class="fab fa-whatsapp"></a>
        </div>
      </div>
      <div class="box">
        <h3>Entre em contato</h3>
        <a href="" class="links"><i class="fas fa-phone"></i> +123-456-789</a>
        <a href="" class="links"><i class="fas fa-phone"></i> +123-456-789</a>
        <a href="" class="links"><i class="fas fa-envelope"></i> DevLogCJM@email.com.br</a>
        <a href="" class="links"><i class="fas fa-map-marked-alt"></i> Rua dos bobos, n°: 0</a>
      </div>
      <div class="box">
        <h3>Navegação</h3>
        <a href="../index.php" class="links"><i class="fas fa-arrow-circle-right"></i> Página Inicial</a>
        <a href="/paginas/motorista.html" class="links"><i class="fas fa-arrow-circle-right"></i> Motorista</a>
        <a href="/paginas/empresa.html" class="links"><i class="fas fa-arrow-circle-right"></i> Empresa</a>
        <a href="/paginas/login.php" class="links"><i class="fas fa-arrow-circle-right"></i> Login<a>
            <a href="../cadastros2.php" class="links"><i class="fas fa-arrow-circle-right"></i> Cadastre-se</a>
      </div>
      <div class="box">
        <h3>Receba notícias</h3>
        <p>Fique por dentro de nossas novidades</p>
        <input type="email" placeholder="Digite seu email..." class="email">
        <input type="submit" value="Enviar" class="btn">
        <img src="./image/payment.png" alt="">
      </div>
    </div>
  </section>

  <footer class="bg-orange-600 text-white py-4" style="text-align: center;">
    <p>&copy; 2025 <span>DevLog </span> | Todos os direitos reservados</p>
  </footer>

  <script>
    // Função para alternar entre abas
    function openTab(evt, tabName) {
      // Esconde todos os conteúdos das abas
      var tabcontent = document.getElementsByClassName("tabcontent");
      for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      
      // Esconde a seção de fretes disponíveis
      var fretesDisponiveis = document.getElementById("disponiveis");
      if (fretesDisponiveis) {
        fretesDisponiveis.style.display = "none";
      }

      // Remove a classe 'active' de todos os botões
      var tablinks = document.getElementsByClassName("tab-btn");
      for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }

      // Mostra a aba atual e adiciona 'active' ao botão clicado
      var tabElement = document.getElementById(tabName);
      if (tabElement) {
        tabElement.style.display = "block";
      }
      if (evt && evt.currentTarget) {
        evt.currentTarget.className += " active";
      }
    }

    // Verifica se há parâmetro 'tab' na URL ao carregar a página
    window.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const tab = urlParams.get('tab');
      
      if (tab === 'aceitos') {
        // Simula clique no botão de fretes aceitos
        var btnAceitos = document.querySelector('button[onclick*="aceitos"]');
        if (btnAceitos) {
          openTab(null, 'aceitos');
          btnAceitos.className += " active";
          // Remove active do botão de disponíveis
          var btnDisponiveis = document.querySelector('button[onclick*="disponiveis"]');
          if (btnDisponiveis) {
            btnDisponiveis.className = btnDisponiveis.className.replace(" active", "");
          }
        }
      }
    });
  </script>

</body>

</html>