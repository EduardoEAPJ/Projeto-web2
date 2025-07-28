<?php
session_start();

if (empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

$total = 0;
require_once 'database.php';
$db = new Database();

$ids = implode(',', array_keys($_SESSION['carrinho']));
$produtos = $db->select("SELECT * FROM produtos WHERE id IN ($ids)");

foreach ($produtos as $p) {
    $total += $p->preco * $_SESSION['carrinho'][$p->id];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Checkout - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<h1>Finalizar Compra</h1>

<p>Total da compra: R$ <?= number_format($total, 2, ',', '.') ?></p>

<form action="confirmar_pedido.php" method="post">
  <label>Nome completo:</label><br>
  <input type="text" name="nome" required><br>
  <label>Endereço:</label><br>
  <input type="text" name="endereco" required><br>
  <label>Pagamento:</label><br>
  <select name="pagamento" required>
    <option value="pix">PIX</option>
    <option value="dinheiro">Dinheiro</option>
    <option value="cartao">Cartão</option>
  </select><br><br>
  <button type="submit">Confirmar Pedido</button>
</form>
</body>
</html>
