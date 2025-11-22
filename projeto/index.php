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
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Modex - Catálogo</title>
</head>
<body>
    <header style="display:flex;align-items:center;justify-content:space-between;padding:12px 18px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="index.php"><img src="img/logo.png" alt="Modex" style="max-width:220px;"></a>
        </div>
        <div style="display:flex;gap:8px;align-items:center;">
            <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'Admin'): ?>
                <a href="dashboard.php" style="padding:8px 12px;background:#28a745;color:#fff;border-radius:4px;text-decoration:none;">Painel</a>
            <?php endif; ?>
            <a href="login.php" style="padding:8px 12px;background:#0b63c3;color:#fff;border-radius:4px;text-decoration:none;">Login</a>
            <a href="registrar.php" style="padding:8px 12px;border:1px solid #0b63c3;color:#0b63c3;border-radius:4px;text-decoration:none;">Registrar</a>
        </div>
    </header>

    <main style="padding: 0 16px 40px;">
        <h2 style="text-align:center;margin-bottom:18px;">Catálogo de Roupas</h2>

        <section class="catalogo-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;">
            <?php foreach ($produtos as $p): ?>
                <?php $img = $p->getImagemDiretorio(); ?>
                <div class="produto-card" style="border:1px solid #e2e2e2;padding:12px;border-radius:6px;text-align:center;background:#fff;">
                        <a href="detalhe_pedido.php?id=<?= $p->getId() ?>" style="color:inherit;text-decoration:none;">
                        <div style="height:160px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p->getNome()) ?>" style="max-width:100%;max-height:100%;object-fit:contain;">
                        </div>
                        <h3 style="font-size:1rem;margin:8px 0 0;"><?= htmlspecialchars($p->getNome()) ?></h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
