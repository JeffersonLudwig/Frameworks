<?php

namespace App\Entities\Response;

class ProdutoEmNotaFiscalDTO
{
    private string $nomeProduto;
    private int $notaFiscalId;

    public function __construct(string $nomeProduto, int $notaFiscalId)
    {
        $this->nomeProduto = $nomeProduto;
        $this->notaFiscalId = $notaFiscalId;
    }

    public function toArray(): array
    {
        return [
            'message'        => 'O produto não pode ser alterado pois está vinculado a uma nota fiscal de saída.',
            'nome_produto'   => $this->nomeProduto,
            'nota_fiscal_id' => $this->notaFiscalId,
        ];
    }
}
