<?php
session_start();

if (isset($_POST['quantidade'])) {
    foreach($_POST['quantidade'] as $id => $qtd) {
        $id = (int)$id;
        $qtd = (int)$qtd;
        if ($qtd > 0) {
            $_SESSION['carrinho'][$id] = $qtd;
        } else {
            unset($_SESSION['carrinho'][$id]);
        }
    }
}
header("Location: carrinho.php");
exit;
?>
