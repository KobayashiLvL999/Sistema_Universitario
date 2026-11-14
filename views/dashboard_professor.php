<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Proteção de acesso: verifica se o usuário está logado e é professor
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_role'] !== 'professor') {
    header("Location: ../index.php");
    exit();
}

$id_professor = $_SESSION['usuario_id'];

try {
    // Buscar turmas ministradas pelo professor
    $sql = "SELECT t.id_turma, t.nome_turma, t.semestre_ano, d.id_disciplina, d.nome_disciplina, c.nome_curso, c.id_curso
            FROM turmas t
            INNER JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
            INNER JOIN cursos c ON d.id_curso = c.id_curso
            WHERE t.id_professor = :id_professor
            ORDER BY t.semestre_ano ASC, t.nome_turma ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_professor' => $id_professor]);
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar turmas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Professor - Faculdade Vencer</title>
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>

<header>
    <h1>Faculdade Vencer - Portal do Professor</h1>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 14px;">Olá, Prof. <strong><?php echo htmlspecialchars($_SESSION['usuario_logado']); ?></strong></span>
        <a href="../src/logout.php" id="logoutBtn" style="text-decoration:none; background-color: #ff9900; padding: 8px 15px; border-radius: 5px; color: #fff; font-weight: bold;">Sair</a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="dashboard_professor.php" style="background-color: rgba(255,255,255,0.1); border-radius: 5px;">Minhas Turmas</a></li>
    </ul>
</nav>

<main>
    <p style="margin-bottom: 20px;">Bem-vindo ao Portal do Professor! Abaixo estão as turmas sob sua responsabilidade neste semestre.</p>
    
    <section class="list-section">
        <h2>🏫 Suas Turmas Ativas</h2>
        
        <?php if (count($turmas) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Turma</th>
                        <th>Semestre</th>
                        <th>Disciplina</th>
                        <th>Curso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($turmas as $t): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($t['nome_turma']); ?></strong></td>
                        <td><span style="background: #eef2f7; padding: 2px 8px; border-radius: 10px;"><?php echo htmlspecialchars($t['semestre_ano']); ?>º Semestre</span></td>
                        <td><?php echo htmlspecialchars($t['nome_disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($t['nome_curso']); ?></td>
                        <td>
                            <a href="turma_alunos.php?id_turma=<?php echo $t['id_turma']; ?>&id_disciplina=<?php echo $t['id_disciplina']; ?>&id_curso=<?php echo $t['id_curso']; ?>" class="btn-edit" style="background-color: #003366 !important; font-weight: bold;">Gerenciar Notas e Faltas</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #666; margin-top: 15px;">Você não possui turmas ativas vinculadas a você no momento.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
