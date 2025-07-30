<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category_id',
        'image',
        'barcode',
        'stock',
        'is_active',
    ];

    public function category(){

        return $this->belongsTo(Category::class);

    }

    public function orders(){

        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price')->withTimestamps();

    }

}