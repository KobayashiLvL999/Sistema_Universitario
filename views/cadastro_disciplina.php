<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    // Busca dados para os menus de seleção
    $cursos = $pdo->query("SELECT * FROM cursos ORDER BY nome_curso ASC")->fetchAll();
    $professores = $pdo->query("SELECT * FROM professores ORDER BY nome ASC")->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Disciplina - Faculdade Vencer</title>
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
            <h2>Cadastrar Disciplina</h2>
            <form action="../src/salvar_disciplina.php" method="POST">
                <div class="form-group">
                    <label>Nome da Disciplina:</label>
                    <input type="text" name="nome_disciplina" placeholder="Ex: Física Geral I" required>
                </div>

                <div class="form-group">
                    <label>Carga Horária (horas):</label>
                    <input type="number" name="carga_horaria" value="60" required>
                </div>

                <div class="form-group">
                    <label>Vincular ao Curso:</label>
                    <select name="id_curso" required>
                        <option value="">Selecione o Curso</option>
                        <?php foreach($cursos as $c): ?>
                            <option value="<?php echo $c['id_curso']; ?>"><?php echo htmlspecialchars($c['nome_curso']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Professor Responsável:</label>
                    <select name="id_professor" required>
                        <option value="">Selecione o Professor</option>
                        <?php foreach($professores as $p): ?>
                            <option value="<?php echo $p['id_professor']; ?>"><?php echo htmlspecialchars($p['nome']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-save">Criar Disciplina</button>
            </form>
            <br>
            <a href="lista_disciplinas.php" style="text-decoration: none; color: #003366;">⬅ Ver todas as disciplinas</a>
        </section>
    </main>
</body>
</html>