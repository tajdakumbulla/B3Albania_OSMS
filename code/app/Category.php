<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'description', 'category_type_id'];

    public $timestamps = false;

    public function products(){
        return $this->belongsToMany('App\Product', 'product_categories')->using('ProductCategory');
    }

    public function type(){
        return $this->hasOne('App\CategoryType');
    }
}
