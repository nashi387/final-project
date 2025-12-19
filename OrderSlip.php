<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;

class Orderslip extends Component
{
    public Order $order;

    public function mount($id)
    {
        $this->order = Order::with(['items.menu'])->findOrFail($id);
    }

    public function render()
{
    return view('livewire.orders.order-slip')
        ->layout('livewire.components.layouts.app');
}
}