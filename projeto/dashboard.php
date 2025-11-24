<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
$usuarioLogado = $_SESSION['usuario'] ?? null;
if (!$usuarioLogado) {
    header('Location: login.php');
    exit;
}
// Restrict dashboard access to administrators only
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'Admin') {
    header('Location: index.php');
    exit;
}

function pode(string $perm): bool
{
    return in_array($perm, $_SESSION['permissoes'] ?? [], true);
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Modex</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/reset.css?v=<?= filemtime(__DIR__ . '/css/reset.css') ?>">
    <link rel="stylesheet" href="css/admin.css?v=<?= filemtime(__DIR__ . '/css/admin.css') ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= filemtime(__DIR__ . '/css/dashboard.css') ?>">
</head>

<body class="pagina-dashboard">
<header class="container-admin">
    <div class="topo-direita">
        <span>Bem-vindo, <?php echo htmlspecialchars($usuarioLogado); ?></span>
        <a href="index.php" class="botao-voltar ml-12 mr-8">Voltar ao site</a>
        <form action="logout.php" method="post" class="inline-form">
            <button type="submit" class="botao-sair">Sair</button>
        </form>
    </div>
    <nav class="menu-adm">
        <a href="dashboard.php">Dashboard</a>
        <a href="produtos/listar.php">Produtos</a>
        <a href="avaliacoes/listar.php">Avaliações</a>
        <a href="pedidos/listar.php">Pedidos</a>
        <?php if (pode('usuarios.listar')): ?>
        <a href="usuarios/listar.php">Usuários</a>
        <?php endif; ?>
    </nav>
    <div class="container-admin-banner">
                    <a href="dashboard.php">
            <img src="img/logo.png" alt="Modex" class="logo-admin">
        </a>
    </div>


</header>
    <main class="dashboard">
        <h1 class="titulo-dashboard">Dashboard</h1>
        <section class="cards-container">
            <?php if (pode('usuarios.listar')): ?>
                <a class="card card-usuarios" href="usuarios/listar.php">
                    <h2>Usuários</h2>
                    <p>Gerenciar e cadastrar usuários.</p>
                </a>
            <?php endif; ?>
            <?php if (pode('produtos.listar')): ?>
                <a class="card card-itens" href="produtos/listar.php">
                    <h2>Produtos</h2>
                    <p>Listar e gerenciar produtos.</p>
                </a>
            <?php endif; ?>
            <a class="card card-avaliacoes" href="avaliacoes/listar.php">
                <h2>Avaliações</h2>
                <p>Listar e gerenciar avaliações dos produtos.</p>
            </a>
            <a class="card card-pedidos" href="pedidos/listar.php">
                <h2>Pedidos</h2>
                <p>Listar e gerenciar pedidos realizados.</p>
            </a>
        </section>
    </main>
</body>

</html>