<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'name',
        'price',
        'category',
    ];

    /**
     * Get all order items associated with this menu.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'menu_id');
    }
}