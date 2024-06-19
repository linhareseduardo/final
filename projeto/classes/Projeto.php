<?php

class Projeto {
    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function create($nome, $descricao, $data_inicial, $data_final, $estabelecimento_id) {
        $stmt = $this->connection->prepare("INSERT INTO projeto (nome, descricao, data_inicial, data_final, estabelecimento_id) VALUES (:nome, :descricao, :data_inicial, :data_final, :estabelecimento_id)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':data_inicial', $data_inicial);
        $stmt->bindParam(':data_final', $data_final);
        $stmt->bindParam(':estabelecimento_id', $estabelecimento_id);

        if ($stmt->execute()) {
            return "Projeto cadastrado com sucesso!";
        } else {
            return "Erro ao cadastrar o projeto.";
        }
    }

    public function read() {
        $stmt = $this->connection->query("SELECT * FROM projeto");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $nome, $descricao, $data_inicial, $data_final, $estabelecimento_id) {
        $stmt = $this->connection->prepare("UPDATE projeto SET nome = :nome, descricao = :descricao, data_inicial = :data_inicial, data_final = :data_final, estabelecimento_id = :estabelecimento_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':data_inicial', $data_inicial);
        $stmt->bindParam(':data_final', $data_final);
        $stmt->bindParam(':estabelecimento_id', $estabelecimento_id);

        if ($stmt->execute()) {
            return "Projeto atualizado com sucesso!";
        } else {
            return "Erro ao atualizar o projeto.";
        }
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM projeto WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return "Projeto excluído com sucesso!";
        } else {
            return "Erro ao excluir o projeto.";
        }
    }
}

?>
