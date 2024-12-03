<?php
require 'conexaodb.php';

$pessoa = $_POST['pessoa'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$ano = $_POST['ano'];
$cor = $_POST['cor'];
$dia = $_POST['dia'];
$mes = $_POST['mes']; // Coleta o mês fornecido pelo usuário

$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');
$sql = "INSERT INTO veiculos (pessoa, marca, modelo, ano, cor, dia, mes)
        VALUES (:pessoa, :marca, :modelo, :ano, :cor, :dia, :mes)";
$stmt = $db->prepare($sql);
$stmt->bindValue(':pessoa', $pessoa, SQLITE3_TEXT);
$stmt->bindValue(':marca', $marca, SQLITE3_TEXT);
$stmt->bindValue(':modelo', $modelo, SQLITE3_TEXT);
$stmt->bindValue(':ano', $ano, SQLITE3_INTEGER);
$stmt->bindValue(':cor', $cor, SQLITE3_TEXT);
$stmt->bindValue(':dia', $dia, SQLITE3_INTEGER);
$stmt->bindValue(':mes', $mes, SQLITE3_INTEGER); // Adiciona o mês na tabela
$stmt->execute();
$db->close();

header("Location: listarveiculos.php");
exit;
?>
