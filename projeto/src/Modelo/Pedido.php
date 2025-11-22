<?php
class Pedido
{
    private ?int $id;
    private int $produto_id;
    private int $usuario_id;
    private ?int $endereco_id;
    private int $quantidade;
    private float $total;
    private string $data_registro;

    public function __construct(?int $id, int $produto_id, int $usuario_id, ?int $endereco_id, int $quantidade, float $total, string $data_registro)
    {
        $this->id = $id;
        $this->produto_id = $produto_id;
        $this->usuario_id = $usuario_id;
        $this->endereco_id = $endereco_id;
        $this->quantidade = $quantidade;
        $this->total = $total;
        $this->data_registro = $data_registro;
    }

    public function getId(): ?int { return $this->id; }
    public function getProdutoId(): int { return $this->produto_id; }
    public function getUsuarioId(): int { return $this->usuario_id; }
    public function getEnderecoId(): ?int { return $this->endereco_id; }
    public function getQuantidade(): int { return $this->quantidade; }
    public function getTotal(): float { return $this->total; }
    public function getDataRegistro(): string { return $this->data_registro; }
}

?>
