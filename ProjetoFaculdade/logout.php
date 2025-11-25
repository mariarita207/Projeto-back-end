<?php
session_start();

// Destrói todas as sessões
session_unset();
session_destroy();

// Redireciona para o login
header("Location: login.php");
exit();
?>
