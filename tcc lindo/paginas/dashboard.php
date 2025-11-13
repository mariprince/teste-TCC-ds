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

// Conecta ao banco para buscar estatísticas
require_once '../conexao/conexao.php';
$conexaoStats = new Conexao();
$connStats = $conexaoStats->conectar();

// Conta total de fretes
$queryTotal = "SELECT COUNT(*) as total FROM cotacao";
$stmtTotal = $connStats->query($queryTotal);
$totalFretes = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

// Conta fretes pendentes (status ABERTA)
$queryPendentes = "SELECT COUNT(*) as total FROM cotacao WHERE status = 'ABERTA'";
$stmtPendentes = $connStats->query($queryPendentes);
$fretesPendentes = $stmtPendentes->fetch(PDO::FETCH_ASSOC)['total'];

// Conta fretes em andamento (status ATRIBUIDA)
$queryAndamento = "SELECT COUNT(*) as total FROM cotacao WHERE status = 'ATRIBUIDA'";
$stmtAndamento = $connStats->query($queryAndamento);
$fretesAndamento = $stmtAndamento->fetch(PDO::FETCH_ASSOC)['total'];

// Conta fretes concluídos (status CONCLUIDA)
$queryConcluidos = "SELECT COUNT(*) as total FROM cotacao WHERE status = 'CONCLUIDA'";
$stmtConcluidos = $connStats->query($queryConcluidos);
$fretesConcluidos = $stmtConcluidos->fetch(PDO::FETCH_ASSOC)['total'];

// Busca dados do usuário logado para o perfil
$dadosUsuario = null;
$tipoUsuario = null;
if (isset($_SESSION['id_motorista'])) {
    $queryMotorista = "SELECT * FROM Motorista WHERE id_motorista = :id";
    $stmtMotorista = $connStats->prepare($queryMotorista);
    $stmtMotorista->bindValue(':id', $_SESSION['id_motorista']);
    $stmtMotorista->execute();
    $dadosUsuario = $stmtMotorista->fetch(PDO::FETCH_ASSOC);
    $tipoUsuario = 'motorista';
} elseif (isset($_SESSION['idEmpresaLogado'])) {
    $queryEmpresa = "SELECT * FROM Empresa WHERE id_empresa = :id";
    $stmtEmpresa = $connStats->prepare($queryEmpresa);
    $stmtEmpresa->bindValue(':id', $_SESSION['idEmpresaLogado']);
    $stmtEmpresa->execute();
    $dadosUsuario = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);
    $tipoUsuario = 'empresa';
}

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
    <span class="user" id="userProfileBtn" style="cursor: pointer;" title="Ver perfil">👤
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
          <div class="stat-number"><?= $totalFretes ?></div>
          <div class="stat-label">Total de Fretes</div>
        </div>
      </div>

      <div class="stat-card pending">
        <div class="stat-icon">⏰</div>
        <div class="stat-info">
          <div class="stat-number"><?= $fretesPendentes ?></div>
          <div class="stat-label">Pendentes</div>
        </div>
      </div>

      <div class="stat-card in-progress">
        <div class="stat-icon">🚛</div>
        <div class="stat-info">
          <div class="stat-number"><?= $fretesAndamento ?></div>
          <div class="stat-label">Em Andamento</div>
        </div>
      </div>

      <div class="stat-card completed">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
          <div class="stat-number"><?= $fretesConcluidos ?></div>
          <div class="stat-label">Concluídos</div>
        </div>
      </div>
    </div>

    <div class="tabs">
  <button class="tab-btn active" id="btn-disponiveis" data-tab="disponiveis">🚚 Fretes Disponíveis</button>
  <button class="tab-btn" id="btn-aceitos" data-tab="aceitos">📋 Fretes Aceitos</button>
