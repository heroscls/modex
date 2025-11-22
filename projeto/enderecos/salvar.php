<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Endereco.php';
require_once __DIR__ . '/../src/Repositorio/EnderecoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /modex/projeto/login.php');
    exit;
}

$usuarioRepo = new UsuarioRepositorio($pdo);
$usuario = $usuarioRepo->buscarPorEmail($_SESSION['usuario']);

$enderecoRepo = new EnderecoRepositorio($pdo);

$id = $_POST['id'] ?? null;
$usuario_id = $_POST['usuario_id'] ?? $usuario->getId();
$rua = $_POST['rua'] ?? '';
$numero = $_POST['numero'] ?? '';
$complemento = $_POST['complemento'] ?? null;
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$cep = $_POST['cep'] ?? '';

if ($id) {
    $endereco = new Endereco((int)$id, (int)$usuario_id, $rua, $numero, $complemento, $cidade, $estado, $cep);
    $enderecoRepo->atualizar($endereco);
} else {
    $endereco = new Endereco(null, (int)$usuario_id, $rua, $numero, $complemento, $cidade, $estado, $cep);
    $enderecoRepo->salvar($endereco);
}

header('Location: listar.php');
exit;
