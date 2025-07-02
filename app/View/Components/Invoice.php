<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Venta; // Asegúrate de tener este modelo
use App\Models\Suscripcion; // Asegúrate de tener este modelo
use Carbon\Carbon;

class Invoice extends Component
{
    public bool $isSubscription;
    public string $invoiceNumber;
    public string $customerName;
    public Carbon $now;
    public float $total;
    
    /**
     * Crea una nueva instancia del componente.
     *
     * @param Venta|null $venta El modelo de Venta (para ventas de productos).
     * @param Suscripcion|null $suscripcion El modelo de Suscripcion.
     */
    public function __construct(
        public ?Venta $venta = null, 
        public ?Suscripcion $suscripcion = null
    ) {
        $this->now = Carbon::now();
        $this->isSubscription = isset($this->suscripcion);

        // Genera un número de factura dinámico, similar a la lógica de React
        $this->invoiceNumber = $this->now->format('Ymd') . '-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        
        if ($this->isSubscription) {
            // Lógica para una suscripción
            $this->customerName = $this->suscripcion->cliente->nombre . ' ' . $this->suscripcion->cliente->apellido;
            $this->total = $this->suscripcion->plan->precio;
        } else {
            // Lógica para una venta de productos
            $this->customerName = $this->venta->cliente ? $this->venta->cliente->nombre . ' ' . $this->venta->cliente->apellido : 'Cliente';
            $this->total = $this->venta->total;
        }
    }

    /**
     * Obtiene la vista / contenidos que representan el componente.
     */
    public function render(): View|Closure|string
    {
        return view('components.invoice');
    }
}