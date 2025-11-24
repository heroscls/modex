<?php
session_start();
require __DIR__ . '/src/conexao-bd.php';
require __DIR__ . '/src/Modelo/Produto.php';
require __DIR__ . '/src/Repositorio/ProdutoRepositorio.php';

$produtoRepo = new ProdutoRepositorio($pdo);
$produtos = $produtoRepo->buscarTodos();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/reset.css?v=<?= filemtime(__DIR__ . '/css/reset.css') ?>">
    <link rel="stylesheet" href="css/index.css?v=<?= filemtime(__DIR__ . '/css/index.css') ?>">
    <link rel="stylesheet" href="css/admin.css?v=<?= filemtime(__DIR__ . '/css/admin.css') ?>">
    <title>Modex - Catálogo</title>
</head>
<body>
    <header class="site-header">
        <div class="header-left">
            <a href="index.php"><img src="img/logo.png" alt="Modex" class="site-logo"></a>
        </div>
        <div class="header-right">
            <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'Admin'): ?>
                <a href="dashboard.php" class="btn-header btn-primary-header">Painel</a>
            <?php endif; ?>
            <a href="login.php" class="btn-header btn-primary-header">Login</a>
            <a href="registrar.php" class="btn-header btn-outline-header">Registrar</a>
        </div>
    </header>

    <main class="main-content">
        <h2 class="titulo-central">Catálogo de Roupas</h2>

        <section class="catalogo-grid">
            <?php foreach ($produtos as $p): ?>
                <?php $img = $p->getImagemDiretorio(); ?>
                <div class="container-produto">
                    <a href="detalhe_pedido.php?id=<?= $p->getId() ?>" class="link-reset">
                        <div class="produto-media">
                            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p->getNome()) ?>">
                        </div>
                        <div class="produto-info">
                            <h3><?= htmlspecialchars($p->getNome()) ?></h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
