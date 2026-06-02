<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

$id = $_GET['id'];

// Buscar serviço
$sql = "SELECT * FROM servicos WHERE id='$id'";
$result = $conn->query($sql);
$servico = $result->fetch_assoc();

$mensagem = "";

// Atualizar serviço
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $modalidade = $_POST['modalidade'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    $sql = "UPDATE servicos SET
                titulo='$titulo',
                categoria='$categoria',
                modalidade='$modalidade',
                preco='$preco',
                descricao='$descricao',
                cidade='$cidade',
                uf='$uf'
            WHERE id='$id'";

    if($conn->query($sql)){
        $mensagem = "Serviço atualizado!";
        // Atualiza os dados do formulário com os valores mais recentes
        $servico = array_merge($servico, $_POST);
    } else {
        $mensagem = "Erro ao atualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar serviço</title>
<link rel="stylesheet" href="css/criar_servico.css">
</head>
<body>

<div class="cadastro-box">

<h2>Editar serviço</h2>

<?php if($mensagem != ""): ?>
<div class="mensagem sucesso"><?php echo $mensagem; ?></div>
<?php endif; ?>

<form method="POST">

    <input type="text" name="titulo" placeholder="Título do serviço" value="<?php echo htmlspecialchars($servico['titulo']); ?>" required>

    <input type="text" name="categoria" placeholder="Área (Tecnologia, Odonto...)" value="<?php echo htmlspecialchars($servico['categoria']); ?>" required>

    <select name="modalidade" required>
        <option value="Presencial" <?php if($servico['modalidade']=="Presencial") echo "selected"; ?>>Presencial</option>
        <option value="Remoto" <?php if($servico['modalidade']=="Remoto") echo "selected"; ?>>Remoto</option>
        <option value="Híbrido" <?php if($servico['modalidade']=="Híbrido") echo "selected"; ?>>Híbrido</option>
    </select>

    <input type="text" name="preco" placeholder="Preço ou 'A combinar'" value="<?php echo htmlspecialchars($servico['preco']); ?>">

    <input type="text" name="cidade" placeholder="Cidade" value="<?php echo htmlspecialchars($servico['cidade']); ?>">

    <input type="text" name="uf" placeholder="UF" value="<?php echo htmlspecialchars($servico['uf']); ?>">

    <textarea name="descricao" placeholder="Descrição do serviço"><?php echo htmlspecialchars($servico['descricao']); ?></textarea>

    <button class="btn" type="submit">Salvar alterações</button>

</form>

<br>

<a href="meus_servicos.php">
    <button class="btn-voltar">Voltar</button>
</a>

</div>

</body>
</html>