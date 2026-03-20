<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Turmas - Gestão Escolar</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sistema Escolar</h1>
            <div class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="cadastro_aluno.php">Alunos</a>
                <a href="cadastro_disciplina.php">Disciplinas</a>
                <a href="../index.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <section class="form-section">
            <h2>Configurar Nova Turma</h2>
            
            <!-- Mensagem de Sucesso -->
            <?php if(isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
                <p style="color: green; font-weight: bold;">✅ Turma cadastrada com sucesso!</p>
            <?php endif; ?>

            <!-- O action aponta para o arquivo de processamento -->
            <form action="../src/salvar_turma.php" method="POST" class="grid-form">
                <div class="form-group">
                    <label>Identificação da Turma</label>
                    <!-- O campo precisa ter name="nome_turma" -->
                    <input type="text" name="nome_turma" placeholder="Ex: 3º Ano A - Matutino" required>
                </div>

                <div class="form-group">
                    <label>Ano Letivo</label>
                    <!-- O campo precisa ter name="ano" -->
                    <input type="number" name="ano" value="2026" min="2024" max="2030" required>
                </div>

                <div class="form-group">
                    <label>Capacidade Máxima (Opcional)</label>
                    <input type="number" name="capacidade" placeholder="Ex: 40">
                </div>

                <div class="form-group">
                    <label>Turno</label>
                    <select name="turno">
                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>
                    </select>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Criar Turma</button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>