<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingCart extends Component
{
    /**
     * El contenido del carrito.
     * @var array
     */
    public $cartItems = [];

    /**
     * El total del carrito.
     * @var float
     */
    public $total = 0;

    /**
     * Controla la visibilidad de la factura/recibo.
     * @var bool
     */
    public $showInvoice = false;
    
    /**
     * Almacena los datos de la última venta para la factura.
     * @var array
     */
    public $lastSaleData = [];

    /**
     * Escuchadores de eventos. Se usa para añadir productos desde otros componentes.
     */
    protected $listeners = ['productAdded' => 'updateCart'];

    /**
     * Se ejecuta cuando el componente es inicializado.
     * Carga el carrito desde la sesión.
     */
    public function mount()
    {
        $this->updateCart();
    }

    /**
     * Actualiza el estado del carrito desde la sesión.
     */
    public function updateCart()
    {
        $this->cartItems = session()->get('cart', []);
        $this->calculateTotal();
    }
    
    /**
     * Incrementa la cantidad de un item en el carrito.
     */
    public function increaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        }
        session()->put('cart', $cart);
        $this->updateCart();
    }

    /**
     * Decrementa la cantidad de un item en el carrito.
     * Si la cantidad llega a 0, lo elimina.
     */
    public function decreaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                unset($cart[$productId]);
            }
        }
        session()->put('cart', $cart);
        $this->updateCart();
    }

    /**
     * Elimina un item del carrito por completo.
     */
    public function removeItem($productId)
    {
        session()->forget("cart.$productId");
        $this->updateCart();
    }

    /**
     * Vacía todo el carrito.
     */
    public function clearCart()
    {
        session()->forget('cart');
        $this->updateCart();
    }

    /**
     * Procesa la venta, la guarda en la base de datos y muestra la factura.
     */
    public function processSale()
    {
        if (empty($this->cartItems)) {
            return; // No hacer nada si el carrito está vacío
        }

        DB::transaction(function () {
            // 1. Crear la venta
            $venta = Venta::create([
                'id_cliente' => null, // Opcional: Asignar un cliente si aplica
                'total' => $this->total,
                'estado' => 'pagado',
                'id_usuario' => Auth::id(), // Asume que un usuario está logueado
            ]);

            // 2. Adjuntar productos a la venta y actualizar stock
            foreach ($this->cartItems as $productId => $item) {
                $venta->productos()->attach($productId, [
                    'cantidad' => $item['quantity'],
                    'precio_unitario' => $item['price']
                ]);

                // 3. Actualizar el stock del producto
                $producto = Producto::find($productId);
                if ($producto) {
                    $producto->stock -= $item['quantity'];
                    $producto->save();
                }
            }

            // Guardar datos para la factura
            $this->lastSaleData = [
                'id' => $venta->id,
                'fecha' => $venta->fecha,
                'items' => $this->cartItems,
                'total' => $this->total
            ];
        });
        
        $this->showInvoice = true;
        $this->clearCart();
    }

    /**
     * Cierra la vista de la factura y resetea el estado.
     */
    public function closeInvoice()
    {
        $this->showInvoice = false;
        $this->lastSaleData = [];
    }

    /**
     * Calcula el total del carrito.
     */
    private function calculateTotal()
    {
        $this->total = collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    /**
     * Renderiza la vista del componente.
     */
    public function render()
    {
        return view('livewire.shopping-cart');
    }
}