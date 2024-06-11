-- criação das tabelas

CREATE TABLE estabelecimento (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(14) UNIQUE NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    estado VARCHAR(255) NOT NULL
);

CREATE TABLE projeto (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    data_inicial DATE NOT NULL,
    data_final DATE NOT NULL,
    estabelecimento_id INT NOT NULL,
    FOREIGN KEY (estabelecimento_id) REFERENCES estabelecimento(id)
);

CREATE TABLE produto (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    estado BOOLEAN NOT NULL,
    CONSTRAINT check_estado CHECK (estado IN (TRUE, FALSE))
);

CREATE TABLE produto_projeto (
    produto_id INT,
    projeto_id INT,
    PRIMARY KEY (produto_id, projeto_id),
    FOREIGN KEY (produto_id) REFERENCES produto(id),
    FOREIGN KEY (projeto_id) REFERENCES projeto(id)
);


--listagem completa de estabelecimento
select * from estabelecimento;

-- listagem completa de projeto
select * from projeto;

--listagem completa de produto
select * from produto;

--listagem completa de produto_projeto
select * from produto_projeto;

-- Inserção de 30 registros na tabela estabelecimento com nomes únicos
INSERT INTO estabelecimento (nome, descricao, estado)
VALUES
    ('11111111111111', 'Razão Social 1', 'Fantasia 1'),
    ('22222222222222', 'Razão Social 2', 'Fantasia 2'),
    ('33333333333333', 'Razão Social 3', 'Fantasia 3'),
    ('44444444444444', 'Razão Social 4', 'Fantasia 4'),
    ('55555555555555', 'Razão Social 5', 'Fantasia 5'),
    ('66666666666666', 'Razão Social 6', 'Fantasia 6'),
    ('77777777777777', 'Razão Social 7', 'Fantasia 7'),
    ('88888888888888', 'Razão Social 8', 'Fantasia 8'),
    ('99999999999999', 'Razão Social 9', 'Fantasia 9'),
    ('12312312312312', 'Razão Social 10', 'Fantasia 10'),
    ('45645645645645', 'Razão Social 11', 'Fantasia 11'),
    ('78978978978978', 'Razão Social 12', 'Fantasia 12'),
    ('15915915915915', 'Razão Social 13', 'Fantasia 13'),
    ('35735735735735', 'Razão Social 14', 'Fantasia 14'),
    ('24624624624624', 'Razão Social 15', 'Fantasia 15'),
    ('96396396396396', 'Razão Social 16', 'Fantasia 16'),
    ('85285285285285', 'Razão Social 17', 'Fantasia 17'),
    ('74174174174174', 'Razão Social 18', 'Fantasia 18'),
    ('36936936936936', 'Razão Social 19', 'Fantasia 19'),
    ('25825825825825', 'Razão Social 20', 'Fantasia 20'),
    ('14714714714714', 'Razão Social 21', 'Fantasia 21'),
    ('65465465465465', 'Razão Social 22', 'Fantasia 22'),
    ('75375375375375', 'Razão Social 23', 'Fantasia 23'),
    ('95195195195195', 'Razão Social 24', 'Fantasia 24'),
    ('11111111111112', 'Razão Social 25', 'Fantasia 25'),
    ('22222222222223', 'Razão Social 26', 'Fantasia 26'),
    ('33333333333334', 'Razão Social 27', 'Fantasia 27'),
    ('44444444444445', 'Razão Social 28', 'Fantasia 28'),
    ('55555555555556', 'Razão Social 29', 'Fantasia 29'),
    ('66666666666667', 'Razão Social 30', 'Fantasia 30');
	
-- Inserção de registros na tabela projeto
INSERT INTO projeto (nome, descricao, data_inicial, data_final, estabelecimento_id)
VALUES
    ('Projeto 1', 'Descrição do Projeto 1', '2024-04-01', '2024-04-30', 1), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 2', 'Descrição do Projeto 2', '2024-05-01', '2024-05-31', 2), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 3', 'Descrição do Projeto 3', '2024-06-01', '2024-06-30', 3), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 4', 'Descrição do Projeto 4', '2024-07-01', '2024-07-31', 4), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 5', 'Descrição do Projeto 5', '2024-08-01', '2024-08-31', 5), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 6', 'Descrição do Projeto 6', '2024-09-01', '2024-09-30', 6), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 7', 'Descrição do Projeto 7', '2024-10-01', '2024-10-31', 7), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 8', 'Descrição do Projeto 8', '2024-11-01', '2024-11-30', 8), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 9', 'Descrição do Projeto 9', '2024-12-01', '2024-12-31', 9), -- Estabelecimento_id deve existir na tabela estabelecimento
    ('Projeto 10', 'Descrição do Projeto 10', '2025-01-01', '2025-01-31', 10); -- Estabelecimento_id deve existir na tabela estabelecimento

