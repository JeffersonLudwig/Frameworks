<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Authentication\JwtService;
use App\Models\UsuarioModel;

class AuthController extends ResourceController
{
    public function cadastrar()
    {

        try {
            $input = $this->request->getJSON(true);
            $nome = $input['nome'] ?? null;
            $email = $input['email'] ?? null;
            $senha = $input['senha'] ?? null;
            $permissao = $input['permissao'] ?? null;
            $estoque_id = $input['estoque_id'] ?? null;

            if (!$nome || !$email || !$senha) {
                return $this->failValidationErrors('Nome, email e senha são obrigatórios');
            }

            $usuarioModel = new UsuarioModel();
            $usuarioModel->cadastrarUsuario([
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha,
                'permissao' => $permissao,
                'estoque_id' => $estoque_id
            ]);

            return $this->respond([
                'message' => 'Usuário cadastrado com sucesso',
            ]);
        } catch (\Exception $e) {
            return $this->failValidationErrors($e->getMessage());
        }
    }
    public function login()
    {
        $input = $this->request->getJSON(true);

        $email = $input['email'] ?? null;
        $senha = $input['senha'] ?? null;

        if (!$email || !$senha) {
            return $this->failValidationErrors('Email e senha são obrigatórios');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $email)->first();

        if (!$usuario) {
            return $this->failUnauthorized('Usuário não encontrado');
        }

        if (!password_verify($senha, $usuario['senha'])) {
            return $this->failUnauthorized('Senha incorreta');
        }

        $jwtService = new JwtService(env('JWT_SECRET'));

        $claims = [
            'uid'   => $usuario['id'],
            'nome'  => $usuario['nome'],
        ];

        $token = $jwtService->gerarToken($claims);

        return $this->respond([
            'token' => $token,
        ]);
    }
}
