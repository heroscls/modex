<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Pedido.php";
require __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";
require __DIR__ . "/../src/Repositorio/ProdutoRepositorio.php";
require __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";
require __DIR__ . "/../src/helpers.php";

$repo = new PedidoRepositorio($pdo);
$produtoRepo = new ProdutoRepositorio($pdo);
$usuarioRepo = new UsuarioRepositorio($pdo);
$pedidos = $repo->buscarTodos();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reset.css?v=<?= filemtime(__DIR__ . '/../css/reset.css') ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?= filemtime(__DIR__ . '/../css/admin.css') ?>">
    <title>Pedidos</title>
</head>
<body>
    <header class="container-admin">
        <div class="topo-direita">
            <a href="../index.php" class="botao-voltar ml-12 mr-8">Voltar ao site</a>
            <?php if (isset($_SESSION['usuario'])): ?>
            <form action="../logout.php" method="post" class="inline-form">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
            <?php endif; ?>
        </div>
        <nav class="menu-adm">
            <a href="../dashboard.php">Dashboard</a>
            <a href="listar.php">Pedidos</a>
        </nav>
    </header>
    <main>
        <h2>Lista de Pedidos</h2>
        <section class="container-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Usuário</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $p):
                        $produto = $produtoRepo->buscar($p->getProdutoId());
                        $usuario = $usuarioRepo->buscar($p->getUsuarioId());
                    ?>
                    <tr>
                        <td><?= $p->getId() ?></td>
                        <td><?= htmlspecialchars($produto ? $produto->getNome() : '—') ?></td>
                        <td><?= htmlspecialchars($usuario ? $usuario->getNome() : $p->getUsuarioId()) ?></td>
                        <td><?= $p->getQuantidade() ?></td>
                        <td><?= 'R$ ' . number_format($p->getTotal(), 2) ?></td>
                        <td><?= htmlspecialchars(formatDateTimeBR($p->getDataRegistro())) ?></td>
                        <td>
                            <a class="botao-editar" href="detalhe.php?id=<?= $p->getId() ?>">Detalhe</a>
                            <form action="excluir.php" method="post" class="inline-form ml-8">
                                <input type="hidden" name="id" value="<?= $p->getId() ?>">
                                <input type="submit" class="botao-excluir" value="Excluir">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
