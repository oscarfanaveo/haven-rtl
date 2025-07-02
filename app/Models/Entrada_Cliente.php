<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrada_Cliente extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'entradas_cliente';

    /**
     * Indica si el modelo debe tener timestamps (created_at, updated_at).
     * La tabla 'entradas_cliente' no las tiene.
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
        'fecha_entrada',
        'horario',
        'id_suscripcion',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_entrada' => 'datetime',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación inversa "pertenece a" con el modelo Cliente.
     * Cada registro de entrada pertenece a un único cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Define la relación inversa "pertenece a" con el modelo Suscripcion.
     * Cada registro de entrada está asociado a una suscripción específica.
     */
    public function suscripcion(): BelongsTo
    {
        return $this->belongsTo(Suscripcion::class, 'id_suscripcion');
    }
}
