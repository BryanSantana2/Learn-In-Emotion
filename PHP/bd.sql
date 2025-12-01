CREATE DATABASE IF NOT EXISTS learn_in_emotion;
USE learn_in_emotion;


CREATE TABLE alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_nasc DATE NOT NULL,
    status ENUM('ativo','inativo','pendente') DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE instrumentos (
    id_instrumento INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT,
    INDEX idx_nome_instrumento (nome)
);

CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    professor VARCHAR(100) NOT NULL,
    id_instrumento INT NOT NULL, -- Coluna adicionada para a FK
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_instrumento) REFERENCES instrumentos(id_instrumento)
);

CREATE TABLE matriculas (
    id_matricula INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_curso INT NOT NULL,
    data_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_fim DATE,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

CREATE TABLE licoes (
    id_licao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    descricao TEXT,
    id_curso INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

CREATE TABLE exercicios (
    id_exercicio INT AUTO_INCREMENT PRIMARY KEY,
    descricao TEXT NOT NULL,
    id_licao INT NOT NULL,
    concluido ENUM('pendente', 'em andamento', 'concluido') DEFAULT 'pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_licao) REFERENCES licoes(id_licao)
);

CREATE TABLE partituras (
    id_partitura INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    id_instrumento INT NOT NULL,
    conteudo TEXT, -- pode ser URL de PDF, texto ou caminho do arquivo
    FOREIGN KEY (id_instrumento) REFERENCES instrumentos(id_instrumento)
);

CREATE TABLE cifras_tabs (
    id_cifra INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    artista VARCHAR(100),
    tipo ENUM('cifra','tablatura','partitura') NOT NULL,
    id_instrumento INT NOT NULL,
    conteudo LONGTEXT NOT NULL, -- cifra/tab completa
    FOREIGN KEY (id_instrumento) REFERENCES instrumentos(id_instrumento)
);

CREATE TABLE favoritos (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_cifra INT NOT NULL,
    data_adicionado DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno),
    FOREIGN KEY (id_cifra) REFERENCES cifras_tabs(id_cifra)
);

CREATE TABLE comunidade (
    id_comunidade INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    id_aluno INT NOT NULL,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno)
);

USE learn_in_emotion;

ALTER TABLE alunos 
ADD COLUMN instrumento_foco VARCHAR(50) DEFAULT NULL,
ADD COLUMN nivel_atual ENUM('basico', 'intermediario', 'avancado') DEFAULT 'basico';

CREATE TABLE IF NOT EXISTS progresso_aulas (
    id_progresso INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    instrumento VARCHAR(50) NOT NULL,
    codigo_licao VARCHAR(100) NOT NULL, -- Ex: 'licao_bateria1'
    data_conclusao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno)
);