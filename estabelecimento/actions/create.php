<?php

require_once '../classes/EstabelecimentoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EstabelecimentoController();
    $response = $controller->create($_POST);
    echo $response;
}

?>
