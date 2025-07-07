<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [
        1 => [
            "nome" => "Açaí de 300ml",
            "preco" => 20.00,
            "imagem" => "imagem/acai_300ml.jpg"
        ],
        2 => [
            "nome" => "Açaí 400ml",
            "preco" => 24.00,
            "imagem" => "imagem/acai_400ml.jpg"
        ],
        3 => [
            "nome" => "Açaí 500ml",
            "preco" => 28.00,
            "imagem" => "imagem/acai_500ml.jpg"
        ],
    ];
}
?>
