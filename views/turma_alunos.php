<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema_Escolar/config/db.php';

// Proteção de acesso
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_role'] !== 'professor') {
    header("Location: ../index.php");
    exit();
}

$id_turma = $_GET['id_turma'] ?? null;
$id_disciplina = $_GET['id_disciplina'] ?? null;
$id_curso = $_GET['id_curso'] ?? null;

if (!$id_turma || !$id_disciplina || !$id_curso) {
    header("Location: dashboard_professor.php");
    exit();
}

try {
    // Buscar detalhes da turma, disciplina e curso
    $sql_detalhes = "SELECT t.nome_turma, t.semestre_ano, d.nome_disciplina, c.nome_curso 
                     FROM turmas t
                     INNER JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
                     INNER JOIN cursos c ON d.id_curso = c.id_curso
                     WHERE t.id_turma = :id_turma AND t.id_disciplina = :id_disciplina AND c.id_curso = :id_curso";
    $stmt_detalhes = $pdo->prepare($sql_detalhes);
    $stmt_detalhes->execute([
        ':id_turma' => $id_turma,
        ':id_disciplina' => $id_disciplina,
        ':id_curso' => $id_curso
    ]);
    $detalhes = $stmt_detalhes->fetch(PDO::FETCH_ASSOC);

    if (!$detalhes) {
        die("Turma não encontrada ou dados inconsistentes.");
    }

    $semestre_ano = $detalhes['semestre_ano'];

    // Buscar alunos matriculados neste curso e semestre
    // E fazer JOIN com a tabela de boletim para carregar notas/faltas se existirem
    $sql_alunos = "SELECT a.id_aluno, a.nome, a.cpf,
                          b.nota1, b.nota2, b.media, b.faltas
                   FROM alunos a
                   LEFT JOIN boletim b ON a.id_aluno = b.id_aluno 
                                      AND b.id_disciplina = :id_disciplina 
                                      AND b.id_turma = :id_turma
                   WHERE a.id_curso = :id_curso AND a.semestre_atual = :semestre_ano
                   ORDER BY a.nome ASC";
    $stmt_alunos = $pdo->prepare($sql_alunos);
    $stmt_alunos->execute([
        ':id_disciplina' => $id_disciplina,
        ':id_turma' => $id_turma,
        ':id_curso' => $id_curso,
        ':semestre_ano' => $semestre_ano
    ]);
    $alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao carregar dados dos alunos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de Notas - Faculdade Vencer</title>
    <link rel="stylesheet" href="../css/style.css"> 
    <style>
        .input-number {
            width: 70px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .btn-submit {
            background-color: #ff9900;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background-color: #e68a00;
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
    <h1>Faculdade Vencer - Lançamento Acadêmico</h1>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 14px;">Olá, Prof. <strong><?php echo htmlspecialchars($_SESSION['usuario_logado']); ?></strong></span>
        <a href="../src/logout.php" id="logoutBtn" style="text-decoration:none; background-color: #ff9900; padding: 8px 15px; border-radius: 5px; color: #fff; font-weight: bold;">Sair</a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="dashboard_professor.php">Minhas Turmas</a></li>
    </ul>
</nav>

<main>
    <div style="margin-bottom: 20px;">
        <a href="dashboard_professor.php" style="text-decoration: none; color: #003366; font-weight: bold;">⬅ Voltar para minhas turmas</a>
    </div>

    <section class="list-section">
        <h2 style="margin-bottom: 10px;">🏫 Gerenciamento Acadêmico</h2>
        <p style="font-size: 15px; color: #666; margin-bottom: 20px;">
            <strong>Turma:</strong> <?php echo htmlspecialchars($detalhes['nome_turma']); ?> &nbsp;|&nbsp;
            <strong>Semestre:</strong> <?php echo htmlspecialchars($detalhes['semestre_ano']); ?>º &nbsp;|&nbsp;
            <strong>Disciplina:</strong> <?php echo htmlspecialchars($detalhes['nome_disciplina']); ?> &nbsp;|&nbsp;
            <strong>Curso:</strong> <?php echo htmlspecialchars($detalhes['nome_curso']); ?>
        </p>

        <?php if(isset($_GET['salvo'])): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                Notas e faltas salvas com sucesso para esta turma!
            </div>
        <?php endif; ?>

        <?php if (count($alunos) > 0): ?>
            <form action="../src/salvar_boletim.php" method="POST">
                <input type="hidden" name="id_turma" value="<?php echo $id_turma; ?>">
                <input type="hidden" name="id_disciplina" value="<?php echo $id_disciplina; ?>">
                <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">

                <table>
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th>CPF</th>
                            <th class="text-center">Nota 1</th>
                            <th class="text-center">Nota 2</th>
                            <th class="text-center">Média</th>
                            <th class="text-center">Faltas</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($aluno['nome']); ?></strong></td>
                            <td><?php echo htmlspecialchars($aluno['cpf']); ?></td>
                            
                            <td class="text-center">
                                <input type="number" step="0.1" min="0" max="10" 
                                       name="boletim[<?php echo $aluno['id_aluno']; ?>][nota1]" 
                                       value="<?php echo $aluno['nota1'] !== null ? number_format($aluno['nota1'], 1) : ''; ?>" 
                                       class="input-number" placeholder="-">
                            </td>
                            
                            <td class="text-center">
                                <input type="number" step="0.1" min="0" max="10" 
                                       name="boletim[<?php echo $aluno['id_aluno']; ?>][nota2]" 
                                       value="<?php echo $aluno['nota2'] !== null ? number_format($aluno['nota2'], 1) : ''; ?>" 
                                       class="input-number" placeholder="-">
                            </td>

                            <td class="text-center" style="font-weight: bold; font-size: 15px;">
                                <?php echo $aluno['media'] !== null ? number_format($aluno['media'], 2) : '-'; ?>
                            </td>
                            
                            <td class="text-center">
                                <input type="number" min="0" max="100" 
                                       name="boletim[<?php echo $aluno['id_aluno']; ?>][faltas]" 
                                       value="<?php echo $aluno['faltas'] !== null ? $aluno['faltas'] : '0'; ?>" 
                                       class="input-number">
                            </td>

                            <td class="text-center">
                                <?php 
                                if ($aluno['media'] === null) {
                                    echo '<span class="badge badge-warning">Em Aberto</span>';
                                } else {
                                    // Regra: Média >= 7.0 e Faltas <= 10 (por exemplo) aprovado
                                    if ($aluno['media'] >= 7.0 && $aluno['faltas'] <= 16) {
                                        echo '<span class="badge badge-success">Aprovado</span>';
                                    } elseif ($aluno['faltas'] > 16) {
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
                
                <div style="margin-top: 25px; text-align: right;">
                    <button type="submit" class="btn-submit">Salvar Notas e Faltas</button>
                </div>
            </form>
        <?php else: ?>
            <p style="color: #cc0000; margin-top: 15px; font-weight: bold;">Nenhum aluno matriculado no <?php echo $semestre_ano; ?>º Semestre deste curso foi encontrado.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
