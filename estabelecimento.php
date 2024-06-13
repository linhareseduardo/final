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
/* 
        button:hover {
            background-color: #45a049;
        } */

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

    </style>
</head>
<body>

    <div class="container">
        <h1>Editar e deletar Estabelecimentos</h1>
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

        <table id="productTable">
            <tr>
                <th>id</th>
                <th>cnpj</th>
                <th>razaosocial</th>
                <th>nomefantasia</th>
                <th>Actions</th>
            </tr>
       
           <?php 
                foreach($result as $row) {          
                   echo "        
                   <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['cnpj']}</td>
                        <td>{$row['razaosocial']}</td>
                        <td>{$row['nomefantasia']}</td>
                        <td>
                            <button class='btn btn-edit' onclick='openEditModal({$row['id']}, \"{$row['cnpj']}\", \"{$row['razaosocial']}\", \"{$row['nomefantasia']}\")'>Editar</button>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='deleteId' value='{$row['id']}'>
                                <button type='submit' class='btn btn-delete'>Excluir</button>
                            </form>
                        </td>
                   </tr>";   
                }           
            ?>
        </table>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Editar Estabelecimento</h2>
            <form method="post">
                <input type="hidden" name="editId" id="editId">
                <label for="editCnpj">CNPJ:</label>
                <input type="text" name="editCnpj" id="editCnpj" required>
                <label for="editRazaoSocial">Razão Social:</label>
                <input type="text" name="editRazaoSocial" id="editRazaoSocial" required>
                <label for="editNomeFantasia">Nome Fantasia:</label>
                <input type="text" name="editNomeFantasia" id="editNomeFantasia" required>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddModal">&times;</span>
            <h2>Cadastrar Estabelecimento</h2>
            <form method="post">
                <label for="addCnpj">CNPJ:</label>
                <input type="text" name="addCnpj" id="addCnpj" required>
                <label for="addRazaoSocial">Razão Social:</label>
                <input type="text" name="addRazaoSocial" id="addRazaoSocial" required>
                <label for="addNomeFantasia">Nome Fantasia:</label>
                <input type="text" name="addNomeFantasia" id="addNomeFantasia" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <script>
        var editModal = document.getElementById("editModal");
        var closeEditModal = document.getElementById("closeEditModal");
        var openModalBtn = document.getElementById("openModalBtn");
        var addModal = document.getElementById("addModal");
        var closeAddModal = document.getElementById("closeAddModal");

        function openEditModal(id, cnpj, razaosocial, nomefantasia) {
            editModal.style.display = "block";
            document.getElementById("editId").value = id;
            document.getElementById("editCnpj").value = cnpj;
            document.getElementById("editRazaoSocial").value = razaosocial;
            document.getElementById("editNomeFantasia").value = nomefantasia;
        }

        closeEditModal.onclick = function() {
            editModal.style.display = "none";
        }

        openModalBtn.onclick = function() {
            addModal.style.display = "block";
        }

        closeAddModal.onclick = function() {
            addModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
            if (event.target == addModal) {
                addModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
