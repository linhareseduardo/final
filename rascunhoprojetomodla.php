<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar e Deletar Projetos</title>
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
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-edit, .btn-delete {
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }
        .btn-edit {
            background-color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 50px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-create {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .btn-create:hover {
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
    <h1>Editar e deletar Projetos</h1>
    <button class="btn-create" onclick="openCreateModal()">Cadastrar Projeto</button>
    <?php
    try {
        $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
        if ($connection) {
            echo "Database connected";
        }
    } catch (PDOException $e) {
        // report error message
        echo $e->getMessage();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleteId'])) {
            $deleteId = $_POST['deleteId'];
            $deleteStmt = $connection->prepare("DELETE FROM projeto WHERE id = :id");
            $deleteStmt->bindParam(':id', $deleteId);
            if ($deleteStmt->execute()) {
                echo '<script>alert("Projeto excluído com sucesso!");</script>';
            } else {
                echo '<script>alert("Erro ao excluir o projeto.");</script>';
            }
        } else if (isset($_POST['editId'])) {
            $editId = $_POST['editId'];
            $editNome = $_POST['editNome'];
            $editDescricao = $_POST['editDescricao'];
            $editDataInicial = $_POST['editDataInicial'];
            $editDataFinal = $_POST['editDataFinal'];
            $editEstabelecimentoId = $_POST['editEstabelecimentoId'];

            $editStmt = $connection->prepare("UPDATE projeto SET nome = :nome, descricao = :descricao, data_inicial = :data_inicial, data_final = :data_final, estabelecimento_id = :estabelecimento_id WHERE id = :id");
            $editStmt->bindParam(':id', $editId);
            $editStmt->bindParam(':nome', $editNome);
            $editStmt->bindParam(':descricao', $editDescricao);
            $editStmt->bindParam(':data_inicial', $editDataInicial);
            $editStmt->bindParam(':data_final', $editDataFinal);
            $editStmt->bindParam(':estabelecimento_id', $editEstabelecimentoId);

            if ($editStmt->execute()) {
                echo '<script>alert("Projeto atualizado com sucesso!");</script>';
            } else {
                echo '<script>alert("Erro ao atualizar o projeto.");</script>';
            }
        } else if (isset($_POST['createNome'])) {
            $createNome = $_POST['createNome'];
            $createDescricao = $_POST['createDescricao'];
            $createDataInicial = $_POST['createDataInicial'];
            $createDataFinal = $_POST['createDataFinal'];
            $createEstabelecimentoId = $_POST['createEstabelecimentoId'];

            $createStmt = $connection->prepare("INSERT INTO projeto (nome, descricao, data_inicial, data_final, estabelecimento_id) VALUES (:nome, :descricao, :data_inicial, :data_final, :estabelecimento_id)");
            $createStmt->bindParam(':nome', $createNome);
            $createStmt->bindParam(':descricao', $createDescricao);
            $createStmt->bindParam(':data_inicial', $createDataInicial);
            $createStmt->bindParam(':data_final', $createDataFinal);
            $createStmt->bindParam(':estabelecimento_id', $createEstabelecimentoId);

            if ($createStmt->execute()) {
                echo '<script>alert("Projeto criado com sucesso!");</script>';
            } else {
                echo '<script>alert("Erro ao criar o projeto.");</script>';
            }
        }
    }

    $result = $connection->query("SELECT * FROM projeto ORDER BY id");
    if (!$result) {
        echo "Erro na consulta. <br>";
        exit;
    }
    ?>

    <table id="projectTable">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Estabelecimento ID</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['descricao'] . "</td>";
            echo "<td>" . $row['data_inicial'] . "</td>";
            echo "<td>" . $row['data_final'] . "</td>";
            echo "<td>" . $row['estabelecimento_id'] . "</td>";
            echo "<td>
                    <button class='btn-edit' onclick='openEditModal(" . $row['id'] . ", \"" . $row['nome'] . "\", \"" . $row['descricao'] . "\", \"" . $row['data_inicial'] . "\", \"" . $row['data_final'] . "\", \"" . $row['estabelecimento_id'] . "\")'>Editar</button>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='deleteId' value='" . $row['id'] . "'>
                        <button type='submit' class='btn-delete'>Deletar</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Editar Projeto</h2>
        <form method="post">
            <input type="hidden" name="editId" id="editId">
            <label for="editNome">Nome:</label><br>
            <input type="text" id="editNome" name="editNome" required><br>
            <label for="editDescricao">Descrição:</label><br>
            <input type="text" id="editDescricao" name="editDescricao" required><br>
            <label for="editDataInicial">Data Inicial:</label><br>
            <input type="date" id="editDataInicial" name="editDataInicial" required><br>
            <label for="editDataFinal">Data Final:</label><br>
            <input type="date" id="editDataFinal" name="editDataFinal" required><br>
            <label for="editEstabelecimentoId">Estabelecimento ID:</label><br>
            <input type="text" id="editEstabelecimentoId" name="editEstabelecimentoId" required><br><br>
            <button type="submit">Salvar</button>
        </form>
    </div>
</div>

<div id="createModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCreateModal()">&times;</span>
        <h2>Cadastrar Projeto</h2>
        <form method="post">
            <label for="createNome">Nome:</label><br>
            <input type="text" id="createNome" name="createNome" required><br>
            <label for="createDescricao">Descrição:</label><br>
            <input type="text" id="createDescricao" name="createDescricao" required><br>
            <label for="createDataInicial">Data Inicial:</label><br>
            <input type="date" id="createDataInicial" name="createDataInicial" required><br>
            <label for="createDataFinal">Data Final:</label><br>
            <input type="date" id="createDataFinal" name="createDataFinal" required><br>
            <label for="createEstabelecimentoId">Estabelecimento ID:</label><br>
            <input type="text" id="createEstabelecimentoId" name="createEstabelecimentoId" required><br><br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nome, descricao, dataInicial, dataFinal, estabelecimentoId) {
        document.getElementById('editId').value = id;
        document.getElementById('editNome').value = nome;
        document.getElementById('editDescricao').value = descricao;
        document.getElementById('editDataInicial').value = dataInicial;
        document.getElementById('editDataFinal').value = dataFinal;
        document.getElementById('editEstabelecimentoId').value = estabelecimentoId;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openCreateModal() {
        document.getElementById('createModal').style.display = 'block';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }
</script>

</body>
</html>