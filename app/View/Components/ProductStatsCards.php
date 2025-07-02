<?php

namespace App\View\Components;

use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductStatsCards extends Component
{
    public int $totalProducts;
    public int $lowStockItems;
    public int $outOfStockItems;

    /**
     * Crea una nueva instancia del componente.
     * Aquí se obtienen los datos directamente desde la base de datos.
     */
    public function __construct()
    {
        // Contamos el total de productos registrados.
        $this->totalProducts = Producto::count();

        // Contamos los productos cuyo stock es exactamente 0.
        $this->outOfStockItems = Producto::where('stock', 0)->count();

        // Contamos productos con poco stock.
        // Se define "poco stock" como > 0 y <= 10. Puedes ajustar este umbral.
        $this->lowStockItems = Producto::where('stock', '>', 0)
                                       ->where('stock', '<=', 10)
                                       ->count();
    }

    /**
     * Obtiene la vista que representa el componente.
     */
    public function render(): View
    {
        return view('components.product-stats-cards');
    }
}