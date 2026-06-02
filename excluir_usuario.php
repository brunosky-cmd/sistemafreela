<?php
session_start();
$conn = new mysqli("localhost","root","","sistema_servicos");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// 1. Deletar serviços do prestador (se for prestador)
$conn->query("DELETE FROM servicos WHERE usuario_id='$usuario_id'");

// 2. Deletar candidaturas do usuário (se houver)
$conn->query("DELETE FROM candidaturas WHERE usuario_id='$usuario_id'");

// 3. Deletar perfil específico
$conn->query("DELETE FROM perfil_prestador WHERE usuario_id='$usuario_id'");
$conn->query("DELETE FROM perfil_buscador WHERE usuario_id='$usuario_id'");

// 4. Deletar usuário
$conn->query("DELETE FROM usuarios WHERE id='$usuario_id'");

// 5. Finaliza sessão e redireciona
session_destroy();
header("Location: index.php");
exit;
?>