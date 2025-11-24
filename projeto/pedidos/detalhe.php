<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['perfil'] ?? '') !== 'Admin') {
    header('Location: ../index.php');
    exit;
}

require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Pedido.php";
require __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";
require __DIR__ . "/../src/Repositorio/ProdutoRepositorio.php";
require __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";
require __DIR__ . "/../src/Repositorio/EnderecoRepositorio.php";
require __DIR__ . "/../src/helpers.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: listar.php');
    exit;
}

$repo = new PedidoRepositorio($pdo);
$pedido = $repo->buscar($id);
if (!$pedido) {
    header('Location: listar.php');
    exit;
}

$produtoRepo = new ProdutoRepositorio($pdo);
$usuarioRepo = new UsuarioRepositorio($pdo);
$enderecoRepo = new EnderecoRepositorio($pdo);

$produto = $produtoRepo->buscar($pedido->getProdutoId());
$usuario = $usuarioRepo->buscar($pedido->getUsuarioId());
$endereco = $pedido->getEnderecoId() ? $enderecoRepo->buscar($pedido->getEnderecoId()) : null;

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reset.css?v=<?= filemtime(__DIR__ . '/../css/reset.css') ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?= filemtime(__DIR__ . '/../css/admin.css') ?>">
    <title>Detalhe do Pedido #<?= htmlspecialchars($pedido->getId()) ?></title>
    <style>
        .detalhe-wrap{max-width:900px;margin:28px auto;padding:12px}
        .card{border:1px solid #e2e2e2;padding:16px;background:#fff;border-radius:6px}
        .media{display:flex;gap:16px}
        .media img{max-width:220px;max-height:220px;object-fit:contain}
    </style>
</head>
<body>
    <main class="detalhe-wrap">
        <a href="listar.php" class="botao-voltar">&larr; Voltar</a>
        <h2>Pedido #<?= htmlspecialchars($pedido->getId()) ?></h2>
        <div class="card">
            <div class="media">
                <div>
                    <?php if ($produto): ?>
                        <img src="<?= htmlspecialchars($produto->getImagemDiretorio()) ?>" alt="<?= htmlspecialchars($produto->getNome()) ?>">
                    <?php endif; ?>
                </div>
                <div>
                    <h3>Produto</h3>
                    <p><strong>Nome:</strong> <?= htmlspecialchars($produto ? $produto->getNome() : '—') ?></p>
                    <p><strong>Preço unitário:</strong> <?= htmlspecialchars($produto ? $produto->getPrecoFormatado() : '—') ?></p>
                    <p><strong>Quantidade:</strong> <?= htmlspecialchars($pedido->getQuantidade()) ?></p>
                    <p><strong>Total:</strong> <?= 'R$ ' . number_format($pedido->getTotal(), 2) ?></p>
                    <p><strong>Data:</strong> <?= htmlspecialchars(formatDateTimeBR($pedido->getDataRegistro())) ?></p>
                </div>
            </div>
            <hr>
            <h3>Cliente</h3>
            <p><strong>Nome:</strong> <?= htmlspecialchars($usuario ? $usuario->getNome() : $pedido->getUsuarioId()) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario ? $usuario->getEmail() : '') ?></p>

            <?php if ($endereco): ?>
                <hr>
                <h3>Endereço de entrega</h3>
                <p><?= htmlspecialchars($endereco->formatar()) ?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
