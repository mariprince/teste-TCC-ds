<?php 
    class Empresa 
    {
        private $id_empresa;
        private $nome_empresa;
        private $email_empresa;
        private $senha;
        private $cnpj;

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
