<?php

namespace App\Entities\Request;


class NotaFiscalRequestDTO
{
    private string $numero_nf;
    private string $numero_serie;
    private string $numero_folhas;
    private string $natureza_operacao;
    private string $data_emissao;
    private string $data_saida;
    private float $valor_total;
    private float $valor_desconto;
    private int $cliente_id;


    public function __construct(array $data)
    {
        $this->numero_nf         = $data['numero_nf'];
        $this->numero_serie      = $data['numero_serie'];
        $this->numero_folhas     = $data['numero_folhas'];
        $this->natureza_operacao = $data['natureza_operacao'];
        $this->data_emissao      = $data['data_emissao'];
        $this->data_saida        = $data['data_saida'];
        $this->valor_total       = (float) $data['valor_total'];
        $this->valor_desconto    = (float) $data['valor_desconto'];
        $this->cliente_id        = $data['cliente_id'];
    }
    public function toArray(): array
    {
        return [
            'numero_nf'         => $this->numero_nf,
            'numero_serie'      => $this->numero_serie,
            'numero_folhas'     => $this->numero_folhas,
            'natureza_operacao' => $this->natureza_operacao,
            'data_emissao'      => $this->data_emissao,
            'data_saida'        => $this->data_saida,
            'valor_total'       => $this->valor_total,
            'valor_desconto'    => $this->valor_desconto,
            'cliente_id'        => $this->cliente_id
        ];
    }
}
