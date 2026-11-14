<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

try {
    // Busca simples: seleciona tudo da tabela professores
    $sql = "SELECT * FROM professores ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    $professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar professores: " . $e->getMessage());
}
?>