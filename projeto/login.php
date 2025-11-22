<?php
session_start();
$usuarioLogado = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Modex - Login</title>
</head>

<body>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const mensagens = document.querySelectorAll('.mensagem-erro, .mensagem-ok');
            mensagens.forEach(msg => {
                setTimeout(() => msg.classList.add('oculto'), 5000);
                msg.addEventListener('transitionend', () => msg.remove());
            });
        });
    </script>
            <section class="container-admin-banner">
                <img src="img/logo.png" class="logo-admin" alt="Modex">
                <h1>Login Modex</h1>
                <div style="margin-top:8px;">
                    <a href="index.php" class="botao-voltar">Voltar ao site</a>
                </div>
            </section>
            <section class="container-form">
                <div class="form-wrapper">
                    <?php if ($erro === 'credenciais'): ?>
                        <p class="mensagem-erro">Usuário ou senha incorretos.</p>
                    <?php elseif ($erro === 'campos'): ?>
                        <p class="mensagem-erro">Preencha e-mail e senha.</p>
                    <?php endif; ?>
                    <?php if (isset($_GET['novo']) && $_GET['novo'] == 1): ?>
                        <p class="mensagem-ok">Usuário registrado. Faça login.</p>
                    <?php endif; ?>
                    <form action="autenticar.php" method="post">

                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite o seu e-mail">

                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite a sua senha">

                        <div class="acoes-login">
                            <button type="submit" class="botao-primario">Entrar</button>
                            <a href="registrar.php" class="botao-secundario">Cadastrar</a>
                        </div>

                    </form>
                </div>
            </section>

        <?php
        ?>
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
