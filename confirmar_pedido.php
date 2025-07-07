<?php
session_start();
require 'produtos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['carrinho'])) {
    header('Location: index.php');
    exit;
}

$nome = trim($_POST['nome']);
$endereco = trim($_POST['endereco']);
$pagamento = $_POST['pagamento'];

$total = 0;
foreach($_SESSION['carrinho'] as $id => $qtd){
    $produto = $_SESSION['produtos'][$id];
    $total += $produto['preco'] * $qtd;
}

// Aqui você poderia salvar o pedido no banco ou arquivo

// Limpa carrinho
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
<header>
  <h1>Pedido Confirmado!</h1>
</header>
<main>
  <h2>Obrigado, <?= htmlspecialchars($nome) ?>!</h2>
  <p>Seu pedido foi recebido e será entregue em breve no endereço:</p>
  <p><strong><?= htmlspecialchars($endereco) ?></strong></p>
  <p>Forma de Pagamento: <strong><?= htmlspecialchars($pagamento) ?></strong></p>
  <p>Valor Total: <strong>R$ <?= number_format($total,2,",",".") ?></strong></p>

  <?php if ($pagamento === 'PIX'): ?>
    <p><strong>Chave PIX:</strong> pix@acai.com</p>
  <?php elseif ($pagamento === 'Dinheiro'): ?>
    <p>O pagamento será feito na entrega.</p>
  <?php elseif ($pagamento === 'Cartão'): ?>
    <p>O pagamento será processado na entrega via maquininha.</p>
  <?php endif; ?>

  <p><a href="index.php">Voltar à Loja</a></p>
</main>
</body>
</html>
