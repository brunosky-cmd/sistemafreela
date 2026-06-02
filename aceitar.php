<?php
$conn = new mysqli("localhost","root","","sistema_servicos");

$id = $_GET['id'];

$sql = "UPDATE candidaturas
SET status='aceito'
WHERE id='$id'";

$conn->query($sql);

header("Location: ".$_SERVER['HTTP_REFERER']);
?>