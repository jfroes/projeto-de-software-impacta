<?php

namespace App\Enums;
enum UserStatus: string
{
    case ATIVO = 'ativo';
    case INATIVO = 'inativo';

    public function label(): string
    {
        return match ($this) {
            self::ATIVO => 'Ativo',
            self::INATIVO => 'Inativo',
        };
    }


    public function color(): string
    {
        return match ($this) {
            self::ATIVO => 'green',
            self::INATIVO => 'grey',
        };
    }

}
