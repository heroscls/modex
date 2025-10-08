<?php
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Usuario.php";
require __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

$repo = new UsuarioRepositorio($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listar.php');
    exit;
}

$id     = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
$nome   = trim($_POST['nome']   ?? '');
$perfil = trim($_POST['perfil'] ?? 'User');
$email  = trim($_POST['email']  ?? '');
$senha  = $_POST['senha'] ?? '';

if ($nome === '' || $email === '' || (!$id && $senha === '')) {
    header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
    exit;
}

if (!in_array($perfil, ['User', 'Admin'], true)) {
    $perfil = 'User';
}

if ($id) {
    $existente = $repo->buscar($id);
    if (!$existente) {
        header('Location: listar.php?erro=inexistente');
        exit;
    }

    if ($senha === '') {
        $senhaParaObjeto = $existente->getSenha();
    } else {
        $senhaParaObjeto = $senha;
    }

    $usuario = new Usuario($id, $nome, $perfil, $email, $senhaParaObjeto);
    $repo->atualizar($usuario);
    header('Location: listar.php?ok=1');
    exit;
}

$usuario = new Usuario(null, $nome, $perfil, $email, $senha);
$repo->salvar($usuario);
header('Location: listar.php?novo=1');
exit;

