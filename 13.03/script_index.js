// Slider
const box = document.querySelector(".slides");
const imagens = document.querySelectorAll(".slide"); // Seleciona todas as divs de slide
let contador = 0;

// Função para mudar a imagem
function slide() {
    contador++;
    if (contador > imagens.length - 1) {
        contador = 0;
    }
    // Muda o botão de rádio correspondente
    document.getElementById(`radio${contador + 1}`).checked = true;
}

// Troca de imagem a cada 2 segundos
setInterval(slide, 5000);