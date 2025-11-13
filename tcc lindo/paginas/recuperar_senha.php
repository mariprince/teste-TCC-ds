<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';
$tipo = $_GET['tipo'] ?? 'motorista';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../conexao/conexao.php';
    $conexao = new Conexao();
    $conn = $conexao->conectar();
    
    $email = $_POST['email'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    $tipoUsuario = $_POST['tipo'] ?? 'motorista';
    
    if (empty($email) || empty($novaSenha) || empty($confirmarSenha)) {
        $mensagem = '<div class="alert alert-danger">Preencha todos os campos!</div>';
    } elseif ($novaSenha !== $confirmarSenha) {
        $mensagem = '<div class="alert alert-danger">As senhas não coincidem!</div>';
    } else {
        try {
            if ($tipoUsuario === 'motorista') {
                // Verifica se o email existe
                $query = "SELECT id_motorista FROM motorista WHERE email_motorista = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':email', $email);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($usuario) {
                    // Atualiza a senha
                    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE motorista SET senha = :senha WHERE email_motorista = :email";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bindValue(':senha', $senhaHash);
                    $updateStmt->bindValue(':email', $email);
                    $updateStmt->execute();
                    
                    $mensagem = '<div class="alert alert-success">Senha alterada com sucesso! <a href="login.php">Faça login aqui</a></div>';
                } else {
                    $mensagem = '<div class="alert alert-danger">Email não encontrado!</div>';
                }
            } else {
                // Empresa
                $query = "SELECT id_empresa FROM empresa WHERE email_empresa = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':email', $email);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($usuario) {
                    // Atualiza a senha
                    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE empresa SET senha = :senha WHERE email_empresa = :email";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bindValue(':senha', $senhaHash);
                    $updateStmt->bindValue(':email', $email);
                    $updateStmt->execute();
                    
                    $mensagem = '<div class="alert alert-success">Senha alterada com sucesso! <a href="login.php?tipo=empresa">Faça login aqui</a></div>';
                } else {
                    $mensagem = '<div class="alert alert-danger">Email não encontrado!</div>';
                }
            }
        } catch (PDOException $e) {
            $mensagem = '<div class="alert alert-danger">Erro ao processar solicitação: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - DevLog</title>
    <link rel="shortcut icon" type="imagex/png" href="/imagens/logo.ico">
    <link rel="stylesheet" href="../css/cadastro.css" />
    <script src="../scripts/script.js" defer></script>
</head>
<body>
    <section class="containerPai">
        <div class="cardBI <?= $tipo === 'motorista' ? 'loginActive' : 'cadastroActive' ?>">
            <!-- FORM MOTORISTA -->
            <div class="esquerda">
                <div class="formMotorista">
                    <h2 style="padding-bottom: 15px;">Recuperar Senha - Motorista</h2>
                    <?php if ($tipo === 'motorista' && !empty($mensagem)): ?>
                        <?= $mensagem ?>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <input type="hidden" name="tipo" value="motorista">
                        <button type="button" class="voltar" onclick="window.location.href='login.php'">🠔</button>
                        
                        <input type="email" name="email" placeholder="Seu E-mail" required>
                        <input type="password" name="nova_senha" placeholder="Nova Senha" minlength="6" required>
                        <input type="password" name="confirmar_senha" placeholder="Confirmar Nova Senha" minlength="6" required>
                        
                        <button type="submit" class="btn btn-outline-warning custom-btn">Alterar Senha</button>
                    </form>
                    <a href="login.php">Voltar ao Login</a>
                </div>
                
                <div class="cadastroMotorista">
                    <h2>Esqueceu sua senha <br/>como motorista?</h2>
                    <p>Recupere o acesso à sua conta rapidamente!</p>
                    <button class="motoristaButton">Recuperar Motorista</button>
                </div>
            </div>
            
            <!-- FORM EMPRESA -->
            <div class="direita">
                <div class="empresaForm">
                    <h2 style="padding-bottom: 15px;">Recuperar Senha - Empresa</h2>
                    <?php if ($tipo === 'empresa' && !empty($mensagem)): ?>
                        <?= $mensagem ?>
                    <?php endif; ?>
                    <form class="formEmpresa" method="POST" action="">
                        <input type="hidden" name="tipo" value="empresa">
                        <button type="button" class="voltar" onclick="window.location.href='login.php?tipo=empresa'">🠔</button>
                        
                        <input type="email" name="email" placeholder="Email da Empresa" required>
                        <input type="password" name="nova_senha" placeholder="Nova Senha" minlength="6" required>
                        <input type="password" name="confirmar_senha" placeholder="Confirmar Nova Senha" minlength="6" required>
                        
                        <br/>
                        <button type="submit" class="">Alterar Senha</button>
                    </form>
                </div>
                
                <div class="cadastroEmpresa">
                    <h2 style="margin-bottom: 20px;">Esqueceu a senha<br/>da sua empresa?</h2>
                    <button class="empresaButton">Recuperar Empresa</button>
                </div>
                
                <a href="login.php?tipo=empresa">Voltar ao Login</a>
            </div>
        </div>
    </section>
</body>
</html>