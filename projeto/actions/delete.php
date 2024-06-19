<?php

require_once '../classes/ProjetoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProjetoController();
    $response = $controller->delete($_POST['deleteId']);
    echo $response;
}

?>
