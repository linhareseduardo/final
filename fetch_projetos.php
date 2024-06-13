<?php
$connection = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=projeto', 'postgres', 'root');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['getAllProjects']) && $data['getAllProjects'] === true) {
    $produtoId = $data['produtoId'];
    $sql = "SELECT id, nome FROM projeto 
            WHERE id NOT IN (SELECT projeto_id FROM produto_projeto WHERE produto_id = :produtoId) 
            ORDER BY 1";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':produtoId', $produtoId);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['projects' => $projects]);
} else {
    $produtoId = $data['produtoId'];
    $sql = "SELECT p.id, p.nome FROM projeto p
            INNER JOIN produto_projeto pp ON p.id = pp.projeto_id
            WHERE pp.produto_id = :produtoId ORDER BY 1";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':produtoId', $produtoId);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['projects' => $projects]);
}
?>
