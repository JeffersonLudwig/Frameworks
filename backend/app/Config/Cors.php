<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Cross-Origin Resource Sharing (CORS) Configuration
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
 */
class Cors extends BaseConfig
{
    /**
     * The default CORS configuration.
     *
     * @var array{
     *      allowedOrigins: list<string>,
     *      allowedOriginsPatterns: list<string>,
     *      supportsCredentials: bool,
     *      allowedHeaders: list<string>,
     *      exposedHeaders: list<string>,
     *      allowedMethods: list<string>,
     *      maxAge: int,
     *  }
     */
    public array $default = [
        'allowedOrigins'       => ['http://localhost:3000'], // ajuste as URLs do seu front e backend
        'allowedOriginsPatterns' => [],
        'supportsCredentials'  => false,
        'allowedHeaders'       => ['Content-Type', 'Authorization', 'X-Requested-With'], // Headers que você usa
        'exposedHeaders'       => [],
        'allowedMethods'       => ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'], // Métodos HTTP permitidos
        'maxAge'               => 7200,
    ];
}
