<?php

//Classe que faz as persisências no BD
class ItemRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Item
    {
        return new Item((int)$dados['id'],$dados['nome'],$dados['senha']);
    }

    public function buscarPorNome(string $nome): ?Item 
    {
        $sql = "SELECT id, nome, categoria, tamanho, cor, preco, estoque, descricao, data_registro FROM Items WHERE nome =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1,$nome);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados): null;
    }

    public function salvar(Item $Item): void
    {
        $sql = "INSERT INTO Items(nome, categoria, tamanho, cor, preco, estoque, descricao, data_registro) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $Item->getnome());
        $stmt->bindValue(2, $Item->getcategoria());
        $stmt->bindValue(3, $Item->gettamanho());
        $stmt->bindValue(4, $Item->getcor());
        $stmt->bindValue(5, $Item->getpreco());
        $stmt->bindValue(6, $Item->getestoque());
        $stmt->bindValue(7, $Item->getdescricao());
        $stmt->bindValue(8, $Item->getdata_registro());
        $stmt->execute();

    }
}

?>