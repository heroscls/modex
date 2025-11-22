<?php
class Endereco
{
    private ?int $id;
    private int $usuario_id;
    private string $rua;
    private string $numero;
    private ?string $complemento;
    private string $cidade;
    private string $estado;
    private string $cep;

    public function __construct(?int $id, int $usuario_id, string $rua, string $numero, ?string $complemento, string $cidade, string $estado, string $cep)
    {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
    }

    public function getId(): ?int { return $this->id; }
    public function getUsuarioId(): int { return $this->usuario_id; }
    public function getRua(): string { return $this->rua; }
    public function getNumero(): string { return $this->numero; }
    public function getComplemento(): ?string { return $this->complemento; }
    public function getCidade(): string { return $this->cidade; }
    public function getEstado(): string { return $this->estado; }
    public function getCep(): string { return $this->cep; }

    public function formatar(): string
    {
        $parts = [ $this->rua . ', ' . $this->numero ];
        if ($this->complemento) $parts[] = $this->complemento;
        $parts[] = $this->cidade . ' - ' . $this->estado;
        $parts[] = 'CEP: ' . $this->cep;
        return implode(' | ', $parts);
    }
}

?>
