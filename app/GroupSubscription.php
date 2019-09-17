<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupSubscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'group_id',
        'user_id',
        'status',
        'amount',
        'customer_id',
        'plan_id',
        'subscription_id',
        'transaction_id',
        'card_number',
        'card_expiry',
        'card_digits',
        'product_id',
        'next_charge_date',
        '',
        '',
        '',
        '',
        '',
        '',
    ];
}
