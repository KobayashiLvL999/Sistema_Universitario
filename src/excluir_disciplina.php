<?php
require_once __DIR__ . '/../config/db.php';
$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM disciplinas WHERE id_disciplina = :id");
        $stmt->execute([':id' => $id]);
        header("Location: ../views/lista_disciplinas.php?excluido=1");
    } catch (PDOException $e) { die("Erro ao excluir: " . $e->getMessage()); }
}