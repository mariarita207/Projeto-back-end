<?php
$servidor = "localhost";
$usuario = "root";
$banco = "lootsy";
$senha = "";

// Cria a conexão
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica se houve erro
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>
