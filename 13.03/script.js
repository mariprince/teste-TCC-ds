
/*const express = require('express');

const mysql = require('mysql2')

const app = express()

const conexao = mysql.createConnection({
    host:'localhost',
    user:'root',
    database:'projeto',
});

conexao.connect(function(erro){
    if(erro) throw erro;
    console.log('Conexão efetuada com sucesso');
});*/

document.querySelector('.custom-btn').addEventListener('click', function() {    event.preventDefault();

    const nomeM = document.getElementById('nome_motorista').value;
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
    console.log(`Motorista cadastrado: ${nomeM}, ${cpf}, ${curriculo}`);
    document.getElementById('form_motorista').reset();
});

//app.listen(8080)


/*async function criarEPopularTabelaMotorista(nomeM, cpf, curriculo) {
    const db = await open({
        filename: 'banco.db',
        driver: sqlite3.Database,
    });

    db.run(`CREATE TABLE IF NOT EXISTS motorista(nome_motorista TEXT, cpf INTEGER PRIMARY KEY, email_motorista TEXT)`

    );
    db.run(`INSERT INTO motorista (nome_motorista, cnpj, email_motorista) VALUES (?,?)`, [
        nome_motorista,
         cpf,
          email_motorista
        ]);
}

criarEPopularTabelaEmpresas('Juan Futuro feito', '487.747.968-60');*/