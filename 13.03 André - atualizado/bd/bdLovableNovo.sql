create database devlog;
use devlog;
-- Empresa (quem oferece fretes)
CREATE TABLE Empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(150) NOT NULL,
    email_empresa VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- Motorista (quem escolhe fretes)
CREATE TABLE Motorista (
    id_motorista INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    cpf CHAR(14) UNIQUE NOT NULL,
    numCtt VARCHAR(15) NOT NULL,
    cnh VARCHAR(20) NOT NULL,
    renavan VARCHAR(20),
    email_motorista VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    curriculo VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- Cotação (frete)
CREATE TABLE Cotacao (
    id_cotacao INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    id_motorista INT NULL, -- preenchido quando um motorista escolhe
    data_saida DATETIME NOT NULL,
    estimativa_entrega DATETIME NOT NULL,
    cep_origem VARCHAR(10) NOT NULL,
    endereco_origem VARCHAR(255) NOT NULL,
    cep_destino VARCHAR(10) NOT NULL,
    valor decimal(10,2) NOT NULL,
    endereco_destino VARCHAR(255) NOT NULL,
    tipo_carga VARCHAR(50) NOT NULL,
    peso VARCHAR(50) NOT NULL,
    altura DECIMAL(10,2) NOT NULL,
    largura DECIMAL(10,2) NOT NULL,
    comprimento DECIMAL(10,2) NOT NULL,
    status ENUM('ABERTA','ATRIBUIDA','CONCLUIDA') DEFAULT 'ABERTA' NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa),
    FOREIGN KEY (id_motorista) REFERENCES Motorista(id_motorista)
);

