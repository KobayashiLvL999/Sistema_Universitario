<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_professor'];
    $nome = $_POST['nome'];
    $formacao = $_POST['formacao'];
    $email = $_POST['email'];
    $senha_plana = $_POST['senha'] ?? '';

    try {
        if (!empty($senha_plana)) {
            $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);
            $sql = "UPDATE professores 
                    SET nome = :nome, formacao = :formacao, email = :email, senha = :senha 
                    WHERE id_professor = :id";
            $params = [
                ':nome' => $nome,
                ':formacao' => $formacao,
                ':email' => $email,
                ':senha' => $senha_hash,
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE professores 
                    SET nome = :nome, formacao = :formacao, email = :email 
                    WHERE id_professor = :id";
            $params = [
                ':nome' => $nome,
                ':formacao' => $formacao,
                ':email' => $email,
                ':id' => $id
            ];
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Se deu tudo certo, volta para a lista com um aviso de sucesso
        header("Location: ../views/lista_professores.php?editado=1");
        exit();

    } catch (PDOException $e) {
        die("Erro ao atualizar o professor: " . $e->getMessage());
    }
} else {
    // Se tentarem acessar o arquivo sem ser pelo formulário, manda de volta
    header("Location: ../views/lista_professores.php");
    exit();
}