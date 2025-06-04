<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'documento', 'inscricao_estadual', 'logradouro', 'numero', 'bairro', 'estado', 'cidade', 'cep', 'pais', 'email', 'telefone'];
}
