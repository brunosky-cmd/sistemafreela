<?php
session_start();

$mensagem = ""; // para exibir erro

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $banco = "sistema_servicos";

    $conn = new mysqli($host, $user, $pass, $banco);
    if($conn->connect_error){
        die("Erro de conexão: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
        $_SESSION['email'] = $row['email'];

        header("Location: index.php");
        exit;

    } else {
        $mensagem = "Email ou senha incorretos.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if($mensagem != ""): ?>
        <p style="color:red;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Digite seu email" required>
        <input type="password" name="senha" placeholder="Digite sua senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>

    <p>Não possui conta?</p>

    <a href="cadastro.php">
        <button class="btn">Cadastre-se</button>
    </a>

    <a href="index.php">
        <button class="btn-voltar">Voltar </button>
    </a>
</div>

</body>
</html>