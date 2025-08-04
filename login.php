<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db = new Database();
    $usuario = $db->select("SELECT * FROM usuarios WHERE email = ?", [$email]);

    if ($usuario && password_verify($senha, $usuario[0]->senha)) {
        $_SESSION['usuario'] = [
            'id' => $usuario[0]->id,
            'nome' => $usuario[0]->nome,
            'email' => $usuario[0]->email,
            'tipo' => $usuario[0]->tipo
        ];

        if ($usuario[0]->tipo === 'admin') {
            header("Location: admin.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        $erro = "Credenciais inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <link rel="stylesheet" href="estilo.css">
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
      margin-bottom: 1em;
      color: #6b1b57;
    }
    input {
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
      color: red;
      text-align: center;
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

<form method="post">
  <h1>Login</h1>
  <?php if (isset($erro)): ?>
    <p class="erro"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>
  <input type="email" name="email" placeholder="E-mail" required>
  <input type="password" name="senha" placeholder="Senha" required>
  <button type="submit">Entrar</button>
  <p style="text-align:center;">Não tem conta?</p>
  <a href="register.php" class="btn-cadastrar">Cadastrar</a>

</form>

</body>
</html>
