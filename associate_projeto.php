<?php
$connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$produtoId = $data['produtoId'];
$projetoId = $data['projetoId'];

$sql = "INSERT INTO produto_projeto (produto_id, projeto_id) VALUES (:produtoId, :projetoId)";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':produtoId', $produtoId);
$stmt->bindParam(':projetoId', $projetoId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
