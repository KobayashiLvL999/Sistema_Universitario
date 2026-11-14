<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM turmas WHERE id_turma = :id");
        $stmt->execute([':id' => $id]);
        header("Location: ../views/lista_turmas.php?sucesso=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao excluir turma: " . $e->getMessage());
    }
}