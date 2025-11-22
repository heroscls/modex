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
require __DIR__ . "/../src/Repositorio/EnderecoRepositorio.php";

$repo = new PedidoRepositorio($pdo);
$produtoRepo = new ProdutoRepositorio($pdo);
$usuarioRepo = new UsuarioRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$pedido = null;
$modoEdicao = false;
if ($id) {
    $pedido = $repo->buscar($id);
    if ($pedido) $modoEdicao = true;
}

$produtos = $produtoRepo->buscarTodos();
$usuarios = $usuarioRepo->buscarTodos();
$enderecos = (new EnderecoRepositorio($pdo))->buscarTodos();

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/form.css">
    <title><?= $modoEdicao ? 'Editar Pedido' : 'Cadastrar Pedido' ?></title>
</head>
<body>
    <main>
        <h2><?= $modoEdicao ? 'Editar Pedido' : 'Cadastrar Pedido' ?></h2>
        <form action="salvar.php" method="post">
            <?php if ($modoEdicao): ?>
                <input type="hidden" name="id" value="<?= $pedido->getId() ?>">
            <?php endif; ?>
            <div>
                <label for="produto_id">Produto</label>
                <select id="produto_id" name="produto_id" required>
                    <option value="">Escolha</option>
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p->getId() ?>" <?= $modoEdicao && $pedido->getProdutoId() == $p->getId() ? 'selected' : '' ?>><?= htmlspecialchars($p->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="usuario_id">Usuário</label>
                <select id="usuario_id" name="usuario_id">
                    <option value="">Escolha</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= $u->getId() ?>" <?= $modoEdicao && $pedido->getUsuarioId() == $u->getId() ? 'selected' : '' ?>><?= htmlspecialchars($u->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="endereco_id">Endereço</label>
                <select id="endereco_id" name="endereco_id">
                    <option value="">Nenhum</option>
                    <?php foreach ($enderecos as $e): ?>
                        <option value="<?= $e->getId() ?>" <?= $modoEdicao && $pedido->getEnderecoId() == $e->getId() ? 'selected' : '' ?>><?= htmlspecialchars($e->formatar()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="quantidade">Quantidade</label>
                <input id="quantidade" name="quantidade" type="number" min="1" value="<?= $modoEdicao ? $pedido->getQuantidade() : 1 ?>">
            </div>
            <div>
                <label for="total">Total</label>
                <input id="total" name="total" type="text" value="<?= $modoEdicao ? $pedido->getTotal() : '' ?>">
            </div>
            <div class="grupo-botoes">
                <button type="submit" class="botao-cadastrar">Salvar</button>
                <a href="listar.php" class="botao-voltar">Voltar</a>
            </div>
        </form>
    </main>
</body>
</html>
