<?php

require_once '../classes/Database.php';
require_once '../classes/Estabelecimento.php';

class EstabelecimentoController {
    private $estabelecimento;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->estabelecimento = new Estabelecimento($db);
    }

    public function create($data) {
        return $this->estabelecimento->create($data['cnpj'], $data['razaosocial'], $data['nomefantasia']);
    }

    public function read() {
        return $this->estabelecimento->read();
    }

    public function update($data) {
        return $this->estabelecimento->update($data['editId'], $data['editCnpj'], $data['editRazaoSocial'], $data['editNomeFantasia']);
    }

    public function delete($id) {
        return $this->estabelecimento->delete($id);
    }
}

?>
