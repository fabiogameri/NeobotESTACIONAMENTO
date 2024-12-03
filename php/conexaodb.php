<?php
// Abre uma conexão com o banco de dados
$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');

// Verifica se a conexão foi bem-sucedida
if(!$db) {
    echo "Erro na conexão: " . $db->lastErrorMsg();
    exit;
}

// Código para outras operações vai aqui...

// Fechar a conexão
$db->close();
?>