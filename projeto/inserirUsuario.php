<?php
    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Usuario.php';

    $email = 'modex@gmail.com';
    $senhaPlana = '1234';

    $repo = new UsuarioRepositorio($pdo);

    if($repo->buscarPorEmail($email)){
        echo "Usuário já existe! {$email}\n";
        exit; 
    }

    $repo->salvar(new Usuario(0, $email, $senhaPlana));

    echo "Usuário inserido: {$email}\n";


?>