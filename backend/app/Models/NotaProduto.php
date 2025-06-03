<?php

namespace App\Models;

use CodeIgniter\Model;

class EstoqueModel extends Model
{
    protected $table = 'notas_fiscais';
    protected $useTimestamps = true;
    protected $allowedFields = ['nota_fiscal_id', 'produto_id', 'quantidade', 'valor_unitario'];
}
