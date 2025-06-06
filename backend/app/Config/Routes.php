<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', function ($routes) {
    $routes->post('login', 'AuthController::login');
    $routes->get('users', 'UserController::index');
    $routes->get('users/findall', 'UsuarioController::index');
    $routes->get('estoques/findAll', 'EstoqueController::index');
    $routes->post('notafiscal/cadastrar', 'NotaFiscalController::index');
    $routes->get('notafiscal/listar', 'NotaFiscalController::listarNotaFiscal');
    $routes->get('notafiscal/listar/(:num)', 'NotaFiscalController::listarNotaFiscalId/$1');
});
