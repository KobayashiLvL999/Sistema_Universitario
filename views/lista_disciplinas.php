<?php
require_once '../config/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM disciplinas ORDER BY nome_disciplina ASC");
    $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Disciplinas</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav> </nav>
    <div class="container">
        <h2>Disciplinas Cadastradas</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Carga Horária</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($disciplinas as $d): ?>
                <tr>
                    <td><?php echo $d['id_disciplina']; ?></td>
                    <td><?php echo htmlspecialchars($d['nome_disciplina']); ?></td>
                    <td><?php echo $d['carga_horaria']; ?>h</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>