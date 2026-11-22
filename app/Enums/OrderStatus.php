<?php

namespace App\Enums;

enum OrderStatus: string
{
    case ABERTO = 'aberto';
    case FATURADO = 'faturado';
    case SAIU_ENTREGA = 'saiu_entrega';
    case ENTREGUE = 'entregue';
    case CANCELADO = 'cancelado';

    public function label(): string
    {
        return match ($this) {
            self::ABERTO => 'Aberto',
            self::FATURADO => 'Faturado',
            self::SAIU_ENTREGA => 'Saiu para entrega',
            self::ENTREGUE => 'Entregue',
            self::CANCELADO => 'Cancelado',
        };
    }

    /** Classes Tailwind do badge (o Tailwind precisa escanear app/Enums). */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::ABERTO => 'bg-blue-100 text-blue-800',
            self::FATURADO => 'bg-indigo-100 text-indigo-800',
            self::SAIU_ENTREGA => 'bg-amber-100 text-amber-800',
            self::ENTREGUE => 'bg-green-100 text-green-800',
            self::CANCELADO => 'bg-red-100 text-red-800',
        };
    }

    /** Próximo status do fluxo normal; null quando não há mais para onde avançar. */
    public function next(): ?self
    {
        return match ($this) {
            self::ABERTO => self::FATURADO,
            self::FATURADO => self::SAIU_ENTREGA,
            self::SAIU_ENTREGA => self::ENTREGUE,
            default => null,
        };
    }

    /** Texto do botão que leva ao próximo status. */
    public function advanceLabel(): ?string
    {
        return match ($this) {
            self::ABERTO => 'Faturar pedido',
            self::FATURADO => 'Marcar saída para entrega',
            self::SAIU_ENTREGA => 'Confirmar entrega',
            default => null,
        };
    }

    public function canCancel(): bool
    {
        return in_array($this, [self::ABERTO, self::FATURADO], true);
    }

    public function canGeneratePdf(): bool
    {
        return in_array($this, [self::FATURADO, self::SAIU_ENTREGA, self::ENTREGUE], true);
    }
}
