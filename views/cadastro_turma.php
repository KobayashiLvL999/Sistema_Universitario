<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    // Busca dados para os selects
    $disciplinas = $pdo->query("SELECT id_disciplina, nome_disciplina FROM disciplinas ORDER BY nome_disciplina ASC")->fetchAll();
    $professores = $pdo->query("SELECT id_professor, nome FROM professores ORDER BY nome ASC")->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Nova Turma</title>
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
            <h2>🏫 Cadastrar Nova Turma</h2>
            <form action="../src/salvar_turma.php" method="POST">
                <div class="form-group">
                    <label>Nome da Turma:</label>
                    <input type="text" name="nome_turma" placeholder="Ex: Turma A - Física" required>
                </div>

                <div class="form-group">
                    <label>Semestre (Número):</label>
                    <input type="number" name="semestre_ano" placeholder="Ex: 1" min="1" max="10" required>
                </div>

                <div class="form-group">
                    <label>Disciplina:</label>
                    <select name="id_disciplina" required>
                        <option value="">Selecione a Disciplina</option>
                        <?php foreach($disciplinas as $d): ?>
                            <option value="<?php echo $d['id_disciplina']; ?>"><?php echo htmlspecialchars($d['nome_disciplina']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Professor:</label>
                    <select name="id_professor" required>
                        <option value="">Selecione o Professor</option>
                        <?php foreach($professores as $p): ?>
                            <option value="<?php echo $p['id_professor']; ?>"><?php echo htmlspecialchars($p['nome']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-save">Criar Turma</button>
            </form>
            <br>
            <a href="lista_turmas.php" style="text-decoration: none; color: #003366;">⬅ Voltar para a lista</a>
        </section>
    </main>
</body>
</html>