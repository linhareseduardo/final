<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Associar Produto a Projeto</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .menu {
        background-color: #333;
        overflow: hidden;
    }
    .menu a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }
    .menu a:hover, .submenu a:hover {
        background-color: #ddd;
        color: black;
    }
    .submenu {
        display: none;
        position: absolute;
        background-color: #333;
        min-width: 160px;
        z-index: 1;
    }
    .submenu a {
        float: none;
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }
    .menu .dropdown {
        float: left;
        overflow: hidden;
    }
    .menu .dropdown:hover .submenu {
        display: block;
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
    select, input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>

<div class="menu">
    <div class="dropdown">
        <a href="#">Cadastro</a>
        <div class="submenu">
            <a href="cadastroestabelecimento.php">Estabelecimento</a>
            <a href="cadastroprojeto.php">Projeto</a>
            <a href="cadastroproduto.php">Produto</a>
            <a href="associacaoprodutoprojeto.php">Associação Projeto-Produto</a>
        </div>
    </div>
    <div class="dropdown">
        <a href="#">Listagem</a>
        <div class="submenu">
            <a href="editardeletarestabelecimento.php">Estabelecimento</a>
            <a href="editardeletarprojeto.php">Projeto</a>
            <a href="editardeletarproduto.php">Produto</a>
            <a href="associardeletarprodutoprojeto.php">Associação Projeto-Produto</a>
        </div>
    </div>
</div>

<div class="container">
    <h1>Associar Produto a Projeto</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="produtoId">Produto:</label>
        <select id="produtoId" name="produtoId" required>
            <?php
            try {
                $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
                if ($connection) {
                    // Consulta para obter os produtos
                    $produtos = $connection->query("SELECT id, nome FROM produto");
                    foreach ($produtos as $produto) {
                        echo "<option value='$produto[id]'>$produto[nome]</option>";
                    }
                }
            } catch (PDOException $e) {
                // Tratamento de erro
                echo "<option disabled selected>Erro ao carregar produtos</option>";
            }
            ?>
        </select>
        <label for="projetoId">Projeto:</label>
        <select id="projetoId" name="projetoId" required>
            <?php
            try {
                $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
                if ($connection) {
                    // Consulta para obter os projetos
                    $projetos = $connection->query("SELECT id, nome FROM projeto");
                    foreach ($projetos as $projeto) {
                        echo "<option value='$projeto[id]'>$projeto[nome]</option>";
                    }
                }
            } catch (PDOException $e) {
                // Tratamento de erro
                echo "<option disabled selected>Erro ao carregar projetos</option>";
            }
            ?>
        </select>
        <input type="submit" value="Associar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');

            $produtoId = $_POST['produtoId'];
            $projetoId = $_POST['projetoId'];

            // Verificar se o produto e o projeto existem
            $stmtVerificar = $connection->prepare("SELECT * FROM produto WHERE id = :produtoId");
            $stmtVerificar->bindParam(':produtoId', $produtoId);
            $stmtVerificar->execute();
            $produtoExiste = $stmtVerificar->fetch();

            $stmtVerificarProjeto = $connection->prepare("SELECT * FROM projeto WHERE id = :projetoId");
            $stmtVerificarProjeto->bindParam(':projetoId', $projetoId);
            $stmtVerificarProjeto->execute();
            $projetoExiste = $stmtVerificarProjeto->fetch();

            if ($produtoExiste && $projetoExiste) {
                // Inserir na tabela produto_projeto
                $sql = "INSERT INTO produto_projeto (produto_id, projeto_id) VALUES (:produtoId, :projetoId)";
                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':produtoId', $produtoId);
                $stmt->bindParam(':projetoId', $projetoId);

                if ($stmt->execute()) {
                    echo "<script>alert('Produto associado ao projeto com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao associar o produto ao projeto.');</script>";
                }
            } else {
                echo "<script>alert('Produto ou projeto não encontrado.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Erro de conexão com o banco de dados: {$e->getMessage()}');</script>";
        }
    }
    ?>
</div>

</body>
</html>
