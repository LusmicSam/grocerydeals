<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DealSubscription extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'deal_subscriptions';

    protected $fillable = [
        'email',
        'is_active',
        'categories',
    ];
}
