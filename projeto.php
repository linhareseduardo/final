<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Projetos</title>
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
            margin-bottom: 20px;
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
            display: inline-block;
            position: relative;
        }

        .menu .dropdown:hover .submenu {
            display: block;
        }

        .menu .dropdown a {
            padding: 14px 16px;
        }

        .menu .dropdown .submenu {
            top: 100%;
            left: 0;
            background-color: #333;
        }

        .menu .dropdown .submenu a {
            padding: 12px 16px;
            color: white;
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
            margin-top: 20px;
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

        .btn {
            padding: 8px 16px;
            margin: 4px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .btn-edit {
            background-color: blue;
        }

        .btn-delete {
            background-color: red;
        }

        .btn-create {
            /* background-color: #4CAF50; */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
        }

        /* .btn-create:hover, .btn:hover {
            background-color: #45a049;
        } */

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
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
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

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* button:hover {
            background-color: #45a049;
        } */

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="date"], textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
        }

        .success, .error {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
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
    <h1>Gerenciar Projetos</h1>
    <button class="btn-create" onclick="openCreateModal()">Cadastrar Projeto</button>
    <?php
    try {
        $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
        if ($connection) {
            echo "";
        }
    } catch (PDOException $e) {
        echo "<div class='error'>Erro: " . $e->getMessage() . "</div>";
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
        } else {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $data_inicial = $_POST['data_inicial'];
            $data_final = $_POST['data_final'];
            $estabelecimento_id = $_POST['estabelecimento_id'];

            $stmt = $connection->prepare("INSERT INTO projeto (nome, descricao, data_inicial, data_final, estabelecimento_id) VALUES (:nome, :descricao, :data_inicial, :data_final, :estabelecimento_id)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':data_inicial', $data_inicial);
            $stmt->bindParam(':data_final', $data_final);
            $stmt->bindParam(':estabelecimento_id', $estabelecimento_id);

            if ($stmt->execute()) {
                echo '<script>alert("Projeto cadastrado com sucesso!");</script>';
            } else {
                echo '<script>alert("Erro ao cadastrar o projeto.");</script>';
            }
        }
    }

    $stmt = $connection->query("SELECT * FROM projeto");
    if ($stmt->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Data Inicial</th><th>Data Final</th><th>Estabelecimento ID</th><th>Ações</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_inicial']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_final']) . "</td>";
            echo "<td>" . htmlspecialchars($row['estabelecimento_id']) . "</td>";
            echo "<td class='action-buttons'>";
            echo "<button class='btn btn-edit' onclick='openEditModal(" . json_encode($row) . ")'>Editar</button>";
            echo "<form method='POST' style='display:inline;' onsubmit='return confirm(\"Tem certeza que deseja excluir este projeto?\");'>";
            echo "<input type='hidden' name='deleteId' value='" . htmlspecialchars($row['id']) . "'>";
            echo "<button class='btn btn-delete' type='submit'>Excluir</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum projeto encontrado.</p>";
    }
    ?>
</div>

<div id="createModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCreateModal()">&times;</span>
        <h2>Cadastrar Projeto</h2>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>
            <label for="data_inicial">Data Inicial:</label>
            <input type="date" id="data_inicial" name="data_inicial" required>
            <label for="data_final">Data Final:</label>
            <input type="date" id="data_final" name="data_final" required>
            <label for="estabelecimento_id">Estabelecimento ID:</label>
            <input type="text" id="estabelecimento_id" name="estabelecimento_id" required>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Editar Projeto</h2>
        <form method="POST">
            <input type="hidden" id="editId" name="editId">
            <label for="editNome">Nome:</label>
            <input type="text" id="editNome" name="editNome" required>
            <label for="editDescricao">Descrição:</label>
            <textarea id="editDescricao" name="editDescricao" required></textarea>
            <label for="editDataInicial">Data Inicial:</label>
            <input type="date" id="editDataInicial" name="editDataInicial" required>
            <label for="editDataFinal">Data Final:</label>
            <input type="date" id="editDataFinal" name="editDataFinal" required>
            <label for="editEstabelecimentoId">Estabelecimento ID:</label>
            <input type="text" id="editEstabelecimentoId" name="editEstabelecimentoId" required>
            <input type="submit" value="Salvar">
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').style.display = 'block';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function openEditModal(projeto) {
        document.getElementById('editId').value = projeto.id;
        document.getElementById('editNome').value = projeto.nome;
        document.getElementById('editDescricao').value = projeto.descricao;
        document.getElementById('editDataInicial').value = projeto.data_inicial;
        document.getElementById('editDataFinal').value = projeto.data_final;
        document.getElementById('editEstabelecimentoId').value = projeto.estabelecimento_id;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('createModal')) {
            closeCreateModal();
        }
        if (event.target == document.getElementById('editModal')) {
            closeEditModal();
        }
    }
</script>

</body>
</html>
