<?php

namespace App\Middleware;

use App\Authentication\JwtService;

class JwtGuard
{
    public static function autenticar(string $secret): array
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (!preg_match('/Bearer\s(.+)/', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['erro' => 'Token não enviado']);
            exit;
        }

        $jwt = new JwtService($secret);
        $dados = $jwt->validarToken($matches[1]);

        if (!$dados) {
            http_response_code(401);
            echo json_encode(['erro' => 'Token inválido ou expirado']);
            exit;
        }

        return $dados;
    }
}
