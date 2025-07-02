<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * El nombre de la tabla asociada con el modelo.
     * Laravel infiere "usuarios" de "Usuario", pero especificarlo es más explícito.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Laravel por defecto busca las columnas `created_at` y `updated_at`.
     * Debemos indicar el nombre de nuestra columna de creación y deshabilitar la de actualización.
     */
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // La tabla no tiene una columna de actualización.

    /**
     * Los atributos que se pueden asignar masivamente.
     * Estos deben coincidir con los nombres de las columnas en tu tabla 'usuarios'.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
        'rol',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     * Es una buena práctica de seguridad ocultar la contraseña.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contraseña', // Usamos 'contraseña' en lugar de 'password'.
        // Tu tabla no tiene 'remember_token', así que lo omitimos.
        // Si necesitas la funcionalidad "Recordarme", deberás agregar la columna a tu tabla.
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // No tenemos 'email_verified_at' en la tabla.
            'contraseña' => 'hashed', // Le indica a Laravel que hashee automáticamente este campo.
            'creado_en' => 'datetime',
        ];
    }

    /**
     * Como el nombre de la columna para la contraseña no es 'password',
     * debemos indicarle a Laravel cuál es el nombre correcto.
     *
     * @return string
     */
    public function getAuthPasswordName()
    {
        return 'contraseña';
    }
    
    // --- RELACIONES DE ELOQUENT ---

    /**
     * Define la relación "uno a muchos" con el modelo Suscripcion.
     * Un usuario (empleado/admin) puede registrar muchas suscripciones.
     */
    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'id_usuario');
    }

    /**
     * Define la relación "uno a muchos" con el modelo Venta.
     * Un usuario (empleado/admin) puede realizar muchas ventas.
     */
    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'id_usuario');
    }

    /**
     * Define la relación "uno a muchos" con el modelo ReporteMensual.
     * Un usuario puede generar muchos reportes.
     */
    public function reportesMensuales(): HasMany
    {
        return $this->hasMany(Reporte_Mensual::class, 'generado_por');
    }
}
