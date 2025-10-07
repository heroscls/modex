<?php
    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/ItemRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Item.php';

    $nome = 'calça cargo';
    $categoria = 'streetwear';
    $tamanho = 'G';
    $cor = 'preto';
    $preco = 150.99;
    $estoque = 70;
    $descricao = 'calça cargo larga';
    $data_registro = '2025/10/06';

    $repo = new ItemRepositorio($pdo);

    if($repo->buscarPorNome($nome)){
        echo "Item já existe! {$nome}\n";
        exit; 
    }

    $repo->salvar(new Item(0, $nome, $categoria, $tamanho, $cor, $preco, $estoque, $descricao, $data_registro));

    echo "Item inserido: {$nome}\n";


?>