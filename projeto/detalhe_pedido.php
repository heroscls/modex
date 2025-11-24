<?php
require __DIR__ . '/src/conexao-bd.php';
require __DIR__ . '/src/Modelo/Produto.php';
require __DIR__ . '/src/Repositorio/ProdutoRepositorio.php';
require __DIR__ . '/src/Repositorio/CategoriaRepositorio.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$repo = new ProdutoRepositorio($pdo);
$produto = $repo->buscar($id);
if (!$produto) {
    header('Location: index.php');
    exit;
}

$categoriaRepo = new CategoriaRepositorio($pdo);
$categoria = null;
if (method_exists($produto, 'getCategoria_id') && $produto->getCategoria_id()) {
    $categoria = $categoriaRepo->buscar($produto->getCategoria_id());
}

$img = $produto->getImagemDiretorio();
if (strpos($img, '/') !== 0 && strpos($img, '..') !== 0) {
    // paths returned are relative to project root, so ensure correct
    $img = $img;
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/reset.css?v=<?= filemtime(__DIR__ . '/css/reset.css') ?>">
    <link rel="stylesheet" href="css/form.css?v=<?= filemtime(__DIR__ . '/css/form.css') ?>">
    <link rel="stylesheet" href="css/admin.css?v=<?= filemtime(__DIR__ . '/css/admin.css') ?>">
    <title><?= htmlspecialchars($produto->getNome()) ?> - Modex</title>
</head>
<body>
    <header class="site-header">
        <a href="index.php"><img src="img/logo.png" alt="Modex" class="site-logo"></a>
    </header>
    <main class="detalhe-container">
        <a href="index.php" class="botao-voltar">&larr; Voltar ao catálogo</a>
        <div class="detalhe-grid">
            <div class="detalhe-imagem">
                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($produto->getNome()) ?>">
            </div>
            <div>
                <h1><?= htmlspecialchars($produto->getNome()) ?></h1>
                <p><strong>Tipo:</strong> <?= htmlspecialchars($produto->getTipo()) ?></p>
                <p><strong>Categoria:</strong> <?= htmlspecialchars($categoria ? $categoria->getCategoria() : '—') ?></p>
                <p><strong>Preço:</strong> <?= htmlspecialchars($produto->getPrecoFormatado()) ?></p>
                <p><strong>Descrição:</strong><br><?= nl2br(htmlspecialchars($produto->getDescricao())) ?></p>

                <div class="mt-18">
                    <a href="index.php" class="botao-voltar mr-8">Voltar</a>
                    <a class="botao-cadastrar" href="finalizar_pedido.php?id=<?= $produto->getId() ?>">Comprar</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
