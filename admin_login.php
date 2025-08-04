<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $db = new Database();

    $usuario = $db->select("SELECT * FROM usuarios WHERE email = ?", [$email]);

    if ($usuario && count($usuario) > 0) {
        $u = $usuario[0];
        if ($u->tipo === 'admin' && password_verify($senha, $u->senha)) {
            $_SESSION['usuario'] = $u;
            header("Location: admin.php");
            exit;
        }
    }

    $erro = "Credenciais inválidas ou você não é um administrador.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
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
            margin-bottom: 1em;
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
        .erro {
            text-align: center;
            color: red;
            margin-bottom: 1em;
        }

        .btn-cadastrar{
        display: block;
        width: 100%;
        text-align: center;
        background: #fff;
        color: #6b1b57;
        border: 2px solid #6b1b57;
        padding: 0.7em;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        margin-top: 1em;
        }

        .btn-cadastrar:hover {
        background: #6b1b57;
        color: #fff;
        }        
    </style>
</head>
<body>
    <h1>Login Admin</h1>
    <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
          <p style="text-align:center;">Não tem conta?</p>
          <a href="register.php" class="btn-cadastrar">Cadastrar</a>
    </form>
</body>
</html>
