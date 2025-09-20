<?php
class Conexao {
    private $host = 'localhost';
    private $dbname = 'devlog';
    private $user = 'root';
    private $pass = '';

    public function conectar() {
        try {
            $conexao = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->user,
                $this->pass
            );
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Erro ao conectar com o banco de dados.";
        }
    }
}
?>