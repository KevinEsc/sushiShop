<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria',
        'imagen',
        'stock',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'activo' => 'boolean',
            'stock' => 'integer',
        ];
    }

    /**
     * Categorías disponibles.
     */
    public static function categorias(): array
    {
        return [
            'rolls'    => '🌀 Rolls',
            'nigiri'   => '🍣 Nigiri',
            'sashimi'  => '🐟 Sashimi',
            'combos'   => '🎁 Combos',
            'bebidas'  => '🍵 Bebidas',
        ];
    }

    /**
     * Scope para productos activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Obtener URL de imagen con fallback.
     */
    public function getImagenUrlAttribute(): string
    {
        if ($this->imagen && file_exists(public_path('storage/' . $this->imagen))) {
            return asset('storage/' . $this->imagen);
        }
        return asset('images/sushi-placeholder.jpg');
    }
}
