<?php
require_once '../config/db.php';

// Verifica se recebeu o ID e a Tabela pela URL
if (isset($_GET['id']) && isset($_GET['tabela'])) {
    $id = $_GET['id'];
    $tabela = $_GET['tabela'];
    $coluna_id = "";

    // Define qual é o nome da coluna ID baseada na tabela
    // Isso deve bater exatamente com o seu banco no Workbench
    if ($tabela == 'alunos') { $coluna_id = 'id_aluno'; }
    elseif ($tabela == 'turmas') { $coluna_id = 'id_turma'; }
    elseif ($tabela == 'disciplinas') { $coluna_id = 'id_disciplina'; }

    try {
        $sql = "DELETE FROM $tabela WHERE $coluna_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Redireciona de volta para a lista de onde viemos
        header("Location: ../views/lista_$tabela.php?status=excluido");
        exit();
        
    } catch (PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
    }
}