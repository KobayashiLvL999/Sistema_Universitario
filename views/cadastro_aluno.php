<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno - Gestão Escolar</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sistema Escolar</h1>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="lista_alunos.php">Listar Alunos</a>
                <a href="../index.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="form-section">
            <h2>Novo Cadastro de Aluno</h2>
            <p>Preencha os dados abaixo para matricular um novo estudante.</p>
            
            <form action="../src/salvar_aluno.php" method="POST" class="grid-form">
    
    <input type="text" name="nome" required>
    <input type="date" name="data_nasc">
    <input type="email" name="email">
    <input type="text" name="cpf" maxlength="14" placeholder="000.000.000-00">
    
    <select name="id_turma">
        <option value="1">1º Ano A</option> 
        </select>

    <button type="submit" class="btn-save">Salvar Matrícula</button>
</form>
        </section>
    </div>
</body>
</html>