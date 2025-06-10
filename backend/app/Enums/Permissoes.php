<?php

namespace App\Enums;

enum Permissoes
{
    case SuperAdmin;
    case Administrador;
    case Desenvolvedor;
    case Colaborador;
    case Cliente;

    public static function fromString(string $valor): ?self
    {
        return match (strtolower($valor)) {
            'superadmin'     => self::SuperAdmin,
            'admin'          => self::Administrador,
            'dev'            => self::Desenvolvedor,
            'colaborador'    => self::Colaborador,
            'cliente'        => self::Cliente,
            default          => null,
        };
    }

    public function nome(): string
    {
        return match ($this) {
            self::SuperAdmin   => 'Super Admin',
            self::Administrador => 'Administrador',
            self::Desenvolvedor => 'Desenvolvedor',
            self::Colaborador   => 'Colaborador',
            self::Cliente       => 'Cliente',
        };
    }
}
