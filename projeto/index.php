<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Projetos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- <div class="menu">
        <a href="estabelecimento.php">Estabelecimento</a>
        <a href="produto.php">Produto</a>
        <a href="projeto.php">Projeto</a>
    </div> -->
    <?php include 'menu.php'; ?>
    

    <div class="container">
        <h1>Gerenciar Projetos</h1>
        <button class="btn-create" onclick="openCreateModal()">Cadastrar Projeto</button>
        <div id="projects-table">
            <!-- Conteúdo gerado dinamicamente via JavaScript -->
        </div>
    </div>

    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <h2>Cadastrar Projeto</h2>
            <form id="createForm">
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
            <form id="editForm">
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

    <script src="scripts.js"></script>
</body>
</html>
