<?php
// 1. Conecta ao banco de dados usando o caminho do seu notebook
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Coleta os dados que vieram do formulário de cadastro
    $nome = $_POST['nome_curso'] ?? '';
    $duracao = $_POST['duracao'] ?? '';

    try {
        // 3. Prepara o comando para gravar na tabela 'cursos' que você criou no Workbench
        $sql = "INSERT INTO cursos (nome_curso, duracao_semestres) VALUES (:nome, :duracao)";
        $stmt = $pdo->prepare($sql);
        
        // 4. Executa a gravação
        $stmt->execute([
            ':nome' => $nome,
            ':duracao' => $duracao
        ]);

        // 5. Missão cumprida! Volta para o Dashboard para ver o número 1
        header("Location: ../views/dashboard.php?sucesso=1");
        exit();

    } catch (PDOException $e) {
        // Caso aconteça algum erro (como nome de tabela errado), ele avisa aqui
        die("Erro ao salvar curso no banco universitário: " . $e->getMessage());
    }
} else {
    // Se alguém tentar acessar esse arquivo direto pelo navegador, manda de volta
    header("Location: ../views/dashboard.php");
    exit();
}