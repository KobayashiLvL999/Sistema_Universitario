<?php
// 1. Inclui a conexão com o banco de dados
require_once '../config/db.php';

// 2. Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 3. Coleta os dados do formulário
    $nome = $_POST['nome'];
    $data_nasc = $_POST['data_nasc'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $id_turma = $_POST['id_turma']; // Certifique-se que o <select> no HTML tenha esse name

    try {
        // 4. Prepara o comando SQL (usando Prepared Statements para segurança)
        $sql = "INSERT INTO alunos (nome, data_nascimento, cpf, email, id_turma) 
                VALUES (:nome, :data_nasc, :cpf, :email, :id_turma)";
        
        $stmt = $pdo->prepare($sql);

        // 5. Vincula os valores e executa
        $stmt->execute([
            ':nome' => $nome,
            ':data_nasc' => $data_nasc,
            ':cpf' => $cpf,
            ':email' => $email,
            ':id_turma' => $id_turma
        ]);

        // 6. Redireciona de volta com uma mensagem de sucesso
        header("Location: ../views/lista_alunos.php?status=sucesso");
        exit();

    } catch (PDOException $e) {
        // Caso dê erro (ex: CPF duplicado)
        echo "Erro ao salvar: " . $e->getMessage();
    }
}
?>