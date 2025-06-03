<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    protected $useTimestamps = true;
    protected $allowedFields = ['nome_estoque', 'cnpj', 'rua', 'bairro', 'cidade', 'estado', 'pais', 'cep', 'telefone'];
}
