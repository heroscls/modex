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
require_once __DIR__ . '/../src/Modelo/Usuario.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

$repo = new UsuarioRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$usuario = null;

if ($id) {
    
    if (method_exists($repo, 'buscar')) {
        $usuario = $repo->buscar($id);
    }

    if ($usuario) {
        $modoEdicao = true;
    } else {
        header('Location: listar.php');
        exit;
    }
}

$valorNome       = $modoEdicao ? $usuario->getNome() : '';
$valorPerfil     = $modoEdicao ? $usuario->getPerfil() : '';
$valorEmail      = $modoEdicao ? $usuario->getEmail() : '';
$valorSenha      = $modoEdicao ? $usuario->getSenha() : '';


$tituloPagina = $modoEdicao ? 'Editar Usuário' : 'Cadastrar Usuário';
$textoBotao   = $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Usuário';
$actionForm   = $modoEdicao ? 'salvar.php' : 'salvar.php';
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tituloPagina) ?> - Modex</title>
    <link rel="stylesheet" href="../css/reset.css?v=<?= filemtime(__DIR__ . '/../css/reset.css') ?>">
    <link rel="stylesheet" href="../css/index.css?v=<?= filemtime(__DIR__ . '/../css/index.css') ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?= filemtime(__DIR__ . '/../css/admin.css') ?>">
    <link rel="stylesheet" href="../css/form.css?v=<?= filemtime(__DIR__ . '/../css/form.css') ?>">
    <link rel="stylesheet" href="../css/login.css?v=<?= filemtime(__DIR__ . '/../css/login.css') ?>">
</head>

<body>
    <header class="container-admin">
        <div class="topo-direita">
            <span>Bem-vindo, <?php echo htmlspecialchars($usuarioLogado); ?></span>
            <form action="../logout.php" method="post" class="inline-form">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
        <nav class="menu-adm">
            <a href="../dashboard.php">Dashboard</a>
            <a href="../produtos/listar.php">Produtos</a>
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

        <div class="form-wrapper">
            <?php if (isset($_GET['erro']) && $_GET['erro'] === 'campos'): ?>
                <p class="mensagem-erro">Preencha todos os campos.</p>
            <?php endif; ?>

            <form action="<?= $actionForm ?>" method="post" class="form-produto">
                <?php if ($modoEdicao): ?>
                    <input type="hidden" name="id" value="<?= (int)$usuario->getId() ?>">
                <?php endif; ?>

                <div>
                    <label for="nome">Nome</label>
                    <input id="nome" name="nome" type="text" value="<?= htmlspecialchars($valorNome) ?>">
                </div>

                <div>
                    <label for="perfil">Perfil</label>
                    <select id="perfil" name="perfil">
                        <option value="User" <?= $valorPerfil === 'User'  ? 'selected' : '' ?>>User</option>
                        <option value="Admin" <?= $valorPerfil === 'Admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?= htmlspecialchars($valorEmail) ?>">
                </div>

                <div>
                    <label for="senha">Senha</label>
                    <input id="senha" name="senha" type="password" value="<?= htmlspecialchars($valorSenha) ?>">
                </div>

                <div class="grupo-botoes vertical">
                    <button type="submit" class="botao-cadastrar"><?= htmlspecialchars($textoBotao) ?></button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>
            </form>
        </div>
    </main>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const mensagens = document.querySelectorAll('.mensagem-erro, .mensagem-ok');
            mensagens.forEach(msg => {
                setTimeout(() => msg.classList.add('oculto'), 5000);
                msg.addEventListener('transitionend', () => msg.remove());
            });
        });
    </script>
</body>

</html>