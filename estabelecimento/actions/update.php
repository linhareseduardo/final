<?php

require_once '../classes/EstabelecimentoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EstabelecimentoController();
    $response = $controller->update($_POST);
    echo $response;
}

?>