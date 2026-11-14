<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de página: verifica se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

// Busca os cursos para o select dinâmico
try {
    $cursos = $pdo->query("SELECT * FROM cursos ORDER BY nome_curso ASC")->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar cursos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Novo Aluno</title>
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
            <h2>🎓 Cadastro de Aluno</h2>
            <form action="../src/salvar_aluno.php" method="POST">
                <label>Nome do Aluno:</label>
                <input type="text" name="nome" placeholder="Nome completo" required>
                
                <label>CPF:</label>
                <input type="text" name="cpf" placeholder="000.000.000-00" required> 

                <label>E-mail Acadêmico:</label>
                <input type="email" name="email" placeholder="nome@vencer.edu.br" required>

                <label>Senha de Acesso:</label>
                <input type="password" name="senha" placeholder="Senha do aluno" required>

                <label>Semestre de Ingresso:</label>
                <select name="semestre_atual" required>
                    <?php for($i=1; $i<=10; $i++) echo "<option value='$i'>$i º Semestre</option>"; ?>
                </select>

                <label>Curso:</label>
                <select name="id_curso" required>
                    <option value="">Selecione o curso</option>
                    <?php foreach($cursos as $c): ?>
                    <option value="<?php echo $c['id_curso']; ?>"><?php echo htmlspecialchars($c['nome_curso']); ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Salvar Matrícula</button>
            </form>
        </section>
    </main>
</body>
</html>