<?php
    class Item
    {
    private ?int $id;
        private string $nome;
        private string $categoria;
        private string $tamanho;
        private string $cor;
        private float $preco;
        private int $estoque;
        private string $descricao;
        private string $data_registro;

    public function __construct(?int $id, string $nome, string $categoria, string $tamanho, string $cor, float $preco, int $estoque, string $descricao, string $data_registro){
            $this->id = $id;
            $this->nome = $nome;
            $this->categoria = $categoria; 
            $this->tamanho = $tamanho;
            $this->cor = $cor;
            $this->preco = $preco;
            $this->estoque = $estoque;
            $this->descricao = $descricao;
            $this->data_registro = $data_registro;
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getCategoria(): string
        {
            return $this->categoria;
        }

        public function getTamanho(): string
        {
            return $this->tamanho;
        }

        public function getCor(): string
        {
            return $this->cor;
        }

        public function getPreco(): float
        {
            return $this->preco;
        }

        public function getEstoque(): int
        {
            return $this->estoque;
        }

        public function getDescricao(): string
        {
            return $this->descricao;
        }

        public function getDataRegistro(): string
        {
            return $this->data_registro;
        }
    }

?>