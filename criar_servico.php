<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['tipo_usuario'] != "prestador"){
    echo "<p style='color:red; font-weight:bold;'>Apenas prestadores podem criar serviços.</p>";
    exit;
}

$conn = new mysqli("localhost","root","","sistema_servicos");

$mensagem = "";
$tipo_mensagem = ""; // 'sucesso' ou 'erro'

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $modalidade = $_POST['modalidade'];
    $preco = $_POST['preco'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    $usuario_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO servicos (usuario_id, titulo, descricao, categoria, modalidade, preco, cidade, uf)
            VALUES ('$usuario_id','$titulo','$descricao','$categoria','$modalidade','$preco','$cidade','$uf')";

    if($conn->query($sql)){
        $mensagem = "Serviço publicado com sucesso!";
        $tipo_mensagem = "sucesso";
    } else {
        $mensagem = "Erro ao publicar serviço: " . $conn->error;
        $tipo_mensagem = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Criar serviço</title>
<link rel="stylesheet" href="css/criar_servico.css">
</head>

<body>

<div class="cadastro-box">

<h2>Criar Serviço</h2>

<?php if($mensagem != ""): ?>
<div class="mensagem <?php echo $tipo_mensagem; ?>">
    <?php echo $mensagem; ?>
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

<a href="index.php">
    <button class="btn-voltar">Voltar</button>
</a>

</div>

</body>
</html>