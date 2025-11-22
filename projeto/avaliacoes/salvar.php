<?php
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Avaliacao.php";
require __DIR__ . "/../src/Repositorio/AvaliacaoRepositorio.php";

$repo = new AvaliacaoRepositorio($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listar.php');
    exit;
}

$id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
$produto_id = isset($_POST['produto_id']) ? (int)$_POST['produto_id'] : 0;
$usuario_id = isset($_POST['usuario_id']) && $_POST['usuario_id'] !== '' ? (int)$_POST['usuario_id'] : null;
$nota = isset($_POST['nota']) ? (int)$_POST['nota'] : 0;
$comentario = $_POST['comentario'] ?? '';
$data_registro = date('Y-m-d H:i:s');

$avaliacao = new Avaliacao($id, $produto_id, $usuario_id, $nota, $comentario, $data_registro);

if ($id) {
    $repo->atualizar($avaliacao);
} else {
    $repo->salvar($avaliacao);
}

header('Location: listar.php');
exit;
