<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['tipo_usuario'] != "prestador"){
    echo "Acesso permitido apenas para prestadores.";
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

if($conn->connect_error){
    die("Erro de conexão: " . $conn->connect_error);
}

$usuario_id = $_SESSION['usuario_id'];
$mensagem = "";

/* SALVAR ALTERAÇÕES */
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = $_POST['nome'] ?? "";
    $telefone = $_POST['telefone'] ?? "";
    $cep = $_POST['cep'] ?? "";
    $rua = $_POST['rua'] ?? "";
    $bairro = $_POST['bairro'] ?? "";
    $cidade = $_POST['cidade'] ?? "";
    $quem_sou = $_POST['quem_sou'] ?? "";
    $categoria = $_POST['categoria'] ?? "";

    // Atualiza nome na tabela usuarios
    $conn->query("UPDATE usuarios SET nome='$nome' WHERE id='$usuario_id'");

    $sql = "UPDATE perfil_prestador SET
                telefone='$telefone',
                cep='$cep',
                rua='$rua',
                bairro='$bairro',
                cidade='$cidade',
                quem_sou='$quem_sou',
                categoria='$categoria'
            WHERE usuario_id='$usuario_id'";

    if($conn->query($sql)){
        $_SESSION['nome'] = $nome; // atualiza sessão
        $mensagem = "✅ Perfil atualizado com sucesso!";
    } else {
        $mensagem = "❌ Erro ao atualizar o perfil.";
    }
}

/* BUSCAR DADOS */
$sql = "SELECT * FROM perfil_prestador WHERE usuario_id='$usuario_id'";
$result = $conn->query($sql);
$dados = $result->fetch_assoc() ?? [];

// Buscar nome atual
$result_nome = $conn->query("SELECT nome FROM usuarios WHERE id='$usuario_id'");
$usuario_nome = $result_nome->fetch_assoc()['nome'] ?? '';

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Perfil - Prestador</title>
<link rel="stylesheet" href="css/editar_prestador.css">
</head>
<body>

<div class="editar-container">

<h2>Editar Perfil Prestador</h2>

<?php if($mensagem != ""): ?>
<p class="mensagem"><?php echo $mensagem; ?></p>
<?php endif; ?>

<form method="POST">

<input type="text" name="nome" placeholder="Nome / Empresa" 
value="<?php echo htmlspecialchars($usuario_nome); ?>">

<input type="text" name="telefone" placeholder="Telefone"
value="<?php echo $dados['telefone'] ?? ''; ?>">

<input type="text" name="cep" placeholder="CEP"
value="<?php echo $dados['cep'] ?? ''; ?>">

<input type="text" name="rua" placeholder="Rua"
value="<?php echo $dados['rua'] ?? ''; ?>">

<input type="text" name="bairro" placeholder="Bairro"
value="<?php echo $dados['bairro'] ?? ''; ?>">

<input type="text" name="cidade" placeholder="Cidade"
value="<?php echo $dados['cidade'] ?? ''; ?>">

<input type="text" name="categoria" placeholder="Categoria (Tecnologia, Odonto...)"
value="<?php echo $dados['categoria'] ?? ''; ?>">

<textarea name="quem_sou" placeholder="Sobre mim"><?php echo $dados['quem_sou'] ?? ''; ?></textarea>

<div class="editar-botoes">
<button type="submit">Salvar alterações</button>

<a href="perfil.php?id=<?php echo $usuario_id; ?>">
<button type="button" class="btn-voltar">Voltar ao Perfil</button>
</a>
</div>

</form>
</div>

</body>
</html>