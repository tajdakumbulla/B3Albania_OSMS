<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'description', 'rating', 'image'];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
