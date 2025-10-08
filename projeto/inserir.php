<!-- <?php
        require __DIR__ . "/../src/conexao-bd.php";
        require __DIR__ . "/../src/Modelo/Item.php";
        require __DIR__ . "/../src/Repositorio/ItemRepositorio.php";

        $itemRepositorio = new ItemRepositorio($pdo);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $item = new Item( 
                $_POST['id'],
                $_POST['nome'] ?: null, 
                $_POST['categoria'],
                $_POST['tamanho'],
                $_POST['cor'],
                $_POST['preco'],
                $_POST['descricao'],
                $_POST['data_registro'],
                $_POST['imagem'],
            );
        }

        if ($item->getId()) {
            
            $itemRepositorio->atualizar($item);
        } else {
            
            $itemRepositorio->salvar($item);
        }

        header("Location: listar.php");
        exit();

