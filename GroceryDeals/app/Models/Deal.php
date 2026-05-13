<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Carbon\Carbon;

class Deal extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'deals';

    protected $fillable = [
        'title',
        'description',
        'product_ids',     // array of MongoDB ObjectId strings — e.g. ["6643...", "6644..."]
        'discount_percent',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'product_ids'      => 'array',
        'discount_percent' => 'float',
        'is_active'        => 'boolean',
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
    ];

    // =========================================================================
    // SCOPE — active deals only (not expired)
    // =========================================================================

    /**
     * Scope: active deals that haven't expired yet.
     *
     * Checks:
     *   1. is_active == true
     *   2. expires_at > now()
     *
     * Usage: Deal::active()->get()
     */
    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true)
            ->where('expires_at', '>', Carbon::now());
    }

    // =========================================================================
    // HELPER — load associated products from product_ids array
    // =========================================================================

    /**
     * Retrieve the products belonging to this deal.
     * MongoDB Eloquent does not natively support array-based cross-collection
     * joins, so we use whereIn on the product _id.
     *
     * Usage: $deal->getProducts()
     */
    public function getProducts()
    {
        return Product::whereIn('_id', $this->product_ids ?? [])->get();
    }
}
