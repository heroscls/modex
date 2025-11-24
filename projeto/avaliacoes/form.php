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

$repo = new AvaliacaoRepositorio($pdo);
$produtoRepo = new ProdutoRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$avaliacao = null;

if ($id) {
    $avaliacao = $repo->buscar($id);
    if ($avaliacao) {
        $modoEdicao = true;
    } else {
        header('Location: listar.php');
        exit;
    }
}

$valorProdutoId = $modoEdicao ? $avaliacao->getProdutoId() : '';
$valorUsuarioId = $modoEdicao ? $avaliacao->getUsuarioId() : '';
$valorNota = $modoEdicao ? $avaliacao->getNota() : '';
$valorComentario = $modoEdicao ? $avaliacao->getComentario() : '';

$produtos = $produtoRepo->buscarTodos();

$titulo = $modoEdicao ? 'Editar Avaliação' : 'Cadastrar Avaliação';

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reset.css?v=<?= filemtime(__DIR__ . '/../css/reset.css') ?>">
    <link rel="stylesheet" href="../css/form.css?v=<?= filemtime(__DIR__ . '/../css/form.css') ?>">
    <title><?= htmlspecialchars($titulo) ?></title>
</head>
<body>
    <main>
        <h2><?= htmlspecialchars($titulo) ?></h2>
        <form action="salvar.php" method="post">
            <?php if ($modoEdicao): ?>
                <input type="hidden" name="id" value="<?= $avaliacao->getId() ?>">
            <?php endif; ?>

            <div>
                <label for="produto_id">Produto</label>
                <select id="produto_id" name="produto_id" required>
                    <option value="">Escolha um produto</option>
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p->getId() ?>" <?= $valorProdutoId == $p->getId() ? 'selected' : '' ?>><?= htmlspecialchars($p->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="usuario_id">Usuário ID</label>
                <input id="usuario_id" name="usuario_id" type="number" value="<?= htmlspecialchars($valorUsuarioId) ?>">
            </div>

            <div>
                <label for="nota">Nota (1-5)</label>
                <input id="nota" name="nota" type="number" min="1" max="5" required value="<?= htmlspecialchars($valorNota) ?>">
            </div>

            <div>
                <label for="comentario">Comentário</label>
                <textarea id="comentario" name="comentario" rows="4"><?= htmlspecialchars($valorComentario) ?></textarea>
            </div>

            <div class="grupo-botoes">
                <button type="submit" class="botao-cadastrar">Salvar</button>
                <a href="listar.php" class="botao-voltar">Voltar</a>
            </div>
        </form>
    </main>
</body>
</html>
