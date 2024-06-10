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
        <h1>Editar e deletar Estabelecimentos</h1>
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
                            <button class='btn-edit' onclick='openEditModal({$row['id']}, \"{$row['cnpj']}\", \"{$row['razaosocial']}\", \"{$row['nomefantasia']}\")'>Editar</button>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='deleteId' value='{$row['id']}'>
                                <button type='submit' class='btn-delete'>Excluir</button>
                            </form>
                        </td>
                    </tr>
                  ";
               }
          ?>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Estabelecimentos</h2>
            <form id="editForm" method="post">
                <input type="hidden" id="editId" name="editId">
                <label for="editCnpj">CNPJ:</label>
                <input type="text" id="editCnpj" name="editCnpj" required><br><br>
                <label for="editRazaoSocial">Razão Social:</label>
                <input type="text" id="editRazaoSocial" name="editRazaoSocial" required><br><br>
                <label for="editNomeFantasia">Nome Fantasia:</label>
                <input type="text" id="editNomeFantasia" name="editNomeFantasia" required><br><br>
                <input type="submit" value="Atualizar">
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, cnpj, razaoSocial, nomeFantasia) {
            document.getElementById('editId').value = id;
            document.getElementById('editCnpj').value = cnpj;
            document.getElementById('editRazaoSocial').value = razaoSocial;
            document.getElementById('editNomeFantasia').value = nomeFantasia;

            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>
</html>