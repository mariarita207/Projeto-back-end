<?php
$servidor = "localhost";
$usuario = "root";
$banco = "lootsy";
$senha = "";

$conexao = new mysqli($servidor,$usuario,$senha,$banco);

if($conexao->connect_error){
    echo("Erro de conexão");
}



?>
