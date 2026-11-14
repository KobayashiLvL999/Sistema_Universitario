<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_role'] !== 'aluno') {
    header("Location: ../index.php");
    exit();
}

$id_aluno = $_SESSION['usuario_id'];

try {
    // 1. Buscar informações do Aluno e de seu Curso
    $sql_aluno = "SELECT a.nome, a.cpf, a.semestre_atual, c.nome_curso, c.id_curso
                  FROM alunos a
                  INNER JOIN cursos c ON a.id_curso = c.id_curso
                  WHERE a.id_aluno = :id_aluno";
    $stmt_aluno = $pdo->prepare($sql_aluno);
    $stmt_aluno->execute([':id_aluno' => $id_aluno]);
    $alunoInfo = $stmt_aluno->fetch(PDO::FETCH_ASSOC);

    if (!$alunoInfo) {
        die("Aluno não encontrado.");
    }

    $id_curso = $alunoInfo['id_curso'];
    $semestre_atual = $alunoInfo['semestre_atual'];

    // 2. Buscar disciplinas e turmas ativas do aluno no semestre atual
    // E carregar notas e faltas correspondentes
    $sql_boletim = "SELECT DISTINCT d.id_disciplina, d.nome_disciplina, d.carga_horaria,
                                    p.nome AS nome_professor, t.id_turma, t.nome_turma,
                                    b.nota1, b.nota2, b.media, b.faltas
                    FROM turmas t
                    INNER JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
                    INNER JOIN professores p ON t.id_professor = p.id_professor
                    LEFT JOIN boletim b ON b.id_disciplina = d.id_disciplina 
                                       AND b.id_aluno = :id_aluno 
                                       AND b.id_turma = t.id_turma
                    WHERE d.id_curso = :id_curso AND t.semestre_ano = :semestre_atual
                    ORDER BY d.nome_disciplina ASC";
                    
    $stmt_boletim = $pdo->prepare($sql_boletim);
    $stmt_boletim->execute([
        ':id_aluno' => $id_aluno,
        ':id_curso' => $id_curso,
        ':semestre_atual' => $semestre_atual
    ]);
    $boletim = $stmt_boletim->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao carregar dados do aluno: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Aluno - Faculdade Vencer</title>
    <link rel="stylesheet" href="../css/style.css"> 
    <style>
        .profile-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            border-left: 5px solid #ff9900;
        }
        .profile-container h2 {
            color: #003366;
            margin-bottom: 10px;
        }
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .profile-item span {
            font-size: 13px;
            color: #666;
            display: block;
        }
        .profile-item strong {
            font-size: 16px;
            color: #333;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
        }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
    </style>
</head>
<body>

<header>
    <h1>Faculdade Vencer - Portal do Aluno</h1>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 14px;">Olá, <strong><?php echo htmlspecialchars($alunoInfo['nome']); ?></strong></span>
        <a href="../src/logout.php" id="logoutBtn" style="text-decoration:none; background-color: #ff9900; padding: 8px 15px; border-radius: 5px; color: #fff; font-weight: bold;">Sair</a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="dashboard_aluno.php" style="background-color: rgba(255,255,255,0.1); border-radius: 5px;">Meu Boletim</a></li>
    </ul>
</nav>

<main>
    <!-- Perfil do Aluno -->
    <section class="profile-container">
        <h2>🎓 Seus Dados Acadêmicos</h2>
        <div class="profile-grid">
            <div class="profile-item">
                <span>Nome Completo</span>
                <strong><?php echo htmlspecialchars($alunoInfo['nome']); ?></strong>
            </div>
            <div class="profile-item">
                <span>CPF</span>
                <strong><?php echo htmlspecialchars($alunoInfo['cpf']); ?></strong>
            </div>
            <div class="profile-item">
                <span>Curso</span>
                <strong><?php echo htmlspecialchars($alunoInfo['nome_curso']); ?></strong>
            </div>
            <div class="profile-item">
                <span>Semestre Atual</span>
                <strong><?php echo htmlspecialchars($alunoInfo['semestre_atual']); ?>º Semestre</strong>
            </div>
        </div>
    </section>

    <!-- Boletim de Notas e Faltas -->
    <section class="list-section">
        <h2>📊 Boletim de Notas e Faltas - Semestre <?php echo htmlspecialchars($semestre_atual); ?>º</h2>
        
        <?php if (count($boletim) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Carga Horária</th>
                        <th>Professor</th>
                        <th>Turma</th>
                        <th class="text-center">Nota 1</th>
                        <th class="text-center">Nota 2</th>
                        <th class="text-center">Média Final</th>
                        <th class="text-center">Faltas</th>
                        <th class="text-center">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boletim as $row): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['nome_disciplina']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['carga_horaria']); ?>h</td>
                        <td><?php echo htmlspecialchars($row['nome_professor']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome_turma']); ?></td>
                        
                        <td class="text-center">
                            <?php echo $row['nota1'] !== null ? number_format($row['nota1'], 1) : '-'; ?>
                        </td>
                        
                        <td class="text-center">
                            <?php echo $row['nota2'] !== null ? number_format($row['nota2'], 1) : '-'; ?>
                        </td>
                        
                        <td class="text-center" style="font-weight: bold;">
                            <?php echo $row['media'] !== null ? number_format($row['media'], 2) : '-'; ?>
                        </td>
                        
                        <td class="text-center">
                            <?php echo $row['faltas'] !== null ? $row['faltas'] : '0'; ?>
                        </td>
                        
                        <td class="text-center">
                            <?php 
                            if ($row['media'] === null) {
                                echo '<span class="badge badge-warning">Em Andamento</span>';
                            } else {
                                if ($row['media'] >= 7.0 && $row['faltas'] <= 16) {
                                    echo '<span class="badge badge-success">Aprovado</span>';
                                } elseif ($row['faltas'] > 16) {
                                    echo '<span class="badge badge-danger">Rep. por Falta</span>';
                                } else {
                                    echo '<span class="badge badge-danger">Reprovado</span>';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #666; margin-top: 15px;">Nenhuma disciplina ou turma ativa foi localizada para seu curso e semestre neste período.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
