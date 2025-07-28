<?php
require_once 'database.php';

$db = new Database();

$produtos = $db->select("SELECT id, nome, preco, imagem FROM produtos");
?>
