<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome']; 
    $formacao = $_POST['formacao'];
    $email = $_POST['email'];
    $senha_plana = $_POST['senha'];

    $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO professores (nome, formacao, email, senha) VALUES (:nome, :formacao, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':formacao' => $formacao,
            ':email' => $email,
            ':senha' => $senha_hash
        ]);

        header("Location: ../views/lista_professores.php?sucesso=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao cadastrar professor: " . $e->getMessage());
    }
}