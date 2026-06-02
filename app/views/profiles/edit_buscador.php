<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Perfil - Buscador</title>
<link rel="stylesheet" href="<?php echo asset('css/editar_buscador.css'); ?>">
</head>
<body>

<div class="editar-container">
    <h2>Editar Perfil - Buscador</h2>

    <?php if($msg) echo "<p class='mensagem'>" . e($msg) . "</p>"; ?>

    <form method="POST">

        <label>Nome / Empresa:</label>
        <input type="text" name="nome" value="<?php echo e($usuario_nome); ?>">

        <label>Telefone:</label>
        <input type="text" name="telefone" value="<?php echo e($perfil['telefone'] ?? ''); ?>">

        <label>CEP:</label>
        <input type="text" name="cep" value="<?php echo e($perfil['cep'] ?? ''); ?>">

        <label>Rua:</label>
        <input type="text" name="rua" value="<?php echo e($perfil['rua'] ?? ''); ?>">

        <label>Bairro:</label>
        <input type="text" name="bairro" value="<?php echo e($perfil['bairro'] ?? ''); ?>">

        <label>Cidade:</label>
        <input type="text" name="cidade" value="<?php echo e($perfil['cidade'] ?? ''); ?>">

        <label>Categoria:</label>
        <input type="text" name="categoria" value="<?php echo e($perfil['categoria'] ?? ''); ?>">

        <label>Sobre mim:</label>
        <textarea name="quem_sou"><?php echo e($perfil['quem_sou'] ?? ''); ?></textarea>

        <label>Trabalho / Atividade:</label>
        <input type="text" name="trabalho" value="<?php echo e($perfil['trabalho'] ?? ''); ?>">

        <div class="perfil-extra">
            <p>
                <label>Valor por hora (R$):</label>
                <input type="number" step="0.01" name="valor_hora" value="<?php echo e($perfil['valor_hora'] ?? ''); ?>">
            </p>
            <p>
                <label>Salário CLT (R$):</label>
                <input type="number" step="0.01" name="salario" value="<?php echo e($perfil['salario'] ?? ''); ?>">
            </p>
        </div>

        <div class="editar-botoes">
            <button type="submit">Salvar Alterações</button>
            <a href="<?php echo url('/perfil?id='); ?><?php echo (int) $usuario_id; ?>">
                <button type="button" class="btn-voltar">Voltar ao perfil</button>
            </a>
        </div>
    </form>
</div>

</body>
</html>

