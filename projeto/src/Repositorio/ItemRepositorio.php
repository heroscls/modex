<?php

class ItemRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Item
    {
        return new Item(
            isset($dados['id']) ? (int)$dados['id'] : null,
            $dados['nome'] ?? '',
            $dados['categoria'] ?? '',
            $dados['tamanho'] ?? '',
            $dados['cor'] ?? '',
            isset($dados['preco']) ? (float)$dados['preco'] : 0.0,
            isset($dados['estoque']) ? (int)$dados['estoque'] : 0,
            $dados['descricao'] ?? '',
            $dados['data_registro'] ?? ''
        );
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT id, nome, categoria, tamanho, cor, preco, estoque, descricao, data_registro FROM itens ORDER BY nome";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function buscar(int $id): ?Item
    {
        $st = $this->pdo->prepare("SELECT id, nome, categoria, tamanho, cor, preco, estoque, descricao, data_registro FROM itens WHERE id=?");
        $st->execute([$id]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function buscarPorNome(string $nome): ?Item
    {
        $st = $this->pdo->prepare("SELECT id, nome, categoria, tamanho, cor, preco, estoque, descricao, data_registro FROM itens WHERE nome=? LIMIT 1");
        $st->bindValue(1, $nome);
        $st->execute([$nome]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }
    
    public function salvar(Item $item): void
    {
        $sql = "INSERT INTO itens(nome, categoria, tamanho, cor, preco, estoque, descricao, data_registro) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $item->getNome());
        $stmt->bindValue(2, $item->getCategoria());
        $stmt->bindValue(3, $item->getTamanho());
        $stmt->bindValue(4, $item->getCor());
        $stmt->bindValue(5, $item->getPreco());
        $stmt->bindValue(6, $item->getEstoque());
        $stmt->bindValue(7, $item->getDescricao());
        $stmt->bindValue(8, $item->getDataRegistro());
        $stmt->execute();

    }

    public function atualizar(Item $item): void
    {
        $sql = "UPDATE itens SET nome = ?, categoria = ?, tamanho = ?, cor = ?, preco = ?, estoque = ?, descricao = ?, data_registro = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $item->getNome());
        $stmt->bindValue(2, $item->getCategoria());
        $stmt->bindValue(3, $item->getTamanho());
        $stmt->bindValue(4, $item->getCor());
        $stmt->bindValue(5, $item->getPreco());
        $stmt->bindValue(6, $item->getEstoque());
        $stmt->bindValue(7, $item->getDescricao());
        $stmt->bindValue(8, $item->getDataRegistro());
        $stmt->bindValue(9, $item->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deletar(int $id): void
    {
        $sql = "DELETE FROM itens WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}

?>