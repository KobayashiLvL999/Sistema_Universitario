<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: lista_cursos.php"); exit(); }

try {
    $stmt = $pdo->prepare("SELECT * FROM cursos WHERE id_curso = :id");
    $stmt->execute([':id' => $id]);
    $curso = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$curso) { die("Curso não encontrado!"); }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Editar Curso</title>
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
            <h2>✏️ Editar Curso</h2>
            <form action="../src/atualizar_curso.php" method="POST">
                <input type="hidden" name="id_curso" value="<?php echo $curso['id_curso']; ?>">

                <div class="form-group">
                    <label>Nome do Curso:</label>
                    <input type="text" name="nome_curso" value="<?php echo htmlspecialchars($curso['nome_curso']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Duração (Semestres):</label>
                    <input type="number" name="duracao" value="<?php echo $curso['duracao_semestres']; ?>" required>
                </div>

                <button type="submit" class="btn-save">Salvar Alterações</button>
            </form>
            <br>
            <a href="lista_cursos.php" style="text-decoration: none; color: #003366;">⬅ Voltar para a lista</a>
        </section>
    </main>
</body>
</html>