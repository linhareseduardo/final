<?php

require_once '../classes/EstabelecimentoController.php';

$controller = new EstabelecimentoController();
$response = $controller->read();
echo json_encode($response);

?>
