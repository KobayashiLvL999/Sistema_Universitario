<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    $stmt = $pdo->query("SELECT * FROM cursos ORDER BY nome_curso ASC");
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar cursos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Cursos</title>
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
        <section class="list-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>📚 Cursos Oferecidos</h2>
                <a href="cadastro_curso.php" style="background-color: #003366; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">+ Novo Curso</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Curso</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $c): ?>
                    <tr>
                        <td><?php echo $c['id_curso']; ?></td>
                        <td><strong><?php echo htmlspecialchars($c['nome_curso']); ?></strong></td>
                        <td><?php echo $c['duracao_semestres']; ?> semestres</td>
                        <td>
                            <a href="editar_curso.php?id=<?php echo $c['id_curso']; ?>" class="btn-edit" style="background-color: #ff9900; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;">Editar</a>
                            <a href="../src/excluir_curso.php?id=<?php echo $c['id_curso']; ?>" style="background-color: #cc0000; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;" onclick="return confirm('Atenção: Excluir um curso removerá o vínculo com alunos e disciplinas. Deseja continuar?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>