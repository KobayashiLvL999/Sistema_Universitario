<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os dados que vêm do 'name' do formulário
    $nome_turma = $_POST['nome_turma'];
    $ano = $_POST['ano'];

    try {
        // Prepare o SQL para a sua tabela 'turmas'
        $sql = "INSERT INTO turmas (nome_turma, ano) VALUES (:nome, :ano)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nome' => $nome_turma,
            ':ano'  => $ano
        ]);

        // Volta para a página de cadastro com status de sucesso
        header("Location: ../views/cadastro_turma.php?status=sucesso");
        exit();
        
    } catch (PDOException $e) {
        echo "Erro ao salvar turma: " . $e->getMessage();
    }
}
?>