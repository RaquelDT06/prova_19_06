<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type'); // --> permite com que qualquer header consiga acessar o sistema


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM clientes");
    $stmt -> execute();
    $clientes = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($clientes);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    
    $stmt = $conn->prepare("INSERT INTO clientes (nome, sobrenome) VALUES (:nome, :sobrenome)");

    $stmt -> bindParam(':nome', $nome);
    $stmt -> bindParam(':sobrenome', $sobrenome);
  
    if ($stmt->execute()){
        echo "Cliente cadastrado com sucesso";
    } else {
        echo "erro ao cadastrar";
    }

}

//rotas para atualizar clientes

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset ($_GET['id_clientes'])) {
    
    //convertando dados
    parse_str(file_get_contents("php://input"), $_PUT);

    $id_clientes = $_GET['id_clientes'];
    $novoNome = $_PUT['nome'];
    $novoSobrenome = $_PUT['sobrenome'];
    

    $stmt = $conn->prepare("UPDATE clientes SET nome = :nome, sobrenome = :sobrenome WHERE id_clientes = :id_clientes");
    $stmt->bindParam(':nome', $novoNome);
    $stmt->bindParam(':sobrenome', $novoSobrenome);
    $stmt->bindParam(':id_clientes', $id_clientes);

    if ($stmt->execute()) {
        echo "Cliente atualizado com sucesso";
    } else {
        echo "erro ao atualizar :(";
    }

}

//rota para deletar

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id_clientes'])) {
    $id_clientes = $_GET['id_clientes'];
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id_clientes = :id_clientes");
    $stmt->bindParam(':id_clientes', $id_clientes);

    if ($stmt->execute()) {
        echo "Cliente excluido com sucesso";
    } else {
        echo "erro ao excluir :(";
    }
}







?>