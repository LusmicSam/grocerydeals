<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    /**
     * Fields that can be mass-assigned.
     * MongoDB uses _id (ObjectId) automatically — no need to list it here.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'discount_percent',
        'discount_percentage',
        'category',
        'category_id',
        'stock',
        'unit',
        'image',
        'image_url',
        'is_featured',
        'is_active',
        'rating',
        'reviews_count',
        'tags',
        'images',
    ];

    /**
     * Cast types for automatic conversion.
     * MongoDB returns numeric strings sometimes; casts keep types predictable.
     */
    protected $casts = [
        'price'            => 'float',
        'original_price'   => 'float',
        'discount_percent' => 'float',
        'stock'            => 'integer',
        'is_featured'      => 'boolean',
        'is_active'        => 'boolean',
        'tags'             => 'array',
        'images'           => 'array',
    ];

    // =========================================================================
    // ACCESSOR  — auto-calculate discount_percent on the fly
    // =========================================================================

    /**
     * Accessor: getDiscountPercentAttribute()
     *
     * If discount_percent is not stored, calculate it from price vs original_price.
     * Accessible as $product->discount_percent
     */
    public function getDiscountPercentAttribute($value): float
    {
        // If explicitly stored, use it
        if ($value) {
            return (float) $value;
        }

        // Auto-calculate from prices
        if (
            isset($this->attributes['original_price']) &&
            $this->attributes['original_price'] > 0 &&
            isset($this->attributes['price'])
        ) {
            return round(
                (($this->attributes['original_price'] - $this->attributes['price'])
                    / $this->attributes['original_price']) * 100,
                2
            );
        }

        return 0.0;
    }

    // =========================================================================
    // SCOPES — reusable query constraints
    // =========================================================================

    /**
     * Scope: only featured products.
     * Usage: Product::featured()->get()
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: only active (visible) products.
     * Usage: Product::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: filter by category slug.
     * Usage: Product::byCategory('fruits')->get()
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // =========================================================================
    // RELATIONSHIP — belongs to a Category document
    // =========================================================================

    /**
     * A product belongs to one Category (linked via category slug field).
     * MongoDB Eloquent uses belongsTo with a local key.
     */
    /**
     * Renamed to categoryInfo() to avoid conflict with the 'category' string attribute.
     * Use $product->categoryInfo to get the related Category model.
     */
    public function categoryInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'slug');
    }
}
