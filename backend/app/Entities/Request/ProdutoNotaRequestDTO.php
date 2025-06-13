<?php

namespace App\Entities\Request;

class ProdutoNotaRequestDTO
{
    public $nota_fiscal_id;
    public $produto_id;
    public $quantidade;
    public $valor_unitario;


    public function __construct(array $data)
    {
        $this->nota_fiscal_id = $data['nota_fiscal_id'];
        $this->produto_id = $data['produto_id'];
        $this->quantidade = $data['quantidade'];
        $this->valor_unitario = $data['valor_unitario'];
    }

    public function toArray()
    {
        return [
            'nota_fiscal_id' => $this->nota_fiscal_id,
            'produto_id' => $this->produto_id,
            'quantidade' => $this->quantidade,
            'valor_unitario' => $this->valor_unitario,
        ];
    }
}
