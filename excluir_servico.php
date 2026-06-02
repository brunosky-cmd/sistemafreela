<?php
session_start();

$conn = new mysqli("localhost","root","","sistema_servicos");

$id = $_GET['id'];

$sql = "DELETE FROM servicos WHERE id='$id'";

$conn->query($sql);

header("Location: meus_servicos.php");
exit;
?>