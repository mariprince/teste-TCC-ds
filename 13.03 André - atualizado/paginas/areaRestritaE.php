<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$acaoe = 'recuperar';
require '../empresa.controller.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN Empresa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/areaRestritaE.css">
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
                <li><a href="index.html">Início</a></li>
                <li><a href="empresa.html">Empresa</a></li>
                <li><a href="cadastros.html">Cadastrar</a></li>
            </ul>
        </nav>
    </header>

    <!-- Conteúdo -->
    <div class="container mt-5">
        <div class="row" style="justify-content: center;">
            <!-- Lista de usuários -->
            <div class="col-md-8">
                <h2>Empresas</h2>
                <table class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($empresa) && is_array($empresa)): ?>
                            <?php foreach ($empresa as $emp): ?>
                                <tr>
                                    <td><?= $emp->id_empresa ?></td>
                                    <td><?= htmlspecialchars($emp->nome_empresa) ?></td>
                                    <td><?= htmlspecialchars($emp->cnpj) ?></td>
                                    <td><?= htmlspecialchars($emp->email_empresa) ?></td>
                                    <td>
                                        <a href="cadastros2.php?metodo=alterar&tipo=empresa&id=<?= $emp->id_empresa ?>"
                                            class="btn btn-sm btn-warning">Editar</a>
                                        <a href="cadastros2.php?metodo=excluir&tipo=empresa&id=<?= $emp->id_empresa ?>"
                                            class="btn btn-sm btn-danger">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

</html>