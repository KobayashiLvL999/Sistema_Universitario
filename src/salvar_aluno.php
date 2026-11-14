<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Recebendo os dados do formulário
    $nome = $_POST['nome']; 
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha_plana = $_POST['senha'];
    $id_curso = $_POST['id_curso'];
    $semestre_atual = $_POST['semestre_atual']; 

    $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

    try {
        // 2. SQL corrigido para incluir a coluna semestre_atual, email e senha
        $sql = "INSERT INTO alunos (nome, cpf, email, senha, id_curso, semestre_atual) 
                VALUES (:nome, :cpf, :email, :senha, :id_curso, :semestre_atual)";
        
        $stmt = $pdo->prepare($sql);
        
        // 3. Execução com os valores corretos
        $stmt->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':email' => $email,
            ':senha' => $senha_hash,
            ':id_curso' => $id_curso,
            ':semestre_atual' => $semestre_atual
        ]);

        header("Location: ../views/lista_alunos.php?sucesso=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao matricular aluno: " . $e->getMessage());
    }
}