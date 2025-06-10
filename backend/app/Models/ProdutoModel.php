<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'estoque_id'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nome' => 'required|string|max_length[255]',
        'estoque_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O nome do produto é obrigatório.',
            'max_length' => 'O nome do produto deve ter no máximo 255 caracteres.',
        ],
        'estoque_id' => [
            'required' => 'O estoque_id é obrigatório.',
            'integer'  => 'O estoque_id deve ser um número inteiro.',
        ],
    ];

    public function produtoEmNotaFiscalSaida(int $produtoId): array
    {
        $db = \Config\Database::connect();
        $query = $db->table('notas_fiscais_produtos')
            ->select('notas_fiscais_produtos.nota_fiscal_id')
            ->join('notas_fiscais', 'notas_fiscais.id = notas_fiscais_produtos.nota_fiscal_id')
            ->where('notas_fiscais_produtos.produto_id', $produtoId)
            ->get();

        return $query->getResultArray();
    }
}
