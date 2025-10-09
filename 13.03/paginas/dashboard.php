<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $acaoc = 'recuperar';
  require '../cotacao.controller.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
      <a class="logo">🚚 DevLog</a>
      <div class="mobile-menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
      <ul class="nav-list">
        <li><a href="/paginas/motorista.html">Motorista</a></li>
        <li><a href="/paginas/empresa.html">Empresa</a></li>
        <li><a href="/paginas/index.html">Início</a></li>
      <a href="/paginas/cotacao.html">Cotação</a>
      <span class="user">👤<?php if(isset($_SESSION['idEmpresaLogado'])){ echo $_SESSION['empresaLogado'];}?> </span>
      <a href="/paginas/login.php" class="logout">Sair</a>
    </nav>
  </header>

  <main class="container">
    <div class="dashboard-header">
      <h1>Dashboard</h1>
      <p>Bem-vindo <?php echo $_SESSION['empresaLogado']; ?>, gerencie seus fretes e acompanhe suas atividades.</p>
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
          <div class="stat-number">0</div>
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
      <button class="tab-btn">📋 Fretes Aceitos</button>
      <button class="tab-btn active">🚚 Fretes Disponíveis</button>
    </div>

    <div class="fretes-section">
      <h2>Fretes Disponíveis</h2>
      <div class="empty-state" style="display:grid; gap: 10px">
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
                        <?php if (!empty($cotacao) && is_array($cotacao)): ?>
                            <?php foreach ($cotacao as $cota): ?>
                                <tr>
                                    <td><?= $cota->id_cotacao ?></td>
                                    <td><?= htmlspecialchars($cota->data_saida) ?></td>
                                    <td><?= htmlspecialchars($cota->cep_origem) ?></td>
                                    <td><?= htmlspecialchars($cota->endereco_origem) ?></td>
                                    <td><?= htmlspecialchars($cota->valor) ?></td>
                                    <td>
                                        <a href="../paginas/areaRestritaCota.php"
                                            class="btn btn-sm btn-warning">Detalhes</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="14" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>



        <div class="warning-icon">⚠️</div>
        <p>Nenhum frete disponível</p>
        <div class="criarBtn">
        <a class="tab-btn active" href="../cotacao2.php"> Criar Frete </a>
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
            <a href="/paginas/index.html" class="links"><i class="fas fa-arrow-circle-right"></i> Página Inicial</a>
            <a href="/paginas/motorista.html" class="links"><i class="fas fa-arrow-circle-right"></i> Motorista</a>
            <a href="/paginas/empresa.html" class="links"><i class="fas fa-arrow-circle-right"></i> Empresa</a>
            <a href="/paginas/login.html" class="links"><i class="fas fa-arrow-circle-right"></i> Login<a>
            <a href="/paginas/cadastros.html" class="links"><i class="fas fa-arrow-circle-right"></i> Cadastre-se</a>
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

</body>
</html>
