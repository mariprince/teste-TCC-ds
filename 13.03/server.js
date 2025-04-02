

const express = require('express');
const bodyParser = require('body-parser');
const db = require('./13.03/banco');

const app = express();
const PORT = 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Rota para cadastrar motorista
app.post('/cadastrar', (req, res) => {
    const { nome, idade, cnh } = req.body;
    const stmt = db.prepare("INSERT INTO motorista (nome_motorista, cpf) VALUES (?, ?)");
    stmt.run(nome_motorista, cpf, function(err) {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.status(201).json({ id: this.lastID, nome_motorista, cpf});
    });
    stmt.finalize();
});

// Rota para listar motoristas
app.get('/motorista', (req, res) => {
    db.all("SELECT * FROM motorista", [], (err, rows) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json(rows);
    });
});

// Iniciar o servidor
app.listen(PORT, () => {
    console.log(`Servidor rodando em http://localhost:${PORT}`);
});

// Selecione o botão de enviar currículo
const enviarCurriculoButton = document.getElementById('enviar-curriculo');
