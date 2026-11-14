<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

try {
    // O JOIN conecta as duas tabelas usando o id_curso
    $sql = "SELECT alunos.id_aluno, alunos.nome, alunos.cpf, cursos.nome_curso 
            FROM alunos 
            INNER JOIN cursos ON alunos.id_curso = cursos.id_curso";
    
    $stmt = $pdo->query($sql);
    $listaAlunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar alunos: " . $e->getMessage());
}
?>