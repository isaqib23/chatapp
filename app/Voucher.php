<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'percentage', 'user_id', 'status', 'code', 'group_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function group(){
        return $this->belongsTo('App\Group', 'group_id');
    }
}
