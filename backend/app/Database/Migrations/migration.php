<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsuariosDate extends Migration
{
    public function up()
    {
        // Estoques
        $this->forge->addField([
            'id' => ['type' => 'INT'], // não auto_incrementa aqui
            'nome_estoque' => ['type' => 'VARCHAR', 'UNIQUE' => true, 'constraint' => 255],
            'cnpj' => ['type' => 'VARCHAR', 'UNIQUE' => true, 'constraint' => 18],
            'rua' => ['type' => 'VARCHAR', 'constraint' => 255],
            'bairro' => ['type' => 'VARCHAR', 'constraint' => 255],
            'cidade' => ['type' => 'VARCHAR', 'constraint' => 255],
            'estado' => ['type' => 'VARCHAR', 'constraint' => 255],
            'pais' => ['type' => 'VARCHAR', 'constraint' => 255],
            'cep' => ['type' => 'VARCHAR', 'constraint' => 9],
            'telefone' => ['type' => 'VARCHAR', 'constraint' => 15],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('estoques');

        // Cria sequence e associa ao id para auto-increment
        $this->db->query('CREATE SEQUENCE estoques_id_seq START 1;');
        $this->db->query('ALTER TABLE estoques ALTER COLUMN id SET DEFAULT nextval(\'estoques_id_seq\');');
        $this->db->query('ALTER SEQUENCE estoques_id_seq OWNED BY estoques.id;');

        // Repita esse padrão para as demais tabelas

        // Usuarios
        $this->forge->addField([
            'id' => ['type' => 'INT'],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 255],
            'email' => ['type' => 'VARCHAR', 'UNIQUE' => true, 'constraint' => 255],
            'senha' => ['type' => 'VARCHAR', 'constraint' => 255],
            'permissao' => ['type' => 'VARCHAR', 'constraint' => 255],
            'estoque_id' => ['type' => 'INT'],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('estoque_id', 'estoques', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('usuarios');
        $this->db->query('CREATE SEQUENCE usuarios_id_seq START 1;');
        $this->db->query('ALTER TABLE usuarios ALTER COLUMN id SET DEFAULT nextval(\'usuarios_id_seq\');');
        $this->db->query('ALTER SEQUENCE usuarios_id_seq OWNED BY usuarios.id;');

        // Produtos
        $this->forge->addField([
            'id' => ['type' => 'INT'],
            'nome' => ['type' => 'VARCHAR', 'UNIQUE' => true, 'constraint' => 255],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('produtos');
        $this->db->query('CREATE SEQUENCE produtos_id_seq START 1;');
        $this->db->query('ALTER TABLE produtos ALTER COLUMN id SET DEFAULT nextval(\'produtos_id_seq\');');
        $this->db->query('ALTER SEQUENCE produtos_id_seq OWNED BY produtos.id;');

        // Estoque_Produtos
        $this->forge->addField([
            'id' => ['type' => 'INT'],
            'estoque_id' => ['type' => 'INT'],
            'produto_id' => ['type' => 'INT'],
            'quantidade' => ['type' => 'DECIMAL', 'constraint' => [10, 2]],
            'preco' => ['type' => 'DECIMAL', 'constraint' => [10, 2]],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('estoque_id', 'estoques', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('estoque_produtos');
        $this->db->query('CREATE SEQUENCE estoque_produtos_id_seq START 1;');
        $this->db->query('ALTER TABLE estoque_produtos ALTER COLUMN id SET DEFAULT nextval(\'estoque_produtos_id_seq\');');
        $this->db->query('ALTER SEQUENCE estoque_produtos_id_seq OWNED BY estoque_produtos.id;');

        // Clientes
        $this->forge->addField([
            'id' => ['type' => 'INT'],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 255],
            'documento' => ['type' => 'VARCHAR', 'UNIQUE' => true, 'constraint' => 255],
            'inscricao_estadual' => ['type' => 'VARCHAR', 'constraint' => 255],
            'logradouro' => ['type' => 'VARCHAR', 'constraint' => 255],
            'numero' => ['type' => 'VARCHAR', 'constraint' => 255],
            'bairro' => ['type' => 'VARCHAR', 'constraint' => 255],
            'cidade' => ['type' => 'VARCHAR', 'constraint' => 255],
            'estado' => ['type' => 'VARCHAR', 'constraint' => 255],
            'cep' => ['type' => 'VARCHAR', 'constraint' => 255],
            'pais' => ['type' => 'VARCHAR', 'constraint' => 255],
            'email' => ['type' => 'VARCHAR', 'constraint' => 255],
            'telefone' => ['type' => 'VARCHAR', 'constraint' => 15],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('clientes');
        $this->db->query('CREATE SEQUENCE clientes_id_seq START 1;');
        $this->db->query('ALTER TABLE clientes ALTER COLUMN id SET DEFAULT nextval(\'clientes_id_seq\');');
        $this->db->query('ALTER SEQUENCE clientes_id_seq OWNED BY clientes.id;');

        // Notas Fiscais
        $this->forge->addField([
            'id' => ['type' => 'INT'],
            'numero_nf' => ['type' => 'VARCHAR', 'constraint' => 255],
            'numero_serie' => ['type' => 'VARCHAR', 'constraint' => 255],
            'numero_folhas' => ['type' => 'VARCHAR', 'constraint' => 255],
            'natureza_operacao' => ['type' => 'VARCHAR', 'constraint' => 255],
            'data_emissao' => ['type' => 'TIMESTAMP'],
            'data_saida' => ['type' => 'TIMESTAMP'],
            'valor_total' => ['type' => 'DECIMAL', 'constraint' => [10, 2]],
            'valor_desconto' => ['type' => 'DECIMAL', 'constraint' => [10, 2]],
            'cliente_id' => ['type' => 'INT'],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notas_fiscais');
        $this->db->query('CREATE SEQUENCE notas_fiscais_id_seq START 1;');
        $this->db->query('ALTER TABLE notas_fiscais ALTER COLUMN id SET DEFAULT nextval(\'notas_fiscais_id_seq\');');
        $this->db->query('ALTER SEQUENCE notas_fiscais_id_seq OWNED BY notas_fiscais.id;');

        // Notas Fiscais Produtos
        $this->forge->addField([
            'id' => ['type' => 'INT'],
            'nota_fiscal_id' => ['type' => 'INT'],
            'produto_id' => ['type' => 'INT'],
            'quantidade' => ['type' => 'DECIMAL', 'constraint' => [10, 2]],
            'valor_unitario' => ['type' => 'DECIMAL', 'constraint' => [10, 2]],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('nota_fiscal_id', 'notas_fiscais', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notas_fiscais_produtos');
        $this->db->query('CREATE SEQUENCE notas_fiscais_produtos_id_seq START 1;');
        $this->db->query('ALTER TABLE notas_fiscais_produtos ALTER COLUMN id SET DEFAULT nextval(\'notas_fiscais_produtos_id_seq\');');
        $this->db->query('ALTER SEQUENCE notas_fiscais_produtos_id_seq OWNED BY notas_fiscais_produtos.id;');
    }

    public function down()
    {
        $this->forge->dropTable('notas_fiscais_produtos', true);
        $this->forge->dropTable('notas_fiscais', true);
        $this->forge->dropTable('clientes', true);
        $this->forge->dropTable('estoque_produtos', true);
        $this->forge->dropTable('produtos', true);
        $this->forge->dropTable('usuarios', true);
        $this->forge->dropTable('estoques', true);
    }
}
