<?php 
    class MotoristaService 
    {
        private $motorista;
        private $conexao;

        public function __construct(Motorista $motorista, Conexao $conexao)
        {
            $this->conexao = $conexao->conectar();
            $this->motorista = $motorista;
        }

        public function inserir()
        {
            $query = "INSERT INTO motorista (nome_motorista, cpf, telefone, cnh, renavan, curriculo, email_motorista, senha) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('nome_motorista'));
            $stmt->bindValue(2, $this->motorista->__get('cpf'));
            $stmt->bindValue(3, $this->motorista->__get('telefone'));
            $stmt->bindValue(4, $this->motorista->__get('cnh'));
            $stmt->bindValue(5, $this->motorista->__get('renavan'));
            $stmt->bindValue(6, $this->motorista->__get('curriculo'));
            $stmt->bindValue(7, $this->motorista->__get('email_motorista'));
            $stmt->bindValue(8, $this->motorista->__get('senha'));
            $stmt->execute();
        }

        public function recuperar()
        {
            $query = 'SELECT id_motorista, nome_motorista, cpf, telefone, cnh, renavan, curriculo, email_motorista, senha FROM motorista';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function recuperarMotorista($ide)
        {
            $query = 'SELECT id_motorista, nome_motorista, cpf, telefone, cnh, renavan, curriculo, email_empresa, senha 
                      FROM motorista WHERE id_motorista = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $ide);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function excluir()
        {
            $query = 'DELETE FROM motorista WHERE id_motorista = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->empresa->__get('id_motorista'));
            $stmt->execute();
        }

        public function alterar()
        {
            $query = "UPDATE motorista 
                      SET nome_motorista = ?, cpf = ?, telefone = ?, cnh = ?, renavan = ?, email_motorista = ?, senha = ? 
                      WHERE id_motorista = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('nome_motorista'));
            $stmt->bindValue(2, $this->motorista->__get('cpf'));
            $stmt->bindValue(3, $this->motorista->__get('telefone'));
            $stmt->bindValue(4, $this->motorista->__get('cnh'));
            $stmt->bindValue(5, $this->motorista->__get('email_motorista'));
            $stmt->bindValue(6, $this->motorista->__get('senha'));
            $stmt->bindValue(7, $this->motorista->__get('cnpj'));
            $stmt->bindValue(8, $this->motorista->__get('id_motorista'));
            $stmt->execute();
        }
    }
?>
