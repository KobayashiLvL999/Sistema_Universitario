<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Novo Professor</title>
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
        <section class="form-section">
            <h2>Cadastro de Professor</h2>
            <form action="../src/salvar_professor.php" method="POST">
                <div class="form-group">
                    <label>Nome do Professor:</label>
                    <input type="text" name="nome" placeholder="Nome completo" required>
                </div>

                <div class="form-group">
                    <label>Formação Acadêmica:</label>
                    <input type="text" name="formacao" placeholder="Ex: Doutorado em Física Nuclear" required>
                </div>

                <div class="form-group">
                    <label>E-mail Acadêmico:</label>
                    <input type="email" name="email" placeholder="professor@faculvencer.com.br" required>
                </div>

                <div class="form-group">
                    <label>Senha de Acesso:</label>
                    <input type="password" name="senha" placeholder="Senha do professor" required>
                </div>
                
                <button type="submit" class="btn-save">Cadastrar Professor</button>
            </form>
            <br>
            <a href="lista_professores.php" style="text-decoration: none; color: #003366;">⬅ Ver todos os professores</a>
        </section>
    </main>
</body>
</html>