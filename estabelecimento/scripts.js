document.addEventListener("DOMContentLoaded", () => {
    loadEstabelecimentos();

    document.getElementById("createForm").addEventListener("submit", (event) => {
        event.preventDefault();
        createEstabelecimento();
    });

    document.getElementById("editForm").addEventListener("submit", (event) => {
        event.preventDefault();
        updateEstabelecimento();
    });
});

function loadEstabelecimentos() {
    fetch('actions/read.php')
        .then(response => response.json())
        .then(data => {
            const estabelecimentosTable = document.getElementById('estabelecimentos-table');
            let html = "<table>";
            html += "<tr><th>ID</th><th>Cnpj</th><th>Razão Social</th><th>Nome Fantasia</th><th>Ações</th></tr>";
            data.forEach(estabelecimento => {
                html += `<tr>
                    <td>${estabelecimento.id}</td>
                    <td>${estabelecimento.cnpj}</td>
                    <td>${estabelecimento.razaosocial}</td>
                    <td>${estabelecimento.nomefantasia}</td>
                    <td class='action-buttons'>
                        <button class='btn btn-edit' onclick='openEditModal(${JSON.stringify(estabelecimento)})'>Editar</button>
                        <form method='POST' style='display:inline;' onsubmit='return deleteEstabelecimento(${estabelecimento.id})'>
                            <input type='hidden' name='deleteId' value='${estabelecimento.id}'>
                            <button class='btn btn-delete' type='submit'>Excluir</button>
                        </form>
                    </td>
                </tr>`;
            });
            html += "</table>";
            estabelecimentosTable.innerHTML = html;
        })
        .catch(error => console.error('Erro ao carregar Estabelecimentos:', error));
}

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

function openEditModal(estabelecimento) {
    document.getElementById('editId').value = estabelecimento.id;
    document.getElementById('editCnpj').value = estabelecimento.cnpj;
    document.getElementById('editRazaoSocial').value = estabelecimento.razaosocial;
    document.getElementById('editNomeFantasia').value = estabelecimento.nomefantasia;
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function createEstabelecimento() {
    const formData = new FormData(document.getElementById('createForm'));
    fetch('actions/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        closeCreateModal();
        loadEstabelecimentos();
    })
    .catch(error => console.error('Erro ao criar projeto:', error));
}

function updateEstabelecimento() {
    const formData = new FormData(document.getElementById('editForm'));
    fetch('actions/update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        closeEditModal();
        loadEstabelecimentos();
    })
    .catch(error => console.error('Erro ao atualizar projeto:', error));
}

function deleteEstabelecimento(id) {
    if (confirm("Tem certeza que deseja excluir este estabelecimento?")) {
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
            loadEstabelecimentos();
        })
        .catch(error => console.error('Erro ao excluir o estabelecimento:', error));
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
