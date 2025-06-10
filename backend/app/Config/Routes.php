<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', function ($routes) {
    $routes->post('login', 'AuthController::login');
    $routes->post('cadastrar', 'AuthController::cadastrar');

    $routes->group('', ['filter' => 'jwt'], function ($routes) {
        $routes->post('notafiscal/cadastrar', 'NotaFiscalController::cadastrarNotaFiscal');
        $routes->get('notafiscal/listar', 'NotaFiscalController::listarNotaFiscal');
        $routes->get('notafiscal/listar/(:num)', 'NotaFiscalController::listarNotaFiscalId/$1');
        $routes->get('users/findall', 'UsuarioController::index');
        $routes->get('estoques/findAll', 'EstoqueController::index');
        $routes->get('users', 'UserController::index');
    });
});

// $routes->group('api', function ($routes) {
//     $routes->get('produtos', 'ProdutoController::index');
//     $routes->get('produtos/(:num)', 'ProdutoController::show/$1');
//     $routes->post('produtos', 'ProdutoController::create');
//     $routes->put('produtos/(:num)', 'ProdutoController::update/$1');
//     $routes->patch('produtos/(:num)', 'ProdutoController::update/$1');
//     $routes->delete('produtos/(:num)', 'ProdutoController::delete/$1');
// });
$routes->group('api', ['filter' => 'jwt'], function ($routes) {
    // EstoqueProduto
    $routes->resource('estoqueprodutos', 'EstoqueProdutoController', ['except' => ['new', 'edit']]);
});
