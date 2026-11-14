<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_role'] !== 'professor') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_turma = $_POST['id_turma'] ?? null;
    $id_disciplina = $_POST['id_disciplina'] ?? null;
    $id_curso = $_POST['id_curso'] ?? null;
    $boletim_data = $_POST['boletim'] ?? [];

    if (!$id_turma || !$id_disciplina || !$id_curso) {
        header("Location: ../views/dashboard_professor.php");
        exit();
    }

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO boletim (id_aluno, id_disciplina, id_turma, nota1, nota2, media, faltas)
                VALUES (:id_aluno, :id_disciplina, :id_turma, :nota1, :nota2, :media, :faltas)
                ON DUPLICATE KEY UPDATE
                    nota1 = VALUES(nota1),
                    nota2 = VALUES(nota2),
                    media = VALUES(media),
                    faltas = VALUES(faltas)";
        $stmt = $pdo->prepare($sql);

        foreach ($boletim_data as $id_aluno => $data) {
            $nota1 = $data['nota1'] !== '' ? (float)$data['nota1'] : null;
            $nota2 = $data['nota2'] !== '' ? (float)$data['nota2'] : null;
            $faltas = $data['faltas'] !== '' ? (int)$data['faltas'] : 0;

            // Calcular média se ambas as notas estiverem lançadas
            $media = null;
            if ($nota1 !== null && $nota2 !== null) {
                $media = ($nota1 + $nota2) / 2.0;
            }

            $stmt->execute([
                ':id_aluno' => $id_aluno,
                ':id_disciplina' => $id_disciplina,
                ':id_turma' => $id_turma,
                ':nota1' => $nota1,
                ':nota2' => $nota2,
                ':media' => $media,
                ':faltas' => $faltas
            ]);
        }

        $pdo->commit();
        header("Location: ../views/turma_alunos.php?id_turma=$id_turma&id_disciplina=$id_disciplina&id_curso=$id_curso&salvo=1");
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Erro ao salvar dados acadêmicos: " . $e->getMessage());
    }
} else {
    header("Location: ../views/dashboard_professor.php");
    exit();
}
