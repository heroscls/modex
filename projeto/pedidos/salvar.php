<?php
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Pedido.php";
require __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";

require __DIR__ . "/../src/Repositorio/EnderecoRepositorio.php";

$repo = new PedidoRepositorio($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listar.php');
    exit;
}

$id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
$produto_id = isset($_POST['produto_id']) ? (int)$_POST['produto_id'] : 0;
$usuario_id = isset($_POST['usuario_id']) && $_POST['usuario_id'] !== '' ? (int)$_POST['usuario_id'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;
$total = isset($_POST['total']) ? (float)str_replace(',', '.', $_POST['total']) : 0.0;
$endereco_id = isset($_POST['endereco_id']) && $_POST['endereco_id'] !== '' ? (int)$_POST['endereco_id'] : null;
$data_registro = date('Y-m-d H:i:s');

// If total is not provided, try to compute from product price
if ($total <= 0 && $produto_id) {
    require_once __DIR__ . "/../src/Repositorio/ProdutoRepositorio.php";
    $produtoRepo = new ProdutoRepositorio($pdo);
    $produto = $produtoRepo->buscar($produto_id);
    if ($produto) {
        $total = $produto->getPreco() * max(1, $quantidade);
    }
}

$pedido = new Pedido($id, $produto_id, $usuario_id, $endereco_id, $quantidade, $total, $data_registro);

if ($id) {
    // updating not implemented (simple app) — could implement update method if needed
    // for now redirect to list
    header('Location: listar.php');
    exit;
} else {
    $repo->salvar($pedido);
    header('Location: listar.php');
    exit;
}
