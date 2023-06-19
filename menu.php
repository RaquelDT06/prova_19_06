<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type'); // --> permite com que qualquer header consiga acessar o sistema


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM menu");
    $stmt -> execute();
    $menu = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($menu);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_prato = $_POST['nome_prato'];
    $preco_uni = $_POST['preco_uni'];
    $descricao =$_POST['descricao'];
    

    $stmt = $conn->prepare("INSERT INTO menu (nome_prato, preco_uni, descricao) VALUES (:nome_prato, :preco_uni, :descricao)");

    $stmt -> bindParam(':nome_prato', $nome_prato);
    $stmt -> bindParam(':preco_uni', $preco_uni);
    $stmt -> bindParam(':descricao', $descricao);
   

    if ($stmt->execute()){
        echo "menu realizado com sucesso";
    } else {
        echo "erro ao efetuar o menu";
    }

}

//rotas para atualizar o menu

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset ($_GET['id_item'])) {
    
    //convertando dados
    parse_str(file_get_contents("php://input"), $_PUT);

    $id_item = $_GET['id_item'];
    $novoNome_prato = $_PUT['nome_prato'];
    $novoPreco = $_PUT['preco_uni'];
    $novoDescricao = $_PUT['descricao'];
  

    $stmt = $conn->prepare("UPDATE menu SET nome_prato = :nome_prato, preco_uni = :preco_uni, descricao = :descricao WHERE id_item = :id_item");
    $stmt->bindParam(':nome_prato', $novoNome_prato);
    $stmt->bindParam(':preco_uni', $novoPreco);
    $stmt->bindParam(':descricao', $novoDescricao);
    $stmt->bindParam(':id_item', $id_item);

    if ($stmt->execute()) {
        echo "menu atualizado com sucesso";
    } else {
        echo "erro ao atualizar :(";
    }

}

//rota para deletar

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id_item'])) {
    $id_item = $_GET['id_item'];
    $stmt = $conn->prepare("DELETE FROM menu WHERE id_item = :id_item");
    $stmt->bindParam(':id_item', $id_item);

    if ($stmt->execute()) {
        echo "item excluido com sucesso";
    } else {
        echo "erro ao excluir :(";
    }
}







?>