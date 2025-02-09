const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const PORT = 3000;

app.use(cors());
app.use(bodyParser.json());

// Endpoint para cadastrar cliente
app.post('/api/cliente', (req, res) => {
    const cliente = req.body;
    console.log('Cliente cadastrado:', cliente);
    res.status(201).send('Cliente cadastrado com sucesso!');
});

// Endpoint para cadastrar estabelecimento
app.post('/api/estabelecimento', (req, res) => {
    const estabelecimento = req.body;
    console.log('Estabelecimento cadastrado:', estabelecimento);
    res.status(201).send('Estabelecimento cadastrado com sucesso!');
});

// Endpoint para cadastrar entregador
app.post('/api/entregador', (req, res) => {
    const entregador = req.body;
    console.log('Entregador cadastrado:', entregador);
    res.status(201).send('Entregador cadastrado com sucesso!');
});

// Endpoint para cadastrar endereço
app.post('/api/endereco', (req, res) => {
    const endereco = req.body;
    console.log('Endereço cadastrado:', endereco);
    res.status(201).send('Endereço cadastrado com sucesso!');
});

app.listen(PORT, () => {
    console.log(`Servidor rodando na porta ${PORT}`);
});