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
    <h1>Cadastro de Estabelecimento</h1>
    <form action="cadastrar_produto.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" maxlength="255" required>
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" maxlength="255" required>
        <label for="status">Status:</label>
        <input type="checkbox" id="status" name="status" value="1" checked> Ativo
        <br>
        <input type="submit" value="Cadastrar">
    </form>
</div>
</body>
</html>

<?php
$connection = pg_connect("host=localhost dbname=projeto user=postgres password=root");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = pg_escape_string($connection, $_POST['nome']);
  $descricao = pg_escape_string($connection, $_POST['descricao']);
  $status = isset($_POST['status']) ? 'TRUE' : 'FALSE';

  $query = "INSERT INTO produto (nome, descricao, estado) VALUES ('$nome', '$descricao', $status)";
  $result = pg_query($connection, $query);

  if ($result) {
    echo "<p>Produto cadastrado com sucesso!</p>";
  } else {
    echo "<p>Erro ao cadastrar o produto.</p>";
  }
}

pg_close($connection);
?>
