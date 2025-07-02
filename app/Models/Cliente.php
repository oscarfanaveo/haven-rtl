<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * Laravel busca 'created_at'. Le indicamos que use 'fecha_registro'.
     * No hay columna de actualización, así que la deshabilitamos.
     */
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'codigo',
        'activo',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
        'fecha_registro' => 'datetime',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación "uno a muchos" con el modelo Suscripcion.
     * Un cliente puede tener muchas suscripciones a lo largo del tiempo.
     */
    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'id_cliente');
    }

    /**
     * Define la relación "uno a muchos" con el modelo Venta.
     * Un cliente puede tener muchas ventas asociadas.
     */
    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'id_cliente');
    }

    /**
     * Define la relación "uno a muchos" con el modelo EntradaCliente.
     * Un cliente puede tener muchos registros de entradas.
     */
    public function entradasCliente(): HasMany
    {
        return $this->hasMany(Entrada_Cliente::class, 'id_cliente');
    }

    /**
     * Define la relación "uno a uno" con el modelo ActividadCliente.
     * Cada cliente tiene un único registro de actividad acumulada.
     */
    public function actividad(): HasOne
    {
        return $this->hasOne(Actividad_Cliente::class, 'id_cliente');
    }
    
    // --- ACCESORS ---
    
    /**
     * Concatena el nombre y el apellido del cliente.
     * Puedes acceder a este valor como un atributo: $cliente->nombre_completo
     *
     * @return string
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
