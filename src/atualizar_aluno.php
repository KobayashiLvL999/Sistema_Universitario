<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_aluno'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha_plana = $_POST['senha'] ?? '';
    $id_curso = $_POST['id_curso'];
    $semestre_atual = $_POST['semestre_atual'];

    try {
        if (!empty($senha_plana)) {
            $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);
            $sql = "UPDATE alunos 
                    SET nome = :nome, 
                        cpf = :cpf, 
                        email = :email,
                        senha = :senha,
                        id_curso = :id_curso, 
                        semestre_atual = :semestre 
                    WHERE id_aluno = :id";
            $params = [
                ':nome' => $nome,
                ':cpf' => $cpf,
                ':email' => $email,
                ':senha' => $senha_hash,
                ':id_curso' => $id_curso,
                ':semestre' => $semestre_atual,
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE alunos 
                    SET nome = :nome, 
                        cpf = :cpf, 
                        email = :email,
                        id_curso = :id_curso, 
                        semestre_atual = :semestre 
                    WHERE id_aluno = :id";
            $params = [
                ':nome' => $nome,
                ':cpf' => $cpf,
                ':email' => $email,
                ':id_curso' => $id_curso,
                ':semestre' => $semestre_atual,
                ':id' => $id
            ];
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        header("Location: ../views/lista_alunos.php?editado=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar aluno: " . $e->getMessage());
    }
}