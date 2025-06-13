<?php

namespace App\Enums;

enum NotaFiscal
{
    case Pendente;
    case Cancelada;
    case Enviada;


    public static function fromString(string $valor): ?self
    {
        return match (strtolower($valor)) {
            'pendente'      => self::Pendente,
            'cancelada'     => self::Cancelada,
            'enviada'       => self::Enviada,
            default          => null,
        };
    }

    public function nome(): string
    {
        return match ($this) {
            self::Pendente      => 'Pendente',
            self::Cancelada     => 'Cancelada',
            self::Enviada       => 'Enviada',
        };
    }
}
