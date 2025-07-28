<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$pagamento = $_POST['pagamento'];

$db = new Database();

$ids = implode(',', array_keys($_SESSION['carrinho']));
$produtos = $db->select("SELECT * FROM produtos WHERE id IN ($ids)");

$total = 0;
foreach ($produtos as $p) {
    $total += $p->preco * $_SESSION['carrinho'][$p->id];
}


unset($_SESSION['carrinho']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Pedido Confirmado - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<h1>Pedido Confirmado</h1>
<p>Obrigado, <?= htmlspecialchars($nome) ?>!</p>
<p>Endereço: <?= htmlspecialchars($endereco) ?></p>
<p>Forma de pagamento: <?= htmlspecialchars($pagamento) ?></p>
<p>Valor total: R$ <?= number_format($total, 2, ',', '.') ?></p>
<p>Seu pedido está sendo processado.</p>
<a href="index.php">Voltar ao início</a>
</body>
</html>
