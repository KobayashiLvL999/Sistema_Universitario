<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Universitário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Acesso ao Sistema</h2>
        <form action="src/validar_login.php" method="POST"> 
    <input type="email" name="email" placeholder="Email (admin@vencer.edu.br)" required>
    <input type="password" name="senha" placeholder="Senha (123456)" required>
    <button type="submit">Entrar</button>
    
    <?php if(isset($_GET['erro'])): ?>
        <p style="color:red; font-size:14px;">Usuário ou senha inválidos!</p>
    <?php endif; ?>
</form>
    </div>
</body>
</html>