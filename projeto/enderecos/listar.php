<?php
require_once __DIR__ . '/../src/conexao-bd.php';
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
$enderecos = $enderecoRepo->buscarPorUsuario($usuario->getId());

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Meus Endereços</title>
    <link rel="stylesheet" href="/modex/projeto/css/index.css">
</head>
<body>
<div class="container">
    <h1>Meus Endereços</h1>
    <a href="form.php">Adicionar novo</a>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Rua</th>
            <th>Número</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>CEP</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($enderecos as $e): ?>
            <tr>
                <td><?php echo $e->getId(); ?></td>
                <td><?php echo htmlspecialchars($e->getRua()); ?></td>
                <td><?php echo htmlspecialchars($e->getNumero()); ?></td>
                <td><?php echo htmlspecialchars($e->getCidade()); ?></td>
                <td><?php echo htmlspecialchars($e->getEstado()); ?></td>
                <td><?php echo htmlspecialchars($e->getCep()); ?></td>
                <td>
                    <a href="form.php?id=<?php echo $e->getId(); ?>">Editar</a>
                    <a href="excluir.php?id=<?php echo $e->getId(); ?>" onclick="return confirm('Excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/modex/projeto/dashboard.php">Voltar ao painel</a>
</div>
</body>
</html>
