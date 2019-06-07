<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const OUT_OF_STOCK = 0;

    protected $fillable = ['code', 'price', 'title', 'description', 'in_stock', 'barcode'];

    public function in_stock(){
        return $this->in_stock == Product::OUT_OF_STOCK;
    }
    public function categories(){
        return $this->belongsToMany('App\Category', 'product_categories')->using('App\ProductCategory');
    }
    public function images(){
        return $this->hasMany('App\ProductImage');
    }
    public function reviews(){
        return $this->hasMany('App\Review');
    }
}
