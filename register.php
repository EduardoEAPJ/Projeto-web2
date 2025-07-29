<?php
session_start();
require_once 'database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $existe = $db->select("SELECT * FROM usuarios WHERE email = ?", [$email]);

    if ($existe) {
        $_SESSION['erro'] = 'Este e-mail já está em uso.';
    } else {
        $db->insert("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')", [$nome, $email, $senha]);
        $_SESSION['sucesso'] = 'Cadastro realizado com sucesso!';
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastrar Usuário</title>
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
input[type="text"], input[type="email"], input[type="password"] {
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
}
.sucesso {
    color: green;
    text-align: center;
}
</style>
</head>
<body>

<form method="post">
  <h1>Cadastrar Usuário</h1>

  <?php if (!empty($_SESSION['erro'])): ?>
    <div class="erro"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['sucesso'])): ?>
    <div class="sucesso"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
  <?php endif; ?>

  <input type="text" name="nome" placeholder="Nome completo" required>
  <input type="email" name="email" placeholder="E-mail" required>
  <input type="password" name="senha" placeholder="Senha" required>
  <button type="submit">Criar Conta</button>
</form>

</body>
</html>
