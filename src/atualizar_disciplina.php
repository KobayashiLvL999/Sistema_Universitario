<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturando os dados do formulário
    $id = $_POST['id_disciplina'];
    $nome = $_POST['nome'];
    $carga = $_POST['carga'];
    $id_curso = $_POST['id_curso'];
    $id_professor = $_POST['id_professor'];

    try {
        $sql = "UPDATE disciplinas 
                SET nome_disciplina = :n, 
                    carga_horaria = :ca, 
                    id_curso = :ic, 
                    id_professor = :ip 
                WHERE id_disciplina = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':n'  => $nome,
            ':ca' => $carga,
            ':ic' => $id_curso,
            ':ip' => $id_professor,
            ':id' => $id
        ]);

        header("Location: ../views/lista_disciplinas.php?editado=1");
        exit();
    } catch (PDOException $e) { 
        die("Erro ao atualizar disciplina: " . $e->getMessage()); 
    }
}