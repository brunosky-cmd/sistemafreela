<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar serviço</title>
<link rel="stylesheet" href="<?php echo asset('css/criar_servico.css'); ?>">
</head>
<body>

<div class="cadastro-box">

<h2>Editar serviço</h2>

<?php if($mensagem != ""): ?>
<div class="mensagem sucesso"><?php echo e($mensagem); ?></div>
<?php endif; ?>

<form method="POST">

    <input type="text" name="titulo" placeholder="Título do serviço" value="<?php echo e($servico['titulo']); ?>" required>
    <input type="text" name="categoria" placeholder="Área (Tecnologia, Odonto...)" value="<?php echo e($servico['categoria']); ?>" required>

    <select name="modalidade" required>
        <option value="Presencial" <?php if($servico['modalidade']=="Presencial") echo "selected"; ?>>Presencial</option>
        <option value="Remoto" <?php if($servico['modalidade']=="Remoto") echo "selected"; ?>>Remoto</option>
        <option value="Híbrido" <?php if(modalidadeLabel($servico['modalidade'])=="Híbrido") echo "selected"; ?>>Híbrido</option>
    </select>

    <input type="text" name="preco" placeholder="Preço ou 'A combinar'" value="<?php echo e($servico['preco']); ?>">
    <input type="text" name="cidade" placeholder="Cidade" value="<?php echo e($servico['cidade']); ?>">
    <input type="text" name="uf" placeholder="UF" value="<?php echo e($servico['uf']); ?>">
    <textarea name="descricao" placeholder="Descrição do serviço"><?php echo e($servico['descricao']); ?></textarea>
    <button class="btn" type="submit">Salvar alterações</button>

</form>

<br>

<a href="<?php echo url('/vagas/minhas'); ?>">
    <button class="btn-voltar">Voltar</button>
</a>

</div>

</body>
</html>

