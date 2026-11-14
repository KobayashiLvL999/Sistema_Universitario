<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: lista_disciplinas.php"); exit(); }

try {
    // Busca a disciplina atual
    $stmt = $pdo->prepare("SELECT * FROM disciplinas WHERE id_disciplina = :id");
    $stmt->execute([':id' => $id]);
    $disc = $stmt->fetch(PDO::FETCH_ASSOC);

    // Busca listas para os menus (Selects)
    $cursos = $pdo->query("SELECT * FROM cursos ORDER BY nome_curso ASC")->fetchAll();
    $profs = $pdo->query("SELECT * FROM professores ORDER BY nome ASC")->fetchAll();

    if (!$disc) { die("Disciplina não encontrada!"); }
} catch (PDOException $e) { 
    die("Erro: " . $e->getMessage()); 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Disciplina - Faculdade Vencer</title>
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
            <h2>✏️ Editar Disciplina</h2>
            <form action="../src/atualizar_disciplina.php" method="POST">
                <input type="hidden" name="id_disciplina" value="<?php echo $disc['id_disciplina']; ?>">

                <div class="form-group">
                    <label>Nome da Disciplina:</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($disc['nome_disciplina']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Carga Horária (h):</label>
                    <input type="number" name="carga" value="<?php echo $disc['carga_horaria']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Mudar Curso:</label>
                    <select name="id_curso">
                        <?php foreach($cursos as $c): ?>
                            <option value="<?php echo $c['id_curso']; ?>" <?php echo ($c['id_curso'] == $disc['id_curso']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['nome_curso']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Mudar Professor:</label>
                    <select name="id_professor">
                        <?php foreach($profs as $p): ?>
                            <option value="<?php echo $p['id_professor']; ?>" <?php echo ($p['id_professor'] == $disc['id_professor']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($p['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-save">Salvar Alterações</button>
            </form>
            <br>
            <a href="lista_disciplinas.php" style="text-decoration: none; color: #003366;">⬅ Cancelar e Voltar</a>
        </section>
    </main>
</body>
</html>