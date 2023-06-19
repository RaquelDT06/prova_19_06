<?php

$host = "localhost:3307";
$dbname = "geren_saboroso";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$host; dbname=$dbname;port=3307", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Erro na conexão" . $error->getMessage();
}

// conexão com o banco de dados, api conversando com o sistema 
?>