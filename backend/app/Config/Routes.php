<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->options('(:any)', function () {
    return response()->setStatusCode(200);
});
// Rotas públicas (sem filtro JWT)
$routes->group('api', function ($routes) {
    $routes->post('login', 'AuthController::login');
    $routes->post('cadastrar', 'AuthController::cadastrar');
});


// Rotas protegidas por JWT
$routes->group('api', ['filter' => 'jwt'], function ($routes) {
    // Rotas de Estoque
    $routes->get('estoques', 'EstoqueController::index');
    $routes->get('estoques/(:num)', 'EstoqueController::show/$1');
    $routes->post('estoques', 'EstoqueController::create');
    $routes->put('estoques/(:num)', 'EstoqueController::update/$1');
    $routes->patch('estoques/(:num)', 'EstoqueController::update/$1');
    $routes->delete('estoques/(:num)', 'EstoqueController::delete/$1');
    $routes->post('estoques/(:num)/produtos', 'EstoqueController::adicionarProduto/$1');
    $routes->put('estoques/(:num)/produtos/(:num)', 'EstoqueController::atualizarProduto/$1/$2');
    $routes->delete('estoques/(:num)/produtos/(:num)', 'EstoqueController::removerProduto/$1/$2');

    // Rotas dos produtos
    $routes->get('produtos', 'ProdutoController::index');
    $routes->get('produtos/(:num)', 'ProdutoController::show/$1');
    $routes->post('produtos/', 'ProdutoController::create');
    $routes->put('produtos/(:num)', 'ProdutoController::update/$1');
    $routes->patch('produtos/(:num)', 'ProdutoController::update/$1');
    $routes->delete('produtos/(:num)', 'ProdutoController::delete/$1');

    // Rotas das notas fiscais
    $routes->post('notafiscal/cadastrar', 'NotaFiscalController::cadastrarNotaFiscal');
    $routes->get('notafiscal/listar', 'NotaFiscalController::listarNotaFiscal');
    $routes->get('notafiscal/listar/(:num)', 'NotaFiscalController::listarNotaFiscalId/$1');
    $routes->delete('notafiscal/deletar/(:num)', 'NotaFiscalController::deletarNotaFiscal/$1');
    $routes->post('notafiscal/inserirproduto', 'NotaFiscalController::inserirProdutoNaNotaFiscal');

    // Rotas dos usuarios
    $routes->get('users', 'UserController::index');
    $routes->get('users/findall', 'UsuarioController::index');
});