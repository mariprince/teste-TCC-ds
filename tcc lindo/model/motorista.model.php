<?php 
    class Motorista
    {
        private $id_motorista;
        private $nome_completo;
        private $cpf;
        private $numCtt;
        private $cnh;
        private $renavan;
        private $email_motorista;
        private $senha;
        private $curriculo;
        private $data_cadastro;
        
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