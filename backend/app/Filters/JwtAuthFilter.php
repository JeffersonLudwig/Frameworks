<?php

namespace App\Filters;

use App\Authentication\JwtService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JwtAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return service('response')
                ->setJSON(['erro' => 'Token não enviado'])
                ->setStatusCode(401);
        }

        $jwt = new JwtService(env('JWT_SECRET'));
        $dados = $jwt->validarToken($matches[1]);

        if (!$dados) {
            return service('response')
                ->setJSON(['erro' => 'Token inválido ou expirado'])
                ->setStatusCode(401);
        }

        $request->usuario = $dados;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
