<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Pegamos os dados usando os nomes CORRETOS do formulário
    $nome_turma = $_POST['nome_turma'];
    $semestre_ano = $_POST['semestre_ano']; // Mudamos de "ano" para "semestre_ano"
    $id_disciplina = $_POST['id_disciplina'];
    $id_professor = $_POST['id_professor'];

    try {
        // 2. O SQL também deve usar o nome da coluna que está no Banco de Dados
        $sql = "INSERT INTO turmas (nome_turma, semestre_ano, id_disciplina, id_professor) 
                VALUES (:nome, :semestre, :id_disc, :id_prof)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nome'     => $nome_turma,
            ':semestre' => $semestre_ano,
            ':id_disc'  => $id_disciplina,
            ':id_prof'  => $id_professor
        ]);

        // 3. Redireciona de volta para a lista com sucesso
        header("Location: ../views/lista_turmas.php?sucesso=1");
        exit();

    } catch (PDOException $e) {
        die("Erro ao salvar turma: " . $e->getMessage());
    }
} else {
    header("Location: ../views/lista_turmas.php");
    exit();
}