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
    .container {
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1, h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="submit"], button {
        background-color: #4CAF50;
        color: #fff;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
    }
    input[type="submit"]:hover, button:hover {
        background-color: #45a049;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
</style>
</head>
<body>
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
                echo "<option disabled selected>Erro ao carregar projetos</option>";
            }
            ?>
        </select>
        <input type="submit" name="associar" value="Associar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');

            if (isset($_POST['associar'])) {
                // Associar produto a projeto
                $produtoId = $_POST['produtoId'];
                $projetoId = $_POST['projetoId'];
                $associarStmt = $connection->prepare("INSERT INTO produto_projeto (produto_id, projeto_id) VALUES (:produtoId, :projetoId)");
                $associarStmt->bindParam(':produtoId', $produtoId);
                $associarStmt->bindParam(':projetoId', $projetoId);
                if ($associarStmt->execute()) {
                    echo "<script>alert('Associação realizada com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao associar produto ao projeto.');</script>";
                }
            }

            if (isset($_POST['deleteProdutoId']) && isset($_POST['deleteProjetoId'])) {
                // Excluir associação
                $deleteProdutoId = $_POST['deleteProdutoId'];
                $deleteProjetoId = $_POST['deleteProjetoId'];
                $deleteStmt = $connection->prepare("DELETE FROM produto_projeto WHERE produto_id = :produtoId AND projeto_id = :projetoId");
                $deleteStmt->bindParam(':produtoId', $deleteProdutoId);
                $deleteStmt->bindParam(':projetoId', $deleteProjetoId);
                if ($deleteStmt->execute()) {
                    echo "<script>alert('Associação excluída com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao excluir a associação.');</script>";
                }
            }
        } catch (PDOException $e) {
            echo "<script>alert('Erro de conexão com o banco de dados: {$e->getMessage()}');</script>";
        }
    }
    ?>

    <h2>Excluir Associação</h2>
    <table>
        <tr>
            <th>Produto</th>
            <th>Projeto</th>
            <th>Actions</th>
        </tr>
        <?php
        $associacoes = $connection->query("SELECT pp.produto_id, pp.projeto_id, p.nome as produto_nome, pr.nome as projeto_nome FROM produto_projeto pp JOIN produto p ON pp.produto_id = p.id JOIN projeto pr ON pp.projeto_id = pr.id order by 1");
        foreach ($associacoes as $associacao) {
            echo "<tr>";
            echo "<td>{$associacao['produto_nome']}</td>";
            echo "<td>{$associacao['projeto_nome']}</td>";
            echo "<td>";
            echo "<form method='post' style='display:inline;'>";
            echo "<input type='hidden' name='deleteProdutoId' value='{$associacao['produto_id']}'>";
            echo "<input type='hidden' name='deleteProjetoId' value='{$associacao['projeto_id']}'>";
            echo "<button type='submit'>Excluir</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
