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
    <div class="container">
        <h1>Editar e deletar Projetos</h1>
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
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['descricao']}</td>
                        <td>{$row['data_inicial']}</td>
                        <td>{$row['data_final']}</td>
                        <td>{$row['estabelecimento_id']}</td>
                        <td>
                            <button class='btn-edit' onclick='openEditModal({$row['id']}, \"{$row['nome']}\", \"{$row['descricao']}\", \"{$row['data_inicial']}\", \"{$row['data_final']}\", \"{$row['estabelecimento_id']}\")'>Editar</button>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='deleteId' value='{$row['id']}'>
                                <button type='submit' class='btn-delete'>Excluir</button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Editar Projeto</h2>
            <form id="editForm" method="post">
                <input type="hidden" id="editId" name="editId">
                <label for="editNome">Nome:</label>
                <input type="text" id="editNome" name="editNome" required><br><br>
                <label for="editDescricao">Descrição:</label>
                <input type="text" id="editDescricao" name="editDescricao" required><br><br>
                <label for="editDataInicial">Data Inicial:</label>
                <input type="text" id="editDataInicial" name="editDataInicial" required><br><br>
                <label for="editDataFinal">Data Final:</label>
                <input type="text" id="editDataFinal" name="editDataFinal" required><br><br>
                <label for="editEstabelecimentoId">Estabelecimento ID:</label>
                <input type="text" id="editEstabelecimentoId" name="editEstabelecimentoId" required><br><br>
                <input type="submit" value="Atualizar">
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
    </script>
</body>
</html>
