<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login Usuário</title>
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
input[type="text"], input[type="password"] {
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
</style>
</head>
<body>
<form method="post" action="index.php">
  <h1>Login Usuário</h1>
  <input type="text" name="usuario" placeholder="Usuário" required>
  <input type="password" name="senha" placeholder="Senha" required>
  <button type="submit">Entrar</button>
</form>
</body>
</html>
