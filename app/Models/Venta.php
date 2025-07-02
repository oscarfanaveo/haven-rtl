<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Venta extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'ventas';

    /**
     * Laravel busca por defecto 'created_at'. Le indicamos que use 'fecha' en su lugar.
     * No hay columna de actualización, así que la deshabilitamos.
     */
    const CREATED_AT = 'fecha';
    const UPDATED_AT = null;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_cliente',
        'total',
        'estado',
        'id_usuario',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'datetime',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación inversa "pertenece a" con el modelo Cliente.
     * Una venta puede ser asociada a un cliente (o puede ser anónima, si id_cliente es null).
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Define la relación inversa "pertenece a" con el modelo Usuario.
     * Cada venta es registrada por un usuario (empleado/admin).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Define la relación "muchos a muchos" con el modelo Producto.
     * Una venta puede incluir muchos productos.
     */
    public function productos(): BelongsToMany
    {
        // El método belongsToMany define la relación
        // - Producto::class: El modelo relacionado.
        // - 'ventas_productos': El nombre de la tabla intermedia (pivote).
        // - 'id_venta': La clave foránea de este modelo en la tabla pivote.
        // - 'id_producto': La clave foránea del modelo relacionado en la tabla pivote.
        return $this->belongsToMany(Producto::class, 'ventas_productos', 'id_venta', 'id_producto')
                    // withPivot permite acceder a columnas adicionales de la tabla pivote.
                    ->withPivot('cantidad', 'precio_unitario');
    }
}
