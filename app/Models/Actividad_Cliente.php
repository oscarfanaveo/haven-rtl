<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad_Cliente extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'actividad_clientes';

    /**
     * Indica si el modelo debe tener timestamps (created_at, updated_at).
     * La tabla 'actividad_clientes' no las tiene.
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
        'id_cliente',
        'entradas_usadas',
        'cambios_plan',
        'renovaciones',
        'ultimo_ingreso',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'entradas_usadas' => 'integer',
        'cambios_plan' => 'integer',
        'renovaciones' => 'integer',
        'ultimo_ingreso' => 'datetime',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación inversa "pertenece a" con el modelo Cliente.
     * Cada registro de actividad pertenece a un único cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
