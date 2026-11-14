<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_curso'];
    $nome = $_POST['nome_curso'];
    $duracao = $_POST['duracao'];

    try {
        $sql = "UPDATE cursos SET nome_curso = :nome, duracao_semestres = :duracao WHERE id_curso = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':duracao' => $duracao,
            ':id' => $id
        ]);

        header("Location: ../views/lista_cursos.php?sucesso=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar curso: " . $e->getMessage());
    }
}