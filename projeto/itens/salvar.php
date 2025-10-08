<?php
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Item.php";
require __DIR__ . "/../src/Repositorio/ItemRepositorio.php";

$repo = new ItemRepositorio($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listar.php');
    exit;
}

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$tamanho = trim($_POST['tamanho'] ?? '');
$cor = trim($_POST['cor'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : (int)($_POST['quantidade'] ?? 0);
$preco = (float)($_POST['preco'] ?? 0.0);
$data_registro = trim($_POST['data_registro'] ?? '');

if ($nome === '' || $categoria === '' || $estoque < 0 || $preco < 0) {
    header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
    exit;
}

    try {
    $item = new Item($id, $nome, $categoria, $tamanho, $cor, $preco, $estoque, $descricao, $data_registro);

    if ($id) {
        $existente = $repo->buscar($id);
        if (!$existente) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }
        $repo->atualizar($item);
        header('Location: listar.php?ok=1');
        exit;
    }

    $repo->salvar($item);
    header('Location: listar.php?novo=1');
    exit;

} catch (Throwable $e) {
    error_log('Erro salvar item: ' . $e->getMessage());
    header('Location: form.php' . ($id ? '?id=' . $id . '&erro=exception' : '?erro=exception'));
    exit;
}
