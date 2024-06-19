<?php

class Estabelecimento {
    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function create($cnpj, $razaosocial, $nomefantasia) {
        $stmt = $this->connection->prepare("INSERT INTO estabelecimento (cnpj, razaosocial, nomefantasia) VALUES (:cnpj, :razaosocial, :nomefantasia)");
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':razaosocial', $razaosocial);
        $stmt->bindParam(':nomefantasia', $nomefantasia);

        if ($stmt->execute()) {
            return "Estabelecimento cadastrado com sucesso!";
        } else {
            return "Erro ao cadastrar o estabelecimento.";
        }
    }

    public function read() {
        $stmt = $this->connection->query("SELECT * FROM estabelecimento");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $cnpj, $razaosocial, $nomefantasia) {
        $stmt = $this->connection->prepare("UPDATE estabelecimento SET cnpj = :cnpj, razaosocial = :razaosocial, nomefantasia = :nomefantasia WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':razaosocial', $razaosocial);
        $stmt->bindParam(':nomefantasia', $nomefantasia);

        if ($stmt->execute()) {
            return "Estabelecimento atualizado com sucesso!";
        } else {
            return "Erro ao atualizar o estabelecimento.";
        }
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM estabelecimento WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return "Estabelecimento excluído com sucesso!";
        } else {
            return "Erro ao excluir o Estabelecimento.";
        }
    }
}

?>
