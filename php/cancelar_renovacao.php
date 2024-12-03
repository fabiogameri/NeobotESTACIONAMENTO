<?php
require 'conexaodb.php';

$id = $_POST['id'];

$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');
$sql = "UPDATE veiculos SET pago = 0, data_renovacao = NULL WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$stmt->execute();
$db->close();

header("Location: listarveiculos.php");
exit;
?>
