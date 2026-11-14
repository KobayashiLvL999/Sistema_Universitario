<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: lista_alunos.php"); exit(); }

try {
    // 1. Busca os dados do aluno atual
    $stmt = $pdo->prepare("SELECT * FROM alunos WHERE id_aluno = :id");
    $stmt->execute([':id' => $id]);
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Busca os cursos para o menu de seleção
    $cursos = $pdo->query("SELECT * FROM cursos ORDER BY nome_curso ASC")->fetchAll();

    if (!$aluno) { die("Aluno não encontrado!"); }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno - Faculdade Vencer</title>
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
            <h2>✏️ Editar Cadastro de Aluno</h2>
            <form action="../src/atualizar_aluno.php" method="POST">
                <input type="hidden" name="id_aluno" value="<?php echo $aluno['id_aluno']; ?>">

                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($aluno['nome']); ?>" required>
                </div>

                <div class="form-group">
                    <label>CPF:</label>
                    <input type="text" name="cpf" value="<?php echo htmlspecialchars($aluno['cpf']); ?>" required>
                </div>

                <div class="form-group">
                    <label>E-mail Acadêmico:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($aluno['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Senha de Acesso (Deixe em branco para manter a atual):</label>
                    <input type="password" name="senha" placeholder="Nova senha se desejar alterar">
                </div>

                <div class="form-group">
                    <label>Semestre Atual:</label>
                    <select name="semestre_atual" required>
                        <?php for($i=1; $i<=10; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == $aluno['semestre_atual']) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>º Semestre
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Curso:</label>
                    <select name="id_curso" required>
                        <?php foreach($cursos as $c): ?>
                            <option value="<?php echo $c['id_curso']; ?>" <?php echo ($c['id_curso'] == $aluno['id_curso']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['nome_curso']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-save">Salvar Alterações</button>
            </form>
            <br>
            <a href="lista_alunos.php" style="text-decoration: none; color: #003366;">⬅ Cancelar e Voltar</a>
        </section>
    </main>
</body>
</html>