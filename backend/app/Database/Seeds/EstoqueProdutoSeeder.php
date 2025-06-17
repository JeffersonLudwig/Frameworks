<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstoqueProdutoSeeder extends Seeder
{
    public function run()
    {
        $dados = [
            [
                'estoque_id' => 1,
                'produto_id' => 1,
                'quantidade' => 100.00,
                'preco' => 25.50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'estoque_id' => 1,
                'produto_id' => 2,
                'quantidade' => 50.00,
                'preco' => 19.90,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'estoque_id' => 2,
                'produto_id' => 1,
                'quantidade' => 30.00,
                'preco' => 28.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ];

        $this->db->table('estoque_produtos')->insertBatch($dados);
    }
}
