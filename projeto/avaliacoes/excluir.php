<?php
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Repositorio/AvaliacaoRepositorio.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listar.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$repo = new AvaliacaoRepositorio($pdo);
$repo->deletar($id);

header('Location: listar.php');
exit;
