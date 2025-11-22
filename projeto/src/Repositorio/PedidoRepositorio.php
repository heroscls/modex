<?php

require_once __DIR__ . '/../Modelo/Pedido.php';

class PedidoRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $d): Pedido
    {
        return new Pedido(
            isset($d['id']) ? (int)$d['id'] : null,
            (int)$d['produto_id'],
            (int)$d['usuario_id'],
            isset($d['endereco_id']) && $d['endereco_id'] !== null ? (int)$d['endereco_id'] : null,
            (int)$d['quantidade'],
            isset($d['total']) ? (float)$d['total'] : 0.0,
            $d['data_registro'] ?? ''
        );
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT id, produto_id, usuario_id, endereco_id, quantidade, total, data_registro FROM pedidos ORDER BY data_registro DESC";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function buscar(int $id): ?Pedido
    {
        $st = $this->pdo->prepare("SELECT id, produto_id, usuario_id, endereco_id, quantidade, total, data_registro FROM pedidos WHERE id = ?");
        $st->execute([$id]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function salvar(Pedido $pedido): int
    {
        $sql = "INSERT INTO pedidos (produto_id, usuario_id, endereco_id, quantidade, total, data_registro) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $pedido->getProdutoId(), PDO::PARAM_INT);
        $stmt->bindValue(2, $pedido->getUsuarioId(), PDO::PARAM_INT);
        $endId = $pedido->getEnderecoId();
        if ($endId === null) {
            $stmt->bindValue(3, null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(3, $endId, PDO::PARAM_INT);
        }
        $stmt->bindValue(4, $pedido->getQuantidade(), PDO::PARAM_INT);
        $stmt->bindValue(5, $pedido->getTotal());
        $stmt->bindValue(6, $pedido->getDataRegistro());
        $stmt->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function deletar(int $id): void
    {
        $sql = "DELETE FROM pedidos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>
