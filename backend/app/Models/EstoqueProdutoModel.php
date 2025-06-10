<?php

namespace App\Models;

use CodeIgniter\Model;

class EstoqueProdutoModel extends Model
{
    protected $table = 'estoque_produtos';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['estoque_id', 'produto_id', 'quantidade', 'preco'];

    protected $validationRules = [
        'estoque_id' => 'required|integer',
        'produto_id' => 'required|integer',
        'quantidade' => 'required|decimal',
        'preco'      => 'required|decimal',
    ];

    protected $validationMessages = [
        'estoque_id' => [
            'required' => 'O estoque_id é obrigatório.',
            'integer'  => 'O estoque_id deve ser um número inteiro.',
        ],
        'produto_id' => [
            'required' => 'O produto_id é obrigatório.',
            'integer'  => 'O produto_id deve ser um número inteiro.',
        ],
        'quantidade' => [
            'required' => 'A quantidade é obrigatória.',
            'decimal'  => 'A quantidade deve ser um número decimal.',
        ],
        'preco' => [
            'required' => 'O preço é obrigatório.',
            'decimal'  => 'O preço deve ser um número decimal.',
        ],
    ];
}
