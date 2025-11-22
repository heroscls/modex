<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/EnderecoRepositorio.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /modex/projeto/login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $repo = new EnderecoRepositorio($pdo);
    $repo->deletar((int)$id);
}

header('Location: listar.php');
exit;
