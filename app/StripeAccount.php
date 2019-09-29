<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    protected $table = 'stripe_accounts';
    protected $fillable = [
        'user_id', 'stripe_publishable_key', 'stripe_user_id', 'refresh_token', 'access_token'
    ];
}
