document.addEventListener('DOMContentLoaded', function () {
  const bannerText = document.querySelector('.banner-text');

  function checkScrollForBanner() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // Ativa a animação quando o usuário desce pelo menos 50px (início do scroll)
    if (scrollTop > 50 && !bannerText.classList.contains('active')) {
      bannerText.classList.add('active');
      // Remove o listener após ativar para performance (animação só uma vez)
      window.removeEventListener('scroll', checkScrollForBanner);
    }
  }

  // Verifica no carregamento inicial (caso o usuário já esteja rolando)
  checkScrollForBanner();

  // Adiciona o listener de scroll
  window.addEventListener('scroll', checkScrollForBanner);
});

document.addEventListener('DOMContentLoaded', function () {
  const bannerText = document.querySelector('.banner-textD');

  function checkScrollForBanner() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // Ativa a animação quando o usuário desce pelo menos 50px (início do scroll)
    if (scrollTop > 50 && !bannerText.classList.contains('active')) {
      bannerText.classList.add('active');
      // Remove o listener após ativar para performance (animação só uma vez)
      window.removeEventListener('scroll', checkScrollForBanner);
    }
  }

  // Verifica no carregamento inicial (caso o usuário já esteja rolando)
  checkScrollForBanner();

  // Adiciona o listener de scroll
  window.addEventListener('scroll', checkScrollForBanner);
});

document.addEventListener('DOMContentLoaded', function () {
  const sobreNozes = document.querySelector('.sobre-nozes');

  function checkScroll() {
    const rect = sobreNozes.getBoundingClientRect();
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;

    // Quando a parte superior da seção estiver visível na tela (ajuste o valor conforme desejar)
    if (rect.top <= windowHeight * 0.75) {
      sobreNozes.classList.add('active');
      // Se quiser que a animação ocorra só uma vez, remova o event listener
      window.removeEventListener('scroll', checkScroll);
    }
  }
  /**/
  window.addEventListener('scroll', checkScroll);
  // Verifica logo no carregamento caso já esteja visível 
  checkScroll();
});


