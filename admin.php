<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}
require_once 'database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover'])) {
    $db->delete("DELETE FROM produtos WHERE id = ?", [$_POST['id']]);
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $imagem = $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], 'imagem/' . $imagem);
    $db->insert("INSERT INTO produtos (nome, preco, imagem) VALUES (?, ?, ?)", [$nome, $preco, "imagem/$imagem"]);
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_produto'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    if (!empty($_FILES['imagem']['name'])) {
        $imagem = $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], 'imagem/' . $imagem);
        $db->update("UPDATE produtos SET nome = ?, preco = ?, imagem = ? WHERE id = ?", [$nome, $preco, "imagem/$imagem", $id]);
    } else {
        $db->update("UPDATE produtos SET nome = ?, preco = ? WHERE id = ?", [$nome, $preco, $id]);
    }
    header('Location: admin.php');
    exit;
}

$produtos = $db->select("SELECT * FROM produtos");
$editar_id = isset($_POST['editar']) ? $_POST['id'] : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Admin</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f4f4;
}
h1, h2 {
    margin: 1em;
    color: #6b1b57;
}
form {
    background: white;
    margin: 1em;
    padding: 1.5em;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
    max-width: 600px;
}
input[type="text"], input[type="number"], input[type="file"] {
    width: 100%;
    padding: 0.7em;
    margin: 0.5em 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    background: #6b1b57;
    color: white;
    padding: 0.7em 1.5em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 0.5em;
}
button:hover {
    background: #9e3a83;
}
ul {
    list-style: none;
    padding: 0;
    margin: 1em;
}
li {
    background: white;
    padding: 1em;
    margin-bottom: 0.5em;
    border-left: 5px solid #6b1b57;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.actions form {
    display: inline;
}
</style>
</head>
<body>
<h1>Painel Admin</h1>

<h2>Adicionar Produto</h2>
<form method="post" enctype="multipart/form-data">
  <input type="text" name="nome" placeholder="Nome" required>
  <input type="number" step="0.01" name="preco" placeholder="Preço" required>
  <input type="file" name="imagem" accept="image/*" required>
  <button type="submit" name="adicionar">Adicionar</button>
</form>

<h2>Produtos</h2>
<ul>
  <?php foreach ($produtos as $p): ?>
  <li>
    <div>
      <?= $p->nome ?> - R$ <?= number_format($p->preco, 2, ',', '.') ?>
    </div>
    <div class="actions">
      <form method="post">
        <input type="hidden" name="id" value="<?= $p->id ?>">
        <button type="submit" name="remover">Remover</button>
        <button type="submit" name="editar">Editar</button>
      </form>
    </div>
  </li>

  <?php if ($editar_id == $p->id): ?>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $p->id ?>">
    <input type="text" name="nome" value="<?= $p->nome ?>" required>
    <input type="number" step="0.01" name="preco" value="<?= $p->preco ?>" required>
    <input type="file" name="imagem" accept="image/*">
    <button type="submit" name="editar_produto">Salvar Alterações</button>
  </form>
  <?php endif; ?>

  <?php endforeach; ?>
</ul>
</body>
</html>
