<?php

namespace App\Models;

use CodeIgniter\Model;
class EstoqueProdutoModel extends Model
{
    protected $table = 'estoque_produtos';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
}