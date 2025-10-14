<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title img="🚚"> DevLog - Página Inicial</title>
  <link rel="shortcut icon" type="imagex/png" href="../imagens/logo.ico">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-800">
  <header>
    <nav>
      <div class="logo-group">
        <a href="#" class="logo img"><img src="../imagens/logosite.png" alt="DevLog"></a>
        <span id="span">DevLog</span>
      </div>
      <ul class="nav-list">
        <li><a href="../paginas/motorista.html">Motorista</a></li>
        <li><a href="../paginas/empresa.html">Empresa</a></li>
        <li><?php if(isset($_SESSION['idEmpresaLogado'])){ echo $_SESSION['empresaLogado'];  }else{echo '<a href="paginas/login.php?tipo=empresa">Entrar</a>';}?></li>
      </ul>
      <div class="mobile-menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
    </nav>
  </header>
  <!-- Exemplo de onde inserir no body -->
  <section class="container">
    <div class="content">
      <h2>Pensados para atender sua empresa</h2>
      <!-- Caminhão que se move -->
      <div class="truck-wrapper">
        <img src="caminhao.png" alt="Caminhão" class="truck"/>
  </section>
    <div class="banner">
      <img src="../imagens/cbann.jpg">
      <div class="banner-text">
        <h1>Bem-vindo à DevLog! - Conectando o futuro da logística</h1>
        
      </div>
      <div class="banner-textD">
        <p>
          A DevLog é a plataforma que transforma a logística, conectando empresas e motoristas de forma eficiente e inovadora. </br> 
        </p>
      </div>
    </div>

    <div class="sobre-nozes-header"><br><br><br><br><h1>DevLog</h1></div>

    <div class="benefits-container">
      <div class="benefit-card">
        <!-- <img src="../imagens/motIdx.png"> -->
        <i class="fa-solid fa-id-card"></i>
        <h3>Motorista</h3>
        <p class="small">Sua experiência é valorizada!</p>
        <p>Se você é um motorista capacitado, tem tempo de estrada e precisa de conexões, aqui é o lugar certo!</p>
        <a href="../paginas/motorista.html"
        class="rounded-2x1 p-4 text-center text-orange font-bold block mx-auto w-fit">Saiba Mais</a>  
      </div>

      <div class="benefit-card">
        <!-- <img src="../imagens/BannerIdx1.png"> -->
        <i class="fa-solid fa-users-rectangle"></i>
        <h3>Seja parte do time!</h3>
        <p class="small">Conectamos informações e objetivos.</p>
        <p>A plataforma para conecta motoristas e empresas para realização de frete da forma mais eficiente e eficaz.</p>
        <a href="../paginas/motorista.html"
        class="rounded-2x1 p-4 text-center text-orange font-bold block mx-auto w-fit">Saiba Mais</a>
      </div>
        
      <div class="benefit-card">
        <!-- <img src="../imagens/empresaIndx.jpg">       -->
        <i class="fa-solid fa-business-time"></i>
        <h3>Empresa</h3>
        <p class="small">Encontre a combinação perfeita!</p>
        <p>Se sua empresa precisa de frete? Aqui é a melhor plataforma para encontrar o motorista ideal.</p>
        <a href="../paginas/empresa.html"  class="rounded-2x1 p-4 text-center text-orange font-bold block mx-auto w-fit">Saiba Mais</a>
      </div>
    </div>

    <section class="sobre-nozes">
      <!-- Coluna Esquerda -->
      <div class="sobre-nozes-header">
        <h1>SOBRE<br>NÓS</h1>
        <p>
          <strong>EQUIPE DEVLOG</strong> Após muita pesquisa e estudo de casos com o objetivo de otimizar a etapa de
          entrega da cadeia de suprimentos, desenvolvemos a plataforma para conectar motoristas aptos e comprometidos a
          realizar fretes de curta a longa distância para empresas que têm vendas, movimentação de mercado, mas não
          possuem modal adequado ou profissional para realizar a fretagem.
        </p>
      </div>
    
      <!-- Coluna Direita -->
      <div class="sobre-nozes-info">
        <div class="box-info">
          <h2 class="titulo-esquerda">MISSÃO</h2>
          <p>Conectar motoristas e empresas, entregando valor às operações por meio de inovação e cooperação.</p>
        </div>
        <div class="box-info">
          <h2 class="titulo-esquerda">VISÃO</h2>
          <p>Ser referência na logística cooperativa, promover desenvolvimento econômico e social sustentável.</p>
        </div>
        <div class="box-info">
          <h2 class="titulo-esquerda">VALOR</h2>
          <p>Transparência, ética, inovação, simplicidade e respeito em todas as nossas ações.</p>
        </div>
      </div>
    </section>
    
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
          <a href="paginas/motorista.html" class="links"><i class="fas fa-arrow-circle-right"></i> Motorista</a>
          <a href="paginas/empresa.html" class="links"><i class="fas fa-arrow-circle-right"></i> Empresa</a>
          <a href="paginas/login.php" class="links"><i class="fas fa-arrow-circle-right"></i> Login<a>
              <a href="cadastros2.php" class="links"><i class="fas fa-arrow-circle-right"></i> Cadastre-se</a>
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

    <footer class="bg-orange-600 text-white py-4" style="width: 100%; text-align: center;">
      <p>&copy; 2025 <span>DevLog </span> | Todos os direitos reservados</p>
    </footer>
    <script src="../scripts/script_index.js"></script>
    <script src="../scripts/mobile-navbar.js"></script>
  
