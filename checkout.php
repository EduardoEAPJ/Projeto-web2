<?php
session_start();
require 'produtos.php';

if (empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Finalizar Compra - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header>
  <h1>Finalizar Compra</h1>
</header>

<main>
  <h2>Resumo do Pedido</h2>
  <table>
    <tr>
      <th>Produto</th>
      <th>Quantidade</th>
      <th>Subtotal</th>
    </tr>
    <?php
    $total = 0;
    foreach($_SESSION['carrinho'] as $id => $qtd):
        $produto = $_SESSION['produtos'][$id];
        $subtotal = $produto['preco'] * $qtd;
        $total += $subtotal;
    ?>
    <tr>
      <td><?= htmlspecialchars($produto['nome']) ?></td>
      <td><?= $qtd ?></td>
      <td>R$ <?= number_format($subtotal,2,",",".") ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p><strong>Total: R$ <?= number_format($total,2,",",".") ?></strong></p>

  <h2>Dados do Cliente</h2>
  <form action="confirmar_pedido.php" method="post">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco" required><br>

    <label>Forma de Pagamento:</label><br>
    <select name="pagamento" required>
      <option value="">Selecione</option>
      <option value="PIX">PIX</option>
      <option value="Dinheiro">Dinheiro</option>
      <option value="Cartão">Cartão</option>
    </select><br><br>

    <button type="submit">Confirmar Pedido</button>
  </form>

  <p><a href="carrinho.php">Voltar ao Carrinho</a></p>
</main>
</body>
</html>
