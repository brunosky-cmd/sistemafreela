<?php
session_start();

// Verifica se está logado e é buscador
if(!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != "buscador"){
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

$usuario_id = $_SESSION['usuario_id'];

// Atualizar perfil se o formulário foi enviado
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $rua = $_POST['rua'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $quem_sou = $_POST['quem_sou'] ?? '';
    $trabalho = $_POST['trabalho'] ?? '';
    $valor_hora = $_POST['valor_hora'] ?? '';
    $salario = $_POST['salario'] ?? '';

    // Atualiza nome na tabela usuarios
    $conn->query("UPDATE usuarios SET nome='$nome' WHERE id='$usuario_id'");

    $sql = "UPDATE perfil_buscador SET 
                telefone='$telefone',
                cep='$cep',
                rua='$rua',
                bairro='$bairro',
                cidade='$cidade',
                categoria='$categoria',
                quem_sou='$quem_sou',
                trabalho='$trabalho',
                valor_hora='$valor_hora',
                salario='$salario'
            WHERE usuario_id='$usuario_id'";

    if($conn->query($sql)){
        $_SESSION['nome'] = $nome; // atualiza sessão
        $msg = "✅ Perfil atualizado com sucesso!";
    } else {
        $msg = "❌ Erro ao atualizar: " . $conn->error;
    }
}

// Buscar dados atuais do perfil
$result = $conn->query("SELECT * FROM perfil_buscador WHERE usuario_id='$usuario_id'");
$perfil = $result->fetch_assoc() ?? [];

// Buscar nome atual
$result_nome = $conn->query("SELECT nome FROM usuarios WHERE id='$usuario_id'");
$usuario_nome = $result_nome->fetch_assoc()['nome'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Perfil - Buscador</title>
<link rel="stylesheet" href="css/editar_buscador.css">
</head>
<body>

<div class="editar-container">
    <h2>Editar Perfil - Buscador</h2>

    <?php if(isset($msg)) echo "<p class='mensagem'>$msg</p>"; ?>

    <form method="POST">

        <label>Nome / Empresa:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario_nome); ?>">

        <label>Telefone:</label>
        <input type="text" name="telefone" value="<?php echo htmlspecialchars($perfil['telefone']); ?>">

        <label>CEP:</label>
        <input type="text" name="cep" value="<?php echo htmlspecialchars($perfil['cep']); ?>">

        <label>Rua:</label>
        <input type="text" name="rua" value="<?php echo htmlspecialchars($perfil['rua']); ?>">

        <label>Bairro:</label>
        <input type="text" name="bairro" value="<?php echo htmlspecialchars($perfil['bairro']); ?>">

        <label>Cidade:</label>
        <input type="text" name="cidade" value="<?php echo htmlspecialchars($perfil['cidade']); ?>">

        <label>Categoria:</label>
        <input type="text" name="categoria" value="<?php echo htmlspecialchars($perfil['categoria']); ?>">

        <label>Sobre mim:</label>
        <textarea name="quem_sou"><?php echo htmlspecialchars($perfil['quem_sou']); ?></textarea>

        <label>Trabalho / Atividade:</label>
        <input type="text" name="trabalho" value="<?php echo htmlspecialchars($perfil['trabalho']); ?>">

        <div class="perfil-extra">
            <p>
                <label>Valor por hora (R$):</label>
                <input type="number" step="0.01" name="valor_hora" value="<?php echo htmlspecialchars($perfil['valor_hora']); ?>">
            </p>
            <p>
                <label>Salário CLT (R$):</label>
                <input type="number" step="0.01" name="salario" value="<?php echo htmlspecialchars($perfil['salario']); ?>">
            </p>
        </div>

        <div class="editar-botoes">
            <button type="submit">Salvar Alterações</button>
            <a href="perfil.php?id=<?php echo $usuario_id; ?>">
                <button type="button" class="btn-voltar">Voltar ao perfil</button>
            </a>
        </div>
    </form>
</div>

</body>
</html>