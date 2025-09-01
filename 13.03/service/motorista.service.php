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

        $id_motorista;
$nome_completo;
$cpf;
$telefone;
$cnh;
$renavan;
$email;
$senha;
$curriculo;
$data_cadastro
        


        public function inserir()
        {
            $query = "INSERT INTO motorista (id_motorista, ome_completo, cpf, telefone, cnh, renavan, email, senha, curriculo, data_cadastro) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('nome_empresa'));
            $stmt->bindValue(2, $this->motorista->__get('email_empresa'));
            $stmt->bindValue(3, $this->motorista->__get('senha'));
            $stmt->bindValue(4, $this->motorista->__get('cnpj'));
            $stmt->execute();
        }

        public function recuperar()
        {
            $query = 'SELECT id_empresa, nome_empresa, email_empresa, senha, cnpj FROM empresa';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function recuperarEmpresa($ide)
        {
            $query = 'SELECT id_empresa, nome_empresa, email_empresa, senha, cnpj 
                      FROM empresa WHERE id_empresa = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $ide);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function excluir()
        {
            $query = 'DELETE FROM empresa WHERE id_empresa = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->empresa->__get('id_empresa'));
            $stmt->execute();
        }

        public function alterar()
        {
            $query = "UPDATE empresa 
                      SET nome_empresa = ?, email_empresa = ?, senha = ?, cnpj = ? 
                      WHERE id_empresa = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->empresa->__get('nome_empresa'));
            $stmt->bindValue(2, $this->empresa->__get('email_empresa'));
            $stmt->bindValue(3, $this->empresa->__get('senha'));
            $stmt->bindValue(4, $this->empresa->__get('cnpj'));
            $stmt->bindValue(5, $this->empresa->__get('id_empresa'));
            $stmt->execute();
        }
    }
?>
