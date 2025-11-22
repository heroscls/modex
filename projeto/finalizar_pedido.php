<?php
require __DIR__ . '/src/conexao-bd.php';
require __DIR__ . '/src/Modelo/Produto.php';
require __DIR__ . '/src/Repositorio/ProdutoRepositorio.php';
require __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
require __DIR__ . '/src/Modelo/Pedido.php';
require __DIR__ . '/src/Repositorio/PedidoRepositorio.php';
require __DIR__ . '/src/Modelo/Endereco.php';
require __DIR__ . '/src/Repositorio/EnderecoRepositorio.php';


session_start();

$produtoRepo = new ProdutoRepositorio($pdo);
$usuarioRepo = new UsuarioRepositorio($pdo);
$pedidoRepo = new PedidoRepositorio($pdo);
$enderecoRepo = new EnderecoRepositorio($pdo);

// exige usuário logado para acessar a finalização
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['usuario'];
$usuario = $usuarioRepo->buscarPorEmail($email);
if (!$usuario) {
    header('Location: login.php');
    exit;
}

// Se enviou o formulário para finalizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar'])) {
    $produtoId = isset($_POST['produto_id']) ? (int)$_POST['produto_id'] : null;
    $quantidade = isset($_POST['quantidade']) ? max(1, (int)$_POST['quantidade']) : 1;
    $produto = $produtoId ? $produtoRepo->buscar($produtoId) : null;
    if (!$produto) {
        header('Location: index.php');
        exit;
    }

    $enderecoId = isset($_POST['endereco_id']) && $_POST['endereco_id'] !== '' ? (int)$_POST['endereco_id'] : null;

    $total = $produto->getPreco() * $quantidade;
    $data_registro = date('Y-m-d H:i:s');

    $pedido = new Pedido(null, $produto->getId(), $usuario->getId(), $enderecoId, $quantidade, $total, $data_registro);
    $pedidoId = $pedidoRepo->salvar($pedido);

    $endereco = $enderecoId ? $enderecoRepo->buscar($enderecoId) : null;

    ?>
    <!doctype html>
    <html lang="pt-br">
    <head><meta charset="utf-8"><title>Pedido finalizado - Modex</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin.css">
    </head>
    <body style="padding:24px;">
        <h2>Compra finalizada</h2>
        <p>Obrigado! Seu pedido foi processado com sucesso.</p>
        <p><strong>Pedido ID:</strong> <?= $pedidoId ?></p>
        <p><strong>Produto:</strong> <?= htmlspecialchars($produto->getNome()) ?></p>
        <p><strong>Quantidade:</strong> <?= $quantidade ?></p>
        <p><strong>Total:</strong> <?= htmlspecialchars('R$ ' . number_format($total, 2)) ?></p>
        <?php if ($endereco): ?>
            <h3>Endereço de entrega</h3>
            <p><?= htmlspecialchars($endereco->formatar()) ?></p>
        <?php endif; ?>
        <a class="botao-cadastrar" href="index.php">Voltar ao catálogo</a>
    </body>
    </html>
    <?php
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$produto = $produtoRepo->buscar($id);
if (!$produto) {
    header('Location: index.php');
    exit;
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Finalizar Pedido - Modex</title>
    <style>
        .pedido-wrap{max-width:720px;margin:28px auto;padding:0 12px}
        .pedido-card{border:1px solid #e2e2e2;padding:16px;border-radius:6px;background:#fff}
    </style>
</head>
<body>
    <header style="padding:12px 16px;">
        <a href="index.php"><img src="img/logo.png" alt="Modex" style="max-width:160px;"></a>
    </header>
    <main class="pedido-wrap">
        <h2>Finalizar Pedido</h2>
        <div class="pedido-card">
            <p><strong>Produto:</strong> <?= htmlspecialchars($produto->getNome()) ?></p>
            <p><strong>Preço unitário:</strong> <?= htmlspecialchars($produto->getPrecoFormatado()) ?></p>
            <form method="post">
                <input type="hidden" name="produto_id" value="<?= $produto->getId() ?>">
                <div>
                    <label for="quantidade">Quantidade</label>
                    <input id="quantidade" name="quantidade" type="number" min="1" value="1">
                </div>
                <div style="margin-top:12px;">
                    <label>Endereço de entrega</label>
                    <?php $enderecos = $enderecoRepo->buscarPorUsuario($usuario->getId()); ?>
                    <?php if (count($enderecos) === 0): ?>
                        <p>Nenhum endereço cadastrado. <a href="enderecos/form.php">Adicionar agora</a></p>
                    <?php else: ?>
                        <?php foreach ($enderecos as $e): ?>
                            <div>
                                <label>
                                    <input type="radio" name="endereco_id" value="<?= $e->getId() ?>"> <?= htmlspecialchars($e->formatar()) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        <div style="margin-top:8px;"><a href="enderecos/form.php">Adicionar outro endereço</a></div>
                    <?php endif; ?>
                </div>
                <div style="margin-top:12px;">
                    <a href="index.php" class="botao-voltar" style="margin-right:8px;">Cancelar</a>
                    <button type="submit" name="finalizar" class="botao-cadastrar">Finalizar Compra</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
