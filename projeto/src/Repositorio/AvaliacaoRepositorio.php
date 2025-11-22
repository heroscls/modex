<?php
require_once __DIR__ . '/../Modelo/Avaliacao.php';

class AvaliacaoRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $dados): Avaliacao
    {
        return new Avaliacao(
            isset($dados['id']) ? (int)$dados['id'] : null,
            (int)$dados['produto_id'],
            isset($dados['usuario_id']) ? (int)$dados['usuario_id'] : null,
            isset($dados['nota']) ? (int)$dados['nota'] : 0,
            $dados['comentario'] ?? '',
            $dados['data_registro'] ?? ''
        );
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT id, produto_id, usuario_id, nota, comentario, data_registro FROM avaliacoes ORDER BY data_registro DESC";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function buscar(int $id): ?Avaliacao
    {
        $st = $this->pdo->prepare("SELECT id, produto_id, usuario_id, nota, comentario, data_registro FROM avaliacoes WHERE id = ?");
        $st->execute([$id]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function buscarPorProduto(int $produtoId): array
    {
        $st = $this->pdo->prepare("SELECT id, produto_id, usuario_id, nota, comentario, data_registro FROM avaliacoes WHERE produto_id = ? ORDER BY data_registro DESC");
        $st->execute([$produtoId]);
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function salvar(Avaliacao $avaliacao): void
    {
        $sql = "INSERT INTO avaliacoes (produto_id, usuario_id, nota, comentario, data_registro) VALUES (?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $avaliacao->getProdutoId(), PDO::PARAM_INT);
        $stmt->bindValue(2, $avaliacao->getUsuarioId(), PDO::PARAM_INT);
        $stmt->bindValue(3, $avaliacao->getNota(), PDO::PARAM_INT);
        $stmt->bindValue(4, $avaliacao->getComentario(), PDO::PARAM_STR);
        $stmt->bindValue(5, $avaliacao->getDataRegistro(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function atualizar(Avaliacao $avaliacao): void
    {
        $sql = "UPDATE avaliacoes SET produto_id = ?, usuario_id = ?, nota = ?, comentario = ?, data_registro = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $avaliacao->getProdutoId(), PDO::PARAM_INT);
        $stmt->bindValue(2, $avaliacao->getUsuarioId(), PDO::PARAM_INT);
        $stmt->bindValue(3, $avaliacao->getNota(), PDO::PARAM_INT);
        $stmt->bindValue(4, $avaliacao->getComentario(), PDO::PARAM_STR);
        $stmt->bindValue(5, $avaliacao->getDataRegistro(), PDO::PARAM_STR);
        $stmt->bindValue(6, $avaliacao->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deletar(int $id): void
    {
        $sql = "DELETE FROM avaliacoes WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>
