<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios - Gestão Escolar</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Estilos específicos para a página de relatórios */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-box { background: #fff; padding: 20px; border-radius: 8px; text-align: center; border-bottom: 4px solid var(--accent); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .stat-box h3 { font-size: 2rem; margin: 5px 0; color: var(--primary); }
        .progress-bar { background: #eee; border-radius: 10px; height: 20px; width: 100%; margin: 10px 0; overflow: hidden; }
        .progress-fill { background: var(--accent); height: 100%; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sistema Escolar - Relatórios</h1>
            <div class="menu">
                <a href="dashboard.php">Voltar ao Início</a>
                <a href="../index.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Visão Geral da Instituição</h2>
        
        <div class="stats-grid">
            <div class="stat-box">
                <p>Total de Alunos</p>
                <h3>152</h3>
            </div>
            <div class="stat-box">
                <p>Turmas Ativas</p>
                <h3>08</h3>
            </div>
            <div class="stat-box" style="border-bottom-color: #3498db;">
                <p>Média Geral</p>
                <h3>8.5</h3>
            </div>
            <div class="stat-box" style="border-bottom-color: #f39c12;">
                <p>Inadimplência</p>
                <h3>3%</h3>
            </div>
        </div>

        <section>
            <h3>Ocupação das Turmas</h3>
            <p>3º Ano A - Médio (90%)</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 90%;"></div>
            </div>

            <p>1º Ano B - Fundamental (65%)</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 65%; background: #3498db;"></div>
            </div>
        </section>
    </div>
</body>
</html>