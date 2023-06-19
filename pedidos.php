<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type'); // --> permite com que qualquer header consiga acessar o sistema


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM pedidos");
    $stmt -> execute();
    $pedidos = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($pedidos);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_prato = $_POST['nome_prato'];
    $cliente = $_POST['cliente'];
    $quantidade =$_POST['quantidade'];
    $preco =$_POST['preco'];

    $stmt = $conn->prepare("INSERT INTO pedidos (nome_prato, cliente, quantidade, preco ) VALUES (:nome_prato, :cliente, :quantidade, :preco)");

    $stmt -> bindParam(':nome_prato', $nome_prato);
    $stmt -> bindParam(':cliente', $cliente);
    $stmt -> bindParam(':quantidade', $quantidade);
    $stmt -> bindParam(':preco', $preco);

    if ($stmt->execute()){
        echo "Pedido realizado com sucesso";
    } else {
        echo "erro ao efetuar o pedido";
    }

}

//rotas para atualizar pedidos

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset ($_GET['id_pedidos'])) {
    
    //convertando dados
    parse_str(file_get_contents("php://input"), $_PUT);

    $id_pedidos = $_GET['id_pedidos'];
    $novoNome_prato = $_PUT['nome_prato'];
    $novoCliente = $_PUT['cliente'];
    $novoQuantidade = $_PUT['quantidade'];
    $novoPreco = $_PUT['preco'];

    $stmt = $conn->prepare("UPDATE pedidos SET nome_prato = :nome_prato, cliente = :cliente, quantidade = :quantidade, preco = :preco WHERE id_pedidos = :id_pedidos");
    $stmt->bindParam(':nome_prato', $novoNome_prato);
    $stmt->bindParam(':cliente', $novoCliente);
    $stmt->bindParam(':quantidade', $novoQuantidade);
    $stmt->bindParam(':preco', $novoPreco);
    $stmt->bindParam(':id_pedidos', $id_pedidos);

    if ($stmt->execute()) {
        echo "Pedido atualizado com sucesso";
    } else {
        echo "erro ao atualizar :(";
    }

}

//rota para deletar

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id_pedidos'])) {
    $id_pedidos = $_GET['id_pedidos'];
    $stmt = $conn->prepare("DELETE FROM pedidos WHERE id_pedidos = :id_pedidos");
    $stmt->bindParam(':id_pedidos', $id_pedidos);

    if ($stmt->execute()) {
        echo "Pedido excluido com sucesso";
    } else {
        echo "erro ao excluir :(";
    }
}







?>