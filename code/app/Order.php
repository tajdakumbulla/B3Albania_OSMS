<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use test\Mockery\ReturnTypeObjectTypeHint;

class Order extends Model
{
    const RECEIVED = 1;
    const IN_PROCESS = 2;
    const IN_TRANSIT = 3;
    const COMPLETED = 4;
    const REJECTED = 5;
    const DELETED = 6;

    protected $fillable = ['user_id', 'status_code', 'note'];

    public function received(){
        return $this->status_code == Order::RECEIVED;
    }
    public function in_process(){
        return $this->status_code == Order::IN_PROCESS;
    }
    public function in_transit(){
        return $this->status_code == Order::IN_TRANSIT;
    }
    public function completed(){
        return $this->status_code == Order::COMPLETED;
    }
    public function rejected(){
        return $this->status_code == Order::REJECTED;
    }
    public function order_deleted(){
        return $this->status_code == Order::DELETED;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function order_products(){
        return $this->hasMany('App\OrderProduct');
    }
}
