<?php
require_once '../config/db.php';

try {
    // SQL "Mágico": Ele junta a tabela alunos com a tabela turmas
    // buscando o nome da turma onde os IDs batem.
    $sql = "SELECT a.id_aluno, a.nome, a.cpf, a.email, t.nome_turma 
            FROM alunos a 
            INNER JOIN turmas t ON a.id_turma = t.id_turma 
            ORDER BY a.nome ASC";
            
    $stmt = $pdo->query($sql);
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar alunos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos - Gestão Escolar</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sistema Escolar</h1>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="cadastro_aluno.php">Novo Aluno</a>
                <a href="../index.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Alunos Matriculados</h2>
        
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Turma</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($alunos) > 0): ?>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo $aluno['id_aluno']; ?></td>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['nome_turma']); ?></td>
                            <td>
                                <button class="btn-edit">Editar</button>
                                <button class="btn-delete">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Nenhum aluno cadastrado nesta turma.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>