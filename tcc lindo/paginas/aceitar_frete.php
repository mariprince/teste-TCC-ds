<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once '../conexao/conexao.php';

// Pega os dados do formulário
$id_cotacao = $_POST['id_cotacao'] ?? null;
$id_motorista = $_POST['id_motorista'] ?? ($_SESSION['id_motorista'] ?? null);

if (!$id_cotacao || !$id_motorista) {
    die("Erro: dados insuficientes para aceitar o frete.");
}

try {
    // Cria conexão
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Atualiza o status do frete e associa ao motorista
    $query = "UPDATE cotacao 
              SET status = 'ACEITO', id_motorista = :id_motorista 
              WHERE id_cotacao = :id_cotacao";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id_motorista', $id_motorista);
    $stmt->bindValue(':id_cotacao', $id_cotacao);
    $stmt->execute();

    // Redireciona de volta ao dashboard
    header("Location: dashboard.php");
    exit;

} catch (PDOException $e) {
    echo "Erro ao aceitar frete: " . $e->getMessage();
}
