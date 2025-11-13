<?php
$host = "localhost";
$usuario = "root";
$senha = ""; // senha em branco no XAMPP
$banco = "lootsy"; // mesmo nome do banco que você importou

$conexao = mysqli_connect("localhost", "root", "", "lootsy");

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>
