<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'productos';

    /**
     * Indica si el modelo debe tener timestamps.
     * La tabla 'productos' no tiene las columnas created_at/updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'categoria',
        'precio',
        'stock',
        'estado',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'estado' => 'boolean',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación "muchos a muchos" con el modelo Venta.
     * Un producto puede estar incluido en muchas ventas.
     */
    public function ventas(): BelongsToMany
    {
        // El método belongsToMany define la relación inversa
        // - Venta::class: El modelo relacionado.
        // - 'ventas_productos': El nombre de la tabla intermedia (pivote).
        // - 'id_producto': La clave foránea de este modelo en la tabla pivote.
        // - 'id_venta': La clave foránea del modelo relacionado en la tabla pivote.
        return $this->belongsToMany(Venta::class, 'ventas_productos', 'id_producto', 'id_venta')
                    // withPivot permite acceder a columnas adicionales de la tabla pivote.
                    ->withPivot('cantidad', 'precio_unitario');
    }
}
