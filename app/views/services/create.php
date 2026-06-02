<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Criar serviço</title>
<link rel="stylesheet" href="<?php echo asset('css/criar_servico.css'); ?>">
</head>

<body>

<div class="cadastro-box">

<h2>Criar Serviço</h2>

<?php if($mensagem != ""): ?>
<div class="mensagem <?php echo e($tipo_mensagem); ?>">
    <?php echo e($mensagem); ?>
</div>
<?php endif; ?>

<form method="POST">

    <input type="text" name="titulo" placeholder="Título do serviço" required>
    <input type="text" name="categoria" placeholder="Área (Tecnologia, Odonto...)" required>

    <select name="modalidade" required>
        <option value="">Modalidade</option>
        <option value="Presencial">Presencial</option>
        <option value="Remoto">Remoto</option>
        <option value="Híbrido">Híbrido</option>
    </select>

    <input type="text" name="preco" placeholder="Preço ou 'A combinar'">
    <input type="text" name="cidade" placeholder="Cidade do serviço" required>
    <input type="text" name="uf" placeholder="UF (ex: SP, RJ)" maxlength="2" required>
    <textarea name="descricao" placeholder="Descrição do serviço"></textarea>
    <button class="btn" type="submit">Publicar serviço</button>

</form>

<br>

<a href="<?php echo url('/home'); ?>">
    <button class="btn-voltar">Voltar</button>
</a>

</div>

</body>
</html>

