<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'email',
        'phone',
        'address',
    ];

    /** Grava sempre só os dígitos do CPF/CNPJ. */
    protected function document(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => $value === null ? null : preg_replace('/\D/', '', $value),
        );
    }

    /** CPF/CNPJ formatado para exibir nas views e no PDF. */
    protected function documentFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                $doc = $this->document;

                return match (strlen((string)$doc)) {
                    11 => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $doc),
                    14 => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $doc),
                    default => $doc,
                };
            },
        );
    }

    /** Filtro de busca por nome, documento ou e-mail (tabela Livewire). */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $digits = preg_replace('/\D/', '', $term);

        return $query->where(function (Builder $q) use ($term, $digits) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");

            if ($digits !== '') {
                $q->orWhere('document', 'like', "%{$digits}%");
            }
        });
    }
}
