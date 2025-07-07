<?php
session_start();
require 'produtos.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header>
  <img src="imagem/logo.jpg" alt="Logo Açaí do Mamute" class="logo">
  <h1>Açaí do Mamute</h1>
  <nav class="menu">
    <input type="checkbox" id="menu-toggle"/>
    <label for="menu-toggle" class="hamburger">☰ Menu</label>
    <ul>
      <li><a href="index.php">Início</a></li>
      <li><a href="carrinho.php">Carrinho</a></li>
      <li><a href="login.php">Login Usuário</a></li>
      <li><a href="admin_login.php">Login Admin</a></li>
    </ul>
  </nav>
</header>

<main>
  <h2>Nossos Produtos</h2>
  <ul class="produtos">
    <?php foreach($_SESSION['produtos'] as $id => $produto): ?>
      <li>
        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
        <p>Preço: R$ <?= number_format($produto['preco'],2,",",".") ?></p>
        <a href="carrinho.php?add=<?= $id ?>" class="btn">Adicionar ao Carrinho</a>
      </li>
    <?php endforeach; ?>
  </ul>
</main>
</body>
</html>