</body>

<!-- 
CARDS ANTIGOS - SE FOR USAR
><div class="cartoes">
    <div class="card" style="width: 25rem; height: 20rem; border-radius: 3rem;">
      <div class="card-body">
        <img src="../imagens/motIdx.png">
        <h5 class="card-title">Motorista</h5>
        <p class="card-text">Se você é capacitado, tem experiência na estrada e precisa de conexões, aqui é o seu lugar!
        </p>
        <a href="paginas/motorista.html"
        class="rounded-2x1 p-4 text-center text-orange font-bold flex justify-between items-center">Saiba Mais</a>  
      </div>
    </div>

    <div class="card3" style="width: 25rem; height: 20rem; border-radius: 3rem;">
      <div class="card-body">
        <img src="../imagens/4.png">
        <h5 class="card-title">Seja Parte do Time</h5>
        <p class="card-text">A melhor plataforma para conectar motoristas e empresas para realização de frete.</p>
        <a href="../paginas/cadastros.html"
          class="rounded-2x1 p-4 text-center text-orange font-bold flex justify-between items-center">Cadastre-se</a>
      </div>
    </div>

    <div class="card2" style="width: 25rem; height: 20rem; border-radius: 3rem;">
      <div class="card-body">
        <img src="../imagens/empIdx.png">
        <h5 class="card-title">Empresa</h5>
        <p class="card-text">Se sua empresa não tem quem entrega suas vendas, aqui é a melhor plataforma para encontrar
          o motorista ideal.</p>
        <a href="../paginas/empresa.html" class="rounded-2x1 p-4 text-center text-orange font-bold flex">Saiba Mais</a>
      </div>
    </div>
  </div>

sobre nós original
  <section class="sobre-nos">
    <div class="sobre-nos-header">
      <h1>SOBRE<br>NÓS</h1>
      <p>
        <strong>EQUIPE DEVLOG</strong> Após muita pesquisa e estudo de casos com o objetivo de otimizar a etapa de
        entrega da cadeia de suprimentos, desenvolvemos a plataforma para conectar motoristas aptos e comprometidos a
        realizar fretes de curta a longa distância para empresas que tem vendas, tem a movimentação de mercado, mas não
        tem o modal adequado, ou o próprio profissional para realizar a fretagem.
      </p>
    </div>
    <div>
      <div class="equipeDS">
        <div class="membroJ">
          <h4>Juan da Silva</h4>
          <p>Desenvolvedor</p>
        </div>
        <div class="membroMa">
          <h4>Marina da Silva</h4>
          <p>Líder da Equipe</p>
        </div>
        <div class="membroMi">
          <h4>Miguel Rodrigues</h4>
          <p>Designer</p>
        </div>
      </div>

      <div class="equipeDOC">
        <div class="membroCl">
          <h4>Clara Helena Sarri</h4>
          <p>Pesquisadora</p>
        </div>
        <div class="membroMr">
          <h4>Mariane Oliveira</h4>
          <p>Documentadora</p>
        </div>
      </div>
    </div>
  </section> -->

<!-- <ul> Logo Caminhãozim
          <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
          </svg>
        </ul> -->

<!--<div class="slider">
    <div class="slides">
      Radio Buttons
      <input type="radio" name="radio-btn" id="radio1">
      <input type="radio" name="radio-btn" id="radio2">
      <input type="radio" name="radio-btn" id="radio3">
      FIM Radio Buttons-->

<!-- Slides Imagens
      <div class="slide first">
        <img src="imagens/Tipos-de-caminhao.jpeg" alt="Imagem 1">
      </div>
      <div class="slide">
        <img src="imagens/3.png" alt="Imagem 2">
      </div>
      <div class="slide">
        <img src="imagens/4.png" alt="Imagem 3">
      </div>
      FIM Slides Imagens-->

<!-- Navigation
      <div class="navigation-auto">
        <div class="auto-btn1"></div>
        <div class="auto-btn2"></div>
        <div class="auto-btn3"></div>
      </div>
    </div>
    <div class="manual-navigation">

      <label for="radio1" class="manual-btn"></label>
      <label for="radio2" class="manual-btn"></label>
      <label for="radio3" class="manual-btn"></label>
    </div>
  </div>-->

</html>