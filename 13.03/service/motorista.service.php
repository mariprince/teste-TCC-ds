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
            $query = "INSERT INTO Motorista 
                     (nome_completo, cpf, telefone, cnh, renavan, email, senha, curriculo) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('nome_completo'));
            $stmt->bindValue(2, $this->motorista->__get('cpf'));
            $stmt->bindValue(3, $this->motorista->__get('telefone'));
            $stmt->bindValue(4, $this->motorista->__get('cnh'));
            $stmt->bindValue(5, $this->motorista->__get('renavan'));
            $stmt->bindValue(6, $this->motorista->__get('email'));
            $stmt->bindValue(7, $this->motorista->__get('senha'));
            $stmt->bindValue(8, $this->motorista->__get('curriculo'));
            
            if ($stmt->execute()) {
                $this->salvarCurriculo();
                return $this->conexao->lastInsertId();
            }
            return false;
        }

        public function recuperar()
        {
            $query = 'SELECT id_motorista, nome_completo, cpf, telefone, cnh, renavan, email, curriculo, data_cadastro 
                      FROM Motorista';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function recuperarMotorista($idm)
        {
            $query = 'SELECT id_motorista, nome_completo, cpf, telefone, cnh, renavan, email, curriculo, data_cadastro 
                      FROM Motorista WHERE id_motorista = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $idm);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function excluir()
        {
            // Primeiro recupera o nome do currículo para excluir o arquivo
            $motorista = $this->recuperarMotorista($this->motorista->__get('id_motorista'));
            $curriculo = $motorista->curriculo;

            $query = 'DELETE FROM Motorista WHERE id_motorista = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('id_motorista'));

            if ($stmt->execute() && $curriculo) {
                $this->removerCurriculo($curriculo);
                return true;
            }
            return false;
        }

        public function alterar()
        {
            $curriculoAntigo = null;
            
            // Se está enviando um novo currículo, recupera o antigo para excluir
            if ($this->motorista->__get('curriculo')) {
                $motoristaAtual = $this->recuperarMotorista($this->motorista->__get('id_motorista'));
                $curriculoAntigo = $motoristaAtual->curriculo;
            }

            $query = "UPDATE Motorista 
                      SET nome_completo = ?, cpf = ?, telefone = ?, cnh = ?, 
                          renavan = ?, email = ?, senha = ?, curriculo = ? 
                      WHERE id_motorista = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('nome_completo'));
            $stmt->bindValue(2, $this->motorista->__get('cpf'));
            $stmt->bindValue(3, $this->motorista->__get('telefone'));
            $stmt->bindValue(4, $this->motorista->__get('cnh'));
            $stmt->bindValue(5, $this->motorista->__get('renavan'));
            $stmt->bindValue(6, $this->motorista->__get('email'));
            $stmt->bindValue(7, $this->motorista->__get('senha'));
            $stmt->bindValue(8, $this->motorista->__get('curriculo'));
            $stmt->bindValue(9, $this->motorista->__get('id_motorista'));

            if ($stmt->execute()) {
                if ($curriculoAntigo && $curriculoAntigo !== $this->motorista->__get('curriculo')) {
                    $this->removerCurriculo($curriculoAntigo);
                }
                if ($this->motorista->__get('curriculo')) {
                    $this->salvarCurriculo();
                }
                return true;
            }
            return false;
        }
        
        public function autenticar() 
        {
            $query = "SELECT id_motorista, nome_completo, email, curriculo 
                      FROM Motorista 
                      WHERE email = ? AND senha = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->motorista->__get('email'));
            $stmt->bindValue(2, $this->motorista->__get('senha'));
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        
        public function buscarPorEmail($email) 
        {
            $query = "SELECT * FROM Motorista WHERE email = ? LIMIT 1";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $email);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        // Salva o currículo no diretório
        private function salvarCurriculo() {
            if (!empty($_FILES['curriculo']['tmp_name'])) {
                $diretorio = "curriculos/";
                if (!is_dir($diretorio)) {
                    mkdir($diretorio, 0755, true);
                }
                move_uploaded_file($_FILES['curriculo']['tmp_name'], $diretorio . $this->motorista->__get('curriculo'));
            }
        }

        // Remove o currículo do servidor
        private function removerCurriculo($nomeCurriculo) {
            $caminho = "curriculos/" . $nomeCurriculo;
            if (file_exists($caminho)) {
                unlink($caminho);
            }
        }
    }
?>