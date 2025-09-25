<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$acaoc = 'recuperar';
require '../cotacao.controller.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN Cota</title>
    <link rel="shortcut icon" type="imagex/png" href="/imagens/logo.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/areaRestritaCota.css">
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
            <div class="col-md-11">
                <h2>Cotação</h2>
                <table class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Data Saída</th>
                            <th>Estimativa Entrega</th>
                            <th>Cep Origem</th>
                            <th>Endereço Origem</th>
                            <th>Cep Destino</th>
                            <th>Endereço Origem</th>
                            <th>Valor</th>
                            <th>Tipo Carga</th>
                            <th>Peso</th>
                            <th>Altura</th>
                            <th>Largura</th>
                            <th>Comprimento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cotacao) && is_array($cotacao)): ?>
                            <?php foreach ($cotacao as $cota): ?>
                                <tr>
                                    <td><?= $cota->id_cotacao ?></td>
                                    <td><?= htmlspecialchars($cota->data_saida) ?></td>
                                    <td><?= htmlspecialchars($cota->estimativa_entrega) ?></td>
                                    <td><?= htmlspecialchars($cota->cep_origem) ?></td>
                                    <td><?= htmlspecialchars($cota->endereco_origem) ?></td>
                                    <td><?= htmlspecialchars($cota->cep_destino) ?></td>
                                    <td><?= htmlspecialchars($cota->endereco_destino) ?>
                                    <td><?= htmlspecialchars($cota->valor) ?>
                                    <td><?= htmlspecialchars($cota->tipo_carga) ?>
                                    <td><?= htmlspecialchars($cota->peso) ?>
                                    <td><?= htmlspecialchars($cota->altura) ?>
                                    <td><?= htmlspecialchars($cota->largura) ?>
                                    <td><?= htmlspecialchars($cota->comprimento) ?>
                                    <td>
                                        <a href="../cotacao2.php?metodo=alterar&tipo=cotacao&id=<?= $cota->id_cotacao ?>"
                                            class="btn btn-sm btn-warning">Editar</a>
                                        <a href="../cotacao2.php?metodo=excluir&tipo=cotacao&id=<?= $cota->id_cotacao ?>"
                                            class="btn btn-sm btn-danger">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="14" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

</html>