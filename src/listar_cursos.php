<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

try {
    // Busca simples na tabela de cursos
    $sql = "SELECT * FROM cursos ORDER BY nome_curso ASC";
    $stmt = $pdo->query($sql);
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar cursos: " . $e->getMessage());
}
?>