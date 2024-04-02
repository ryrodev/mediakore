<?php
// Inicie a sessão
session_start();

// Destrua todas as variáveis de sessão
session_destroy();

// Redirecionar para a página de login após o logout
header('Location: login.php');
exit;
?>
