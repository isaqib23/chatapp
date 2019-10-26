<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'group_id', 'user_id', 'status', 'message', 'type', 'receiver_id', 'text_type', 'room_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function receiver(){
        return $this->belongsTo('App\User','receiver_id');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }
}
