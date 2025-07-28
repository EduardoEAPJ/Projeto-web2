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
