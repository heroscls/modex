<?php

require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Item.php";
require __DIR__ . "/../src/Repositorio/ItemRepositorio.php";

$itemRepositorio = new ItemRepositorio($pdo);
$itemRepositorio->deletar($_POST['id']);

header("Location: listar.php");