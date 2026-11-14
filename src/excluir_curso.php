<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM cursos WHERE id_curso = :id");
        $stmt->execute([':id' => $id]);
        
        header("Location: ../views/lista_cursos.php?excluido=1");
        exit();
    } catch (PDOException $e) {
        // Erro comum: Curso com alunos ou disciplinas vinculadas
        die("Erro: Não é possível excluir este curso pois existem alunos ou disciplinas matriculados nele.");
    }
}