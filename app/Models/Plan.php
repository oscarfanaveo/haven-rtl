<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'planes';

    /**
     * Indica si el modelo debe tener timestamps (created_at, updated_at).
     * La tabla 'planes' no las tiene.
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
        'tipo',
        'precio',
        'entradas',
        'horario',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'entradas' => 'integer',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación "uno a muchos" con el modelo Suscripcion.
     * Un plan puede estar asociado a muchas suscripciones de clientes.
     */
    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'id_plan');
    }
}
