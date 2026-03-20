<?php
// Inclui a conexão com o banco
require_once '../config/db.php';

// Busca todas as turmas cadastradas
try {
    $stmt = $pdo->query("SELECT * FROM turmas ORDER BY ano DESC, nome_turma ASC");
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar turmas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Turmas - Gestão Escolar</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sistema Escolar</h1>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="cadastro_turma.php">Nova Turma</a>
                <a href="../index.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Turmas Cadastradas</h2>
        <p>Abaixo estão todas as turmas registradas no sistema.</p>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Turma</th>
                    <th>Ano Letivo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($turmas) > 0): ?>
                    <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo $turma['id_turma']; ?></td>
                            <td><?php echo htmlspecialchars($turma['nome_turma']); ?></td>
                            <td><?php echo $turma['ano']; ?></td>
                            <td>
                                <button class="btn-edit">Editar</button>
                                <button class="btn-delete">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Nenhuma turma encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>