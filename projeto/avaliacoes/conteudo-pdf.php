<?php
require "../src/conexao-bd.php";
require "../src/Modelo/Avaliacao.php";
require "../src/Repositorio/AvaliacaoRepositorio.php";
require "../src/Repositorio/ProdutoRepositorio.php";
require "../src/Repositorio/UsuarioRepositorio.php";
require "../src/helpers.php";

date_default_timezone_set('America/Sao_Paulo');
$rodapeDataHora = date('d/m/Y H:i');

$repo = new AvaliacaoRepositorio($pdo);
$produtoRepo = new ProdutoRepositorio($pdo);
$usuarioRepo = new UsuarioRepositorio($pdo);
$avaliacoes = $repo->buscarTodos();

$imagePath = '../img/logo.png';
$imageData = base64_encode(file_get_contents($imagePath));
$imageSrc = 'data:image/png;base64,' . $imageData;

?>
<head>
    <meta charset="UTF-8">
<style>
    body, table, th, td, h3 { font-family: Arial, Helvetica, sans-serif; }
    table { width: 90%; margin: auto 0; }
    table, th, td { border: 1px solid #000; }
    table th { padding: 8px; font-weight: bold; font-size: 14px; text-align: left; }
    table td { font-size: 12px; padding: 8px; }
    h3 { text-align: center; margin-top: 0.5rem; margin-bottom: 1rem; }
    .pdf-footer { position: fixed; bottom: 0; left: 0; right: 0; height: 30px; text-align: center; font-size: 12px; color: #444; border-top: 1px solid #ddd; padding-top: 6px; }
    body { margin-bottom: 50px; margin-top: 0; }
    .pdf-img { width: 100px; }
</style>
</head>
<img src="<?= $imageSrc ?>" class="pdf-img" alt="logo-modex">

<h3>Listagem de avaliações</h3>

<table>
    <thead>
        <tr>
            <th>Produto</th>
            <th>Usuário</th>
            <th>Nota</th>
            <th>Comentário</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($avaliacoes as $a):
            $produto = $produtoRepo->buscar($a->getProdutoId());
            $usuario = $usuarioRepo->buscar($a->getUsuarioId() ?? 0);
        ?>
            <tr>
                <td><?= htmlspecialchars($produto ? $produto->getNome() : '—') ?></td>
                <td><?= htmlspecialchars($usuario ? $usuario->getNome() : ($a->getUsuarioId() ?? '—')) ?></td>
                <td><?= htmlspecialchars($a->getNota()) ?></td>
                <td><?= htmlspecialchars($a->getComentario()) ?></td>
                <td><?= htmlspecialchars(formatDateTimeBR($a->getDataRegistro())) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pdf-footer">Gerado em: <?= htmlspecialchars($rodapeDataHora) ?></div>
