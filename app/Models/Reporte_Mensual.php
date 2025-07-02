<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reporte_Mensual extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'reportes_mensuales';

    /**
     * Laravel busca 'created_at'. Le indicamos que use 'fecha_generado'.
     * No hay columna de actualización, así que la deshabilitamos.
     */
    const CREATED_AT = 'fecha_generado';
    const UPDATED_AT = null;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo',
        'periodo',
        'datos',
        'generado_por',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * La conversión de 'datos' a 'array' es especialmente útil.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'periodo' => 'date',
        'datos' => 'array', // Convierte el JSON de la BD a un array de PHP y viceversa.
        'fecha_generado' => 'datetime',
    ];

    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación inversa "pertenece a" con el modelo Usuario.
     * Cada reporte fue generado por un único usuario.
     */
    public function generadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'generado_por');
    }
}
