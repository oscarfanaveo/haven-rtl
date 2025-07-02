<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'entrenamientos';

    /**
     * Indica si el modelo debe tener timestamps (created_at, updated_at).
     * La tabla 'entrenamientos' no las tiene.
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
        'equipamiento',
        'musculo',
        'descripcion',
        'imagen',
        'enlace',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * No hay conversiones especiales necesarias para esta tabla por ahora.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];
}
