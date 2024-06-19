<?php

require_once '../classes/Database.php';
require_once '../classes/Projeto.php';

class ProjetoController {
    private $projeto;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->projeto = new Projeto($db);
    }

    public function create($data) {
        return $this->projeto->create($data['nome'], $data['descricao'], $data['data_inicial'], $data['data_final'], $data['estabelecimento_id']);
    }

    public function read() {
        return $this->projeto->read();
    }

    public function update($data) {
        return $this->projeto->update($data['editId'], $data['editNome'], $data['editDescricao'], $data['editDataInicial'], $data['editDataFinal'], $data['editEstabelecimentoId']);
    }

    public function delete($id) {
        return $this->projeto->delete($id);
    }
}

?>
