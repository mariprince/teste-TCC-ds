document.getElementById('form-cliente').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome-cliente').value;
    const email = document.getElementById('email-cliente').value;
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Cliente cadastrado: ${nome}, ${email}`);
});

document.getElementById('form-estabelecimento').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome-estabelecimento').value;
    const cnpj = document.getElementById('cnpj').value;
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Estabelecimento cadastrado: ${nome}, ${cnpj}`);
});

document.getElementById('form-entregador').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome-entregador').value;
    const cpf = document.getElementById('cpf').value;
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Entregador cadastrado: ${nome}, ${cpf}`);
});

document.getElementById('form-endereco').addEventListener('submit', function(event) {
    event.preventDefault();
    const rua = document.getElementById('rua').value;
    const numero = document.getElementById('numero').value;
    const cidade = document.getElementById('cidade').value;
    // Aqui você pode adicionar a lógica para enviar os dados para o backend
    console.log(`Endereço cadastrado: ${rua}, ${numero}, ${cidade}`);
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