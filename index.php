<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestão Escolar</title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Acesso ao Sistema</h2>
        <form action="views/dashboard.php" method="POST"> <input type="text" name="usuario" placeholder="Usuário (admin)" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>