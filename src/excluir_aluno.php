<?php
require_once __DIR__ . '/../config/db.php';

// 1. Pega o ID que veio pelo link
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // 2. Prepara o comando de exclusão
        $sql = "DELETE FROM alunos WHERE id_aluno = :id";
        $stmt = $pdo->prepare($sql);
        
        // 3. Executa a remoção
        $stmt->execute([':id' => $id]);

        // 4. Sucesso! Volta para a lista
        header("Location: ../views/lista_alunos.php?excluido=1");
        exit();

    } catch (PDOException $e) {
        die("Erro ao excluir aluno: " . $e->getMessage());
    }
} else {
    // Se não enviou ID, volta para a lista
    header("Location: ../views/lista_alunos.php");
    exit();
}