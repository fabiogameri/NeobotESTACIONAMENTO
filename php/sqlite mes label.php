<?php
require 'conexaodb.php';

$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');

$sql = "UPDATE veiculos
SET 
    mes_numero = CASE
        WHEN strftime('%m', data) = '01' THEN 1
        WHEN strftime('%m', data) = '02' THEN 2
        WHEN strftime('%m', data) = '03' THEN 3
        WHEN strftime('%m', data) = '04' THEN 4
        WHEN strftime('%m', data) = '05' THEN 5
        WHEN strftime('%m', data) = '06' THEN 6
        WHEN strftime('%m', data) = '07' THEN 7
        WHEN strftime('%m', data) = '08' THEN 8
        WHEN strftime('%m', data) = '09' THEN 9
        WHEN strftime('%m', data) = '10' THEN 10
        WHEN strftime('%m', data) = '11' THEN 11
        WHEN strftime('%m', data) = '12' THEN 12
    END,
    mes_nome = CASE
        WHEN strftime('%m', data) = '01' THEN 'Janeiro'
        WHEN strftime('%m', data) = '02' THEN 'Fevereiro'
        WHEN strftime('%m', data) = '03' THEN 'Março'
        WHEN strftime('%m', data) = '04' THEN 'Abril'
        WHEN strftime('%m', data) = '05' THEN 'Maio'
        WHEN strftime('%m', data) = '06' THEN 'Junho'
        WHEN strftime('%m', data) = '07' THEN 'Julho'
        WHEN strftime('%m', data) = '08' THEN 'Agosto'
        WHEN strftime('%m', data) = '09' THEN 'Setembro'
        WHEN strftime('%m', data) = '10' THEN 'Outubro'
        WHEN strftime('%m', data) = '11' THEN 'Novembro'
        WHEN strftime('%m', data) = '12' THEN 'Dezembro'
    END,
    dias_no_mes = CASE
        WHEN strftime('%m', data) = '01' THEN 31
        WHEN strftime('%m', data) = '02' AND (strftime('%Y', data) % 4 = 0 AND (strftime('%Y', data) % 100 != 0 OR strftime('%Y', data) % 400 = 0)) THEN 29
        WHEN strftime('%m', data) = '02' THEN 28
        WHEN strftime('%m', data) = '03' THEN 31
        WHEN strftime('%m', data) = '04' THEN 30
        WHEN strftime('%m', data) = '05' THEN 31
        WHEN strftime('%m', data) = '06' THEN 30
        WHEN strftime('%m', data) = '07' THEN 31
        WHEN strftime('%m', data) = '08' THEN 31
        WHEN strftime('%m', data) = '09' THEN 30
        WHEN strftime('%m', data) = '10' THEN 31
        WHEN strftime('%m', data) = '11' THEN 30
        WHEN strftime('%m', data) = '12' THEN 31
    END";
    
$db->exec($sql);
$db->close();
