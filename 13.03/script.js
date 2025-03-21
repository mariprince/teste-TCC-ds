/*document.getElementById('form-motorista').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome-motorista').value;
    const email = document.getElementById('email-motorista').value;
    Aqui você pode adicionar a lógica para enviar os dados para o backend
   console.log(`Motorista cadastrado: ${nome}, ${email}`);
}); */

document.getElementById('form-empresa').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome-empresa').value;
    const cnpj = document.getElementById('cnpj').value;
    const email = document.getElementById('email-empresa').value;
    
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Empresa cadastrada: ${nome}, ${cnpj}, ${email}`);
});

document.getElementById('form-motorista').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome-motorista').value;
    const cpf = document.getElementById('cpf').value;
    const curriculo = document.getElementById('curriculo').value;
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Motorista cadastrado: ${nome}, ${cpf}, ${curriculo}`);
});

document.getElementById('form-endereco').addEventListener('submit', function(event) {
    event.preventDefault();
    const rua = document.getElementById('rua').value;
    const numero = document.getElementById('numero').value;
    const cidade = document.getElementById('cidade').value;
    const origem = document.getElementById('origem').value;
    const destino = document.getElementById('destino').value;
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Endereço cadastrado: ${rua}, ${numero}, ${cidade}, ${origem}, ${destino}`);
});

// Selecione o botão de enviar currículo
const enviarCurriculoButton = document.getElementById('enviar-curriculo');

// Adicione um evento de clique ao botão
enviarCurriculoButton.addEventListener('click', () => {
    // Selecione o input de currículo
    const curriculoInput = document.getElementById('curriculo');

    // Verifique se o input de currículo está vazio
    if (curriculoInput.files.length === 0) {
        alert('Selecione um arquivo para enviar');
        return;
    }

    // Envie o currículo para o servidor (ou faça o que você precisa fazer)
    // Aqui você pode adicionar a lógica para enviar o arquivo para o servidor
    console.log('Currículo enviado com sucesso!');
});

