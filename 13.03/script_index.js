// Slider
const box = document.querySelector(".slide");
const imagens = document.querySelectorAll(".slide img"); // Corrigido para selecionar todas as imagens

let contador = 0;

function slide() {
    contador++;

    if (contador > imagens.length - 1) {
        contador = 0;
    }

    box.style.transform = `translateX(${-contador * 1260}px)`;
}

setInterval(slide, 2000);