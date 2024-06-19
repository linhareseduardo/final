<?php

require_once '../classes/ProjetoController.php';

$controller = new ProjetoController();
$response = $controller->read();
echo json_encode($response);

?>
