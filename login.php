<?php
session_start();
require_once 'database.php';

$db = new Database();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca usuário pelo e-mail
    $usuario = $db->select("SELECT * FROM usuarios WHERE email = ?", [$email]);

    if ($usuario && password_verify($senha, $usuario[0]->senha)) {
        // Login válido
        $_SESSION['usuario'] = $usuario[0]->nome;
        $_SESSION['tipo'] = $usuario[0]->tipo;

        if ($usuario[0]->tipo === 'admin') {
            $_SESSION['admin'] = true;
            header('Location: admin.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
}
form {
    background: white;
    max-width: 400px;
    margin: 5em auto;
    padding: 2em;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
h1 {
    text-align: center;
    color: #6b1b57;
}
input[type="email"], input[type="password"] {
    width: 100%;
    padding: 0.7em;
    margin-bottom: 1em;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    width: 100%;
    background: #6b1b57;
    color: white;
    padding: 0.7em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background: #9e3a83;
}
p.erro {
    color: red;
    text-align: center;
}
a{
    display:block;
    text-align: center;
    margin-top: 1em;
    color: #6b1b57;
    text-decoration: none;
    background: #f4f4f4;
    padding: 0.7em;
    border-radius: 5px;
}
a:holver {
    background: #9e3a83;
    color: white;
    text-decoration: none;
}
</style>
</head>
<body>
<form method="post">
  <h1>Login</h1>
  <?php if ($erro): ?>
    <p class="erro"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>
  <input type="email" name="email" placeholder="E-mail" required>
  <input type="password" name="senha" placeholder="Senha" required>
  <button type="submit">Entrar</button>
  <p>não tem conta: <br> <a href="register.php">Cadastrar</a><br></p>
</form>
</body>
</html>

</form>
</body>
</html>


