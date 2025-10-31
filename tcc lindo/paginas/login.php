<?php 
$cardAtivo = 'loginActive'; // padrão = motorista

if (isset($_GET['tipo']) && $_GET['tipo'] === 'empresa') {
    $cardAtivo = 'cadastroActive'; // empresa
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="/scripts/scriptLogin.js" defer></script>
    <title>Login</title>
    <link rel="shortcut icon" type="imagex/png" href="/imagens/logo.ico">
</head>

<body>
    <section class="containerPai">
        <div class="cardBI <?= $cardAtivo ?>">
            <div class="esquerda">
                <div class="formMotorista">
                    <h2>Login Motorista</h2>
                    <form action="../motorista.controller.php?acao=recuperarLoginM" method="post">
                        <input type="email" name="email_motorista" id="email_motorista" placeholder=" Seu E-mail">
                        <input type="password" name="senha" placeholder="Sua Senha">
                        <button type="submit" class="btn btn-outline-warning custom-btn">
                            Login
                        </button>
                    </form>
                    <a href="..\cadastros2.php">
                        Não tem conta? Cadastre-se aqui!
                    </a>
                    <a href="recuperar_senha.php?tipo=motorista">
                        Esqueceu a Senha? Recupere aqui!
                    </a>
                </div>
                <div class="loginMotorista">
                    <h2>Já tem conta <br/>como motorista?</h2>
                    <button class="motoristaButton">Login Motorista</button>
                </div>
            </div>
            <div class="direita">
                <div class="empresaForm">
                    <h2>Login Empresa</h2>
                    <form class="formEmpresa" action="../empresa.controller.php?acaoe=recuperarLoginE" method="post">
                        <input placeholder="Email Empresa" type="email" name="email_empresa" id="email_empresa"
                            class="w-full border border-gray-300 rounded-md p-2" required/>
                            <input type="password" name="senha" placeholder="Sua Senha">
                        <br/>

                        <button type="submit" class="btn btn-outline-warning custom-btn">
                            Login
                        </button>
                    </form>
                </div>
                <div class="loginEmpresa">
                    <h2>Para quem <br />já é empresa parceira!</h2> </br>
                    <button type="submit" class="empresaButton">Login Empresa</button>
                </div>
                <a href="../cadastros2.php">
                    Não cadastrou sua Empresa? Cadastre-se aqui!
                </a>
                <a href="recuperar_senha.php?tipo=empresa">
                    Esqueceu a Senha? Recupere aqui!
                </a>
            </div>
        </div>
    </section>
</body>

</html>