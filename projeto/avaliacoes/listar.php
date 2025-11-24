<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Avaliacao.php";
require __DIR__ . "/../src/Repositorio/AvaliacaoRepositorio.php";
require __DIR__ . "/../src/Repositorio/ProdutoRepositorio.php";
require __DIR__ . "/../src/helpers.php";

$repo = new AvaliacaoRepositorio($pdo);
$produtoRepo = new ProdutoRepositorio($pdo);
$avaliacoes = $repo->buscarTodos();

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reset.css?v=<?= filemtime(__DIR__ . '/../css/reset.css') ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?= filemtime(__DIR__ . '/../css/admin.css') ?>">
    <title>Avaliações</title>
</head>
<body>
    <header class="container-admin">
        <nav class="menu-adm">
            <a href="../dashboard.php">Dashboard</a>
            <a href="listar.php">Avaliações</a>
        </nav>
    </header>
    <main>
        <h2>Lista de Avaliações</h2>
        <section class="container-table">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Usuário ID</th>
                        <th>Nota</th>
                        <th>Comentário</th>
                        <th>Data</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($avaliacoes as $avaliacao):
                        $produto = $produtoRepo->buscar($avaliacao->getProdutoId());
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($produto ? $produto->getNome() : '—') ?></td>
                        <td><?= htmlspecialchars($avaliacao->getUsuarioId()) ?></td>
                        <td><?= htmlspecialchars($avaliacao->getNota()) ?></td>
                        <td><?= htmlspecialchars($avaliacao->getComentario()) ?></td>
                        <td><?= htmlspecialchars(formatDateTimeBR($avaliacao->getDataRegistro())) ?></td>
                        <td><a class="botao-editar" href="form.php?id=<?= $avaliacao->getId() ?>">Editar</a></td>
                        <td>
                            <form action="excluir.php" method="post">
                                <input type="hidden" name="id" value="<?= $avaliacao->getId() ?>">
                                <input type="submit" class="botao-excluir" value="Excluir">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a class="botao-cadastrar" href="form.php">Cadastrar avaliação</a>
            <form action="gerador-pdf.php" method="post" class="inline-form ml-8">
                <input type="submit" class="botao-cadastrar" value="Baixar Relatório">
            </form>
        </section>
    </main>
</body>
</html>
