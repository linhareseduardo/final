<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro de Projeto</title>
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
    input[type="text"],
    input[type="date"],
    select {
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
    <h1>Cadastro de Projeto</h1>
    <form action="teste.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" maxlength="255" required>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>
        <label for="dataInicial">Data Inicial:</label>
        <input type="date" id="dataInicial" name="dataInicial" required>
        <label for="dataFinal">Data Final:</label>
        <input type="date" id="dataFinal" name="dataFinal" required>
        <label for="estabelecimentoId">Estabelecimento:</label>
        <select id="estabelecimentoId" name="estabelecimentoId" required>
            <?php
            try {
                $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
                if ($connection) {
                    // Consulta para obter os estabelecimentos
                    $estabelecimentos = $connection->query("SELECT id, nomefantasia FROM estabelecimento");
                    foreach ($estabelecimentos as $estabelecimento) {
                        echo "<option value='$estabelecimento[id]'>$estabelecimento[nomefantasia]</option>";
                    }
                }
            } catch (PDOException $e) {
                // Tratamento de erro
                echo $e->getMessage();
            }
            ?>
        </select>
        <input type="submit" value="Cadastrar">
    </form>
</div>
</body>
</html>

<?php
try {
    $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');

    if ($connection) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $dataInicial = $_POST['dataInicial'];
            $dataFinal = $_POST['dataFinal'];
            $estabelecimentoId = $_POST['estabelecimentoId'];

            // Preparar a instrução SQL para inserir os dados do projeto
            $sql = "INSERT INTO projeto (nome, descricao, data_inicial, data_final, estabelecimento_id) 
                    VALUES (:nome, :descricao, :dataInicial, :dataFinal, :estabelecimentoId)";

            // Preparar a consulta
            $stmt = $connection->prepare($sql);

            // Bind dos parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':dataInicial', $dataInicial);
            $stmt->bindParam(':dataFinal', $dataFinal);
            $stmt->bindParam(':estabelecimentoId', $estabelecimentoId);

            // Executar a consulta
            if ($stmt->execute()) {
                echo "<script>alert('Projeto cadastrado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar o projeto.');</script>";
            }
        }
    }
} catch (PDOException $e) {
    // Tratamento de erro
    echo "<script>alert('$e->getMessage()');</script>";
}
?>
