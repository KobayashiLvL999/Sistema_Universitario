<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    // Busca as disciplinas unindo com curso e professor
    $sql = "SELECT d.id_disciplina, d.nome_disciplina, d.carga_horaria, c.nome_curso, p.nome as nome_professor
            FROM disciplinas d
            INNER JOIN cursos c ON d.id_curso = c.id_curso
            INNER JOIN professores p ON d.id_professor = p.id_professor
            ORDER BY c.nome_curso ASC, d.nome_disciplina ASC";
            
    $stmt = $pdo->query($sql);
    $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar disciplinas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Grade Curricular</title>
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
                <h2>📚 Grade Curricular</h2>
                <a href="cadastro_disciplina.php" style="background-color: #003366; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">+ Nova Disciplina</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Carga</th>
                        <th>Curso</th>
                        <th>Professor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($disciplinas) > 0): ?>
                        <?php foreach ($disciplinas as $d): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($d['nome_disciplina']); ?></strong></td>
                            <td><?php echo $d['carga_horaria']; ?>h</td>
                            <td><?php echo htmlspecialchars($d['nome_curso']); ?></td>
                            <td><?php echo htmlspecialchars($d['nome_professor']); ?></td>
                            <td>
                                <a href="editar_disciplina.php?id=<?php echo $d['id_disciplina']; ?>" style="background-color: #ff9900; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;">Editar</a>
                                <a href="../src/excluir_disciplina.php?id=<?php echo $d['id_disciplina']; ?>" style="background-color: #cc0000; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;" onclick="return confirm('Deseja realmente excluir esta disciplina?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 20px;">Nenhuma disciplina cadastrada ainda.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>