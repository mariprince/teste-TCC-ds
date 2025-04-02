//import sqlite3 from 'sqlite3';
//import {open} from 'sqlite';

document.querySelector('.custom-btn').addEventListener('click', function() {    event.preventDefault();

    const nomeM = document.getElementById('nome_motorista').value;
    const cpf = document.getElementById('cpf').value;
    const curriculo = document.getElementById('curriculo').value;
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


/*async function criarEPopularTabelaEmpresas(nome_empresa, cnpj, email_empresa) {
    const db = await open({
        filename: './banco/banco.db',
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

criarEPopularTabelaEmpresas('Juan Futuro feito', '20.182.807/0004-42', 'juanfuturista@gmail.com');
*/