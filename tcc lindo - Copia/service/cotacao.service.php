<?php 
    class cotacaoService 
    {
        private $cotacao;
        private $conexao;

        public function __construct(Cotacao $cotacao, Conexao $conexao)
        {
            $this->conexao = $conexao->conectar();
            $this->cotacao = $cotacao;
        }

        public function inserir()
        {
            $query = "INSERT INTO cotacao (id_cotacao, data_saida, cep_origem, endereco_origem, estimativa_entrega, cep_destino,
            valor , endereco_destino , tipo_carga, peso, altura, largura, comprimento, status, id_empresa) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->cotacao->__get('id_cotacao'));
            $stmt->bindValue(2, $this->cotacao->__get('data_saida'));
            $stmt->bindValue(3, $this->cotacao->__get('cep_origem'));
            $stmt->bindValue(4, $this->cotacao->__get('endereco_origem'));
            $stmt->bindValue(5, $this->cotacao->__get('estimativa_entrega'));
            $stmt->bindValue(6, $this->cotacao->__get('cep_destino'));
            $stmt->bindValue(7, $this->cotacao->__get('valor'));
            $stmt->bindValue(8, $this->cotacao->__get('endereco_destino'));
            $stmt->bindValue(9, $this->cotacao->__get('tipo_carga'));
            $stmt->bindValue(10, $this->cotacao->__get('peso'));
            $stmt->bindValue(11, $this->cotacao->__get('altura'));
            $stmt->bindValue(12, $this->cotacao->__get('largura'));
            $stmt->bindValue(13, $this->cotacao->__get('comprimento'));
            $stmt->bindValue(14, $this->cotacao->__get('status'));
            $stmt->bindValue(15, $this->cotacao->__get('id_empresa'));
            $stmt->execute();
        }

        public function recuperar()
        {
            $query = 'SELECT id_cotacao, data_saida, cep_origem, endereco_origem, estimativa_entrega, cep_destino, valor , endereco_destino ,
             tipo_carga, peso, altura, largura, comprimento, status FROM cotacao';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function recuperarCotacao($idc)
        {
            $query = 'SELECT id_cotacao, data_saida, cep_origem, endereco_origem, estimativa_entrega, cep_destino, valor , endereco_destino , tipo_carga, peso, altura, largura, comprimento, status FROM cotacao
                      WHERE id_cotacao = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $idc);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function excluir()
        {
            $query = 'DELETE FROM cotacao WHERE id_cotacao = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->cotacao->__get('id_cotacao'));
            $stmt->execute();
        }

        public function alterar()
        {
            $query = "UPDATE cotacao 
                      SET  data_saida = ?, cep_origem = ?, endereco_origem = ?, estimativa_entrega = ?, cep_destino = ?, valor = ?, endereco_destino = ?, tipo_carga = ?, peso = ?, altura = ?, largura = ?, comprimento = ?, status = ?
                      WHERE id_cotacao = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->cotacao->__get('data_saida'));
            $stmt->bindValue(2, $this->cotacao->__get('cep_origem'));
            $stmt->bindValue(3, $this->cotacao->__get('endereco_origem'));
            $stmt->bindValue(4, $this->cotacao->__get('estimativa_entrega'));
            $stmt->bindValue(5, $this->cotacao->__get('cep_destino'));
            $stmt->bindValue(6, $this->cotacao->__get('valor'));
            $stmt->bindValue(7, $this->cotacao->__get('endereco_destino'));
            $stmt->bindValue(8, $this->cotacao->__get('tipo_carga'));
            $stmt->bindValue(9, $this->cotacao->__get('peso'));
            $stmt->bindValue(10, $this->cotacao->__get('altura'));
            $stmt->bindValue(11, $this->cotacao->__get('largura'));
            $stmt->bindValue(12, $this->cotacao->__get('comprimento'));
            $stmt->bindValue(13, $this->cotacao->__get('status'));
            $stmt->bindValue(14, $this->cotacao->__get('id_cotacao'));
            $stmt->execute();
        }

        public function contar(){
        $query = "SELECT COUNT(*) as total FROM cotacao";
        $stmt = $conexao->prepare($query);}
    }
?>
