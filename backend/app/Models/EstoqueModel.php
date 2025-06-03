<?php

namespace App\Models;

use CodeIgniter\Model;

class EstoqueModel extends Model
{
    protected $table = 'estoques';
    protected $useTimestamps = true;
    protected $allowedFields = ['nome_estoque', 'cnpj', 'rua', 'bairro', 'cidade', 'estado', 'pais', 'cep', 'telefone'];
}
