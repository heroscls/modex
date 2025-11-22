<?php
session_start();
require __DIR__ . '/../src/conexao-bd.php';
require __DIR__ . '/../src/Modelo/Produto.php';
require __DIR__ . '/../src/Repositorio/ProdutoRepositorio.php';
require __DIR__ . '/../src/Repositorio/CategoriaRepositorio.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: ../index.php');
    exit;
}

$repo = new ProdutoRepositorio($pdo);
$produto = $repo->buscar($id);
if (!$produto) {
    header('Location: ../index.php');
    exit;
}

$categoriaRepo = new CategoriaRepositorio($pdo);
$categoria = null;
if (method_exists($produto, 'getCategoria_id') && $produto->getCategoria_id()) {
    $categoria = $categoriaRepo->buscar($produto->getCategoria_id());
}

// Ajusta caminho de imagem quando estamos em pasta /produtos (getImagemDiretorio retorna paths relativos ao root)
$img = $produto->getImagemDiretorio();
if (strpos($img, '../') !== 0 && strpos($img, '/') !== 0) {
    $img = '../' . $img;
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title><?= htmlspecialchars($produto->getNome()) ?> - Modex</title>
    <style>
        .detalhe-container{max-width:980px;margin:24px auto;padding:0 12px}
        .detalhe-grid{display:grid;grid-template-columns:360px 1fr;gap:20px}
        .detalhe-imagem{border:1px solid #e2e2e2;padding:12px;background:#fff}
    </style>
</head>
<body>
    <header style="padding:12px 16px;">
        <a href="../index.php"><img src="../img/logo.png" alt="Modex" style="max-width:180px;"></a>
    </header>
    <main class="detalhe-container">
        <a href="../index.php" class="botao-voltar" style="display:inline-block;margin-bottom:12px;">&larr; Voltar ao catálogo</a>
        <div class="detalhe-grid">
            <div class="detalhe-imagem">
                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($produto->getNome()) ?>" style="width:100%;height:360px;object-fit:contain;">
            </div>
            <div>
                <h1><?= htmlspecialchars($produto->getNome()) ?></h1>
                <p><strong>Tipo:</strong> <?= htmlspecialchars($produto->getTipo()) ?></p>
                <p><strong>Categoria:</strong> <?= htmlspecialchars($categoria ? $categoria->getCategoria() : '—') ?></p>
                <p><strong>Preço:</strong> <?= htmlspecialchars($produto->getPrecoFormatado()) ?></p>
                <p><strong>Descrição:</strong><br><?= nl2br(htmlspecialchars($produto->getDescricao())) ?></p>

                <div style="margin-top:18px;">
                    <a href="../index.php" class="botao-voltar" style="margin-right:8px;">Voltar</a>
                    <a class="botao-cadastrar" href="../finalizar_pedido.php?id=<?= $produto->getId() ?>">Comprar</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
