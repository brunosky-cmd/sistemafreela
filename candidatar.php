<?php
session_start();

$conn = new mysqli("localhost","root","","sistema_servicos");

$servico_id = $_GET['servico_id'];
$buscador_id = $_SESSION['usuario_id'];

$sql = "INSERT INTO candidaturas (servico_id,buscador_id)
VALUES ('$servico_id','$buscador_id')";

$conn->query($sql);

header("Location: servico.php?id=$servico_id");
?>