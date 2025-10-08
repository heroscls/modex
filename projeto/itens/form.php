<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'] ?? null;
if (!$usuarioLogado) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Item.php';
require_once __DIR__ . '/../src/Repositorio/ItemRepositorio.php';

$repo = new ItemRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$item = null;

if ($id) {
    
    if (method_exists($repo, 'buscar')) {
        $item = $repo->buscar($id);
    }

    if ($item) {
        $modoEdicao = true;
    } else {
        header('Location: listar.php');
        exit;
    }
}

$valorNome       = $modoEdicao ? $item->getNome() : '';
$valorCategoria  = $modoEdicao ? $item->getCategoria() : '';
$valorTamanho    = $modoEdicao ? $item->getTamanho() : '';
$valorCor        = $modoEdicao ? $item->getCor() : '';
$valorPreco      = $modoEdicao ? $item->getPreco() : '';
$valorEstoque    = $modoEdicao ? $item->getEstoque() : '';
$valorDescricao  = $modoEdicao ? $item->getDescricao() : '';

if ($modoEdicao && $item->getDataRegistro()) {
    $data = DateTime::createFromFormat('Y-m-d', $item->getDataRegistro());
    if (!$data) {
        $data = DateTime::createFromFormat('d/m/Y', $item->getDataRegistro());
    }
    $valorDataRegistro = $data ? $data->format('Y-m-d') : '';
} else {
    $valorDataRegistro = '';
}

$tituloPagina = $modoEdicao ? 'Editar Item' : 'Cadastrar Item';
$textoBotao   = $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Item';
$actionForm   = $modoEdicao ? 'salvar.php' : 'salvar.php';
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tituloPagina) ?> - Modex</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <header class="container-admin">
    <div class="topo-direita">
        <span>Bem-vindo, <?php echo htmlspecialchars($usuarioLogado); ?></span>
        <form action="../logout.php" method="post" style="display:inline;">
            <button type="submit" class="botao-sair">Sair</button>
        </form>
    </div>
    <nav class="menu-adm">
        <a href="../dashboard.php">Dashboard</a>
        <a href="../itens/listar.php">Itens</a>
        <a href="../usuarios/listar.php">Usuários</a>
    </nav>
    <div class="container-admin-banner">
        <a href="dashboard.php">
            <img src="../img/logo.png" alt="Modex" class="logo-admin">
        </a>
    </div>


</header>
    <main>
        <h2><?= htmlspecialchars($tituloPagina) ?></h2>
        <section class="container-form">
            <div class="form-wrapper">
                <?php if (isset($_GET['erro']) &&   $_GET['erro'] === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php endif; ?>
                <form action="<?= $actionForm ?>" method="post" class="form-produto">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id" value="<?= (int)$item->getId() ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label for="nome">Nome</label>
                        <input id="nome" name="nome" type="text" value="<?= htmlspecialchars($valorNome) ?>">
                    </div>

                    <div>
                        <label for="categoria">Categoria</label>
                        <input id="categoria" name="categoria" type="text" value="<?= htmlspecialchars($valorCategoria) ?>">
                    </div>

                    <div>
                        <label for="tamanho">Tamanho</label>
                        <input id="tamanho" name="tamanho" type="text" value="<?= htmlspecialchars($valorTamanho) ?>">
                    </div>

                    <div>
                        <label for="cor">Cor</label>
                        <input id="cor" name="cor" type="text" value="<?= htmlspecialchars($valorCor) ?>">
                    </div>

                    <div>
                        <label for="preco">Preço</label>
                        <input id="preco" name="preco" type="text" value="<?= htmlspecialchars($valorPreco) ?>">
                    </div>

                    <div>
                        <label for="estoque">Estoque</label>
                        <input id="estoque" name="estoque" type="number" value="<?= htmlspecialchars($valorEstoque) ?>">
                    </div>

                    <div>
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao"><?= htmlspecialchars($valorDescricao) ?></textarea>
                    </div>

                    <div>
                        <label for="data_registro">Data de Registro</label>
                        <input id="data_registro" name="data_registro" type="date" value="<?= htmlspecialchars($valorDataRegistro) ?>">
                    </div>

                    <div class="grupo-botoes">
                        <button type="submit" class="botao-cadastrar"><?= htmlspecialchars($textoBotao) ?></button>
                        <a href="listar.php" class="botao-voltar">Voltar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const mensagens = document.querySelectorAll('.mensagem-erro, .mensagem-ok');

            mensagens.forEach(msg => {
                setTimeout(() => {
                    msg.classList.add('oculto');
                }, 5000);

                msg.addEventListener('transitionend', () => msg.remove());
            });
        });
    </script>
</body>

</html>