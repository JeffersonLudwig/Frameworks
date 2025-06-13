<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaProdutoModel extends Model
{
    protected $table = 'nota_produto'; // tabela intermediária correta
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        'nota_fiscal_id',
        'produto_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'desconto',
        'icms',
        'ipi',
        'cfop',
        'unidade_medida',
        'observacao'
    ];

    protected $validationRules = [
        'nota_fiscal_id' => 'required|integer',
        'produto_id'     => 'required|integer',
        'quantidade'     => 'required|decimal',
        'valor_unitario' => 'required|decimal',
        'valor_total'    => 'permit_empty|decimal',
        'desconto'       => 'permit_empty|decimal',
        'icms'           => 'permit_empty|decimal',
        'ipi'            => 'permit_empty|decimal',
        'cfop'           => 'permit_empty|string|max_length[10]',
        'unidade_medida' => 'permit_empty|string|max_length[10]',
        'observacao'     => 'permit_empty|string|max_length[255]',
    ];
}
