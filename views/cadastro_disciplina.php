<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Disciplinas - Gestão Escolar</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sistema Escolar</h1>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="lista_disciplinas.php">Ver Disciplinas</a>
                <a href="../index.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="form-section">
            <h2>Cadastrar Disciplina</h2>
            
            <?php if(isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
                <p style="color: green; font-weight: bold;">✅ Disciplina cadastrada com sucesso!</p>
            <?php endif; ?>

            <form action="../src/salvar_disciplina.php" method="POST" class="grid-form">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Nome da Disciplina</label>
                    <input type="text" name="nome_disciplina" placeholder="Ex: Física Nuclear" required>
                </div>

                <div class="form-group">
                    <label>Professor Responsável</label>
                    <input type="text" name="professor" placeholder="Nome do docente">
                </div>

                <div class="form-group">
                    <label>Carga Horária (horas)</label>
                    <input type="number" name="carga_horaria" placeholder="Ex: 80">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Registrar Disciplina</button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>