-- Inserção de registros na tabela produto
INSERT INTO produto (nome, descricao, estado)
VALUES
    ('Produto 1', 'Descrição do Produto 1', TRUE),
    ('Produto 2', 'Descrição do Produto 2', FALSE),
    ('Produto 3', 'Descrição do Produto 3', TRUE),
    ('Produto 4', 'Descrição do Produto 4', FALSE),
    ('Produto 5', 'Descrição do Produto 5', TRUE),
    ('Produto 6', 'Descrição do Produto 6', FALSE),
    ('Produto 7', 'Descrição do Produto 7', TRUE),
    ('Produto 8', 'Descrição do Produto 8', FALSE),
    ('Produto 9', 'Descrição do Produto 9', TRUE),
    ('Produto 10', 'Descrição do Produto 10', FALSE),
    ('Produto 11', 'Descrição do Produto 11', TRUE),
    ('Produto 12', 'Descrição do Produto 12', FALSE),
    ('Produto 13', 'Descrição do Produto 13', TRUE),
    ('Produto 14', 'Descrição do Produto 14', FALSE),
    ('Produto 15', 'Descrição do Produto 15', TRUE);

-- Inserção de registros na tabela produto_projeto com produtos em múltiplos projetos
INSERT INTO produto_projeto (produto_id, projeto_id)
VALUES
    (1, 1), -- Produto 1 no Projeto 1
    (2, 2), -- Produto 2 no Projeto 2
    (3, 3), -- Produto 3 no Projeto 3
    (4, 4), -- Produto 4 no Projeto 4
    (5, 5), -- Produto 5 no Projeto 5
    (6, 6), -- Produto 6 no Projeto 6
    (7, 7), -- Produto 7 no Projeto 7
    (8, 8), -- Produto 8 no Projeto 8
    (9, 9), -- Produto 9 no Projeto 9
    (10, 10), -- Produto 10 no Projeto 10
    (1, 2), -- Produto 1 também no Projeto 2
    (2, 3), -- Produto 2 também no Projeto 3
    (3, 4), -- Produto 3 também no Projeto 4
    (4, 5), -- Produto 4 também no Projeto 5
    (5, 6); -- Produto 5 também no Projeto 6

-- listar o nome do estabelecimento, seus projetos e produtos associados

SELECT
    e.estado AS "Estabelecimento",
    p.nome AS "Projeto",
    pr.nome AS "Produto"
FROM
    estabelecimento e
INNER JOIN projeto p ON e.id = p.estabelecimento_id
LEFT JOIN produto_projeto pp ON p.id = pp.projeto_id
LEFT JOIN produto pr ON pp.produto_id = pr.id
ORDER BY
    e.estado,
    p.nome,
    pr.nome;
-- listar os produtos de cada projeto
SELECT
    p.nome AS "Projeto",
    pr.nome AS "Produto"
FROM
    projeto p
LEFT JOIN produto_projeto pp ON p.id = pp.projeto_id
LEFT JOIN produto pr ON pp.produto_id = pr.id
ORDER BY
    p.nome,
    pr.nome;
-- listar os projetos de cada estabelecimento
								   
SELECT
    e.estado AS "Estabelecimento",
    p.nome AS "Projeto"
FROM
    estabelecimento e
INNER JOIN projeto p ON e.id = p.estabelecimento_id
ORDER BY
    e.estado,
    p.nome;

-- Inserção de novos projetos para estabelecimentos existentes
INSERT INTO projeto (nome, descricao, data_inicial, data_final, estabelecimento_id)
VALUES
    ('Novo Projeto 1', 'Descrição do Novo Projeto 1', '2024-04-01', '2024-04-30', 7),
    ('Novo Projeto 2', 'Descrição do Novo Projeto 2', '2024-05-01', '2024-05-31', 8),
    ('Novo Projeto 3', 'Descrição do Novo Projeto 3', '2024-06-01', '2024-06-30', 9),
    ('Novo Projeto 4', 'Descrição do Novo Projeto 4', '2024-07-01', '2024-07-31', 10),
    ('Novo Projeto 5', 'Descrição do Novo Projeto 5', '2024-08-01', '2024-08-31', 11);
							
