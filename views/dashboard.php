<main class="container">
    <h2>Bem-vindo, Administrador</h2>
    <p>O que você deseja gerenciar hoje?</p>
    
    <div class="cards">
        <div class="card clickable" onclick="location.href='cadastro_aluno.php'">
            <h3>Alunos</h3>
            <p>150 Matrículas</p>
            <span>Gerenciar estudantes → <br></br>
                <a href="lista_alunos.php">Ver Alunos</a>
            </span>
        </div>

        <div class="card clickable" onclick="location.href='cadastro_turma.php'">
            <h3>Turmas</h3>
            <p>08 Ativas</p>
            <span>Gerenciar salas → <br></br>
                <a href="lista_turmas.php">Ver Turmas</a>
            </span>
        </div>

        <div class="card clickable" onclick="location.href='cadastro_disciplina.php'">
            <h3>Disciplinas</h3>
            <p>12 Matérias</p>
            <span>Gerenciar currículo → <br></br>
                <a href="lista_turmas.php">Ver Disciplinas</a>
            </span>
        </div>
    </div>
</main>