<?php
session_start();

$conn = new mysqli("localhost","root","","sistema_servicos");

$id = $_GET['id'];

/* BUSCAR SERVIÇO COM NOME DO USUÁRIO */
$sql = "SELECT servicos.*, usuarios.nome, usuarios.email
        FROM servicos
        JOIN usuarios ON servicos.usuario_id = usuarios.id
        WHERE servicos.id='$id'";

$result = $conn->query($sql);
$servico = $result->fetch_assoc();

/* VERIFICAR CANDIDATURA DO BUSCADOR */
$candidatura_status = "";

if(isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] == "buscador"){
    $buscador_id = $_SESSION['usuario_id'];

    $sql = "SELECT status FROM candidaturas
            WHERE servico_id='$id' AND buscador_id='$buscador_id'";

    $result_candidatura = $conn->query($sql);

    if($result_candidatura->num_rows > 0){
        $c = $result_candidatura->fetch_assoc();
        $candidatura_status = $c['status'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($servico['titulo']); ?></title>
<link rel="stylesheet" href="css/servico.css">
</head>
<body>

<div class="servico-container">

<div class="servico-card">

<h1><?php echo htmlspecialchars($servico['titulo']); ?></h1>

<p><b>Categoria:</b> <?php echo htmlspecialchars($servico['categoria']); ?></p>
<p><b>Modalidade:</b> <?php echo htmlspecialchars($servico['modalidade']); ?></p>
<p><b>Preço:</b> <?php echo htmlspecialchars($servico['preco']); ?></p>
<p><b>Cidade:</b> <?php echo htmlspecialchars($servico['cidade']); ?> / <?php echo htmlspecialchars($servico['uf']); ?></p>
<p><b>Prestador / Empresa:</b> <?php echo htmlspecialchars($servico['nome']); ?></p>

<p><b>Descrição:</b></p>
<p class="servico-descricao"><?php echo htmlspecialchars($servico['descricao']); ?></p>

<div class="servico-botoes">

<?php if(!isset($_SESSION['usuario_id'])): ?>
    <p style="color: #facc15; font-weight:bold;">⚠️ Faça login para se candidatar a esta vaga.</p>
<?php elseif($_SESSION['tipo_usuario']=="buscador"): ?>

    <?php if($candidatura_status == ""): ?>
        <a href="candidatar.php?servico_id=<?php echo $servico['id']; ?>">
            <button>Candidatar-se</button>
        </a>
    <?php elseif($candidatura_status == "aguardando"): ?>
        <p>⏳ Aguardando resposta do prestador</p>
    <?php elseif($candidatura_status == "recusado"): ?>
        <p>❌ Candidatura recusada</p>
    <?php elseif($candidatura_status == "aceito"): ?>
        <a href="perfil.php?id=<?php echo $servico['usuario_id']; ?>">
            <button>Ver perfil do prestador</button>
        </a>
    <?php endif; ?>

<?php endif; ?>

<a href="index.php">
    <button>Voltar</button>
</a>

</div>
</div>
</div>

</body>
</html>