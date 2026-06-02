<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Perfil - Prestador</title>
<link rel="stylesheet" href="<?php echo asset('css/editar_prestador.css'); ?>">
</head>
<body>

<div class="editar-container">

<h2>Editar Perfil Prestador</h2>

<?php if($mensagem != ""): ?>
<p class="mensagem"><?php echo e($mensagem); ?></p>
<?php endif; ?>

<form method="POST">

<input type="text" name="nome" placeholder="Nome / Empresa"
value="<?php echo e($usuario_nome); ?>">

<input type="text" name="telefone" placeholder="Telefone"
value="<?php echo e($dados['telefone'] ?? ''); ?>">

<input type="text" name="cep" placeholder="CEP"
value="<?php echo e($dados['cep'] ?? ''); ?>">

<input type="text" name="rua" placeholder="Rua"
value="<?php echo e($dados['rua'] ?? ''); ?>">

<input type="text" name="bairro" placeholder="Bairro"
value="<?php echo e($dados['bairro'] ?? ''); ?>">

<input type="text" name="cidade" placeholder="Cidade"
value="<?php echo e($dados['cidade'] ?? ''); ?>">

<input type="text" name="categoria" placeholder="Categoria (Tecnologia, Odonto...)"
value="<?php echo e($dados['categoria'] ?? ''); ?>">

<textarea name="quem_sou" placeholder="Sobre mim"><?php echo e($dados['quem_sou'] ?? ''); ?></textarea>

<div class="editar-botoes">
<button type="submit">Salvar alterações</button>

<a href="<?php echo url('/perfil?id='); ?><?php echo (int) $usuario_id; ?>">
<button type="button" class="btn-voltar">Voltar ao Perfil</button>
</a>
</div>

</form>
</div>

</body>
</html>

