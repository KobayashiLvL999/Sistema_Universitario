<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_disciplina'];
    $carga = $_POST['carga_horaria'];
    $id_curso = $_POST['id_curso'];
    $id_professor = $_POST['id_professor'];

    try {
        $sql = "INSERT INTO disciplinas (nome_disciplina, carga_horaria, id_curso, id_professor) 
                VALUES (:nome, :carga, :id_curso, :id_professor)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':carga' => $carga,
            ':id_curso' => $id_curso,
            ':id_professor' => $id_professor
        ]);

        header("Location: ../views/dashboard.php?sucesso_disc=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao criar disciplina: " . $e->getMessage());
    }
}