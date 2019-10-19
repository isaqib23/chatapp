<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table = 'group_users';

    protected $fillable = [
        'group_id', 'user_id', 'status', 'can_send_text'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }
}
