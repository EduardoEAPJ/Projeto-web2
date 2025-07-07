<?php
session_start();
require 'produtos.php';

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}


if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    if (isset($_SESSION['produtos'][$id])) {
        if (!isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] = 1;
        } else {
            $_SESSION['carrinho'][$id]++;
        }
    }
    header("Location: carrinho.php");
    exit;
}


if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    unset($_SESSION['carrinho'][$id]);
    header("Location: carrinho.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Carrinho - Açaí do Mamute</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header>
  <h1>Seu Carrinho</h1>
</header>
<main>
  <?php if (empty($_SESSION['carrinho'])): ?>
    <p>O carrinho está vazio.</p>
  <?php else: ?>
    <form action="atualiza_carrinho.php" method="post">
      <table>
        <tr><th>Produto</th><th>Quantidade</th><th>Preço</th><th>Subtotal</th><th>Ações</th></tr>
        <?php
        $total = 0;
        foreach($_SESSION['carrinho'] as $id => $qtd):
            $produto = $_SESSION['produtos'][$id];
            $subtotal = $produto['preco'] * $qtd;
            $total += $subtotal;
        ?>
        <tr>
          <td><?= htmlspecialchars($produto['nome']) ?></td>
          <td><input type="number" name="quantidade[<?= $id ?>]" value="<?= $qtd ?>" min="1"></td>
          <td>R$ <?= number_format($produto['preco'],2,",",".") ?></td>
          <td>R$ <?= number_format($subtotal,2,",",".") ?></td>
          <td><a href="?remove=<?= $id ?>">Remover</a></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <p><strong>Total: R$ <?= number_format($total,2,",",".") ?></strong></p>
      <button type="submit">Atualizar Quantidades</button>
      <a href="checkout.php" class="btn">Finalizar Compra</a>

    </form>
  <?php endif; ?>
  <p><a href="index.php">Continuar Comprando</a></p>
</main>
</body>
</html>
