 <!--- Início do HTML -->
 <!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lootsy | Loja de Games com Ofertas Lendárias</title>
  <meta name="description" content="Lootsy é a loja online de games com as melhores ofertas em jogos de console e PC. Compre com segurança e entrega para todo o Brasil.">

    <!--- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet"/>

    <!--- CSS e CSS boostrap -->
    
  <link rel="stylesheet" href="styles/home.css"/>
  <link rel="stylesheet" href="styles/banner.css"/>
  <link rel="stylesheet" href="styles/footer.css"/>
  <link rel="shortcut icon" href="assets/images/imagem_da_logo.png" type="image/x-icon">
</head>

  <!--- Início do corpo da página -->
<body>
<header> 
    <div class="icone">
       <a href="home.php">
        <img src="assets/images/logo+nome.png" alt="Lootsy">
       </a>
    </div>
    <div class="search-bar">
      <input type="text" placeholder="Buscar jogos..." />
   </div>

   <div class="header-buttons">
     <a href="login.php" class="login-button">
      <img src="assets/images/login-icone.png" alt="Login" class="login-icon">
      <div class="login-text">LOGIN<br>CADASTRE-SE</div>
     </a>
     
     
     <div class="trilho" id="trilho">
          <div class="indicador"></div>
   </div>

   

     <div class="cart-button">
      <img src="assets/images/carrinho-compras.png" alt="Carrinho">
      <div class="cart-text">CARRINHO</div>
     </div>
  </header>

    <nav class="navbar">
        <ul class="nav-links">
  <li><a href="home.php">Página Inicial</a></li>    
  <li><a href="todososjogos.php">Jogos</a></li>
  <li><a href="sobrenos.php">Sobre Nós</a></li>
        </ul>
  </nav>

  <!--- Carousel do Banner -->
<section class="banner">
  <div class="carousel">
    <div class="slides">
      <img src="assets/images/banner1.png" class="slide active" alt="Promoção de jogos da Lootsy - Banner 1"/>
      <img src="assets/images/banner2.png" class="slide" alt="Promoção de jogos da Lootsy - Banner 2"/>
      <img src="assets/images/banner3.png" class="slide" alt="Promoção de jogos da Lootsy - Banner 3"/>
    </div>
  </div>

      <button type="button" class="prev" aria-label="Slide anterior">❮</button>
      <button type="button" class="next" aria-label="Próximo slide">❯</button>

    <div class="dots">
      <span onclick="goToSlide(0)" class="dot active"></span>
      <span onclick="goToSlide(1)" class="dot"></span>
      <span onclick="goToSlide(2)" class="dot"></span>
    </div>
  </section>

<!--- Destaques do dia -->
<section class="destaques">
  <h2>Destaques do Dia</h2>

  <div class="destaques-container">
    <div class="jogo">
      <img src="assets/images/thelast.png" loading="lazy" alt="The Last of Us Part II" />
      <h3>The Last of Us Part II</h3>
      <p>R$ 195,99</p>
      <a href="catalogo_jogos/tlou.php" class="btn">Conferir</a>
    </div>
    <div class="jogo">
      <img src="assets/images/reddead.png" loading="lazy" alt="Red Dead Redemption II" />
      <h3>Red Dead Redemption II</h3>
      <p>R$ 150,28</p>
      <a href="catalogo_jogos/redDead.php" class="btn">Conferir</a>
    </div>
    <div class="jogo">
      <img src="assets/images/zelda.jpg" loading="lazy" alt="The Legend of Zelda" />
      <h3>The Legend of Zelda: Echoes of Wisdom</h3>
      <p>R$ 150</p>
      <a href="catalogo_jogos/zelda.php" class="btn">Conferir</a>
    </div>
    <div class="jogo">
      <img src="assets/images/fable.webp" loading="lazy" alt="Fable Anniversary" />
      <h3>Fable Anniversary Edition</h3>
      <p>R$ 50,99</p>
      <a href="catalogo_jogos/fable.php" class="btn">Conferir</a>
    </div>
  </div>
</section>

<!--- Hero banner -->
  <section class="secao-hero-fundo">
  <section class="loot-banner"> 
    <div class="banner-content">
      <div class="textos">
       <p class="titulo">O melhor loot é encontrar o jogo perfeito</p>
       <p class="subtitulo">Ofertas lendárias em jogos de console e PC.</p>
       <a href="todososjogos.php" class="btn">Explorar Jogos</a>
      </div>

      <div class="imagem-wrapper">
       <img src="assets/images/icone02.png" loading="lazy" alt="Loot"  />
      </div>
   </div>
 </section>
  </section>

 <!--- Compra garantida e formas de pagamentos -->
  <section class="compra-garantida">
  <div class="bloco-texto-e-icon">
    <div class="icon">
      <img src="assets/images/compra-ok.png" loading="lazy" alt="Ícone Garantia" />
    </div>
    <div class="texto">
      <strong>Compra Garantida</strong>
      <span>Sua compra garantida ou seu dinheiro de volta.</span>
    </div>
  </div>

  <div class="pagamentos">
    <img src="assets/images/pix.png" loading="lazy" alt="Pix"/>
    <img src="assets/images/boleto.png" loading="lazy" alt="Boleto"/>
    <img src="assets/images/cartao.png" loading="lazy" alt="Cartão de Crédito"/>
 </div>
  </section>
    </main>

    <!--- Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="institucional">
        <h2>Institucional</h2>
        <p>Comércio eletrônico de games.<br>
          Estamos há 10 anos no mercado
          com o objetivo de ser a melhor loja online de games. <br>
          Enviamos para todo o país, através dos serviços de entrega dos Correios, tudo bem embalado e com segurança.</p>
        <p>Estamos em Rio de Janeiro/RJ e temos loja física no bairro de Bonsucesso e Magé.<br>
          Visite-nos, tem muita coisa boa.<br>
          Saudações Gamers!</p>
      </div>

      <div class="contato-social">
        <div class="logo">
          <img src="assets/images/logo+nome.png" loading="lazy" alt="Logo Lootsy">
          <p>AV. PARIS, 84 · (21) 3882-9797</p>
        </div>
        <div class="social-icons">
          <img src="assets/images/redes.png" loading="lazy" alt="Redes">
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="selos">
        <h3>Selos de Segurança:</h3>
        <img src="assets/images/google-secure.png" loading="lazy" alt="Google Site Seguro">
        <img src="assets/images/ssl-secure.png" loading="lazy" alt="SSL Encryption">
      </div>

      <div class="envio">
        <h3>Formas de Envio:</h3>
        <img src="assets/images/envios_correios.webp" loading="lazy" alt="Correios SEDEX e PAC">
      </div>
    </div>

    <div class="copyright">
      <p>Lootsy - CNPJ: 22.222.222/0001-22 © Todos os direitos reservados. 2025© Lootsy ® é marca registrada de Lootsy | Todos os direitos reservados.</p>
      <p>Todas as fotos expostas na Lootsy.com.br são meramente ilustrativas e de nossa propriedade, estando protegidas por Lei Federal de Direito Autoral.</p>
    </div>
  </footer>

  <!--- Jquery e JS boostrap -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!--- JS -->
  <script src="js/index.js"></script>
  <script src="js/banner.js"></script>
 <script src="js/darkmode.js"></script>

</body>
</html> 

<!--- Fim do código -->
