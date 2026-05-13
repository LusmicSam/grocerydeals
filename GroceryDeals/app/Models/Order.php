<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'user_id',      // Link to User _id
        'items',        // Embedded array: [{product_id, name, price, qty, image}]
        'total',
        'status',       // e.g. "pending", "completed", "cancelled"
        'address',      // e.g. "123 Street, City"
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'float',
    ];

    /**
     * An order belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
