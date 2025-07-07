<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($usuario === 'admin' && $senha === 'admin123') {
        $_SESSION['admin'] = $usuario;
        header('Location: admin.php');
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login Admin - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
<style>
/* Estilo específico só para login admin */
body {
    background: #f0f0f0;
    font-family: Arial, sans-serif;
}

.login-container {
    max-width: 400px;
    margin: 50px auto;
    background: white;
    padding: 2em;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.login-container h2 {
    text-align: center;
    color: #6b1b57;
}

.login-container form {
    display: flex;
    flex-direction: column;
}

.login-container label {
    margin-top: 1em;
    color: #333;
}

.login-container input {
    padding: 0.5em;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 0.3em;
}

.login-container button {
    margin-top: 1.5em;
    padding: 0.7em;
    background: #6b1b57;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background 0.3s;
}

.login-container button:hover {
    background: #8c2b73;
}

.login-container .error {
    margin-top: 1em;
    color: #b00020;
    text-align: center;
}
</style>
</head>
<body>
<div class="login-container">
    <h2>Login do Administrador</h2>
    <?php if (!empty($erro)): ?>
        <div class="error"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Usuário:</label>
        <input type="text" name="usuario" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Entrar</button>
    </form>
</div>
</body>
</html>