</div>

    <div class="fretes-section tabcontent" id="disponiveis">
      <h2>Fretes Disponíveis</h2>
      <div class="empty-state" style="display:grid; gap: 10px">
        <?php 
          // Calcula fretes visíveis para o perfil atual
          $cotacoesVisiveis = [];
          if (!empty($cotacao)) {
            foreach ($cotacao as $c) {
              if (isset($_SESSION['idEmpresaLogado']) && (int)$c->id_empresa !== (int)$_SESSION['idEmpresaLogado']) {
                continue;
              }
              if ($c->status == 'ATRIBUIDA' || $c->status == 'CONCLUIDA') {
                continue;
              }
              $cotacoesVisiveis[] = $c;
            }
          }
        ?>
        <?php if (!empty($cotacoesVisiveis)): ?>
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
              <?php foreach ($cotacoesVisiveis as $cota): ?>
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
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="warning-icon">⚠️</div>
          <p>Nenhum frete disponível</p>
        <?php endif; ?>
        <div class="criarBtn">
        <?php if (isset($_SESSION['empresaLogado'])):?>
            <a class="tab-btn active" href="../cotacao2.php" style="background: #e97400; color: #fff;"> Criar Frete </a> 
            <?php endif;?>
        </div>
      </div>
    </div>
    <div class="fretes-section tabcontent" id="aceitos" style="display:none;">
  <h2>Fretes Aceitos</h2>
  <?php
  require_once '../conexao/conexao.php';
  $conexao = new Conexao();
  $conn = $conexao->conectar();

  // Verifica se é motorista ou empresa logado
  if (isset($_SESSION['motoristaLogado'])) {
    // Motorista: mostra apenas seus fretes aceitos
    $id_motorista = $_SESSION['id_motorista'] ?? 0;
    $query = "SELECT c.*, m.nome_completo as motorista_nome 
              FROM cotacao c 
              LEFT JOIN Motorista m ON c.id_motorista = m.id_motorista 
              WHERE c.status = 'ATRIBUIDA' AND c.id_motorista = :id_motorista";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id_motorista', $id_motorista);
    $stmt->execute();
    $fretesAceitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    // Empresa: mostra apenas fretes aceitos criados por ela, com nome do motorista
    $id_empresa = $_SESSION['idEmpresaLogado'] ?? 0;
    $query = "SELECT c.*, m.nome_completo as motorista_nome 
              FROM cotacao c 
              LEFT JOIN Motorista m ON c.id_motorista = m.id_motorista 
              WHERE c.status = 'ATRIBUIDA' AND c.id_empresa = :id_empresa";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id_empresa', $id_empresa);
    $stmt->execute();
    $fretesAceitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
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
          <?php if (isset($_SESSION['empresaLogado'])): ?>
            <th>Motorista</th>
          <?php endif; ?>
          <th>Ações</th>
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
            <?php if (isset($_SESSION['empresaLogado'])): ?>
              <td><?= htmlspecialchars($f['motorista_nome'] ?? 'Não atribuído') ?></td>
            <?php endif; ?>
            <td>
              <a href="../paginas/areaRestritaCota.php" class="btn btn-sm btn-warning">Detalhes</a>
              <?php if (isset($_SESSION['motoristaLogado'])):?>
                <form action="finalizar_frete.php" method="POST" style="display:inline;">
                <input type="hidden" name="id_cotacao" value="<?= $f['id_cotacao'] ?>">
                  <button type="submit" title="Finalizar frete" style="border:none;background:none;font-size:20px;">🆗</button>
                </form>
                <?php endif;?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="text-center" style="margin-top:15px;">
      <p><?= isset($_SESSION['motoristaLogado']) ? 'Você ainda não aceitou nenhum frete.' : 'Nenhum frete foi aceito ainda.' ?></p>
    </div>
  <?php endif; ?>
</div>

  <!-- Modal de Perfil -->
  <div id="profileModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; border-radius:15px; padding:30px; max-width:500px; width:90%; box-shadow:0 10px 30px rgba(0,0,0,0.3); position:relative;">
      <button id="closeModal" style="position:absolute; top:15px; right:15px; background:none; border:none; font-size:24px; cursor:pointer; color:#666;">&times;</button>
      
      <div style="text-align:center; margin-bottom:20px;">
        <div style="width:100px; height:100px; background:linear-gradient(135deg, #e97400, #ff9933); border-radius:50%; margin:0 auto 15px; display:flex; align-items:center; justify-content:center; font-size:50px;">
          <?php echo $tipoUsuario === 'motorista' ? '🚚' : '🏢'; ?>
        </div>
        <h2 style="margin:0; color:#333;">
          <?php 
          if (isset($dadosUsuario)) {
              echo $tipoUsuario === 'motorista' ? htmlspecialchars($dadosUsuario['nome_completo']) : htmlspecialchars($dadosUsuario['nome_empresa']);
          }
          ?>
        </h2>
        <p style="color:#666; margin:5px 0;"><?php echo $tipoUsuario === 'motorista' ? 'Motorista' : 'Empresa'; ?></p>
      </div>

      <div style="background:#f8f9fa; padding:20px; border-radius:10px; margin-bottom:20px;">
        <?php if ($tipoUsuario === 'motorista' && isset($dadosUsuario)): ?>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-envelope"></i> Email:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['email'] ?? $dadosUsuario['email_motorista'] ?? 'Não informado') ?></p>
          </div>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-id-card"></i> CPF:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['cpf']) ?></p>
          </div>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-phone"></i> Telefone:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['telefone'] ?? $dadosUsuario['numCtt'] ?? 'Não informado') ?></p>
          </div>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-id-badge"></i> CNH:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['cnh'] ?? 'Não informado') ?></p>
          </div>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-car"></i> Renavan:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['renavan'] ?? 'Não informado') ?></p>
          </div>
          <div>
            <strong style="color:#e97400;"><i class="fas fa-calendar"></i> Cadastrado em:</strong>
            <p style="margin:5px 0;"><?= date('d/m/Y', strtotime($dadosUsuario['data_cadastro'])) ?></p>
          </div>
        <?php elseif ($tipoUsuario === 'empresa' && isset($dadosUsuario)): ?>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-envelope"></i> Email:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['email_empresa']) ?></p>
          </div>
          <div style="margin-bottom:15px;">
            <strong style="color:#e97400;"><i class="fas fa-building"></i> CNPJ:</strong>
            <p style="margin:5px 0;"><?= htmlspecialchars($dadosUsuario['cnpj']) ?></p>
          </div>
          <div>
            <strong style="color:#e97400;"><i class="fas fa-calendar"></i> Cadastrado em:</strong>
            <p style="margin:5px 0;"><?= date('d/m/Y', strtotime($dadosUsuario['data_cadastro'])) ?></p>
          </div>
        <?php endif; ?>
      </div>

      <div style="display:flex; gap:10px;">
       
        <button id="closeModalBtn" style="flex:1; padding:12px; background:#6c757d; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:bold;">
          <i class="fas fa-times"></i> Fechar
        </button>
      </div>
    </div>
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
        <a href="/paginas/login.php" class="links"><i class="fas fa-arrow-circle-right"></i> Login</a>
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
    console.log('Script carregado!');
    
    // Função para alternar entre abas
    function openTab(tabName) {
      console.log('=== openTab chamado ===');
      console.log('tabName:', tabName);
      
      // Esconde todos os conteúdos das abas
      var tabcontent = document.getElementsByClassName("tabcontent");
      console.log('Elementos com classe tabcontent encontrados:', tabcontent.length);
      
      for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        console.log('Escondido:', tabcontent[i].id);
      }

      // Remove a classe 'active' de todos os botões
      var tablinks = document.getElementsByClassName("tab-btn");
      for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
      }

      // Mostra a aba atual
      var tabElement = document.getElementById(tabName);
      console.log('Elemento da aba encontrado:', tabElement);
      
      if (tabElement) {
        tabElement.style.display = "block";
        console.log('Display definido para block em:', tabName);
        console.log('Display atual:', window.getComputedStyle(tabElement).display);
      } else {
        console.error('Elemento não encontrado:', tabName);
      }
      
      // Adiciona 'active' ao botão correspondente
      var btnAtivo = document.getElementById('btn-' + tabName);
      if (btnAtivo) {
        btnAtivo.classList.add('active');
        console.log('Botão ativado:', 'btn-' + tabName);
      }
    }

    // Executa quando a página carregar
    window.addEventListener('DOMContentLoaded', function() {
      console.log('=== Página carregada ===');
      
      // Verifica se os botões existem
      var btnDisp = document.getElementById('btn-disponiveis');
      var btnAceit = document.getElementById('btn-aceitos');
      console.log('Botão disponíveis encontrado:', btnDisp);
      console.log('Botão aceitos encontrado:', btnAceit);
      
      // Adiciona event listeners aos botões
      if (btnDisp) {
        btnDisp.addEventListener('click', function() {
          console.log('Clique no botão disponíveis');
          openTab('disponiveis');
        });
      }
      
      if (btnAceit) {
        btnAceit.addEventListener('click', function() {
          console.log('Clique no botão aceitos');
          openTab('aceitos');
        });
      }
      
      // Verifica se há parâmetro 'tab' na URL
      const urlParams = new URLSearchParams(window.location.search);
      const tab = urlParams.get('tab');
      console.log('Parâmetro tab na URL:', tab);
      
      if (tab === 'aceitos') {
        console.log('=== Tentando abrir aba de fretes aceitos ===');
        setTimeout(function() {
          openTab('aceitos');
        }, 100);
      }
    });

    // Modal de Perfil
    const userProfileBtn = document.getElementById('userProfileBtn');
    const profileModal = document.getElementById('profileModal');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Abrir modal ao clicar no usuário
    if (userProfileBtn) {
      userProfileBtn.addEventListener('click', function() {
        console.log('Abrindo modal de perfil');
        profileModal.style.display = 'flex';
      });
    }

    // Fechar modal ao clicar no X
    if (closeModal) {
      closeModal.addEventListener('click', function() {
        profileModal.style.display = 'none';
      });
    }

    // Fechar modal ao clicar no botão Fechar
    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', function() {
        profileModal.style.display = 'none';
      });
    }

    // Fechar modal ao clicar fora dele
    if (profileModal) {
      profileModal.addEventListener('click', function(e) {
        if (e.target === profileModal) {
          profileModal.style.display = 'none';
        }
      });
    }
  </script>

</body>

</html>