<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="<?php echo asset('css/loginstyle.css'); ?>">
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if($mensagem != ""): ?>
        <p style="color:red;"><?php echo e($mensagem); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Digite seu email" required>
        <input type="password" name="senha" placeholder="Digite sua senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>

    <p>Não possui conta?</p>

    <a href="<?php echo url('/cadastro'); ?>">
        <button class="btn">Cadastre-se</button>
    </a>

    <a href="<?php echo url('/home'); ?>">
        <button class="btn-voltar">Voltar </button>
    </a>
</div>

</body>
</html>

