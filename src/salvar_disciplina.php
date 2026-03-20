<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_disciplina = $_POST['nome_disciplina'];
    $professor = $_POST['professor']; // Pegando o nome do professor do formulário
    $carga_horaria = $_POST['carga_horaria'];

    try {
        // SQL ajustado para incluir o professor_nome
        $sql = "INSERT INTO disciplinas (nome_disciplina, carga_horaria, professor_nome) 
                VALUES (:nome, :carga, :prof)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nome'  => $nome_disciplina,
            ':carga' => $carga_horaria,
            ':prof'  => $professor
        ]);

        header("Location: ../views/cadastro_disciplina.php?status=sucesso");
        exit();
        
    } catch (PDOException $e) {
        echo "Erro ao salvar disciplina: " . $e->getMessage();
    }
}
?>