<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    if (!isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] = 1;
    } else {
        $_SESSION['carrinho'][$id]++;
    }
    header('Location: carrinho.php');
    exit;
}

if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
    }
    header('Location: carrinho.php');
    exit;
}

if (isset($_POST['update'])) {
    foreach ($_POST['quantidade'] as $id => $qtd) {
        $qtd = (int)$qtd;
        if ($qtd <= 0) {
            unset($_SESSION['carrinho'][$id]);
        } else {
            $_SESSION['carrinho'][$id] = $qtd;
        }
    }
    header('Location: carrinho.php');
    exit;
}

$db = new Database();

$produtos = [];

if (!empty($_SESSION['carrinho'])) {
    $ids = implode(',', array_keys($_SESSION['carrinho']));
    $produtos = $db->select("SELECT * FROM produtos WHERE id IN ($ids)");
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Carrinho - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  padding: 24px;
  color: #333;
}

h1 {
  text-align: center;
  color: #6b1b57;
  margin-bottom: 24px;
  font-size: 1.6rem;
}

.container {
  max-width: 1100px;
  margin: 0 auto;
}

.table-wrap {
  overflow-x: auto;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

table th, table td {
  padding: 14px 12px;
  border-bottom: 1px solid #eee;
  text-align: center;
  vertical-align: middle;
  font-size: 0.95rem;
}

table th {
  background-color: #6b1b57;
  color: #fff;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .4px;
  font-size: 0.85rem;
}

.product-name {
  display: flex;
  align-items: center;
  gap: 12px;
  text-align: left;
}

.product-name img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 6px;
  border: 1px solid #e6e6e6;
}

input[type="number"] {
  width: 72px;
  padding: 8px;
  text-align: center;
  border: 1px solid #d0d0d0;
  border-radius: 6px;
  background: #fafafa;
  font-size: 0.95rem;
}

.remove-link {
  color: #e03434;
  text-decoration: none;
  font-weight: 700;
  padding: 6px 10px;
  border-radius: 6px;
  transition: background .15s ease;
}

.remove-link:hover {
  background: rgba(224,52,52,0.08);
}

.cart-summary {
  display: flex;
  justify-content: flex-end;
  gap: 16px;
  align-items: center;
  margin-top: 12px;
  margin-bottom: 20px;
}

.total-box {
  background: #fff;
  padding: 12px 16px;
  border-radius: 8px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.04);
  font-weight: 700;
}

button[name="update"] {
  background-color: #6b1b57;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.95rem;
  transition: background .15s ease, transform .06s ease;
}

button[name="update"]:hover {
  background-color: #9e3a83;
  transform: translateY(-1px);
}

.checkout-btn {
  display: inline-block;
  background-color: #27a05b;
  color: #fff;
  padding: 11px 20px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 700;
  transition: background .15s ease, transform .06s ease;
  margin-left: 12px;
}

.checkout-btn:hover {
  background-color: #1f7e45;
  transform: translateY(-1px);
}

.empty {
  text-align: center;
  background: #fff;
  padding: 28px;
  border-radius: 8px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.04);
  font-size: 1rem;
}

@media (max-width: 700px) {
  table th, table td { padding: 10px; font-size: .9rem; }
  .product-name img { width: 56px; height: 56px; }
  .cart-summary { flex-direction: column; align-items: stretch; gap: 10px; }
  .checkout-btn { width: 100%; text-align: center; margin-left: 0; }
}
    
</style>

</head>
<body>
<h1>Carrinho</h1>

<?php if (empty($produtos)): ?>
    <p>Seu carrinho está vazio.</p>
<?php else: ?>
<form method="post">
<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>Produto</th>
    <th>Quantidade</th>
    <th>Preço Unitário</th>
    <th>Subtotal</th>
    <th>Remover</th>
</tr>
<?php foreach ($produtos as $p): 
    $qtd = $_SESSION['carrinho'][$p->id];
    $subtotal = $p->preco * $qtd;
    $total += $subtotal;
?>
<tr>
    <td><?= htmlspecialchars($p->nome) ?></td>
    <td><input type="number" name="quantidade[<?= $p->id ?>]" value="<?= $qtd ?>" min="1"></td>
    <td>R$ <?= number_format($p->preco, 2, ',', '.') ?></td>
    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
    <td><a href="carrinho.php?remove=<?= $p->id ?>">X</a></td>
</tr>
<?php endforeach; ?>
<tr>
    <td colspan="3" align="right"><strong>Total:</strong></td>
    <td colspan="2">R$ <?= number_format($total, 2, ',', '.') ?></td>
</tr>
</table>
<button type="submit" name="update">Atualizar Quantidades</button>
</form>
<a href="checkout.php">Finalizar Compra</a>
<?php endif; ?>
</body>
</html>
