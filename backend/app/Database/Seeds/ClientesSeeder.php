<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nome'               => 'Empresa Exemplo Ltda',
                'documento'          => '12345678000199',
                'inscricao_estadual' => '1234567890',
                'logradouro'         => 'Rua das Flores',
                'numero'             => '100',
                'bairro'             => 'Centro',
                'cidade'             => 'São Paulo',
                'estado'             => 'SP',
                'cep'                => '01000-000',
                'pais'               => 'Brasil',
                'email'              => 'contato@exemplo.com',
                'telefone'           => '(11) 99999-0000',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => null,
            ],
            [
                'nome'               => 'Cliente Teste ME',
                'documento'          => '98765432000100',
                'inscricao_estadual' => '0987654321',
                'logradouro'         => 'Av. Paulista',
                'numero'             => '2000',
                'bairro'             => 'Bela Vista',
                'cidade'             => 'São Paulo',
                'estado'             => 'SP',
                'cep'                => '01310-000',
                'pais'               => 'Brasil',
                'email'              => 'cliente@teste.com',
                'telefone'           => '(11) 98888-7777',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => null,
            ],
        ];

        // Insere os dados na tabela 'clientes'
        $this->db->table('clientes')->insertBatch($data);
    }
}
