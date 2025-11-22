<?php
class Avaliacao
{
    private ?int $id;
    private int $produto_id;
    private ?int $usuario_id;
    private int $nota; // 1-5
    private string $comentario;
    private string $data_registro;

    public function __construct(?int $id, int $produto_id, ?int $usuario_id, int $nota, string $comentario, string $data_registro)
    {
        $this->id = $id;
        $this->produto_id = $produto_id;
        $this->usuario_id = $usuario_id;
        $this->nota = $nota;
        $this->comentario = $comentario;
        $this->data_registro = $data_registro;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProdutoId(): int
    {
        return $this->produto_id;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuario_id;
    }

    public function getNota(): int
    {
        return $this->nota;
    }

    public function getComentario(): string
    {
        return $this->comentario;
    }

    public function getDataRegistro(): string
    {
        return $this->data_registro;
    }
}

?>
