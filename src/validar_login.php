<?php
session_start();

// Ajustei para o nome da sua pasta atual no htdocs
$nome_da_pasta = 'Sistema_Escolar'; 

// Agora que está no htdocs, este caminho será lido corretamente pelo XAMPP
$root = $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar';
require_once $root . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    try {
        // 1. Verificar Admin (Login Fixo)
        if ($email == "admin@vencer.edu.br" && $senha == "123456") {
            $_SESSION['usuario_logado'] = "Administrador";
            $_SESSION['usuario_role'] = "admin";
            header("Location: ../views/dashboard.php"); 
            exit();
        }

        // 2. Verificar Professor no Banco de Dados
        $stmt_prof = $pdo->prepare("SELECT * FROM professores WHERE email = :email");
        $stmt_prof->execute([':email' => $email]);
        $professor = $stmt_prof->fetch();

        if ($professor && !empty($professor['senha']) && password_verify($senha, $professor['senha'])) {
            $_SESSION['usuario_logado'] = $professor['nome'];
            $_SESSION['usuario_role'] = "professor";
            $_SESSION['usuario_id'] = $professor['id_professor'];
            header("Location: ../views/dashboard_professor.php");
            exit();
        }

        // 3. Verificar Aluno no Banco de Dados
        $stmt_aluno = $pdo->prepare("SELECT * FROM alunos WHERE email = :email");
        $stmt_aluno->execute([':email' => $email]);
        $aluno = $stmt_aluno->fetch();

        if ($aluno && !empty($aluno['senha']) && password_verify($senha, $aluno['senha'])) {
            $_SESSION['usuario_logado'] = $aluno['nome'];
            $_SESSION['usuario_role'] = "aluno";
            $_SESSION['usuario_id'] = $aluno['id_aluno'];
            $_SESSION['id_curso'] = $aluno['id_curso'];
            header("Location: ../views/dashboard_aluno.php");
            exit();
        }

        // Se falhar tudo
        header("Location: ../index.php?erro=1");
        exit();
    } catch (Exception $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}