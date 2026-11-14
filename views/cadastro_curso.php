<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Curso - Faculdade Vencer</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastrar Novo Curso</h2>
        <form action="../src/salvar_curso.php" method="POST">
            <div class="form-group">
                <label>Nome do Curso:</label>
                <input type="text" name="nome_curso" placeholder="Ex: Física Nuclear" required>
            </div>
            <div class="form-group">
                <label>Duração (Semestres):</label>
                <input type="number" name="duracao" value="8" required>
            </div>
            <button type="submit" class="btn-save">Salvar Curso</button>
        </form>
    </div>
</body>
</html>