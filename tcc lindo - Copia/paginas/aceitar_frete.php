<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../conexao/conexao.php';

// 🟩 Pegamos os dados do formulário e da sessão:
    $id_cotacao = $_POST['id_cotacao'] ?? null;
    $id_motorista = $_SESSION['id_motorista'] ?? null;
    
    
// 🟥 Testa se veio tudo certo
if (!$id_cotacao || !$id_motorista) {
    die("Erro: dados insuficientes para aceitar o frete. 
         id_cotacao = " . var_export($id_cotacao, true) . 
         ", id_motorista = " . var_export($id_motorista, true));
}

try {
    // 🟩 Cria conexão com o banco
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // 🟦 Atualiza o status e vincula ao motorista
    $query = "UPDATE cotacao 
              SET status = 'ATRIBUIDO', id_motorista = :id_motorista 
              WHERE id_cotacao = :id_cotacao";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id_motorista', $id_motorista);
    $stmt->bindValue(':id_cotacao', $id_cotacao);
    $stmt->execute();

    // 🟨 Redireciona de volta ao dashboard com parâmetro para abrir aba de fretes aceitos
    header("Location: dashboard.php?tab=aceitos");
    exit;

} catch (PDOException $e) {
    echo "Erro ao aceitar frete: " . $e->getMessage();
}
