<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstoquesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nome_estoque' => 'Estoque Central',
                'cnpj' => '12.345.678/0001-90',
                'rua' => 'Av. Brasil',
                'bairro' => 'Centro',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'pais' => 'Brasil',
                'cep' => '01000-000',
                'telefone' => '(11) 99999-9999',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nome_estoque' => 'Filial RJ',
                'cnpj' => '98.765.432/0001-10',
                'rua' => 'Rua das Flores',
                'bairro' => 'Copacabana',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'pais' => 'Brasil',
                'cep' => '22000-000',
                'telefone' => '(21) 98888-8888',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nome_estoque' => 'Filial RJS',
                'cnpj' => '98.765.432/0001-11',
                'rua' => 'Rua das Floree',
                'bairro' => 'Copacabanaa',
                'cidade' => 'Rio de Janeiroa',
                'estado' => 'RJS',
                'pais' => 'Brasila',
                'cep' => '22000-000',
                'telefone' => '(21) 98888-8888',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('estoques')->insertBatch($data);
    }
}
