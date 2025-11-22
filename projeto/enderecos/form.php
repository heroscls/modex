<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Endereco.php';
require_once __DIR__ . '/../src/Repositorio/EnderecoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /modex/projeto/login.php');
    exit;
}

$usuarioRepo = new UsuarioRepositorio($pdo);
$usuario = $usuarioRepo->buscarPorEmail($_SESSION['usuario']);

$enderecoRepo = new EnderecoRepositorio($pdo);
$endereco = null;
if (isset($_GET['id'])) {
    $endereco = $enderecoRepo->buscar((int)$_GET['id']);
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Endereço - Formulário</title>
    <link rel="stylesheet" href="/modex/projeto/css/form.css">
    <link rel="stylesheet" href="/modex/projeto/css/index.css">
</head>
<body>
<div class="container">
    <h1>Endereço</h1>
    <form action="salvar.php" method="post">
        <?php if ($endereco): ?>
            <input type="hidden" name="id" value="<?php echo $endereco->getId(); ?>">
        <?php endif; ?>
        <input type="hidden" name="usuario_id" value="<?php echo $usuario->getId(); ?>">
        <div>
            <label>Rua</label>
            <input type="text" name="rua" value="<?php echo $endereco ? $endereco->getRua() : ''; ?>" required>
        </div>
        <div>
            <label>Número</label>
            <input type="text" name="numero" value="<?php echo $endereco ? $endereco->getNumero() : ''; ?>" required>
        </div>
        <div>
            <label>Complemento</label>
            <input type="text" name="complemento" value="<?php echo $endereco ? $endereco->getComplemento() : ''; ?>">
        </div>
        <div>
            <label>Cidade</label>
            <input type="text" name="cidade" value="<?php echo $endereco ? $endereco->getCidade() : ''; ?>" required>
        </div>
        <div>
            <label>Estado</label>
            <input type="text" name="estado" value="<?php echo $endereco ? $endereco->getEstado() : ''; ?>" required>
        </div>
        <div>
            <label>CEP</label>
            <input type="text" name="cep" value="<?php echo $endereco ? $endereco->getCep() : ''; ?>" required>
        </div>
        <div>
            <button type="submit">Salvar Endereço</button>
            <a href="listar.php">Voltar</a>
        </div>
    </form>
</div>
</body>
</html>
