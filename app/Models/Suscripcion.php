<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suscripcion extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'suscripciones';

    /**
     * Indica si el modelo debe tener timestamps.
     * La tabla 'suscripciones' no tiene las columnas created_at/updated_at.
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
        'id_plan',
        'fecha_inicio',
        'fecha_fin',
        'codigo',
        'renovaciones',
        'cambios_plan',
        'id_usuario',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación inversa "pertenece a" con el modelo Cliente.
     * Cada suscripción pertenece a un único cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Define la relación inversa "pertenece a" con el modelo Plan.
     * Cada suscripción está asociada a un único plan.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    /**
     * Define la relación inversa "pertenece a" con el modelo Usuario.
     * Cada suscripción fue registrada por un usuario (empleado/admin).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Define la relación "uno a muchos" con el modelo EntradaCliente.
     * Una suscripción puede tener muchos registros de entrada asociados.
     */
    public function entradasCliente(): HasMany
    {
        return $this->hasMany(Entrada_Cliente::class, 'id_suscripcion');
    }
}
