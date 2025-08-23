<?php
// Inicia sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_user'])) {
    // Redireciona para login se não estiver logado
    header("Location: /formulario/src/views/login.php?error=Você precisa fazer login");
    exit;
}
