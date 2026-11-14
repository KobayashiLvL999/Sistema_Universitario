<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit();
}

try {
    // SQL que busca a turma e conta os alunos do curso/semestre correspondente automaticamente
    $sql = "SELECT t.*, d.nome_disciplina, p.nome as nome_professor,
            (SELECT COUNT(*) FROM alunos a 
             INNER JOIN disciplinas d2 ON a.id_curso = d2.id_curso 
             WHERE d2.id_disciplina = t.id_disciplina 
             AND a.semestre_atual = t.semestre_ano) as total_alunos
            FROM turmas t
            INNER JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
            INNER JOIN professores p ON t.id_professor = p.id_professor
            ORDER BY t.semestre_ano ASC, t.nome_turma ASC";
            
    $stmt = $pdo->query($sql);
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar turmas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faculdade Vencer - Turmas</title>
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
                <h2>🏫 Gerenciamento de Turmas</h2>
                <a href="cadastro_turma.php" style="background-color: #003366; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">+ Nova Turma</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nome da Turma</th>
                        <th>Disciplina</th>
                        <th>Semestre</th>
                        <th>Professor</th>
                        <th>Alunos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($turmas) > 0): ?>
                        <?php foreach ($turmas as $t): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($t['nome_turma']); ?></strong></td>
                            <td><?php echo htmlspecialchars($t['nome_disciplina']); ?></td>
                            <td><?php echo $t['semestre_ano']; ?>º Semestre</td>
                            <td><?php echo htmlspecialchars($t['nome_professor']); ?></td>
                            <td><span style="background: #eef2f7; padding: 4px 12px; border-radius: 20px; font-weight: bold; color: #003366;"><?php echo $t['total_alunos']; ?></span></td>
                            <td>
                                <a href="editar_turma.php?id=<?php echo $t['id_turma']; ?>" class="btn-edit" style="background-color: #ff9900; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;">Editar</a>
                                <a href="../src/excluir_turma.php?id=<?php echo $t['id_turma']; ?>" style="background-color: #cc0000; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px;" onclick="return confirm('Excluir esta turma?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center; padding: 20px;">Nenhuma turma encontrada.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>