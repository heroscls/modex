<?php

require_once __DIR__ . '/../Modelo/Endereco.php';

class EnderecoRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $d): Endereco
    {
        return new Endereco(
            isset($d['id']) ? (int)$d['id'] : null,
            (int)$d['usuario_id'],
            $d['rua'] ?? '',
            $d['numero'] ?? '',
            $d['complemento'] ?? null,
            $d['cidade'] ?? '',
            $d['estado'] ?? '',
            $d['cep'] ?? ''
        );
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT id, usuario_id, rua, numero, complemento, cidade, estado, cep FROM enderecos ORDER BY id DESC";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function buscar(int $id): ?Endereco
    {
        $st = $this->pdo->prepare("SELECT id, usuario_id, rua, numero, complemento, cidade, estado, cep FROM enderecos WHERE id = ?");
        $st->execute([$id]);
        $d = $st->fetch(PDO::FETCH_ASSOC);
        return $d ? $this->formarObjeto($d) : null;
    }

    public function buscarPorUsuario(int $usuarioId): array
    {
        $st = $this->pdo->prepare("SELECT id, usuario_id, rua, numero, complemento, cidade, estado, cep FROM enderecos WHERE usuario_id = ? ORDER BY id DESC");
        $st->execute([$usuarioId]);
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => $this->formarObjeto($r), $rs);
    }

    public function salvar(Endereco $endereco): int
    {
        $sql = "INSERT INTO enderecos (usuario_id, rua, numero, complemento, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $endereco->getUsuarioId(), PDO::PARAM_INT);
        $stmt->bindValue(2, $endereco->getRua(), PDO::PARAM_STR);
        $stmt->bindValue(3, $endereco->getNumero(), PDO::PARAM_STR);
        $stmt->bindValue(4, $endereco->getComplemento(), PDO::PARAM_STR);
        $stmt->bindValue(5, $endereco->getCidade(), PDO::PARAM_STR);
        $stmt->bindValue(6, $endereco->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(7, $endereco->getCep(), PDO::PARAM_STR);
        $stmt->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function atualizar(Endereco $endereco): void
    {
        $sql = "UPDATE enderecos SET rua = ?, numero = ?, complemento = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $endereco->getRua(),
            $endereco->getNumero(),
            $endereco->getComplemento(),
            $endereco->getCidade(),
            $endereco->getEstado(),
            $endereco->getCep(),
            $endereco->getId()
        ]);
    }

    public function deletar(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM enderecos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>
