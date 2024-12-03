<?php
require 'conexaodb.php';

$id = $_POST['id'];
$dataRenovacao = date('d-m-Y'); // Data atual

$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');
$sql = "UPDATE veiculos SET pago = 1, data_renovacao = :dataRenovacao WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$stmt->bindValue(':dataRenovacao', $dataRenovacao, SQLITE3_TEXT);

// Verificar se a execução foi bem-sucedida
if ($stmt->execute()) {
    echo "Renovação realizada com sucesso!";
} else {
    echo "Erro na renovação.";
}

$db->close();

// Redirecionar para a página de listagem
header("Location: listarveiculos.php");
exit;
?>