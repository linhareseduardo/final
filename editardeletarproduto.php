<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listagem de Produtos</title>
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
    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    table th {
        background-color: #f2f2f2;
    }
    .btn {
        padding: 6px 10px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn.edit {
        background-color: #2196F3;
    }
    .btn.delete {
        background-color: #f44336;
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
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        border-radius: 5px;
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
    <h1>Listagem de Produtos</h1>
    <?php
    try {
        $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Editar produto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editId'])) {
            $id = $_POST['editId'];
            $name = $_POST['nome'];
            $description = $_POST['descricao'];
            $status = isset($_POST['status']) ? 1 : 0;

            $sql = "UPDATE produto SET nome = :name, descricao = :description, estado = :status WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

        // Excluir produto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId'])) {
            $id = $_POST['deleteId'];

            $sql = "DELETE FROM produto WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

        // Listagem de produtos
        $sql = "SELECT * FROM produto";
        $stmt = $connection->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($products) > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Status</th><th>Ações</th></tr>';
            foreach ($products as $product) {
                echo '<tr>';
                echo '<td>' . $product['id'] . '</td>';
                echo '<td>' . $product['nome'] . '</td>';
                echo '<td>' . $product['descricao'] . '</td>';
                echo '<td>' . ($product['estado'] ? 'Ativo' : 'Inativo') . '</td>';
                echo '<td>';
                echo '<button class="btn edit" onclick="openEditModal(' . $product['id'] . ', \'' . $product['nome'] . '\', \'' . $product['descricao'] . '\', ' . $product['estado'] . ')">Editar</button>';
                echo '<form method="POST" style="display: inline-block;">';
                echo '<input type="hidden" name="deleteId" value="' . $product['id'] . '">';
                echo '<button type="submit" class="btn delete">Excluir</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Nenhum produto encontrado.</p>';
        }

    } catch (PDOException $e) {
        echo 'Erro de conexão com o banco de dados: ' . $e->getMessage();
    }
    ?>
</div>

<!-- Modal de Edição de Produto -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Editar Produto</h2>
        <form method="POST">
            <input type="hidden" id="editId" name="editId">
            <label for="editName">Nome:</label>
            <input type="text" id="editName" name="nome" maxlength="255" required>
            <label for="editDescription">Descrição:</label>
            <textarea id="editDescription" name="descricao" rows="4" required></textarea>
            <label for="editStatus">Status:</label>
            <input type="checkbox" id="editStatus" name="status" value="1" checked> Ativo
            <br>
            <input type="submit" value="Salvar">
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, description, status) {
        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editStatus').checked = status;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

</body>
</html>
