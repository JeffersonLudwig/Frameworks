<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        $produtos = [
            [
                'nome' => 'Produto A',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'nome' => 'Produto B',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'nome' => 'Produto C',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ];

        $this->db->table('produtos')->insertBatch($produtos);
    }
}
