# Sistema Universitário — Faculdade Vencer

Sistema web de gestão acadêmica universitária desenvolvido em **PHP** com banco de dados **MySQL (PDO)**, voltado para o gerenciamento de cursos de graduação, disciplinas, turmas, professores, alunos e boletins acadêmicos (notas e frequência).

---

## Funcionalidades

### Painel Administrativo (`Administrador`)
- **Dashboard Geral:** indicadores em tempo real com o total de alunos, professores, cursos, disciplinas e turmas cadastradas.
- **Gestão de Alunos:** cadastro, listagem, edição e exclusão de alunos vinculados a cursos.
- **Gestão de Professores:** cadastro, listagem, edição e exclusão de docentes.
- **Gestão de Cursos:** criação, edição e remoção de cursos ofertados pela faculdade.
- **Gestão de Disciplinas:** cadastro, atualização e exclusão de disciplinas com carga horária.
- **Gestão de Turmas:** criação de turmas relacionando disciplina, professor, semestre e turno, além da visualização de alunos matriculados.
- **Relatórios:** visão consolidada dos registros acadêmicos da instituição.

### Painel do Professor (`Professor`)
- Visualização das turmas sob sua responsabilidade.
- Lançamento e atualização de notas (`Nota 1`, `Nota 2`), cálculo automático de média e controle de faltas dos alunos no boletim.

### Portal do Aluno (`Aluno`)
- Consulta às informações de matrícula e curso.
- Acompanhamento do boletim acadêmico (notas, média final, faltas e situação por disciplina).

---

## Tecnologias Utilizadas

- **Back-end:** PHP 8+ (PDO para conexão segura com o banco de dados e `password_hash` / `password_verify` para autenticação)
- **Banco de Dados:** MySQL / MariaDB
- **Front-end:** HTML5, CSS3 e JavaScript
- **Ambiente recomendado:** XAMPP (Apache + MySQL)

---

## Estrutura do Projeto

```text
Sistema_Universitario/
├── config/
│   ├── db.php                  # Configuração da conexão PDO com o MySQL
│   └── db_update.sql           # Script de atualização de tabelas, credenciais e boletim
├── css/
│   └── style.css               # Folha de estilos principal
├── js/
│   └── script.js               # Scripts de interação no front-end
├── src/                        # Controladores e regras de negócio (login, CRUDs, boletim)
├── views/                      # Telas do sistema (dashboards, listagens, formulários)
├── index.php                   # Tela de login unificada
└── README.md                   # Documentação do projeto
```

---

## Como Executar Localmente

1. **Clone o repositório** dentro da pasta `htdocs` do seu XAMPP:
   ```bash
   git clone https://github.com/KobayashiLvL999/Sistema_Universitario.git
   ```
2. **Inicie os serviços:** abra o painel de controle do **XAMPP** e inicie os módulos **Apache** e **MySQL**.
3. **Configure o Banco de Dados:**
   - Certifique-se de que o banco de dados `gestao_universitaria` existe no seu MySQL/phpMyAdmin.
   - Execute o script [`config/db_update.sql`](config/db_update.sql) para garantir a criação da tabela `boletim` e das colunas de autenticação (`email` e `senha`) nas tabelas de `alunos` e `professores`.
   - Verifique as credenciais de conexão em [`config/db.php`](config/db.php) (`$host`, `$db`, `$user`, `$pass`).
4. **Acesse no navegador:**
   ```text
   http://localhost/Sistema_Universitario/
   ```
   *(ou `http://localhost/Sistema_Escolar/` caso mantenha o nome antigo da pasta local)*

---

## Credenciais de Acesso (Padrão de Teste)

| Perfil | E-mail | Senha |
| :--- | :--- | :--- |
| **Administrador** | `admin@vencer.edu.br` | `123456` |
| **Aluno (Exemplo)** | `caio@vencer.edu.br` | `123456` |
| **Professor** | *E-mail cadastrado no banco* | `123456` |
