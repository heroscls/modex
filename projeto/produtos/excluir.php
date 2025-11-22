<?php

session_start();
require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Produto.php";
require __DIR__ . "/../src/Repositorio/ProdutoRepositorio.php";

$produtoRepositorio = new ProdutoRepositorio($pdo);
try {
	$produtoRepositorio->deletar((int)($_POST['id'] ?? 0));
	$_SESSION['mensagem_ok'] = 'Produto excluído com sucesso.';
} catch (PDOException $e) {
	// Código 23000 com driver MySQL usa erro 1451 quando existe FK restritiva
	$code = $e->getCode();
	if ($code === '23000' || strpos($e->getMessage(), '1451') !== false) {
		$_SESSION['mensagem_erro'] = 'Não é possível excluir o produto: existem pedidos vinculados a ele.';
	} else {
		$_SESSION['mensagem_erro'] = 'Erro ao excluir o produto: ' . $e->getMessage();
	}
}

header("Location: listar.php");
