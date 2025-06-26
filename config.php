<?php
session_start();

// Configurações do banco
$pdo = new PDO('mysql:host=localhost;dbname=marina', 'a2023953906@teiacoltec.org', 'coltec2024');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Funções úteis
function redirect($url) {
    header("Location: $url");
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['id']) || isset($_SESSION['usuario']);
}
?>