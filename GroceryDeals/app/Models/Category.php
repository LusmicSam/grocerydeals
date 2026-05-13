<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'icon',          // e.g. "🍎" or a CSS class name
        'color',         // e.g. "#FF5733" for UI badges
        'product_count', // denormalized counter, updated on product changes
    ];

    protected $casts = [
        'product_count' => 'integer',
    ];

    // =========================================================================
    // RELATIONSHIP
    // =========================================================================

    /**
     * A category has many products.
     * MongoDB Eloquent hasMany uses a foreign key on products collection.
     */
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category', 'slug');
    }
}
