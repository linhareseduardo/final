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

.btn.edit {
    background-color: blue;
}

.btn.delete {
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

#projectList div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

#projectList div span {
    flex: 1;
}

#projectList div form {
    margin: 0;
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
    <h1>Gerenciar Produtos</h1>

    <button class="btn" onclick="openAddModal()">Cadastrar Produto</button>

    <?php
    $connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['editId'])) {
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
        } elseif (isset($_POST['deleteId'])) {
            $id = $_POST['deleteId'];

            $sql = "DELETE FROM produto WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } elseif (isset($_POST['deleteAssociation'])) {
            $produtoId = $_POST['produtoId'];
            $projetoId = $_POST['deleteAssociation'];

            $sql = "DELETE FROM produto_projeto WHERE produto_id = :produtoId AND projeto_id = :projetoId";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':produtoId', $produtoId);
            $stmt->bindParam(':projetoId', $projetoId);
            $stmt->execute();
        } elseif (isset($_POST['projetoId']) && isset($_POST['produtoId'])) {
            $produtoId = $_POST['produtoId'];
            $projetoId = $_POST['projetoId'];

            $sql = "INSERT INTO produto_projeto (produto_id, projeto_id) VALUES (:produtoId, :projetoId)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':produtoId', $produtoId);
            $stmt->bindParam(':projetoId', $projetoId);
            $stmt->execute();
        } elseif (isset($_POST['nome']) && isset($_POST['descricao'])) {
            $name = $_POST['nome'];
            $description = $_POST['descricao'];
            $status = isset($_POST['status']) ? 1 : 0;

            $sql = "INSERT INTO produto (nome, descricao, estado) VALUES (:name, :description, :status)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }
    }

    $sql = "SELECT * FROM produto ORDER BY 1";
    $stmt = $connection->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($products) > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Estado</th><th>Ações</th></tr>';
        foreach ($products as $product) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($product['id']) . '</td>';
            echo '<td>' . htmlspecialchars($product['nome']) . '</td>';
            echo '<td>' . htmlspecialchars($product['descricao']) . '</td>';
            echo '<td>' . ($product['estado'] ? 'Ativo' : 'Inativo') . '</td>';
            echo '<td>';
            echo '<button class="btn edit" onclick="openEditModal(' . $product['id'] . ', \'' . htmlspecialchars($product['nome']) . '\', \'' . htmlspecialchars($product['descricao']) . '\', ' . $product['estado'] . ')">Editar</button>';
            echo '<button class="btn delete" onclick="openDeleteModal(' . $product['id'] . ')">Excluir</button>';
            echo '<button class="btn view" onclick="openViewModal(' . $product['id'] . ')">Visualizar Projetos</button>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Nenhum produto encontrado.</p>';
    }
    ?>
</div>

<!-- Modal de edição -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Editar Produto</h2>
        <form method="POST" action="">
            <input type="hidden" id="editId" name="editId">
            <label for="editName">Nome:</label>
            <input type="text" id="editName" name="nome" required>
            <label for="editDescription">Descrição:</label>
            <textarea id="editDescription" name="descricao" required></textarea>
            <label for="editStatus">Ativo:</label>
            <input type="checkbox" id="editStatus" name="status">
            <input type="submit" value="Salvar">
        </form>
    </div>
</div>

<!-- Modal de deleção -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Deletar Produto</h2>
        <form method="POST" action="">
            <input type="hidden" id="deleteId" name="deleteId">
            <p>Tem certeza que deseja deletar este produto?</p>
            <input type="submit" value="Sim, deletar">
            <button type="button" onclick="closeDeleteModal()">Cancelar</button>
        </form>
    </div>
</div>

<!-- Modal de visualização de projetos -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeViewModal()">&times;</span>
        <h2>Projetos Associados</h2>
        <div id="projectList">
            <!-- Projetos associados serão carregados aqui -->
        </div>
        <button class="btn" onclick="openAssociateModal(document.getElementById('produtoId').value)">Associar Novo Projeto</button>
    </div>
</div>

<!-- Modal de associação de projeto -->
<div id="associateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAssociateModal()">&times;</span>
        <h2>Associar Projeto ao Produto</h2>
        <form method="POST" action="">
            <input type="hidden" id="produtoId" name="produtoId">
            <label for="projetoId">Projeto:</label>
            <select id="projetoId" name="projetoId" required></select>
            <input type="submit" value="Associar">
        </form>
    </div>
</div>

<!-- Modal de cadastro de produto -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2>Cadastrar Produto</h2>
        <form method="POST" action="">
            <label for="addName">Nome:</label>
            <input type="text" id="addName" name="nome" required>
            <label for="addDescription">Descrição:</label>
            <textarea id="addDescription" name="descricao" required></textarea>
            <label for="addStatus">Ativo:</label>
            <input type="checkbox" id="addStatus" name="status">
            <input type="submit" value="Cadastrar">
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

function openDeleteModal(id) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function openViewModal(produtoId) {
    fetch('fetch_projetos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ getAllProjects: false, produtoId: produtoId })
    })
    .then(response => response.json())
    .then(data => {
        let projectList = document.getElementById('projectList');
        projectList.innerHTML = '';
        data.projects.forEach(project => {
            let projectDiv = document.createElement('div');
            projectDiv.innerHTML = `
                <p>${project.nome}</p>
                <form method="POST" action="">
                    <input type="hidden" name="produtoId" value="${produtoId}">
                    <button type="submit" class="btn delete" name="deleteAssociation" value="${project.id}">Remover Associação</button>
                </form>
            `;
            projectList.appendChild(projectDiv);
        });
        document.getElementById('produtoId').value = produtoId;
        document.getElementById('viewModal').style.display = 'block';
    });
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}

function openAssociateModal(produtoId) {
    fetch('fetch_projetos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ getAllProjects: true, produtoId: produtoId })
    })
    .then(response => response.json())
    .then(data => {
        let select = document.getElementById('projetoId');
        select.innerHTML = '';
        data.projects.forEach(project => {
            let option = document.createElement('option');
            option.value = project.id;
            option.text = project.nome;
            select.appendChild(option);
        });
        document.getElementById('produtoId').value = produtoId;
        document.getElementById('associateModal').style.display = 'block';
    });
}

function closeAssociateModal() {
    document.getElementById('associateModal').style.display = 'none';
}

function openAddModal() {
    document.getElementById('addModal').style.display = 'block';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

window.onclick = function(event) {
    var addModal = document.getElementById('addModal');
    var editModal = document.getElementById('editModal');
    var deleteModal = document.getElementById('deleteModal');
    var viewModal = document.getElementById('viewModal');
    var associateModal = document.getElementById('associateModal');
    if (event.target === addModal) {
        addModal.style.display = 'none';
    }
    if (event.target === editModal) {
        editModal.style.display = 'none';
    }
    if (event.target === deleteModal) {
        deleteModal.style.display = 'none';
    }
    if (event.target === viewModal) {
        viewModal.style.display = 'none';
    }
    if (event.target === associateModal) {
        associateModal.style.display = 'none';
    }
}
</script>

</body>
</html>
