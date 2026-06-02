<?php
session_start();

$conn = new mysqli("localhost","root","","sistema_servicos");

// Verifica se está logado
if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$usuario_id_logado = $_SESSION['usuario_id'];
$tipo_usuario_logado = $_SESSION['tipo_usuario'];

// ID do perfil a ser exibido: se não vier na URL, mostra o do logado
$id = isset($_GET['id']) ? intval($_GET['id']) : $usuario_id_logado;

// Busca usuário
$result_usuario = $conn->query("SELECT * FROM usuarios WHERE id='$id'");
$usuario = $result_usuario->fetch_assoc();

// Determina tabela de perfil
if($usuario['tipo_usuario'] == 'prestador'){
    $result_perfil = $conn->query("SELECT * FROM perfil_prestador WHERE usuario_id='$id'");
} else {
    $result_perfil = $conn->query("SELECT * FROM perfil_buscador WHERE usuario_id='$id'");
}

$perfil = $result_perfil->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Perfil de <?php echo htmlspecialchars($usuario['nome'] ?: $usuario['email']); ?></title>
<link rel="stylesheet" href="css/perfil.css">
</head>
<body>

<div class="perfil-container">

<h2>Perfil de <?php echo htmlspecialchars($usuario['nome'] ?: $usuario['email']); ?> (<?php echo ucfirst($usuario['tipo_usuario']); ?>)</h2>

<p><b>Email:</b> <?php echo htmlspecialchars($usuario['email']); ?></p>

<?php if($usuario['tipo_usuario'] == 'prestador'): ?>
    <p><b>Nome / Empresa:</b> <?php echo htmlspecialchars($usuario['nome']); ?></p>
    <p><b>Categoria:</b> <?php echo htmlspecialchars($perfil['categoria']); ?></p>
    <p><b>Telefone:</b> <?php echo htmlspecialchars($perfil['telefone']); ?></p>
    <p><b>Cidade:</b> <?php echo htmlspecialchars($perfil['cidade']); ?></p>
    <p><b>Bairro:</b> <?php echo htmlspecialchars($perfil['bairro']); ?></p>
    <p><b>Rua:</b> <?php echo htmlspecialchars($perfil['rua']); ?></p>
    <p><b>Sobre mim/nós:</b></p>
    <p class="perfil-sobre"><?php echo htmlspecialchars($perfil['quem_sou']); ?></p>

<?php else: // buscador ?>
    <p><b>Nome / Empresa:</b> <?php echo htmlspecialchars($usuario['nome']); ?></p>
    <p><b>Telefone:</b> <?php echo htmlspecialchars($perfil['telefone']); ?></p>
    <p><b>CEP:</b> <?php echo htmlspecialchars($perfil['cep']); ?></p>
    <p><b>Rua:</b> <?php echo htmlspecialchars($perfil['rua']); ?></p>
    <p><b>Bairro:</b> <?php echo htmlspecialchars($perfil['bairro']); ?></p>
    <p><b>Cidade:</b> <?php echo htmlspecialchars($perfil['cidade']); ?></p>
    <p><b>Categoria:</b> <?php echo htmlspecialchars($perfil['categoria']); ?></p>
    <p><b>Sobre mim:</b></p>
    <p class="perfil-sobre"><?php echo htmlspecialchars($perfil['quem_sou']); ?></p>
    <p><b>Trabalho / Atividade:</b> <?php echo htmlspecialchars($perfil['trabalho']); ?></p>
    <p><b>Valor por hora (R$):</b> <?php echo htmlspecialchars($perfil['valor_hora']); ?></p>
    <p><b>Salário CLT (R$):</b> <?php echo htmlspecialchars($perfil['salario']); ?></p>
<?php endif; ?>

<div class="perfil-botoes">
<?php if($usuario_id_logado == $id): ?>
    <?php if($tipo_usuario_logado == 'prestador'): ?>
        <a href="editar_prestador.php"><button>Editar perfil</button></a>
        <a href="meus_servicos.php"><button>Meus serviços</button></a>
    <?php else: ?>
        <a href="editar_buscador.php"><button>Editar perfil</button></a>
        <a href="minhas_candidaturas.php"><button>Minhas Candidaturas</button></a>
    <?php endif; ?>
    <!-- Botão Excluir Perfil -->
    <a href="excluir_usuario.php" onclick="return confirm('Tem certeza que deseja excluir seu perfil? Esta ação não pode ser desfeita.')">
        <button class="btn-excluir">Excluir perfil</button>
    </a>

<?php endif; ?>

<a href="index.php"><button class="btn-voltar">Voltar ao início</button></a>
</div>

</div>
</body>
</html>