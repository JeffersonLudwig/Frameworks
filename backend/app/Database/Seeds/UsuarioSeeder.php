<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nome'       => 'Admin User',
                'email'      => 'admin@example.com',
                'senha'      => password_hash('admin123', PASSWORD_DEFAULT),
                'permissao'  => 'admin',
                'estoque_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'nome'       => 'User Comum',
                'email'      => 'user@example.com',
                'senha'      => password_hash('user123', PASSWORD_DEFAULT),
                'permissao'  => 'usuario',
                'estoque_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ];
        // Insere os dados na tabela 'usuarios'
        $this->db->table('usuarios')->insertBatch($data);
    }
}
