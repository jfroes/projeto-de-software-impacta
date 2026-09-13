<?php

namespace App\Enums;
enum UserRole: string
{
    case ADMIN = 'admin';
    case GESTOR = 'gestor';
    case FUNCIONARIO = 'funcionario';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::GESTOR => 'Gestor',
            self::FUNCIONARIO => 'Funcionário',
        };
    }


    public function canManageUsers(): bool
    {
        return match ($this) {
            self::ADMIN => true,
            self::GESTOR => false,
            self::FUNCIONARIO => false,
        };
    }

}
