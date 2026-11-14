-- Use the correct database
USE gestao_universitaria;

-- 1. Alter alunos table to add email and senha columns if they do not exist
ALTER TABLE alunos ADD COLUMN IF NOT EXISTS email VARCHAR(100) UNIQUE NULL;
ALTER TABLE alunos ADD COLUMN IF NOT EXISTS senha VARCHAR(255) NULL;

-- 2. Alter professores table to add senha column if it does not exist
ALTER TABLE professores ADD COLUMN IF NOT EXISTS senha VARCHAR(255) NULL;

-- 3. Create boletim table for grades and attendance
CREATE TABLE IF NOT EXISTS boletim (
    id_boletim INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_disciplina INT NOT NULL,
    id_turma INT NOT NULL,
    nota1 DECIMAL(4,2) DEFAULT NULL,
    nota2 DECIMAL(4,2) DEFAULT NULL,
    media DECIMAL(4,2) DEFAULT NULL,
    faltas INT DEFAULT 0,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno) ON DELETE CASCADE,
    FOREIGN KEY (id_disciplina) REFERENCES disciplinas(id_disciplina) ON DELETE CASCADE,
    FOREIGN KEY (id_turma) REFERENCES turmas(id_turma) ON DELETE CASCADE,
    UNIQUE KEY uq_aluno_disciplina_turma (id_aluno, id_disciplina, id_turma)
);

-- 4. Update existing students with emails and default password '123456'
UPDATE alunos SET email = 'caio@vencer.edu.br', senha = '$2y$10$qsGhRH6zNtDkjHXx3vw1DOvoa.VNGkfBTwC7fk2syVDOPa.tPIwfO' WHERE id_aluno = 1 AND email IS NULL;
UPDATE alunos SET email = 'romeu@vencer.edu.br', senha = '$2y$10$qsGhRH6zNtDkjHXx3vw1DOvoa.VNGkfBTwC7fk2syVDOPa.tPIwfO' WHERE id_aluno = 2 AND email IS NULL;
UPDATE alunos SET email = 'albert@vencer.edu.br', senha = '$2y$10$qsGhRH6zNtDkjHXx3vw1DOvoa.VNGkfBTwC7fk2syVDOPa.tPIwfO' WHERE id_aluno = 4 AND email IS NULL;
UPDATE alunos SET email = 'afonso@vencer.edu.br', senha = '$2y$10$qsGhRH6zNtDkjHXx3vw1DOvoa.VNGkfBTwC7fk2syVDOPa.tPIwfO' WHERE id_aluno = 5 AND email IS NULL;

-- 5. Update other/future students with a fallback email template if they are created without email
UPDATE alunos SET email = CONCAT('aluno', id_aluno, '@vencer.edu.br'), senha = '$2y$10$qsGhRH6zNtDkjHXx3vw1DOvoa.VNGkfBTwC7fk2syVDOPa.tPIwfO' WHERE email IS NULL;

-- 6. Update existing professors with default password '123456'
UPDATE professores SET senha = '$2y$10$qsGhRH6zNtDkjHXx3vw1DOvoa.VNGkfBTwC7fk2syVDOPa.tPIwfO' WHERE senha IS NULL;

-- 7. Seed initial grades/attendance data (boletim)
-- Student Caio (id 1) is in course 1. Turma 1 is for id_disciplina 2, id_professor 2.
-- Let's insert a record in boletim for Caio (id 1) in Turma 1 (id_turma 1, id_disciplina 2)
INSERT IGNORE INTO boletim (id_aluno, id_disciplina, id_turma, nota1, nota2, media, faltas)
VALUES (1, 2, 1, 8.50, 7.00, 7.75, 2);

-- Let's also insert a record for student Romeu (id 2) in Turma 1 (id_turma 1, id_disciplina 2)
INSERT IGNORE INTO boletim (id_aluno, id_disciplina, id_turma, nota1, nota2, media, faltas)
VALUES (2, 2, 1, 6.00, 7.50, 6.75, 4);

-- Let's insert a record for student Albert (id 4) in Turma 1
INSERT IGNORE INTO boletim (id_aluno, id_disciplina, id_turma, nota1, nota2, media, faltas)
VALUES (4, 2, 1, 9.00, 8.50, 8.75, 0);
