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
    die("Erro: dados insuficientes para finalizar o frete. 
         id_cotacao = " . var_export($id_cotacao, true) . 
         ", id_motorista = " . var_export($id_motorista, true));
}

try {
    // 🟩 Cria conexão com o banco
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // 🟦 Atualiza o status para CONCLUIDA
    $query = "UPDATE cotacao 
              SET status = 'CONCLUIDA'
              WHERE id_cotacao = :id_cotacao 
              AND id_motorista = :id_motorista";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id_motorista', $id_motorista, PDO::PARAM_INT);
    $stmt->bindValue(':id_cotacao', $id_cotacao, PDO::PARAM_INT);
    $stmt->execute();

    // 🟨 Redireciona de volta ao dashboard
    header("Location: dashboard.php?tab=aceitos");
    exit;

} catch (PDOException $e) {
    echo "Erro ao finalizar frete: " . $e->getMessage();
}
