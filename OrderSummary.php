<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Order;
use Carbon\Carbon;

class Ordersummary extends Component
{
    public string $date;

    public function mount()
    {
        $this->date = Carbon::today()->toDateString();
    }

    public function render()
{
    $orders = \App\Models\Order::with('items.menu')
        ->whereDate('order_date', $this->date)
        ->orderBy('order_date')
        ->get();

    $grandTotal = $orders->sum('total_amount');

    return view('livewire.reports.order-summary', [
        'orders' => $orders,
        'grandTotal' => $grandTotal,
    ])->layout('livewire.components.layouts.app');
}
}