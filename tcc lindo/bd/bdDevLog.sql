create database devlog;
use devlog;
-- Tabela de Motoristas
CREATE TABLE Motorista (
    id_motorista INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    cpf CHAR(14) UNIQUE NOT NULL,
    telefone VARCHAR(15),
    cnh VARCHAR(20),
    renavan VARCHAR(20),
    email VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    curriculo VARCHAR(255), -- caminho do arquivo
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Empresas
CREATE TABLE Empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(150) NOT NULL,
    email_empresa VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Login (pode unificar Motorista e Empresa)
CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('MOTORISTA','EMPRESA') NOT NULL,
    id_motorista INT,
    id_empresa INT,
    FOREIGN KEY (id_motorista) REFERENCES Motorista(id_motorista),
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
);

-- Tabela de Cotações de Frete
CREATE TABLE Cotacao (
    id_cotacao INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    data_saida DATETIME NOT NULL,
    estimativa_entrega DATETIME,
    cep_origem VARCHAR(10),
    endereco_origem VARCHAR(255),
    cep_destino VARCHAR(10),
    endereco_destino VARCHAR(255),
    tipo_carga VARCHAR(50),
    peso VARCHAR(50),
    altura DECIMAL(10,2),
    largura DECIMAL(10,2),
    comprimento DECIMAL(10,2),
    carga_perigosa BOOLEAN DEFAULT FALSE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
);

-- Tabela auxiliar para informações de cargas perigosas
CREATE TABLE CargaPerigosaInfo (
    id_info INT AUTO_INCREMENT PRIMARY KEY,
    id_cotacao INT NOT NULL,
    pictograma BOOLEAN DEFAULT FALSE,
    ficha_dados BOOLEAN DEFAULT FALSE,
    identificacao BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_cotacao) REFERENCES Cotacao(id_cotacao)
);
