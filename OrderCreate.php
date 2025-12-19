<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderCreate extends Component
{
    public $cart = [];
    public $total = 0;

    public function addItem($menuId)
    {
        $menu = Menu::findOrFail($menuId);

        if (!isset($this->cart[$menuId])) {
            $this->cart[$menuId] = [
                'name'   => $menu->name,
                'price'  => $menu->price,
                'qty'    => 1,
                'amount' => $menu->price,
            ];
        } else {
            $this->cart[$menuId]['qty']++;
            $this->cart[$menuId]['amount'] =
                $this->cart[$menuId]['qty'] * $this->cart[$menuId]['price'];
        }

        $this->updateTotal();
    }

    public function removeItem($menuId)
    {
        unset($this->cart[$menuId]);
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->total = collect($this->cart)->sum('amount');
    }

    public function saveOrder()
    {
        if (empty($this->cart)) {
            return;
        }

        $order = Order::create([
            'order_number' => now()->timestamp,
            'order_date'   => Carbon::today(),
            'total_amount'=> $this->total,
        ]);

        foreach ($this->cart as $menuId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id'  => $menuId,
                'quantity' => $item['qty'],
                'price'    => $item['price'],
                'amount'   => $item['amount'],
            ]);
        }

        $this->reset(['cart', 'total']);

        return redirect()->to("/orders/{$order->id}");
    }

    public function render()
{
    return view('livewire.orders.order-create', [
        'menus' => \App\Models\Menu::all()
    ])->layout('livewire.components.layouts.app');
}
}