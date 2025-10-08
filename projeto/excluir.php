<?php

require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Item.php";
require __DIR__ . "/../src/Repositorio/itemRepositorio.php";

$itemRepositorio = new itemRepositorio($pdo);
$itemRepositorio->deletar($_POST['id']);

header("Location: listar.php");