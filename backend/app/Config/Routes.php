<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', function ($routes) {
    $routes->post('login', 'AuthController::login');
    $routes->get('users', 'UserController::index');
    $routes->get('users/findAll', 'UsuarioController::index');
});
