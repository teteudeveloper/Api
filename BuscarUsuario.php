<?php
global $pdo;
require 'Conexao.php';

$email = $_POST['id'] ?? null;

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Id é obrigatório.']);
    exit;
}

try {
    $sql = "SELECT id, email, criado_em FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo json_encode(['success' => true, 'data' => $usuario]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao buscar o usuário: ' . $e->getMessage()]);
}