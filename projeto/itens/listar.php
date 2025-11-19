<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Usuario.php";
require __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";
require __DIR__ . "/../src/Modelo/Item.php";
require __DIR__ . "/../src/Repositorio/ItemRepositorio.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
if (!$usuarioLogado) {
    header('Location: login.php');
    exit;
}

$itemRepositorio = new ItemRepositorio($pdo);
$itens = $itemRepositorio->buscarTodos();
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <title>Modex - Painel</title>
</head>

<body>
    <header class="container-admin">
        <div class="topo-direita">
            <span>Bem-vindo, <?php echo htmlspecialchars($usuarioLogado); ?></span>
            <form action="../logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
        <nav class="menu-adm">
            <a href="../dashboard.php">Dashboard</a>
            <a href="../itens/listar.php">Itens</a>
            <a href="../usuarios/listar.php">Usuários</a>
        </nav>
        <div class="container-admin-banner">
            <a href="../dashboard.php">
                <img src="../img/logo.png" alt="Modex" class="logo-admin">
            </a>
        </div>


    </header>
    <main>
        <h2>Lista de Itens</h2>
        <section class="container-table">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Tamanho</th>
                        <th>Cor</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Descrição</th>
                        <th>Data de Registro</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item->getNome()) ?></td>
                            <td><?= htmlspecialchars($item->getCategoria()) ?></td>
                            <td><?= htmlspecialchars($item->getTamanho()) ?></td>
                            <td><?= htmlspecialchars($item->getCor()) ?></td>
                            <td><?= htmlspecialchars($item->getPreco()) ?></td>
                            <td><?= htmlspecialchars($item->getEstoque()) ?></td>
                            <td><?= htmlspecialchars($item->getDescricao()) ?></td>
                            <td><?= htmlspecialchars($item->getDataRegistro()) ?></td>

                            <td><a class="botao-editar" href="form.php?id=<?= $item->getId() ?>">Editar</a></td>
                            <td>
                                <form action="excluir.php" method="post">
                                    <input type="hidden" name="id" value="<?= $item->getId() ?>">
                                    <input type="submit" class="botao-excluir" value="Excluir">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a class="botao-cadastrar" href="form.php">Cadastrar item</a>
            <form action="gerador-pdf.php" method="post" style="display:inline;">
                <input type="submit" class="botao-cadastrar" value="Baixar Relatório">
            </form>
        </section>
    </main>
</body>

</html>