<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro de Produto</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        resize: vertical;
    }
    input[type="checkbox"] {
        margin-bottom: 15px;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Cadastro de Produto</h1>
    <form action="teste2.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" maxlength="255" required>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>
        <label for="status">Status:</label>
        <input type="checkbox" id="status" name="status" value="1" checked> Ativo
        <br>
        <input type="submit" value="Cadastrar">
    </form>
</div>
</body>
</html>

<?php
try {
    $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $status = isset($_POST['status']) ? 1 : 0;

        $sql = "INSERT INTO produto (nome, descricao, estado) VALUES (:nome, :descricao, :status)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "<script>alert('Produto cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o produto.');</script>";
        }
    }
} catch (PDOException $e) {
    echo "<script>alert('Erro de conexão com o banco de dados: {$e->getMessage()}');</script>";
}
?>
