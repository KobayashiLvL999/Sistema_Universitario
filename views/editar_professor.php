<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: lista_professores.php"); exit(); }

try {
    $stmt = $pdo->prepare("SELECT * FROM professores WHERE id_professor = :id");
    $stmt->execute([':id' => $id]);
    $prof = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prof) { die("Professor não encontrado!"); }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Professor - Faculdade Vencer</title>
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
            <h2>✏️ Editar Cadastro de Professor</h2>
            <form action="../src/atualizar_professor.php" method="POST">
                <input type="hidden" name="id_professor" value="<?php echo $prof['id_professor']; ?>">

                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($prof['nome']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Formação:</label>
                    <input type="text" name="formacao" value="<?php echo htmlspecialchars($prof['formacao']); ?>" required>
                </div>

                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($prof['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Senha de Acesso (Deixe em branco para manter a atual):</label>
                    <input type="password" name="senha" placeholder="Nova senha se desejar alterar">
                </div>

                <button type="submit" class="btn-save">Salvar Alterações</button>
            </form>
            <br>
            <a href="lista_professores.php" style="text-decoration: none; color: #003366;">⬅ Cancelar e Voltar</a>
        </section>
    </main>
</body>
</html>