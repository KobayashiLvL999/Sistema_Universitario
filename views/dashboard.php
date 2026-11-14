<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consultas para os contadores do Dashboard
    $totalCursos = $pdo->query("SELECT COUNT(*) FROM cursos")->fetchColumn();
    $totalAlunos = $pdo->query("SELECT COUNT(*) FROM alunos")->fetchColumn();
    $totalProfessores = $pdo->query("SELECT COUNT(*) FROM professores")->fetchColumn();
    $totalDisciplinas = $pdo->query("SELECT COUNT(*) FROM disciplinas")->fetchColumn();
    // Nova contagem para as Turmas
    $totalTurmas = $pdo->query("SELECT COUNT(*) FROM turmas")->fetchColumn();
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculdade Vencer - Dashboard</title>
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>

<header>
    <h1>Faculdade Vencer - Sistema Acadêmico</h1>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 14px;">Olá, <strong><?php echo $_SESSION['usuario_logado']; ?></strong></span>
        <a href="../src/logout.php" id="logoutBtn" style="text-decoration:none; background-color: #ff9900; padding: 8px 15px; border-radius: 5px; color: #fff; font-weight: bold;">Sair</a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="lista_alunos.php">Alunos</a></li>
        <li><a href="lista_professores.php">Professores</a></li>
        <li><a href="lista_cursos.php">Cursos</a></li>
        <li><a href="lista_disciplinas.php">Disciplinas</a></li>
        <li><a href="lista_turmas.php" style="background-color: rgba(255,255,255,0.1); border-radius: 5px;">Turmas</a></li>
    </ul>
</nav>

<main>
    <p style="margin-bottom: 20px;">Bem-vindo ao painel administrativo, <strong><?php echo $_SESSION['usuario_logado']; ?></strong>!</p>
    
    <section class="stats">
        <div class="card">
            <h3>Total de Alunos</h3>
            <p><?php echo $totalAlunos; ?></p>
            <a href="cadastro_aluno.php" style="color: #0055a5; font-size: 14px; text-decoration: none; font-weight: bold;">+ Novo Aluno</a>
        </div>

        <div class="card">
            <h3>Professores</h3>
            <p><?php echo $totalProfessores; ?></p>
            <a href="cadastro_professor.php" style="color: #0055a5; font-size: 14px; text-decoration: none; font-weight: bold;">+ Novo Professor</a>
        </div>

       <div class="card">
            <h3>Total de Cursos</h3>
            <p><?php echo $totalCursos; ?></p>
            <a href="cadastro_curso.php" style="color: #0055a5; font-size: 14px; text-decoration: none; font-weight: bold;">+ Novo Curso</a>
        </div>

        <div class="card">
            <h3>Disciplinas</h3>
            <p><?php echo $totalDisciplinas; ?></p>
            <a href="cadastro_disciplina.php" style="color: #0055a5; font-size: 14px; text-decoration: none; font-weight: bold;">+ Nova Disciplina</a>
        </div>

        <div class="card" style="border-bottom-color: #ff9900;">
            <h3>Turmas Ativas</h3>
            <p><?php echo $totalTurmas; ?></p>
            <a href="cadastro_turma.php" style="color: #0055a5; font-size: 14px; text-decoration: none; font-weight: bold;">+ Nova Turma</a>
        </div>
    </section>
</main>

</body>
</html>