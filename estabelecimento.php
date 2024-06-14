<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            padding: 8px 16px;
            text-decoration: none;
            background-color: #f2f2f2;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .menu .dropdown .submenu {
            top: 100%;
            left: 0;
            background-color: #f9f9f9;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .menu .dropdown .submenu a {
            padding: 8px 16px;
            color: #333;
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

        .btn.view {
            background-color: #FFA500;
        }

        .btn-create {
            background-color: #4CAF50;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
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

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], form textarea {
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

        .menu {
            background-color: #333;
            overflow: hidden;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .menu a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .menu a:hover {
            background-color: #ddd;
            color: black;
        }

    </style>
</head>
<body>

    <div class="menu">
        <a href="estabelecimento.php">Estabelecimento</a>
        <a href="produto.php">Produto</a>
        <a href="projeto.php">Projeto</a>
    </div>
     

    <div class="container">
        <h1>Gerenciar Estabelecimentos</h1>
        <button id="openModalBtn">Cadastrar Estabelecimento</button>
        <?php
        try {
            $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
            if ($connection) {
                echo "";
            }
        } catch (PDOException $e) {
            // report error message
            echo $e->getMessage();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteId'])) {
                $deleteId = $_POST['deleteId'];
                $deleteStmt = $connection->prepare("DELETE FROM estabelecimento WHERE id = :id");
                $deleteStmt->bindParam(':id', $deleteId);
                if ($deleteStmt->execute()) {
                    echo '<script>alert("Produto excluído com sucesso!");</script>';
                } else {
                    echo '<script>alert("Erro ao excluir o produto.");</script>';
                }
            } else if (isset($_POST['editId'])) {
                $editId = $_POST['editId'];
                $editCnpj = $_POST['editCnpj'];
                $editRazaoSocial = $_POST['editRazaoSocial'];
                $editNomeFantasia = $_POST['editNomeFantasia'];

                $editStmt = $connection->prepare("UPDATE estabelecimento SET cnpj = :cnpj, razaosocial = :razaoSocial, nomefantasia = :nomeFantasia WHERE id = :id");
                $editStmt->bindParam(':id', $editId);
                $editStmt->bindParam(':cnpj', $editCnpj);
                $editStmt->bindParam(':razaoSocial', $editRazaoSocial);
                $editStmt->bindParam(':nomeFantasia', $editNomeFantasia);

                if ($editStmt->execute()) {
                    echo '<script>alert("Produto atualizado com sucesso!");</script>';
                } else {
                    echo '<script>alert("Erro ao atualizar o produto.");</script>';
                }
            } else if (isset($_POST['addCnpj'])) {
                $addCnpj = $_POST['addCnpj'];
                $addRazaoSocial = $_POST['addRazaoSocial'];
                $addNomeFantasia = $_POST['addNomeFantasia'];

                $addStmt = $connection->prepare("INSERT INTO estabelecimento (cnpj, razaosocial, nomefantasia) VALUES (:cnpj, :razaoSocial, :nomeFantasia)");
                $addStmt->bindParam(':cnpj', $addCnpj);
                $addStmt->bindParam(':razaoSocial', $addRazaoSocial);
                $addStmt->bindParam(':nomeFantasia', $addNomeFantasia);

                if ($addStmt->execute()) {
                    echo '<script>alert("Estabelecimento cadastrado com sucesso!");</script>';
                } else {
                    echo '<script>alert("Erro ao cadastrar o estabelecimento.");</script>';
                }
            }
        }

        $result = $connection->query("SELECT * FROM estabelecimento order by id");
        if (!$result) {
            echo "Erro na consulta. <br>";
            exit;
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CNPJ</th>
                    <th>Razão Social</th>
                    <th>Nome Fantasia</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['cnpj']; ?></td>
                        <td><?php echo $row['razaosocial']; ?></td>
                        <td><?php echo $row['nomefantasia']; ?></td>
                        <td class="btn-container">
                        <button class="btn btn-edit" onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo $row['cnpj']; ?>', '<?php echo $row['razaosocial']; ?>', '<?php echo $row['nomefantasia']; ?>')">Editar</button>
                            <form method="post" style="display: inline-block;">
                                <input type="hidden" name="deleteId" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-delete">Excluir</button>
                            </form>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="modalForm" method="post">
                <input type="hidden" id="editId" name="editId">
                <label for="editCnpj">CNPJ:</label>
                <input type="text" id="editCnpj" name="editCnpj" required>
                <label for="editRazaoSocial">Razão Social:</label>
                <input type="text" id="editRazaoSocial" name="editRazaoSocial" required>
                <label for="editNomeFantasia">Nome Fantasia:</label>
                <input type="text" id="editNomeFantasia" name="editNomeFantasia" required>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="addForm" method="post">
                <label for="addCnpj">CNPJ:</label>
                <input type="text" id="addCnpj" name="addCnpj" required>
                <label for="addRazaoSocial">Razão Social:</label>
                <input type="text" id="addRazaoSocial" name="addRazaoSocial" required>
                <label for="addNomeFantasia">Nome Fantasia:</label>
                <input type="text" id="addNomeFantasia" name="addNomeFantasia" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, cnpj, razaoSocial, nomeFantasia) {
            document.getElementById('editId').value = id;
            document.getElementById('editCnpj').value = cnpj;
            document.getElementById('editRazaoSocial').value = razaoSocial;
            document.getElementById('editNomeFantasia').value = nomeFantasia;
            document.getElementById('modal').style.display = 'block';
        }

        document.getElementById('openModalBtn').onclick = function () {
            document.getElementById('addModal').style.display = 'block';
        };

        document.querySelectorAll('.close').forEach(function (closeBtn) {
            closeBtn.onclick = function () {
                closeBtn.parentElement.parentElement.style.display = 'none';
            };
        });

        window.onclick = function (event) {
            if (event.target == document.getElementById('modal')) {
                document.getElementById('modal').style.display = 'none';
            } else if (event.target == document.getElementById('addModal')) {
                document.getElementById('addModal').style.display = 'none';
            }
        };
    </script>
</body>
</html>
