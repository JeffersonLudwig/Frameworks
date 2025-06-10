<?php

namespace App\Entities\Request;

class ProdutoUpdateRequestDTO
{
    public string $nome;

    public function __construct(array $data)
    {
        $this->nome = $data['nome'];
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
        ];
    }
}
