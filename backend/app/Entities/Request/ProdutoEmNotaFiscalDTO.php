<?php

namespace App\Entities\Request;

class ProdutoEmNotaFiscalDTO
{
    private int $produto_id;
    private int $quantidade;
    private float $valor_unitario;

    public function __construct(array $data)
    {
        if (!isset($data['produto_id'], $data['quantidade'], $data['valor_unitario'])) {
            throw new \InvalidArgumentException('Dados do item inválidos.');
        }

        $this->produto_id = (int) $data['produto_id'];
        $this->quantidade = (int) $data['quantidade'];
        $this->valor_unitario = (float) $data['valor_unitario'];
    }

    public function toArray(int $notaFiscalId): array
    {
        return [
            'nota_fiscal_id' => $notaFiscalId,
            'produto_id' => $this->produto_id,
            'quantidade' => $this->quantidade,
            'valor_unitario' => $this->valor_unitario,
        ];
    }
}
