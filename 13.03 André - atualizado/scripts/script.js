
const myObserver = new IntersectionObserver( (entries) => {
    entries.forEach( (entry) => {
        if(entry.isIntersecting){
            entry.target.classList.add('show')
        }else{
            entry.target.classList.remove('show')
        }
    })
})

function mascaraTelefone(input) {
  let value = input.value.replace(/\D/g, '');

  // Limita o valor a no máximo 11 dígitos (2 DDD + 9 número)
  value = value.substring(0, 11);

  // Aplica a máscara
  if (value.length <= 10) {
    // Telefone fixo: (99) 9999-9999
    value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
  } else {
    // Celular: (99) 99999-9999
    value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
  }

  input.value = value;
}

function mascaraCPF(input) {
  let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número

  // Limita a 11 dígitos
  value = value.slice(0, 11);

  // Aplica a máscara: 000.000.000-00
  if (value.length >= 10) {
    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
  } else if (value.length >= 7) {
    value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
  } else if (value.length >= 4) {
    value = value.replace(/(\d{3})(\d{1,3})/, "$1.$2");
  }

  input.value = value;
}
function formatarCNPJ(campo) {
  let cnpj = campo.value.replace(/\D/g, ''); // Remove tudo que não for dígito

  if (cnpj.length > 14) cnpj = cnpj.slice(0, 14); // Limita a 14 dígitos

  // Aplica a formatação
  cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
  cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
  cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
  cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");

  campo.value = cnpj;
}

function mascaraNumerica(input, maxLength) {
  let value = input.value.replace(/\D/g, '');
  input.value = value.slice(0, maxLength);
}

function toggleSenha(botao) {
  const input = document.getElementById("senha");

  if (input.type === "password") {
    input.type = "text";
    botao.textContent = "🙈"; // ícone de ocultar
  } else {
    input.type = "password";
    botao.textContent = "👁️"; // ícone de mostrar
  }
}

const elements = document.querySelectorAll('.pagcadastro');
elements.forEach( (element) => myObserver.observe(element));

let card = document.querySelector(".cardBI")
let motoristaButton = document.querySelector(".motoristaButton")
let empresaButton = document.querySelector(".empresaButton")

motoristaButton.onclick = () => {
    card.classList.remove("cadastroActive")
    card.classList.add("loginActive")
}

empresaButton.onclick = () => {
    card.classList.remove("loginActive")
    card.classList.add("cadastroActive")
}

