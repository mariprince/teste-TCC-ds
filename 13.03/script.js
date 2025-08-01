document.querySelector('.custom-btn').addEventListener('click', function() {    event.preventDefault();
    const emailM = document.getElementById('email').value;
    const senha = document.getElementById('password')
    const cpf = document.getElementById('cpf').value;
    const curriculo = document.getElementById('formFile').value;
    if (curriculo.length > 0) {
        console.log('Currículos selecionados:');
        for (let i = 0; i < curriculo.length; i++) {
            console.log(curriculo[i].name);
        }
    } else {
        console.log('Nenhum currículo selecionado.');
    }
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Motorista cadastrado: ${emailM}, ${password}, ${cpf}, ${curriculo}`);
    document.getElementById('formCadastroMotorista').reset();
});
const myObserver = new IntersectionObserver( (entries) => {
    entries.forEach( (entry) => {
        if(entry.isIntersecting){
            entry.target.classList.add('show')
        }else{
            entry.target.classList.remove('show')
        }
    })
})

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

// NOVO: Envio do formulário de cadastro de motorista como JSON para o backend
const formCadastroMotorista = document.getElementById('formCadastroMotorista');
if (formCadastroMotorista) {
  formCadastroMotorista.addEventListener('submit', async function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const cpf = document.getElementById('cpf').value;
    const password = document.getElementById('password').value;
    // O campo de currículo não será enviado por enquanto, pois o backend não espera arquivo

    try {
      const response = await fetch('/cadastro', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, cpf, password })
      });
      if (response.ok) {
        window.location.href = '/login.html';
      } else {
        window.location.href = '/error.html';
      }
    } catch (error) {
      console.error('Erro no cadastro:', error);
      window.location.href = '/error.html';
    }
  });
}

// NOVO: Envio do formulário de cadastro de empresa como JSON para o backend
const formEmpresa = document.querySelector('.formEmpresa');
if (formEmpresa) {
  formEmpresa.addEventListener('submit', async function(event) {
    event.preventDefault();
    // Pega os campos do formulário
    const nome_empresa = formEmpresa.querySelector('input[placeholder="Nome Empresa"]').value;
    // O campo de email correto é o que tem id="email_empresa"
    const email_empresa = formEmpresa.querySelector('#email_empresa').value;
    // O campo de senha (corrigindo o type para password se necessário)
    let senha_empresa = '';
    const senhaInput = formEmpresa.querySelector('input[type="senha"], input[type="password"]');
    if (senhaInput) senha_empresa = senhaInput.value;
    const cnpj = formEmpresa.querySelector('#cnpj').value;

    try {
      const response = await fetch('/cadastro-empresa', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nome_empresa, email_empresa, senha_empresa, cnpj })
      });
      if (response.ok) {
        window.location.href = '/login.html';
      } else {
        window.location.href = '/error.html';
      }
    } catch (error) {
      console.error('Erro no cadastro de empresa:', error);
      window.location.href = '/error.html';
    }
  });
}

