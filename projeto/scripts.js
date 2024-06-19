document.addEventListener("DOMContentLoaded", () => {
    loadProjects();

    document.getElementById("createForm").addEventListener("submit", (event) => {
        event.preventDefault();
        createProject();
    });

    document.getElementById("editForm").addEventListener("submit", (event) => {
        event.preventDefault();
        updateProject();
    });
});

function loadProjects() {
    fetch('actions/read.php')
        .then(response => response.json())
        .then(data => {
            const projectsTable = document.getElementById('projects-table');
            let html = "<table>";
            html += "<tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Data Inicial</th><th>Data Final</th><th>Estabelecimento ID</th><th>Ações</th></tr>";
            data.forEach(project => {
                html += `<tr>
                    <td>${project.id}</td>
                    <td>${project.nome}</td>
                    <td>${project.descricao}</td>
                    <td>${project.data_inicial}</td>
                    <td>${project.data_final}</td>
                    <td>${project.estabelecimento_id}</td>
                    <td class='action-buttons'>
                        <button class='btn btn-edit' onclick='openEditModal(${JSON.stringify(project)})'>Editar</button>
                        <form method='POST' style='display:inline;' onsubmit='return deleteProject(${project.id})'>
                            <input type='hidden' name='deleteId' value='${project.id}'>
                            <button class='btn btn-delete' type='submit'>Excluir</button>
                        </form>
                    </td>
                </tr>`;
            });
            html += "</table>";
            projectsTable.innerHTML = html;
        })
        .catch(error => console.error('Erro ao carregar projetos:', error));
}

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

function openEditModal(project) {
    document.getElementById('editId').value = project.id;
    document.getElementById('editNome').value = project.nome;
    document.getElementById('editDescricao').value = project.descricao;
    document.getElementById('editDataInicial').value = project.data_inicial;
    document.getElementById('editDataFinal').value = project.data_final;
    document.getElementById('editEstabelecimentoId').value = project.estabelecimento_id;
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function createProject() {
    const formData = new FormData(document.getElementById('createForm'));
    fetch('actions/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        closeCreateModal();
        loadProjects();
    })
    .catch(error => console.error('Erro ao criar projeto:', error));
}

function updateProject() {
    const formData = new FormData(document.getElementById('editForm'));
    fetch('actions/update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        closeEditModal();
        loadProjects();
    })
    .catch(error => console.error('Erro ao atualizar projeto:', error));
}

function deleteProject(id) {
    if (confirm("Tem certeza que deseja excluir este projeto?")) {
        fetch('actions/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `deleteId=${id}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            loadProjects();
        })
        .catch(error => console.error('Erro ao excluir projeto:', error));
    }
    return false;
}

window.onclick = function(event) {
    if (event.target == document.getElementById('createModal')) {
        closeCreateModal();
    }
    if (event.target == document.getElementById('editModal')) {
        closeEditModal();
    }
}
