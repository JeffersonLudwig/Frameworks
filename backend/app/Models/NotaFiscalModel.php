<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaFiscalModel extends Model
{
    protected $table = 'notas_fiscais';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'numero_nf',
        'numero_serie',
        'numero_folhas',
        'natureza_operacao',
        'data_emissao',
        'data_saida',
        'valor_total',
        'valor_desconto',
        'created_at',
        'updated_at',
        'cliente_id'
    ];

    public function cadastrarNotaFiscal(array $dados, $userId)
    {
        unset($dados['created_at']);
        $dados['cliente_id'] = $userId;
        return $this->insert($dados);
    }
}
