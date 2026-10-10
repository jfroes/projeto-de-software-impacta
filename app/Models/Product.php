<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'stock_quantity',
        'active',
    ];

        protected function casts(): array
        {
            return [
                'price' => 'decimal:2',
                'stock_quantity' => 'integer',
                'active' => 'boolean',
            ];
        }

        public function scopeActive(Builder $query) : Builder
        {
            return $query->where('active', true);
        }

        public function scopeSearch(Builder $query, string $term) : Builder
        {
            if (blank($term)) {
                return $query;
            }

            return $query->where(function (Builder $q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%");
            });
        }

        public function isLowStock(int $threshold = 5): bool
        {
            return $this->stock_quantity <= $threshold;
        }
}
