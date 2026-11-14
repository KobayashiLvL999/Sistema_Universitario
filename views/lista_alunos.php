<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    // Busca alunos, nome do curso e o semestre atual
    $sql = "SELECT a.id_aluno, a.nome, a.cpf, a.semestre_atual, c.nome_curso 
            FROM alunos a 
            INNER JOIN cursos c ON a.id_curso = c.id_curso 
            ORDER BY a.nome ASC";
    $stmt = $pdo->query($sql);
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar alunos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Lista de Alunos</title>
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
                <h2>🎓 Alunos Matriculados</h2>
                <a href="cadastro_aluno.php" style="background-color: #003366; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">+ Novo Aluno</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Curso</th>
                        <th>Semestre</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?php echo $aluno['id_aluno']; ?></td>
                        <td><strong><?php echo htmlspecialchars($aluno['nome']); ?></strong></td>
                        <td><?php echo htmlspecialchars($aluno['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['nome_curso']); ?></td>
                        <td><span style="background: #eef2f7; padding: 2px 8px; border-radius: 10px;"><?php echo $aluno['semestre_atual']; ?>º</span></td>
                        <td>
                            <a href="editar_aluno.php?id=<?php echo $aluno['id_aluno']; ?>" class="btn-edit" style="background-color: #ff9900; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;">Editar</a>
                            <a href="../src/excluir_aluno.php?id=<?php echo $aluno['id_aluno']; ?>" style="background-color: #cc0000; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;" onclick="return confirm('Excluir aluno?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>