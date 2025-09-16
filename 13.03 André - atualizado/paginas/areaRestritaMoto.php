<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$acaoe = 'recuperar';
require '../controller/motorista.controller.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="shortcut icon" type="imagex/png" href="/imagens/logo.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/areaRestrita.css">
</head>

<body>

    <!-- Navbar -->
    <header style="">
        <nav>
            <a class="logo">🚚 DevLog</a>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-list">
                <li><a href="/paginas/index.html">Início</a></li>
                <li><a href="/paginas/empresa.html">Empresa</a></li>
                <li><a href="/paginas/cadastros.html">Cadastrar</a></li>
            </ul>
        </nav>
    </header>

    <!-- Conteúdo -->
    <div class="container mt-5">
        <div class="row" style="justify-content: center;">
            <!-- Lista de usuários -->
            <div class="col-md-8">
                <h2>Motoristas</h2>
                <table class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Contato</th>
                            <th>CNH</th>
                            <th>RENAVAN</th>
                            <th>Email</th>
                            <th>Currículo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($motorista) && is_array($motorista)): ?>
                            <?php foreach ($motorista as $moto): ?>
                                <tr>
                                    <td><?= $moto->id_motorista ?></td>
                                    <td><?= htmlspecialchars($moto->nome_completo) ?></td>
                                    <td><?= htmlspecialchars($moto->cpf) ?></td>
                                    <td><?= htmlspecialchars($moto->numCtt) ?></td>
                                    <td><?= htmlspecialchars($moto->cnh) ?></td>
                                    <td><?= htmlspecialchars($moto->renavan) ?></td>
                                    <td><?= htmlspecialchars($moto->email_motorista) ?>
                                    <td>
                                        <?php if ($moto->curriculo): ?>
                                            <img src="../imagens/<?= htmlspecialchars($moto->curriculo) ?>" width="40" alt="Foto">
                                        <?php else: ?>
                                            Sem Foto
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="cadastros2.php?metodo=alterar&tipo=motorista&id=<?= $moto->id_motorista ?>"
                                            class="btn btn-sm btn-warning">Editar</a>
                                        <a href="cadastros2.php?metodo=excluir&tipo=motorista&id=<?= $moto->id_motorista ?>"
                                            class="btn btn-sm btn-danger">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

</html>