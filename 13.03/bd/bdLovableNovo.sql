create database devlog;
use devlog;
-- Empresa (quem oferece fretes)
CREATE TABLE Empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(150) NOT NULL,
    email_empresa VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Motorista (quem escolhe fretes)
CREATE TABLE Motorista (
    id_motorista INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    cpf CHAR(14) UNIQUE NOT NULL,
    telefone VARCHAR(15),
    cnh VARCHAR(20),
    renavan VARCHAR(20),
    email VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    curriculo VARCHAR(255),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cotação (frete)
CREATE TABLE Cotacao (
    id_cotacao INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    id_motorista INT NULL, -- preenchido quando um motorista escolhe
    data_saida DATETIME NOT NULL,
    estimativa_entrega DATETIME,
    cep_origem VARCHAR(10),
    endereco_origem VARCHAR(255),
    cep_destino VARCHAR(10),
    valor decimal(10,2),
    endereco_destino VARCHAR(255),
    tipo_carga VARCHAR(50),
    peso VARCHAR(50),
    altura DECIMAL(10,2),
    largura DECIMAL(10,2),
    comprimento DECIMAL(10,2),
    status ENUM('ABERTA','ATRIBUIDA','CONCLUIDA') DEFAULT 'ABERTA',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa),
    FOREIGN KEY (id_motorista) REFERENCES Motorista(id_motorista)
);

