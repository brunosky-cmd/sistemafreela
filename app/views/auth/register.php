<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link rel="stylesheet" href="<?php echo asset('css/cadastrostyle.css'); ?>">
</head>

<body>

<div class="cadastro-box">

<h2>Criar conta</h2>

<?php if($mensagem != ""): ?>

<p class="<?php echo $sucesso ? 'sucesso' : 'erro'; ?>">
<?php echo e($mensagem); ?>
</p>

<?php if($sucesso): ?>

<a href="<?php echo url('/login'); ?>">
<button class="btn">Fazer login</button>
</a>

<?php endif; ?>

<br><br>

<?php endif; ?>

<?php if(!$sucesso): ?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="senha" placeholder="Senha" required>

<select name="tipo_usuario" required>
<option value="">Selecione o tipo de usuÃ¡rio</option>
<option value="buscador">Buscador de serviÃ§o</option>
<option value="prestador">Prestador de serviÃ§o</option>
</select>

<input type="text" name="telefone" placeholder="Telefone" required>

<input type="text" name="cep" placeholder="CEP" required>

<input type="text" name="trabalho" placeholder="ProfissÃ£o / ServiÃ§o" required>

<button type="submit" class="btn">Cadastrar</button>

</form>

<?php endif; ?>

<br>

<a href="<?php echo url('/home'); ?>">
<button class="btn-voltar">Voltar ao inÃ­cio</button>
</a>

</div>

</body>
</html>

