<?php
include 'conexao.php';

$termo = $_GET['termo'] ?? '';

$sql = "SELECT * FROM cadastro WHERE nome LIKE '%$termo%' ORDER BY nome ASC";
$result = mysqli_query($conexao, $sql);

$usuarios = [];

while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
?>
