<?php 
    class Cotacao 
    {
        private $id_cotacao;
        private $data_saida; 
        private $estimativa_entrega;
        private $cep_origem; 
        private $endereco_origem; 
        private $cep_destino; 
        private $valor;  
        private $endereco_destino; 
        private $tipo_carga; 
        private $peso; 
        private $altura; 
        private $largura;
        private $comprimento;
       
        public function __set($atributo, $valor)
        {
            $this->$atributo = $valor;
        }

        public function __get($atributo)
        {
            return $this->$atributo;
        }
    }
?>
