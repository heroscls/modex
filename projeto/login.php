<?php 
    session_start();
    $usuarioLogado = $_SESSION['usuario'] ?? null;

    $erro = $_GET['erro'] ?? '';
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Modex</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="login-center">
       <?php 
        if($usuarioLogado): ?>
        <section class="container-topo">
            <div class="topo-direita">
                <p>Você já está logado como <strong><?php echo htmlspecialchars($usuarioLogado)?></strong></p>
                <form action="logout.php" method="post">
                    <button type="submit" class="botao-sair">Sair</button>
                </form>
            </div>
            <div class="conteudo">
                <a href="admin.php" class="link-adm">Ir para o painel administrativo</a>
            </div>
        </section>
        <?php else: ?>
        

    <div class="logo"><img src="img/logo.png" alt="logo"></div>
      
    <div class="form-wrapper">
                <?php if($erro === 'credenciais'): ?>
                <p class="mensagem-erro">Usuário e senha incorretos.</p>
                <?php elseif($erro === 'campos'): ?>
                <p class="mensagem-erro">Preencha e-mail e senha.</p>
                <?php endif; ?>

      <form id="login-form" class="login-box" action="autenticar.php" method="POST">
        <div class="input">
          <span class="icon-left">🔍</span>
          <input type="email" placeholder="Email" name="email" required>
        </div>

        <div class="input">
          <span class="icon-left">🔒</span>
          <input type="password" placeholder="Senha" name="senha" required>
        </div>

        <button class="btn" type="submit">Entrar</button>
      </form>
    </div>
    <div class="small">Não possui cadastro? Clique aqui</div>
    <?php endif; ?>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', function() {
        var msg = document.querySelector('.mensagem-erro');
        if (msg) {
            setTimeout(function() {
                msg.classList.add('oculto');
            }, 5000);
        }
    });
    </script>
</body>
</html>
