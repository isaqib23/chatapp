<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'price', 'photo', 'user_id', 'description', 'category_id', 'type'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function members(){
        return $this->hasMany('App\GroupUser','group_id','id');
    }

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }
}
