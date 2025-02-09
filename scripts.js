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