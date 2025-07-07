<?php
session_start();
require 'produtos.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

if (!isset($_SESSION['produtos_inativos'])) {
    $_SESSION['produtos_inativos'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['preco'], $_POST['imagem'])) {
    $nome = trim($_POST['nome']);
    $preco = (float)$_POST['preco'];
    $imagem = trim($_POST['imagem']);
    if ($nome && $preco > 0 && $imagem) {
        $id = empty($_SESSION['produtos']) ? 1 : (max(array_keys($_SESSION['produtos'])) + 1);
        $_SESSION['produtos'][$id] = [
            "nome" => $nome,
            "preco" => $preco,
            "imagem" => $imagem
        ];
    }
}

if (isset($_GET['arquivar'])) {
    $id = (int)$_GET['arquivar'];
    if (isset($_SESSION['produtos'][$id])) {
        $_SESSION['produtos_inativos'][$id] = $_SESSION['produtos'][$id];
        unset($_SESSION['produtos'][$id]);
    }
    header("Location: admin.php");
    exit;
}
if (isset($_GET['ativar'])) {
    $id = (int)$_GET['ativar'];
    if (isset($_SESSION['produtos_inativos'][$id])) {
        $_SESSION['produtos'][$id] = $_SESSION['produtos_inativos'][$id];
        unset($_SESSION['produtos_inativos'][$id]);
    }
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Admin - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
<style>
.produto-item { display: flex; align-items: center; margin-bottom: 0.5em; }
.produto-item img { height: 50px; margin-right: 1em; }
.produto-item a { margin-left: 1em; }
</style>
</head>
<body>
<h2>Administração de Produtos</h2>

<h3>Adicionar Produto</h3>
<form method="post">
  <label>Nome:</label><input type="text" name="nome" required><br>
  <label>Preço:</label><input type="number" name="preco" step="0.01" required><br>
  <label>URL da Imagem:</label><input type="text" name="imagem" required><br>
  <button type="submit">Adicionar</button>
</form>

<h3>Produtos Ativos</h3>
<?php if (!empty($_SESSION['produtos'])): ?>
<ul>
<?php foreach($_SESSION['produtos'] as $id => $produto): ?>
  <li class="produto-item">
    <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="">
    <?= htmlspecialchars($produto['nome']) ?> - R$ <?= number_format($produto['preco'],2,",",".") ?>
    <a href="?arquivar=<?= $id ?>">Arquivar</a>
  </li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>Nenhum produto ativo.</p>
<?php endif; ?>

<h3>Produtos Arquivados</h3>
<?php if (!empty($_SESSION['produtos_inativos'])): ?>
<ul>
<?php foreach($_SESSION['produtos_inativos'] as $id => $produto): ?>
  <li class="produto-item">
    <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="">
    <?= htmlspecialchars($produto['nome']) ?> - R$ <?= number_format($produto['preco'],2,",",".") ?>
    <a href="?ativar=<?= $id ?>">Ativar</a>
  </li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>Nenhum produto arquivado.</p>
<?php endif; ?>

<p><a href="index.php">Voltar ao Site</a></p>
</body>
</html>
