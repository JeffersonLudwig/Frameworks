<?php


namespace App\Models;

use CodeIgniter\Model;
use App\Enums\Permissoes;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'email', 'senha', 'permissao', 'estoque_id'];

    public function cadastrarUsuario(array $data)
    {
        try {
            if (isset($data['senha'])) {
                $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            }

            if (isset($data['permissao'])) {
                $enumPermissao = Permissoes::fromString($data['permissao']);
                if (!$enumPermissao) {
                    throw new \InvalidArgumentException("Permissão inválida: {$data['permissao']}");
                }
                $data['permissao'] = $enumPermissao->nome();
            }

            return $this->insert($data);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao cadastrar usuário: ' . $e->getMessage());
        }
    }
}
