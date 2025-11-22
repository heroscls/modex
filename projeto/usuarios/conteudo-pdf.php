<?php
require "../src/conexao-bd.php";
require "../src/Modelo/Usuario.php";
require "../src/Repositorio/UsuarioRepositorio.php";

date_default_timezone_set('America/Sao_Paulo');
$rodapeDataHora = date('d/m/Y H:i');

$usuarioRepositorio = new UsuarioRepositorio($pdo);
$usuarios = $usuarioRepositorio->buscarTodos();

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

<h3>Listagem de usuários</h3>

<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Perfil</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u->getNome()) ?></td>
                <td><?= htmlspecialchars($u->getPerfil()) ?></td>
                <td><?= htmlspecialchars($u->getEmail()) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pdf-footer">Gerado em: <?= htmlspecialchars($rodapeDataHora) ?></div>
