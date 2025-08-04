<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo']; // cliente ou admin

    $db = new Database();

    $existe = $db->select("SELECT * FROM usuarios WHERE email = ?", [$email]);
    if ($existe) {
        $erro = "E-mail já cadastrado.";
    } else {
        $sucesso = $db->query("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)", [$nome, $email, $senha, $tipo]);
        if ($sucesso) {
            header("Location: login.php");
            exit;
        } else {
            $erro = "Erro ao registrar usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
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
    input, select {
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
      font-size: 1em;
    }
    button:hover {
      background: #9e3a83;
    }
    .erro {
      color: red;
      text-align: center;
      margin-bottom: 1em;
    }
    .voltar {
      display: block;
      text-align: center;
      margin-top: 1em;
      text-decoration: none;
      color: #6b1b57;
      font-weight: bold;
    }
    .voltar:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<form method="post">
  <h1>Cadastrar</h1>

  <?php if (isset($erro)) echo "<p class='erro'>{$erro}</p>"; ?>

  <input type="text" name="nome" placeholder="Nome completo" required>
  <input type="email" name="email" placeholder="E-mail" required>
  <input type="password" name="senha" placeholder="Senha" required>

  <select name="tipo" required>
    <option value="">Selecione o tipo</option>
    <option value="cliente">Cliente</option>
    <option value="admin">Administrador</option>
  </select>

  <button type="submit">Cadastrar</button>

  <a class="voltar" href="login.php">Já tem conta? Entrar</a>
</form>

</body>
</html>
