<?php

namespace App\Enums;

enum StockMovementType: string
{
    case ENTRADA = 'entrada';
    case SAIDA = 'saida';

    public function label(): string
    {
        return match ($this) {
            self::ENTRADA => 'Entrada',
            self::SAIDA => 'Saída',
        };
    }

    /** Classes Tailwind do badge (o Tailwind precisa escanear app/Enums). */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::ENTRADA => 'bg-green-100 text-green-800',
            self::SAIDA => 'bg-red-100 text-red-800',
        };
    }

    public function sign(): string
    {
        return match ($this) {
            self::ENTRADA => '+',
            self::SAIDA => '−',
        };
    }
}
